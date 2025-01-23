<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="card mb-5 mb-xl-10">

  <div class="card-body border-top p-9">
    <div id="ass_done_table"></div>
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