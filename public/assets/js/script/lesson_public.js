$(document).ready(function(){
    let id = idc_public

    if(id != '') {
        $.ajax({
            url: base_url + '/teacher/lesson/public/get-content',
            data: {id},
            method: 'post',
            dataType: 'json',
            success: function(e) {
                generate_view_lesson_p(e)
                generate_view_video_p(e)
                generate_view_attachment_p(e)
                generate_view_task_p(e.tasks, e.lesson_additional_id, e.lesson_additional_subject_id, e.lesson_additional_grade)
            }
        })
    }
})

function generate_view_lesson_p(e) {
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

function generate_view_video_p(e) {
    $('.btn_video_content').html('');
    $('#btn_conf_vid_').html('');

    let id_vid = youtube_parser(e.lesson_additional_video_path);
    let vid_view = `
    <div class="video-container">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/${id_vid}?controls=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>`;

    $('#video_lesson').html(e.lesson_additional_video_path != '' ? vid_view : 'Video belum tersedia')
}

function generate_view_attachment_p(e) {
    $('.btn_attach_content').html('');
    $('#btn_conf_attach_').html('');

    let btnn = '';
    if (e.lesson_additional_attachment_path != '') {
        let attach = JSON.parse(e.lesson_additional_attachment_path)
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

function generate_view_task_p(e, id, subj, grad) {
    
    let btn_conf = `
            <div class="d-flex justify-content-begin mb-5">
                <div class="btn_task_content">
                    <button type="button" id="view_quest_bank" data-id="${id}" data-grade="${grad}" data-subject="${subj}" class="btn btn-sm btn-light-dark"><i class="fa fa-pen"></i> Update</button>
                </div>&nbsp;
                <div class="btn_video_content">
                    <button type="button" class="btn btn-sm btn-light-danger" onclick="remove_content_a(${id}, 9)"><i class="fa fa-trash"></i> Hapus</button>
                </div>
            </div>
        `;
    $('#btn_conf_task_').html(btn_conf)

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
    // $('.btn_task_content').html('');
}