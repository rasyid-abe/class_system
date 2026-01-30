<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>


<div class="card mb-5 mb-xl-10">

  <div class="card-body border-top p-9">
    <div class="d-flex justify-content-between align-items-center">
      <div class="btn-group btn-block mb-3 rounded" role="group" aria-label="Basic example">
        <button type="button" id="select-all" class="btn btn-sm btn-dark">Pilih Semua</button>
        <button type="button" id="deselect-all" class="btn btn-sm btn-dark">Batal Pilih</button>
        <button type="button" id="publish-btn" class="btn btn-sm btn-dark">Terbitkan</button>
        <button type="button" id="active-time-btn" class="btn btn-sm btn-dark">Batas Waktu</button>
        <button type="button" id="ignore-time-btn" class="btn btn-sm btn-dark">Abaikan Waktu</button>
        <button type="button" id="show-hint-btn" class="btn btn-sm btn-dark">Tampilkan Petunjuk</button>
        <button type="button" id="hide-hint-btn" class="btn btn-sm btn-dark">Sembunyikan Petunjuk</button>
        <button type="button" id="delete-btn" class="btn btn-sm btn-dark">Hapus</button>
      </div>
      <!-- <div class="p-5 rounded bg-dark text-light fw-bold">Total Data: 123</div> -->
    </div>
    <div id="task_draft_table"></div>
  </div>

</div>


<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="task_prev_less">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    <div class="modal-header">
        <h3 class="modal-title">Materi Tugas</h3>
        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
          <i class="bi bi-x-square fs-2x"></i>
        </div>
      </div>
      <div class="modal-body">
        <div class="" id="select_qb_alert">
          <div class="row">
            <div class="col-sm-12">
              <!-- <div class="hover-scroll-x"> -->
                <div class="d-grid">
                  <ul class="nav nav-tabs flex-nowrap text-nowrap">
                    <li class="nav-item">
                      <a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0 tab_topic_a active" id="tab_topic_a_content" data-bs-toggle="tab" href="#tab_content_p">Materi</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0 tab_topic_a" id="tab_topic_a_video" data-bs-toggle="tab" href="#tab_video_p">Video</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0 tab_topic_a" id="tab_topic_a_attachment" data-bs-toggle="tab" href="#tab_attachment_p">Lampiran</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0 tab_topic_a" id="tab_topic_a_task" data-bs-toggle="tab" href="#tab_task_p">Latihan</a>
                    </li>
                  </ul>
                </div>
              <!-- </div> -->

              <div class="card p-5" id="content_value">
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade content_topic show active" id="tab_content_p" role="tabpanel">
                    <div class="content_lesson_pub"></div>
                  </div>
                  <div class="tab-pane fade content_topic" id="tab_video_p" role="tabpanel">
                    <div id="btn_conf_vid_"></div>
                    <div class="video_lesson_pub"></div>
                  </div>
                  <div class="tab-pane fade content_topic" id="tab_attachment_p" role="tabpanel">
                    <div id="btn_conf_attach_"></div>
                    <div class="attachment_lesson_pub"></div>
                  </div>
                  <div class="tab-pane fade content_topic" id="tab_task_p" role="tabpanel">
                    <div class="task_lesson_pub"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_task_choose">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">
          <div id="task_title_a">Atur Soal Latihan</div>
        </h3>
      </div>
      <div class="modal-body">
        <input type="hidden" name="less_id" val="">
        <div class="row">
          <div class="col-sm-3">
            <div class="task" id="view_select_task"></div>
          </div>
          <div class="col-sm-9">
            <div class="task" id="preview_task"></div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-light-danger" onclick="close_mdl_task_choose()">Tutup</button>
        <button type="button" class="btn btn-primary" onclick="selected_task();">Kirim</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_task_upd">
  <div class="modal-dialog modal-xl">
    <div class="modal-content" id="content_modal">
      <div class="modal-header">
        <h3 class="modal-title">Ubah Tugas Siswa</h3>
      </div>
      <div class="modal-body">
        <form id="kt_account_profile_details_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
          <div class="card-body">

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
              <label class="col-lg-3 col-form-label fw-semibold fs-6">Tugas Agama<small class="text-danger">**</small></label>

              <div class="col-lg-4 fv-row">
                <div class="d-flex">
                  <label class="form-check form-check-custom form-check-inline form-check-solid me-5 form-switch">
                    <div class="inpreli">
                      <input class="form-check-input asscheck" name="religion_assign" id="religion_assign" type="checkbox" value="1">
                    </div>
                  </label>
                  <div class="selreli hide">
                    <select class="form-select form-select-solid" name=select_religion_test id="select_religion_test" data-close-on-select="false" data-dropdown-parent="#modal_assessment" data-placeholder="Pilih Tugas Agama" data-allow-clear="true">
                    </select>
                  </div>
                  <!-- <input type="number" max="168" min="30" name="timer" class="hide form-control form-control-lg form-control-solid" placeholder="Waktu Pengerjaan (menit)" id="c_timer"> -->
                </div>
                <small class="hide reli_ass text-danger">Kolom Tugas Agama harus dipilih!</small>
              </div>
            </div>

            <div class="row mb-6">
              <label class="col-lg-3 col-form-label fw-semibold fs-6">Sumber Materi</label>

              <div class="col-lg-9 fv-row fv-plugins-icon-container">
                <input type="text" name="source_lesson_task" class="form-control form-control-lg form-control-solid" />
              </div>
            </div>

            <div class="row mb-6">
              <label class="col-lg-3 col-form-label fw-semibold fs-6">Materi</label>

              <div class="col-lg-9 fv-row fv-plugins-icon-container">
                <input type="text" name="selected_task" class="form-control form-control-lg form-control-solid" />
                <input type="hidden" name="lessonid" />
                <input type="hidden" name="lessonsrc" />
                <input type="hidden" name="task_id" value=0 />
              </div>
            </div>

            <div class="row mb-6">
              <label class="col-lg-3 col-form-label required fw-semibold fs-6">Judul Tugas</label>

              <div class="col-lg-9 fv-row fv-plugins-icon-container">
                <input type="text" name="title" class="form-control form-control-lg form-control-solid" placeholder="Masukkan judul tugas">
                <small class="hide title_ass text-danger">Judul tugas harus diisi!</small>
              </div>
            </div>

            <div class="row mb-6">
              <label class="col-lg-3 col-form-label fw-semibold fs-6">
                <span class="required">Kelompok Belajar</span>
              </label>

              <div class="col-lg-9 fv-row fv-plugins-icon-container">
                <select class="form-select form-select-solid" name=groups[] id="multiple-select-group" data-control="select2" data-close-on-select="false" data-dropdown-parent="#modal_task_upd" data-placeholder="Pilih Kelompok Belajar" data-allow-clear="true" multiple="multiple">
                </select>
                <small class="hide group_ass text-danger">Kelompok belajar harus dipilih!</small>
              </div>
            </div>

            <div class="row mb-6">
              <label class="col-lg-3 col-form-label required fw-semibold fs-6">Periode Pengerjaan</label>

              <div class="col-lg-9">
                <div class="row">
                  <div class="col-lg-4 fv-row fv-plugins-icon-container">
                    <input type="hidden" name="old_start_task" id="old_start_task">
                    <input onchange="chk_range_task()" class="form-control form-control-solid periode_date" placeholder="Periode Awal" id="start_task" name="start_task" />
                    <small class="hide text-danger start_ass anom_period">Periode awal harus dipilih!</small>
                  </div>

                  <div class="col-lg-4 fv-row fv-plugins-icon-container">
                    <input onchange="chk_range_task()" class="form-control form-control-solid periode_date" placeholder="Periode Akhir" id="end_task" name="end_task" />
                    <small class="hide text-danger end_ass">Periode akhir harus dipilih!</small>
                  </div>

                  <div class="col-lg-4 fv-row fv-plugins-icon-container mt-2">
                    <div class="col-lg-9 d-flex align-items-center">
                      <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                        <input class="form-check-input asscheck checked w-45px h-30px" type="checkbox" id="autosumbit" checked="true">
                        <label class="form-check-label" style="margin-left: 16px">Batas Waktu Aktif</label>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <div class="row my-5 mt-10">
              <label for="instruction_task" class="form-label">Instruksi Pengerjaan</label>
              <div id="instruction_task_upd"></div>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-light-danger" data-bs-dismiss="modal">Batal</button>
        <button type="sumbit" class="btn btn-sm btn-light-success" onclick="save_task(1, 2);">Ubah</button>
        <button type="sumbit" class="btn btn-sm btn-primary" onclick="save_task(2, 2);">Kirim</button>
      </div>
    </div>
  </div>
</div>

<?php $this->endSection(); ?>