<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="card mb-5 mb-xl-10">

  <div class="card-body border-top p-9">
  <div class="btn-group mb-3" role="group" aria-label="Basic example">
      <button type="button" id="select-all" class="btn btn-sm btn-dark">Pilih Semua</button>
      <button type="button" id="deselect-all" class="btn btn-sm btn-dark">Batal Pilih</button>
      <button type="button" id="publish-btn" class="btn btn-sm btn-dark">Terbitkan</button>
      <button type="button" id="delete-btn" class="btn btn-sm btn-dark">Hapus</button>
    </div>
    <div id="ass_draft_table"></div>
  </div>

</div>


<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_assessment_edit">
  <div class="modal-dialog modal-xl">
    <div class="modal-content" id="content_modal">
      <div class="modal-header">
        <h3 class="modal-title">Ubah Penilaian Siswa</h3>
      </div>
      <div class="modal-body">
        <form id="kt_account_profile_details_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
          <div class="card-body">

            <div class="row mb-6">
              <label class="col-lg-3 col-form-label fw-semibold fs-6">Soal</label>

              <div class="col-lg-9 fv-row fv-plugins-icon-container">
                <input type="text" name="selected_task" class="form-control form-control-lg form-control-solid" />
                <input type="hidden" name="taskid" />
                <input type="hidden" name="tasksrc" />
                <input type="hidden" name="assessment_id" />
              </div>
            </div>

            <div class="row mb-6">
              <label class="col-lg-3 col-form-label fw-semibold fs-6">Mata Pelajaran</label>

              <div class="col-lg-9">
                <div class="fv-row fv-plugins-icon-container">
                  <input type="text" name="selected_subj" class="form-control form-control-lg form-control-solid" />
                  <input type="hidden" name="subjid" />
                  <input type="hidden" name="gradid" />
                </div>
              </div>
            </div>

            <div class="row mb-6">
              <label class="col-lg-3 col-form-label required fw-semibold fs-6">Judul Penilaian</label>

              <div class="col-lg-9 fv-row fv-plugins-icon-container">
                <input type="text" name="title" class="form-control form-control-lg form-control-solid" placeholder="Masukkan judul penilaian">
                <small class="hide title_ass text-danger">Judul penilaian harus diisi!</small>
              </div>
            </div>

            <div class="row mb-6">
              <label class="col-lg-3 col-form-label fw-semibold fs-6">
                <span class="required">Kelompok Belajar</span>
              </label>

              <div class="col-lg-9 fv-row fv-plugins-icon-container">
                <select class="form-select form-select-solid" name=groups[] id="multiple-select-group" data-control="select2" data-close-on-select="false" data-dropdown-parent="#modal_assessment_edit" data-placeholder="Pilih Kelompok Belajar" data-allow-clear="true" multiple="multiple">
                </select>
                <small class="hide group_ass text-danger">Kelompok belajar harus dipilih!</small>
              </div>
            </div>

            <div class="row mb-6">
              <label class="col-lg-3 col-form-label required fw-semibold fs-6">Periode Pengerjaan</label>

              <div class="col-lg-9">
                <div class="row">
                  <div class="col-lg-4 fv-row fv-plugins-icon-container">
                    <input onchange="chk_range()" class="form-control form-control-solid periode_date" placeholder="Periode Awal" id="start_assessment" name="start_assessment" />
                    <small class="hide text-danger start_ass anom_period">Periode awal harus dipilih!</small>
                  </div>

                  <div class="col-lg-4 fv-row fv-plugins-icon-container">
                    <input onchange="chk_range()" class="form-control form-control-solid periode_date" placeholder="Periode Akhir" id="end_assessment" name="end_assessment" />
                    <small class="hide text-danger end_ass">Periode akhir harus dipilih!</small>
                  </div>

                  <div class="col-lg-4 fv-row fv-plugins-icon-container mt-2">
                    <!-- <label class="col-lg-3 col-form-label fw-semibold fs-6">Kirim Otomatis</label> -->
                    <div class="col-lg-9 d-flex align-items-center">
                      <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                        <input class="form-check-input asscheck w-45px h-30px" type="checkbox" id="autosumbit">
                        <label class="form-check-label" style="margin-left: 16px">Kirim Otomatis</label>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <div class="row mb-4">
              <label class="col-lg-3 col-form-label fw-semibold fs-6">Timer Aktif <small class="text-danger">**</small></label>

              <div class="col-lg-4 fv-row">
                <div class="d-flex">
                  <label class="form-check form-check-custom form-check-inline form-check-solid me-5 form-switch">
                    <input class="form-check-input asscheck" name="ass_timer" id="ass_timer" type="checkbox" value="1">
                  </label>
                  <input type="number" max="168" min="30" name="timer" class="hide form-control form-control-lg form-control-solid" placeholder="Waktu Pengerjaan (menit)" id="c_timer">
                </div>
                <small class="hide timer_ass text-danger">Timer aktif membutuhkan waktu pengerjaan!</small>
              </div>
            </div>

            <!-- <div class="row mb-6">
              <label class="col-lg-3 col-form-label fw-semibold fs-6">Kirim Otomatis</label>
              <div class="col-lg-9 d-flex align-items-center">
                <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                  <input class="form-check-input asscheck checked w-45px h-30px" type="checkbox" id="autosumbit" checked="true">
                  <label class="form-check-label" style="margin-left: 16px">Akan terkirim otomatis ketika waktu pengerjaan sudah habis</label>
                </div>
              </div>
            </div> -->

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

            <div class="row my-5 mt-10">
              <label for="instruction_assessment_edit" class="form-label">Instruksi Pengerjaan</label>
              <div id="instruction_assessment_edit"></div>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-light-danger" onclick="hide_modal_edit()">Batal</button>
        <button type="sumbit" class="btn btn-sm btn-light-success" onclick="save_assessment(1, 2);">Ubah</button>
        <button type="sumbit" class="btn btn-sm btn-primary" onclick="save_assessment(2, 2);">Kirim</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_look_question">
  <div class="modal-dialog modal-xl">
    <div class="modal-content" id="content_modal">
      <div class="modal-header">
        <h3 class="modal-title">Soal Penilaian</h3>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-sm-3">
            <div class="card">
                <div id="lists_questions"></div>
            </div>
          </div>

          <div class="col-sm-9">
            <div class="hide" id="quest_cont">
              <div class="d-grid">
                <ul class="nav nav-tabs flex-nowrap text-nowrap">
                  <li class="nav-item">
                    <a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0 active" data-bs-toggle="tab" href="#show_task">Soal</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0" data-bs-toggle="tab" href="#show_hint">Petunjuk</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0" data-bs-toggle="tab" href="#show_explain">Penjelasan</a>
                  </li>
                </ul>
              </div>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="show_task" role="tabpanel">
                  <div id="tab_task"></div>
                </div>
                <div class="tab-pane fade" id="show_hint" role="tabpanel">
                  <div id="tab_hint"></div>
                </div>
                <div class="tab-pane fade" id="show_explain" role="tabpanel">
                  <div id="tab_explain"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-light-danger" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<?php $this->endSection(); ?>

