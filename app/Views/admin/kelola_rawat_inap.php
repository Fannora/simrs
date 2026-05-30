<?php $title = 'Rawat Inap'; ?>
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<!-- Header Area / Tabs & Search -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 animate-in fade-in duration-300">
    <!-- Tab Navigation -->
    <div class="flex gap-1 bg-slate-100 p-1 rounded-xl w-fit">
        <button id="tab-btn-1" onclick="switchTab(1)" class="tab-btn px-5 py-2.5 rounded-lg text-sm font-bold transition-all bg-white text-secondary shadow-sm">
            <span class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px]">pending</span>
                Perlu Masuk
                <?php if (count($perluMasuk) > 0): ?>
                <span class="bg-rose-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full"><?= count($perluMasuk) ?></span>
                <?php endif; ?>
            </span>
        </button>
        <button id="tab-btn-2" onclick="switchTab(2)" class="tab-btn px-5 py-2.5 rounded-lg text-sm font-bold transition-all text-slate-500 hover:text-slate-800">
            <span class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px]">hotel</span>
                Sedang Dirawat
                <?php if (count($sedangDirawat) > 0): ?>
                <span class="bg-amber-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full"><?= count($sedangDirawat) ?></span>
                <?php endif; ?>
            </span>
        </button>
        <button id="tab-btn-3" onclick="switchTab(3)" class="tab-btn px-5 py-2.5 rounded-lg text-sm font-bold transition-all text-slate-500 hover:text-slate-800">
            <span class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px]">history</span>
                Riwayat
            </span>
        </button>
    </div>
    
    <!-- Search Filter Form -->
    <form method="GET" action="<?= base_url('admin/rawat-inap') ?>" class="flex items-center gap-2 w-full sm:w-auto">
        <div class="relative w-full sm:w-64">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
            <input type="text" name="cari" value="<?= esc($cari ?? '') ?>" placeholder="Cari nama pasien..." class="w-full pl-9 pr-4 py-2 border border-outline-variant/65 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-secondary/50 focus:border-secondary transition-all bg-white text-slate-700">
        </div>
        <button type="submit" class="bg-secondary text-white hover:opacity-90 px-5 py-2 rounded-xl text-sm font-bold shadow-sm transition-all flex items-center gap-1.5 h-[38px]">
            Cari
        </button>
        <?php if (!empty($cari)): ?>
            <a href="<?= base_url('admin/rawat-inap') ?>" class="border border-outline-variant/60 hover:bg-slate-50 text-slate-600 px-3 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-1 h-[38px] whitespace-nowrap">
                Reset
            </a>
        <?php endif; ?>
    </form>
</div>

<!-- TAB 1: Perlu Masuk -->
<div id="tab-1" class="tab-content">
    <div class="bg-white border border-outline-variant/65 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50 flex items-center gap-2">
            <span class="material-symbols-outlined text-secondary">pending</span>
            <h3 class="font-bold text-slate-800">Pasien yang Perlu Masuk Rawat Inap</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-outline-variant/35 bg-slate-50 text-slate-600 text-xs font-bold uppercase tracking-wider">
                        <th class="py-4 px-6">Nama Pasien</th>
                        <th class="py-4 px-6">No. Rawat</th>
                        <th class="py-4 px-6">Dokter / Poli</th>
                        <th class="py-4 px-6">Tgl. Daftar</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/25 text-sm text-slate-700">
                    <?php if (empty($perluMasuk)): ?>
                    <tr>
                        <td colspan="5" class="text-center text-slate-400 py-10">
                            <span class="material-symbols-outlined text-[40px] text-slate-300 block mb-1"><?= !empty($cari) ? 'search_off' : 'check_circle' ?></span>
                            <?= !empty($cari) ? 'Tidak ditemukan pasien dengan nama "' . esc($cari) . '".' : 'Tidak ada pasien yang perlu dimasukkan ke kamar rawat inap.' ?>
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($perluMasuk as $p): ?>
                    <tr class="hover:bg-slate-50/45 transition-colors">
                        <td class="py-4 px-6 font-bold text-slate-800"><?= esc($p['nama_pasien']) ?></td>
                        <td class="py-4 px-6"><code class="bg-slate-100 px-2 py-0.5 rounded text-xs font-mono"><?= esc($p['no_rawat']) ?></code></td>
                        <td class="py-4 px-6">
                            <div class="font-semibold">dr. <?= esc($p['nama_dokter']) ?></div>
                            <div class="text-xs text-slate-400"><?= esc($p['nama_poli']) ?></div>
                        </td>
                        <td class="py-4 px-6 text-slate-500"><?= date('d M Y', strtotime($p['tgl_daftar'])) ?></td>
                        <td class="py-4 px-6">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" onclick="openMasukModal('<?= esc($p['no_rawat'], 'js') ?>', '<?= esc($p['nama_pasien'], 'js') ?>')"
                                    class="px-3.5 py-2 bg-secondary text-white text-xs font-bold rounded-xl hover:opacity-90 transition-all shadow-sm flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[14px]">hotel</span>
                                    Masukkan ke Kamar
                                </button>
                                <button type="button" onclick="confirmCancelRawatInap('<?= esc($p['no_rawat'], 'js') ?>', '<?= esc($p['nama_pasien'], 'js') ?>')"
                                    class="px-3.5 py-2 border border-red-200 text-red-600 hover:bg-red-50 hover:border-red-300 text-xs font-bold rounded-xl transition-all flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[14px]">cancel</span>
                                    Batalkan
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- TAB 2: Sedang Dirawat -->
<div id="tab-2" class="tab-content hidden">
    <div class="bg-white border border-outline-variant/65 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50 flex items-center gap-2">
            <span class="material-symbols-outlined text-amber-500">hotel</span>
            <h3 class="font-bold text-slate-800">Pasien Sedang Dirawat</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-outline-variant/35 bg-slate-50 text-slate-600 text-xs font-bold uppercase tracking-wider">
                        <th class="py-4 px-6">Nama Pasien</th>
                        <th class="py-4 px-6">Kamar / Kelas</th>
                        <th class="py-4 px-6 text-right">Harga/Malam</th>
                        <th class="py-4 px-6 text-center">Tgl Masuk</th>
                        <th class="py-4 px-6 text-center">Hari Dirawat</th>
                        <th class="py-4 px-6 text-right">Est. Biaya</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/25 text-sm text-slate-700">
                    <?php if (empty($sedangDirawat)): ?>
                    <tr>
                        <td colspan="7" class="text-center text-slate-400 py-10">
                            <span class="material-symbols-outlined text-[40px] text-slate-300 block mb-1"><?= !empty($cari) ? 'search_off' : 'hotel' ?></span>
                            <?= !empty($cari) ? 'Tidak ditemukan pasien dirawat dengan nama "' . esc($cari) . '".' : 'Tidak ada pasien yang sedang dirawat.' ?>
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($sedangDirawat as $ri): ?>
                    <tr class="hover:bg-slate-50/45 transition-colors">
                        <td class="py-4 px-6">
                            <div class="font-bold text-slate-800"><?= esc($ri['nama_pasien']) ?></div>
                            <div class="text-xs text-slate-400"><?= esc($ri['no_rawat']) ?></div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="font-semibold"><?= esc($ri['nama_kamar']) ?></div>
                            <?php
                            $kelasColor = match($ri['kelas']) {
                                'VIP'  => 'bg-amber-50 text-amber-700 border-amber-100',
                                'I'    => 'bg-purple-50 text-purple-700 border-purple-100',
                                'II'   => 'bg-blue-50 text-blue-700 border-blue-100',
                                default=> 'bg-slate-100 text-slate-600 border-slate-200',
                            };
                            ?>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full border <?= $kelasColor ?>">Kelas <?= esc($ri['kelas']) ?></span>
                        </td>
                        <td class="py-4 px-6 text-right">Rp <?= number_format($ri['harga_per_malam'], 0, ',', '.') ?></td>
                        <td class="py-4 px-6 text-center text-slate-500"><?= date('d M Y', strtotime($ri['tgl_masuk'])) ?></td>
                        <td class="py-4 px-6 text-center">
                            <span class="bg-amber-50 text-amber-700 border border-amber-100 text-xs font-bold px-3 py-1 rounded-full">
                                <?= max(1, (int)$ri['hari_dirawat']) ?> Hari
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right font-bold text-slate-800">
                            Rp <?= number_format(max(1, (int)$ri['hari_dirawat']) * (float)$ri['harga_per_malam'], 0, ',', '.') ?>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <button type="button" onclick="openPulangModal(<?= $ri['id_rawatinap'] ?>, '<?= esc($ri['nama_pasien'], 'js') ?>')"
                                class="px-4 py-2 bg-emerald-600 text-white text-xs font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-sm flex items-center gap-1 mx-auto">
                                <span class="material-symbols-outlined text-[14px]">logout</span>
                                Pasien Pulang
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- TAB 3: Riwayat -->
<div id="tab-3" class="tab-content hidden">
    <div class="bg-white border border-outline-variant/65 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50 flex items-center gap-2">
            <span class="material-symbols-outlined text-slate-500">history</span>
            <h3 class="font-bold text-slate-800">Riwayat Rawat Inap</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-outline-variant/35 bg-slate-50 text-slate-600 text-xs font-bold uppercase tracking-wider">
                        <th class="py-4 px-6">Nama Pasien</th>
                        <th class="py-4 px-6">Kamar</th>
                        <th class="py-4 px-6 text-center">Tgl Masuk</th>
                        <th class="py-4 px-6 text-center">Tgl Keluar</th>
                        <th class="py-4 px-6 text-center">Total Hari</th>
                        <th class="py-4 px-6 text-right">Biaya Kamar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/25 text-sm text-slate-700">
                    <?php if (empty($riwayat)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-slate-400 py-10">
                            <span class="material-symbols-outlined text-[40px] text-slate-300 block mb-1"><?= !empty($cari) ? 'search_off' : 'history' ?></span>
                            <?= !empty($cari) ? 'Tidak ditemukan riwayat pasien dengan nama "' . esc($cari) . '".' : 'Belum ada riwayat rawat inap.' ?>
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($riwayat as $r): ?>
                    <tr class="hover:bg-slate-50/45 transition-colors">
                        <td class="py-4 px-6">
                            <div class="font-bold text-slate-800"><?= esc($r['nama_pasien']) ?></div>
                            <div class="text-xs text-slate-400"><?= esc($r['no_rawat']) ?></div>
                        </td>
                        <td class="py-4 px-6 font-semibold"><?= esc($r['nama_kamar']) ?> <span class="text-xs text-slate-400">(<?= esc($r['kelas']) ?>)</span></td>
                        <td class="py-4 px-6 text-center text-slate-500"><?= date('d M Y', strtotime($r['tgl_masuk'])) ?></td>
                        <td class="py-4 px-6 text-center text-slate-500"><?= $r['tgl_keluar'] ? date('d M Y', strtotime($r['tgl_keluar'])) : '-' ?></td>
                        <td class="py-4 px-6 text-center">
                            <span class="bg-slate-100 text-slate-700 text-xs font-bold px-3 py-1 rounded-full"><?= $r['total_hari'] ?? '-' ?> Hari</span>
                        </td>
                        <td class="py-4 px-6 text-right font-bold text-slate-800">
                            Rp <?= number_format($r['biaya_kamar'] ?? 0, 0, ',', '.') ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Masukkan ke Kamar -->
<div id="modalMasuk" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform scale-95 transition-all duration-300">
        <div class="bg-secondary text-white px-6 py-5 flex justify-between items-center">
            <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">hotel</span>
                <h3 class="font-bold text-lg text-white">Masukkan ke Kamar Rawat Inap</h3>
            </div>
            <button type="button" onclick="closeModal('modalMasuk')" class="text-white/80 hover:text-white p-1 rounded-full hover:bg-white/10 transition-all">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form method="POST" action="<?= base_url('admin/rawat-inap/masuk') ?>" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" name="no_rawat" id="masuk_no_rawat">
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 flex items-center gap-3">
                <span class="material-symbols-outlined text-secondary">person</span>
                <div>
                    <p class="text-xs text-slate-500">Pasien</p>
                    <p class="font-bold text-slate-800" id="masuk_nama_pasien"></p>
                </div>
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Pilih Kamar <span class="text-rose-500">*</span></label>
                <select name="id_kamar" required class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm bg-white py-2.5">
                    <option value="" disabled selected>-- Pilih Kamar Tersedia --</option>
                    <?php foreach ($kamarTersedia as $k): ?>
                    <option value="<?= $k['id_kamar'] ?>">
                        <?= esc($k['nama_kamar']) ?> — Kelas <?= esc($k['kelas']) ?> — Rp <?= number_format($k['harga_per_malam'], 0, ',', '.') ?>/malam
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Catatan (opsional)</label>
                <textarea name="catatan" rows="2" class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm" placeholder="Catatan medis atau instruksi khusus..."></textarea>
            </div>
            <div class="pt-4 border-t border-slate-100 flex gap-2 justify-end">
                <button type="button" onclick="closeModal('modalMasuk')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-bold transition-all">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-secondary text-white hover:opacity-90 rounded-xl text-sm font-bold shadow-sm transition-all">Masukkan Pasien</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Pasien Pulang -->
<div id="modalPulang" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform scale-95 transition-all duration-300">
        <div class="bg-emerald-600 text-white px-6 py-5 flex justify-between items-center">
            <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">logout</span>
                <h3 class="font-bold text-lg text-white">Proses Kepulangan Pasien</h3>
            </div>
            <button type="button" onclick="closeModal('modalPulang')" class="text-white/80 hover:text-white p-1 rounded-full hover:bg-white/10 transition-all">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form method="POST" id="formPulang" action="" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-3 flex items-center gap-3">
                <span class="material-symbols-outlined text-emerald-600">person</span>
                <div>
                    <p class="text-xs text-slate-500">Pasien Pulang</p>
                    <p class="font-bold text-slate-800" id="pulang_nama_pasien"></p>
                </div>
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Tanggal Keluar <span class="text-rose-500">*</span></label>
                <input type="date" name="tgl_keluar" id="pulang_tgl_keluar" required class="w-full rounded-xl border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
            </div>
            <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl text-sm text-amber-800">
                <span class="material-symbols-outlined text-[16px] text-amber-600 align-middle">info</span>
                Biaya kamar akan dihitung otomatis: <strong>Jumlah hari × tarif kamar per malam</strong> dan ditambahkan ke tagihan pasien.
            </div>
            <div class="pt-4 border-t border-slate-100 flex gap-2 justify-end">
                <button type="button" onclick="closeModal('modalPulang')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-bold transition-all">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow-sm transition-all">Konfirmasi Pulang</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
function openModal(id) {
    const m = document.getElementById(id);
    m.classList.remove('opacity-0', 'pointer-events-none');
    m.querySelector('.bg-white').classList.remove('scale-95');
    m.querySelector('.bg-white').classList.add('scale-100');
}
function closeModal(id) {
    const m = document.getElementById(id);
    m.classList.add('opacity-0', 'pointer-events-none');
    m.querySelector('.bg-white').classList.remove('scale-100');
    m.querySelector('.bg-white').classList.add('scale-95');
}

function openMasukModal(noRawat, namaPasien) {
    document.getElementById('masuk_no_rawat').value = noRawat;
    document.getElementById('masuk_nama_pasien').textContent = namaPasien;
    openModal('modalMasuk');
}

function openPulangModal(id, namaPasien) {
    document.getElementById('formPulang').action = '<?= base_url('admin/rawat-inap/pulang/') ?>' + id;
    document.getElementById('pulang_nama_pasien').textContent = namaPasien;
    document.getElementById('pulang_tgl_keluar').value = new Date().toISOString().split('T')[0];
    openModal('modalPulang');
}

function confirmCancelRawatInap(noRawat, namaPasien) {
    Swal.fire({
        title: 'Batalkan Rawat Inap',
        html: `<div class="text-left font-body-md">
            <p class="text-sm text-slate-600 mb-3">Apakah Anda yakin ingin membatalkan rekomendasi rawat inap untuk <strong>${namaPasien}</strong>?</p>
            <p class="text-xs text-slate-500 bg-slate-50 border border-slate-100 rounded-xl p-3 flex items-start gap-2 leading-relaxed">
                <span class="material-symbols-outlined text-amber-500 text-lg flex-shrink-0" style="font-variation-settings: 'FILL' 1;">info</span>
                <span>Status periksa pasien akan dikembalikan menjadi <strong>"Selesai"</strong> (Rawat Jalan) dan dikeluarkan dari daftar rawat inap.</span>
            </p>
        </div>`,
        icon: 'warning',
        iconColor: '#ef4444',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Batalkan Inap',
        cancelButtonText: 'Batal',
        customClass: {
            popup: 'rounded-2xl border border-outline-variant/40 shadow-xl font-body-md text-slate-800 p-6',
            confirmButton: 'rounded-xl px-5 py-2.5 font-bold text-xs shadow-sm transition-all focus:ring-2 focus:ring-offset-2 focus:ring-red-500 mr-2',
            cancelButton: 'rounded-xl px-5 py-2.5 font-bold text-xs shadow-sm transition-all focus:ring-2 focus:ring-offset-2 focus:ring-slate-500'
        },
        buttonsStyling: true
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?= base_url('admin/rawat-inap/batal/') ?>' + noRawat;
        }
    });
}

function switchTab(n) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('bg-white', 'text-secondary', 'shadow-sm');
        btn.classList.add('text-slate-500');
    });
    document.getElementById('tab-' + n).classList.remove('hidden');
    const activeBtn = document.getElementById('tab-btn-' + n);
    activeBtn.classList.add('bg-white', 'text-secondary', 'shadow-sm');
    activeBtn.classList.remove('text-slate-500');
}
</script>
<?= $this->endSection() ?>
