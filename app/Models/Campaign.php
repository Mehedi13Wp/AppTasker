<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Campaign extends Model {
 use HasFactory;
 protected $fillable=['user_id','app_name','app_url','plan','amount','duration_days','status','accepted_at','ends_at','payment_status','payment_method','transaction_id','paid_at'];
 protected function casts(): array { return ['amount'=>'decimal:2','accepted_at'=>'datetime','ends_at'=>'datetime','paid_at'=>'datetime']; }
 public function user(){ return $this->belongsTo(User::class); }
}