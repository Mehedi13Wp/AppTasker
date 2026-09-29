<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class TaskSubmission extends Model {
 use HasFactory;
 protected $fillable=['worker_task_id','result_file','original_name','mime_type','file_size','status','verification_notes','submitted_at'];
 protected function casts(): array { return ['submitted_at'=>'datetime']; }
 public function workerTask(){ return $this->belongsTo(WorkerTask::class); }
}