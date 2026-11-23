<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Remind Me')</title>
    <style>
        :root {
            --bg:#0a0e1a; --panel:#111827; --panel2:#0f172a; --line:#1f2a44;
            --text:#d1d5db; --muted:#6b7a99;
            --cyan:#22d3ee; --green:#4ade80; --amber:#fbbf24; --red:#f87171; --violet:#a78bfa;
            --mono: ui-monospace, "Cascadia Code", "JetBrains Mono", Consolas, "Courier New", monospace;
        }
        * { box-sizing:border-box; }
        body {
            margin:0; font-family:var(--mono); font-size:14px; color:var(--text); min-height:100vh;
            background:
                linear-gradient(rgba(34,211,238,.035) 1px, transparent 1px) 0 0/100% 32px,
                linear-gradient(90deg, rgba(34,211,238,.035) 1px, transparent 1px) 0 0/32px 100%,
                var(--bg);
        }
        a { color:var(--cyan); text-decoration:none; }

        /* top bar */
        .topbar { display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;
                  padding:12px 24px; background:var(--panel2); border-bottom:1px solid var(--line); }
        .brand { color:var(--green); font-weight:700; font-size:1rem; margin:0; }
        .brand span { color:var(--cyan); }
        .cursor { display:inline-block; width:8px; height:15px; background:var(--green); margin-left:4px; vertical-align:middle; animation:blink 1s steps(1) infinite; }
        @keyframes blink { 50% { opacity:0; } }
        .userbox { display:flex; align-items:center; gap:14px; color:var(--muted); flex-wrap:wrap; }
        .userbox b { color:var(--cyan); font-weight:600; }
        .navlinks { display:flex; gap:14px; }
        .navlinks a { color:var(--text); }
        .navlinks a:hover { color:var(--cyan); }

        main { max-width:860px; margin:26px auto; padding:0 16px; }

        /* panels */
        .panel { background:var(--panel); border:1px solid var(--line); border-radius:8px; margin-bottom:16px; overflow:hidden; }
        .panel-head { display:flex; align-items:center; gap:7px; padding:9px 14px; background:var(--panel2); border-bottom:1px solid var(--line); color:var(--muted); font-size:12px; }
        .dot { width:10px; height:10px; border-radius:50%; display:inline-block; }
        .dot.r{background:#ef4444} .dot.y{background:#f59e0b} .dot.g{background:#22c55e}
        .panel-head .ttl { margin-left:8px; }
        .panel-body { padding:18px; }

        /* stats */
        .stats { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin-bottom:18px; }
        .stat { background:var(--panel); border:1px solid var(--line); border-radius:8px; padding:14px 16px; }
        .stat .num { font-size:1.8rem; font-weight:700; }
        .stat .lbl { color:var(--muted); font-size:12px; text-transform:uppercase; letter-spacing:.08em; }
        .c-cyan{color:var(--cyan)} .c-amber{color:var(--amber)} .c-green{color:var(--green)}

        /* section titles */
        .section-title { color:var(--muted); margin:22px 0 10px; font-size:13px; }
        .section-title::before { content:"$ "; color:var(--green); }

        /* activity item */
        .item { background:var(--panel); border:1px solid var(--line); border-left:3px solid var(--cyan);
                border-radius:8px; padding:14px 16px; margin-bottom:10px; }
        a:hover > .item { border-color:var(--cyan); }
        .item.done { border-left-color:var(--green); opacity:.65; }
        .item.done .title { text-decoration:line-through; }
        .item .title { font-size:1rem; color:#fff; font-weight:600; }
        .item .meta { color:var(--muted); font-size:12.5px; margin-top:4px; }
        .item .desc { margin-top:6px; color:var(--text); font-size:13px; }
        .row { display:flex; justify-content:space-between; align-items:flex-start; gap:12px; flex-wrap:wrap; }
        .actions { display:flex; gap:6px; flex-wrap:wrap; }
        .actions form { margin:0; }
        .tag { display:inline-block; font-size:11px; padding:2px 7px; border-radius:4px; margin-left:8px; border:1px solid; }
        .tag.pending { color:var(--amber); border-color:var(--amber); }
        .tag.done    { color:var(--green); border-color:var(--green); }

        /* buttons */
        .btn { font-family:var(--mono); font-size:12.5px; padding:7px 12px; border-radius:5px; cursor:pointer;
               border:1px solid var(--cyan); background:transparent; color:var(--cyan); transition:.15s; display:inline-block; }
        .btn:hover { background:var(--cyan); color:#04121a; }
        .btn-green { border-color:var(--green); color:var(--green); } .btn-green:hover { background:var(--green); color:#04140a; }
        .btn-red   { border-color:var(--red);   color:var(--red); }   .btn-red:hover   { background:var(--red);   color:#1a0505; }
        .btn-ghost { border-color:var(--line);  color:var(--muted); } .btn-ghost:hover { background:var(--line); color:#fff; }
        .btn-block { width:100%; padding:10px; }

        /* forms */
        label { display:block; margin-bottom:16px; color:var(--cyan); font-size:12px; text-transform:uppercase; letter-spacing:.06em; }
        input, textarea, select {
            width:100%; margin-top:6px; padding:10px 12px; font-family:var(--mono); font-size:14px;
            background:#070b16; color:#e5e7eb; border:1px solid var(--line); border-radius:5px; outline:none;
        }
        input:focus, textarea:focus, select:focus { border-color:var(--cyan); box-shadow:0 0 0 2px rgba(34,211,238,.15); }
        input[type="date"], input[type="time"] { color-scheme:dark; }
        .grid2 { display:grid; grid-template-columns:1fr 1fr; gap:14px; }

        /* alerts */
        .alert { padding:10px 14px; border-radius:6px; margin-bottom:16px; border:1px solid; font-size:13px; }
        .alert-ok  { color:var(--green); border-color:var(--green); background:rgba(74,222,128,.07); }
        .alert-ok::before  { content:"[ OK ] "; font-weight:700; }
        .alert-err { color:var(--red); border-color:var(--red); background:rgba(248,113,113,.07); }
        .alert-err::before { content:"[ ERROR ] "; font-weight:700; }

        .empty { color:var(--muted); padding:14px 16px; border:1px dashed var(--line); border-radius:8px; }
        .login-wrap { max-width:420px; margin:70px auto 0; }
        .hint { color:var(--muted); font-size:12px; margin:0 0 16px; }

        /* toast (reminder pop-up) */
        #toasts { position:fixed; right:16px; bottom:16px; display:flex; flex-direction:column; gap:10px; z-index:50; }
        .toast { background:var(--panel2); border:1px solid var(--amber); color:var(--amber); padding:12px 16px; border-radius:6px;
                 box-shadow:0 0 20px rgba(251,191,36,.25); max-width:320px; }
        .toast b { color:#fff; }

        @media (max-width:600px) { .stats{grid-template-columns:1fr;} .grid2{grid-template-columns:1fr;} }
    </style>
</head>
<body>
    @auth
    <header class="topbar">
        <p class="brand">remind-me<span>@system</span>:~$<i class="cursor"></i></p>
        <div class="userbox">
            <nav class="navlinks">
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.users.index') }}">users</a>
                @endif
                <a href="{{ route('activities.index') }}">activities</a>
                <a href="{{ route('requests.index') }}">requests</a>
            </nav>
            <span>user: <b>{{ auth()->user()->name }}</b></span>
            <form method="POST" action="{{ route('logout') }}" style="margin:0">
                @csrf
                <button type="submit" class="btn btn-ghost">logout</button>
            </form>
        </div>
    </header>
    @endauth

    <main>
        @if (session('success') || session('notice'))
            <div class="alert alert-ok">{{ session('success') ?? session('notice') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-err">{{ $errors->first() }}</div>
        @endif
        @yield('content')
    </main>

    <div id="toasts"></div>
    @stack('scripts')
</body>
</html>