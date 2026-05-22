<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Login — RS MedikaCare</title>
<meta name="description" content="Login ke sistem informasi RS MedikaCare untuk mengakses layanan kesehatan.">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box}
:root{--cyan:#06b6d4;--cyan-dark:#0e7490;--teal:#0d9488;--green-light:#ecfdf5;--green:#10b981;--pink:#f472b6;--dark:#0f172a;--gray:#64748b;--white:#fff;--red:#ef4444}
html{height:100%}
body{font-family:'DM Sans',sans-serif;color:#1e293b;height:100%;overflow-x:hidden}
h1,h2,h3,h4{font-family:'Plus Jakarta Sans',sans-serif}
a{text-decoration:none;color:inherit}

/* LAYOUT */
.login-wrapper{display:flex;min-height:100vh}

/* LEFT PANEL */
.left-panel{width:40%;background:linear-gradient(135deg,var(--cyan-dark) 0%,var(--teal) 100%);position:relative;display:flex;flex-direction:column;justify-content:center;padding:60px 48px;color:#fff;overflow:hidden}
.left-panel::before{content:'';position:absolute;inset:0;background-image:radial-gradient(rgba(255,255,255,.07) 1px,transparent 1px);background-size:22px 22px;pointer-events:none}
.left-logo{display:flex;align-items:center;gap:10px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:1.2rem;margin-bottom:48px;position:relative;z-index:2}
.left-logo svg{width:30px;height:30px;flex-shrink:0}
.left-illustration{position:relative;z-index:2;margin-bottom:40px;display:flex;justify-content:center}
.left-illustration svg{width:220px;height:auto;opacity:.92}
.left-text{position:relative;z-index:2}
.left-text h2{font-size:1.8rem;font-weight:800;margin-bottom:10px;line-height:1.3}
.left-text p{font-size:.95rem;opacity:.78;line-height:1.6;margin-bottom:28px}
.features{list-style:none;display:flex;flex-direction:column;gap:14px;position:relative;z-index:2}
.features li{display:flex;align-items:center;gap:12px;font-size:.92rem;font-weight:500}
.check-icon{width:22px;height:22px;border-radius:50%;background:rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;flex-shrink:0}
.check-icon svg{width:12px;height:12px}

/* RIGHT PANEL */
.right-panel{flex:1;display:flex;align-items:center;justify-content:center;padding:40px 24px;background:#fff;position:relative}
.form-container{width:100%;max-width:420px;animation:slideIn .6s ease-out}
@keyframes slideIn{from{opacity:0;transform:translateX(30px)}to{opacity:1;transform:translateX(0)}}

.form-container h1{font-size:1.75rem;font-weight:800;color:var(--dark);margin-bottom:8px}
.form-sub{color:var(--gray);font-size:.92rem;margin-bottom:32px}
.form-sub a{color:var(--cyan);font-weight:600;transition:color .2s}
.form-sub a:hover{color:var(--cyan-dark)}

/* ALERT */
.alert{padding:14px 18px;border-radius:10px;margin-bottom:20px;font-size:.9rem;line-height:1.5;display:flex;align-items:flex-start;gap:10px;animation:fadeAlert .4s ease}
.alert-error{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}
.alert-error svg{flex-shrink:0;margin-top:1px}
.alert-success{background:#f0fdf4;color:#166534;border:1px solid #bbf7d0}
@keyframes fadeAlert{from{opacity:0;transform:translateY(-8px)}to{opacity:1;transform:translateY(0)}}

/* FORM */
.input-group{position:relative;margin-bottom:22px}
.input-group label{display:block;font-size:.82rem;font-weight:600;color:#475569;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px}
.input-wrap{position:relative}
.input-wrap svg{position:absolute;left:14px;top:50%;transform:translateY(-50%);width:18px;height:18px;color:#94a3b8;pointer-events:none}
.input-wrap input{width:100%;padding:13px 14px 13px 44px;border:2px solid #e2e8f0;border-radius:10px;font-size:.95rem;font-family:'DM Sans',sans-serif;color:var(--dark);background:#f8fafc;transition:all .25s;outline:none}
.input-wrap input:focus{border-color:var(--cyan);background:#fff;box-shadow:0 0 0 3px rgba(6,182,212,.12)}
.input-wrap input::placeholder{color:#94a3b8}
.toggle-pw{position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94a3b8;padding:2px;transition:color .2s}
.toggle-pw:hover{color:var(--cyan)}
.toggle-pw svg{width:18px;height:18px}

.form-options{display:flex;justify-content:space-between;align-items:center;margin-bottom:28px;font-size:.88rem}
.remember{display:flex;align-items:center;gap:8px;cursor:pointer;color:#475569;font-weight:500}
.remember input[type=checkbox]{width:16px;height:16px;accent-color:var(--cyan);cursor:pointer}
.forgot{color:var(--cyan);font-weight:600;transition:color .2s}
.forgot:hover{color:var(--cyan-dark)}

/* BUTTONS */
.btn-login{width:100%;padding:14px;border:none;border-radius:10px;background:linear-gradient(135deg,var(--cyan-dark),var(--teal));color:#fff;font-size:1rem;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;cursor:pointer;transition:all .25s;position:relative;overflow:hidden}
.btn-login:hover{box-shadow:0 8px 24px rgba(6,182,212,.35);transform:translateY(-2px)}
.btn-login:active{transform:translateY(0)}
.btn-login.loading{pointer-events:none;opacity:.8}
.btn-login.loading .btn-text{visibility:hidden}
.btn-login .spinner{display:none;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:22px;height:22px;border:3px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .6s linear infinite}
.btn-login.loading .spinner{display:block}
@keyframes spin{to{transform:translate(-50%,-50%) rotate(360deg)}}

.divider{display:flex;align-items:center;gap:14px;margin:24px 0;color:#cbd5e1;font-size:.82rem;font-weight:500}
.divider::before,.divider::after{content:'';flex:1;height:1px;background:#e2e8f0}

.btn-home{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:13px;border:2px solid #e2e8f0;border-radius:10px;background:#fff;color:#475569;font-size:.92rem;font-weight:600;font-family:'DM Sans',sans-serif;cursor:pointer;transition:all .25s}
.btn-home:hover{border-color:var(--cyan);color:var(--cyan);transform:translateY(-1px)}
.btn-home svg{width:16px;height:16px}

/* RESPONSIVE */
@media(max-width:768px){
.left-panel{display:none}
.right-panel{padding:32px 20px}
.form-container{max-width:100%}
}
@media(min-width:769px) and (max-width:1024px){
.left-panel{width:35%;padding:40px 32px}
.left-illustration svg{width:170px}
.left-text h2{font-size:1.5rem}
}
</style>
</head>
<body>
<div class="login-wrapper">

  <!-- LEFT DECORATIVE PANEL -->
  <div class="left-panel">
    <a href="<?= base_url('/') ?>" class="left-logo">
      <svg viewBox="0 0 32 32" fill="none"><rect x="4" y="8" width="24" height="18" rx="3" stroke="#fff" stroke-width="2"/><path d="M16 12v8M12 16h8" stroke="#fff" stroke-width="2" stroke-linecap="round"/><path d="M10 8V6a2 2 0 012-2h8a2 2 0 012 2v2" stroke="#fff" stroke-width="2"/></svg>
      RS MedikaCare
    </a>

    <div class="left-illustration">
      <svg viewBox="0 0 300 260" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Hospital Building -->
        <rect x="75" y="80" width="150" height="140" rx="8" fill="rgba(255,255,255,.12)" stroke="rgba(255,255,255,.3)" stroke-width="2"/>
        <rect x="115" y="60" width="70" height="160" rx="6" fill="rgba(255,255,255,.18)" stroke="rgba(255,255,255,.35)" stroke-width="2"/>
        <!-- Cross -->
        <rect x="140" y="75" width="20" height="40" rx="3" fill="rgba(255,255,255,.6)"/>
        <rect x="130" y="85" width="40" height="20" rx="3" fill="rgba(255,255,255,.6)"/>
        <!-- Windows -->
        <rect x="95" y="110" width="22" height="22" rx="4" fill="rgba(255,255,255,.15)" stroke="rgba(255,255,255,.25)" stroke-width="1.5"/>
        <rect x="95" y="150" width="22" height="22" rx="4" fill="rgba(255,255,255,.15)" stroke="rgba(255,255,255,.25)" stroke-width="1.5"/>
        <rect x="183" y="110" width="22" height="22" rx="4" fill="rgba(255,255,255,.15)" stroke="rgba(255,255,255,.25)" stroke-width="1.5"/>
        <rect x="183" y="150" width="22" height="22" rx="4" fill="rgba(255,255,255,.15)" stroke="rgba(255,255,255,.25)" stroke-width="1.5"/>
        <!-- Door -->
        <rect x="130" y="185" width="40" height="35" rx="4" fill="rgba(255,255,255,.2)" stroke="rgba(255,255,255,.35)" stroke-width="1.5"/>
        <circle cx="162" cy="203" r="3" fill="rgba(255,255,255,.5)"/>
        <!-- Doctor figure -->
        <circle cx="52" cy="155" r="14" fill="rgba(255,255,255,.2)" stroke="rgba(255,255,255,.35)" stroke-width="1.5"/>
        <path d="M52 169c-12 0-20 8-20 18v15h40v-15c0-10-8-18-20-18z" fill="rgba(255,255,255,.15)" stroke="rgba(255,255,255,.3)" stroke-width="1.5"/>
        <rect x="43" y="145" width="18" height="4" rx="2" fill="rgba(255,255,255,.35)"/>
        <!-- Stethoscope hint -->
        <path d="M44 175c0 6 4 10 8 10s8-4 8-10" stroke="rgba(255,255,255,.3)" stroke-width="1.5" fill="none" stroke-linecap="round"/>
        <!-- Heartbeat line -->
        <path d="M240 150 l10 0 l5-20 l10 40 l10-40 l5 20 l10 0" stroke="rgba(255,255,255,.35)" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
        <!-- Small Plus signs -->
        <g opacity=".3" stroke="#fff" stroke-width="1.5" stroke-linecap="round">
          <path d="M250 90v8M246 94h8"/>
          <path d="M40 100v6M37 103h6"/>
          <path d="M260 200v6M257 203h6"/>
        </g>
      </svg>
    </div>

    <div class="left-text">
      <h2>Selamat Datang Kembali</h2>
      <p>Akses layanan kesehatan RS MedikaCare dengan mudah melalui portal digital kami.</p>
    </div>

    <ul class="features">
      <li>
        <span class="check-icon"><svg viewBox="0 0 12 12" fill="none"><path d="M2.5 6l2.5 2.5 4.5-5" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
        Booking Online 24/7
      </li>
      <li>
        <span class="check-icon"><svg viewBox="0 0 12 12" fill="none"><path d="M2.5 6l2.5 2.5 4.5-5" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
        Rekam Medis Digital
      </li>
      <li>
        <span class="check-icon"><svg viewBox="0 0 12 12" fill="none"><path d="M2.5 6l2.5 2.5 4.5-5" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
        Konsultasi Mudah
      </li>
    </ul>
  </div>

  <!-- RIGHT FORM PANEL -->
  <div class="right-panel">
    <div class="form-container">

      <h1>Masuk ke Akun Anda</h1>
      <p class="form-sub">Belum punya akun? <a href="<?= base_url('register') ?>">Daftar sekarang</a></p>

      <!-- Flash Messages -->
      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error">
          <svg viewBox="0 0 20 20" fill="currentColor" width="18" height="18"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/></svg>
          <span><?= session()->getFlashdata('error') ?></span>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
          <span><?= session()->getFlashdata('success') ?></span>
        </div>
      <?php endif; ?>

      <form action="<?= base_url('login') ?>" method="POST" id="loginForm">
        <?= csrf_field() ?>

        <div class="input-group">
          <label for="username">Username</label>
          <div class="input-wrap">
            <svg viewBox="0 0 20 20" fill="currentColor"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/></svg>
            <input type="text" id="username" name="username" placeholder="Masukkan username" required autocomplete="username">
          </div>
        </div>

        <div class="input-group">
          <label for="password">Password</label>
          <div class="input-wrap">
            <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required autocomplete="current-password">
            <button type="button" class="toggle-pw" id="togglePw" aria-label="Tampilkan password">
              <svg id="eyeOpen" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
              <svg id="eyeClosed" viewBox="0 0 20 20" fill="currentColor" style="display:none"><path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"/><path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"/></svg>
            </button>
          </div>
        </div>

        <div class="form-options">
          <label class="remember">
            <input type="checkbox" name="remember"> Ingat Saya
          </label>
          <a href="#" class="forgot">Lupa Password?</a>
        </div>

        <button type="submit" class="btn-login" id="btnLogin">
          <span class="btn-text">Masuk</span>
          <span class="spinner"></span>
        </button>
      </form>

      <div class="divider">atau</div>

      <a href="<?= base_url('/') ?>" class="btn-home">
        <svg viewBox="0 0 20 20" fill="currentColor"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
        Kembali ke Beranda
      </a>

    </div>
  </div>
</div>

<script>
// Toggle password visibility
const toggle=document.getElementById('togglePw');
const pwInput=document.getElementById('password');
const eyeO=document.getElementById('eyeOpen');
const eyeC=document.getElementById('eyeClosed');
toggle.addEventListener('click',()=>{
  const show=pwInput.type==='password';
  pwInput.type=show?'text':'password';
  eyeO.style.display=show?'none':'block';
  eyeC.style.display=show?'block':'none';
});

// Loading state on submit
document.getElementById('loginForm').addEventListener('submit',function(){
  const btn=document.getElementById('btnLogin');
  btn.classList.add('loading');
});
</script>
</body>
</html>
