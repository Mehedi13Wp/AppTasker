<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Task extends Model {
 use HasFactory;
 protected $fillable=['title','type','description','reward','slot','status','source_file','app_name','app_url','app_package','requirements','available_from','available_until'];
 protected function casts(): array { return ['reward'=>'decimal:2','requirements'=>'array','available_from'=>'datetime','available_until'=>'datetime']; }
 public function scopeAvailable($query) {
  return $query->where('status','available')
   ->where(fn($q)=>$q->whereNull('available_from')->orWhere('available_from','<=',now()))
   ->where(fn($q)=>$q->whereNull('available_until')->orWhere('available_until','>=',now()));
 }
}