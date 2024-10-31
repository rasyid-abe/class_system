<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_upload_content">
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


                    <?php foreach ($chapters as $k => $v) : ?>
                        <div class="accordion-item">
                            <div class="accordion-body bg-light">
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="d-grid" style="font-weight: 500;" onclick="toggle_collapse(<?= $k ?>);"><?= $v['lesson_standart_chapter'] ?></a>
                                </div>
                            </div>
                            <div id="coll_body_<?= $k ?>" class="hide body_collapse">
                                <div class="accordion-body bg-secondary">
                                    <?php foreach ($v['sub_chapter'] as $key => $val): ?>
                                        <?php if ($val['lesson_standart_subchapter'] != '') : ?>
                                            <div class="d-flex justify-content-between">
                                                <a href="#" class="text-primary opacity-75-hover fs-6 fw-semibold" onclick="view_content_s(<?= $val['lesson_standart_id'] ?>);"><?= $val['lesson_standart_subchapter'] ?></a>
                                            </div>
                                            <?= count($v['sub_chapter']) > 1 ? '<div class="separator separator-dashed my-3"></div>' : '' ?>
                                        <?php endif; ?>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>

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

<?php $this->endSection(); ?>   