// function generate_tree(json) {
//     $('#tree').bstreeview({
//         data: json,
//         expandIcon: 'fa fa-angle-down fa-fw',
//         collapseIcon: 'fa fa-angle-right fa-fw',
//         indent: 1.25,
//         parentsMarginLeft: '1.25rem',
//         openNodeLinkOnNewTab: true
//     });
// }

$(document).on('click', '.parent_list', function(e) {
    let idp = $(this).data('bs-target')
    
    if($(idp).hasClass('hide')) {
        $(idp).removeClass('hide')
    } else {
        $(idp).addClass('hide')
    }

    if ($(idp).children().length > 0 ) {
        if ($(this).find('i').hasClass('fa-angle-right')) {
            $(this).find('i').removeClass('fa-angle-right')
            $(this).find('i').addClass('fa-angle-down')
        } else {
            $(this).find('i').addClass('fa-angle-right')
            $(this).find('i').removeClass('fa-angle-down')

        }
    } else {
        console.log('no child');
        
    }
    
})



function close_modal_content() {
    $('#modal_update_content').modal('hide')
    $('#body_content_modal').html('')

}

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
                <span class="badge badge-${si > allow_size ? 'danger' : 'info'}">${formatBytes(si)}</span>
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
                <span class="badge badge-${si > allow_size ? 'danger' : 'info'}">${formatBytes(si)}</span>
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

    let file_path = base_url + 'lesson_file/'

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
                        ${e.lesson_content != '' ? e.lesson_content : 'Materi belum tersedia'}
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
                        ${e.lesson_school_content_path != '' ? `<embed src="${file_path + e.lesson_school_content_path}" width="100%" height="500px" />` : 'File belum tersedia'}
                    </div>
                </div>

            </div>

        `;


    $('#content_lesson').html(butn)
}

function generate_view_video(e) {
    $('.btn_video_content').html('');
    $('#btn_conf_vid_').html('');

    let id_vid = youtube_parser(e.lesson_video_path);
    let vid_view = `
        <div class="video-container">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/${id_vid}?controls=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>`;

    $('#video_lesson').html(e.lesson_video_path != '' ? vid_view : 'Video belum tersedia')

}

function generate_view_attachment(e) {
    $('.btn_attach_content').html('');
    $('#btn_conf_attach_').html('');

    let btnn = '';
    if (e.lesson_attachment_path != '') {
        let attach = JSON.parse(e.lesson_attachment_path)
        for (let i = 0; i < attach.length; i++) {
            spl = attach[i].split("^");
            btnn += `
                    <div class="btn-group m-1" role="group">
                        <a href="${base_url + 'attachment/' + attach[i]}" download="${spl[2]}" class="btn btn-outline btn-outline-primary btn-outline-primary btn-active-light-primary btn-sm">${spl[2]}</a>
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
    // $('#task_lesson').html(e.lesson_school_video_path)
    if (e.lesson_school_tasks != '') {
        $('#task_lesson').before('<div class="btn_task_content"><button type="button" class="btn btn-sm btn-primary">Ubah Video</button></div>')
    } else {
        $('#task_lesson').before('<div class="btn_task_content"><button type="button" class="btn btn-sm btn-primary">Tambah Video</button></div>')
    }
}

function view_content(id, source) {
    $.ajax({
        url: base_url + '/teacher/lesson/school/grab-content',
        data: {
            id,
            source
        },
        method: 'post',
        dataType: 'json',
        success: function (e) {
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
    const year = $('#school_active_year').data('id')

    if (e == 1) {
        form = `
                <input type="hidden" name="form_type" value="${e}" />
                <input type="hidden" name="lesson_id" value="${chap}" />
                <label for="chapter" class="form-label">Judul BAB</label>
                <input type="text" class="form-control form-control-md" name="chapter" value="${chap}" />
            `;

        $('#head_content_modal').html('<h3 class="modal-title">Ubah Judul BAB</h3>')
        $('#body_content_modal').html(form)
    } else if (e == 2) {
        $.ajax({
            url: base_url + '/teacher/lesson/school/grab-chaps',
            data: {
                id
            },
            method: 'post',
            dataType: 'json',
            success: function (res) {
                let opt = '';
                $.each(res, function (i, v) {
                    opt += `
                            <option value="${v.lesson_school_chapter}" ${v.lesson_school_chapter == chap ? 'selected' : ''}>${v.lesson_school_chapter}</option>
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
        $.ajax({
            url: base_url + '/teacher/lesson/school/grab-all-subchap',
            data: {
                id
            },
            method: 'post',
            dataType: 'json',
            success: function (res) {
                json = res
                form = `
                        <input type="hidden" name="form_type" value="${e}" />
                        <input type="hidden" name="lesson_id" value="${id}" />
                        <input type="hidden" name="chapter" value="${chap}" />
                        <div id="tree"></div>
                    `;

                $('#head_content_modal').html('<h3 class="modal-title">Pilih Topik</h3>')
                $('#body_content_modal').html(form)
                // generate_tree(res)

            },
            async: false
        })

    } else if (e == 4) {
        if (year == "") {
            Swal.fire({
                text: "Untuk menambahkan data, anda harus membuat data 'Tahun Pelajaran' terlebih dahulu. ",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        } else {
            form = `
                    <input type="hidden" name="form_type" value="${e}" />
                    <label for="chapter" class="form-label">Judul Bab</label>
                    <input type="text" class="form-control form-control-md" name="chapter" value="" />
                    <br>
                    <span class="text-primary">NOTE: Materi ini tersimpan hanya pada T.P '<?= year_active()['school_year_period'] ?>'}</span>
                `;

            $('#head_content_modal').html('<h3 class="modal-title">Tambah BAB Pelajaran</h3>')
            $('#body_content_modal').html(form)
        }
    }


    if (e < 4) {
        $('#modal_update_content').modal('show')
    } else {
        if (year != '') {
            $('#modal_update_content').modal('show')
        }
    }

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
        subj = $('input[name=subject]').val();
        grad = $('input[name=grade]').val();
        subchap = $('input[name=sub_chapter]').val();
        store_content(type, id, [chap, subj, grad, subchap])
    } else if (type == 4) {
        chap = $('input[name=chapter]').val();
        subj = $('input[name=subject]').val();
        grad = $('input[name=grade]').val();
        store_content(type, '', [chap, subj, grad])
    }

    $('#modal_update_content').modal('hide')
}

function store_content(type, id, val) {
    $.ajax({
        url: base_url + '/teacher/lesson/school/update-content',
        data: {
            type,
            id,
            val
        },
        method: 'post',
        dataType: 'json',
        success: function (e) {
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

function act_remove(id, type, file) {
    $.ajax({
        url: base_url + '/teacher/lesson/school/remove-content',
        data: {
            id,
            type,
            file
        },
        method: 'post',
        dataType: 'json',
        success: function (e) {
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
            } else if (type == 7) {
                view_content(id)
                $('.tab_topic').removeClass('active')
                $('.content_topic').removeClass('active')
                $('.content_topic').removeClass('show')

                $('#tab_attachment').addClass('show')
                $('#tab_attachment').addClass('active')
                $('#tab_topic_attachment').addClass('active')
            } else {
                location.reload()
            }
        }
    })
}