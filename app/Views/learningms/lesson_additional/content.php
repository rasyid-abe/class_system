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
                        <small class="text-danger hide" id="rmsg"><span id="msg_err_mdl"></span></small>
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
                <h3 class="modal-title">
                    <div id="shared_title_a"></div>
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

                <input type="hidden" name="less_id" val="">
                <input type="hidden" name="title_topic" val="">
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

                <div class="hide" id="shared_less_to">
                    <select class="form-select form-select-sm form-select-solid" id="multiple-select-field-a" data-control="select2" data-close-on-select="false" data-placeholder="Pilih Guru" data-allow-clear="true" multiple="multiple">
                        <?php foreach ($teachers as $k => $v): ?>
                            <?php $degr = $v['teacher_degree'] != '' ? ', ' . $v['teacher_degree'] : ''  ?>
                            <option value="<?= $v['teacher_id'] ?>"><?= $v['teacher_first_name'] . ' ' . $v['teacher_last_name'] . $degr ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="modal-footer" id="btn-footer">
                <button type="button" class="btn btn-light-danger" onclick="close_share_les()">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="act_share_a();">Kirim</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_task_a">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">
                    <div id="task_title_a">Tambah Latihan</div>
                </h3>
            </div>
            <div class="modal-body">
                <div class="hide" id="select_quest_alert">
                    <div class="alert alert-danger d-flex align-items-center p-2 mb-5">
                        <i class="bi bi-shield-fill-x fs-2hx text-danger me-4"><span class="path1"></span><span class="path2"></span></i>
                        <div class="d-flex flex-column">
                            <div id="">Belum ada soal yang dipilih!</div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="less_id" val="">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="task" id="view_select_task"></div>
                    </div>
                    <div class="col-sm-9">
                        <div class="task" id="preview_task"></div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light-danger" onclick="close_task_a()">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="act_task_a();">Kirim</button>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-sm-3">
        <div class="rounded border">
            <div class="" id="kt_accordion_1">

                <div class="d-grid mb-2">
                    <a href="#" onclick="form_chapter_a(4, '', '', '')" class="btn btn-primary" type="button"><i class="mb-1 fa fa-plus"></i> BAB Pelajaran</a>
                </div>
                <div class="treeslesson" id="treeslesson"></div>
            </div>
        </div>
    </div>

    <div class="col-sm-9 hide" id="content_tab_add">
        <!-- <div class="hover-scroll-x"> -->
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
                        <a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0 tab_topic_a" id="tab_topic_a_task" data-bs-toggle="tab" href="#tab_task">Latihan</a>
                    </li>
                </ul>
            </div>
        <!-- </div> -->

        <div class="card p-5 hide" id="content_value_add">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade content_topic_a show active" id="tab_content" role="tabpanel">
                    <div id="content_lesson"></div>
                </div>
                <div class="tab-pane fade content_topic_a" id="tab_video_a" role="tabpanel">
                    <div id="btn_conf_vid_a"></div>
                    <div id="video_lesson"></div>
                </div>
                <div class="tab-pane fade content_topic_a" id="tab_attachment_a" role="tabpanel">
                    <div id="btn_conf_attach_a"></div>
                    <div id="attachment_lesson"></div>
                </div>
                <div class="tab-pane fade content_topic_a" id="tab_task" role="tabpanel">
                    <div id="btn_conf_task_"></div>
                    <div id="task_lesson"></div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php $this->endSection(); ?>