<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="card mb-5 mb-xl-10">

  <div class="card-body border-top p-9">
    <div id="task_dones_table"></div>
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

<div class="modal bg-body fade task_modal_act" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="checking_mydone_task">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content shadow-none">
      <div class="modal-header">
        <div class="modal-title">
          <h5 id="donetaskname"></h5>
          <badge id="donesubject" class="badge badge-info mt-2"></badge>
        </div>
        <div class="buttonn">
          <span class="fw-bold mx-5 fs-3"><span id="left_time_task" class="hide"></span></span>
          <button type="button" class="btn btn-danger" onclick="close_checking_mydone_task()">Tutup</button>
          <input type="hidden" name="doneresult_id_tsk" id="doneresult_id_tsk">
          <input type="hidden" name="donestu_id_tsk" id="donestu_id_tsk">
          <input type="hidden" name="donetaskid" id="donetaskid">
        </div>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="list_questions_tsk_done" id="list_questions_tsk_done"></div>
          </div>
          <div class="col-sm-8">
            <div id="check_question_tskdone"></div>
            <div id="check_answer_tskdone"></div>
            <div id="check_answer_essay_tskdone"></div>
            <div id="check_hinttsk"></div>
          </div>
          <div class="col-sm-4">
            <div id="checkpoin_tskdone"></div>
            <div id="check_explaintsk"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php $this->endSection(); ?>