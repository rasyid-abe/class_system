<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="card mb-5 mb-xl-10">

  <div class="card-body border-top p-9">
    <div class="btn-group mb-3" role="group" aria-label="Basic example">
      <button type="button" id="select-all" class="btn btn-sm btn-dark">Pilih Semua</button>
      <button type="button" id="deselect-all" class="btn btn-sm btn-dark">Batal Pilih</button>
      <button type="button" id="active-time-btn" class="btn btn-sm btn-dark">Batas Waktu</button>
      <button type="button" id="ignore-time-btn" class="btn btn-sm btn-dark">Abaikan Waktu</button>
    </div>
    <div id="task_present_table"></div>
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
<?php $this->endSection(); ?>