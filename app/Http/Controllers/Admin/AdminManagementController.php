<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class AdminManagementController extends Controller {
 public function tasks(): View { $tasks=Task::latest()->paginate(25); return view('admin.tasks',compact('tasks')); }
 public function storeTask(Request $request): RedirectResponse {
  $d=$request->validate(['title'=>'required|string|max:150','type'=>'required|in:image_resize,video_resize,image_convert','description'=>'nullable|string|max:1000','reward'=>'required|numeric|min:0','slot'=>'required|in:morning,afternoon,evening','status'=>'required|in:available,paused']);
  Task::create($d); return back()->with('success','Task created.');
 }
 public function taskStatus(Task $task): RedirectResponse { $task->update(['status'=>$task->status==='available'?'paused':'available']); return back()->with('success','Task status updated.'); }
 public function workers(): View { $workers=User::where('role','worker')->latest()->paginate(25); return view('admin.users',compact('workers'))->with('pageType','Workers'); }
 public function clients(): View { $workers=User::where('role','client')->latest()->paginate(25); return view('admin.users',compact('workers'))->with('pageType','Clients'); }
 public function userStatus(Request $request,User $user): RedirectResponse {
  abort_if($user->isAdmin(),403); $d=$request->validate(['status'=>'required|in:active,suspended,blocked']); $user->update($d); return back()->with('success','Account status updated.');
 }
}