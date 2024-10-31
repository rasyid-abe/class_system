<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_upload_content_a">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="content_modal">
            <div class="modal-header">
                <div id="head_upload_modal"></div>
            </div>
            <form enctype="multipart/form-data" action="<?= base_url('/teacher/lesson/additional/upload-content') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="subject" value="<?= $subject ?>">
                    <input type="hidden" name="grade" value="<?= $grade ?>">
                    <div id="body_upload_modal"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-light-danger" data-bs-dismiss="modal">Tutup</button>
                    <button type="sumbit" id="submit_upload" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_update_content_a">
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
                        <div id="body_content_modal_a"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light-danger" onclick="close_modal_content_a();">Tutup</button>
                <button type="sumbit" class="btn btn-sm btn-primary" onclick="save_content_a();">Simpan</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_share_a">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><div id="shared_title_a"></div></h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>
            <div class="modal-body">
                <input type="hidden" name="less_id" val="">
                <div class="form-check form-check-custom form-check-solid me-10 mb-2 form-check-inline">
                    <input class="form-check-input input_share_a" type="radio" name="gender" value="1" id="opt1" />
                    <label class="form-check-label text-dark" for="opt1">
                        Seluruh Guru
                    </label>
                </div>
                <div class="form-check form-check-custom form-check-solid me-10 mb-2 form-check-inline">
                    <input class="form-check-input input_share_a" type="radio" name="gender" value="2" id="opt2" />
                    <label class="form-check-label text-dark" for="opt2">
                        Guru Mata Pelajaran yang sama
                    </label>
                </div>
                <div class="form-check form-check-custom form-check-solid me-10 mb-2 form-check-inline">
                    <input class="form-check-input input_share_a" type="radio" name="gender" value="3" id="opt3" />
                    <label class="form-check-label text-dark" for="opt3">
                        Guru Mata Pelajaran dan Jenjang Kelas yang sama
                    </label>
                </div>
                <div class="form-check form-check-custom form-check-solid me-10 mb-2 form-check-inline">
                    <input class="form-check-input input_share_a" type="radio" name="gender" value="4" id="opt4" />
                    <label class="form-check-label text-dark" for="opt4">
                        Guru tertentu
                    </label>
                </div>

                <select class="form-select hide" id="multiple-select-field-a" data-placeholder="Pilih Guru" multiple disabled>
                    <?php foreach ($teachers as $k => $v): ?>
                        <?php $degr = $v['teacher_degree'] != '' ? ', ' . $v['teacher_degree'] : ''  ?>
                        <option value="<?= $v['teacher_id'] ?>"><?= $v['teacher_first_name'] . ' ' . $v['teacher_last_name'] . $degr ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light-danger" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="act_share_a();">Kirim</button>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-sm-3">
        <div class="rounded border">
            <div class="" id="kt_accordion_1">

                <?php if (count($chapters) > 0) : ?>

                    <div class="d-grid mb-2">
                        <a href="#" onclick="form_chapter_a(4, '', '', '')" class="btn btn-primary" type="button"><i class="mb-1 fa fa-plus"></i> BAB Pelajaran</a>
                    </div>
                    <?php foreach ($chapters as $k => $v) : ?>
                        <div class="accordion-item">
                            <div class="accordion-body bg-light">
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="d-grid" style="font-weight: 500;" onclick="toggle_collapse(<?= $k ?>);"><?= $v['lesson_additional_chapter'] ?></a>
                                    <div class="btnleft">
                                        <a href="#" class="" onclick="form_chapter_a(3, '<?= $v['lesson_additional_chapter'] ?>', '', '<?= $v['lesson_additional_id'] ?>')">
                                            <i class="bi bi-plus fs-3 text-gray-600"></i>
                                        </a>
                                        <a href="#" class="menu-dropdown" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <i class="bi bi-three-dots-vertical fs-3 text-gray-600"></i>
                                        </a>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true" data-popper-placement="bottom-end"
                                            style="z-index: 107; position: fixed; inset: 0px 0px auto auto; margin: 0px; transform: translate(-13.75px, 308.75px);">
                                            <div class="menu-item px-3">
                                                <span onclick="form_chapter_a(1, '<?= $v['lesson_additional_chapter'] ?>', '', '<?= $v['lesson_additional_id'] ?>');" class="menu-link px-3">
                                                    Ubah
                                                </span>
                                            </div>
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3" onclick="remove_content_a(<?= $v['lesson_additional_id'] ?>, 1, '<?= $v['lesson_additional_chapter'] ?>')" data-kt-users-table-filter="delete_row">
                                                    Hapus BAB
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="coll_body_<?= $k ?>" class="hide body_collapse">
                                <div class="accordion-body bg-secondary">
                                    <?php foreach ($v['sub_chapter'] as $key => $val): ?>
                                        <?php if ($val['lesson_additional_subchapter'] != '') : ?>
                                            <div class="d-flex justify-content-between">
                                                <a href="#" class="text-primary opacity-75-hover fs-6 fw-semibold" onclick="view_content_a(<?= $val['lesson_additional_id'] ?>);"><?= $val['lesson_additional_subchapter'] ?></a>
                                                <div class="">
                                                    <a href="#" class="" onclick="share_topic_a(<?= $val['lesson_additional_id'] ?>, '<?= $val['lesson_additional_chapter'] ?>', '<?= $val['lesson_additional_subchapter'] ?>');">
                                                        <i class="bi bi-share fs-5 text-gray-600"></i>
                                                    </a>
                                                    <a href="#" class="menu-dropdown" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                        <i class="bi bi-three-dots-vertical fs-3 text-gray-600"></i>
                                                    </a>
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true" style="z-index: 107; position: fixed; inset: 0px 0px auto auto; margin: 0px; transform: translate(-13.75px, 308.75px);" data-popper-placement="bottom-end">
                                                        <div class="menu-item px-3">
                                                            <span onclick="form_chapter_a(2, '<?= $val['lesson_additional_chapter'] ?>', '<?= $val['lesson_additional_subchapter'] ?>', '<?= $val['lesson_additional_id'] ?>');" class="menu-link px-3">
                                                                Ubah
                                                            </span>
                                                        </div>
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" onclick="remove_content_a(<?= $val['lesson_additional_id'] ?>, 2)" data-kt-users-table-filter="delete_row">
                                                                Hapus Topik
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?= count($v['sub_chapter']) > 1 ? '<div class="separator separator-dashed my-3"></div>' : '' ?>
                                        <?php endif; ?>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                <?php else : ?>
                    <div class="d-grid mb-2">
                        <a href="#" onclick="form_chapter_a(4, '', '', '')" class="btn btn-primary" type="button"><i class="mb-1 fa fa-plus"></i> BAB Pelajaran</a>
                    </div>
                <?php endif ?>

            </div>
        </div>
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
                    <div id="task_lesson"></div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php $this->endSection(); ?>