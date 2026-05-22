<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>RS MedikaCare — Sistem Informasi Rumah Sakit</title>
<meta name="description" content="RS MedikaCare - Layanan kesehatan terbaik dengan dokter profesional berpengalaman. Booking online mudah dan cepat.">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box}
:root{--cyan:#06b6d4;--cyan-dark:#0e7490;--teal:#0d9488;--green-light:#ecfdf5;--green:#10b981;--pink:#f472b6;--dark:#0f172a;--gray:#64748b;--white:#fff}
html{scroll-behavior:smooth}
body{font-family:'DM Sans',sans-serif;color:#1e293b;overflow-x:hidden}
h1,h2,h3,h4{font-family:'Plus Jakarta Sans',sans-serif}
a{text-decoration:none;color:inherit}
.container{max-width:1200px;margin:0 auto;padding:0 24px}

/* NAVBAR */
.navbar{position:fixed;top:0;left:0;width:100%;z-index:1000;background:var(--cyan);padding:12px 0;transition:box-shadow .3s}
.navbar.scrolled{box-shadow:0 4px 20px rgba(0,0,0,.15)}
.nav-inner{display:flex;align-items:center;justify-content:space-between}
.nav-logo{display:flex;align-items:center;gap:10px;color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:1.25rem}
.nav-logo svg{width:32px;height:32px}
.nav-links{display:flex;align-items:center;gap:28px;list-style:none}
.nav-links a{color:rgba(255,255,255,.85);font-size:.95rem;font-weight:500;transition:color .2s}
.nav-links a:hover{color:#fff}
.nav-btns{display:flex;gap:10px}
.btn{display:inline-flex;align-items:center;justify-content:center;padding:10px 22px;border-radius:8px;font-weight:600;font-size:.9rem;cursor:pointer;transition:all .2s;border:2px solid transparent;font-family:'DM Sans',sans-serif}
.btn-outline-w{color:#fff;border-color:rgba(255,255,255,.5);background:transparent}
.btn-outline-w:hover{background:rgba(255,255,255,.15);border-color:#fff}
.btn-filled{background:#fff;color:var(--cyan);border-color:#fff}
.btn-filled:hover{transform:translateY(-2px);box-shadow:0 4px 15px rgba(255,255,255,.3)}
.btn-cyan{background:var(--cyan);color:#fff;border-color:var(--cyan)}
.btn-cyan:hover{background:var(--cyan-dark);transform:translateY(-2px);box-shadow:0 4px 15px rgba(6,182,212,.4)}
.hamburger{display:none;flex-direction:column;gap:5px;cursor:pointer;background:none;border:none;padding:4px}
.hamburger span{display:block;width:24px;height:2.5px;background:#fff;border-radius:2px;transition:all .3s}

/* HERO */
.hero{padding:140px 0 100px;background:linear-gradient(135deg,var(--cyan-dark) 0%,var(--teal) 100%);position:relative;overflow:hidden}
.hero::before{content:'';position:absolute;inset:0;background-image:radial-gradient(rgba(255,255,255,.08) 1px,transparent 1px);background-size:24px 24px}
.hero-grid{display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;position:relative;z-index:2}
.hero h1{font-size:3.2rem;font-weight:800;color:#fff;line-height:1.2;margin-bottom:18px}
.hero p{color:rgba(255,255,255,.85);font-size:1.15rem;line-height:1.7;margin-bottom:32px;max-width:500px}
.hero-btns{display:flex;gap:14px;flex-wrap:wrap}
.stats-area{display:flex;flex-direction:column;gap:18px;align-items:flex-end}
.stat-card{background:rgba(255,255,255,.12);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,.18);border-radius:16px;padding:20px 28px;color:#fff;min-width:220px;animation:float 3s ease-in-out infinite}
.stat-card:nth-child(2){animation-delay:.5s}
.stat-card:nth-child(3){animation-delay:1s}
.stat-card .num{font-family:'Plus Jakarta Sans',sans-serif;font-size:1.6rem;font-weight:800}
.stat-card .label{font-size:.85rem;opacity:.8;margin-top:2px}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
.hero-wave{position:absolute;bottom:-2px;left:0;width:100%}
.hero-wave svg{display:block;width:100%}

/* SECTIONS COMMON */
.section{padding:90px 0}
.section-title{text-align:center;font-size:2.2rem;font-weight:800;color:var(--dark);margin-bottom:14px}
.section-sub{text-align:center;color:var(--gray);font-size:1.05rem;margin-bottom:50px;max-width:560px;margin-left:auto;margin-right:auto}

/* LAYANAN */
.services-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.svc-card{background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:32px 24px;text-align:center;transition:all .3s;cursor:pointer}
.svc-card:hover{transform:translateY(-6px);box-shadow:0 12px 30px rgba(6,182,212,.12);border-color:var(--cyan)}
.svc-icon{width:64px;height:64px;border-radius:50%;background:linear-gradient(135deg,#ecfeff,#cffafe);display:inline-flex;align-items:center;justify-content:center;margin-bottom:18px;font-size:1.6rem;color:var(--cyan)}
.svc-card h3{font-size:1.15rem;font-weight:700;margin-bottom:8px;color:var(--dark)}
.svc-card p{font-size:.9rem;color:var(--gray);line-height:1.6;margin-bottom:16px}
.svc-link{color:var(--cyan);font-weight:600;font-size:.9rem}

/* BOOKING STEPS */
.booking-section{background:var(--green-light)}
.steps{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;position:relative}
.step{text-align:center;position:relative;padding:24px 16px}
.step-num{width:48px;height:48px;border-radius:50%;background:var(--cyan);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-weight:700;font-size:1.1rem;margin-bottom:14px;font-family:'Plus Jakarta Sans',sans-serif}
.step-icon{font-size:1.5rem;color:var(--cyan);margin-bottom:10px;display:block}
.step h4{font-size:1rem;font-weight:700;color:var(--dark);margin-bottom:6px}
.step p{font-size:.85rem;color:var(--gray);line-height:1.5}

/* DOKTER */
.doctors-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:28px}
.doc-card{background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:32px 24px;text-align:center;transition:all .3s}
.doc-card:hover{transform:translateY(-4px);box-shadow:0 12px 30px rgba(0,0,0,.08)}
.doc-avatar{width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,var(--cyan),var(--teal));display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:1.5rem;font-weight:700;margin-bottom:16px;font-family:'Plus Jakarta Sans',sans-serif}
.doc-card h3{font-size:1.1rem;font-weight:700;color:var(--dark)}
.doc-card .spec{color:var(--cyan);font-size:.9rem;font-weight:500;margin:4px 0 10px}
.stars{color:#fbbf24;font-size:.9rem;margin-bottom:16px}

/* TESTIMONIAL */
.testi-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.testi-card{background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:28px;transition:all .3s}
.testi-card:hover{box-shadow:0 8px 24px rgba(0,0,0,.06)}
.testi-avatar{width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,var(--pink),var(--cyan));display:inline-flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.9rem;margin-bottom:12px}
.testi-card .testi-stars{color:#fbbf24;font-size:.8rem;margin-bottom:10px}
.testi-card p{font-size:.92rem;color:#475569;line-height:1.6;font-style:italic;margin-bottom:12px}
.testi-card .testi-name{font-weight:600;color:var(--dark);font-size:.9rem}

/* CTA */
.cta{padding:80px 0;background:linear-gradient(135deg,var(--cyan-dark),var(--teal));text-align:center;color:#fff}
.cta h2{font-size:2.2rem;font-weight:800;margin-bottom:14px}
.cta p{opacity:.85;font-size:1.05rem;margin-bottom:30px;max-width:480px;margin-left:auto;margin-right:auto}

/* FOOTER */
footer{background:var(--dark);color:rgba(255,255,255,.7);padding:60px 0 0}
.footer-grid{display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:40px;padding-bottom:40px;border-bottom:1px solid rgba(255,255,255,.1)}
.footer-logo{font-family:'Plus Jakarta Sans',sans-serif;font-size:1.3rem;font-weight:800;color:#fff;margin-bottom:12px}
footer h4{color:#fff;font-size:1rem;font-weight:700;margin-bottom:16px;font-family:'Plus Jakarta Sans',sans-serif}
footer ul{list-style:none}
footer li{margin-bottom:10px}
footer li a{color:rgba(255,255,255,.6);font-size:.9rem;transition:color .2s}
footer li a:hover{color:var(--cyan)}
.footer-bottom{text-align:center;padding:24px 0;font-size:.85rem;color:rgba(255,255,255,.4)}

/* ANIMATIONS */
.fade-up{opacity:0;transform:translateY(30px);transition:all .6s ease}
.fade-up.visible{opacity:1;transform:translateY(0)}

/* MOBILE NAV */
.mobile-menu{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:var(--cyan-dark);z-index:999;flex-direction:column;align-items:center;justify-content:center;gap:24px}
.mobile-menu.active{display:flex}
.mobile-menu a{color:#fff;font-size:1.3rem;font-weight:600}
.mobile-close{position:absolute;top:20px;right:24px;background:none;border:none;color:#fff;font-size:2rem;cursor:pointer}

/* RESPONSIVE */
@media(max-width:768px){
.nav-links,.nav-btns{display:none}
.hamburger{display:flex}
.hero-grid{grid-template-columns:1fr;text-align:center}
.hero h1{font-size:2.2rem}
.hero p{margin-left:auto;margin-right:auto}
.hero-btns{justify-content:center}
.stats-area{align-items:center;margin-top:30px}
.services-grid,.doctors-grid,.testi-grid{grid-template-columns:1fr}
.steps{grid-template-columns:repeat(2,1fr)}
.footer-grid{grid-template-columns:1fr 1fr}
}
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar" id="navbar">
<div class="container nav-inner">
  <a href="<?= base_url('/') ?>" class="nav-logo">
    <svg viewBox="0 0 32 32" fill="none"><rect x="4" y="8" width="24" height="18" rx="3" stroke="#fff" stroke-width="2"/><path d="M16 12v8M12 16h8" stroke="#fff" stroke-width="2" stroke-linecap="round"/><path d="M10 8V6a2 2 0 012-2h8a2 2 0 012 2v2" stroke="#fff" stroke-width="2"/></svg>
    RS MedikaCare
  </a>
  <ul class="nav-links">
    <li><a href="#beranda">Beranda</a></li>
    <li><a href="#layanan">Layanan</a></li>
    <li><a href="#dokter">Dokter</a></li>
    <li><a href="#tentang">Tentang Kami</a></li>
    <li><a href="#kontak">Kontak</a></li>
  </ul>
  <div class="nav-btns">
    <a href="<?= base_url('login') ?>" class="btn btn-outline-w">Login</a>
    <a href="<?= base_url('login') ?>" class="btn btn-filled">Daftar Sekarang</a>
  </div>
  <button class="hamburger" id="hamburgerBtn" aria-label="Menu">
    <span></span><span></span><span></span>
  </button>
</div>
</nav>

<!-- MOBILE MENU -->
<div class="mobile-menu" id="mobileMenu">
  <button class="mobile-close" id="mobileClose">&times;</button>
  <a href="#beranda" onclick="closeMobile()">Beranda</a>
  <a href="#layanan" onclick="closeMobile()">Layanan</a>
  <a href="#dokter" onclick="closeMobile()">Dokter</a>
  <a href="#tentang" onclick="closeMobile()">Tentang Kami</a>
  <a href="#kontak" onclick="closeMobile()">Kontak</a>
  <a href="<?= base_url('login') ?>" class="btn btn-filled" style="margin-top:10px">Login</a>
</div>

<!-- HERO -->
<section class="hero" id="beranda">
<div class="container hero-grid">
  <div>
    <h1>Kesehatan Anda, Prioritas Kami</h1>
    <p>Dapatkan layanan medis terbaik dengan tim dokter profesional berpengalaman. Booking online mudah dan cepat.</p>
    <div class="hero-btns">
      <a href="<?= base_url('login') ?>" class="btn btn-filled">Booking Sekarang</a>
      <a href="#layanan" class="btn btn-outline-w">Lihat Layanan</a>
    </div>
  </div>
  <div class="stats-area">
    <div class="stat-card"><div class="num">150+</div><div class="label">Dokter Spesialis</div></div>
    <div class="stat-card"><div class="num">50.000+</div><div class="label">Pasien Terbantu</div></div>
    <div class="stat-card"><div class="num">15 Tahun</div><div class="label">Pengalaman</div></div>
  </div>
</div>
<div class="hero-wave">
  <svg viewBox="0 0 1440 100" preserveAspectRatio="none"><path d="M0,40 C360,100 1080,0 1440,60 L1440,100 L0,100Z" fill="#ffffff"/></svg>
</div>
</section>

<!-- LAYANAN -->
<section class="section" id="layanan">
<div class="container">
  <h2 class="section-title">Layanan Unggulan Kami</h2>
  <p class="section-sub">Kami menyediakan berbagai layanan kesehatan untuk memenuhi kebutuhan Anda dan keluarga.</p>
  <div class="services-grid">
    <div class="svc-card fade-up">
      <div class="svc-icon">&#x1FA7A;</div>
      <h3>Poli Umum</h3>
      <p>Pemeriksaan kesehatan umum dan konsultasi medis dengan dokter berpengalaman.</p>
      <span class="svc-link">Selengkapnya →</span>
    </div>
    <div class="svc-card fade-up">
      <div class="svc-icon">&#x1F9B7;</div>
      <h3>Poli Gigi</h3>
      <p>Perawatan gigi lengkap mulai dari pembersihan hingga bedah mulut.</p>
      <span class="svc-link">Selengkapnya →</span>
    </div>
    <div class="svc-card fade-up">
      <div class="svc-icon">&#x1F442;</div>
      <h3>Poli THT</h3>
      <p>Penanganan gangguan telinga, hidung, dan tenggorokan secara profesional.</p>
      <span class="svc-link">Selengkapnya →</span>
    </div>
    <div class="svc-card fade-up">
      <div class="svc-icon">&#x1F476;</div>
      <h3>Poli Anak</h3>
      <p>Layanan kesehatan anak dengan pendekatan ramah dan menyenangkan.</p>
      <span class="svc-link">Selengkapnya →</span>
    </div>
    <div class="svc-card fade-up">
      <div class="svc-icon">&#x2764;&#xFE0F;</div>
      <h3>Poli Kandungan</h3>
      <p>Pemeriksaan kehamilan dan kesehatan reproduksi wanita.</p>
      <span class="svc-link">Selengkapnya →</span>
    </div>
    <div class="svc-card fade-up">
      <div class="svc-icon">&#x1F497;</div>
      <h3>Poli Jantung</h3>
      <p>Diagnosis dan penanganan penyakit jantung oleh spesialis kardiovaskular.</p>
      <span class="svc-link">Selengkapnya →</span>
    </div>
  </div>
</div>
</section>

<!-- BOOKING STEPS -->
<section class="section booking-section" id="tentang">
<div class="container">
  <h2 class="section-title">Cara Booking Online</h2>
  <p class="section-sub">Booking jadwal dokter hanya dalam 4 langkah mudah.</p>
  <div class="steps">
    <div class="step fade-up">
      <div class="step-num">1</div>
      <span class="step-icon">&#x1F464;</span>
      <h4>Buat Akun</h4>
      <p>Daftar akun baru dengan data diri Anda.</p>
    </div>
    <div class="step fade-up">
      <div class="step-num">2</div>
      <span class="step-icon">&#x1F50D;</span>
      <h4>Pilih Dokter</h4>
      <p>Cari dokter spesialis sesuai kebutuhan.</p>
    </div>
    <div class="step fade-up">
      <div class="step-num">3</div>
      <span class="step-icon">&#x1F4C5;</span>
      <h4>Pilih Jadwal</h4>
      <p>Pilih tanggal dan jam yang tersedia.</p>
    </div>
    <div class="step fade-up">
      <div class="step-num">4</div>
      <span class="step-icon">&#x2705;</span>
      <h4>Konfirmasi Booking</h4>
      <p>Konfirmasi dan dapatkan tiket booking.</p>
    </div>
  </div>
</div>
</section>

<!-- DOKTER -->
<section class="section" id="dokter">
<div class="container">
  <h2 class="section-title">Tim Dokter Kami</h2>
  <p class="section-sub">Dokter profesional berpengalaman siap melayani Anda.</p>
  <div class="doctors-grid">
    <div class="doc-card fade-up">
      <div class="doc-avatar">AS</div>
      <h3>dr. Andi Setiawan, Sp.U</h3>
      <div class="spec">Poli Umum</div>
      <div class="stars">★★★★★</div>
      <a href="<?= base_url('login') ?>" class="btn btn-cyan">Buat Janji</a>
    </div>
    <div class="doc-card fade-up">
      <div class="doc-avatar">RA</div>
      <h3>dr. Rusdi Ambatukam, drg</h3>
      <div class="spec">Poli Gigi</div>
      <div class="stars">★★★★★</div>
      <a href="<?= base_url('login') ?>" class="btn btn-cyan">Buat Janji</a>
    </div>
    <div class="doc-card fade-up">
      <div class="doc-avatar">SD</div>
      <h3>dr. Sari Dewi, Sp.THT</h3>
      <div class="spec">Poli THT</div>
      <div class="stars">★★★★★</div>
      <a href="<?= base_url('login') ?>" class="btn btn-cyan">Buat Janji</a>
    </div>
  </div>
</div>
</section>

<!-- TESTIMONIAL -->
<section class="section">
<div class="container">
  <h2 class="section-title">Apa Kata Mereka?</h2>
  <p class="section-sub">Testimoni dari pasien yang telah menggunakan layanan kami.</p>
  <div class="testi-grid">
    <div class="testi-card fade-up">
      <div class="testi-avatar">BW</div>
      <div class="testi-stars">★★★★★</div>
      <p>"Pelayanan sangat ramah dan profesional. Dokternya menjelaskan dengan detail tentang kondisi saya."</p>
      <div class="testi-name">Budi Widodo</div>
    </div>
    <div class="testi-card fade-up">
      <div class="testi-avatar">SR</div>
      <div class="testi-stars">★★★★★</div>
      <p>"Booking online sangat mudah dan cepat. Tidak perlu antre lama lagi. Sangat direkomendasikan!"</p>
      <div class="testi-name">Siti Rahayu</div>
    </div>
    <div class="testi-card fade-up">
      <div class="testi-avatar">AP</div>
      <div class="testi-stars">★★★★★</div>
      <p>"Fasilitas rumah sakit sangat bersih dan modern. Dokter anak sangat sabar menangani anak saya."</p>
      <div class="testi-name">Ahmad Pratama</div>
    </div>
  </div>
</div>
</section>

<!-- CTA -->
<section class="cta">
<div class="container">
  <h2>Siap Menjaga Kesehatan Anda?</h2>
  <p>Daftarkan diri Anda sekarang dan nikmati kemudahan booking dokter secara online kapan saja.</p>
  <a href="<?= base_url('login') ?>" class="btn btn-filled" style="font-size:1.05rem;padding:14px 36px">Daftar &amp; Booking Sekarang</a>
</div>
</section>

<!-- FOOTER -->
<footer id="kontak">
<div class="container">
  <div class="footer-grid">
    <div>
      <div class="footer-logo">&#x1F3E5; RS MedikaCare</div>
      <p style="font-size:.9rem;line-height:1.7;margin-top:8px">Memberikan pelayanan kesehatan terbaik dengan teknologi modern dan tenaga medis profesional sejak 2011.</p>
    </div>
    <div>
      <h4>Layanan</h4>
      <ul>
        <li><a href="#layanan">Poli Umum</a></li>
        <li><a href="#layanan">Poli Gigi</a></li>
        <li><a href="#layanan">Poli THT</a></li>
        <li><a href="#layanan">Poli Anak</a></li>
      </ul>
    </div>
    <div>
      <h4>Informasi</h4>
      <ul>
        <li><a href="#tentang">Tentang Kami</a></li>
        <li><a href="#dokter">Dokter</a></li>
        <li><a href="#">Karir</a></li>
        <li><a href="#">FAQ</a></li>
      </ul>
    </div>
    <div>
      <h4>Kontak</h4>
      <ul>
        <li>📍 Jl. Sehat No. 123, Jakarta</li>
        <li>📞 (021) 1234-5678</li>
        <li>✉️ info@medikacare.id</li>
        <li>🕐 Senin - Sabtu, 07:00 - 21:00</li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">&copy; 2026 RS MedikaCare. All rights reserved.</div>
</div>
</footer>

<script>
// Navbar scroll effect
window.addEventListener('scroll',()=>{document.getElementById('navbar').classList.toggle('scrolled',window.scrollY>50)});

// Hamburger
document.getElementById('hamburgerBtn').addEventListener('click',()=>{document.getElementById('mobileMenu').classList.add('active')});
document.getElementById('mobileClose').addEventListener('click',closeMobile);
function closeMobile(){document.getElementById('mobileMenu').classList.remove('active')}

// Intersection Observer for fade-in
const obs=new IntersectionObserver((entries)=>{entries.forEach(e=>{if(e.isIntersecting){e.target.classList.add('visible');obs.unobserve(e.target)}})},{threshold:0.15});
document.querySelectorAll('.fade-up').forEach(el=>obs.observe(el));
</script>
</body>
</html>
