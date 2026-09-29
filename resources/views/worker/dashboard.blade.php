<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<title>Worker Dashboard | AppTasker</title>
<style>
:root{--navy:#101828;--blue:#4f6ef7;--blue2:#6d5dfc;--bg:#f5f7fb;--text:#182230;--muted:#667085;--line:#e7eaf0;--green:#12b76a;--amber:#f79009}
*{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",sans-serif;background:var(--bg);color:var(--text)}button,a{font:inherit}.shell{min-height:100vh}
.sidebar{position:fixed;inset:0 auto 0 0;width:260px;padding:28px 18px;background:linear-gradient(180deg,#101828,#17213a);color:#fff;z-index:20}.brand{display:flex;align-items:center;gap:10px;padding:0 10px 30px;font-size:23px;font-weight:850}.logo{display:grid;place-items:center;width:38px;height:38px;border-radius:12px;background:linear-gradient(135deg,#7188ff,#7657f7);box-shadow:0 8px 24px #0004}.nav a{display:flex;gap:12px;align-items:center;text-decoration:none;color:#b8c1d1;padding:13px 14px;margin:5px 0;border-radius:12px;font-weight:650}.nav a.active{background:#ffffff14;color:#fff}.nav a:hover{background:#ffffff0d;color:#fff}.side-foot{position:absolute;left:18px;right:18px;bottom:22px;padding:15px;border:1px solid #ffffff12;border-radius:15px;background:#ffffff08}.side-foot small{color:#98a2b3}
.main{margin-left:260px;padding:30px;max-width:1600px}.top{display:flex;align-items:center;justify-content:space-between;gap:20px}.eyebrow{font-size:13px;font-weight:750;color:var(--blue);text-transform:uppercase;letter-spacing:.08em}.top h1{font-size:29px;line-height:1.2;margin:6px 0 0}.top-actions{display:flex;align-items:center;gap:10px}.avatar{width:42px;height:42px;display:grid;place-items:center;border-radius:50%;background:#e9edff;color:#4358c9;font-weight:850}.logout{border:1px solid #d7dce5;background:#fff;color:#344054;padding:10px 15px;border-radius:11px;font-weight:750;cursor:pointer}
.hero{margin-top:26px;background:linear-gradient(125deg,#526df5,#7358f6);color:#fff;border-radius:22px;padding:25px;display:flex;justify-content:space-between;align-items:center;gap:24px;box-shadow:0 15px 38px rgba(79,110,247,.20)}.hero h2{margin:0 0 7px;font-size:21px}.hero p{margin:0;color:#ffffffcf;line-height:1.55}.quota{min-width:190px}.quota-row{display:flex;justify-content:space-between;font-size:13px;font-weight:750}.bar{height:8px;background:#ffffff30;border-radius:99px;margin-top:9px;overflow:hidden}.bar i{display:block;width:{{ min(100, ($todayTasks->count()/9)*100) }}%;height:100%;background:#fff}
.stats{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:15px;margin:18px 0}.stat{background:#fff;border:1px solid var(--line);border-radius:18px;padding:19px;box-shadow:0 7px 24px rgba(16,24,40,.035)}.stat-top{display:flex;align-items:center;justify-content:space-between}.icon{width:38px;height:38px;border-radius:11px;background:#f0f3ff;display:grid;place-items:center;font-size:18px}.label{color:var(--muted);font-size:13px;font-weight:600}.value{font-size:26px;font-weight:850;margin-top:9px;letter-spacing:-.03em}.positive{font-size:12px;color:var(--green);font-weight:750;margin-top:5px}
.content-grid{display:grid;grid-template-columns:minmax(0,2fr) minmax(270px,.8fr);gap:18px}.panel{background:#fff;border:1px solid var(--line);border-radius:19px;padding:20px}.panel-head{display:flex;align-items:center;justify-content:space-between;gap:15px;margin-bottom:15px}.panel h2{font-size:18px;margin:0}.view-all{font-size:13px;color:var(--blue);font-weight:750;text-decoration:none}.tasks{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px}.task{border:1px solid var(--line);border-radius:16px;padding:16px;transition:.2s}.task:hover{transform:translateY(-2px);box-shadow:0 10px 25px #1018280d}.pill{display:inline-flex;padding:5px 9px;border-radius:99px;background:#eef1ff;color:#4459c5;font-size:11px;font-weight:850}.task h3{font-size:16px;margin:12px 0 6px}.task p{font-size:13px;color:var(--muted);line-height:1.5;min-height:58px}.empty-btn{width:100%;border:0;border-radius:10px;padding:10px;background:#eef1f5;color:#98a2b3;font-weight:750}.task-link{display:block;text-align:center;text-decoration:none;background:#182230;color:#fff;transition:.2s}.task-link:hover{background:#526df5}.slot{display:flex;align-items:center;gap:12px;padding:13px 0;border-bottom:1px solid #f0f1f4}.slot:last-child{border:0}.slot-icon{width:36px;height:36px;border-radius:11px;background:#fff7e8;display:grid;place-items:center}.slot strong{display:block;font-size:13px}.slot small{color:var(--muted)}.status{margin-left:auto;font-size:11px;font-weight:800;color:var(--green);background:#ecfdf3;padding:5px 8px;border-radius:99px}
.mobile-nav{display:none}
@media(max-width:1100px){.stats{grid-template-columns:repeat(2,1fr)}.content-grid{grid-template-columns:1fr}.tasks{grid-template-columns:repeat(3,1fr)}}
@media(max-width:800px){.sidebar{display:none}.main{margin:0;padding:22px 16px calc(94px + env(safe-area-inset-bottom));}.top h1{font-size:24px}.hero{padding:20px;border-radius:19px}.stats{gap:11px}.tasks{grid-template-columns:1fr}.task p{min-height:auto}.mobile-nav{display:grid;grid-template-columns:repeat(4,1fr);position:fixed;z-index:30;bottom:0;left:0;right:0;padding:9px 8px calc(9px + env(safe-area-inset-bottom));background:#fffffff5;backdrop-filter:blur(14px);border-top:1px solid var(--line)}.mobile-nav a{text-decoration:none;color:#7b8495;text-align:center;font-size:11px;font-weight:650}.mobile-nav b{display:block;font-size:19px;line-height:23px}.mobile-nav a.active{color:var(--blue)}}
@media(max-width:520px){.main{padding-top:18px}.eyebrow{font-size:11px}.top h1{font-size:22px;max-width:220px}.avatar{display:none}.logout{padding:9px 12px}.hero{display:block;margin-top:20px}.hero h2{font-size:18px}.hero p{font-size:13px}.quota{margin-top:18px;min-width:0}.stats{grid-template-columns:1fr 1fr}.stat{padding:15px}.value{font-size:22px}.panel{padding:16px}.content-grid{gap:13px}}
</style>
</head>
<body>
<div class="shell">
<aside class="sidebar">
 <div class="brand"><span class="logo">A</span> AppTasker</div>
 <nav class="nav"><a class="active" href="#">⌂ Dashboard</a><a href="#tasks">✓ Available Tasks</a><a href="{{ route('worker.history') }}">▣ My Tasks</a><a href="{{ route('worker.wallet') }}">◈ Wallet</a><a href="{{ route('worker.profile') }}">○ Profile</a></nav>
 <div class="side-foot"><strong>Worker account</strong><br><small>{{ auth()->user()->email }}</small></div>
</aside>
<main class="main">
 <header class="top">
  <div><div class="eyebrow">Worker workspace</div><h1>Welcome back, {{ auth()->user()->name }}</h1></div>
  <div class="top-actions"><div class="avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div><form method="POST" action="{{ route('logout') }}">@csrf<button class="logout">Logout</button></form></div>
 </header>
 <section class="hero"><div><h2>Ready to complete today's tasks?</h2><p>Your daily task limit is 9. Complete quality work to grow your trust level and earnings.</p></div><div class="quota"><div class="quota-row"><span>Daily progress</span><span>{{ $todayTasks->count() }} / 9</span></div><div class="bar"><i></i></div></div></section>
 <section class="stats">
  <div class="stat"><div class="stat-top"><span class="label">Available Tasks</span><span class="icon">✓</span></div><div class="value">{{ $availableCount }}</div><div class="positive">{{ $availableCount > 0 ? "Tasks ready to start" : "Waiting for new tasks" }}</div></div>
  <div class="stat"><div class="stat-top"><span class="label">Today's Earnings</span><span class="icon">৳</span></div><div class="value">৳{{ number_format($todayEarnings,2) }}</div><div class="positive">Ready to earn</div></div>
  <div class="stat"><div class="stat-top"><span class="label">Completed Today</span><span class="icon">↗</span></div><div class="value">{{ $completedToday }} / 9</div><div class="positive">{{ max(0,9-$todayTasks->count()) }} tasks remaining</div></div>
  <div class="stat"><div class="stat-top"><span class="label">Trust Level</span><span class="icon">★</span></div><div class="value">{{ $trustLevel }}</div><div class="positive">Build your reputation</div></div>
 </section>
 <section class="content-grid">
  <div class="panel" id="tasks"><div class="panel-head"><h2>Available tasks</h2><a class="view-all" href="#tasks">View all</a></div>
   <div class="tasks">
    @forelse($tasks as $task)
     <article class="task">
      <span class="pill">{{ strtoupper(str_replace('_', ' ', $task->type)) }}</span>
      <h3>{{ $task->title }}</h3>
      <p>{{ $task->description ?: 'Open this task to see the full requirements.' }}</p>
      <a class="empty-btn task-link" href="{{ route('worker.tasks.show', $task) }}">View Task · ৳{{ number_format((float) $task->reward, 2) }}</a>
     </article>
    @empty
     <article class="task"><span class="pill">TASKS</span><h3>No task available</h3><p>New tasks will appear here automatically when they are published.</p><button class="empty-btn" disabled>Check again later</button></article>
    @endforelse
   </div>
   </div>
  </div>
  <aside class="panel"><div class="panel-head"><h2>Today's slots</h2></div>
   <div class="slot"><span class="slot-icon">☀</span><div><strong>Morning</strong><small>3 tasks max</small></div><span class="status">Open</span></div>
   <div class="slot"><span class="slot-icon">◐</span><div><strong>Afternoon</strong><small>3 tasks max</small></div><span class="status">Open</span></div>
   <div class="slot"><span class="slot-icon">☾</span><div><strong>Evening</strong><small>3 tasks max</small></div><span class="status">Open</span></div>
  </aside>
 </section>
</main>
<nav class="mobile-nav"><a class="active" href="{{ route('worker.dashboard') }}"><b>⌂</b>Home</a><a href="{{ route('worker.history') }}"><b>✓</b>Tasks</a><a href="{{ route('worker.wallet') }}"><b>◈</b>Wallet</a><a href="{{ route('worker.profile') }}"><b>○</b>Profile</a></nav>
</div>
</body></html>