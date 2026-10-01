<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
class AdminCampaignController extends Controller {
 public function index(): View { $campaigns=Campaign::with('user')->latest()->paginate(25); return view('admin.campaigns',compact('campaigns')); }
 public function update(Request $request,Campaign $campaign): RedirectResponse {
  abort_if(in_array($campaign->status,['completed','cancelled'],true),422,'This campaign is already finalized.');
  $d=$request->validate(['status'=>'required|in:pending,active,completed,cancelled']);
  if($d['status']==='completed' && $campaign->status!=='active') return back()->withErrors(['status'=>'Only an active campaign can be completed.']);
  if($d['status']==='active' && $campaign->payment_status!=='paid') return back()->withErrors(['status'=>'Campaign must be paid before activation.']);
  if($campaign->status==='active' && $d['status']==='pending') return back()->withErrors(['status'=>'An active campaign cannot return to pending.']);
  if($d['status']==='active' && $campaign->status!=='active'){ $campaign->accepted_at=now(); $campaign->ends_at=now()->addDays($campaign->duration_days); }
  $campaign->status=$d['status']; $campaign->save(); return back()->with('success','Campaign status updated.');
 }
}