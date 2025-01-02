<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="card mb-5 mb-xl-10">

  <div class="card-body border-top p-9">
    <div class="btn-group mb-3" role="group" aria-label="Basic example">
      <button type="button" id="select-all" class="btn btn-sm btn-secondary">Pilih Semua</button>
      <button type="button" id="deselect-all" class="btn btn-sm btn-secondary">Batal Pilih</button>
      <button type="button" id="publish-btn" class="btn btn-sm btn-secondary">Terbitkan</button>
      <button type="button" id="delete-btn" class="btn btn-sm btn-secondary">Hapus</button>
    </div>
    <div id="task_draft_table"></div>
  </div>

</div>


<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="tasks_prev_less">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">
        <div id="task_title_a">Materi Tugas</div>
        </h3>
      </div>
      <div class="modal-body">
        <div class="" id="select_qb_alert">
          <div class="row">
            <div class="col-sm-12">
              <div class="hover-scroll-x">
                <div class="d-grid">
                  <ul class="nav nav-tabs flex-nowrap text-nowrap">
                    <li class="nav-item">
                      <a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0 tab_topic active" id="tab_topic_content" data-bs-toggle="tab" href="#tab_content">Materi</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0 tab_topic" id="tab_topic_video" data-bs-toggle="tab" href="#tab_video">Video</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0 tab_topic" id="tab_topic_attachment" data-bs-toggle="tab" href="#tab_attachment">Lampiran</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0 tab_topic" id="tab_topic_tasks" data-bs-toggle="tab" href="#tab_task">Latihan</a>
                    </li>
                  </ul>
                </div>
              </div>

              <div class="card p-5" id="content_value">
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade content_topic show active" id="tab_content" role="tabpanel">
                    <div id="content_lesson"></div>
                  </div>
                  <div class="tab-pane fade content_topic" id="tab_video" role="tabpanel">
                    <div id="btn_conf_vid_"></div>
                    <div id="video_lesson"></div>
                  </div>
                  <div class="tab-pane fade content_topic" id="tab_attachment" role="tabpanel">
                    <div id="btn_conf_attach_"></div>
                    <div id="attachment_lesson"></div>
                  </div>
                  <div class="tab-pane fade content_topic" id="tab_task" role="tabpanel">
                    <div id="task_lesson"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Tutup</button>
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
        <button type="button" class="btn btn-light-danger" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" onclick="selected_tasks();">Kirim</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_tasks_upd">
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
              <label class="col-lg-3 col-form-label fw-semibold fs-6">Materi</label>

              <div class="col-lg-9 fv-row fv-plugins-icon-container">
                <input type="text" name="selected_task" class="form-control form-control-lg form-control-solid" />
                <input type="hidden" name="lessonid" />
                <input type="hidden" name="lessonsrc" />
                <input type="hidden" name="tasks_id" value=0 />
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
                <select class="form-select form-select-solid" name=groups[] id="multiple-select-group" data-control="select2" data-close-on-select="false" data-dropdown-parent="#modal_tasks_upd" data-placeholder="Pilih Kelompok Belajar" data-allow-clear="true" multiple="multiple">
                </select>
                <small class="hide group_ass text-danger">Kelompok belajar harus dipilih!</small>
              </div>
            </div>

            <div class="row mb-6">
              <label class="col-lg-3 col-form-label required fw-semibold fs-6">Periode Pengerjaan</label>

              <div class="col-lg-9">
                <div class="row">
                  <div class="col-lg-4 fv-row fv-plugins-icon-container">
                    <input onchange="chk_range_tasks()" class="form-control form-control-solid periode_date" placeholder="Periode Awal" id="start_tasks" name="start_tasks" />
                    <small class="hide text-danger start_ass anom_period">Periode awal harus dipilih!</small>
                  </div>

                  <div class="col-lg-4 fv-row fv-plugins-icon-container">
                    <input onchange="chk_range_tasks()" class="form-control form-control-solid periode_date" placeholder="Periode Akhir" id="end_tasks" name="end_tasks" />
                    <small class="hide text-danger end_ass">Periode akhir harus dipilih!</small>
                  </div>

                  <div class="col-lg-4 fv-row fv-plugins-icon-container mt-2">
                    <div class="col-lg-9 d-flex align-items-center">
                      <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                        <input class="form-check-input asscheck checked w-45px h-30px" type="checkbox" id="autosumbit" checked="true">
                        <label class="form-check-label" style="margin-left: 16px">Kirim Otomatis</label>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <div class="row my-5 mt-10">
              <label for="instruction_tasks" class="form-label">Instruksi Pengerjaan</label>
              <div id="instruction_tasks_upd"></div>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-light-danger" data-bs-dismiss="modal">Batal</button>
        <button type="sumbit" class="btn btn-sm btn-light-success" onclick="save_tasks(1, 2);">Ubah</button>
        <button type="sumbit" class="btn btn-sm btn-primary" onclick="save_tasks(2, 2);">Kirim</button>
      </div>
    </div>
  </div>
</div>

<?php $this->endSection(); ?>