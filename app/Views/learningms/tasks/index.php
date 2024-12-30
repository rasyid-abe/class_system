<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="row gx-6 gx-xl-9">
  <?php foreach ($my_duty as $k => $v): ?>
    <div class="col-lg-6 col-xxl-4 mb-10">
      <div class="card  h-100">
        <div class="card-body p-9">
          <div class="fw-bold">
            <h3><?= $v['subjs'] ?></h3>
          </div>
          <div class="fs-4 fw-semibold text-gray-500 mb-7"></div>

          <?php foreach ($v['grade'] as $key => $val) : ?>
            <div class="fs-6 d-flex justify-content-between mb-4">
              <div class="fw-semibold"><?= $val ?></div>
              <div class="d-flex fw-bold">
                <badge type="button" class="badge badge-primary" id="btnshow_lesson" data-subjs="<?= $v['subjs_id'] ?>" data-grade="<?= $key ?>">Buat Tugas</badge>
              </div>
            </div>

            <div class="separator separator-dashed mb-4"></div>
          <?php endforeach ?>

        </div>
      </div>
    </div>
  <?php endforeach ?>
</div>


<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="tasks_prev_less">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">
          <div id="task_title_a">Pilih Materi</div>
        </h3>
      </div>
      <div class="modal-body">
        <div class="" id="select_qb_alert">
          <div class="alert alert-info d-flex align-items-center p-2 mb-5">
          <i class="bi bi-shield-fill-exclamation fs-2hx text-info me-4"></i>
            <div class="d-flex flex-column">
            <h4 class="mb-1 text-info">Informasi</h4>
            <span>Untuk mengubah data materi dapat melalui menu <span class="fw-bolder">Materi Pelajaran > Materi Saya</span></span>
            <span>Latihan dapat ditambahkan ketika tugas berhasil berhasil dibuat.</span>
            </div>
          </div>
        <div class="hide" id="select_tk_alert">
          <div class="alert alert-danger d-flex align-items-center p-2 mb-5">
            <i class="bi bi-shield-fill-x fs-2hx text-danger me-4"><span class="path1"></span><span class="path2"></span></i>
            <div class="d-flex flex-column">
              <h6 class="mb-1 text-danger">Materi belum dipilih!</h6>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-3">
           <div id="treeview_tasks__"></div>
          </div>

          <div class="col-sm-9 hide" id="content_tab">
            <div class="hover-scroll-x">
              <div class="d-grid">
                <ul class="nav nav-tabs flex-nowrap text-nowrap">
                  <li class="nav-item">
                    <a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0 tab_topic_a active" id="tab_topic_a_content" data-bs-toggle="tab" href="#tab_content">Materi</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0 tab_topic_a" id="tab_topic_a_video" data-bs-toggle="tab" href="#tab_video_a">Video</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0 tab_topic_a" id="tab_topic_a_attachment" data-bs-toggle="tab" href="#tab_attachment_a">Lampiran</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0 tab_topic_a" id="tab_topic_a_tasks" data-bs-toggle="tab" href="#tab_task">Latihan</a>
                  </li>
                </ul>
              </div>
            </div>

            <div class="card p-5 hide" id="content_value">
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade content_topic_a show active" id="tab_content" role="tabpanel">
                  <div id="content_lesson"></div>
                </div>
                <div class="tab-pane fade content_topic_a" id="tab_video_a" role="tabpanel">
                  <div id="btn_conf_vid_"></div>
                  <div id="video_lesson"></div>
                </div>
                <div class="tab-pane fade content_topic_a" id="tab_attachment_a" role="tabpanel">
                  <div id="btn_conf_attach_"></div>
                  <div id="attachment_lesson"></div>
                </div>
                <div class="tab-pane fade content_topic_a" id="tab_task" role="tabpanel">
                  <div id="btn_conf_task_"></div>
                  <div id="task_lesson"></div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-light-danger btn-sm" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="choose_tasks();">Pilih</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_tasks_ch" style="z-index:9999">
  <div class="modal-dialog modal-xl">
    <div class="modal-content" id="content_modal">
      <div class="modal-header">
        <h3 class="modal-title">Tambah Tugas Siswa</h3>
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
                <select class="form-select form-select-solid" name=groups[] id="multiple-select-group" data-control="select2" data-close-on-select="false" data-dropdown-parent="#modal_tasks_ch" data-placeholder="Pilih Kelompok Belajar" data-allow-clear="true" multiple="multiple">
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

            <!-- <div class="row mb-4">
              <label class="col-lg-3 col-form-label fw-semibold fs-6">Timer Aktif <small class="text-danger">**</small></label>

              <div class="col-lg-4 fv-row">
                <div class="d-flex">
                  <label class="form-check form-check-custom form-check-inline form-check-solid me-5 form-switch">
                    <input class="form-check-input asscheck" name="task_timer" id="task_timer" type="checkbox" value="1">
                  </label>
                  <input type="number" max="168" min="30" name="timer" class="hide form-control form-control-lg form-control-solid" placeholder="Waktu Pengerjaan (menit)" id="c_timer">
                </div>
                <small class="hide timer_ass text-danger">Timer aktif membutuhkan waktu pengerjaan!</small>
              </div>
            </div> -->

            <!-- <div class="row mb-6">
              <label class="col-lg-3 col-form-label fw-semibold fs-6">Kesulitan</label>

              <div class="col-lg-9 fv-row fv-plugins-icon-container">
                <div class="d-flex align-items-center mt-3">
                  <label class="form-check form-check-custom form-check-inline form-check-solid me-5">
                    <input class="form-check-input asscheck" name="random" id="task_random" type="checkbox" value="1">
                    <span class="fw-semibold ps-2 fs-6">
                      Acak
                    </span>
                  </label>

                  <label class="form-check form-check-custom form-check-inline form-check-solid">
                    <input class="form-check-input asscheck" name="cheat" id="task_cheat" type="checkbox" value="2">
                    <span class="fw-semibold ps-2 fs-6">
                      Anti Curang
                    </span>
                  </label>
                </div>
              </div>
            </div> -->

            <div class="row my-5 mt-10">
              <label for="instruction_tasks" class="form-label">Instruksi Pengerjaan</label>
              <div id="instruction_tasks"></div>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-light-danger" onclick="hide_modal()">Kembali</button>
        <button type="sumbit" class="btn btn-sm btn-light-success" onclick="save_tasks(1, 1);">Simpan</button>
        <button type="sumbit" class="btn btn-sm btn-primary" onclick="save_tasks(2, 1);">Kirim</button>
      </div>
    </div>
  </div>
</div>

<?php $this->endSection(); ?>