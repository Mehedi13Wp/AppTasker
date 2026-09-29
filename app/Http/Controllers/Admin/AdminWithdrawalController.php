<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
class AdminWithdrawalController extends Controller {
 public function index(): View { $withdrawals=WithdrawalRequest::with('user')->latest()->paginate(25); return view('admin.withdrawals',compact('withdrawals')); }
 public function update(Request $request,WithdrawalRequest $withdrawal): RedirectResponse {
  $d=$request->validate(['status'=>'required|in:approved,rejected,paid','admin_note'=>'nullable|string|max:1000']);
  $withdrawal->update(['status'=>$d['status'],'admin_note'=>$d['admin_note']??null,'processed_at'=>in_array($d['status'],['rejected','paid'])?now():null]);
  return back()->with('success','Withdrawal updated.');
 }
}