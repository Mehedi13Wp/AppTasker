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
  $d=$request->validate(['status'=>'required|in:pending,active,completed,cancelled']);
  if($d['status']==='active' && $campaign->status!=='active'){ $campaign->accepted_at=now(); $campaign->ends_at=now()->addDays($campaign->duration_days); }
  $campaign->status=$d['status']; $campaign->save(); return back()->with('success','Campaign status updated.');
 }
}