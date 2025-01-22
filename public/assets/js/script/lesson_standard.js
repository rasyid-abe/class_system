// const dt = new DataTransfer(); // Permet de manipuler les fichiers de l'input file
// const sizes = {}
// $(document.body).on('change', '#attachment', function(e) {
//     for (var i = 0; i < this.files.length; i++) {
//         let fileBloc = $('<span/>', {
//                 class: 'file-block'
//             }),
//             fileName = $('<span/>', {
//                 class: 'name',
//                 text: this.files.item(i).name
//             });
//         fileBloc.append('<span class="file-delete"><span>+</span></span>')
//             .append(fileName);
//         $("#filesList > #files-names").append(fileBloc);
//         sizes[this.files[i].size] = this.files.item(i).name
//     };

//     config_size_s(1)

//     // Ajout des fichiers dans l'objet DataTransfer
//     for (let file of this.files) {
//         dt.items.add(file);
//     }
//     // Mise à jour des fichiers de l'input file après ajout
//     this.files = dt.files;

//     // EventListener pour le bouton de suppression créé
//     $('span.file-delete').click(function() {
//         let name = $(this).next('span.name').text();
//         // Supprimer l'affichage du nom de fichier
//         $(this).parent().remove();
//         for (let i = 0; i < dt.items.length; i++) {
//             // Correspondance du fichier et du nom
//             if (name === dt.items[i].getAsFile().name) {
//                 config_size_s(dt.files[i].size)
//                 // Suppression du fichier dans l'objet DataTransfer
//                 dt.items.remove(i);
//                 continue;
//             }
//         }
//         // Mise à jour des fichiers de l'input file après suppression
//         document.getElementById('attachment').files = dt.files;
//     });
// });

$(document.body).on('click', '#download_attch', function(e) {
    e.preventDefault()
    let file = $(this).data('file')
    window.location.href = base_url + 'attachment/' + file;
})

function config_size_s(e) {
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

function generate_view_lesson_s(e) {
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
                    ${e.lesson_content != '' ? e.lesson_content : 'Materi belum tersedia' }
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
                    ${e.lesson_content_path != '' ? `<embed src="${file_path + e.lesson_content_path}" width="100%" height="500px" />` : 'File belum tersedia' }
                </div>
            </div>

        </div>

    `;


    $('#content_lesson').html(butn)
}

function generate_view_video_s(e) {
    $('.btn_video_content').html('');
    $('#btn_conf_vid_').html('');

    let id_vid = youtube_parser(e.lesson_video_path);
    let vid_view = `
    <div class="video-container">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/${id_vid}?controls=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>`;

    $('#video_lesson').html(e.lesson_video_path != '' ? vid_view : 'Video belum tersedia')
}

function generate_view_attachment_s(e) {
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

function generate_view_task_s(e, id, subj, grad) {
    let cont = ''
    let list = ''
    if (e.length == 0) {
        cont = 'Latihan tidak tersedia'
    } else {
        let ii = 1
        $.each(e, function(i, v) {
            
            if (v != 'empty') {
                if (i == 'std') {
                    for (let idx = 0; idx < v.length; idx++) {
                        list += `<a href="#" class="list-group-item list-group-item-action ltv" id="ltv${ii}" data-c="${ii}" data-type="std" data-idd="${v[idx]}">Soal ${ii}</a>`
                        ii++
                    }
                } else {
                    for (let idx = 0; idx < v.length; idx++) {
                        list += `<a href="#" class="list-group-item list-group-item-action ltv" id="ltv${ii}" data-c="${ii}" data-type="me" data-idd="${v[idx]}">Soal ${ii}</a>`
                        ii++
                    }
                }
            }
        })

        
        cont = `
            <div class="row">
                <div class="col-sm-3">
                    <ul class="list-group">${list}</ul>
                </div>
                <div class="col-sm-9">
                    <div class="task" id="preview_task_act"></div>
                </div>
            </div>
        `
    }
    
    $('#task_lesson').html(cont)
}

function view_content_s(id) {
    let l_url = level == 11 ? 'teacher' : 'student'
    $.ajax({
        url: base_url + l_url + '/lesson/standart/grab-content',
        data: {
            id
        },
        method: 'post',
        dataType: 'json',
        success: function(e) {
            generate_view_lesson_s(e)
            generate_view_video_s(e)
            generate_view_attachment_s(e)
            generate_view_task_s(e.tasks, e.lesson_id, e.lesson_subject_id, e.lesson_grade)
        }
    })

    if ($('#content_tab').hasClass('hide')) {
        $('#content_tab').removeClass('hide')
        $('#content_value').removeClass('hide')
    }
}


// function download_attach_s(file) {
//     $.ajax({
//         url: base_url + '/teacher/lesson/additional/download-attach',
//         data: {
//             file
//         },
//         method: 'post',
//         success: function(e) {}
//     })
// }

// function toggle_collapse(e) {
//     // $('.head_collapse').removeClass('collapsed')
//     // $('.body_collapse').addClass('hide')
//     if ($(`#coll_body_${e}`).hasClass('hide')) {
//         $(`#coll_body_${e}`).removeClass('hide')
//     } else {
//         $(`#coll_body_${e}`).addClass('hide')
//     }
//     if ($(`#btn_head_${e}`).hasClass('collapsed')) {
//         $(`#btn_head_${e}`).removeClass('collapsed')
//     } else {
//         $(`#btn_head_${e}`).addClass('collapsed')
//     }

// }
