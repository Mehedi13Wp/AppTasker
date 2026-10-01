<?php
namespace App\Http\Controllers\Worker;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\WorkerTask;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;
class TaskController extends Controller {
 public function show(Task $task): View {
  $workerTask=WorkerTask::where('task_id',$task->id)->where('user_id',auth()->id())->first();
  abort_unless($task->status === 'available' || $workerTask,404);
  $submission=$workerTask?->submission;
  return view('worker.task-show',compact('task','workerTask','submission'));
 }
 public function start(Task $task): RedirectResponse {
  abort_unless($task->status === 'available',404);
  $todayCount=WorkerTask::where('user_id',auth()->id())->whereDate('started_at',today())->count();
  $slotCount=WorkerTask::where('user_id',auth()->id())->whereDate('started_at',today())->whereHas('task',fn($q)=>$q->where('slot',$task->slot))->count();
  if($todayCount>=9) return back()->with('error','Daily task limit reached.');
  if($slotCount>=3) return back()->with('error','This time slot already has 3 tasks today.');
  WorkerTask::firstOrCreate(['task_id'=>$task->id,'user_id'=>auth()->id()],['status'=>'started','token'=>(string)Str::uuid(),'started_at'=>now()]);
  return redirect()->route('worker.tasks.show',$task)->with('success','Task started successfully.');
 }
}