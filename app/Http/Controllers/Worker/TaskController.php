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
  abort_unless($task->status === 'available',404);
  $workerTask=WorkerTask::where('task_id',$task->id)->where('user_id',auth()->id())->first();
  $submission=$workerTask?->submission;
  return view('worker.task-show',compact('task','workerTask','submission'));
 }
 public function start(Task $task): RedirectResponse {
  abort_unless($task->status === 'available',404);
  $todayCount=WorkerTask::where('user_id',auth()->id())->whereDate('started_at',today())->count();
  if($todayCount>=9) return back()->with('error','Daily task limit reached.');
  WorkerTask::firstOrCreate(['task_id'=>$task->id,'user_id'=>auth()->id()],['status'=>'started','token'=>(string)Str::uuid(),'started_at'=>now()]);
  return redirect()->route('worker.tasks.show',$task)->with('success','Task started successfully.');
 }
}