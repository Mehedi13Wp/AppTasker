<?php
namespace App\Http\Controllers\Worker;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\View\View;
class WorkerDashboardController extends Controller {
 public function index(): View {
  $tasks=Task::available()->latest()->take(12)->get();
  return view('worker.dashboard',['tasks'=>$tasks,'availableCount'=>$tasks->count()]);
 }
}