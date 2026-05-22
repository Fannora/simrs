<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Daftar — RS MedikaCare</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box}
:root{--pink:#ec4899;--rose:#f43f5e;--cyan:#06b6d4;--cyan-dark:#0e7490;--teal:#0d9488;--dark:#0f172a;--gray:#64748b;--white:#fff}
html{height:100%}
body{font-family:'DM Sans',sans-serif;color:#1e293b;min-height:100%}
h1,h2,h3,h4{font-family:'Plus Jakarta Sans',sans-serif}
a{text-decoration:none;color:inherit}

.reg-wrapper{display:flex;min-height:100vh}

/* LEFT */
.left{width:38%;background:linear-gradient(135deg,var(--pink),var(--rose));position:relative;display:flex;flex-direction:column;justify-content:center;padding:50px 40px;color:#fff;overflow:hidden}
.left::before{content:'';position:absolute;inset:0;background-image:radial-gradient(rgba(255,255,255,.07) 1px,transparent 1px);background-size:22px 22px}
.left-logo{display:flex;align-items:center;gap:10px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:1.15rem;margin-bottom:40px;position:relative;z-index:2}
.left-logo svg{width:28px;height:28px;flex-shrink:0}
.left-illust{position:relative;z-index:2;display:flex;justify-content:center;margin-bottom:36px}
.left-illust svg{width:200px;opacity:.9}
.left h2{font-size:1.7rem;font-weight:800;margin-bottom:10px;position:relative;z-index:2;line-height:1.3}
.left>p{font-size:.92rem;opacity:.78;line-height:1.6;margin-bottom:24px;position:relative;z-index:2}
.feat{list-style:none;display:flex;flex-direction:column;gap:12px;position:relative;z-index:2}
.feat li{display:flex;align-items:center;gap:10px;font-size:.9rem;font-weight:500}
.ck{width:22px;height:22px;border-radius:50%;background:rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;flex-shrink:0}
.ck svg{width:12px;height:12px}

/* RIGHT */
.right{flex:1;display:flex;align-items:center;justify-content:center;padding:40px 24px;background:#fff;overflow-y:auto}
.form-box{width:100%;max-width:520px;animation:slideIn .6s ease-out}
@keyframes slideIn{from{opacity:0;transform:translateX(30px)}to{opacity:1;transform:translateX(0)}}
.form-box h1{font-size:1.65rem;font-weight:800;color:var(--dark);margin-bottom:6px}
.form-sub{color:var(--gray);font-size:.9rem;margin-bottom:28px}
.form-sub a{color:var(--pink);font-weight:600}
.form-sub a:hover{color:var(--rose)}

/* ALERT */
.alert{padding:12px 16px;border-radius:10px;margin-bottom:18px;font-size:.88rem;line-height:1.5;display:flex;align-items:flex-start;gap:10px;animation:fadeA .4s ease}
.alert-error{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}
.alert-success{background:#f0fdf4;color:#166534;border:1px solid #bbf7d0}
@keyframes fadeA{from{opacity:0;transform:translateY(-8px)}to{opacity:1;transform:translateY(0)}}

/* GRID */
.row{display:grid;grid-template-columns:1fr 1fr;gap:0 18px}
.full{grid-column:1/-1}

/* INPUTS */
.fg{margin-bottom:18px}
.fg label{display:block;font-size:.8rem;font-weight:600;color:#475569;margin-bottom:5px;text-transform:uppercase;letter-spacing:.4px}
.fg .opt{font-weight:400;text-transform:none;letter-spacing:0;color:#94a3b8;font-size:.75rem}
.iw{position:relative}
.iw svg.ico{position:absolute;left:12px;top:50%;transform:translateY(-50%);width:17px;height:17px;color:#94a3b8;pointer-events:none}
.iw input,.iw textarea,.iw select{width:100%;padding:12px 12px 12px 40px;border:2px solid #e2e8f0;border-radius:10px;font-size:.92rem;font-family:'DM Sans',sans-serif;color:var(--dark);background:#f8fafc;transition:all .25s;outline:none}
.iw textarea{padding-left:12px;min-height:70px;resize:vertical}
.iw input:focus,.iw textarea:focus{border-color:var(--pink);background:#fff;box-shadow:0 0 0 3px rgba(236,72,153,.1)}
.iw input::placeholder,.iw textarea::placeholder{color:#94a3b8}
.toggle-pw{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94a3b8;padding:2px}
.toggle-pw:hover{color:var(--pink)}
.toggle-pw svg{width:17px;height:17px}

/* GENDER TOGGLE */
.gender-toggle{display:flex;gap:10px}
.gender-toggle label{flex:1;display:flex;align-items:center;justify-content:center;gap:8px;padding:11px;border:2px solid #e2e8f0;border-radius:10px;cursor:pointer;font-size:.9rem;font-weight:500;color:#64748b;background:#f8fafc;transition:all .25s}
.gender-toggle input{display:none}
.gender-toggle input:checked+span{background:transparent}
.gender-toggle label:has(input:checked){border-color:var(--pink);color:var(--pink);background:#fdf2f8}

/* STRENGTH */
.pw-strength{margin-top:6px;display:flex;align-items:center;gap:8px}
.pw-bar{flex:1;height:4px;background:#e2e8f0;border-radius:4px;overflow:hidden}
.pw-bar-fill{height:100%;width:0;border-radius:4px;transition:all .3s}
.pw-label{font-size:.75rem;font-weight:600;min-width:50px}
.str-weak .pw-bar-fill{width:33%;background:#ef4444}
.str-weak .pw-label{color:#ef4444}
.str-med .pw-bar-fill{width:66%;background:#f59e0b}
.str-med .pw-label{color:#f59e0b}
.str-strong .pw-bar-fill{width:100%;background:#10b981}
.str-strong .pw-label{color:#10b981}

/* MATCH */
.match-info{font-size:.78rem;margin-top:5px;font-weight:600;display:none}
.match-ok{color:#10b981}
.match-no{color:#ef4444}

/* BUTTON */
.btn-reg{width:100%;padding:14px;border:none;border-radius:10px;background:linear-gradient(135deg,var(--pink),var(--rose));color:#fff;font-size:1rem;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;cursor:pointer;transition:all .25s;position:relative;overflow:hidden;margin-top:6px}
.btn-reg:hover{box-shadow:0 8px 24px rgba(236,72,153,.3);transform:translateY(-2px)}
.btn-reg.loading{pointer-events:none;opacity:.8}
.btn-reg.loading .bt{visibility:hidden}
.btn-reg .sp{display:none;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:22px;height:22px;border:3px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .6s linear infinite}
.btn-reg.loading .sp{display:block}
@keyframes spin{to{transform:translate(-50%,-50%) rotate(360deg)}}

.divider{display:flex;align-items:center;gap:14px;margin:20px 0;color:#cbd5e1;font-size:.8rem;font-weight:500}
.divider::before,.divider::after{content:'';flex:1;height:1px;background:#e2e8f0}
.btn-back{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:12px;border:2px solid #e2e8f0;border-radius:10px;background:#fff;color:#475569;font-size:.9rem;font-weight:600;font-family:'DM Sans',sans-serif;cursor:pointer;transition:all .25s}
.btn-back:hover{border-color:var(--pink);color:var(--pink)}
.btn-back svg{width:16px;height:16px}

@media(max-width:768px){
.left{display:none}
.right{padding:28px 18px}
.row{grid-template-columns:1fr}
}
</style>
</head>
<body>
<div class="reg-wrapper">

  <!-- LEFT -->
  <div class="left">
    <a href="<?= base_url('/') ?>" class="left-logo">
      <svg viewBox="0 0 32 32" fill="none"><rect x="4" y="8" width="24" height="18" rx="3" stroke="#fff" stroke-width="2"/><path d="M16 12v8M12 16h8" stroke="#fff" stroke-width="2" stroke-linecap="round"/><path d="M10 8V6a2 2 0 012-2h8a2 2 0 012 2v2" stroke="#fff" stroke-width="2"/></svg>
      RS MedikaCare
    </a>
    <div class="left-illust">
      <svg viewBox="0 0 280 240" fill="none">
        <rect x="70" y="70" width="140" height="130" rx="8" fill="rgba(255,255,255,.12)" stroke="rgba(255,255,255,.3)" stroke-width="2"/>
        <rect x="105" y="50" width="70" height="150" rx="6" fill="rgba(255,255,255,.18)" stroke="rgba(255,255,255,.35)" stroke-width="2"/>
        <rect x="130" y="65" width="20" height="36" rx="3" fill="rgba(255,255,255,.55)"/>
        <rect x="122" y="74" width="36" height="18" rx="3" fill="rgba(255,255,255,.55)"/>
        <rect x="88" y="105" width="20" height="20" rx="4" fill="rgba(255,255,255,.13)" stroke="rgba(255,255,255,.22)" stroke-width="1.5"/>
        <rect x="88" y="140" width="20" height="20" rx="4" fill="rgba(255,255,255,.13)" stroke="rgba(255,255,255,.22)" stroke-width="1.5"/>
        <rect x="172" y="105" width="20" height="20" rx="4" fill="rgba(255,255,255,.13)" stroke="rgba(255,255,255,.22)" stroke-width="1.5"/>
        <rect x="172" y="140" width="20" height="20" rx="4" fill="rgba(255,255,255,.13)" stroke="rgba(255,255,255,.22)" stroke-width="1.5"/>
        <rect x="122" y="170" width="36" height="30" rx="4" fill="rgba(255,255,255,.18)" stroke="rgba(255,255,255,.3)" stroke-width="1.5"/>
        <!-- Person with clipboard -->
        <circle cx="240" cy="110" r="12" fill="rgba(255,255,255,.18)" stroke="rgba(255,255,255,.3)" stroke-width="1.5"/>
        <path d="M240 122c-10 0-17 7-17 15v12h34v-12c0-8-7-15-17-15z" fill="rgba(255,255,255,.13)" stroke="rgba(255,255,255,.25)" stroke-width="1.5"/>
        <rect x="230" y="148" width="20" height="26" rx="3" fill="rgba(255,255,255,.12)" stroke="rgba(255,255,255,.25)" stroke-width="1.5"/>
        <line x1="234" y1="155" x2="246" y2="155" stroke="rgba(255,255,255,.3)" stroke-width="1"/>
        <line x1="234" y1="160" x2="246" y2="160" stroke="rgba(255,255,255,.3)" stroke-width="1"/>
        <line x1="234" y1="165" x2="242" y2="165" stroke="rgba(255,255,255,.3)" stroke-width="1"/>
        <g opacity=".3" stroke="#fff" stroke-width="1.5" stroke-linecap="round">
          <path d="M40 80v6M37 83h6"/><path d="M30 170v6M27 173h6"/><path d="M250 60v6M247 63h6"/>
        </g>
      </svg>
    </div>
    <h2>Bergabung Bersama Kami</h2>
    <p>Daftar sekarang dan nikmati kemudahan layanan kesehatan digital RS MedikaCare.</p>
    <ul class="feat">
      <li><span class="ck"><svg viewBox="0 0 12 12" fill="none"><path d="M2.5 6l2.5 2.5 4.5-5" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></span>Booking Online 24/7</li>
      <li><span class="ck"><svg viewBox="0 0 12 12" fill="none"><path d="M2.5 6l2.5 2.5 4.5-5" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></span>Rekam Medis Digital</li>
      <li><span class="ck"><svg viewBox="0 0 12 12" fill="none"><path d="M2.5 6l2.5 2.5 4.5-5" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></span>Konsultasi Mudah</li>
    </ul>
  </div>

  <!-- RIGHT -->
  <div class="right">
    <div class="form-box">
      <h1>Buat Akun Baru</h1>
      <p class="form-sub">Sudah punya akun? <a href="<?= base_url('login') ?>">Masuk di sini</a></p>

      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error"><span><?= session()->getFlashdata('error') ?></span></div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><span><?= session()->getFlashdata('success') ?></span></div>
      <?php endif; ?>

      <form action="<?= base_url('register') ?>" method="POST" id="regForm">
        <?= csrf_field() ?>

        <!-- Nama Lengkap -->
        <div class="fg full">
          <label>Nama Lengkap</label>
          <div class="iw">
            <svg class="ico" viewBox="0 0 20 20" fill="currentColor"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/></svg>
            <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap" required>
          </div>
        </div>

        <!-- NIK -->
        <div class="fg full">
          <label>NIK (Nomor Induk Kependudukan)</label>
          <div class="iw">
            <svg class="ico" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm3 1h6v2H7V5zm0 4h6v2H7V9zm0 4h4v2H7v-2z" clip-rule="evenodd"/></svg>
            <input type="text" name="nik" placeholder="16 digit NIK" maxlength="16" id="nikInput" required>
          </div>
        </div>

        <div class="row">
          <!-- Tanggal Lahir -->
          <div class="fg">
            <label>Tanggal Lahir</label>
            <div class="iw">
              <svg class="ico" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
              <input type="date" name="tgl_lahir" required>
            </div>
          </div>

          <!-- Jenis Kelamin -->
          <div class="fg">
            <label>Jenis Kelamin</label>
            <div class="gender-toggle">
              <label><input type="radio" name="jk" value="Laki-laki" required>Laki-laki</label>
              <label><input type="radio" name="jk" value="Perempuan">Perempuan</label>
            </div>
          </div>
        </div>

        <!-- Alamat -->
        <div class="fg full">
          <label>Alamat</label>
          <div class="iw">
            <textarea name="alamat" placeholder="Masukkan alamat lengkap" required></textarea>
          </div>
        </div>

        <!-- No BPJS -->
        <div class="fg full">
          <label>No. BPJS <span class="opt">(opsional)</span></label>
          <div class="iw">
            <svg class="ico" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 2L3 7v9a2 2 0 002 2h10a2 2 0 002-2V7l-7-5zM9 9h2v5H9V9zm0-3h2v2H9V6z" clip-rule="evenodd"/></svg>
            <input type="text" name="no_bpjs" placeholder="Nomor BPJS (jika ada)">
          </div>
        </div>

        <hr style="border:none;border-top:1px solid #e2e8f0;margin:8px 0 20px">

        <!-- Username -->
        <div class="fg full">
          <label>Username</label>
          <div class="iw">
            <svg class="ico" viewBox="0 0 20 20" fill="currentColor"><path d="M2.003 5.884L10 10.882l7.997-4.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884zM18 8.118l-8 5-8-5V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
            <input type="text" name="username" placeholder="Pilih username" required>
          </div>
        </div>

        <!-- Password -->
        <div class="fg full">
          <label>Password</label>
          <div class="iw">
            <svg class="ico" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
            <input type="password" name="password" id="pw" placeholder="Buat password" required>
            <button type="button" class="toggle-pw" onclick="togPw('pw',this)"><svg viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg></button>
          </div>
          <div class="pw-strength" id="pwStr">
            <div class="pw-bar"><div class="pw-bar-fill"></div></div>
            <span class="pw-label"></span>
          </div>
        </div>

        <!-- Konfirmasi Password -->
        <div class="fg full">
          <label>Konfirmasi Password</label>
          <div class="iw">
            <svg class="ico" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
            <input type="password" name="konfirmasi_password" id="cpw" placeholder="Ulangi password" required>
            <button type="button" class="toggle-pw" onclick="togPw('cpw',this)"><svg viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg></button>
          </div>
          <div class="match-info" id="matchInfo"></div>
        </div>

        <button type="submit" class="btn-reg" id="btnReg">
          <span class="bt">Daftar</span><span class="sp"></span>
        </button>
      </form>

      <div class="divider">atau</div>
      <a href="<?= base_url('/') ?>" class="btn-back">
        <svg viewBox="0 0 20 20" fill="currentColor"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
        Kembali ke Beranda
      </a>
    </div>
  </div>
</div>

<script>
// NIK: digits only
document.getElementById('nikInput').addEventListener('input',function(){this.value=this.value.replace(/\D/g,'')});

// Toggle password
function togPw(id,btn){var i=document.getElementById(id);i.type=i.type==='password'?'text':'password'}

// Password strength
document.getElementById('pw').addEventListener('input',function(){
  var v=this.value,s=document.getElementById('pwStr'),c='';
  if(!v){s.className='pw-strength';s.querySelector('.pw-label').textContent='';return}
  var score=0;
  if(v.length>=6)score++;if(v.length>=10)score++;if(/[A-Z]/.test(v))score++;if(/[0-9]/.test(v))score++;if(/[^A-Za-z0-9]/.test(v))score++;
  if(score<=2)c='str-weak';else if(score<=3)c='str-med';else c='str-strong';
  s.className='pw-strength '+c;
  s.querySelector('.pw-label').textContent=c==='str-weak'?'Lemah':c==='str-med'?'Sedang':'Kuat';
  checkMatch();
});

// Confirm password match
document.getElementById('cpw').addEventListener('input',checkMatch);
function checkMatch(){
  var pw=document.getElementById('pw').value,cpw=document.getElementById('cpw').value,el=document.getElementById('matchInfo');
  if(!cpw){el.style.display='none';return}
  el.style.display='block';
  if(pw===cpw){el.className='match-info match-ok';el.textContent='✓ Password cocok'}
  else{el.className='match-info match-no';el.textContent='✗ Password tidak cocok'}
}

// Loading on submit
document.getElementById('regForm').addEventListener('submit',function(e){
  var pw=document.getElementById('pw').value,cpw=document.getElementById('cpw').value;
  if(pw!==cpw){e.preventDefault();alert('Password dan konfirmasi password tidak cocok!');return}
  document.getElementById('btnReg').classList.add('loading');
});
</script>
</body>
</html>
