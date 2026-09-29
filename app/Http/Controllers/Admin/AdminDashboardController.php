<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\User;
use App\Models\WorkerTask;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class AdminDashboardController extends Controller {
 public function index(): View {
  $stats=['workers'=>User::where('role','worker')->count(),'clients'=>User::where('role','client')->count(),'tasks'=>Task::count(),'pending'=>TaskSubmission::where('status','pending')->count()];
  $submissions=TaskSubmission::with(['workerTask.task','workerTask.user'])->latest('submitted_at')->take(8)->get();
  $tasks=Task::latest()->take(8)->get();
  return view('admin.dashboard',compact('stats','submissions','tasks'));
 }
 public function submissions(): View {
  $submissions=TaskSubmission::with(['workerTask.task','workerTask.user'])->latest('submitted_at')->paginate(25);
  return view('admin.submissions',compact('submissions'));
 }
 public function review(Request $request,TaskSubmission $submission): RedirectResponse {
  abort_if($submission->status!=='pending',422,'This submission has already been reviewed.');
  $data=$request->validate(['status'=>['required','in:approved,rejected'],'verification_notes'=>['nullable','string','max:1000']]);
  $submission->update(['status'=>$data['status'],'verification_notes'=>$data['verification_notes']??null]);
  $submission->workerTask->update(['status'=>$data['status']==='approved'?'completed':'rejected','completed_at'=>$data['status']==='approved'?now():null]);
  return back()->with('success','Submission updated.');
 }
}