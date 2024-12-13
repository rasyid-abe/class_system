<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>


<div class="card mb-5 mb-xl-10">
  <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
    <div class="card-title m-0">
      <h3 class="fw-bold m-0">Tambah Penilaian</h3>
    </div>
  </div>

  <div id="kt_account_settings_profile_details" class="collapse show">
    <form id="kt_account_profile_details_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
      <div class="card-body border-top p-9">

        <div class="row mb-6">
          <label class="col-lg-3 col-form-label required fw-semibold fs-6">Judul Penilaian</label>

          <div class="col-lg-9 fv-row fv-plugins-icon-container">
            <input type="text" name="company" class="form-control form-control-lg form-control-solid" placeholder="Company name" value="Keenthemes">
            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
          </div>
        </div>

        <div class="row mb-6">
          <label class="col-lg-3 col-form-label required fw-semibold fs-6">Kelas & Mata Pelajaran</label>

          <div class="col-lg-9">
            <div class="row">
              <div class="col-lg-6 fv-row fv-plugins-icon-container">
                <input type="text" name="fname" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="First name" value="Max">
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
              </div>

              <div class="col-lg-6 fv-row fv-plugins-icon-container">
                <input type="text" name="lname" class="form-control form-control-lg form-control-solid" placeholder="Last name" value="Smith">
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
              </div>
            </div>
          </div>
        </div>



        <div class="row mb-6">
          <label class="col-lg-3 col-form-label fw-semibold fs-6">
            <span class="required">Grup Belajar</span>


            <span class="ms-1" data-bs-toggle="tooltip" aria-label="Phone number must be active" data-bs-original-title="Phone number must be active" data-kt-initialized="1">
              <i class="ki-duotone ki-information-5 text-gray-500 fs-6"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span> </label>

          <div class="col-lg-9 fv-row fv-plugins-icon-container">
            <input type="tel" name="phone" class="form-control form-control-lg form-control-solid" placeholder="Phone number" value="044 3276 454 935">
            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
          </div>
        </div>

        <div class="row mb-6">
          <label class="col-lg-3 col-form-label required fw-semibold fs-6">Periode Pengerjaan</label>

          <div class="col-lg-9">
            <div class="row">
              <div class="col-lg-6 fv-row fv-plugins-icon-container">
                <input type="text" name="fname" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="First name" value="Max">
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
              </div>

              <div class="col-lg-6 fv-row fv-plugins-icon-container">
                <input type="text" name="lname" class="form-control form-control-lg form-control-solid" placeholder="Last name" value="Smith">
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="row mb-6">
          <label class="col-lg-3 col-form-label required fw-semibold fs-6">Timer (Menit)</label>

          <div class="col-lg-9 fv-row">
            <input type="text" name="website" class="form-control form-control-lg form-control-solid" placeholder="Company website" value="keenthemes.com">
          </div>
        </div>

        <div class="row mb-6">
          <label class="col-lg-3 col-form-label fw-semibold fs-6">Kesulitan</label>

          <div class="col-lg-9 fv-row fv-plugins-icon-container">
            <div class="d-flex align-items-center mt-3">
              <label class="form-check form-check-custom form-check-inline form-check-solid me-5">
                <input class="form-check-input" name="communication[]" type="checkbox" value="1">
                <span class="fw-semibold ps-2 fs-6">
                  Acak
                </span>
              </label>

              <label class="form-check form-check-custom form-check-inline form-check-solid">
                <input class="form-check-input" name="communication[]" type="checkbox" value="2">
                <span class="fw-semibold ps-2 fs-6">
                  Anti Curang
                </span>
              </label>
            </div>
            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
          </div>
        </div>

        <div class="row mb-0">
          <label class="col-lg-3 col-form-label fw-semibold fs-6">Kirim Otomatis</label>
          <div class="col-lg-9 d-flex align-items-center">
            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
              <input class="form-check-input w-45px h-30px" type="checkbox" id="allowmarketing" checked="">
              <label class="form-check-label" for="allowmarketing">Akan terkirim otomatis ketika waktu pengerjaan sudah habis</label>
            </div>
          </div>
        </div>
       
        <div class="row my-5 mt-10">
            <label for="instruction_assessment" class="form-label">Instruksi Pengerjaan</label>
            <div id="instruction_assessment"></div>
        </div>
      </div>

      <div class="card-footer d-flex justify-content-end py-6 px-9">
        <button type="reset" class="btn btn-light btn-active-light-primary me-2">Batal</button>
        <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Simpan</button>
      </div>
      <input type="hidden">
    </form>
  </div>
</div>


<?php $this->endSection(); ?>