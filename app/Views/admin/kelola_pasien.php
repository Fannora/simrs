<?php $title = 'Kelola Pasien'; ?>
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<!-- Header Area -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 animate-in fade-in duration-300">
    <button type="button" onclick="openModal('modalTambahPasien')" class="bg-secondary text-white hover:opacity-90 px-5 py-2.5 rounded-xl font-bold flex items-center gap-2 shadow-sm transition-all whitespace-nowrap">
        <span class="material-symbols-outlined">person_add</span>
        Tambah Pasien Baru
    </button>
    
    <!-- Search Filter Form -->
    <form method="GET" action="<?= base_url('admin/pasien') ?>" class="flex items-center gap-2 w-full sm:w-auto">
        <div class="relative w-full sm:w-64">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
            <input type="text" name="cari" value="<?= esc($cari ?? '') ?>" placeholder="Cari nama pasien..." class="w-full pl-9 pr-4 py-2 border border-outline-variant/65 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-secondary/50 focus:border-secondary transition-all bg-white text-slate-700">
        </div>
        <button type="submit" class="bg-secondary text-white hover:opacity-90 px-5 py-2 rounded-xl text-sm font-bold shadow-sm transition-all flex items-center gap-1.5 h-[38px]">
            Cari
        </button>
        <?php if (!empty($cari)): ?>
            <a href="<?= base_url('admin/pasien') ?>" class="border border-outline-variant/60 hover:bg-slate-50 text-slate-600 px-3 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-1 h-[38px] whitespace-nowrap">
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
                    <th class="py-4 px-6">No. Rekam Medis (RM)</th>
                    <th class="py-4 px-6">Nomor NIK</th>
                    <th class="py-4 px-6">Nama Lengkap Pasien</th>
                    <th class="py-4 px-6">Tanggal Lahir</th>
                    <th class="py-4 px-6">Jenis Kelamin</th>
                    <th class="py-4 px-6">Nomor BPJS</th>
                    <th class="py-4 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/25 text-sm text-slate-700">
                <?php if (empty($pasien)): ?>
                <tr>
                    <td colspan="7" class="text-center text-slate-400 py-12">
                        <span class="material-symbols-outlined text-[48px] text-slate-300 block mb-2"><?= !empty($cari) ? 'search_off' : 'no_accounts' ?></span>
                        <?= !empty($cari) ? 'Tidak ditemukan pasien dengan nama "' . esc($cari) . '".' : 'Belum ada data pasien terdaftar di database RS.' ?>
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($pasien as $p): ?>
                <?php
                    $bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                    $tgl = explode('-', $p['tgl_lahir']);
                    $tglFmt = (int)$tgl[2] . ' ' . $bulan[(int)$tgl[1]] . ' ' . $tgl[0];
                ?>
                <tr class="hover:bg-slate-50/45 transition-colors">
                    <td class="py-5 px-6">
                        <strong class="font-mono text-sm text-red-800 font-bold"><?= esc($p['no_rm']) ?></strong>
                    </td>
                    <td class="py-5 px-6 font-semibold text-slate-600 font-mono text-sm">
                        <?= esc($p['nik']) ?>
                    </td>
                    <td class="py-5 px-6">
                        <strong class="text-slate-800 font-bold"><?= esc($p['nama_pasien']) ?></strong>
                    </td>
                    <td class="py-5 px-6 font-medium text-slate-600">
                        <?= $tglFmt ?>
                    </td>
                    <td class="py-5 px-6">
                        <strong class="text-sm font-bold <?= $p['jk'] == 'L' ? 'text-blue-900' : 'text-pink-500' ?>"><?= $p['jk'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></strong>
                    </td>
                    <td class="py-5 px-6 font-bold text-slate-800 font-mono text-sm">
                        <?php if(!empty($p['no_bpjs'])): ?>
                            <strong><?= esc($p['no_bpjs']) ?></strong>
                        <?php else: ?>
                            <span class="text-slate-400 font-normal">-</span>
                        <?php endif; ?>
                    </td>
                    <td class="py-5 px-6 text-center">
                        <div class="inline-flex gap-2">
                            <button type="button" class="p-2 bg-amber-50 hover:bg-amber-100/80 text-amber-600 rounded-lg border border-amber-200 transition-colors" 
                                onclick="populateEditPasien('<?= esc($p['no_rm'], 'js') ?>', '<?= esc($p['nik'], 'js') ?>', '<?= esc($p['nama_pasien'], 'js') ?>', '<?= $p['tgl_lahir'] ?>', '<?= $p['jk'] ?>', '<?= esc($p['alamat'] ?? '', 'js') ?>', '<?= esc($p['no_bpjs'] ?? '', 'js') ?>')">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </button>
                            <a href="<?= base_url('admin/pasien/hapus/' . $p['no_rm']) ?>" class="p-2 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg border border-rose-200 transition-colors" 
                                onclick="return confirm('Apakah Anda yakin ingin menghapus data pasien <?= esc($p['nama_pasien'], 'js') ?>?')">
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

<!-- Modal Tambah Pasien -->
<div id="modalTambahPasien" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform scale-95 transition-all duration-300">
        <!-- Header -->
        <div class="bg-secondary text-white px-5 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">person_add</span>
                <h3 class="font-headline-sm text-base font-bold text-white">Tambah Pasien Baru</h3>
            </div>
            <button type="button" onclick="closeModal('modalTambahPasien')" class="text-white/80 hover:text-white p-1 rounded-full hover:bg-white/10 transition-all">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
        
        <!-- Form -->
        <form method="POST" action="<?= base_url('admin/pasien/simpan') ?>" class="p-5 space-y-3">
            <?= csrf_field() ?>
            
            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Nomor NIK <span class="text-rose-500">*</span></label>
                <input type="text" name="nik" required maxlength="16" minlength="16" class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm py-2" placeholder="Masukkan 16 digit NIK">
                <div id="nik-feedback-tambah" class="text-[11px] font-semibold mt-1 hidden"></div>
            </div>
            
            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Nama Lengkap Pasien <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_pasien" required class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm py-2" placeholder="Contoh: Budi Santoso">
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Tanggal Lahir <span class="text-rose-500">*</span></label>
                    <input type="date" name="tgl_lahir" required class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm py-2">
                </div>
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Jenis Kelamin <span class="text-rose-500">*</span></label>
                    <select name="jk" required class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm bg-white py-2">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
            </div>
            
            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Alamat Tempat Tinggal</label>
                <textarea name="alamat" rows="2" class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm min-h-[45px] py-1.5 px-3 resize-y" placeholder="Masukkan alamat lengkap pasien..."></textarea>
            </div>
            
            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Nomor BPJS (Opsional)</label>
                <input type="text" name="no_bpjs" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm py-2" placeholder="Contoh: 0001XXXXXXXXX">
            </div>
            
            <div class="bg-slate-50 border border-slate-100 p-2.5 rounded-xl flex items-start gap-2 text-[10px] text-slate-500">
                <span class="material-symbols-outlined text-secondary text-[16px] shrink-0 mt-0.5" style="font-variation-settings: 'FILL' 1;">info</span>
                <p>Nomor Rekam Medis (RM) akan dibuat dan di-generate secara otomatis oleh sistem rumah sakit setelah formulir disimpan.</p>
            </div>
            
            <!-- Actions -->
            <div class="pt-3 border-t border-slate-100 flex gap-2 justify-end">
                <button type="button" onclick="closeModal('modalTambahPasien')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200/80 text-slate-600 rounded-xl text-xs font-bold transition-all">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 bg-secondary text-white hover:opacity-90 rounded-xl text-xs font-bold shadow-sm transition-all">
                    Simpan Pasien
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Pasien -->
<div id="modalEditPasien" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform scale-95 transition-all duration-300">
        <!-- Header -->
        <div class="bg-amber-500 text-white px-5 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">edit_square</span>
                <h3 class="font-headline-sm text-base font-bold text-white">Edit Data Pasien</h3>
            </div>
            <button type="button" onclick="closeModal('modalEditPasien')" class="text-white/80 hover:text-white p-1 rounded-full hover:bg-white/10 transition-all">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
        
        <!-- Form -->
        <form method="POST" action="<?= base_url('admin/pasien/edit') ?>" class="p-5 space-y-3">
            <?= csrf_field() ?>
            <input type="hidden" name="no_rm" id="edit_no_rm">
            
            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Nomor NIK <span class="text-rose-500">*</span></label>
                <input type="text" name="nik" id="edit_nik" required maxlength="16" minlength="16" class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm py-2">
                <div id="nik-feedback-edit" class="text-[11px] font-semibold mt-1 hidden"></div>
            </div>
            
            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Nama Lengkap Pasien <span class="text-rose-500">*</span></label>
                <input type="text" name="nama_pasien" id="edit_nama_pasien" required class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm py-2">
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Tanggal Lahir <span class="text-rose-500">*</span></label>
                    <input type="date" name="tgl_lahir" id="edit_tgl_lahir" required class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm py-2">
                </div>
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Jenis Kelamin <span class="text-rose-500">*</span></label>
                    <select name="jk" id="edit_jk" required class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm bg-white py-2">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
            </div>
            
            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Alamat Tempat Tinggal</label>
                <textarea name="alamat" id="edit_alamat" rows="2" class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm min-h-[45px] py-1.5 px-3 resize-y"></textarea>
            </div>
            
            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Nomor BPJS</label>
                <input type="text" name="no_bpjs" id="edit_no_bpjs" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm py-2">
            </div>
            
            <!-- Actions -->
            <div class="pt-3 border-t border-slate-100 flex gap-2 justify-end">
                <button type="button" onclick="closeModal('modalEditPasien')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200/80 text-slate-600 rounded-xl text-xs font-bold transition-all">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-xs font-bold shadow-sm transition-all">
                    Simpan Perubahan
                </button>
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

function populateEditPasien(noRm, nik, nama, tglLahir, jk, alamat, noBpjs) {
    document.getElementById('edit_no_rm').value = noRm;
    document.getElementById('edit_nik').value = nik;
    document.getElementById('edit_nama_pasien').value = nama;
    document.getElementById('edit_tgl_lahir').value = tglLahir;
    document.getElementById('edit_jk').value = jk;
    document.getElementById('edit_alamat').value = alamat;
    document.getElementById('edit_no_bpjs').value = noBpjs;
    openModal('modalEditPasien');
    
    // Reset feedback on populate
    $('#nik-feedback-edit').addClass('hidden').empty();
    $('button[type="submit"]', '#modalEditPasien').prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');
}

$(document).ready(function() {
    // 1. Tambah Pasien - NIK dynamic check
    const nikInputTambah = $('input[name="nik"]', '#modalTambahPasien');
    const feedbackTambah = $('#nik-feedback-tambah');
    const submitTambah = $('button[type="submit"]', '#modalTambahPasien');

    nikInputTambah.on('input propertychange', function() {
        const nik = $(this).val().trim();
        $(this).val(nik.replace(/[^0-9]/g, ''));
        const cleanNik = $(this).val();

        if (cleanNik.length === 16) {
            feedbackTambah.removeClass('hidden text-rose-500 text-emerald-500').addClass('text-slate-400').text('Memeriksa NIK...');
            submitTambah.prop('disabled', true);

            $.ajax({
                url: '<?= site_url("admin/pasien/cek-nik") ?>',
                type: 'GET',
                data: { nik: cleanNik },
                success: function(res) {
                    if (res.registered) {
                        feedbackTambah.removeClass('text-slate-400 text-emerald-500').addClass('text-rose-500')
                            .html(`<span class="flex items-center gap-1 mt-0.5"><span class="material-symbols-outlined text-[13px]">cancel</span> NIK terdaftar atas nama ${res.nama_pasien} (${res.no_rm})</span>`);
                        submitTambah.prop('disabled', true).addClass('opacity-50 cursor-not-allowed');
                    } else {
                        feedbackTambah.removeClass('text-slate-400 text-rose-500').addClass('text-emerald-500')
                            .html('<span class="flex items-center gap-1 mt-0.5"><span class="material-symbols-outlined text-[13px]">check_circle</span> NIK tersedia dan dapat digunakan</span>');
                        submitTambah.prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');
                    }
                },
                error: function() {
                    feedbackTambah.removeClass('hidden text-rose-500 text-emerald-500').addClass('text-rose-500').text('Gagal memverifikasi NIK.');
                }
            });
        } else {
            feedbackTambah.addClass('hidden').empty();
            submitTambah.prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');
        }
    });

    // 2. Edit Pasien - NIK dynamic check
    const nikInputEdit = $('#edit_nik');
    const feedbackEdit = $('#nik-feedback-edit');
    const submitEdit = $('button[type="submit"]', '#modalEditPasien');

    nikInputEdit.on('input propertychange', function() {
        const nik = $(this).val().trim();
        $(this).val(nik.replace(/[^0-9]/g, ''));
        const cleanNik = $(this).val();
        const currentRm = $('#edit_no_rm').val();

        if (cleanNik.length === 16) {
            feedbackEdit.removeClass('hidden text-rose-500 text-emerald-500').addClass('text-slate-400').text('Memeriksa NIK...');
            submitEdit.prop('disabled', true);

            $.ajax({
                url: '<?= site_url("admin/pasien/cek-nik") ?>',
                type: 'GET',
                data: { nik: cleanNik, exclude_rm: currentRm },
                success: function(res) {
                    if (res.registered) {
                        feedbackEdit.removeClass('text-slate-400 text-emerald-500').addClass('text-rose-500')
                            .html(`<span class="flex items-center gap-1 mt-0.5"><span class="material-symbols-outlined text-[13px]">cancel</span> NIK terdaftar atas nama ${res.nama_pasien} (${res.no_rm})</span>`);
                        submitEdit.prop('disabled', true).addClass('opacity-50 cursor-not-allowed');
                    } else {
                        feedbackEdit.removeClass('text-slate-400 text-rose-500').addClass('text-emerald-500')
                            .html('<span class="flex items-center gap-1 mt-0.5"><span class="material-symbols-outlined text-[13px]">check_circle</span> NIK tersedia dan dapat digunakan</span>');
                        submitEdit.prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');
                    }
                },
                error: function() {
                    feedbackEdit.removeClass('hidden text-rose-500 text-emerald-500').addClass('text-rose-500').text('Gagal memverifikasi NIK.');
                }
            });
        } else {
            feedbackEdit.addClass('hidden').empty();
            submitEdit.prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');
        }
    });

    // Reset feedback on modal close
    window.closeModalOriginal = window.closeModal;
    window.closeModal = function(modalId) {
        closeModalOriginal(modalId);
        if (modalId === 'modalTambahPasien') {
            feedbackTambah.addClass('hidden').empty();
            submitTambah.prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');
            // Clear input values
            $('input[name="nik"]', '#modalTambahPasien').val('');
            $('input[name="nama_pasien"]', '#modalTambahPasien').val('');
            $('input[name="tgl_lahir"]', '#modalTambahPasien').val('');
            $('textarea[name="alamat"]', '#modalTambahPasien').val('');
            $('input[name="no_bpjs"]', '#modalTambahPasien').val('');
        } else if (modalId === 'modalEditPasien') {
            feedbackEdit.addClass('hidden').empty();
            submitEdit.prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');
        }
    };
});
</script>
<?= $this->endSection() ?>
