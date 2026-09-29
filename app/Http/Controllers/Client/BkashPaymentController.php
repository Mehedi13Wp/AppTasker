<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;
class BkashPaymentController extends Controller {
 public function checkout(Campaign $campaign): View {
  abort_unless($campaign->user_id===auth()->id(),403);
  abort_if($campaign->payment_status==='paid',422,'Campaign is already paid.');
  return view('client.bkash-checkout',compact('campaign'));
 }
 public function demoPay(Campaign $campaign): RedirectResponse {
  abort_unless($campaign->user_id===auth()->id(),403);
  abort_unless(config('services.bkash.mode','demo')==='demo',403,'Demo payment is disabled.');
  if($campaign->payment_status!=='paid') $campaign->update(['payment_status'=>'paid','payment_method'=>'bkash','transaction_id'=>'DEMO-'.strtoupper(Str::random(12)),'paid_at'=>now(),'status'=>'pending']);
  return redirect()->route('client.dashboard')->with('success','Demo bKash payment completed. No real money was transferred.');
 }
}