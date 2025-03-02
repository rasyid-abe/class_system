<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="card mb-5 mb-xl-10">

  <div class="card-body border-top p-9">
    <div id="ass_present_table"></div>
  </div>

</div>

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_assessment_information">
  <div class="modal-dialog modal-md">
    <div class="modal-content" id="content_modal">
      <div class="modal-header">
        <div class="text-gray-900 fw-bolder fs-6">Informasi Penilaian</div>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div class="d-flex flex-stack">
            <div class="text-gray-700 fw-semibold fs-6 me-2">Penilaian</div>
            <div class="d-flex align-items-senter">
              <span class="text-gray-900 fw-bolder fs-6"><div class="title_assessment"></div></span>
            </div>
          </div>

          <div class="separator separator-dashed my-3"></div>

          <div class="d-flex flex-stack">
            <div class="text-gray-700 fw-semibold fs-6 me-2">Bidang Studi</div>
            <div class="d-flex align-items-senter">
              <span class="text-gray-900 fw-bolder fs-6"><div class="subject_assessment"></div></span>
            </div>
          </div>

          <div class="separator separator-dashed my-3"></div>

          <div class="d-flex flex-stack">
            <div class="text-gray-700 fw-semibold fs-6 me-2">Guru</div>
            <div class="d-flex align-items-senter">
              <span class="text-gray-900 fw-bolder fs-6"><div class="teacher_assessment"></div></span>
            </div>
          </div>
          <div class="separator separator-dashed my-3"></div>

          <div class="d-flex flex-stack">
            <div class="text-gray-700 fw-semibold fs-6 me-2">Periode</div>
            <div class="d-flex align-items-senter">
              <span class="text-gray-900 fw-bolder fs-6"><div class="period_assessment"></div></span>
            </div>
          </div>
          <div class="separator separator-dashed my-3"></div>

          <div class="d-flex flex-stack">
            <div class="text-gray-700 fw-semibold fs-6 me-2">Waktu Mengerjakan</div>
            <div class="d-flex align-items-senter">
              <span class="text-gray-900 fw-bolder fs-6"><div class="duration_assessment"></div></span>
            </div>
          </div>
        </div>
        <div class="source_question_bank hide"></div>
        <div class="end_time hide"></div>
        <div class="timer hide"></div>
        <div class="autosubmit hide"></div>
        <div class="random hide"></div>
        <div class="no_cheat hide"></div>
        <div class="assesst_id hide"></div>
        <div class="sch_year_id hide"></div>
        <br>

        <div class="mb-3 bg-light-info p-3 rounded">
          <p class="d-inline" style="font-size: 9pt">
            <b>Instruksi :</b>
            <br>
            <div class="instruction_assessment"></div>
          </p>
        </div>
        <br>

        <div class="mb-3 bg-light-danger p-3 rounded">
          <p class="d-inline" style="font-size: 9pt">
            <b>Catatan :</b>
            <br>
            <span id="assessment_notes"></span>
          </p>
        </div>

        <div class="btn_footer d-flex justify-content-end">
          <button type="button" class="btn btn-sm btn-light-danger mx-2" data-bs-dismiss="modal">Batal</button>
          <div class="start" id="betin_assessment"></div>
        </div>
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