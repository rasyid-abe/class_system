<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_upload_content">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="content_modal">
            <div class="modal-header">
                <div id="head_upload_modal"></div>
            </div>
            <form enctype="multipart/form-data" action="<?= base_url('/teacher/lesson/school/upload-content') ?>" method="post">
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

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_update_content">
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
                        <div id="body_content_modal"></div>
                        <!-- <div class="private_tree">
                            <div role="treeitem" class="parent_list my-2" data-bs-toggle="collapse" data-bs-target="#child_list-0" style="padding-left:1.25rem" aria-level="1"><i class="state-icon fa fa-angle-right fa-fw"></i>Materi Saya</div>
                            <div role="group" class="hide" id="child_list-0">
                                <div role="treeitem" class="parent_list my-2" data-bs-toggle="collapse" data-bs-target="#child_list-1" style="padding-left:2.5rem;" aria-level="2"><i class="state-icon fa fa-angle-right fa-fw"></i>Judul BAB</div>
                                <div role="group" class="hide" id="child_list-1">
                                    <div role="treeitem" class="parent_list my-2" data-bs-toggle="collapse" data-bs-target="#child_list-2" style="padding-left:3.75rem;" aria-level="3">Topik Pertama</div>
                                </div>
                                <div role="treeitem" class="parent_list my-2" data-bs-toggle="collapse" data-bs-target="#child_list-3" style="padding-left:2.5rem;" aria-level="2"><i class="state-icon fa fa-angle-right fa-fw"></i>Judul BAB 2</div>
                                <div role="group" class="hide" id="child_list-3">
                                    <div role="treeitem" class="parent_list my-2" data-bs-toggle="collapse" data-bs-target="#child_list-4" style="padding-left:3.75rem;" aria-level="3">Topik Pertama 2</div>
                                </div>
                                <div role="treeitem" class="parent_list my-2" data-bs-toggle="collapse" data-bs-target="#child_list-5" style="padding-left:2.5rem;" aria-level="2"><i class="state-icon fa fa-angle-right fa-fw"></i>Judul BAB 3</div>
                                <div role="group" class="hide" id="child_list-5">
                                    <div role="treeitem" class="parent_list my-2" data-bs-toggle="collapse" data-bs-target="#child_list-6" style="padding-left:3.75rem;" aria-level="3">Sub BAB 32</div>
                                </div>
                            </div>
                            <div role="treeitem" class="parent_list my-2" data-bs-toggle="collapse" data-bs-target="#child_list-7" style="padding-left:1.25rem" aria-level="1"><i class="state-icon fa fa-angle-right fa-fw"></i>Materi Standar</div>
                            <div role="group" class="hide" id="child_list-7">
                                <div role="treeitem" class="parent_list my-2" data-bs-toggle="collapse" data-bs-target="#child_list-8" style="padding-left:2.5rem;" aria-level="2"><i class="state-icon fa fa-angle-right fa-fw"></i>1</div>
                                <div role="group" class="hide" id="child_list-8">
                                    <div role="treeitem" class="parent_list my-2" data-bs-toggle="collapse" data-bs-target="#child_list-9" style="padding-left:3.75rem;" aria-level="3">1.1</div>
                                </div>
                                <div role="treeitem" class="parent_list my-2" data-bs-toggle="collapse" data-bs-target="#child_list-10" style="padding-left:2.5rem;" aria-level="2"><i class="state-icon fa fa-angle-right fa-fw"></i>Test Chapter</div>
                                <div role="group" class="hide" id="child_list-10">
                                    <div role="treeitem" class="parent_list my-2" data-bs-toggle="collapse" data-bs-target="#child_list-11" style="padding-left:3.75rem;" aria-level="3">Lesson 1</div>
                                    <div role="treeitem" class="parent_list my-2" data-bs-toggle="collapse" data-bs-target="#child_list-12" style="padding-left:3.75rem;" aria-level="3">Lesson 2</div>
                                </div>
                                <div role="treeitem" class="parent_list my-2" data-bs-toggle="collapse" data-bs-target="#child_list-13" style="padding-left:2.5rem;" aria-level="2"><i class="state-icon fa fa-angle-right fa-fw"></i>Test Chapter Duplicate</div>
                                <div role="group" class="hide" id="child_list-13">
                                    <div role="treeitem" class="parent_list my-2" data-bs-toggle="collapse" data-bs-target="#child_list-14" style="padding-left:3.75rem;" aria-level="3">Lesson 1 Duplicate</div>
                                    <div role="treeitem" class="parent_list my-2" data-bs-toggle="collapse" data-bs-target="#child_list-15" style="padding-left:3.75rem;" aria-level="3">Lesson 2 Duplicate</div>
                                </div>
                            </div>
                            <div role="treeitem" class="parent_list my-2" data-bs-toggle="collapse" data-bs-target="#child_list-16" style="padding-left:1.25rem" aria-level="1"><i class="state-icon fa fa-angle-right fa-fw"></i>Materi Publik</div>
                            <div role="group" class="hide" id="child_list-16">
                                <div role="treeitem" class="parent_list my-2" data-bs-toggle="collapse" data-bs-target="#child_list-17" style="padding-left:2.5rem;" aria-level="2"><i class="state-icon fa fa-angle-right fa-fw"></i>Shared Test</div>
                                <div role="group" class="hide" id="child_list-17">
                                    <div role="treeitem" class="parent_list my-2" data-bs-toggle="collapse" data-bs-target="#child_list-18" style="padding-left:3.75rem;" aria-level="3">Share All</div>
                                    <div role="treeitem" class="parent_list my-2" data-bs-toggle="collapse" data-bs-target="#child_list-19" style="padding-left:3.75rem;" aria-level="3">Share Subject</div>
                                    <div role="treeitem" class="parent_list my-2" data-bs-toggle="collapse" data-bs-target="#child_list-20" style="padding-left:3.75rem;" aria-level="3">Shared Subject &amp; Grade</div>
                                    <div role="treeitem" class="parent_list my-2" data-bs-toggle="collapse" data-bs-target="#child_list-21" style="padding-left:3.75rem;" aria-level="3">Shared Directly</div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light-danger" onclick="close_modal_content();">Tutup</button>
                <button type="sumbit" class="btn btn-sm btn-primary" onclick="save_content();">Simpan</button>
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
                        <a href="#" onclick="form_chapter(4, '', '', '')" class="btn btn-primary" type="button"><i class="mb-1 fa fa-plus"></i> BAB Pelajaran</a>
                    </div>
                    <?php foreach ($chapters as $k => $v) : ?>
                        <div class="accordion-item">
                            <div class="accordion-body bg-light">
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="d-grid" style="font-weight: 500;" onclick="toggle_collapse(<?= $k ?>);"><?= $v['lesson_school_chapter'] ?></a>
                                    <div class="btnleft">
                                        <a href="#" class="" onclick="form_chapter(3, '<?= $v['lesson_school_chapter'] ?>', '', '<?= $v['lesson_school_id'] ?>')">
                                            <i class="bi bi-plus fs-3 text-gray-600"></i>
                                        </a>
                                        <a href="#" class="menu-dropdown" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <i class="bi bi-three-dots-vertical fs-3 text-gray-600"></i>
                                        </a>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true" data-popper-placement="bottom-end"
                                            style="z-index: 107; position: fixed; inset: 0px 0px auto auto; margin: 0px; transform: translate(-13.75px, 308.75px);">
                                            <div class="menu-item px-3">
                                                <span onclick="form_chapter(1, '<?= $v['lesson_school_chapter'] ?>', '', '<?= $v['lesson_school_id'] ?>');" class="menu-link px-3">
                                                    Ubah
                                                </span>
                                            </div>
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3" onclick="remove_content(<?= $v['lesson_school_id'] ?>, 1, '<?= $v['lesson_school_chapter'] ?>')" data-kt-users-table-filter="delete_row">
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
                                        <?php if ($val['lesson_subchapter'] != '') : ?>
                                            <?php $lesson_id = $val['lesson_additional_id'] > 0 ? $val['lesson_additional_id'] : $val['lesson_standart_id']; ?>
                                            <div class="d-flex justify-content-between">
                                                <a href="#" class="text-primary opacity-75-hover fs-6 fw-semibold" onclick="view_content(<?= $lesson_id ?>, '<?= $val['lesson_source'] ?>');"><?= $val['lesson_subchapter'] ?></a>
                                                <div class="">
                                                    <a href="#" class="menu-dropdown" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                        <i class="bi bi-three-dots-vertical fs-3 text-gray-600"></i>
                                                    </a>
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true" style="z-index: 107; position: fixed; inset: 0px 0px auto auto; margin: 0px; transform: translate(-13.75px, 308.75px);" data-popper-placement="bottom-end">
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" onclick="remove_content(<?= $lesson_id ?>, 2)" data-kt-users-table-filter="delete_row">
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
                        <a href="#" onclick="form_chapter(4, '', '', '')" class="btn btn-primary" type="button"><i class="mb-1 fa fa-plus"></i> BAB Pelajaran</a>
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

        <div class="card p-5 hide" id="content_value">
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

<script>
    
</script>

<?php $this->endSection(); ?>