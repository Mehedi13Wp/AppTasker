<?php
namespace App\Http\Controllers\Worker;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\WorkerTask;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
class TaskSubmissionController extends Controller {
 public function store(Request $request,Task $task): RedirectResponse {
  $workerTask=WorkerTask::where('task_id',$task->id)->where('user_id',auth()->id())->firstOrFail();
  if(!$workerTask->app_completed) return back()->with('error','Complete the task inside the assigned Android app before submitting.');
  if(TaskSubmission::where('worker_task_id',$workerTask->id)->exists()) return back()->with('error','This task has already been submitted.');
  $validated=$request->validate(['result_file'=>['required','file','max:102400']]);
  $file=$validated['result_file']; $stored=$file->store('task-results','local'); $path=basename($stored);
  TaskSubmission::create(['worker_task_id'=>$workerTask->id,'result_file'=>$path,'original_name'=>$file->getClientOriginalName(),'mime_type'=>$file->getMimeType(),'file_size'=>$file->getSize(),'status'=>'pending','submitted_at'=>now()]);
  $workerTask->update(['status'=>'submitted','submitted_at'=>now()]);
  return redirect()->route('worker.tasks.show',$task)->with('success','Result submitted successfully. Verification is pending.');
 }
}