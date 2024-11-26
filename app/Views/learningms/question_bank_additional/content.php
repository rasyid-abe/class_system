<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_update_content_quest">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="content_modal">
            <div class="modal-header">
                <div id="head_content_modal"></div>
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

<div class="row">
    <div class="col-sm-3">
        <div class="rounded-border">
            <div class="d-grid mb-3">
                <a href="#" onclick="form_chapter_quest(1)" class="btn btn-primary btn-md" type="button"><i
                        class="mb-1 fa fa-plus"></i> Judul Soal</a>
            </div>
            <div class="accordion-item rounded-border">
                <?php foreach ($questions as $k => $v): ?>
                    <div class="accordion-body bg-secondary">
                        <div class="d-flex justify-content-between">
                            <a href="#" class="d-grid" style="font-weight: 500;" onclick="toggle_collapse('<?= $v['question_bank_id'] ?>');"><?= $v['question_bank_title'] ?></a>
                            <div class="btnleft">
                                <a href="#" class="menu-dropdown" data-kt-menu-trigger="click"
                                    data-kt-menu-placement="bottom-end">
                                    <i class="bi bi-three-dots-vertical fs-3 text-gray-600"></i>
                                </a>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                    data-kt-menu="true" data-popper-placement="bottom-end"
                                    style="z-index: 107; position: fixed; inset: 0px 0px auto auto; margin: 0px; transform: translate(-13.75px, 308.75px);">
                                    <div class="menu-item px-3">
                                        <span onclick="form_chapter_quest(2, '<?= $v['question_bank_title'] ?>', <?= $v['question_bank_id'] ?>);" class="menu-link px-3">
                                            Ubah
                                        </span>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" onclick="remove_content_quest(<?= $v['question_bank_id'] ?>, '<?= $v['question_bank_title'] ?>', 1)"
                                            data-kt-users-table-filter="delete_row">
                                            Hapus
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="coll_body_<?= $v['question_bank_id'] ?>" class="hide body_collapse">
                        <div class="accordion-body bg-light">
                            <div class="d-flex justify-content-between">
                                <a href="#" class="m-1 btn btn-icon btn-outline btn-outline-primary btn-active-primary">1</a>
                                <a href="#" class="m-1 btn btn-icon btn-outline btn-outline-primary btn-active-primary">2</a>
                                <a href="#" class="m-1 btn btn-icon btn-outline btn-outline-primary btn-active-primary">12</a>
                                <a href="#" class="m-1 btn btn-icon btn-outline btn-outline-primary btn-active-primary">12</a>
                                <a href="#" class="m-1 btn btn-icon btn-outline btn-outline-secondary btn-active-secondary"><i class="bi bi-plus fs-2"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    <div class="col-sm-9">
        <div class="bg-secondary accordion-header p-3 mb-3 d-flex" style="border-radius: 5px;">
            <span class="px-2">Soal 1</span>
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
                    <div class="position-relative">
                        <div class="position-absolute top-0"></div>
                        <textarea class="form-control"></textarea>
                    </div>
                </div>

                <div class="hide" id="multiplechoice">
                    <div class="mt-10">
                        <label for="exampleFormControlInput1" class="form-label">Pilihan</label>
                        <div class="position-relative">
                            <div class="position-absolute top-0"></div>
                            <textarea class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="mt-1">
                        <div class="position-relative">
                            <div class="position-absolute top-0"></div>
                            <textarea class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="mt-1">
                        <div class="position-relative">
                            <div class="position-absolute top-0"></div>
                            <textarea class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="mt-1">
                        <div class="position-relative">
                            <div class="position-absolute top-0"></div>
                            <textarea class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="repeater">
                        <div class="mt-2">
                            <div data-repeater-list="group-a">
                                <div data-repeater-item>
                                    <div class="d-flex justify-content-between mb-2">
                                        <textarea name="textarea-input" class="form-control"></textarea>
                                        <div class="butt ml-3" style="min-width: 200px">
                                            <div class="form-check form-check-custom form-check-solid m-2">
                                                <input class="form-check-input" type="radio" value="" id="flexRadioDefault" />
                                                <label class="form-check-label" for="flexRadioDefault">
                                                    Default radio
                                                </label>
                                            </div>
                                            <input data-repeater-delete type="button" class="m-2 btn btn-danger btn-sm" value="Delete" />
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <input data-repeater-create type="button" class="btn btn-info btn-sm mt-2" value="Tambah Pilihan" />
                        </div>
                    </div>
                </div>

                <div class="row hide" id="multiplechoice_complex">
                    <div class="mt-10">
                        <label for="exampleFormControlInput1" class="form-label">Pilihan Kompleks</label>
                        <div class="position-relative">
                            <div class="position-absolute top-0"></div>
                            <textarea class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="mt-1">
                        <div class="position-relative">
                            <div class="position-absolute top-0"></div>
                            <textarea class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="mt-1">
                        <div class="position-relative">
                            <div class="position-absolute top-0"></div>
                            <textarea class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="mt-1">
                        <div class="position-relative">
                            <div class="position-absolute top-0"></div>
                            <textarea class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="repeater">
                        <div class="mt-2">
                            <div data-repeater-list="group-a">
                                <div data-repeater-item>
                                    <div class="d-flex justify-content-between mb-2">
                                        <textarea name="textarea-input" class="form-control"></textarea>
                                        <div class="butt ml-3" style="min-width: 200px">
                                            <div class="form-check m-2">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Jawaban Benar
                                                </label>
                                            </div>
                                            <input data-repeater-delete type="button" class="m-2 btn btn-danger btn-sm" value="Delete" />
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <input data-repeater-create type="button" class="btn btn-info btn-sm mt-2" value="Tambah Pilihan" />
                        </div>
                    </div>
                </div>

                <div class="hide mt-10" id="truefalse">
                    <label for="exampleFormControlInput1" class="form-label">Jawaban</label>
                    <div class="form-check form-check-custom form-check-solid m-2">
                        <input class="form-check-input" type="radio" value="" id="flexRadioDefault" />
                        <label class="form-check-label" for="flexRadioDefault">
                            Benar
                        </label>
                    </div>
                    <div class="form-check form-check-custom form-check-solid m-2">
                        <input class="form-check-input" type="radio" value="" id="flexRadioDefault" />
                        <label class="form-check-label" for="flexRadioDefault">
                            Salah
                        </label>
                    </div>
                </div>


            </div>
        </div>

        <div class="pt-5">
            <div class="bg-secondary accordion-header p-3 mb-3 d-flex" style="border-radius: 5px;">
                <span class="px-2">Petunjuk Soal</span>
            </div>
            <div class="card p-5">
                <div class="px-5">
                    <div class="position-relative">
                        <div class="position-absolute top-0"></div>
                        <textarea class="form-control"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-5">
            <div class="bg-secondary accordion-header p-3 mb-3 d-flex" style="border-radius: 5px;">
                <span class="px-2">Penjelasan Soal</span>
            </div>
            <div class="card p-5">
                <div class="px-5">
                    <div class="position-relative">
                        <div class="position-absolute top-0"></div>
                        <textarea class="form-control"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->endSection(); ?>