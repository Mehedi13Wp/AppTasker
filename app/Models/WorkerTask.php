<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class WorkerTask extends Model {
 use HasFactory;
 protected $fillable=['task_id','user_id','status','token','started_at','submitted_at','completed_at'];
 protected function casts(): array { return ['started_at'=>'datetime','submitted_at'=>'datetime','completed_at'=>'datetime']; }
 public function task(){ return $this->belongsTo(Task::class); }
 public function user(){ return $this->belongsTo(User::class); }
}