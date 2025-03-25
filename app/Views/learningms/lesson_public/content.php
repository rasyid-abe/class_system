<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="hover-scroll-x">
            <div class="d-grid">
                <ul class="nav nav-tabs flex-nowrap text-nowrap">
                    <li class="nav-item">
                        <a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0 tab_topic_a active" id="tab_topic_a_content" data-bs-toggle="tab" href="#tab_content_p">Materi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0 tab_topic_a" id="tab_topic_a_video" data-bs-toggle="tab" href="#tab_video_p">Video</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0 tab_topic_a" id="tab_topic_a_attachment" data-bs-toggle="tab" href="#tab_attachment_p">Lampiran</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0 tab_topic_a" id="tab_topic_a_task" data-bs-toggle="tab" href="#tab_task_p">Latihan</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card p-5" id="content_value">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade content_topic show active" id="tab_content_p" role="tabpanel">
                    <div id="content_lesson_p"></div>
                </div>
                <div class="tab-pane fade content_topic" id="tab_video_p" role="tabpanel">
                    <div id="btn_conf_vid_"></div>
                    <div id="video_lesson_p"></div>
                </div>
                <div class="tab-pane fade content_topic" id="tab_attachment_p" role="tabpanel">
                    <div id="btn_conf_attach_"></div>
                    <div id="attachment_lesson_p"></div>
                </div>
                <div class="tab-pane fade content_topic" id="tab_task_p" role="tabpanel">
                    <div id="task_lesson_p"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>


</script>

<?php $this->endSection(); ?>
