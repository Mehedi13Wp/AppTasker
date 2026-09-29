<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Worker Dashboard | AppTasker</title>
<style>
*{box-sizing:border-box}body{margin:0;font-family:Inter,system-ui,-apple-system,sans-serif;background:#f4f7fb;color:#172033}.shell{min-height:100vh;display:flex}.sidebar{width:250px;background:#101828;color:#fff;padding:28px 20px;position:fixed;inset:0 auto 0 0}.brand{font-size:24px;font-weight:800;margin-bottom:42px}.brand span{color:#7c9cff}.nav a{display:block;color:#b9c2d3;text-decoration:none;padding:13px 15px;border-radius:12px;margin:6px 0}.nav a.active{background:#25304a;color:#fff}.main{margin-left:250px;width:calc(100% - 250px);padding:32px}.top{display:flex;justify-content:space-between;align-items:center;gap:20px}.eyebrow{color:#667085;font-size:14px}.top h1{margin:5px 0;font-size:28px}.logout{border:1px solid #d0d5dd;background:#fff;padding:10px 16px;border-radius:10px;font-weight:700}.grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin:28px 0}.card{background:#fff;border:1px solid #e5e9f0;border-radius:18px;padding:20px;box-shadow:0 8px 30px rgba(16,24,40,.04)}.label{font-size:13px;color:#667085}.value{font-size:27px;font-weight:800;margin-top:8px}.section-title{font-size:19px;font-weight:800;margin:28px 0 14px}.tasks{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}.task h3{margin:8px 0}.pill{display:inline-block;background:#eef4ff;color:#3448a5;padding:6px 9px;border-radius:999px;font-size:12px;font-weight:700}.task p{color:#667085;line-height:1.5}.task button{width:100%;border:0;background:#172033;color:#fff;padding:12px;border-radius:11px;font-weight:700}.mobile-nav{display:none}
@media(max-width:900px){.grid{grid-template-columns:repeat(2,1fr)}.tasks{grid-template-columns:1fr}.sidebar{display:none}.main{margin:0;width:100%;padding:20px 16px 90px}.mobile-nav{display:flex;position:fixed;bottom:0;left:0;right:0;background:#fff;border-top:1px solid #e5e9f0;justify-content:space-around;padding:12px 6px;z-index:10}.mobile-nav span{font-size:12px;color:#667085}.mobile-nav .active{color:#172033;font-weight:800}}
@media(max-width:520px){.grid{grid-template-columns:1fr 1fr;gap:10px}.card{padding:15px}.value{font-size:22px}.top h1{font-size:23px}.logout{padding:9px 12px}}
</style>
</head>
<body>
<div class="shell">
<aside class="sidebar">
<div class="brand">App<span>Tasker</span></div>
<nav class="nav"><a class="active" href="#">Dashboard</a><a href="#">Available Tasks</a><a href="#">My Tasks</a><a href="#">Wallet</a><a href="#">Profile</a></nav>
</aside>
<main class="main">
<header class="top">
<div><div class="eyebrow">Worker workspace</div><h1>Welcome, {{ auth()->user()->name }}</h1></div>
<form method="POST" action="{{ route('logout') }}">@csrf<button class="logout" type="submit">Logout</button></form>
</header>
<section class="grid">
<div class="card"><div class="label">Available Tasks</div><div class="value">0</div></div>
<div class="card"><div class="label">Today's Earnings</div><div class="value">$0.00</div></div>
<div class="card"><div class="label">Completed Today</div><div class="value">0 / 9</div></div>
<div class="card"><div class="label">Trust Level</div><div class="value">New</div></div>
</section>
<div class="section-title">Available tasks</div>
<section class="tasks">
<div class="card task"><span class="pill">IMAGE</span><h3>Image Resize</h3><p>Resize an assigned image to the required dimensions and submit the processed result.</p><button disabled>No task available</button></div>
<div class="card task"><span class="pill">VIDEO</span><h3>Video Resize</h3><p>Process a short video to the requested resolution while preserving its content.</p><button disabled>No task available</button></div>
<div class="card task"><span class="pill">CONVERT</span><h3>File Convert</h3><p>Convert an assigned file into the requested output format and submit it for verification.</p><button disabled>No task available</button></div>
</section>
</main>
<nav class="mobile-nav"><span class="active">Home</span><span>Tasks</span><span>Wallet</span><span>Profile</span></nav>
</div>
</body>
</html>
