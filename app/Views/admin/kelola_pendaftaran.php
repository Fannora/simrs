<?php $title = 'Kelola Pendaftaran & Janji Temu'; ?>
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<!-- Include jQuery and SweetAlert2 for premium notifications -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Filter & Action Header -->
<div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 mb-6 animate-in fade-in duration-300">
    <button type="button" onclick="openModal('modalTambahPendaftaran')" class="bg-secondary text-white hover:opacity-90 px-5 py-2.5 rounded-xl font-bold flex items-center gap-2 shadow-sm transition-all whitespace-nowrap">
        <span class="material-symbols-outlined">calendar_add_on</span>
        Pendaftaran Baru
    </button>
    
    <!-- Filter Form -->
    <form method="GET" action="<?= base_url('admin/pendaftaran') ?>" class="flex flex-wrap items-center gap-3 w-full xl:w-auto">
        <div class="flex items-center gap-2">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider whitespace-nowrap">Tanggal:</label>
            <input type="date" name="tanggal" value="<?= esc($tanggal) ?>" class="rounded-xl border-outline-variant/65 text-sm py-2 px-3 focus:ring-secondary focus:border-secondary transition-all bg-white text-slate-700">
        </div>
        
        <div class="flex items-center gap-2">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider whitespace-nowrap">Dokter:</label>
            <select name="id_dokter" class="rounded-xl border-outline-variant/65 text-sm py-2 px-3 focus:ring-secondary focus:border-secondary transition-all bg-white text-slate-700 w-52">
                <option value="">-- Semua Dokter --</option>
                <?php foreach ($dokter as $d): ?>
                    <option value="<?= $d['id_dokter'] ?>" <?= $id_dokter == $d['id_dokter'] ? 'selected' : '' ?>>
                        <?= esc($d['nama_dokter']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="flex items-center gap-2">
            <button type="submit" class="bg-secondary text-white hover:opacity-90 px-5 py-2 rounded-xl text-sm font-bold shadow-sm transition-all h-[38px] flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">filter_alt</span> Saring
            </button>
            <?php if (!empty($id_dokter) || $tanggal != date('Y-m-d')): ?>
                <a href="<?= base_url('admin/pendaftaran') ?>" class="border border-outline-variant/60 hover:bg-slate-50 text-slate-600 px-4 py-2 rounded-xl text-sm font-bold transition-all h-[38px] flex items-center justify-center">
                    Reset
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Table Card -->
<div class="bg-white border border-outline-variant/65 rounded-2xl shadow-sm overflow-hidden animate-in fade-in slide-in-from-top-4 duration-500">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-outline-variant/35 bg-slate-50 text-slate-600 text-xs font-bold uppercase tracking-wider">
                    <th class="py-4 px-6">No. Rawat</th>
                    <th class="py-4 px-6">Pasien</th>
                    <th class="py-4 px-6">Dokter / Poli</th>
                    <th class="py-4 px-6">Jadwal &amp; Jam</th>
                    <th class="py-4 px-6">Keluhan</th>
                    <th class="py-4 px-6 text-center">Status</th>
                    <th class="py-4 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/25 text-sm text-slate-700">
                <?php if (empty($pendaftaran)): ?>
                <tr>
                    <td colspan="7" class="text-center text-slate-400 py-12">
                        <span class="material-symbols-outlined text-[48px] text-slate-300 block mb-2">event_busy</span>
                        Tidak ada janji temu aktif terdaftar untuk kriteria filter ini.
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($pendaftaran as $p): ?>
                <tr class="hover:bg-slate-50/45 transition-colors">
                    <td class="py-5 px-6">
                        <strong class="font-mono text-sm text-red-800 font-bold"><?= esc($p['no_rawat']) ?></strong>
                    </td>
                    <td class="py-5 px-6">
                        <div class="font-bold text-slate-800"><?= esc($p['nama_pasien']) ?></div>
                        <div class="text-xs text-slate-400 font-mono"><?= esc($p['no_rm']) ?></div>
                    </td>
                    <td class="py-5 px-6">
                        <div class="font-semibold text-slate-700"><?= esc($p['nama_dokter']) ?></div>
                        <div class="text-xs text-slate-400 font-semibold uppercase tracking-wider"><?= esc($p['nama_poli']) ?></div>
                    </td>
                    <td class="py-5 px-6 font-medium">
                        <div class="text-slate-700"><?= date('d/m/Y', strtotime($p['tgl_daftar'])) ?></div>
                        <div class="text-xs text-secondary font-bold flex items-center gap-1 mt-0.5">
                            <span class="material-symbols-outlined text-xs">schedule</span>
                            <?= substr($p['jam_kunjungan'], 0, 5) ?>
                        </div>
                    </td>
                    <td class="py-5 px-6 max-w-xs truncate" title="<?= esc($p['keluhan_awal']) ?>">
                        <?= esc($p['keluhan_awal']) ?>
                    </td>
                    <td class="py-5 px-6 text-center whitespace-nowrap">
                        <?php
                            $status = $p['status_periksa'];
                            $badgeClass = 'bg-slate-50 text-slate-600 border-slate-200';
                            if ($status === 'Belum Diperiksa') $badgeClass = 'bg-blue-50 text-blue-700 border-blue-200';
                            elseif ($status === 'Sedang Diperiksa') $badgeClass = 'bg-amber-50 text-amber-700 border-amber-200';
                            elseif ($status === 'Selesai') $badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                            elseif ($status === 'Tidak Hadir') $badgeClass = 'bg-rose-50 text-rose-700 border-rose-200';
                            elseif ($status === 'Batal') $badgeClass = 'bg-slate-100 text-slate-400 border-slate-200 line-through';
                        ?>
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full border <?= $badgeClass ?> whitespace-nowrap">
                            <?= esc($status) ?>
                        </span>
                    </td>
                    <td class="py-5 px-6 text-center">
                        <div class="inline-flex gap-2">
                            <?php if (in_array($status, ['Belum Diperiksa', 'Sedang Diperiksa'])): ?>
                                <button type="button" class="p-2 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg border border-amber-200 transition-colors flex items-center gap-1.5 font-semibold text-xs" 
                                    onclick="openRescheduleModal('<?= esc($p['no_rawat'], 'js') ?>', '<?= $p['id_poli'] ?>', '<?= $p['id_dokter'] ?>', '<?= $p['tgl_daftar'] ?>', '<?= $p['slot_waktu'] ?>')">
                                    <span class="material-symbols-outlined text-[16px]">edit_calendar</span>
                                    Reschedule
                                </button>
                                <button type="button" class="p-2 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg border border-rose-200 transition-colors flex items-center gap-1.5 font-semibold text-xs" 
                                    onclick="confirmCancel('<?= esc($p['no_rawat'], 'js') ?>', '<?= esc($p['nama_pasien'], 'js') ?>')">
                                    <span class="material-symbols-outlined text-[16px]">block</span>
                                    Batalkan
                                </button>
                            <?php else: ?>
                                <span class="text-xs text-slate-400 italic font-medium">Tidak ada aksi</span>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Pendaftaran (Walk-in) -->
<div id="modalTambahPendaftaran" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform scale-95 transition-all duration-300">
        <!-- Header -->
        <div class="bg-secondary text-white px-5 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">calendar_month</span>
                <h3 class="font-headline-sm text-base font-bold text-white">Pendaftaran Baru (Walk-in)</h3>
            </div>
            <button type="button" onclick="closeModal('modalTambahPendaftaran')" class="text-white/80 hover:text-white p-1 rounded-full hover:bg-white/10 transition-all">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
        
        <!-- Form -->
        <form method="POST" action="<?= base_url('admin/pendaftaran/simpan') ?>" class="p-5 space-y-3">
            <?= csrf_field() ?>
            
            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Pilih Pasien <span class="text-rose-500">*</span></label>
                <select name="no_rm" required class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm bg-white py-2">
                    <option value="" disabled selected>-- Pilih Pasien --</option>
                    <?php foreach ($pasien as $pa): ?>
                        <option value="<?= $pa['no_rm'] ?>"><?= esc($pa['nama_pasien']) ?> (<?= esc($pa['no_rm']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Poliklinik <span class="text-rose-500">*</span></label>
                    <select id="walkin_poli" name="id_poli" required class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm bg-white py-2">
                        <option value="" disabled selected>-- Pilih Poli --</option>
                        <?php foreach ($poli as $po): ?>
                            <option value="<?= $po['id_poli'] ?>"><?= esc($po['nama_poli']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Dokter Spesialis <span class="text-rose-500">*</span></label>
                    <select id="walkin_dokter" name="id_dokter" required disabled class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm bg-slate-100 py-2">
                        <option value="" disabled selected>-- Pilih Poli Dulu --</option>
                    </select>
                </div>
            </div>
            
            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Tanggal Kunjungan <span class="text-rose-500">*</span></label>
                <input type="date" id="walkin_tanggal" name="tgl_daftar" required min="<?= date('Y-m-d') ?>" disabled class="w-full rounded-xl border-slate-200 bg-slate-100 cursor-not-allowed focus:ring-secondary focus:border-secondary text-sm py-2" value="">
            </div>
            
            <!-- Dynamic Slot Picker -->
            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Slot Waktu Tersedia <span class="text-rose-500">*</span></label>
                <div id="walkin_slots_container" class="grid grid-cols-3 gap-2 max-h-36 overflow-y-auto p-1.5 bg-slate-50 border border-slate-100 rounded-xl text-center">
                    <p class="col-span-3 text-slate-400 text-[11px] py-3">Silakan pilih Dokter &amp; Tanggal terlebih dahulu.</p>
                </div>
            </div>
            
            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Keluhan Awal</label>
                <textarea name="keluhan_awal" rows="2" class="w-full rounded-xl border-slate-200 focus:ring-secondary focus:border-secondary text-sm min-h-[45px] py-1.5 px-3 resize-y" placeholder="Masukkan keluhan awal pasien jika ada..."></textarea>
            </div>
            
            <!-- Actions -->
            <div class="pt-3 border-t border-slate-100 flex gap-2 justify-end">
                <button type="button" onclick="closeModal('modalTambahPendaftaran')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200/80 text-slate-600 rounded-xl text-xs font-bold transition-all">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 bg-secondary text-white hover:opacity-90 rounded-xl text-xs font-bold shadow-sm transition-all">
                    Daftarkan Pasien
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Reschedule Pendaftaran -->
<div id="modalReschedule" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform scale-95 transition-all duration-300">
        <!-- Header -->
        <div class="bg-amber-500 text-white px-5 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">edit_calendar</span>
                <h3 class="font-headline-sm text-base font-bold text-white">Reschedule Janji Temu</h3>
            </div>
            <button type="button" onclick="closeModal('modalReschedule')" class="text-white/80 hover:text-white p-1 rounded-full hover:bg-white/10 transition-all">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
        
        <!-- Form -->
        <form id="rescheduleForm" method="POST" action="" class="p-5 space-y-3">
            <?= csrf_field() ?>
            
            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">No. Rawat</label>
                <input type="text" id="reschedule_no_rawat" readonly class="w-full rounded-xl border-slate-200 bg-slate-100 font-mono text-red-800 font-bold text-sm cursor-not-allowed py-2">
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Poliklinik <span class="text-rose-500">*</span></label>
                    <select id="reschedule_poli" name="id_poli" required class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm bg-white py-2">
                        <option value="" disabled>-- Pilih Poli --</option>
                        <?php foreach ($poli as $po): ?>
                            <option value="<?= $po['id_poli'] ?>"><?= esc($po['nama_poli']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Dokter Spesialis <span class="text-rose-500">*</span></label>
                    <select id="reschedule_dokter" name="id_dokter" required class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm bg-white py-2">
                        <option value="" disabled>-- Pilih Dokter --</option>
                    </select>
                </div>
            </div>
            
            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Tanggal Reschedule Baru <span class="text-rose-500">*</span></label>
                <input type="date" id="reschedule_tanggal" name="tgl_daftar" required min="<?= date('Y-m-d') ?>" class="w-full rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-sm py-2">
            </div>
            
            <!-- Dynamic Slot Picker -->
            <div class="space-y-1">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Slot Waktu Tersedia <span class="text-rose-500">*</span></label>
                <div id="reschedule_slots_container" class="grid grid-cols-3 gap-2 max-h-36 overflow-y-auto p-1.5 bg-slate-50 border border-slate-100 rounded-xl text-center">
                    <p class="col-span-3 text-slate-400 text-[11px] py-3">Silakan tunggu, sedang memuat jadwal...</p>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="pt-3 border-t border-slate-100 flex gap-2 justify-end">
                <button type="button" onclick="closeModal('modalReschedule')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200/80 text-slate-600 rounded-xl text-xs font-bold transition-all">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-xs font-bold shadow-sm transition-all">
                    Konfirmasi Reschedule
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
// Open / Close Modals
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

// SweetAlert2 Confirmation for Booking Cancellation
function confirmCancel(noRawat, namaPasien) {
    Swal.fire({
        title: 'Batalkan Pendaftaran?',
        html: `Apakah Anda yakin ingin membatalkan pendaftaran <strong class="text-black font-bold">${noRawat}</strong> untuk pasien <strong class="text-black font-bold">${namaPasien}</strong>?<br><br><span class="text-rose-600 font-medium">Tindakan ini akan membebaskan slot waktu dokter kembali.</span>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#E11D48', // alert-crimson
        cancelButtonColor: '#64748B', // Slate gray
        confirmButtonText: 'Ya, Batalkan',
        cancelButtonText: 'Kembali',
        background: '#ffffff',
        customClass: {
            popup: 'rounded-[24px] border border-outline-variant font-body-md shadow-2xl p-6',
            title: 'font-headline-sm text-black font-bold',
            confirmButton: 'rounded-xl px-5 py-3 text-white font-semibold',
            cancelButton: 'rounded-xl px-5 py-3 text-white font-semibold'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `<?= base_url('admin/pendaftaran/batal') ?>/${noRawat}`;
        }
    });
}

// Dynamic AJAX populated slot loader
function loadSlots(idDokter, tanggal, containerId, activeSlot = null) {
    const container = document.getElementById(containerId);
    container.innerHTML = `
        <div class="col-span-3 py-4 flex items-center justify-center gap-2 text-slate-400 text-xs">
            <svg class="animate-spin h-4 w-4 text-secondary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Memuat slot waktu...
        </div>
    `;

    $.ajax({
        url: '<?= site_url("admin/pendaftaran/slot") ?>',
        type: 'GET',
        data: { id_dokter: idDokter, tanggal: tanggal },
        success: function(slots) {
            container.innerHTML = '';
            if (slots.error) {
                container.innerHTML = `<p class="col-span-3 text-rose-500 font-semibold text-xs py-4">${slots.error}</p>`;
                return;
            }

            if (slots.length === 0) {
                container.innerHTML = `<p class="col-span-3 text-slate-400 text-xs py-4">Tidak ada slot praktik hari ini.</p>`;
                return;
            }

            slots.forEach(s => {
                const isPenuh = s.status === 'penuh';
                const isSelected = activeSlot === s.slot;
                const buttonClass = isSelected 
                    ? 'bg-amber-500 text-white font-bold border-amber-600 scale-102 shadow-sm' 
                    : (isPenuh ? 'bg-rose-50 border-rose-100 text-rose-300 cursor-not-allowed opacity-60' : 'bg-white hover:bg-amber-500 hover:text-white border-slate-200 text-slate-700 hover:border-amber-600 cursor-pointer hover:scale-102 hover:shadow-sm');

                const disabledAttr = isPenuh ? 'disabled' : '';
                const checkedAttr = isSelected ? 'checked' : '';

                container.insertAdjacentHTML('beforeend', `
                    <label class="group border rounded-xl py-1.5 px-2 flex flex-col items-center transition-all ${buttonClass} relative select-none">
                        <input type="radio" name="slot_waktu" value="${s.slot}" required ${disabledAttr} ${checkedAttr} class="absolute opacity-0">
                        <span class="text-xs font-bold">${s.slot}</span>
                        <span class="text-[9px] uppercase font-semibold mt-0.5 tracking-wider transition-colors ${isSelected ? 'text-white/80' : (isPenuh ? 'text-rose-400' : 'text-slate-400 group-hover:text-white/80')}">
                            ${isPenuh ? 'Penuh' : `Sisa ${s.sisa}`}
                        </span>
                    </label>
                `);
            });

            // Handle selection style change visually
            $(`#${containerId} label`).on('click', function() {
                if ($(this).find('input').is(':disabled')) return;
                
                // Reset all non-disabled labels to default unselected classes
                $(`#${containerId} label`).each(function() {
                    if (!$(this).find('input').is(':disabled')) {
                        $(this).removeClass('bg-amber-500 text-white border-amber-600 scale-102 shadow-sm font-bold')
                               .addClass('bg-white border-slate-200 text-slate-700 hover:border-amber-600 hover:bg-amber-500 hover:text-white hover:shadow-sm hover:scale-102');
                        $(this).find('span:last-child').removeClass('text-white/80').addClass('text-slate-400');
                    }
                });
                
                // Set the clicked label to selected classes
                $(this).removeClass('bg-white border-slate-200 text-slate-700 hover:border-amber-600 hover:bg-amber-500 hover:text-white hover:shadow-sm hover:scale-102')
                       .addClass('bg-amber-500 text-white border-amber-600 scale-102 shadow-sm font-bold');
                $(this).find('span:last-child').removeClass('text-slate-400').addClass('text-white/80');
                $(this).find('input').prop('checked', true);
            });
        },
        error: function() {
            container.innerHTML = `<p class="col-span-3 text-rose-500 text-xs py-4">Gagal memuat jadwal slot. Coba lagi.</p>`;
        }
    });
}

$(document).ready(function() {
    // ============================================
    // WALKIN PENDAFTARAN EVENT HANDLERS
    // ============================================
    
    // 1. When Poliklinik changes
    $('#walkin_poli').on('change', function() {
        const idPoli = $(this).val();
        const docSelect = $('#walkin_dokter');
        const tglInput = $('#walkin_tanggal');
        
        // Reset and disable doctor select
        docSelect.prop('disabled', true).addClass('bg-slate-100');
        docSelect.html('<option value="" disabled selected>Memuat dokter...</option>');
        
        // Reset and disable date input
        tglInput.prop('disabled', true).addClass('bg-slate-100 cursor-not-allowed').val('');
        
        // Reset slots container
        $('#walkin_slots_container').html('<p class="col-span-3 text-slate-400 text-xs py-4">Silakan pilih Dokter &amp; Tanggal terlebih dahulu.</p>');

        $.ajax({
            url: '<?= site_url("admin/pendaftaran/dokter") ?>',
            type: 'GET',
            data: { id_poli: idPoli },
            success: function(dokterList) {
                if (dokterList.length === 0) {
                    docSelect.html('<option value="" disabled selected>Tidak ada dokter aktif di poli ini</option>');
                    return;
                }
                docSelect.html('<option value="" disabled selected>-- Pilih Dokter --</option>');
                dokterList.forEach(d => {
                    docSelect.append(`<option value="${d.id_dokter}">${d.nama_dokter} (${d.jam_mulai.substring(0, 5)} - ${d.jam_selesai.substring(0, 5)})</option>`);
                });
                docSelect.prop('disabled', false).removeClass('bg-slate-100');
            },
            error: function() {
                docSelect.html('<option value="" disabled selected>Gagal memuat data dokter</option>');
            }
        });
    });

    // 2. When Doctor changes
    $('#walkin_dokter').on('change', function() {
        const idDokter = $(this).val();
        const tglInput = $('#walkin_tanggal');
        
        if (idDokter) {
            // Enable date input
            tglInput.prop('disabled', false).removeClass('bg-slate-100 cursor-not-allowed');
            
            // If date already has a value, load slots
            const tanggal = tglInput.val();
            if (tanggal) {
                loadSlots(idDokter, tanggal, 'walkin_slots_container');
            } else {
                $('#walkin_slots_container').html('<p class="col-span-3 text-slate-400 text-xs py-4">Silakan pilih Tanggal Kunjungan.</p>');
            }
        } else {
            // Disable date input
            tglInput.prop('disabled', true).addClass('bg-slate-100 cursor-not-allowed').val('');
            $('#walkin_slots_container').html('<p class="col-span-3 text-slate-400 text-xs py-4">Silakan pilih Dokter &amp; Tanggal terlebih dahulu.</p>');
        }
    });

    // 3. When Date changes
    $('#walkin_tanggal').on('change', function() {
        const idDokter = $('#walkin_dokter').val();
        const tanggal = $(this).val();

        if (idDokter && tanggal) {
            loadSlots(idDokter, tanggal, 'walkin_slots_container');
        }
    });

    // ============================================
    // RESCHEDULE PENDAFTARAN EVENT HANDLERS
    // ============================================
    $('#reschedule_poli').on('change', function(e, preselectedDocId = null) {
        const idPoli = $(this).val();
        const docSelect = $('#reschedule_dokter');
        
        docSelect.prop('disabled', true).addClass('bg-slate-100');
        docSelect.html('<option value="" disabled selected>Memuat dokter...</option>');
        
        $.ajax({
            url: '<?= site_url("admin/pendaftaran/dokter") ?>',
            type: 'GET',
            data: { id_poli: idPoli },
            success: function(dokterList) {
                if (dokterList.length === 0) {
                    docSelect.html('<option value="" disabled selected>Tidak ada dokter aktif di poli ini</option>');
                    return;
                }
                docSelect.html('<option value="" disabled selected>-- Pilih Dokter --</option>');
                dokterList.forEach(d => {
                    const selected = preselectedDocId == d.id_dokter ? 'selected' : '';
                    docSelect.append(`<option value="${d.id_dokter}" ${selected}>${d.nama_dokter} (${d.jam_mulai.substring(0, 5)} - ${d.jam_selesai.substring(0, 5)})</option>`);
                });
                docSelect.prop('disabled', false).removeClass('bg-slate-100');
                

                if (preselectedDocId) {
                    const tanggal = $('#reschedule_tanggal').val();
                    const activeSlot = $('#rescheduleForm').data('active-slot');
                    loadSlots(preselectedDocId, tanggal, 'reschedule_slots_container', activeSlot);
                }
            },
            error: function() {
                docSelect.html('<option value="" disabled selected>Gagal memuat data dokter</option>');
            }
        });
    });

    $('#reschedule_dokter, #reschedule_tanggal').on('change', function() {
        const idDokter = $('#reschedule_dokter').val();
        const tanggal = $('#reschedule_tanggal').val();

        if (idDokter && tanggal) {
            loadSlots(idDokter, tanggal, 'reschedule_slots_container');
        }
    });
});

// Populate & Trigger Reschedule Modal
function openRescheduleModal(noRawat, idPoli, idDokter, tanggal, activeSlot) {
    document.getElementById('reschedule_no_rawat').value = noRawat;
    document.getElementById('reschedule_tanggal').value = tanggal;
    document.getElementById('rescheduleForm').action = `<?= site_url('admin/pendaftaran/reschedule') ?>/${noRawat}`;
    
    // Save current active slot for reference
    $('#rescheduleForm').data('active-slot', activeSlot);
    
    // Set poli select option
    $('#reschedule_poli').val(idPoli);
    
    // Trigger poli change dynamically, passing doctor to pre-select
    $('#reschedule_poli').trigger('change', [idDokter]);

    openModal('modalReschedule');
}
</script>
<?= $this->endSection() ?>
