
$(document).ready(function () {
    if (att_id != '') {
        
        view_content_a(att_id)
        $('.tab_topic_a').removeClass('active')
        $('.content_topic_a').removeClass('active')
        $('.content_topic_a').removeClass('show')

        $('#tab_attachment_a').addClass('show')
        $('#tab_attachment_a').addClass('active')
        $('#tab_topic_a_attachment').addClass('active')
    }

    if (file_id != '') {
        view_content_a(file_id)
        $('#kt_accordion_2_item_1_a').removeClass('show')
        $('#kt_accordion_2_item_2_a').addClass('show')
    }
})

jQuery('.input_share_a').on('click', function (e) {
    const chks = $(this).val();
    if (chks == 4) {
        $('#multiple-select-field-a').removeAttr('disabled')
    } else {
        $('#multiple-select-field-a').attr('data-placeholder', 'Pilih Guru').attr('disabled', true)
        $('#select2-multiple-select-field-a-container').html('')
    }
})




function close_modal_content_a() {
    $('#modal_update_content_a').modal('hide')
    $('#body_content_modal_a').html('')

}

function share_topic_a(id, chap, subchap) {
    $('#shared_title_a').html(`Bagikan BAB ${chap} Topik ${subchap}`)
    $('input[name=less_id]').val(id);
    $('#modal_share_a').modal('show')
}

function act_share_a() {
    let val = $('.input_share_a:checked').val()
    let thc = $('#multiple-select-field-a').val()
    let idd = $('input[name=less_id]').val()
    $('#modal_share_a').modal('hide')
    $.ajax({
        url: base_url + '/teacher/lesson/additional/share-topic',
        data: { idd, val, thc },
        method: 'post',
        dataType: 'json',
        success: function (e) {
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

$('#multiple-select-field-a').select2({
    theme: "bootstrap-5",
    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
    placeholder: $(this).data('placeholder'),
    closeOnSelect: false,
});

$(document.body).on('click', '#btn_update_content_file', function () {
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
    $('#modal_upload_content_a').modal('show')
    $('#submit_upload').attr('disabled', 'disabled')
})

$(document.body).on('click', '#btn_update_content', function () {
    $('#body_content_modal_a').html('')
    let id = $('#btn_update_content').data('id');
    $.ajax({
        url: base_url + '/teacher/lesson/additional/grab-topic-content',
        data: {
            id
        },
        method: 'post',
        dataType: 'json',
        success: function (e) {
            let form = `
                    <input type="hidden" name="lesson_id" value="${id}" />
                    <input type="hidden" name="form_type" value="5" />
                    <textarea id="content" name="content" class="tinymce-editor">${e.lesson_additional_content}</textarea>
                `;

            $('#body_content_modal_a').html(form)
            $('#head_content_modal').html('<h3 class="modal-title">Update Materi Pembelajaran</h3>')
            $('#modal_update_content_a').modal('show')
            conf_tinymce()
        }
    })

})

$(document.body).on('click', '#btn_update_video', function () {
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

    $('#body_content_modal_a').html(form)
    $('#head_content_modal').html('<h3 class="modal-title">Update Video Pembelajaran</h3>')
    $('#modal_update_content_a').modal('show')
})

$(document.body).on('input', 'input[name=videolink]', function () {
    let v_id = youtube_parser($(this).val());
    let view_vid = `
            <iframe width="620" height="315"
            src="https://www.youtube.com/embed/${v_id}?controls=0">
            </iframe> 
        `;

    $('#preview_video').html(view_vid)
})

$(document.body).on('click', '#btn_update_attach', function () {
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
    $('#modal_upload_content_a').modal('show')
})

const dt = new DataTransfer(); // Permet de manipuler les fichiers de l'input file
const sizes = {}
$(document.body).on('change', '#attachment', function (e) {
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

    config_size_a(1)

    // Ajout des fichiers dans l'objet DataTransfer
    for (let file of this.files) {
        dt.items.add(file);
    }
    // Mise à jour des fichiers de l'input file après ajout
    this.files = dt.files;

    // EventListener pour le bouton de suppression créé
    $('span.file-delete').click(function () {
        let name = $(this).next('span.name').text();
        // Supprimer l'affichage du nom de fichier
        $(this).parent().remove();
        for (let i = 0; i < dt.items.length; i++) {
            // Correspondance du fichier et du nom
            if (name === dt.items[i].getAsFile().name) {
                config_size_a(dt.files[i].size)
                // Suppression du fichier dans l'objet DataTransfer
                dt.items.remove(i);
                continue;
            }
        }
        // Mise à jour des fichiers de l'input file après suppression
        document.getElementById('attachment').files = dt.files;
    });
});

function config_size_a(e) {
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

function generate_view_lesson_a(e) {
    $('.btn_content_content').html('');
    $('.btn_conf_topic').html('');

    let file_path = base_url + '/lesson_file'

    let butn = `
            <div class="accordion accordion-icon-toggle" id="kt_accordion_2">
                <div class="mt-5">
                    <div class="bg-secondary accordion-header d-flex p-1" data-bs-toggle="collapse" data-bs-target="#kt_accordion_2_item_1_a" style="border-radius: 5px;">
                        <span class="accordion-icon">
                            <i class="ki-duotone ki-arrow-right fs-4"><span class="path1"></span><span class="path2"></span></i>
                        </span>
                        <span class="px-2">Konten Teks</span>
                    </div>

                    <div id="kt_accordion_2_item_1_a" class="fs-6 collapse show m-5" data-bs-parent="#kt_accordion_2" style="max-height: 500px; overflow-y: scroll;">
                        <div class="d-flex justify-content-end btn_conf_topic">
                            <div class="btn_content_content">
                                <button type="button" class="btn btn-sm btn-light-dark" id="btn_update_content" data-id="${e.lesson_additional_id}"><i class="fa fa-pen"></i> Update</button>
                            </div>&nbsp;
                            <div class="btn_content_content">
                                <button type="button" class="btn btn-sm btn-light-danger" onclick="remove_content_a(${e.lesson_additional_id}, 5)"><i class="fa fa-trash"></i> Hapus</button>
                            </div>
                        </div>
                        ${e.lesson_additional_content != '' ? e.lesson_additional_content : 'Materi belum tersedia'}
                    </div>
                </div>

                <div class="mt-5">
                    <div class="bg-secondary accordion-header p-1 d-flex collapsed" data-bs-toggle="collapse" data-bs-target="#kt_accordion_2_item_2_a" style="border-radius: 5px;">
                        <span class="accordion-icon">
                            <i class="ki-duotone ki-arrow-right fs-4"><span class="path1"></span><span class="path2"></span></i>
                        </span>
                        <span class="px-2">Konten File</span>
                    </div>

                    <div id="kt_accordion_2_item_2_a" class="collapse fs-6 m-5" data-bs-parent="#kt_accordion_2">
                        <div class="d-flex justify-content-end btn_conf_topic mb-2">
                            <div class="btn_content_content">
                                <button type="button" class="btn btn-sm btn-light-dark" id="btn_update_content_file" data-id="${e.lesson_additional_id}"><i class="fa fa-pen"></i> Update</button>
                            </div>&nbsp;
                            <div class="btn_content_content">
                                <button type="button" class="btn btn-sm btn-light-danger" onclick="remove_content_a(${e.lesson_additional_id}, 8, '${e.lesson_additional_content_path}')"><i class="fa fa-trash"></i> Hapus</button>
                            </div>
                        </div>

                        ${e.lesson_additional_content_path != '' ? `<embed src="${file_path + e.lesson_additional_content_path}" width="100%" height="500px" />` : 'File belum tersedia'}
                    </div>
                </div>

            </div>

        `;


    $('#content_lesson').html(butn)
}

function generate_view_video_a(e) {
    $('.btn_video_content').html('');
    $('#btn_conf_vid_').html('');

    let id_vid = youtube_parser(e.lesson_additional_video_path);
    let vid_view = `
        <div class="video-container">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/${id_vid}?controls=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>`;

    $('#video_lesson').html(e.lesson_additional_video_path != '' ? vid_view : 'Video belum tersedia')

    let btn_conf = `
            <div class="d-flex justify-content-begin mb-3">
                <div class="btn_video_content">
                    <button type="button" class="btn btn-sm btn-light-dark" id="btn_update_video" data-url="${e.lesson_additional_video_path}" data-id="${e.lesson_additional_id}"><i class="fa fa-pen"></i> Update</button>
                </div>&nbsp;
                <div class="btn_video_content">
                    <button type="button" class="btn btn-sm btn-light-danger" onclick="remove_content_a(${e.lesson_additional_id}, 6)"><i class="fa fa-trash"></i> Hapus</button>
                </div>
            </div>
        `;
    $('#btn_conf_vid_').html(btn_conf)
}

function generate_view_attachment_a(e) {
    $('.btn_attach_content').html('');
    $('#btn_conf_attach_').html('');
    
    let btnn = '';
    
    if (e.attach_arr != '') {
        for (let i = 0; i < e.attach_arr.length; i++) {
            spl = e.attach_arr[i].split("^");
            
            btnn += `
                    <div class="btn-group btn-group-sm mb-1" role="group" aria-label="Button group with nested dropdown">
                    <button onclick="remove_content_a(${e.lesson_additional_id}, 7, '${e.attach_arr[i]}');" type="button" class="btn btn-primary btn-sm btn-icon"><i class="bi bi-x fs-5"></i></button>

                    <div class="btn-group" role="group">
                        <a href="${base_url + 'attachment/' + e.attach_arr[i]}" download="${spl[2]}" class="btn btn-outline btn-outline-primary btn-outline-primary btn-active-light-primary btn-sm">${spl[2]}</a>
                    </div>
                    </div>
                `;
        }
    } else {
        btnn = 'Lampiran belum tersedia';
    }

    $('#attachment_lesson').html(btnn)
    let btn_conf = `
            <div class="d-flex justify-content-begin btn_conf_attach mb-3">
                <div class="btn_attach_content">
                    <button type="button" class="btn btn-sm btn-light-dark" id="btn_update_attach" data-url="${e.attach_arr}" data-id="${e.lesson_additional_id}"><i class="fa fa-plus"></i> Tambah</button>
                </div>&nbsp;
                <div class="btn_attach_content">
                    <button type="button" class="btn btn-sm btn-light-danger" onclick="remove_content_a(${e.lesson_additional_id}, 7);" ><i class="fa fa-trash"></i> Hapus</button>
                </div>
            </div>
        `;
    $('#btn_conf_attach_').html(btn_conf)
}

function generate_view_task_a(e) {
    $('.btn_task_content').html('');
    // $('#task_lesson').html(e.lesson_additional_video_path)
    if (e.lesson_additional_tasks != '') {
        $('#task_lesson').before('<div class="btn_task_content"><button type="button" class="btn btn-sm btn-primary">Ubah Video</button></div>')
    } else {
        $('#task_lesson').before('<div class="btn_task_content"><button type="button" class="btn btn-sm btn-primary">Tambah Video</button></div>')
    }
}

function remove_content_a(id, type, file = null) {
    let msg = '';

    if (type == 1) {
        msg = 'hapus bab materi'
    } else if (type == 2) {
        msg = 'hapus topik materi'
    } else if (type == 3) { } else if (type == 4) { } else if (type == 5) {
        msg = 'topik pembelajaran'
    } else if (type == 6) {
        msg = 'video pembelajaran';
    } else if (type == 7) {
        
        if (file != null) {
            spl = file.split("^")
            msg = 'file lampiran ' + spl[2];
        } else {
            msg = 'seluruh file lampiran'
        }
    } else if (type == 8) {
        msg = 'file materi'
    }
    Swal.fire({
        html: `Apakah anda yakin menghapus ${msg}?`,
        icon: "info",
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: "Ya",
        cancelButtonText: 'Tidak',
        customClass: {
            confirmButton: "btn btn-sm btn-primary",
            cancelButton: 'btn btn-sm btn-danger'
        }
    }).then(function (confirm) {
        if (confirm.isConfirmed) {
            act_remove_a(id, type, file)
        }
    });
}

function view_content_a(id) {
    $.ajax({
        url: base_url + '/teacher/lesson/additional/grab-content',
        data: {
            id
        },
        method: 'post',
        dataType: 'json',
        success: function (e) {
            generate_view_lesson_a(e)
            generate_view_video_a(e)
            generate_view_attachment_a(e)
            generate_view_task_a(e)
        }
    })

    if ($('#content_tab').hasClass('hide')) {
        $('#content_tab').removeClass('hide')
        $('#content_value').removeClass('hide')
    }
}

function form_chapter_a(e, chap = null, subchap = null, id = null) {
    let form = ''

    if (e == 1) {
        form = `
                <input type="hidden" name="form_type" value="${e}" />
                <input type="hidden" name="lesson_id" value="${chap}" />
                <label for="chapter" class="form-label">Judul BAB</label>
                <input type="text" class="form-control form-control-md" name="chapter" value="${chap}" />
            `;

        $('#head_content_modal').html('<h3 class="modal-title">Ubah Judul BAB</h3>')
        $('#body_content_modal_a').html(form)
    } else if (e == 2) {
        $.ajax({
            url: base_url + '/teacher/lesson/additional/grab-chaps',
            data: {
                id
            },
            method: 'post',
            dataType: 'json',
            success: function (res) {
                let opt = '';
                $.each(res, function (i, v) {
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
                $('#body_content_modal_a').html(form)
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
        $('#body_content_modal_a').html(form)
    } else if (e == 4) {
        form = `
                <input type="hidden" name="form_type" value="${e}" />
                <label for="chapter" class="form-label">Judul Bab</label>
                <input type="text" class="form-control form-control-md" name="chapter" value="" />
            `;

        $('#head_content_modal').html('<h3 class="modal-title">Tambah BAB Pelajaran</h3>')
        $('#body_content_modal_a').html(form)
    }

    $('#modal_update_content_a').modal('show')

}

function save_content_a() {
    let type = $('input[name=form_type]').val();
    if (type == 1) {
        item = $('input[name=chapter]').val();
        id = $('input[name=lesson_id]').val();
        store_content_a(type, id, [item])
    } else if (type == 2) {
        chap = $('#sel_chapter').find(":selected").val();
        subchap = $('input[name=sub_chapter]').val();
        id = $('input[name=lesson_id]').val();
        store_content_a(type, id, [chap, subchap])
    } else if (type == 3) {
        id = $('input[name=lesson_id]').val();
        chap = $('input[name=chapter]').val();
        subj = $('input[name=subject]').val();
        grad = $('input[name=grade]').val();
        subchap = $('input[name=sub_chapter]').val();
        store_content_a(type, id, [chap, subj, grad, subchap])
    } else if (type == 4) {
        chap = $('input[name=chapter]').val();
        subj = $('input[name=subject]').val();
        grad = $('input[name=grade]').val();
        store_content_a(type, '', [chap, subj, grad])
    } else if (type == 5) {
        id = $('input[name=lesson_id]').val();
        topic = tinymce.activeEditor.getContent();
        store_content_a(type, id, [topic])
    } else if (type == 6) {
        id = $('input[name=lesson_id]').val();
        video = $('input[name=videolink]').val();
        store_content_a(type, id, [video])
    } else if (type == 7) {
        id = $('input[name=lesson_id]').val();
        var fd = new FormData();
        var files = $("#attachment").get(0).files;
        store_content_a(type, id, files)
    }

    $('#modal_update_content_a').modal('hide')
}

function store_content_a(type, id, val) {
    $.ajax({
        url: base_url + '/teacher/lesson/additional/update-content',
        data: {
            type,
            id,
            val
        },
        method: 'post',
        dataType: 'json',
        success: function (e) {
            if (type == 5) {
                view_content_a(id)
            } else if (type == 6) {
                view_content_a(id)
                $('.tab_topic_a').removeClass('active')
                $('.content_topic_a').removeClass('active')
                $('.content_topic_a').removeClass('show')

                $('#tab_video_a').addClass('show')
                $('#tab_video_a').addClass('active')
                $('#tab_topic_a_video').addClass('active')
            } else {
                location.reload()
            }
        }
    })
}

function download_attach(file) {
    $.ajax({
        url: base_url + '/teacher/lesson/additional/download-attach',
        data: {
            file
        },
        method: 'post',
        success: function (e) { }
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

function act_remove_a(id, type, file) {
    $.ajax({
        url: base_url + '/teacher/lesson/additional/remove-content',
        data: {
            id,
            type,
            file
        },
        method: 'post',
        dataType: 'json',
        success: function (e) {
            if (type == 5) {
                view_content_a(id)
            } else if (type == 6) {
                view_content_a(id)
                $('.tab_topic_a').removeClass('active')
                $('.content_topic_a').removeClass('active')
                $('.content_topic_a').removeClass('show')

                $('#tab_video_a').addClass('show')
                $('#tab_video_a').addClass('active')
                $('#tab_topic_a_video').addClass('active')
            } else if (type == 7) {
                view_content_a(id)
                $('.tab_topic_a').removeClass('active')
                $('.content_topic_a').removeClass('active')
                $('.content_topic_a').removeClass('show')

                $('#tab_attachment_a').addClass('show')
                $('#tab_attachment_a').addClass('active')
                $('#tab_topic_a_attachment').addClass('active')
            } else {
                location.reload()
            }
        }
    })
}

$('.delete').on('click', function (e) {
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
    }).then(function (confirm) {
        if (confirm.isConfirmed) {
            $.ajax({
                url: url + '?' + $.param({
                    id: id
                }),
                method: 'delete',
                dataType: 'json',
                success: function (e) {
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
