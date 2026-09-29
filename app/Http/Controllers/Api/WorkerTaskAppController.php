<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\WorkerTask;
use Illuminate\Http\JsonResponse;
class WorkerTaskAppController extends Controller {
 public function task(string $token): JsonResponse {
  $assignment=WorkerTask::with('task')->where('token',$token)->firstOrFail();
  return response()->json(['success'=>true,'assignment'=>['status'=>$assignment->status,'token'=>$assignment->token,'app_opened'=>$assignment->app_opened,'app_completed'=>$assignment->app_completed,'task'=>['id'=>$assignment->task->id,'title'=>$assignment->task->title,'type'=>$assignment->task->type,'requirements'=>$assignment->task->requirements]]]);
 }
 public function opened(string $token): JsonResponse {
  $assignment=WorkerTask::where('token',$token)->firstOrFail();
  $assignment->update(['app_opened'=>true,'app_opened_at'=>now()]);
  return response()->json(['success'=>true,'message'=>'App open confirmed.']);
 }
 public function completed(string $token): JsonResponse {
  $assignment=WorkerTask::where('token',$token)->firstOrFail();
  if(!$assignment->app_opened) return response()->json(['success'=>false,'message'=>'App open event is required first.'],422);
  $assignment->update(['app_completed'=>true,'app_completed_at'=>now(),'status'=>'processed']);
  return response()->json(['success'=>true,'message'=>'App processing completion confirmed.']);
 }
}