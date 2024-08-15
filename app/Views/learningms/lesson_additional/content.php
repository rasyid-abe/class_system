<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

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

                <?php if (count($chapters) > 0) : ?>

                    <div class="d-grid mb-2">
                        <a href="#" onclick="form_chapter(4, '', '', '')" class="btn btn-primary" type="button"><i class="mb-1 fa fa-plus"></i> BAB Pelajaran</a>
                    </div>
                    <?php foreach ($chapters as $k => $v) : ?>
                        <div class="accordion-item">
                            <div class="accordion-body bg-light">
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="d-grid" style="font-weight: 500;" onclick="toggle_collapse(<?= $k ?>);"><?= $v['lesson_additional_chapter'] ?></a>
                                    <div class="btnleft">
                                        <a href="#" class="" onclick="form_chapter(3, '<?= $v['lesson_additional_chapter'] ?>', '', '<?= $v['lesson_additional_id'] ?>')">
                                            <i class="bi bi-plus fs-3 text-gray-600"></i>
                                        </a>
                                        <a href="#" class="menu-dropdown" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <i class="bi bi-three-dots-vertical fs-3 text-gray-600"></i>
                                        </a>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true" data-popper-placement="bottom-end"
                                            style="z-index: 107; position: fixed; inset: 0px 0px auto auto; margin: 0px; transform: translate(-13.75px, 308.75px);">
                                            <div class="menu-item px-3">
                                                <span onclick="form_chapter(1, '<?= $v['lesson_additional_chapter'] ?>', '', '<?= $v['lesson_additional_id'] ?>');" class="menu-link px-3">
                                                    Ubah
                                                </span>
                                            </div>
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">
                                                    Hapus
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
                                                <a href="#" class="text-primary opacity-75-hover fs-6 fw-semibold" onclick="view_content(<?= $val['lesson_additional_id'] ?>);"><?= $val['lesson_additional_subchapter'] ?></a>
                                                <div class="">
                                                    <a href="#" class="menu-dropdown" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                        <i class="bi bi-three-dots-vertical fs-3 text-gray-600"></i>
                                                    </a>
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true" style="z-index: 107; position: fixed; inset: 0px 0px auto auto; margin: 0px; transform: translate(-13.75px, 308.75px);" data-popper-placement="bottom-end">
                                                        <div class="menu-item px-3">
                                                            <span onclick="form_chapter(2, '<?= $val['lesson_additional_chapter'] ?>', '<?= $val['lesson_additional_subchapter'] ?>', '<?= $val['lesson_additional_id'] ?>');" class="menu-link px-3">
                                                                Ubah
                                                            </span>
                                                        </div>
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">
                                                                Hapus
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
                        <a href="<?= base_url('/teacher/lesson/additional/create/' . $subject . '/' . $grade) ?>" class="btn btn-primary" type="button"><i class="mb-1 fa fa-plus"></i> Tambah Materi</a>
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
                    <div id="video_lesson"></div>
                </div>
                <div class="tab-pane fade content_topic" id="tab_attachment" role="tabpanel">
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
    function close_modal_content() {
        $('#modal_update_content').modal('hide')
        $('#body_content_modal').html('')
    }
    
    $(document.body).on('click', '#btn_update_content', function() {
        $('#body_content_modal').html('')
        let id = $('#btn_update_content').data('id');
        $.ajax({
            url: '<?= base_url('/teacher/lesson/additional/grab-topic-content') ?>',
            data: {id},
            method: 'post',
            dataType: 'json',
            success: function(e) {
                let form = `
                    <input type="hidden" name="lesson_id" value="${id}" />
                    <input type="hidden" name="form_type" value="5" />
                    <textarea id="content" name="content" class="tinymce-editor">${e.lesson_additional_content}</textarea>
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

    function generate_view_lesson(e) {
        $('.btn_content_content').html('');
        $('.btn_conf').html('');
        $('#content_lesson').html(e.lesson_additional_content != '' ? e.lesson_additional_content : 'Materi belum tersedia')
        let btn_conf = `
            <div class="d-flex justify-content-end btn_conf">
                <div class="btn_content_content">
                    <button type="button" class="btn btn-sm btn-light-dark" id="btn_update_content" data-id="${e.lesson_additional_id}"><i class="fa fa-pen"></i> Update</button>
                </div>&nbsp;
                <div class="btn_content_content">
                    <button type="button" class="btn btn-sm btn-light-danger" id="btn_delete_content" data-id="${e.lesson_additional_id}"><i class="fa fa-trash"></i> Hapus</button>
                </div>
            </div>
        `;
        $('#content_lesson').before(btn_conf)
    }

    function generate_view_video(e) {
        $('.btn_video_content').html('');
        $('.btn_conf_vid').html('');
        let id_vid = youtube_parser(e.lesson_additional_video_path);
        let vid_view = `<iframe width="100%" height="500"
            src="https://www.youtube.com/embed/${id_vid}?controls=0">
            </iframe>`;

        $('#video_lesson').html(e.lesson_additional_video_path != '' ? vid_view : 'Video belum tersedia' )
        let btn_conf = `
            <div class="d-flex justify-content-begin btn_conf_vid mb-3">
                <div class="btn_video_content">
                    <button type="button" class="btn btn-sm btn-light-dark" id="btn_update_video" data-url="${e.lesson_additional_video_path}" data-id="${e.lesson_additional_id}"><i class="fa fa-pen"></i> Update</button>
                </div>&nbsp;
                <div class="btn_video_content">
                    <button type="button" class="btn btn-sm btn-light-danger" id="btn_delete_video" data-id="${e.lesson_additional_id}"><i class="fa fa-trash"></i> Hapus</button>
                </div>
            </div>
        `;
        $('#video_lesson').before(btn_conf)
    }

    function generate_view_attachment(e) {
        $('.btn_attachment_content').html('');
        $('#attachment_lesson').html(e.lesson_additional_attachment_path)
        if (e.lesson_additional_attachment_path != '') {
            $('#attachment_lesson').before('<div class="btn_attachment_content"><button type="button" class="btn btn-sm btn-primary">Ubah Lampiran</button></div>')
        } else {
            $('#attachment_lesson').before('<div class="btn_attachment_content"><button type="button" class="btn btn-sm btn-primary">Tambah Lampiran</button></div>')
        }
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

    function view_content(id) {
        $.ajax({
            url: '<?= base_url('/teacher/lesson/additional/grab-content') ?>',
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

    function form_chapter(e, chap = null, subchap = null, id = null) {
        let form = ''
        if (e == 1) {
            form = `
                <input type="hidden" name="form_type" value="${e}" />
                <input type="hidden" name="lesson_id" value="${id}" />
                <label for="chapter" class="form-label">Judul BAB</label>
                <input type="text" class="form-control form-control-md" name="chapter" value="${chap}" />
            `;

            $('#head_content_modal').html('<h3 class="modal-title">Ubah Judul BAB</h3>')
            $('#body_content_modal').html(form)
        } else if (e == 2) {
            $.ajax({
                url: '<?= base_url('/teacher/lesson/additional/grab-chaps') ?>',
                data: {
                    id
                },
                method: 'post',
                dataType: 'json',
                success: function(res) {
                    let opt = '';
                    $.each(res, function(i, v) {
                        opt += `
                            <option value="${v.lesson_additional_chapter}" ${v.lesson_additional_chapter == chap ? 'selected' : ''}>${v.lesson_additional_chapter}</option>
                        `;
                    })

                    form = `
                        <input type="hidden" name="form_type" value="${e}" />
                        <input type="hidden" name="lesson_id" value="${id}" />
                        <label for="chapter" class="form-label">Judul BAB</label>
                        <select class="form-select form-control-md" data-control="select2" id="sel_chapter">
                        ${opt}
                        </select>
                        <br>
                        <label for="sub_chapter" class="form-label">Judul Sub BAB</label>
                        <input type="text" class="form-control form-control-md" name="sub_chapter" value="${subchap}" />
                    `;

                    $('#head_content_modal').html('<h3 class="modal-title">Ubah Judul Topik</h3>')
                    $('#body_content_modal').html(form)
                }
            })
        } else if (e == 3) {
            form = `
                <input type="hidden" name="form_type" value="${e}" />
                <input type="hidden" name="lesson_id" value="${id}" />
                <input type="hidden" name="chapter" value="${chap}" />
                <label for="sub_chapter" class="form-label">Judul Topik</label>
                <input type="text" class="form-control form-control-md" name="sub_chapter" value="" />
            `;

            $('#head_content_modal').html('<h3 class="modal-title">Tambah Topik</h3>')
            $('#body_content_modal').html(form)
        } else if (e == 4) {
            form = `
                <input type="hidden" name="form_type" value="${e}" />
                <label for="chapter" class="form-label">Judul Bab</label>
                <input type="text" class="form-control form-control-md" name="chapter" value="" />
            `;

            $('#head_content_modal').html('<h3 class="modal-title">Tambah BAB Pelajaran</h3>')
            $('#body_content_modal').html(form)
        }

        $('#modal_update_content').modal('show')

    }

    function save_content() {
        let type = $('input[name=form_type]').val();
        if (type == 1) {
            item = $('input[name=chapter]').val();
            id = $('input[name=lesson_id]').val();
            store_content(type, id, [item])
        } else if (type == 2) {
            chap = $('#sel_chapter').find(":selected").val();
            subchap = $('input[name=sub_chapter]').val();
            id = $('input[name=lesson_id]').val();
            store_content(type, id, [chap, subchap])
        } else if (type == 3) {
            id = $('input[name=lesson_id]').val();
            chap = $('input[name=chapter]').val();
            subchap = $('input[name=sub_chapter]').val();
            store_content(type, id, [chap, subchap])
        } else if (type == 4) {
            chap = $('input[name=chapter]').val();
            subj = $('input[name=subject]').val();
            grad = $('input[name=grade]').val();
            store_content(type, '', [chap, subj, grad])
        } else if (type == 5) {
            id = $('input[name=lesson_id]').val();
            topic = tinymce.activeEditor.getContent();
            store_content(type, id, [topic])
        } else if (type == 6) {
            id = $('input[name=lesson_id]').val();
            video = $('input[name=videolink]').val();
            store_content(type, id, [video])
        }

        $('#modal_update_content').modal('hide')
    }

    function store_content(type, id, val) {
        $.ajax({
            url: '<?= base_url('/teacher/lesson/additional/update-content') ?>',
            data: {
                type,
                id,
                val
            },
            method: 'post',
            dataType: 'json',
            success: function(e) {
                if (type == 5) {
                    view_content(id)
                } else if (type == 6) {
                    view_content(id)
                    $('.tab_topic').removeClass('active')
                    $('.content_topic').removeClass('active')
                    $('.content_topic').removeClass('show')

                    $('#tab_video').addClass('show')
                    $('#tab_video').addClass('active')
                    $('#tab_topic_video').addClass('active')
                } else {
                    location.reload()
                }
            }
        })


    }

    function delete_content() {
        alert('hapus data')
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

    // ClassicEditor
    // .create(document.querySelector('.richtext'))
    // .then(editor => {
    //     console.log(editor);
    // })
    // .catch(error => {
    //     console.error(error);
    // });

    jQuery('.form-check-input').on('click', function(e) {
        const id = $(this).data('id');
        const sts = $(this).val();
        e.preventDefault();

        Swal.fire({
            html: `Apakah anda ingin mengubah status?`,
            icon: "info",
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: 'Tidak',
            customClass: {
                confirmButton: "btn btn-sm btn-primary",
                cancelButton: 'btn btn-sm btn-danger'
            }
        }).then(function(confirm) {
            if (confirm.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('/teacher/lesson/additional/status') ?>',
                    data: {
                        'id': id,
                        'sts': sts
                    },
                    method: 'post',
                    dataType: 'json',
                    success: function(e) {
                        sts < 1 ? $('#chx_' + id).val(1) : $('#chx_' + id).val(0)
                        sts < 1 ? $('#chx_' + id).prop('checked', true) : $('#chx_' + id).prop('checked', false)
                        $.toast({
                            heading: 'Success',
                            text: 'Data berhasil di' + e.msg,
                            showHideTransition: 'fade',
                            position: 'top-right',
                            icon: 'success'
                        })

                    }
                })
            }
        });
    });

    $('.delete').on('click', function(e) {
        const id = $(this).data('id');
        const url = $(this).data('url');

        Swal.fire({
            html: `Apakah anda ingin menghapus data?`,
            icon: "info",
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: 'Tidak',
            customClass: {
                confirmButton: "btn btn-sm btn-primary",
                cancelButton: 'btn btn-sm btn-danger'
            }
        }).then(function(confirm) {
            if (confirm.isConfirmed) {
                $.ajax({
                    url: url + '?' + $.param({
                        id: id
                    }),
                    method: 'delete',
                    dataType: 'json',
                    success: function(e) {
                        location.reload();
                        $.toast({
                            heading: 'Success',
                            text: 'Data berhasil di' + e.msg,
                            showHideTransition: 'fade',
                            position: 'top-right',
                            icon: 'success'
                        })
                    }
                })
            }
        });
    })
</script>

<?php $this->endSection(); ?>