function share_task(id, title) {
  $('#shared_title').html(`Bagikan Soal ${title}`)
  $('input[name=task_id]').val(id);
  $('#modal_share_task').modal('show')
}

jQuery('.input_share_task').on('click', function (e) {
  const chks = $(this).val();
  if (chks == 4) {
      $('#shared_task_to').removeClass('hide')
  } else {
      $('#shared_task_to').addClass('hide')
  }
})

function act_share_task() {
  let val = $('.input_share_task:checked').val()
  let thc = $('#multiple-select-field-task').val()
  let idd = $('input[name=task_id]').val()

  if (val == 4 && thc.length < 1) {
    al_swal('Guru belum dipilih!', 'error')
  } else {
    $('#modal_share_task').modal('hide')
    $.ajax({
        url: base_url + '/teacher/question-bank/additional/share-task',
        data: { idd, val, thc },
        method: 'post',
        dataType: 'json',
        success: function (e) {
          al_swal('Soal berhasil di bagikan.', 'success')
        }
    })
  }

}

const toolbarOptions = [
  ["bold", "italic", "underline", "strike"], // toggled buttons
  [{ align: [] }],
  ["link", "image", "formula"],

  //   [{ header: 1 }, { header: 2 }], // custom button values
  [{ list: "ordered" }, { list: "bullet" }, { list: "check" }],
  [{ script: "sub" }, { script: "super" }], // superscript/subscript
  [{ indent: "-1" }, { indent: "+1" }], // outdent/indent
  //   [{ direction: "rtl" }], // text direction

  //   [{ size: ["small", false, "large", "huge"] }], // custom dropdown
  [{ header: [1, 2, 3, 4, 5, 6, false] }],

  [{ color: [] }, { background: [] }], // dropdown with defaults from theme
  //   [{ font: [] }],
  ["clean", "code-block"], // remove formatting button
];

function view_question(id) {
  $('#quest_cont').removeClass('hide')
  $.ajax({
    url: base_url + "/teacher/question-bank/additional/get-question",
    data: {id,},
    method: "post",
    dataType: "json",
    success: function (e) {
      generate_task(e)
      generate_hint(e)
      generate_explain(e)
    },
  });
}

function generate_task(e) {
  let opt = ``
  let num = 1
  $.each(e.option, function(i,v) {
    opt += `
        <div class="col-sm-6">
            <div class="alert alert-dismissible bg-light-${i == 'right' ? 'success border border-success' : 'secondary border border-dark'} d-flex flex-column flex-sm-row p-5 mb-5">
                <div class="d-flex flex-column pe-0 pe-sm-10">
                    <h4 class="fw-semibold">Pilihan Jawaban ${num}</h4>
                    ${v}
                </div>
            </div>
        </div>
    `
    num++
  })

  let html = `
     <div class="card">
        <div class="card-header p-5 d-flex justify-content-end">
            <button type="button" class="btn btn-sm btn-success mx-2" onclick="show_form_edit(-15, ${e.id}, ${e.subj}, ${e.grad}, ${e.parent})"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-copy" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"/>
            </svg> Salin</button>
            <button type="button" class="btn btn-sm btn-info" onclick="show_form_edit(-14, ${e.id}, ${e.subj}, ${e.grad}, ${e.parent})"><i class="bi bi-arrows-move"></i> Pindah</button>
            <button type="button" class="btn btn-sm btn-warning mx-2" onclick="show_form_edit(-11, ${e.id})"><i class="bi bi-pencil fs-5"></i> Ubah</button>
            <button type="button" class="btn btn-sm btn-danger" onclick="remove_content_quest(${e.id}, '${e.tilte}', 2)"><i class="bi bi-trash fs-5"></i> Hapus</button>
        </div>
        <div class="card-body">
            <div class="alert alert-dismissible bg-light-primary border border-primary d-flex flex-column flex-sm-row p-5 mb-5">
                <div class="d-flex flex-column pe-0 pe-sm-10">
                    <h4 class="fw-semibold">Pertanyaan</h4>
                    ${e.question}
                </div>
            </div>
            <div class="row">
                ${opt}
            </div>
        </div>
    </div>
  `
  $('#tab_task').html(html)
}

function generate_hint(e) {
  let html = `
  <div class="card">
        <div class="card-header p-5 d-flex justify-content-end">
            <button type="button" class="btn btn-sm btn-warning" onclick="show_form_edit(-12, ${e.id}, ${e.subj}, ${e.grad})"><i class="bi bi-pencil fs-5"></i> Ubah</button>
            <button type="button" class="btn btn-sm btn-danger mx-5" onclick="remove_content_quest(${e.id}, '${e.title}', 3)"><i class="bi bi-trash fs-5"></i> Hapus</button>
        </div>
        <div class="card-body">
          <div class="alert alert-dismissible bg-light-info border border-info d-flex flex-column flex-sm-row p-5 mb-5">
              <div class="d-flex flex-column pe-0 pe-sm-10">
                  <h4 class="fw-semibold">Petunjuk Penyelesaian</h4>
                  ${e.hint == '<p><br></p>' ? '<p>Tidak ada data</p>' : e.hint}
              </div>
          </div>
        </div>
    </div>
  `

  $('#tab_hint').html(html)
}

function generate_explain(e) {
  let html = `
  <div class="card">
        <div class="card-header p-5 d-flex justify-content-end">
            <button type="button" class="btn btn-sm btn-warning" onclick="show_form_edit(-13, ${e.id}, ${e.subj}, ${e.grad})"><i class="bi bi-pencil fs-5"></i> Ubah</button>
            <button type="button" class="btn btn-sm btn-danger mx-5" onclick="remove_content_quest(${e.id}, '${e.title}', 4)"><i class="bi bi-trash fs-5"></i> Hapus</button>
        </div>
        <div class="card-body">
    <div class="alert alert-dismissible bg-light-info border border-info d-flex flex-column flex-sm-row p-5 mb-5">
        <div class="d-flex flex-column pe-0 pe-sm-10">
            <h4 class="fw-semibold">Penjelasan Penyelesaian</h4>
            ${e.explain == '<p><br></p>' ? '<p>Tidak ada data</p>' : e.explain}
        </div>
    </div>
    </div>
    </div>
  `

  $('#tab_explain').html(html)
}

function show_form_edit(type, id, subj = null, grad = null, parent = null) {
  if (type == -14 || type == -15) {
    $.ajax({
      url: base_url + "/teacher/question-bank/additional/get-title-list",
      data: {subj, grad, parent},
      method: "post",
      dataType: "json",
      success: function (e) {
        console.log(e);
          let form = ''
          $.each(e, function(i,v) {
            form += `
                <div data-kt-buttons="true">
                    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-6 mb-5">
                        <div class="d-flex align-items-center me-2">
                            <div class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                <input class="form-check-input move_task" type="radio" name="move_task" value="${v.question_bank_id}"/>
                            </div>
  
                            <div class="flex-grow-1">
                                <div class="fw-semibold">
                                    ${v.question_bank_title}
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
            `
          })

          $("#head_content_modal_std").html(`
              <input type="hidden" name="form_type" value="${type}" />
              <input type="hidden" name="quest_id" value="${id}" />
              <h3 class="modal-title">${type == -14 ? 'Pindahkan' : 'Salin'} Soal Ke</h3>
          `);
          $("#body_content_modal_quest").html(form);

          $("#modal_update_content_quest").modal("show");
      },
    });
  } else {
    $.ajax({
      url: base_url + "/teacher/question-bank/additional/get-question",
      data: {id},
      method: "post",
      dataType: "json",
      success: function (e) {
        show_edit_task(e, type, id)
      },
    });
  }
}

function show_edit_task(e, type, id) {
  if (type == -11) {
    $('#repeater_edit').removeClass("hide")
    let opt = `<option value="0">Pilih Tipe Soal</option>`
    $.each(e.list_quest, function(i,v) {
      opt += `<option value="${i}" ${i == e.type ? 'selected' : ''}>${v}</option>`
    })
  
    let choose = ''
    let iddx = 0
    $.each(e.option, function(i,v) {
      choose += `
        <div class="mt-5" id="opt_mc_rem${iddx}">
            <div class="position-relative">
                <div class="d-flex justify-content-left" style="min-width: 200px; padding-left:8px">
                    <div class="form-check form-check-custom form-switch form-check-success form-check-solid mb-2" style="margin-right: 4px">
                        <input class="form-check-input mc_option_edit ${i == 'right' ? 'checked_mc' : ''}" type="radio" value="" ${i == 'right' ? 'checked' : ''} />
                        <label class="form-check-label">
                            Jawaban Benar
                        </label>
                    </div>
                    <button onclick="rem_elem_id('opt_mc_rem${iddx}')" type="button" class="m-2 btn btn-danger btn-sm btn-icon"><i class="bi bi-trash fs-2"></i></button>
                </div>
                <div id="edit_optmc${iddx}" name="optmc${iddx}" class="optmc_n_edit"></div>
            </div>
        </div>
      `
      iddx++
    })
  
    let task = `
        <input type="hidden" name="id_quest_edit" value="${id}" />
        <input type="hidden" name="form_type" value="${type}" />
        <div class="card" id="content_value">
            <div class="px-5">
                <div class="mb-3 row">
                    <label for="poin" class="col-sm-1 col-form-label">Poin</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="poin_edit" id="poin" min="1" value="${e.poin}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="staticEmail" class="col-sm-1 col-form-label">Tipe</label>
                    <div class="col-sm-6">
                        <select name="quest_type" id="quest_type_edit" class="form-control" onchange="chk_type()">
                            ${opt}
                        </select>
                    </div>
                </div>
                <div class="mt-10 mb-5" id="question_form">
                    <label for="exampleFormControlInput1" class="form-label">Pertanyaan</label>
                    <div id="task_quest_edit"></div>
                </div>
  
                <div class="" id="multiplechoice">
                    <label for="exampleFormControlInput1" class="form-label">Pilihan</label>
                    ${choose}
                </div>
            </div>
        </div>
    `
    $('#task_edit').html(task)
    $('#modal_update_task').modal('show')
  
    var task_quest_edit = new Quill("#task_quest_edit", {
      modules: {
        toolbar: toolbarOptions,
      },
      theme: "snow", // or 'bubble'
    });
    $('#task_quest_edit > .ql-editor').html(e.question)
  
    let iddy = 0
    $.each(e.option, function(i,v) {
      var edit_optmc0 = new Quill("#edit_optmc" + iddy, {
        modules: {
          toolbar: toolbarOptions,
        },
        theme: "snow", // or 'bubble'
      });
      $('#edit_optmc' + iddy + ' > .ql-editor').html(v)
  
      iddy++
    })
  } else if (type == -12) {
    $('#repeater_edit').addClass("hide")
    let hint = `
    <input type="hidden" name="id_quest_edit" value="${id}" />
    <input type="hidden" name="form_type" value="${type}" />
        <div class="card" id="content_value">
            <div id="hint_quest_edit"></div>
        </div>
    </div>
    `
    $('#task_edit').html(hint)
    $('#modal_update_task').modal('show')

    var hint_quest_edit = new Quill("#hint_quest_edit", {
      modules: {
        toolbar: toolbarOptions,
      },
      theme: "snow", // or 'bubble'
    });
    $('#hint_quest_edit > .ql-editor').html(e.hint)
  } else if (type == -13) {
    $('#repeater_edit').addClass("hide")
    let hint = `
    <input type="hidden" name="id_quest_edit" value="${id}" />
    <input type="hidden" name="form_type" value="${type}" />
        <div class="card" id="content_value">
            <div id="explain_quest_edit"></div>
        </div>
    </div>
    `
    $('#task_edit').html(hint)
    $('#modal_update_task').modal('show')

    var explain_quest_edit = new Quill("#explain_quest_edit", {
      modules: {
        toolbar: toolbarOptions,
      },
      theme: "snow", // or 'bubble'
    });
    $('#explain_quest_edit > .ql-editor').html(e.explain)
  }

}

function rem_elem_id(id) {
  Swal.fire({
    html: `Apakah anda yakin menghapus form pilihan ini?`,
    icon: "info",
    buttonsStyling: false,
    showCancelButton: true,
    confirmButtonText: "Ya",
    cancelButtonText: "Tidak",
    customClass: {
      confirmButton: "btn btn-sm btn-primary",
      cancelButton: "btn btn-sm btn-danger",
    },
  }).then(function (confirm) {
    if (confirm.isConfirmed) {
      $('#' + id).remove()
    }
  });
  
}

function form_chapter_quest(e, chap = null, id = null) {
  
  if (e == -1) {
    $("#head_content_modal").html(`
      <input type="hidden" name="form_type" value="${e}" />
      <input type="hidden" name="id_quest" value="${id}" />
      <h3 class="modal-title">Tambah Soal ${chap}</h3>
    `);
    $("#modal_update_question_quest").modal("show");
  } else {
    let form = "";

    if (e == 1) {
      form = `
              <input type="hidden" name="form_type" value="${e}" />
              <label for="chapter" class="form-label">Judul Soal</label>
              <input type="text" class="form-control form-control-md" name="chapter" value="" />
          `;

      $("#head_content_modal_std").html(
        '<h3 class="modal-title">Tambah Judul Soal</h3>'
      );
      $("#body_content_modal_quest").html(form);
    } else if (e == 2) {
      form = `
              <input type="hidden" name="form_type" value="${e}" />
              <input type="hidden" name="id_quest" value="${id}" />
              <label for="chapter" class="form-label">Judul Soal</label>
              <input type="text" class="form-control form-control-md" name="chapter" value="${chap}" />
          `;

      $("#head_content_modal_std").html(
        '<h3 class="modal-title">Ubah Judul Soal</h3>'
      );
      $("#body_content_modal_quest").html(form);
    }

    $("#modal_update_content_quest").modal("show");
  }
}

function close_modal_content_quest() {
  $("#modal_update_content_quest").modal("hide");
  $("#body_content_modal_quest").html("");
  $("#modal_update_question_quest").modal("hide");
  $("#modal_update_task").modal("hide");
}

function save_content_quest() {
  let type = $("input[name=form_type]").val();
  console.log(type);
  
  if (type == 1) {
    chap = $("input[name=chapter]").val();
    subj = $("input[name=subject]").val();
    grad = $("input[name=grade]").val();
    store_content_quest(type, "", [chap, subj, grad]);
  } else if (type == 2) {
    id = $("input[name=id_quest]").val();
    chap = $("input[name=chapter]").val();
    subj = $("input[name=subject]").val();
    grad = $("input[name=grade]").val();
    store_content_quest(type, id, [chap, subj, grad]);
  } else if (type == -1) {
    pre_question(type);
  } else if (type == -11) {
    pre_question_edit(type)
  } else if (type == -12) {
    id = $("input[name=id_quest_edit]").val();
    hint = $("#hint_quest_edit > .ql-editor").html();
    store_content_quest(type, id, [hint]);
  } else if (type == -13) {
    id = $("input[name=id_quest_edit]").val();
    explain = $("#explain_quest_edit > .ql-editor").html();
    store_content_quest(type, id, [explain]);
  } else if (type == -14 || type == -15) {
    id = $("input[name=quest_id]").val();
    new_id = $('input[name="move_task"]:checked').val();
    store_content_quest(type, id, [new_id]);
  }
}

function pre_question(type) {
  idx = 0;
  ii = 0;
  chk = [];
  $(".mc_option").each(function () {
    if ($(this).hasClass("checked_mc")) {
      idx = ii;
      chk.push(true);
    } else {
      chk.push(false);
    }
    ii++;
  });

  option = [];
  $(".optmc_n > .ql-editor").each(function () {
    if ($(this).html() != '<p><br></p>') {
      option.push($(this).html()); //or $(this).text();
    }
  });

  id = $("input[name=id_quest]").val();
  subj = $("input[name=subject]").val();
  grad = $("input[name=grade]").val();
  poin = $("input[name=poin]").val();
  quest_type = $("#quest_type").find(":selected").val();
  question = $("#quilleditor_question > .ql-editor").html();
  answer = option[idx];
  hint = $("#hint_quest > .ql-editor").html();
  explain = $("#explain_quest > .ql-editor").html();
  
  if (quest_type != 0) {
    if (question != '<p><br></p>') {
      if (option.length > 0) {
        if (answer != undefined) {
          if (chk.includes(true)) {
            store_content_quest(type, id, [
              subj,
              grad,
              quest_type,
              question,
              option,
              answer,
              poin,
              hint,
              explain,
            ]);
          } else {
            al_swal("Jawaban benar belum dipilih!", "error")
          }
        } else {
          al_swal("Pilihan jawaban benar tidak sesuai!", "error")
        }
      } else {
        al_swal("Kolom pilihan jawaban harus diisi!", "error")
      }
    } else {
      al_swal("Kolom pertanyaan harus diisi!", "error")
    }
  } else {
    al_swal("Tipe soal harus dipilih!", "error")
  }
}

function pre_question_edit(type) {
  idx = 0;
  ii = 0;
  chk = [];
  $(".mc_option_edit").each(function () {
    if ($(this).hasClass("checked_mc")) {
      idx = ii;
      chk.push(true);
    } else {
      chk.push(false);
    }
    ii++;
  });

  option = [];
  $(".optmc_n_edit > .ql-editor").each(function () {
    if ($(this).html() != '<p><br></p>') {
      option.push($(this).html()); //or $(this).text();
    }
  });

  id = $("input[name=id_quest_edit]").val();
  subj = $("input[name=subject]").val();
  grad = $("input[name=grade]").val();
  poin = $("input[name=poin_edit]").val();
  quest_type = $("#quest_type_edit").find(":selected").val();
  question = $("#task_quest_edit > .ql-editor").html();
  answer = option[idx];
  
  if (quest_type != 0) {
    if (question != '<p><br></p>') {
      if (option.length > 0) {
        if (answer != undefined) {
          if (chk.includes(true)) {
            store_content_quest(type, id, [
              subj,
              grad,
              quest_type,
              question,
              option,
              answer,
              poin
            ]);
          } else {
            al_swal("Jawaban benar belum dipilih!", "error")
          }
        } else {
          al_swal("Pilihan jawaban benar tidak sesuai!", "error")
        }
      } else {
        al_swal("Kolom pilihan jawaban harus diisi!", "error")
      }
    } else {
      al_swal("Kolom pertanyaan harus diisi!", "error")
    }
  } else {
    al_swal("Tipe soal harus dipilih!", "error")
  }
}

$(document).on("click", ".mc_option_edit", function () {
  $(".mc_option_edit").each(function () {
    if ($(this).hasClass("checked_mc")) {
      $(this).removeClass("checked_mc");
      $(this).prop("checked", false);
    }
  });

  $(this).addClass("checked_mc");

  $(".mc_option_edit").each(function () {
    if ($(this).hasClass("checked_mc")) {
      $(this).prop("checked", true);
    }
  });
});

$(document).on("click", ".mc_option", function () {
  $(".mc_option").each(function () {
    if ($(this).hasClass("checked_mc")) {
      $(this).removeClass("checked_mc");
      $(this).prop("checked", false);
    }
  });

  $(this).addClass("checked_mc");

  $(".mc_option").each(function () {
    if ($(this).hasClass("checked_mc")) {
      $(this).prop("checked", true);
    }
  });
});

$(document).on("click", ".checked_mc", function () {
  $(this).removeClass("checked_mc");
  $(this).prop("checked", false);
  return false;
});

function store_content_quest(type, id, val) {
  $.ajax({
    url: base_url + "/teacher/question-bank/additional/update-content",
    data: {
      type,
      id,
      val,
    },
    method: "post",
    dataType: "json",
    success: function (e) {
      location.reload();
    },
  });
}

function remove_content_quest(id, title, type = null, file = null) {
  let msg = "";

  if (type == 1) {
    msg = "soal " + title;
  } else if (type == 2) {
    msg = "soal ini";
  } else if (type == 3) {
    msg = "petunjuk soal ini";
  } else if (type == 4) {
    msg = "penjelasan soal ini";
  }
  
  Swal.fire({
    html: `Apakah anda yakin menghapus ${msg}?`,
    icon: "info",
    buttonsStyling: false,
    showCancelButton: true,
    confirmButtonText: "Ya",
    cancelButtonText: "Tidak",
    customClass: {
      confirmButton: "btn btn-sm btn-primary",
      cancelButton: "btn btn-sm btn-danger",
    },
  }).then(function (confirm) {
    if (confirm.isConfirmed) {
      act_remove_quest(id, type, file);
    }
  });
}

function act_remove_quest(id, type = null, file = null) {
  $.ajax({
    url: base_url + "/teacher/question-bank/additional/remove-content",
    data: {
      id,
      type,
      file,
    },
    method: "post",
    dataType: "json",
    success: function (e) {
      location.reload();
    },
  });
}

function chk_type() {
  let type = $("#quest_type").val();
  $("#question_form").removeClass("hide");
  if (type == 1) {
    $("#multiplechoice").removeClass("hide");
    $("#multiplechoice_complex").addClass("hide");
    $("#truefalse").addClass("hide");
  } else if (type == 2) {
    $("#multiplechoice_complex").removeClass("hide");
    $("#truefalse").addClass("hide");
    $("#multiplechoice").addClass("hide");
  } else if (type == 3) {
    $("#truefalse").removeClass("hide");
    $("#multiplechoice_complex").addClass("hide");
    $("#multiplechoice").addClass("hide");
  }
}

function tog_form(id) {
  $("#" + id).toggleClass("hide");
}

function generate_richtext() {
  var quilleditor_question = new Quill("#quilleditor_question", {
    modules: {
      toolbar: toolbarOptions,
    },
    theme: "snow", // or 'bubble'
  });
  var quilleditor_optmc_edit = new Quill("#quilleditor_optmc_edit", {
    modules: {
      toolbar: toolbarOptions,
    },
    theme: "snow", // or 'bubble'
  });
  var quilleditor_optmc_n = new Quill("#quilleditor_optmc_n", {
    modules: {
      toolbar: toolbarOptions,
    },
    theme: "snow", // or 'bubble'
  });
  var quilleditor_optmc0 = new Quill("#quilleditor_optmc0", {
    modules: {
      toolbar: toolbarOptions,
    },
    theme: "snow", // or 'bubble'
  });
  var quilleditor_optmc1 = new Quill("#quilleditor_optmc1", {
    modules: {
      toolbar: toolbarOptions,
    },
    theme: "snow", // or 'bubble'
  });
  var quilleditor_optmc2 = new Quill("#quilleditor_optmc2", {
    modules: {
      toolbar: toolbarOptions,
    },
    theme: "snow", // or 'bubble'
  });
  var quilleditor_optmc3 = new Quill("#quilleditor_optmc3", {
    modules: {
      toolbar: toolbarOptions,
    },
    theme: "snow", // or 'bubble'
  });
  var quilleditor_optmc4 = new Quill("#quilleditor_optmc4", {
    modules: {
      toolbar: toolbarOptions,
    },
    theme: "snow", // or 'bubble'
  });
  var explain_quest = new Quill("#explain_quest", {
    modules: {
      toolbar: toolbarOptions,
    },
    theme: "snow", // or 'bubble'
  });
  var hint_quest = new Quill("#hint_quest", {
    modules: {
      toolbar: toolbarOptions,
    },
    theme: "snow", // or 'bubble'
  });
  var quilleditor_optmcx0 = new Quill("#quilleditor_optmcx0", {
    modules: {
      toolbar: toolbarOptions,
    },
    theme: "snow", // or 'bubble'
  });
  var quilleditor_optmcx1 = new Quill("#quilleditor_optmcx1", {
    modules: {
      toolbar: toolbarOptions,
    },
    theme: "snow", // or 'bubble'
  });
  var quilleditor_optmcx2 = new Quill("#quilleditor_optmcx2", {
    modules: {
      toolbar: toolbarOptions,
    },
    theme: "snow", // or 'bubble'
  });
  var quilleditor_optmcx3 = new Quill("#quilleditor_optmcx3", {
    modules: {
      toolbar: toolbarOptions,
    },
    theme: "snow", // or 'bubble'
  });
  var quilleditor_optmcx_n = new Quill("#quilleditor_optmcx_n", {
    modules: {
      toolbar: toolbarOptions,
    },
    theme: "snow", // or 'bubble'
  });
}

function act_repeater() {
  generate_richtext();
  $(".repeater").repeater({
    initEmpty: true,
    defaultValues: {
      "text-input": "foo",
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
        cancelButtonText: "Tidak",
        customClass: {
          confirmButton: "btn btn-sm btn-primary",
          cancelButton: "btn btn-sm btn-danger",
        },
      }).then(function (confirm) {
        if (confirm.isConfirmed) {
          $(this).slideUp(deleteElement);
        }
      });
    },
    isFirstItemUndeletable: true,
  });
}

$(document).ready(function () {
  let url = window.location.href
  if (url.includes("question-bank/additional/view-content")){
    act_repeater()
  }
});
