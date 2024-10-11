<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="row">
    <div class="col-sm-12">
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

        <div class="card p-5" id="content_value">
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
    $(document).ready(function(){
        let id = '<?= $id_content ?>'
        $.ajax({
            url: '<?= base_url('/teacher/lesson/public/get-content') ?>',
            data: {id},
            method: 'post',
            dataType: 'json',
            success: function(e) {
                console.log(e);
                
                generate_view_lesson(e[0])
                generate_view_video(e[0])
                generate_view_attachment(e[0])
                generate_view_task(e[0])
            }
        })

        // if ($('#content_tab').hasClass('hide')) {
        //     $('#content_tab').removeClass('hide')
        //     $('#content_value').removeClass('hide')
        // }
    })

    function generate_view_lesson(e) {
        $('.btn_content_content').html('');
        $('.btn_conf_topic').html('');

        let file_path = '<?= base_url() . 'lesson_file/' ?>'

        let butn = `
            <div class="accordion accordion-icon-toggle" id="kt_accordion_2">
                <div class="mt-5">
                    <div class="bg-secondary accordion-header d-flex p-1" data-bs-toggle="collapse" data-bs-target="#kt_accordion_2_item_1" style="border-radius: 5px;">
                        <span class="accordion-icon">
                            <i class="ki-duotone ki-arrow-right fs-4"><span class="path1"></span><span class="path2"></span></i>
                        </span>
                        <span class="px-2">Konten Teks</span>
                    </div>

                    <div id="kt_accordion_2_item_1" class="fs-6 collapse show m-5" data-bs-parent="#kt_accordion_2" style="max-height: 500px; overflow-y: scroll;">
                        ${e.lesson_additional_content != '' ? e.lesson_additional_content : 'Materi belum tersedia' }
                    </div>
                </div>

                <div class="mt-5">
                    <div class="bg-secondary accordion-header p-1 d-flex collapsed" data-bs-toggle="collapse" data-bs-target="#kt_accordion_2_item_2" style="border-radius: 5px;">
                        <span class="accordion-icon">
                            <i class="ki-duotone ki-arrow-right fs-4"><span class="path1"></span><span class="path2"></span></i>
                        </span>
                        <span class="px-2">Konten File</span>
                    </div>

                    <div id="kt_accordion_2_item_2" class="collapse fs-6 m-5" data-bs-parent="#kt_accordion_2">

                        ${e.lesson_additional_content_path != '' ? `<embed src="${file_path + e.lesson_additional_content_path}" width="100%" height="500px" />` : 'File belum tersedia' }
                    </div>
                </div>

            </div>

        `;


        $('#content_lesson').html(butn)
    }

    function generate_view_video(e) {
        $('.btn_video_content').html('');
        $('#btn_conf_vid_').html('');

        let id_vid = youtube_parser(e.lesson_additional_video_path);
        let vid_view = `
        <div class="video-container">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/${id_vid}?controls=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>`;

        $('#video_lesson').html(e.lesson_additional_video_path != '' ? vid_view : 'Video belum tersedia')
    }

    function generate_view_attachment(e) {
        $('.btn_attach_content').html('');
        $('#btn_conf_attach_').html('');

        let btnn = '';
        if (e.lesson_additional_attachment_path != '') {
            let attach = JSON.parse(e.lesson_additional_attachment_path)
            for (let i = 0; i < attach.length; i++) {
                spl = attach[i].split("^");
                btnn += `

                    <div class="btn-group m-1" role="group">
                        <button type="button" id="download_attch" data-file= "${spl[2]}"class="btn btn-outline btn-outline-primary btn-outline-primary btn-active-light-primary btn-sm">
                        ${spl[2]}
                        </button>
                    </div>
                `;
            }
        } else {
            btnn = 'Lampiran belum tersedia';
        }

        $('#attachment_lesson').html(btnn)
    }

    function generate_view_task(e) {
        $('.btn_task_content').html('');
        // $('#task_lesson').html(e.lesson_additional_video_path)
        if (e.lesson_additional_tasks != '') {
            $('#task_lesson').before('<div class="btn_task_content"><button type="button" class="btn btn-sm btn-primary">Ubah Video</button></div>')
        } else {
            $('#task_lesson').before('<div class="btn_task_content"><button type="button" class="btn btn-sm btn-primary">Tambah Video</button></div>')
        }
    }

</script>

<?php $this->endSection(); ?>
