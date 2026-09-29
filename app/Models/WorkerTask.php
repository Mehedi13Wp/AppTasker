<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class WorkerTask extends Model {
 use HasFactory;
 protected $fillable=['task_id','user_id','status','token','started_at','app_opened','app_opened_at','app_completed','app_completed_at','submitted_at','completed_at'];
 protected function casts(): array { return ['started_at'=>'datetime','app_opened'=>'boolean','app_opened_at'=>'datetime','app_completed'=>'boolean','app_completed_at'=>'datetime','submitted_at'=>'datetime','completed_at'=>'datetime']; }
 public function task(){ return $this->belongsTo(Task::class); }
 public function user(){ return $this->belongsTo(User::class); }
 public function submission(){ return $this->hasOne(TaskSubmission::class); }
}