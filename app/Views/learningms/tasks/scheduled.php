<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="card mb-5 mb-xl-10">

  <div class="card-body border-top p-9">
  <div class="btn-group mb-3" role="group" aria-label="Basic example">
      <button type="button" id="select-all" class="btn btn-sm btn-secondary">Pilih Semua</button>
      <button type="button" id="deselect-all" class="btn btn-sm btn-secondary">Batal Pilih</button>
      <button type="button" id="unpublish-btn" class="btn btn-sm btn-secondary">Batalkan Tugas</button>
    </div>
    <div id="task_scheduled_table"></div>
  </div>

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

<?php $this->endSection(); ?>