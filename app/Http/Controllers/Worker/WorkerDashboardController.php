<?php
namespace App\Http\Controllers\Worker;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\WorkerTask;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
class WorkerDashboardController extends Controller {
 public function index(): View {
  $user=auth()->user();
  $tasks=Task::available()->latest()->take(12)->get();
  $todayTasks=WorkerTask::with(['task','submission'])->where('user_id',$user->id)->whereDate('started_at',today())->latest()->get();
  $completedToday=$todayTasks->whereIn('status',['completed','approved'])->count();
  $submittedToday=$todayTasks->whereIn('status',['submitted','completed','approved'])->count();
  $todayEarnings=$todayTasks->filter(fn($item)=>in_array($item->submission?->status,['approved'],true))->sum(fn($item)=>(float)$item->task->reward);
  $totalApproved=WorkerTask::with('submission')->where('user_id',$user->id)->get()->filter(fn($item)=>$item->submission?->status==='approved')->count();
  $trustLevel=$totalApproved>=30?'Trusted':($totalApproved>=10?'Verified':'New');
  return view('worker.dashboard',[
   'tasks'=>$tasks,'availableCount'=>$tasks->count(),'todayTasks'=>$todayTasks,'completedToday'=>$completedToday,
   'submittedToday'=>$submittedToday,'todayEarnings'=>$todayEarnings,'trustLevel'=>$trustLevel,
  ]);
 }
 public function history(): View {
  $workerTasks=WorkerTask::with(['task','submission'])->where('user_id',auth()->id())->latest('started_at')->paginate(20);
  return view('worker.history',compact('workerTasks'));
 }
 public function wallet(): View {
  $approved=WorkerTask::with(['task','submission'])->where('user_id',auth()->id())->get()->filter(fn($item)=>$item->submission?->status==='approved');
  $balance=$approved->sum(fn($item)=>(float)$item->task->reward);
  $withdrawals=WithdrawalRequest::where('user_id',auth()->id())->latest()->get();
  $reserved=(float)$withdrawals->whereIn('status',['pending','approved','paid'])->sum('amount');
  $availableBalance=max(0,$balance-$reserved);
  return view('worker.wallet',compact('approved','balance','availableBalance','withdrawals'));
 }
 public function withdraw(Request $request): RedirectResponse {
  $d=$request->validate(['amount'=>'required|numeric|min:10','account'=>'required|string|max:150']);
  $approved=WorkerTask::with(['task','submission'])->where('user_id',auth()->id())->get()->filter(fn($item)=>$item->submission?->status==='approved');
  $earned=$approved->sum(fn($item)=>(float)$item->task->reward);
  $reserved=(float)WithdrawalRequest::where('user_id',auth()->id())->whereIn('status',['pending','approved','paid'])->sum('amount');
  abort_if((float)$d['amount']>max(0,$earned-$reserved),422,'Insufficient available balance.');
  WithdrawalRequest::create(['user_id'=>auth()->id(),'amount'=>$d['amount'],'method'=>'bKash','account'=>$d['account'],'status'=>'pending']);
  return back()->with('success','Withdrawal request submitted.');
 }
 public function profile(): View {
  $all=WorkerTask::with('submission')->where('user_id',auth()->id())->get();
  $approved=$all->filter(fn($item)=>$item->submission?->status==='approved')->count();
  $rejected=$all->filter(fn($item)=>$item->submission?->status==='rejected')->count();
  $trustLevel=$approved>=30?'Trusted':($approved>=10?'Verified':'New');
  return view('worker.profile',compact('approved','rejected','trustLevel'));
 }
}