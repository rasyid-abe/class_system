function form_chapter_quest(e, chap = null, id = null) {
    let form = ''

    if (e == 1) {
        form = `
            <input type="hidden" name="form_type" value="${e}" />
            <label for="chapter" class="form-label">Judul Soal</label>
            <input type="text" class="form-control form-control-md" name="chapter" value="" />
        `

        $('#head_content_modal').html('<h3 class="modal-title">Tambah Judul Soal</h3>')
        $('#body_content_modal_quest').html(form)
    } else if (e == 2) {
        form = `
            <input type="hidden" name="form_type" value="${e}" />
            <input type="hidden" name="id_quest" value="${id}" />
            <label for="chapter" class="form-label">Judul Soal</label>
            <input type="text" class="form-control form-control-md" name="chapter" value="${chap}" />
        `

        $('#head_content_modal').html('<h3 class="modal-title">Ubah Judul Soal</h3>')
        $('#body_content_modal_quest').html(form)
    }

    $('#modal_update_content_quest').modal('show')
}

function close_modal_content_quest() {
    $('#modal_update_content_quest').modal('hide')
    $('#body_content_modal_quest').html('')
}

function save_content_quest() {
    let type = $('input[name=form_type]').val();
    if (type == 1) {
        chap = $('input[name=chapter]').val();
        subj = $('input[name=subject]').val();
        grad = $('input[name=grade]').val();
        store_content_quest(type, '', [chap, subj, grad])
    } else if (type == 2) {
        id = $('input[name=id_quest]').val();
        chap = $('input[name=chapter]').val();
        subj = $('input[name=subject]').val();
        grad = $('input[name=grade]').val();
        store_content_quest(type, id, [chap, subj, grad])
    }
}

function store_content_quest(type, id, val) {
    $.ajax({
        url: base_url + '/teacher/question-bank/additional/update-content',
        data: {
            type,
            id,
            val
        },
        method: 'post',
        dataType: 'json',
        success: function (e) {
            location.reload()
        }
    })
}

function remove_content_quest(id, title,  type = null, file = null) {
    let msg = '';

    if (type == 1) {
        msg = 'soal ' + title 
    } else if (type == 2) {
        msg = 'hapus topik materi'
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
            act_remove_quest(id, type, file)
        }
    });
}


function act_remove_quest(id, type = null, file = null) {
    $.ajax({
        url: base_url + '/teacher/question-bank/additional/remove-content',
        data: {
            id,
            type,
            file
        },
        method: 'post',
        dataType: 'json',
        success: function (e) {
            location.reload()
        }
    })
}

function chk_type() {
    let type = $('#quest_type').val();
    $('#question_form').removeClass('hide')
    if (type == 1) {
        $('#multiplechoice').removeClass('hide')
        $('#multiplechoice_complex').addClass('hide')
        $('#truefalse').addClass('hide')
    } else if (type == 2) {
        $('#multiplechoice_complex').removeClass('hide')
        $('#truefalse').addClass('hide')
        $('#multiplechoice').addClass('hide')
    } else if (type == 3) {
        $('#truefalse').removeClass('hide')
        $('#multiplechoice_complex').addClass('hide')
        $('#multiplechoice').addClass('hide')
    }
}


$(document).ready(function () {
    $('.repeater').repeater({
        initEmpty: true,
        defaultValues: {
            'text-input': 'foo'
        },
        show: function () {
            $(this).slideDown();
        },
        hide: function (deleteElement) {
            Swal.fire({
                html: `Apakah anda yakin menghapus form pilihan ini?`,
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
                    $(this).slideUp(deleteElement);
                }
            });
        },
        isFirstItemUndeletable: true
    })
});


