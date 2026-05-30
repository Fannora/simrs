<?php $title = 'Kelola Dokter'; ?>
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<!-- Header Area -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 animate-in fade-in duration-300">
    <button type="button" onclick="openModal('modalTambahDokter')" class="bg-secondary text-white hover:opacity-90 px-5 py-2.5 rounded-xl font-bold flex items-center gap-2 shadow-sm transition-all whitespace-nowrap">
        <span class="material-symbols-outlined">add</span>
        Tambah Dokter Baru
    </button>
    
    <!-- Search Filter Form -->
    <form method="GET" action="<?= base_url('admin/dokter') ?>" class="flex items-center gap-2 w-full sm:w-auto">
        <div class="relative w-full sm:w-64">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
            <input type="text" name="cari" value="<?= esc($cari ?? '') ?>" placeholder="Cari nama dokter..." class="w-full pl-9 pr-4 py-2 border border-outline-variant/65 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-secondary/50 focus:border-secondary transition-all bg-white text-slate-700">
        </div>
        <button type="submit" class="bg-secondary text-white hover:opacity-90 px-5 py-2 rounded-xl text-sm font-bold shadow-sm transition-all flex items-center gap-1.5 h-[38px]">
            Cari
        </button>
        <?php if (!empty($cari)): ?>
            <a href="<?= base_url('admin/dokter') ?>" class="border border-outline-variant/60 hover:bg-slate-50 text-slate-600 px-3 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-1 h-[38px] whitespace-nowrap">
                Reset
            </a>
        <?php endif; ?>
    </form>
</div>

<!-- Table Card -->
<div class="bg-white border border-outline-variant/65 rounded-2xl shadow-sm overflow-hidden animate-in fade-in slide-in-from-top-4 duration-500">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-outline-variant/35 bg-slate-50 text-slate-600 text-xs font-bold uppercase tracking-wider">
                    <th class="py-4 px-6 w-16 text-center">No</th>
                    <th class="py-4 px-6">Nama Lengkap & Akun</th>
                    <th class="py-4 px-6">Poli Spesialis</th>
                    <th class="py-4 px-6">No. WhatsApp</th>
                    <th class="py-4 px-6">Jadwal Praktik</th>
                    <th class="py-4 px-6 text-center">Kuota / Slot</th>
                    <th class="py-4 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/25 text-sm text-slate-700">
                <?php if (empty($dokter)): ?>
                <tr>
                    <td colspan="7" class="text-center text-slate-400 py-12">
                        <span class="material-symbols-outlined text-[48px] text-slate-300 block mb-2"><?= !empty($cari) ? 'search_off' : 'person_off' ?></span>
                        <?= !empty($cari) ? 'Tidak ditemukan dokter dengan nama "' . esc($cari) . '".' : 'Belum ada data dokter terdaftar di database RS.' ?>
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($dokter as $i => $d): ?>
                <tr class="hover:bg-slate-50/45 transition-colors">
                    <td class="py-5 px-6 text-center font-semibold text-slate-500">
                        <?= $i + 1 ?>
                    </td>
                    <td class="py-5 px-6">
                        <div class="font-bold text-slate-800 text-sm"><?= esc($d['nama_dokter']) ?></div>
                        <?php if (!empty($d['username'])): ?>
                        <div class="flex items-center gap-1.5 text-xs text-slate-500 mt-1">
                            <span class="material-symbols-outlined text-[14px]">account_circle</span>
                            <span><?= esc($d['username']) ?></span>
                        </div>
                        <?php endif; ?>
                    </td>
                    <td class="py-5 px-6">
                        <span class="text-xs bg-blue-50 text-secondary border border-blue-100 px-2.5 py-1 rounded-full font-bold">
                            <?= esc($d['nama_poli']) ?>
                        </span>
                    </td>
                    <td class="py-5 px-6 font-medium text-slate-600">
                        <?= esc($d['no_telp'] ?? '-') ?>
                    </td>
                    <td class="py-5 px-6 font-semibold text-slate-700">
                        <?= date('H:i', strtotime($d['jam_mulai'])) ?> — <?= date('H:i', strtotime($d['jam_selesai'])) ?>
                    </td>
                    <td class="py-5 px-6 text-center font-bold text-slate-700">
                        <?= $d['kuota_per_slot'] ?? 5 ?> pasien
                    </td>
                    <td class="py-5 px-6 text-center">
                        <div class="inline-flex gap-2">
                            <button type="button" class="p-2 bg-amber-50 hover:bg-amber-100/80 text-amber-600 rounded-lg border border-amber-200 transition-colors" 
                                onclick="populateEdit(<?= $d['id_dokter'] ?>, '<?= esc($d['nama_dokter'], 'js') ?>', <?= $d['id_poli'] ?>, '<?= esc($d['no_telp'] ?? '', 'js') ?>', '<?= $d['jam_mulai'] ?>', '<?= $d['jam_selesai'] ?>', <?= $d['kuota_per_slot'] ?? 5 ?>)">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </button>
                            <a href="<?= base_url('admin/dokter/hapus/' . $d['id_dokter']) ?>" class="p-2 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg border border-rose-200 transition-colors" 
                                onclick="return confirm('Apakah Anda yakin ingin menghapus data dokter <?= esc($d['nama_dokter'], 'js') ?>?')">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Dokter -->
<div id="modalTambahDokter" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden transform scale-95 transition-all duration-300">
        <div class="bg-secondary text-white px-6 py-5 flex justify-between items-center">
            <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">add_circle</span>
                <h3 class="font-headline-sm text-lg font-bold text-white">Tambah Dokter Baru</h3>
            </div>
            <button type="button" onclick="closeModal('modalTambahDokter')" class="text-white/80 hover:text-white p-1 rounded-full hover:bg-white/10 transition-all">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form method="POST" action="<?= base_url('admin/dokter/simpan') ?>" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Dokter <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_dokter" required class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm" placeholder="Contoh: dr. Rusdi Santoso, Sp.A">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Username Akun <span class="text-rose-500">*</span></label>
                    <input type="text" name="username" required class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm" placeholder="contoh: dr_rusdi">
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kata Sandi <span class="text-rose-500">*</span></label>
                    <input type="password" name="password" required class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm" placeholder="••••••••">
                </div>
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Poli Spesialis <span class="text-rose-500">*</span></label>
                <select name="id_poli" required class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm bg-white py-2.5">
                    <option value="" disabled selected>-- Pilih Poli --</option>
                    <?php foreach ($poli as $p): ?>
                    <option value="<?= $p['id_poli'] ?>"><?= esc($p['nama_poli']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Nomor Telp / WhatsApp</label>
                <input type="text" name="no_telp" class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm" placeholder="Contoh: 0812XXXXXXXX">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Jam Mulai Praktik <span class="text-rose-500">*</span></label>
                    <input type="time" name="jam_mulai" required class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm">
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Jam Selesai Praktik <span class="text-rose-500">*</span></label>
                    <input type="time" name="jam_selesai" required class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm">
                </div>
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kuota Maks per Slot Waktu</label>
                <input type="number" name="kuota_per_slot" value="5" min="1" class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm">
            </div>
            <div class="pt-4 border-t border-slate-100 flex gap-2 justify-end">
                <button type="button" onclick="closeModal('modalTambahDokter')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200/80 text-slate-600 rounded-xl text-sm font-bold transition-all">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-secondary text-white hover:opacity-90 rounded-xl text-sm font-bold shadow-sm transition-all">Simpan Dokter</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Dokter -->
<div id="modalEditDokter" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden transform scale-95 transition-all duration-300">
        <div class="bg-amber-500 text-white px-6 py-5 flex justify-between items-center">
            <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">edit_square</span>
                <h3 class="font-headline-sm text-lg font-bold text-white">Edit Data Dokter</h3>
            </div>
            <button type="button" onclick="closeModal('modalEditDokter')" class="text-white/80 hover:text-white p-1 rounded-full hover:bg-white/10 transition-all">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form method="POST" action="<?= base_url('admin/dokter/edit') ?>" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" name="id_dokter" id="edit_id_dokter">
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Dokter <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_dokter" id="edit_nama_dokter" required class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm">
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Poli Spesialis <span class="text-rose-500">*</span></label>
                <select name="id_poli" id="edit_id_poli" required class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm bg-white py-2.5">
                    <?php foreach ($poli as $p): ?>
                    <option value="<?= $p['id_poli'] ?>"><?= esc($p['nama_poli']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Nomor Telp / WhatsApp</label>
                <input type="text" name="no_telp" id="edit_no_telp" class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Jam Mulai Praktik <span class="text-rose-500">*</span></label>
                    <input type="time" name="jam_mulai" id="edit_jam_mulai" required class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm">
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Jam Selesai Praktik <span class="text-rose-500">*</span></label>
                    <input type="time" name="jam_selesai" id="edit_jam_selesai" required class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm">
                </div>
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kuota Maks per Slot Waktu</label>
                <input type="number" name="kuota_per_slot" id="edit_kuota" min="1" class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm">
            </div>
            <div class="pt-4 border-t border-slate-100 flex gap-2 justify-end">
                <button type="button" onclick="closeModal('modalEditDokter')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200/80 text-slate-600 rounded-xl text-sm font-bold transition-all">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm font-bold shadow-sm transition-all">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('opacity-0', 'pointer-events-none');
    modal.querySelector('.bg-white').classList.remove('scale-95');
    modal.querySelector('.bg-white').classList.add('scale-100');
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.add('opacity-0', 'pointer-events-none');
    modal.querySelector('.bg-white').classList.remove('scale-100');
    modal.querySelector('.bg-white').classList.add('scale-95');
}

function populateEdit(id, nama, idPoli, telp, jamMulai, jamSelesai, kuota) {
    document.getElementById('edit_id_dokter').value = id;
    document.getElementById('edit_nama_dokter').value = nama;
    document.getElementById('edit_id_poli').value = idPoli;
    document.getElementById('edit_no_telp').value = telp;
    document.getElementById('edit_jam_mulai').value = jamMulai.substring(0, 5);
    document.getElementById('edit_jam_selesai').value = jamSelesai.substring(0, 5);
    document.getElementById('edit_kuota').value = kuota;
    openModal('modalEditDokter');
}
</script>
<?= $this->endSection() ?>
