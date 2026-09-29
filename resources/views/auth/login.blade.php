<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign in — AppTasker</title>
<style>
*{box-sizing:border-box}body{margin:0;font-family:Inter,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;background:#07111f;color:#eaf2ff;min-height:100vh}.page{min-height:100vh;display:grid;grid-template-columns:1.08fr .92fr}.hero{position:relative;padding:54px clamp(28px,6vw,90px);display:flex;flex-direction:column;justify-content:space-between;overflow:hidden;background:radial-gradient(circle at 20% 15%,rgba(59,130,246,.24),transparent 30%),radial-gradient(circle at 75% 75%,rgba(16,185,129,.16),transparent 32%),#07111f}.hero:after{content:"";position:absolute;width:420px;height:420px;border:1px solid rgba(255,255,255,.08);border-radius:50%;right:-160px;bottom:-140px}.brand{display:flex;align-items:center;gap:12px;font-weight:800;font-size:22px;position:relative;z-index:1}.logo{width:40px;height:40px;border-radius:13px;display:grid;place-items:center;background:linear-gradient(135deg,#3b82f6,#22c55e);box-shadow:0 10px 30px rgba(59,130,246,.25)}.hero-copy{max-width:650px;position:relative;z-index:1}.badge{display:inline-flex;padding:8px 12px;border:1px solid rgba(255,255,255,.1);border-radius:999px;background:rgba(255,255,255,.05);font-size:13px;color:#b9c8dc}.hero h1{font-size:clamp(38px,5vw,68px);line-height:1.02;letter-spacing:-2.5px;margin:22px 0 18px}.hero p{font-size:18px;line-height:1.7;color:#9fb0c6;max-width:560px}.points{display:flex;gap:24px;flex-wrap:wrap;margin-top:30px;color:#c8d6e8;font-size:14px}.point:before{content:"✓";color:#4ade80;margin-right:8px}.panel{background:#f8fafc;color:#0f172a;display:grid;place-items:center;padding:32px}.card{width:min(100%,470px)}.card h2{font-size:34px;letter-spacing:-1.2px;margin:0 0 9px}.sub{color:#64748b;margin:0 0 30px;line-height:1.6}.field{margin-bottom:18px}.field label{display:block;font-weight:650;font-size:14px;margin-bottom:8px}.field input{width:100%;height:52px;border:1px solid #dbe3ee;border-radius:14px;background:white;padding:0 16px;font-size:16px;outline:none;transition:.2s}.field input:focus{border-color:#3b82f6;box-shadow:0 0 0 4px rgba(59,130,246,.1)}.row{display:flex;justify-content:space-between;align-items:center;margin:6px 0 22px;font-size:14px;color:#64748b}.remember{display:flex;align-items:center;gap:8px}.remember input{accent-color:#2563eb}.btn{border:0;width:100%;height:54px;border-radius:14px;background:#0f172a;color:white;font-weight:750;font-size:16px;cursor:pointer;box-shadow:0 12px 25px rgba(15,23,42,.16)}.switch{text-align:center;color:#64748b;margin-top:24px}.switch a{color:#2563eb;font-weight:700;text-decoration:none}.errors{background:#fff1f2;color:#be123c;border:1px solid #fecdd3;border-radius:13px;padding:12px 14px;margin-bottom:18px;font-size:14px}.foot{color:#6f8199;font-size:13px;position:relative;z-index:1}@media(max-width:850px){.page{grid-template-columns:1fr}.hero{min-height:auto;padding:26px 22px 32px}.hero-copy{margin-top:55px}.hero h1{font-size:40px}.hero p{font-size:16px}.points,.foot{display:none}.panel{padding:36px 20px 46px}.card h2{font-size:30px}}@media(max-width:430px){.hero-copy{margin-top:38px}.hero h1{font-size:34px;letter-spacing:-1.5px}.panel{padding-top:30px}.field input,.btn{height:50px}}
</style>
</head>
<body>
<div class="page">
<section class="hero">
<div class="brand"><span class="logo">A</span> AppTasker</div>
<div class="hero-copy"><span class="badge">One platform. Real digital work.</span><h1>Promote apps.<br>Complete tasks.<br>Grow together.</h1><p>A professional workspace connecting app clients with verified digital workers through structured campaigns and task-based rewards.</p><div class="points"><span class="point">Verified workflows</span><span class="point">Task-based rewards</span><span class="point">Secure accounts</span></div></div>
<div class="foot">© {{ date('Y') }} AppTasker. Built for clients and digital workers.</div>
</section>
<main class="panel"><div class="card"><h2>Welcome back</h2><p class="sub">Sign in to continue to your AppTasker workspace.</p>
@if ($errors->any())<div class="errors">{{ $errors->first() }}</div>@endif
<form method="POST" action="{{ route('login.store') }}">@csrf
<div class="field"><label>Email address</label><input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autofocus></div>
<div class="field"><label>Password</label><input type="password" name="password" placeholder="Enter your password" required></div>
<div class="row"><label class="remember"><input type="checkbox" name="remember"> Remember me</label><span>Secure sign in</span></div>
<button class="btn" type="submit">Sign in to AppTasker</button></form>
<p class="switch">New to AppTasker? <a href="{{ route('register') }}">Create an account</a></p></div></main>
</div></body></html>
