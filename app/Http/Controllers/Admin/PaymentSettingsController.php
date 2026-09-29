<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
class PaymentSettingsController extends Controller {
 public function index(): View {
  return view('admin.payment-settings',['mode'=>config('services.bkash.mode','demo'),'merchant'=>config('services.bkash.merchant_number')]);
 }
 public function update(Request $request): RedirectResponse {
  $d=$request->validate(['mode'=>'required|in:demo,live','merchant_number'=>'nullable|string|max:30']);
  if($d['mode']==='live' && !config('services.bkash.app_key')) return back()->withErrors(['mode'=>'Add your official bKash API credentials to the server environment before enabling Live mode.']);
  return back()->with('success','Payment preference checked. Server credentials remain protected in environment configuration.');
 }
}