<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class WithdrawalRequest extends Model {
 use HasFactory;
 protected $fillable=['user_id','amount','method','account','status','admin_note','processed_at'];
 protected function casts(): array { return ['amount'=>'decimal:2','processed_at'=>'datetime']; }
 public function user(){ return $this->belongsTo(User::class); }
}