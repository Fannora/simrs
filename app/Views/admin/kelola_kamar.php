<?php $title = 'Kelola Kamar'; ?>
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<!-- Header Area -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 animate-in fade-in duration-300">
    <div class="flex items-center gap-4">
        <button type="button" onclick="openModal('modalTambahKamar')" class="bg-secondary text-white hover:opacity-90 px-5 py-2.5 rounded-xl font-bold flex items-center gap-2 shadow-sm transition-all whitespace-nowrap">
            <span class="material-symbols-outlined">add</span>
            Tambah Kamar
        </button>
        <p class="text-xs text-slate-500 hidden md:block">Manajemen kamar rawat inap rumah sakit</p>
    </div>
    
    <!-- Search Filter Form -->
    <form method="GET" action="<?= base_url('admin/kamar') ?>" class="flex items-center gap-2 w-full sm:w-auto">
        <div class="relative w-full sm:w-64">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
            <input type="text" name="cari" value="<?= esc($cari ?? '') ?>" placeholder="Cari nama kamar..." class="w-full pl-9 pr-4 py-2 border border-outline-variant/65 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-secondary/50 focus:border-secondary transition-all bg-white text-slate-700">
        </div>
        <button type="submit" class="bg-secondary text-white hover:opacity-90 px-5 py-2 rounded-xl text-sm font-bold shadow-sm transition-all flex items-center gap-1.5 h-[38px]">
            Cari
        </button>
        <?php if (!empty($cari)): ?>
            <a href="<?= base_url('admin/kamar') ?>" class="border border-outline-variant/60 hover:bg-slate-50 text-slate-600 px-3 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-1 h-[38px] whitespace-nowrap">
                Reset
            </a>
        <?php endif; ?>
    </form>
</div>

<!-- Stat Cards -->
<?php
$tersedia = count(array_filter($kamar, fn($k) => $k['status'] === 'Tersedia'));
$terisi   = count(array_filter($kamar, fn($k) => $k['status'] === 'Terisi'));
?>
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white border border-outline-variant/65 rounded-2xl p-5 flex items-center gap-4 shadow-sm">
        <div class="w-12 h-12 bg-secondary/10 rounded-xl flex items-center justify-center text-secondary">
            <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">meeting_room</span>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-500 uppercase">Total Kamar</p>
            <p class="text-2xl font-extrabold text-slate-800"><?= count($kamar) ?></p>
        </div>
    </div>
    <div class="bg-white border border-outline-variant/65 rounded-2xl p-5 flex items-center gap-4 shadow-sm">
        <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
            <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">door_open</span>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-500 uppercase">Tersedia</p>
            <p class="text-2xl font-extrabold text-emerald-600"><?= $tersedia ?></p>
        </div>
    </div>
    <div class="bg-white border border-outline-variant/65 rounded-2xl p-5 flex items-center gap-4 shadow-sm">
        <div class="w-12 h-12 bg-rose-50 rounded-xl flex items-center justify-center text-rose-600">
            <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">do_not_disturb</span>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-500 uppercase">Terisi</p>
            <p class="text-2xl font-extrabold text-rose-600"><?= $terisi ?></p>
        </div>
    </div>
</div>

<!-- Table -->
<div class="bg-white border border-outline-variant/65 rounded-2xl shadow-sm overflow-hidden animate-in fade-in slide-in-from-top-4 duration-500">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-outline-variant/35 bg-slate-50 text-slate-600 text-xs font-bold uppercase tracking-wider">
                    <th class="py-4 px-6 w-12 text-center">No</th>
                    <th class="py-4 px-6">Nama Kamar</th>
                    <th class="py-4 px-6 text-center">Kelas</th>
                    <th class="py-4 px-6 text-right">Harga / Malam</th>
                    <th class="py-4 px-6 text-center">Status</th>
                    <th class="py-4 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/25 text-sm text-slate-700">
                <?php if (empty($kamar)): ?>
                <tr>
                    <td colspan="6" class="text-center text-slate-400 py-12">
                        <span class="material-symbols-outlined text-[48px] text-slate-300 block mb-2"><?= !empty($cari) ? 'search_off' : 'meeting_room' ?></span>
                        <?= !empty($cari) ? 'Tidak ditemukan kamar dengan nama "' . esc($cari) . '".' : 'Belum ada data kamar. Tambahkan kamar untuk rawat inap.' ?>
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($kamar as $i => $k): ?>
                <tr class="hover:bg-slate-50/45 transition-colors">
                    <td class="py-4 px-6 text-center font-semibold text-slate-500"><?= $i + 1 ?></td>
                    <td class="py-4 px-6 font-bold text-slate-800"><?= esc($k['nama_kamar']) ?></td>
                    <td class="py-4 px-6 text-center">
                        <?php
                        $kelasColor = match($k['kelas']) {
                            'VIP'  => 'bg-amber-50 text-amber-700 border-amber-100',
                            'I'    => 'bg-purple-50 text-purple-700 border-purple-100',
                            'II'   => 'bg-blue-50 text-blue-700 border-blue-100',
                            default=> 'bg-slate-100 text-slate-600 border-slate-200',
                        };
                        ?>
                        <span class="text-xs font-bold px-3 py-1 rounded-full border <?= $kelasColor ?>">Kelas <?= esc($k['kelas']) ?></span>
                    </td>
                    <td class="py-4 px-6 text-right font-bold text-slate-800">Rp <?= number_format($k['harga_per_malam'], 0, ',', '.') ?></td>
                    <td class="py-4 px-6 text-center">
                        <?php if ($k['status'] === 'Tersedia'): ?>
                            <span class="text-xs font-bold px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100">Tersedia</span>
                        <?php else: ?>
                            <span class="text-xs font-bold px-3 py-1 rounded-full bg-rose-50 text-rose-700 border border-rose-100">Terisi</span>
                        <?php endif; ?>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <?php if ($k['status'] === 'Tersedia'): ?>
                        <button type="button"
                            class="p-2 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg border border-amber-200 transition-colors"
                            onclick="populateEdit(<?= $k['id_kamar'] ?>, '<?= esc($k['nama_kamar'], 'js') ?>', '<?= esc($k['kelas'], 'js') ?>', <?= $k['harga_per_malam'] ?>)">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                        </button>
                        <?php else: ?>
                        <span class="p-2 text-slate-300 cursor-not-allowed inline-block" title="Kamar terisi, tidak dapat diedit">
                            <span class="material-symbols-outlined text-[18px]">edit_off</span>
                        </span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div id="modalTambahKamar" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform scale-95 transition-all duration-300">
        <div class="bg-secondary text-white px-6 py-5 flex justify-between items-center">
            <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">add_circle</span>
                <h3 class="font-bold text-lg text-white">Tambah Kamar</h3>
            </div>
            <button type="button" onclick="closeModal('modalTambahKamar')" class="text-white/80 hover:text-white p-1 rounded-full hover:bg-white/10 transition-all">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form method="POST" action="<?= base_url('admin/kamar/store') ?>" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Kamar <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_kamar" required class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm" placeholder="Contoh: Anggrek 1">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kelas <span class="text-rose-500">*</span></label>
                    <select name="kelas" required class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm bg-white py-2.5">
                        <option value="VIP">VIP</option>
                        <option value="I">Kelas I</option>
                        <option value="II">Kelas II</option>
                        <option value="III" selected>Kelas III</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Harga/Malam (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" name="harga_per_malam" required min="0" step="1000" class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm" placeholder="500000">
                </div>
            </div>
            <div class="pt-4 border-t border-slate-100 flex gap-2 justify-end">
                <button type="button" onclick="closeModal('modalTambahKamar')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-bold transition-all">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-secondary text-white hover:opacity-90 rounded-xl text-sm font-bold shadow-sm transition-all">Simpan Kamar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="modalEditKamar" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform scale-95 transition-all duration-300">
        <div class="bg-amber-500 text-white px-6 py-5 flex justify-between items-center">
            <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">edit_square</span>
                <h3 class="font-bold text-lg text-white">Edit Kamar</h3>
            </div>
            <button type="button" onclick="closeModal('modalEditKamar')" class="text-white/80 hover:text-white p-1 rounded-full hover:bg-white/10 transition-all">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form method="POST" id="formEditKamar" action="" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Kamar <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_kamar" id="edit_nama_kamar" required class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kelas <span class="text-rose-500">*</span></label>
                    <select name="kelas" id="edit_kelas" required class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm bg-white py-2.5">
                        <option value="VIP">VIP</option>
                        <option value="I">Kelas I</option>
                        <option value="II">Kelas II</option>
                        <option value="III">Kelas III</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Harga/Malam (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" name="harga_per_malam" id="edit_harga_malam" required min="0" step="1000" class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm">
                </div>
            </div>
            <div class="pt-4 border-t border-slate-100 flex gap-2 justify-end">
                <button type="button" onclick="closeModal('modalEditKamar')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-bold transition-all">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm font-bold shadow-sm transition-all">Simpan Perubahan</button>
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
function populateEdit(id, nama, kelas, harga) {
    document.getElementById('formEditKamar').action = '<?= base_url('admin/kamar/update/') ?>' + id;
    document.getElementById('edit_nama_kamar').value = nama;
    document.getElementById('edit_kelas').value = kelas;
    document.getElementById('edit_harga_malam').value = harga;
    openModal('modalEditKamar');
}
</script>
<?= $this->endSection() ?>
