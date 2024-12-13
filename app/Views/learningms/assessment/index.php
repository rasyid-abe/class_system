<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>


<div class="card mb-5 mb-xl-10">
  <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
    <div class="card-title m-0">
      <div class="d-grid">
        <button type="button" class="btn btn-primary" onclick="show_modal()">
          <i class="mb-1 fa fa-plus"></i> Penilaian Siswa
        </button>
      </div>
    </div>
  </div>

  <div class="card-body border-top p-9">
    <div id="example-table"></div>
  </div>

</div>


<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_assessment">
  <div class="modal-dialog modal-xl">
    <div class="modal-content" id="content_modal">
      <div class="modal-header">
        <h3 class="modal-title">Tambah Penilaian Siswa</h3>
      </div>
      <div class="modal-body">
        <form id="kt_account_profile_details_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
          <div class="card-body">

            <div class="row mb-6">
              <label class="col-lg-3 col-form-label required fw-semibold fs-6">Judul Penilaian</label>

              <div class="col-lg-9 fv-row fv-plugins-icon-container">
                <input type="text" name="title" class="form-control form-control-lg form-control-solid">
                <small class="hide title_ass text-danger">Judul penilaian harus diisi!</small>
              </div>
            </div>

            <div class="row mb-6">
              <label class="col-lg-3 col-form-label required fw-semibold fs-6">Mata Pelajaran</label>

              <div class="col-lg-9">
                <div class="row">
                  <div class="col-lg-6 fv-row fv-plugins-icon-container">
                    <select name="subject" id="sub_ass" class="form-control" onchange="check_group()">
                      <option value="0">Pilih Mata Pelajaran</option>
                      <?php foreach ($subs as $k => $v): ?>
                        <option value="<?= $k ?>"><?= $v ?></option>
                      <?php endforeach; ?>
                    </select>
                    <small class="hide sub_ass text-danger">Mata Pelajaran harus dipilih!</small>
                  </div>

                  <div class="col-lg-6 fv-row fv-plugins-icon-container">
                    <select name="grade" id="grade_ass" class="form-control" onchange="check_group()">
                      <option value="0">Pilih Kelas</option>
                      <?php foreach ($grade as $k => $v): ?>
                        <option value="<?= $k ?>"><?= $v ?></option>
                      <?php endforeach; ?>
                    </select>
                    <small class="hide grade_ass text-danger">Jenjang Kelas harus dipilih!</small>
                  </div>
                </div>
              </div>
            </div>

            <div class="row mb-6">
              <label class="col-lg-3 col-form-label fw-semibold fs-6">
                <span class="required">Kelompok Belajar</span>
              </label>

              <div class="col-lg-9 fv-row fv-plugins-icon-container">
                <select class="form-select form-select-solid hide" name=groups[] id="multiple-select-group" data-control="select2" data-close-on-select="false" data-placeholder="Pilih Kelas" data-allow-clear="true" multiple="multiple" disabled>
                </select>
                <small class="hide group_ass text-danger">Kelompok belajar harus dipilih!</small>
              </div>
            </div>

            <div class="row mb-6">
              <label class="col-lg-3 col-form-label required fw-semibold fs-6">Periode Pengerjaan</label>

              <div class="col-lg-9">
                <div class="row">
                  <div class="col-lg-6 fv-row fv-plugins-icon-container">
                    <input onchange="chk_range()" class="form-control form-control-solid assessment_periode_date" placeholder="Periode Awal" id="start_assessment" name="start_assessment" />
                    <small class="hide text-danger start_ass anom_period">Periode awal harus dipilih!</small>
                  </div>
                  
                  <div class="col-lg-6 fv-row fv-plugins-icon-container">
                    <input onchange="chk_range()" class="form-control form-control-solid assessment_periode_date" placeholder="Periode Akhir" id="end_assessment" name="end_assessment" />
                    <small class="hide text-danger end_ass">Periode akhir harus dipilih!</small>
                  </div>
                </div>
              </div>
            </div>

            <div class="row mb-6">
              <label class="col-lg-3 col-form-label required fw-semibold fs-6">Timer (Menit)</label>

              <div class="col-lg-9 fv-row">
                <input type="number" max="168" min="30" name="timer" class="form-control form-control-lg form-control-solid" placeholder="Waktu Pengerjaan">
                <small class="hide timer_ass text-danger">Timer harus diisi!</small>
              </div>
            </div>

            <div class="row mb-6">
              <label class="col-lg-3 col-form-label fw-semibold fs-6">Kesulitan</label>

              <div class="col-lg-9 fv-row fv-plugins-icon-container">
                <div class="d-flex align-items-center mt-3">
                  <label class="form-check form-check-custom form-check-inline form-check-solid me-5">
                    <input class="form-check-input asscheck" name="random" id="ass_random" type="checkbox" value="1">
                    <span class="fw-semibold ps-2 fs-6">
                      Acak
                    </span>
                  </label>

                  <label class="form-check form-check-custom form-check-inline form-check-solid">
                    <input class="form-check-input asscheck" name="cheat" id="ass_cheat" type="checkbox" value="2">
                    <span class="fw-semibold ps-2 fs-6">
                      Anti Curang
                    </span>
                  </label>
                </div>
              </div>
            </div>

            <div class="row mb-0">
              <label class="col-lg-3 col-form-label fw-semibold fs-6">Kirim Otomatis</label>
              <div class="col-lg-9 d-flex align-items-center">
                <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                  <input class="form-check-input asscheck checked w-45px h-30px" type="checkbox" id="autosumbit" checked="true">
                  <label class="form-check-label">Akan terkirim otomatis ketika waktu pengerjaan sudah habis</label>
                </div>
              </div>
            </div>

            <div class="row my-5 mt-10">
              <label for="instruction_assessment" class="form-label">Instruksi Pengerjaan</label>
              <div id="instruction_assessment"></div>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-light-danger" onclick="hide_modal()">Tutup</button>
        <button type="sumbit" class="btn btn-sm btn-primary" onclick="save_assessment();">Simpan</button>
      </div>
    </div>
  </div>
</div>

<?php $this->endSection(); ?>