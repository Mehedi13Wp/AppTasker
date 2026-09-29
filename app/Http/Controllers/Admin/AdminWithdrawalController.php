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
  abort_if(in_array($withdrawal->status,['rejected','paid'],true),422,'This withdrawal is already finalized.');
  $allowed=$withdrawal->status==='pending'?['approved','rejected']:['paid'];
  $d=$request->validate(['status'=>'required|in:'.implode(',',$allowed),'admin_note'=>'nullable|string|max:1000']);
  $withdrawal->update(['status'=>$d['status'],'admin_note'=>$d['admin_note']??$withdrawal->admin_note,'processed_at'=>in_array($d['status'],['rejected','paid'],true)?now():null]);
  return back()->with('success',$d['status']==='paid'?'Withdrawal marked paid.':'Withdrawal status updated.');
 }
}