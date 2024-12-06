<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_update_content_quest">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="content_modal">
            <div class="modal-header">
                <div id="head_content_modal_std"></div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <input type="hidden" name="subject" value="<?= $subject ?>">
                        <input type="hidden" name="grade" value="<?= $grade ?>">
                        <div id="body_content_modal_quest"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light-danger" onclick="close_modal_content_quest();">Tutup</button>
                <button type="sumbit" class="btn btn-sm btn-primary" onclick="save_content_quest();">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_share_task">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">
                    <div id="shared_title"></div>
                </h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>
            <div class="modal-body">
                <input type="hidden" name="task_id" val="">
                <div class="form-check form-check-custom form-check-solid me-10 mb-2 form-check-inline">
                    <input class="form-check-input input_share_task" type="radio" name="gender" value="1" id="opt1" />
                    <label class="form-check-label text-dark" for="opt1">
                        Seluruh Guru
                    </label>
                </div>
                <div class="form-check form-check-custom form-check-solid me-10 mb-2 form-check-inline">
                    <input class="form-check-input input_share_task" type="radio" name="gender" value="2" id="opt2" />
                    <label class="form-check-label text-dark" for="opt2">
                        Guru Mata Pelajaran yang sama
                    </label>
                </div>
                <div class="form-check form-check-custom form-check-solid me-10 mb-2 form-check-inline">
                    <input class="form-check-input input_share_task" type="radio" name="gender" value="3" id="opt3" />
                    <label class="form-check-label text-dark" for="opt3">
                        Guru Mata Pelajaran dan Jenjang Kelas yang sama
                    </label>
                </div>
                <div class="form-check form-check-custom form-check-solid me-10 mb-2 form-check-inline">
                    <input class="form-check-input input_share_task" type="radio" name="gender" value="4" id="opt4" />
                    <label class="form-check-label text-dark" for="opt4">
                        Guru tertentu
                    </label>
                </div>

                <div class="hide" id="shared_task_to">
                    <select class="form-select form-select-sm form-select-solid hide" id="multiple-select-field-task" data-control="select2" data-close-on-select="false" data-placeholder="Pilih Guru" data-allow-clear="true" multiple="multiple">
                    <?php foreach ($teachers as $k => $v): ?>
                            <?php $degr = $v['teacher_degree'] != '' ? ', ' . $v['teacher_degree'] : ''  ?>
                            <option value="<?= $v['teacher_id'] ?>"><?= $v['teacher_first_name'] . ' ' . $v['teacher_last_name'] . $degr ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light-danger" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="act_share_task();">Kirim</button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-3">
        <div class="rounded-border">
            <div class="accordion-item rounded-border">
                <?php foreach ($questions as $k => $v): ?>
                    <div class="accordion-body bg-secondary">
                        <div class="d-flex justify-content-between">
                            <a href="#" class="d-grid" style="font-weight: 500;" onclick="toggle_collapse('<?= $v['question_bank_standart_id'] ?>');"><?= $v['question_bank_standart_title'] ?></a>
                        </div>
                    </div>
                    <div id="coll_body_<?= $v['question_bank_standart_id'] ?>" class="hide body_collapse">
                        <div class="accordion-body bg-light">
                            <?php $i = 0; foreach ($v['child'] as $x): ?>
                                <div class="d-flex justify-content-start">
                                    <?php foreach ($x as $y): ?>
                                        <a href="#" onclick="view_question_std(<?= $y['question_bank_standart_id'] ?>)" class="m-1 btn btn-icon btn-outline btn-outline-primary btn-active-primary"><?= $i + 1 ?></a>
                                    <?php $i++;
                                    endforeach ?>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
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

<?php $this->endSection(); ?>