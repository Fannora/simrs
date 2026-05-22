<?php $title = 'Booking Appointment'; ?>
<?= $this->extend('pasien/layout') ?>
<?= $this->section('content') ?>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    <strong>Gagal!</strong> <?= session()->getFlashdata('error') ?>
  </div>
<?php endif; ?>
<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    <strong>Berhasil!</strong> <?= session()->getFlashdata('success') ?>
  </div>
<?php endif; ?>

<!-- WIZARD STEPS INDICATOR -->
<div class="card mb-2">
  <div class="card-body py-2">
    <div class="row text-center">
      <div class="col-md-4">
        <div class="step-indicator active" id="indicator-1">
          <span class="badge badge-pill badge-info px-2 py-1" id="badge-1">
            <i class="la la-hospital-o"></i> 1
          </span>
          <span class="step-label ml-1 font-weight-bold">Pilih Layanan</span>
        </div>
      </div>
      <div class="col-md-4">
        <div class="step-indicator" id="indicator-2">
          <span class="badge badge-pill badge-secondary px-2 py-1" id="badge-2">
            <i class="la la-calendar"></i> 2
          </span>
          <span class="step-label ml-1">Pilih Jadwal</span>
        </div>
      </div>
      <div class="col-md-4">
        <div class="step-indicator" id="indicator-3">
          <span class="badge badge-pill badge-secondary px-2 py-1" id="badge-3">
            <i class="la la-check-circle"></i> 3
          </span>
          <span class="step-label ml-1">Konfirmasi</span>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- FORM MULTI-STEP -->
<form method="POST" action="<?= base_url('pasien/booking/store') ?>" id="bookingForm">
  <?= csrf_field() ?>
  <input type="hidden" id="selectedPoliNama" name="nama_poli_display">
  <input type="hidden" id="selectedDokterNama" name="nama_dokter_display">

  <!-- ============ STEP 1: Pilih Poli & Dokter ============ -->
  <div id="step1">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Pilih Poli</h4>
      </div>
      <div class="card-content">
        <div class="card-body">

          <!-- Grid card poli -->
          <div class="row" id="poliContainer">
            <?php foreach ($poli as $p): ?>
            <div class="col-md-4 mb-2">
              <div class="card border poli-card" data-id="<?= $p['id_poli'] ?>"
                   style="cursor:pointer; border: 2px solid #e0e0e0 !important; transition: all 0.2s; margin-bottom:0;">
                <div class="card-body text-center py-2">
                  <i class="la la-stethoscope font-large-1 info"></i>
                  <h6 class="mt-1 mb-0"><?= esc($p['nama_poli']) ?></h6>
                  <small class="text-muted"><i class="la la-map-marker"></i> <?= esc($p['gedung']) ?></small>
                  <input type="radio" name="id_poli" value="<?= $p['id_poli'] ?>" class="d-none poli-radio">
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>

          <!-- Dokter section (awalnya hidden) -->
          <div id="dokterSection" class="mt-2" style="display:none;">
            <h5>Pilih Dokter</h5>
            <div id="dokterLoading" class="text-center py-2" style="display:none;">
              <div class="spinner-border text-info" role="status"></div>
              <span class="ml-1">Memuat dokter...</span>
            </div>
            <div id="dokterContainer" class="row"></div>
            <input type="hidden" name="id_dokter" id="selectedDokter">
          </div>

        </div>
      </div>
    </div>
    <div class="text-right mb-2">
      <button type="button" id="toStep2" class="btn btn-info" disabled>
        Lanjutkan <i class="la la-arrow-right"></i>
      </button>
    </div>
  </div>

  <!-- ============ STEP 2: Pilih Jadwal ============ -->
  <div id="step2" style="display:none;">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Pilih Jadwal</h4>
      </div>
      <div class="card-content">
        <div class="card-body">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Tanggal Kunjungan <span class="danger">*</span></label>
                <input type="date" name="tgl_daftar" id="tglDaftar" class="form-control" required>
                <small class="text-muted">* Tidak tersedia pada hari Minggu</small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Keluhan Awal <span class="danger">*</span></label>
                <textarea name="keluhan_awal" id="keluhanAwal" class="form-control" rows="3"
                          placeholder="Jelaskan keluhan Anda..." maxlength="500" required></textarea>
                <small id="charCount" class="text-muted">0/500 karakter</small>
              </div>
            </div>
          </div>

          <!-- Slot waktu -->
          <div id="slotSection" style="display:none;">
            <label>Pilih Slot Waktu <span class="danger">*</span></label>
            <div id="slotLoading" style="display:none;" class="text-center py-2">
              <div class="spinner-border text-info" role="status"></div>
            </div>
            <div id="slotContainer" class="d-flex flex-wrap mt-1"></div>
            <input type="hidden" name="slot_waktu" id="selectedSlot">
            <div class="mt-1">
              <span class="badge badge-success"><i class="la la-check"></i> Tersedia</span>
              <span class="badge badge-warning"><i class="la la-exclamation-triangle"></i> Hampir Penuh</span>
              <span class="badge badge-danger"><i class="la la-times"></i> Penuh</span>
            </div>
          </div>

        </div>
      </div>
    </div>
    <div class="d-flex justify-content-between mb-2">
      <button type="button" id="backToStep1" class="btn btn-outline-secondary">
        <i class="la la-arrow-left"></i> Kembali
      </button>
      <button type="button" id="toStep3" class="btn btn-info" disabled>
        Lanjutkan <i class="la la-arrow-right"></i>
      </button>
    </div>
  </div>

  <!-- ============ STEP 3: Konfirmasi ============ -->
  <div id="step3" style="display:none;">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Konfirmasi Booking</h4>
      </div>
      <div class="card-content">
        <div class="card-body">
          <table class="table table-bordered">
            <tr><th width="35%">Pasien</th><td><?= session()->get('nama_lengkap') ?></td></tr>
            <tr><th>No. Rekam Medis</th><td><?= session()->get('no_rm') ?></td></tr>
            <tr><th>Poli</th><td id="confirm-poli">-</td></tr>
            <tr><th>Dokter</th><td id="confirm-dokter">-</td></tr>
            <tr><th>Tanggal</th><td id="confirm-tanggal">-</td></tr>
            <tr><th>Jam</th><td id="confirm-jam">-</td></tr>
            <tr><th>Keluhan</th><td id="confirm-keluhan">-</td></tr>
          </table>
          <div class="form-group mt-2">
            <label class="d-flex align-items-center" style="cursor:pointer;">
              <input type="checkbox" id="agreeCheck" class="mr-1">
              Saya menyatakan data di atas sudah benar dan ingin melanjutkan booking.
            </label>
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-between mb-2">
      <button type="button" id="backToStep2" class="btn btn-outline-secondary">
        <i class="la la-arrow-left"></i> Edit
      </button>
      <button type="submit" id="submitBooking" class="btn btn-success" disabled>
        <i class="la la-check-circle"></i> Konfirmasi Booking
      </button>
    </div>
  </div>

</form>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
$(document).ready(function() {

  // ============================
  // STEP NAVIGATION
  // ============================
  function showStep(n) {
    $('#step1, #step2, #step3').hide();
    $('#step' + n).fadeIn(300);

    // Reset all indicators
    for (var i = 1; i <= 3; i++) {
      $('#badge-' + i).removeClass('badge-info badge-success').addClass('badge-secondary');
      $('#indicator-' + i).find('.step-label').removeClass('font-weight-bold');
    }

    // Mark completed steps
    for (var j = 1; j < n; j++) {
      $('#badge-' + j).removeClass('badge-secondary badge-info').addClass('badge-success');
    }

    // Mark active step
    $('#badge-' + n).removeClass('badge-secondary badge-success').addClass('badge-info');
    $('#indicator-' + n).find('.step-label').addClass('font-weight-bold');
  }

  // ============================
  // STEP 1: POLI SELECTION
  // ============================
  $('.poli-card').on('click', function() {
    // Reset all poli cards
    $('.poli-card').css({
      'border': '2px solid #e0e0e0',
      'background': ''
    });
    // Highlight selected
    $(this).css({
      'border': '2px solid #00b5cc',
      'background': '#f0fdff'
    });
    $(this).find('.poli-radio').prop('checked', true);

    var id_poli = $(this).data('id');
    var nama_poli = $(this).find('h6').text();
    $('#selectedPoliNama').val(nama_poli);

    // Reset dokter selection
    $('#selectedDokter').val('');
    $('#selectedDokterNama').val('');
    $('#toStep2').prop('disabled', true);

    fetchDokter(id_poli);
  });

  // ============================
  // FETCH DOKTER (AJAX)
  // ============================
  function fetchDokter(id_poli) {
    $('#dokterSection').show();
    $('#dokterLoading').show();
    $('#dokterContainer').empty();

    $.get('<?= base_url('pasien/booking/dokter') ?>?id_poli=' + id_poli, function(data) {
      $('#dokterLoading').hide();

      if (data.length === 0) {
        $('#dokterContainer').html(
          '<div class="col-12"><p class="text-muted text-center py-2">' +
          '<i class="la la-frown-o font-large-1"></i><br>Tidak ada dokter tersedia untuk poli ini.</p></div>'
        );
        return;
      }

      data.forEach(function(d) {
        var initials = d.nama_dokter.split(' ').slice(0, 2).map(function(w) { return w[0]; }).join('').toUpperCase();
        var card =
          '<div class="col-md-6 mb-1">' +
            '<div class="card border dokter-card" data-id="' + d.id_dokter + '" data-nama="' + d.nama_dokter + '" ' +
            'style="cursor:pointer; border:2px solid #e0e0e0 !important; transition: all 0.2s; margin-bottom:0;">' +
              '<div class="card-body d-flex align-items-center py-2">' +
                '<span class="avatar avatar-md mr-1 rounded-circle d-flex align-items-center justify-content-center text-white font-weight-bold" ' +
                'style="background:#00b5cc; width:45px; height:45px; min-width:45px; font-size:14px;">' + initials + '</span>' +
                '<div>' +
                  '<strong>' + d.nama_dokter + '</strong><br>' +
                  '<small class="text-muted"><i class="la la-clock-o"></i> ' + d.jam_mulai + ' - ' + d.jam_selesai + '</small>' +
                '</div>' +
              '</div>' +
            '</div>' +
          '</div>';
        $('#dokterContainer').append(card);
      });

      // Dokter card click handler
      $('#dokterContainer').off('click', '.dokter-card').on('click', '.dokter-card', function() {
        $('.dokter-card').css({
          'border': '2px solid #e0e0e0',
          'background': ''
        });
        $(this).css({
          'border': '2px solid #00b5cc',
          'background': '#f0fdff'
        });
        $('#selectedDokter').val($(this).data('id'));
        $('#selectedDokterNama').val($(this).data('nama'));
        checkStep1Valid();
      });
    }).fail(function() {
      $('#dokterLoading').hide();
      $('#dokterContainer').html(
        '<div class="col-12"><p class="text-danger text-center py-2">Gagal memuat data dokter.</p></div>'
      );
    });
  }

  function checkStep1Valid() {
    var poliSelected = $('input[name="id_poli"]:checked').length > 0;
    var dokterSelected = $('#selectedDokter').val() !== '';
    $('#toStep2').prop('disabled', !(poliSelected && dokterSelected));
  }

  // ============================
  // STEP 2: DATE & SLOT
  // ============================

  // Set min date = tomorrow
  var tomorrow = new Date();
  tomorrow.setDate(tomorrow.getDate() + 1);
  var minDate = tomorrow.toISOString().split('T')[0];
  $('#tglDaftar').attr('min', minDate);

  // Date validation (no Sunday)
  $('#tglDaftar').on('change', function() {
    var date = new Date(this.value + 'T00:00:00');
    var today = new Date();
    today.setHours(0, 0, 0, 0);

    if (date.getDay() === 0) {
      alert('Booking tidak tersedia pada hari Minggu. Silakan pilih hari lain.');
      this.value = '';
      $('#slotSection').hide();
      $('#selectedSlot').val('');
      checkStep2Valid();
      return;
    }
    if (date <= today) {
      alert('Tanggal harus minimal besok.');
      this.value = '';
      $('#slotSection').hide();
      $('#selectedSlot').val('');
      checkStep2Valid();
      return;
    }
    fetchSlot();
  });

  // Fetch available time slots
  function fetchSlot() {
    var id_dokter = $('#selectedDokter').val();
    var tanggal = $('#tglDaftar').val();
    if (!id_dokter || !tanggal) return;

    $('#slotSection').show();
    $('#slotLoading').show();
    $('#slotContainer').empty();
    $('#selectedSlot').val('');
    checkStep2Valid();

    $.get('<?= base_url('pasien/booking/slot') ?>?id_dokter=' + id_dokter + '&tanggal=' + tanggal, function(data) {
      $('#slotLoading').hide();

      if (data.length === 0) {
        $('#slotContainer').html('<p class="text-muted">Tidak ada slot tersedia untuk tanggal ini.</p>');
        return;
      }

      data.forEach(function(s) {
        var btnClass, disabled = '', label = '';

        if (s.status === 'penuh') {
          btnClass = 'btn-danger';
          disabled = 'disabled';
          label = ' (Penuh)';
        } else if (s.hampir_penuh) {
          btnClass = 'btn-warning';
          label = ' (Sisa ' + s.sisa + ')';
        } else {
          btnClass = 'btn-outline-success';
        }

        var btn = '<button type="button" class="btn ' + btnClass + ' btn-sm mr-1 mb-1 slot-btn" ' +
          'data-slot="' + s.slot + '" ' + disabled + '>' + s.slot + label + '</button>';
        $('#slotContainer').append(btn);
      });

      // Slot click handler
      $('#slotContainer').off('click', '.slot-btn:not([disabled])').on('click', '.slot-btn:not([disabled])', function() {
        // Reset all non-disabled slots
        $('.slot-btn:not([disabled])').each(function() {
          $(this).removeClass('btn-info');
          // Restore original class
          if ($(this).data('original-class')) {
            $(this).addClass($(this).data('original-class'));
          } else {
            $(this).addClass('btn-outline-success');
          }
        });

        // Store original class before changing
        if (!$(this).data('original-class')) {
          var origClass = $(this).hasClass('btn-warning') ? 'btn-warning' : 'btn-outline-success';
          $(this).data('original-class', origClass);
        }

        $(this).removeClass('btn-outline-success btn-warning').addClass('btn-info');
        $('#selectedSlot').val($(this).data('slot'));
        checkStep2Valid();
      });
    }).fail(function() {
      $('#slotLoading').hide();
      $('#slotContainer').html('<p class="text-danger">Gagal memuat slot waktu.</p>');
    });
  }

  // Character counter
  $('#keluhanAwal').on('input', function() {
    var len = $(this).val().length;
    $('#charCount').text(len + '/500 karakter');
    checkStep2Valid();
  });

  function checkStep2Valid() {
    var tanggalFilled = $('#tglDaftar').val() !== '';
    var slotSelected = $('#selectedSlot').val() !== '';
    var keluhanFilled = $('#keluhanAwal').val().trim().length > 0;
    $('#toStep3').prop('disabled', !(tanggalFilled && slotSelected && keluhanFilled));
  }

  // ============================
  // STEP BUTTON EVENTS
  // ============================

  $('#toStep2').on('click', function() {
    showStep(2);
  });

  $('#backToStep1').on('click', function() {
    showStep(1);
  });

  $('#toStep3').on('click', function() {
    // Populate confirmation table
    $('#confirm-poli').text($('#selectedPoliNama').val());
    $('#confirm-dokter').text($('#selectedDokterNama').val());

    var tgl = new Date($('#tglDaftar').val() + 'T00:00:00');
    var bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    var hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    $('#confirm-tanggal').text(hari[tgl.getDay()] + ', ' + tgl.getDate() + ' ' + bulan[tgl.getMonth()] + ' ' + tgl.getFullYear());
    $('#confirm-jam').text($('#selectedSlot').val() + ' WIB');
    $('#confirm-keluhan').text($('#keluhanAwal').val());

    showStep(3);
  });

  $('#backToStep2').on('click', function() {
    showStep(2);
  });

  // ============================
  // AGREEMENT CHECKBOX
  // ============================
  $('#agreeCheck').on('change', function() {
    $('#submitBooking').prop('disabled', !this.checked);
  });

  // ============================
  // SUBMIT WITH LOADING STATE
  // ============================
  $('#bookingForm').on('submit', function() {
    var btn = $('#submitBooking');
    btn.prop('disabled', true);
    btn.html('<i class="la la-spinner la-spin"></i> Memproses...');
  });

});
</script>
<?= $this->endSection() ?>
