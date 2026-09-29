<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class ClientDashboardController extends Controller {
 public function index(): View {
  $campaigns=Campaign::where('user_id',auth()->id())->latest()->get();
  $active=$campaigns->where('status','active')->first();
  $spent=(float)$campaigns->sum('amount');
  return view('client.dashboard',compact('campaigns','active','spent'));
 }
 public function store(Request $request): RedirectResponse {
  $d=$request->validate(['app_name'=>'required|string|max:150','app_url'=>'required|url|max:1000','plan'=>'required|in:starter,growth,pro']);
  $plans=['starter'=>['amount'=>5,'days'=>7],'growth'=>['amount'=>10,'days'=>15],'pro'=>['amount'=>15,'days'=>30]];
  $p=$plans[$d['plan']];
  Campaign::create(['user_id'=>auth()->id(),'app_name'=>$d['app_name'],'app_url'=>$d['app_url'],'plan'=>$d['plan'],'amount'=>$p['amount'],'duration_days'=>$p['days'],'status'=>'pending']);
  return back()->with('success','Campaign submitted for admin review.');
 }
}