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
                                                <a href="#" class="text-primary opacity-75-hover fs-6 fw-semibold" onclick="view_content(<?= $val['lesson_standart_id'] ?>);"><?= $val['lesson_standart_subchapter'] ?></a>
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

<script type="text/javascript">

    $(document.body).on('click', '#btn_update_content_file', function() {
        let id = $('#btn_update_attach').data('id');

        let form = `
            <input type="hidden" name="lesson_id" value="${id}" />
            <input type="hidden" name="type" value="8" />
            <p class="mt-2">
                
                <label for="attachment">
                    <a class="btn btn-primary text-light btn-sm" role="button" aria-disabled="false">+ Pilih File</a>
                </label><br>
                <small class="text-info">* Hanya menerima file PDF dengan kapasistas maks 10 Mb.</small>
                <input type="file" name="file_attach" id="attachment" accept="application/pdf" style="visibility: hidden; position: absolute;"/>
            </p>
            <p id="files-area">
                <span id="filesList">
                    <span id="files-names"></span>
                </span>
            </p>
            <div id="sum_attach" class="mt-2"></div>
        `;

        $('#body_upload_modal').html(form)
        $('#head_upload_modal').html('<h3 class="modal-title">Upload Dokumen File</h3>')
        $('#modal_upload_content').modal('show')
        $('#submit_upload').attr('disabled', 'disabled')
    })

    $(document.body).on('click', '#btn_update_content', function() {
        $('#body_content_modal').html('')
        let id = $('#btn_update_content').data('id');
        $.ajax({
            url: '<?= base_url('/teacher/lesson/additional/grab-topic-content') ?>',
            data: {
                id
            },
            method: 'post',
            dataType: 'json',
            success: function(e) {
                let form = `
                    <input type="hidden" name="lesson_id" value="${id}" />
                    <input type="hidden" name="form_type" value="5" />
                    <textarea id="content" name="content" class="tinymce-editor">${e.lesson_standart_content}</textarea>
                `;

                $('#body_content_modal').html(form)
                $('#head_content_modal').html('<h3 class="modal-title">Update Materi Pembelajaran</h3>')
                $('#modal_update_content').modal('show')
                conf_tinymce()
            }
        })

    })

    $(document.body).on('click', '#btn_update_video', function() {
        let id = $('#btn_update_video').data('id');
        let url = $('#btn_update_video').data('url');

        let id_vid = youtube_parser(url);
        let vid_view = `<iframe width="620" height="315"
            src="https://www.youtube.com/embed/${id_vid}?controls=0">
            </iframe>`;

        let form = `
            <input type="hidden" name="lesson_id" value="${id}" />
            <input type="hidden" name="form_type" value="6" />
            <label for="videolink" class="form-label">Tautan Video</label>
            <input type="text" class="form-control form-control-md" name="videolink" value="${url}" />
            <small class="text-danger">* Hanya bisa menggunakan tautan youtube</small>
            <div id="preview_video">${vid_view}</div> 
        `;

        $('#body_content_modal').html(form)
        $('#head_content_modal').html('<h3 class="modal-title">Update Video Pembelajaran</h3>')
        $('#modal_update_content').modal('show')
    })

    $(document.body).on('input', 'input[name=videolink]', function() {
        let v_id = youtube_parser($(this).val());
        let view_vid = `
            <iframe width="620" height="315"
            src="https://www.youtube.com/embed/${v_id}?controls=0">
            </iframe> 
        `;

        $('#preview_video').html(view_vid)
    })

    $(document.body).on('click', '#btn_update_attach', function() {
        let id = $('#btn_update_attach').data('id');

        let form = `
            <input type="hidden" name="lesson_id" value="${id}" />
            <input type="hidden" name="type" value="7" />
            <p class="mt-2">
                
                <label for="attachment">
                    <a class="btn btn-primary text-light" role="button" aria-disabled="false">+ Tambah File</a>
                </label><br>
                <small class="text-info">Dapat upload max 10 file sekaligus dengan total kapasitas max 50 Mb.</small>
                <input type="file" name="file_attach[]" id="attachment" style="visibility: hidden; position: absolute;" multiple="multiple"/>
            </p>
            <p id="files-area">
                <span id="filesList">
                    <span id="files-names"></span>
                </span>
            </p>
            <div id="sum_attach" class="mt-2"></div>
        `;

        $('#body_upload_modal').html(form)
        $('#head_upload_modal').html('<h3 class="modal-title">Lampiran Dokumen</h3>')
        $('#submit_upload').attr('disabled', 'disabled');
        $('#modal_upload_content').modal('show')
    })

    const dt = new DataTransfer(); // Permet de manipuler les fichiers de l'input file
    const sizes = {}
    $(document.body).on('change', '#attachment', function(e) {
        for (var i = 0; i < this.files.length; i++) {
            let fileBloc = $('<span/>', {
                    class: 'file-block'
                }),
                fileName = $('<span/>', {
                    class: 'name',
                    text: this.files.item(i).name
                });
            fileBloc.append('<span class="file-delete"><span>+</span></span>')
                .append(fileName);
            $("#filesList > #files-names").append(fileBloc);
            sizes[this.files[i].size] = this.files.item(i).name
        };

        config_size(1)

        // Ajout des fichiers dans l'objet DataTransfer
        for (let file of this.files) {
            dt.items.add(file);
        }
        // Mise à jour des fichiers de l'input file après ajout
        this.files = dt.files;

        // EventListener pour le bouton de suppression créé
        $('span.file-delete').click(function() {
            let name = $(this).next('span.name').text();
            // Supprimer l'affichage du nom de fichier
            $(this).parent().remove();
            for (let i = 0; i < dt.items.length; i++) {
                // Correspondance du fichier et du nom
                if (name === dt.items[i].getAsFile().name) {
                    config_size(dt.files[i].size)
                    // Suppression du fichier dans l'objet DataTransfer
                    dt.items.remove(i);
                    continue;
                }
            }
            // Mise à jour des fichiers de l'input file après suppression
            document.getElementById('attachment').files = dt.files;
        });
    });

    $(document.body).on('click', '#download_attch', function(e) {
        e.preventDefault()
        let file = $(this).data('file')
        window.location.href = '<?= base_url() . 'attachment/' ?>' + file;
    })

    function config_size(e) {
        if (e != 1) delete sizes[e];
        let type = $('input[name=type]').val()

        let si = ii = 0;
        for (let k in sizes) {
            si += parseInt(k)
            ii++
        }

        let views = ''
        if (type == 7) {
            let allow_size = 50000000
            let allow_file = 10

            if (si > allow_size || ii > allow_file) {
                $('#submit_upload').attr('disabled', 'disabled');
            } else {
                $('#submit_upload').removeAttr('disabled');
            }

            let views = `
                <span class="badge badge-${ii > allow_file ? 'danger' : 'info'}">${ii} File</span>
                <span class="badge badge-${si > allow_size ? 'danger': 'info'}">${formatBytes(si)}</span>
                ${si > allow_size ? '<br><small class="text-danger">* Total kapasitas melebihi kapasistas maksimal</small>' : ''}
                ${ii > allow_file ? '<br><small class="text-danger">* Total file melebihi kapasistas maksimal</small>' : ''}
            `;

            $('#sum_attach').html(views)
        } else if (type == 8) {
            let allow_size = 10000000

            if (si > allow_size) {
                $('#submit_upload').attr('disabled', 'disabled');
            } else {
                $('#submit_upload').removeAttr('disabled');
            }

            let views = `
                <span class="badge badge-${si > allow_size ? 'danger': 'info'}">${formatBytes(si)}</span>
                ${si > allow_size ? '<br><small class="text-danger">* Total kapasitas melebihi kapasistas maksimal</small>' : ''}
            `;
            $('#sum_attach').html(views)
        }

        if (ii < 1) {
            $('#sum_attach').html('')
            $('#submit_upload').attr('disabled', 'disabled');
        }
    }

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
                        ${e.lesson_standart_content != '' ? e.lesson_standart_content : 'Materi belum tersedia' }
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
                        ${e.lesson_standart_content_path != '' ? `<embed src="${file_path + e.lesson_standart_content_path}" width="100%" height="500px" />` : 'File belum tersedia' }
                    </div>
                </div>

            </div>

        `;


        $('#content_lesson').html(butn)
    }

    function generate_view_video(e) {
        $('.btn_video_content').html('');
        $('#btn_conf_vid_').html('');

        let id_vid = youtube_parser(e.lesson_standart_video_path);
        let vid_view = `
        <div class="video-container">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/${id_vid}?controls=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>`;

        $('#video_lesson').html(e.lesson_standart_video_path != '' ? vid_view : 'Video belum tersedia')
    }

    function generate_view_attachment(e) {
        $('.btn_attach_content').html('');
        $('#btn_conf_attach_').html('');

        let btnn = '';
        if (e.lesson_standart_attachment_path != '') {
            let attach = JSON.parse(e.lesson_standart_attachment_path)
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
        // $('#task_lesson').html(e.lesson_standart_video_path)
        if (e.lesson_standart_tasks != '') {
            $('#task_lesson').before('<div class="btn_task_content"><button type="button" class="btn btn-sm btn-primary">Ubah Video</button></div>')
        } else {
            $('#task_lesson').before('<div class="btn_task_content"><button type="button" class="btn btn-sm btn-primary">Tambah Video</button></div>')
        }
    }

    function view_content(id) {
        $.ajax({
            url: '<?= base_url('/teacher/lesson/standart/grab-content') ?>',
            data: {
                id
            },
            method: 'post',
            dataType: 'json',
            success: function(e) {
                generate_view_lesson(e)
                generate_view_video(e)
                generate_view_attachment(e)
                generate_view_task(e)
            }
        })

        if ($('#content_tab').hasClass('hide')) {
            $('#content_tab').removeClass('hide')
            $('#content_value').removeClass('hide')
        }
    }


    function download_attach(file) {
        $.ajax({
            url: '<?= base_url('/teacher/lesson/additional/download-attach') ?>',
            data: {
                file
            },
            method: 'post',
            success: function(e) {}
        })
    }

    function toggle_collapse(e) {
        // $('.head_collapse').removeClass('collapsed')
        // $('.body_collapse').addClass('hide')
        if ($(`#coll_body_${e}`).hasClass('hide')) {
            $(`#coll_body_${e}`).removeClass('hide')
        } else {
            $(`#coll_body_${e}`).addClass('hide')
        }
        if ($(`#btn_head_${e}`).hasClass('collapsed')) {
            $(`#btn_head_${e}`).removeClass('collapsed')
        } else {
            $(`#btn_head_${e}`).addClass('collapsed')
        }

    }
</script>

<?php $this->endSection(); ?>