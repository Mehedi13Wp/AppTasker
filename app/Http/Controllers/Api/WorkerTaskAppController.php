<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\WorkerTask;
use Illuminate\Http\JsonResponse;
class WorkerTaskAppController extends Controller {
 private function assignment(string $token): WorkerTask {
  abort_if(strlen($token)<30,404);
  return WorkerTask::with('task')->where('token',$token)->firstOrFail();
 }
 public function task(string $token): JsonResponse {
  $a=$this->assignment($token);
  return response()->json(['success'=>true,'assignment'=>['status'=>$a->status,'token'=>$a->token,'app_opened'=>$a->app_opened,'app_completed'=>$a->app_completed,'task'=>['id'=>$a->task->id,'title'=>$a->task->title,'type'=>$a->task->type,'requirements'=>$a->task->requirements]]]);
 }
 public function opened(string $token): JsonResponse {
  $a=$this->assignment($token);
  if(in_array($a->status,['submitted','completed','approved','rejected'],true)) return response()->json(['success'=>false,'message'=>'Task is already finalized or submitted.'],409);
  if(!$a->app_opened) $a->update(['app_opened'=>true,'app_opened_at'=>now()]);
  return response()->json(['success'=>true,'message'=>'App open confirmed.']);
 }
 public function completed(string $token): JsonResponse {
  $a=$this->assignment($token);
  if(in_array($a->status,['submitted','completed','approved','rejected'],true)) return response()->json(['success'=>false,'message'=>'Task is already finalized or submitted.'],409);
  if(!$a->app_opened) return response()->json(['success'=>false,'message'=>'App open event is required first.'],422);
  if(!$a->app_completed) $a->update(['app_completed'=>true,'app_completed_at'=>now(),'status'=>'processed']);
  return response()->json(['success'=>true,'message'=>'App processing completion confirmed.']);
 }
}