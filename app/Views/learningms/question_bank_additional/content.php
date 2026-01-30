<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<style>
    #task_upload::file-selector-button {
        background-color: #2884EF;
        color: white;
    }

    #task_upload::file-selector-button:hover {
        background-color: red;
        color: white;
    }
    
</style>

<input type="hidden" name="form_type" value="" />
<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_update_question_quest">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" id="content_modal">
            <div class="modal-header">
                <div id="head_content_modal"></div>
            </div>
            <div class="modal-body">
                <input type="hidden" name="subject" id="subject_idd" value="<?= $subject ?>">
                <input type="hidden" name="grade" id="grade_idd" value="<?= $grade ?>">
                <div id="edit_form_type"></div>

                <div class="bg-secondary accordion-header p-3 mb-3 d-flex" style="border-radius: 5px;" onclick="tog_form('content_value')">
                    <span class="px-2">Soal</span>
                </div>
                <div class="card p-5" id="content_value">
                    <div class="px-5">
                        <div class="mb-3 row">
                            <label for="poin" class="col-sm-1 col-form-label">Poin</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control" name="poin" id="poin" min="1" value="1">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-1 col-form-label">Tipe</label>
                            <div class="col-sm-6">
                                <select name="quest_type" id="quest_type" class="form-control" onchange="chk_type()">
                                    <option value="0">Pilih Tipe Soal</option>
                                    <?php foreach ($quest_type as $k => $v): ?>
                                        <option value=<?= $k ?>><?= $v ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="mt-10 hide" id="question_form">
                            <label for="exampleFormControlInput1" class="form-label">Pertanyaan</label>
                            <div id="quilleditor_question" style="height: 250px"></div>
                        </div>

                        <div class="hide" id="multiplechoice">
                            <div class="mt-10">
                                <label for="exampleFormControlInput1" class="form-label">Pilihan</label>
                                <div class="position-relative">
                                    <div class="butt ml-3" style="min-width: 200px">
                                        <div class="form-check form-check-custom form-switch form-check-success form-check-solid mb-2">
                                            <input class="form-check-input mc_option" type="radio" value="" />
                                            <label class="form-check-label">
                                                Jawaban Benar
                                            </label>
                                        </div>
                                    </div>
                                    <div id="quilleditor_optmc0" name="optmc0" class="optmc_n" style="height: 250px"></div>
                                </div>
                            </div>
                            <div class="mt-5">
                                <div class="position-relative">
                                    <div class="butt ml-3" style="min-width: 200px">
                                        <div class="form-check form-check-custom form-switch form-check-success form-check-solid mb-2">
                                            <input class="form-check-input mc_option" type="radio" value="" />
                                            <label class="form-check-label">
                                                Jawaban Benar
                                            </label>
                                        </div>
                                    </div>
                                    <div id="quilleditor_optmc1" name="optmc1" class="optmc_n" style="height: 250px"></div>
                                </div>
                            </div>
                            <div class="mt-5">
                                <div class="position-relative">
                                    <div class="butt ml-3" style="min-width: 200px">
                                        <div class="form-check form-check-custom form-switch form-check-success form-check-solid mb-2">
                                            <input class="form-check-input mc_option" type="radio" value="" />
                                            <label class="form-check-label">
                                                Jawaban Benar
                                            </label>
                                        </div>
                                    </div>
                                    <div id="quilleditor_optmc2" name="optmc2" class="optmc_n" style="height: 250px"></div>
                                </div>
                            </div>
                            <div class="mt-5">
                                <div class="position-relative">
                                    <div class="butt ml-3" style="min-width: 200px">
                                        <div class="form-check form-check-custom form-switch form-check-success form-check-solid mb-2">
                                            <input class="form-check-input mc_option" type="radio" value="" />
                                            <label class="form-check-label">
                                                Jawaban Benar
                                            </label>
                                        </div>
                                    </div>
                                    <div id="quilleditor_optmc3" name="optmc3" class="optmc_n" style="height: 250px"></div>
                                </div>
                            </div>
                            <div class="mt-5">
                                <div class="position-relative">
                                    <div class="butt ml-3" style="min-width: 200px">
                                        <div class="form-check form-check-custom form-switch form-check-success form-check-solid mb-2">
                                            <input class="form-check-input mc_option" type="radio" value="" />
                                            <label class="form-check-label">
                                                Jawaban Benar
                                            </label>
                                        </div>
                                    </div>
                                    <div id="quilleditor_optmc4" name="optmc4" class="optmc_n" style="height: 250px"></div>
                                </div>
                            </div>
                            <div id="repeater_mc">
                                <div class="repeater">
                                    <div class="mt-5">
                                        <div data-repeater-list="group-mc">
                                            <div data-repeater-item>
                                                <div class="butt ml-3" style="min-width: 200px">
                                                    <div class="d-flex justify-content-left">
                                                        <div class="form-check form-check-custom form-switch form-check-success form-check-solid m-2 pt-2">
                                                            <input class="form-check-input mc_option" type="radio" value="" />
                                                            <label class="form-check-label">
                                                                Jawaban Benar
                                                            </label>
                                                        </div>
                                                        <button data-repeater-delete type="button" class="m-2 btn btn-danger btn-sm btn-icon"><i class="bi bi-trash fs-2"></i></button>
                                                    </div>
                                                </div>
                                                <div id="quilleditor_optmc_n" name="optmc" class="mb-2 optmc_n" style="height: 250px"></div>
                                            </div>
                                        </div>
                                        <input data-repeater-create type="button" class="btn btn-info btn-sm mt-2" value="Tambah Pilihan" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row hide" id="multiplechoice_complex">
                            <div class="mt-10">
                                <label for="exampleFormControlInput1" class="form-label">Pilihan</label>
                                <div class="position-relative">
                                    <div class="butt ml-3" style="min-width: 200px">
                                        <div class="form-check form-check-custom form-switch form-check-success form-check-solid m-2">
                                            <input class="form-check-input mcx_option" type="checkbox" value="" id="" />
                                            <label class="form-check-label" for="">
                                                Jawaban Benar
                                            </label>
                                        </div>
                                    </div>
                                    <div id="quilleditor_optmcx0" name="optmcx0" class="optmcx_n" style="height: 250px"></div>
                                </div>
                            </div>
                            <div class="mt-1">
                                <div class="position-relative">
                                    <div class="butt ml-3" style="min-width: 200px">
                                        <div class="form-check form-check-custom form-switch form-check-success form-check-solid m-2">
                                            <input class="form-check-input mcx_option" type="checkbox" value="" id="" />
                                            <label class="form-check-label" for="">
                                                Jawaban Benar
                                            </label>
                                        </div>
                                    </div>
                                    <div id="quilleditor_optmcx1" name="optmcx1" class="optmcx_n" style="height: 250px"></div>
                                </div>
                            </div>
                            <div class="mt-1">
                                <div class="position-relative">
                                    <div class="butt ml-3" style="min-width: 200px">
                                        <div class="form-check form-check-custom form-switch form-check-success form-check-solid m-2">
                                            <input class="form-check-input mcx_option" type="checkbox" value="" id="" />
                                            <label class="form-check-label" for="">
                                                Jawaban Benar
                                            </label>
                                        </div>
                                    </div>
                                    <div id="quilleditor_optmcx2" name="optmcx2" class="optmcx_n" style="height: 250px"></div>
                                </div>
                            </div>
                            <div class="mt-1">
                                <div class="position-relative">
                                    <div class="butt ml-3" style="min-width: 200px">
                                        <div class="form-check form-check-custom form-switch form-check-success form-check-solid m-2">
                                            <input class="form-check-input mcx_option" type="checkbox" value="" id="" />
                                            <label class="form-check-label" for="">
                                                Jawaban Benar
                                            </label>
                                        </div>
                                    </div>
                                    <div id="quilleditor_optmcx3" name="optmcx3" class="optmcx_n" style="height: 250px"></div>
                                </div>
                            </div>
                            <div class="mt-1">
                                <div class="position-relative">
                                    <div class="butt ml-3" style="min-width: 200px">
                                        <div class="form-check form-check-custom form-switch form-check-success form-check-solid m-2">
                                            <input class="form-check-input mcx_option" type="checkbox" value="" id="" />
                                            <label class="form-check-label" for="">
                                                Jawaban Benar
                                            </label>
                                        </div>
                                    </div>
                                    <div id="quilleditor_optmcx4" name="optmcx4" class="optmcx_n" style="height: 250px"></div>
                                </div>
                            </div>
                            <div class="repeater">
                                <div class="mt-2">
                                    <div data-repeater-list="group-a">
                                        <div data-repeater-item>
                                            <div class="butt ml-3" style="min-width: 200px">
                                                <div class="d-flex justify-content-left">
                                                    <div class="form-check form-check-custom form-switch form-check-success form-check-solid m-2 pt-2">
                                                        <input class="form-check-input mcx_option" type="checkbox" value="" id="" />
                                                        <label class="form-check-label" for="">
                                                            Jawaban Benar
                                                        </label>
                                                    </div>
                                                    <button data-repeater-delete type="button" class="m-2 btn btn-danger btn-sm btn-icon"><i class="bi bi-trash fs-2"></i></button>
                                                </div>
                                            </div>
                                            <div id="quilleditor_optmcx_n" name="optmcx" class="optmcx_n" style="height: 250px"></div>
                                        </div>
                                    </div>
                                    <input data-repeater-create type="button" class="btn btn-info btn-sm mt-2" value="Tambah Pilihan" />
                                </div>
                            </div>
                        </div>

                        <div class="hide mt-10" id="truefalse">
                            <label for="exampleFormControlInput1" class="form-label">Jawaban</label>
                            <div class="form-check form-check-custom form-switch form-check-success form-check-solid m-2">
                                <input class="form-check-input tf_option" type="radio" name="tfopt" value=1 id="ctrue" />
                                <label class="form-check-label" for="ctrue">
                                    Benar
                                </label>
                            </div>
                            <div class="form-check form-check-custom form-switch form-check-success form-check-solid m-2">
                                <input class="form-check-input tf_option" type="radio" name="tfopt" value=2 id="cfalse" />
                                <label class="form-check-label" for="cfalse">
                                    Salah
                                </label>
                            </div>
                        </div>


                    </div>
                </div>

                <div class="pt-5">
                    <div class="bg-secondary accordion-header p-3 mb-3 d-flex" style="border-radius: 5px;" onclick="tog_form('content_hint')">
                        <span class="px-2">Petunjuk Soal</span>
                    </div>
                    <div class="card p-5 hide" id="content_hint">
                        <div class="px-5">
                            <div class="position-relative">
                                <div id="hint_quest" name="textarea"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-5">
                    <div class="bg-secondary accordion-header p-3 mb-3 d-flex" style="border-radius: 5px;" onclick="tog_form('content_explain')">
                        <span class="px-2">Penjelasan Soal</span>
                    </div>
                    <div class="card p-5 hide" id="content_explain">
                        <div class="px-5">
                            <div class="position-relative">
                                <div id="explain_quest" name="textarea"></div>
                            </div>
                        </div>
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

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_update_task_mcx">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" id="content_modal">
            <div class="modal-header">
                <label for="chapter" class="form-label">Ubah Soal</label>
            </div>
            <div class="modal-body">
                <input type="hidden" name="subject" value="<?= $subject ?>">
                <input type="hidden" name="grade" value="<?= $grade ?>">
                <div id="edit_form_type_mcx"></div>

                <div id="task_edit_mcx" name="task_edit_mcx"></div>
                <div class="repeater px-5 hide" id="repeater_edit_mcx">
                    <div class="mt-5">
                        <div data-repeater-list="group-mcx">
                            <div data-repeater-item>
                                <div class="butt" style="min-width: 200px">
                                    <div class="d-flex justify-content-left">
                                        <div class="form-check form-check-custom form-switch form-check-success form-check-solid m-2 pt-2">
                                            <input class="form-check-input mcx_option_edit" type="checkbox" value="" />
                                            <label class="form-check-label">
                                                Jawaban Benar
                                            </label>
                                        </div>
                                        <button data-repeater-delete type="button" class="m-2 btn btn-danger btn-sm btn-icon"><i class="bi bi-trash fs-2"></i></button>
                                    </div>
                                </div>
                                <div id="quilleditor_optmcx_edit" name="optmc" class="mb-2 optmcx_n_edit" style="height: 250px"></div>
                            </div>
                        </div>
                        <input data-repeater-create type="button" class="btn btn-info btn-sm mt-2" value="Tambah Pilihan" />
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

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_update_task">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" id="content_modal">
            <div class="modal-header">
                <label for="chapter" class="form-label title-update-task"></label>
            </div>
            <div class="modal-body">
                <input type="hidden" name="subject" value="<?= $subject ?>">
                <input type="hidden" name="grade" value="<?= $grade ?>">
                <div id="edit_form_type"></div>

                <div id="task_edit" name="task_edit"></div>
                <div class="repeater px-5 hide" id="repeater_edit">
                    <div class="mt-5">
                        <div data-repeater-list="group-mc">
                            <div data-repeater-item>
                                <div class="butt" style="min-width: 200px">
                                    <div class="d-flex justify-content-left">
                                        <div class="form-check form-check-custom form-switch form-check-success form-check-solid m-2 pt-2">
                                            <input class="form-check-input mc_option_edit" type="radio" value="" />
                                            <label class="form-check-label">
                                                Jawaban Benar
                                            </label>
                                        </div>
                                        <button data-repeater-delete type="button" class="m-2 btn btn-danger btn-sm btn-icon"><i class="bi bi-trash fs-2"></i></button>
                                    </div>
                                </div>
                                <div id="quilleditor_optmc_edit" name="optmc" class="mb-2 optmc_n_edit" style="height: 250px"></div>
                            </div>
                        </div>
                        <input data-repeater-create type="button" class="btn btn-info btn-sm mt-2" value="Tambah Pilihan" />
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

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_update_content_quest">
    <div class="modal-dialog modal-xl">
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
                        <small class="text-danger hide" id="rmsg"><span id="msg_err_mdl"></span></small>
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
                <div class="hide" id="select_tk_alert">
                    <div class="alert alert-danger d-flex align-items-center p-2 mb-5">
                        <i class="bi bi-shield-fill-x fs-2hx text-danger me-4"><span class="path1"></span><span class="path2"></span></i>
                        <div class="d-flex flex-column">
                            <div id="msgshareless"></div>
                        </div>
                    </div>
                </div>
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

            <div class="modal-footer" id="btn-footer">
                <button type="button" class="btn btn-light-danger" onclick="close_share_task_modal();">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="act_share_task();">Kirim</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_upload_task">
    <div class="modal-dialog">
        <div class="modal-content" id="content_modal">
            <div class="modal-header">
                <div id="head_content_modal_upl"></div>
            </div>
            <form action="<?= base_url('/teacher/question-bank/additional/upload-task') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div id="body_content_modal_upl"></div>
                    <div class="mb-3">
                        <input type="hidden" name="subject" value="<?= $subject ?>">
                        <input type="hidden" name="grade" value="<?= $grade ?>">
                        <p class="d-inline" style="font-size: 9pt">
                            <b>Catatan :</b>
                            <br>
                            Download
                            <a href="<?= base_url() . 'example/Template_Question_Bank_Import.xlsx'; ?>" download="Template Import Bank Soal.xlsx" class="btn btn-link btn-sm mb-1 btn-color-primary btn-active-color-warning">template </a> file excel
                            berikut untuk import soal.
                        </p>
                        <br>
                        <br>
                        <label for="task_upload" class="form-label">Pilih File Excel</label>
                        <input class="form-control form-control-sm" id="task_upload" name="task_upload" type="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-light-danger" data-bs-dismiss="modal">Tutup</button>
                    <button type="sumbit" class="btn btn-sm btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-3">
        <div class="rounded-border">
            <div class="d-grid mb-3">
                <a href="#" onclick="form_chapter_quest(1)" class="btn btn-primary btn-md" type="button"><i class="mb-1 fa fa-plus"></i> Judul Soal</a>
            </div>
            <div class="accordion-item rounded-border">
                <div class="treequest" id="treequest"></div>
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