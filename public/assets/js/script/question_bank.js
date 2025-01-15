function share_task(id, title) {
  $("#shared_title").html(`Bagikan Soal ${title}`);
  $("input[name=task_id]").val(id);
  $("#modal_share_task").modal("show");
}

jQuery(".input_share_task").on("click", function (e) {
  const chks = $(this).val();
  if (chks == 4) {
    $("#shared_task_to").removeClass("hide");
  } else {
    $("#shared_task_to").addClass("hide");
  }
});

function close_share_task_modal() {
  $("#multiple-select-field-task").val(null).trigger("change");
  $(".input_share_task").prop("checked", false);
  $("#shared_task_to").addClass("hide");
  $("#select_tk_alert").addClass("hide");
  let btn_footer = `
      <button type="button" class="btn btn-sm btn-light-danger" onclick="close_share_task_modal()">Tutup</button>
      <button type="button" class="btn btn-sm btn-primary" onclick="act_share_task();">Kirim</button>
  `;
  $("#btn-footer").html(btn_footer);
  $("#modal_share_task").modal("hide");
}

function view_shared_quest(id) {
  view_question(id, "shr");
}

function act_share_task(clear = null) {
  if (clear) {
    let val = 0;
    let thc = null;
    let idd = $("input[name=task_id]").val();

    $("#modal_share_task").modal("hide");
    $.ajax({
      url: base_url + "/teacher/question-bank/additional/share-task",
      data: { idd, val, thc },
      method: "post",
      dataType: "json",
      success: function (e) {
        al_swal("Pembatalan berhasil.", "success");
      },
    });
  } else {
    let val = $(".input_share_task:checked").val();
    let thc = $("#multiple-select-field-task").val();
    let idd = $("input[name=task_id]").val();

    if (val != undefined) {
      if (val == 4 && thc.length < 1) {
        al_swal("Guru belum dipilih!", "error");
      } else {
        $("#modal_share_task").modal("hide");
        $.ajax({
          url: base_url + "/teacher/question-bank/additional/share-task",
          data: { idd, val, thc },
          method: "post",
          dataType: "json",
          success: function (e) {
            al_swal("Soal berhasil di bagikan.", "success");
          },
        });
      }
    } else {
      $("#msgshareless").html(
        '<h6 class="mb-1 text-danger">Tujuan pembagian bank soal belum dipilih!</h6>'
      );
      $("#select_tk_alert").removeClass("hide");
    }
  }
}

function modal_shared_task_view(e) {
  if (e.question_bank_shared_type == 1) {
    $("#opt1").prop("checked", true);
  } else if (e.question_bank_shared_type == 2) {
    $("#opt2").prop("checked", true);
  } else if (e.question_bank_shared_type == 3) {
    $("#opt3").prop("checked", true);
  } else if (e.question_bank_shared_type == 4) {
    $("#opt4").prop("checked", true);
    let selected_group = [];
    $.each(JSON.parse(e.question_bank_shared_to), function (i, v) {
      selected_group.push(v);
    });
    $("#multiple-select-field-task").val(selected_group).trigger("change");
    $("#shared_task_to").removeClass("hide");
  }

  $("#shared_title").html(`Informasi Bank Soal Dibagikan`);
  $("input[name=task_id]").val(e.question_bank_id);

  let btn_footer = `
    <button type="button" class="btn btn-sm btn-light-danger" onclick="close_share_task_modal()">Tutup</button>
    <button type="button" class="btn btn-sm btn-light-warning" onclick="act_share_task(1)">Batalkan Bagi</button>
    <button type="button" class="btn btn-sm btn-primary" onclick="act_share_task();">Kirim</button>
  `;
  $("#btn-footer").html(btn_footer);

  $("#modal_share_task").modal("show");
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

function view_question(id, type = null) {
  $("#quest_cont").removeClass("hide");
  $.ajax({
    url: base_url + "/teacher/question-bank/additional/get-question",
    data: { id, type },
    method: "post",
    dataType: "json",
    success: function (e) {
      console.log(e);
      
      if (type == "shr") {
        modal_shared_task_view(e);
      } else {
        generate_task(e);
        generate_hint(e);
        generate_explain(e);
      }
    },
  });
}

function view_question_std(id) {
  $("#quest_cont").removeClass("hide");
  $.ajax({
    url: base_url + "/teacher/question-bank/standart/get-question",
    data: { id },
    method: "post",
    dataType: "json",
    success: function (e) {
      generate_task(e);
      generate_hint(e);
      generate_explain(e);
    },
  });
}

function generate_task(e) {
  console.log(e);
  
  let opt = ``;
  let num = 1;
  $.each(e.option, function (i, v) {
    let val = "";
    if (e.type == 3) {
      val = v == 1 ? "Benar" : "Salah";
    } else {
      val = v;
    }
    opt += `
        <div class="col-sm-6">
            <div class="alert alert-dismissible bg-light-${
              e.keys.includes(i)
                ? "success border border-success"
                : "secondary border border-dark"
            } d-flex flex-column flex-sm-row p-5 mb-5">
                <div class="d-flex flex-column pe-0 pe-sm-10">
                    <h4 class="fw-semibold">Pilihan Jawaban ${num}</h4>
                    ${val}
                </div>
            </div>
        </div>
    `;
    num++;
  });

  let btnn = "";
  if (url.includes("question-bank/additional")) {
    btnn = `
      <button type="button" class="btn btn-sm btn-success mx-2" onclick="show_form_edit(-15, ${e.id}, ${e.subj}, ${e.grad}, ${e.parent})"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-copy" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"/>
      </svg> Salin</button>
      <button type="button" class="btn btn-sm btn-info" onclick="show_form_edit(-14, ${e.id}, ${e.subj}, ${e.grad}, ${e.parent})"><i class="bi bi-arrows-move"></i> Pindah</button>
      <button type="button" class="btn btn-sm btn-warning mx-2" onclick="show_form_edit(-11, ${e.id})"><i class="bi bi-pencil fs-5"></i> Ubah</button>
      <button type="button" class="btn btn-sm btn-danger" onclick="remove_content_quest(${e.id}, '${e.tilte}', 2)"><i class="bi bi-trash fs-5"></i> Hapus</button>
    `;
  } else if (url.includes("question-bank/standart")) {
    btnn = `
      <button type="button" class="btn btn-sm btn-success mx-2" onclick="show_form_edit(-16, ${e.id}, ${e.subj}, ${e.grad}, ${e.parent})"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-copy" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"/>
      </svg> Salin</button>
    `;
  } else {
    btnn = `
        <button type="button" class="btn btn-sm btn-success mx-2" onclick="show_form_edit(-15, ${e.id}, ${e.subj}, ${e.grad}, ${e.parent})"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-copy" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"/>
        </svg> Salin</button>
      `;
  }

  let html = "";
  if (url.includes("teacher/assessment/")) {
    html = `
    <div class="card" style="background-color: #F1F4F7;">
        <div class="card-body">
            <div class="alert alert-dismissible bg-light-primary border border-primary d-flex flex-column flex-sm-row mb-5">
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
  `;
  } else {
    html = `
      <div class="card">
          <div class="card-header p-5 d-flex justify-content-end">
              ${btnn}
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
    `;
  }
  $("#tab_task").html(html);
}

function generate_hint(e) {
  let url = window.location.href;
  let btnn = "";
  if (url.includes("question-bank/additional")) {
    btnn = `
      <button type="button" class="btn btn-sm btn-warning" onclick="show_form_edit(-12, ${e.id}, ${e.subj}, ${e.grad})"><i class="bi bi-pencil fs-5"></i> Ubah</button>
      <button type="button" class="btn btn-sm btn-danger mx-5" onclick="remove_content_quest(${e.id}, '${e.title}', 3)"><i class="bi bi-trash fs-5"></i> Hapus</button>
    `;
  }

  let html = "";
  if (url.includes("teacher/assessment/")) {
    html = `
      <div class="card" style="background-color: #F1F4F7;">
        <div class="card-body">
          <div class="alert alert-dismissible bg-light-info border border-info d-flex flex-column flex-sm-row mb-5">
              <div class="d-flex flex-column pe-0 pe-sm-10">
                  <h4 class="fw-semibold">Petunjuk Penyelesaian</h4>
                  ${e.hint == "<p><br></p>" ? "<p>Tidak ada data</p>" : e.hint}
              </div>
          </div>
        </div>
    </div>
  `;
  } else {
    html = `
      <div class="card">
        <div class="card-header p-5 d-flex justify-content-end">
            ${btnn}
        </div>
        <div class="card-body">
          <div class="alert alert-dismissible bg-light-info border border-info d-flex flex-column flex-sm-row p-5 mb-5">
              <div class="d-flex flex-column pe-0 pe-sm-10">
                  <h4 class="fw-semibold">Petunjuk Penyelesaian</h4>
                  ${e.hint == "<p><br></p>" ? "<p>Tidak ada data</p>" : e.hint}
              </div>
          </div>
        </div>
    </div>
  `;
  }

  $("#tab_hint").html(html);
}

function generate_explain(e) {
  let btnn = "";
  if (url.includes("question-bank/additional")) {
    btnn = `
      <button type="button" class="btn btn-sm btn-warning" onclick="show_form_edit(-13, ${e.id}, ${e.subj}, ${e.grad})"><i class="bi bi-pencil fs-5"></i> Ubah</button>
      <button type="button" class="btn btn-sm btn-danger mx-5" onclick="remove_content_quest(${e.id}, '${e.title}', 4)"><i class="bi bi-trash fs-5"></i> Hapus</button>
    `;
  }

  if (url.includes("teacher/assessment/")) {
    html = `
    <div class="card" style="background-color: #F1F4F7;">
          <div class="card-body">
      <div class="alert alert-dismissible bg-light-info border border-info d-flex flex-column flex-sm-row p-5 mb-5">
          <div class="d-flex flex-column pe-0 pe-sm-10">
              <h4 class="fw-semibold">Penjelasan Penyelesaian</h4>
              ${
                e.explain == "<p><br></p>" ? "<p>Tidak ada data</p>" : e.explain
              }
          </div>
      </div>
      </div>
      </div>
    `;
  } else {
    html = `
    <div class="card">
          <div class="card-header p-5 d-flex justify-content-end">
              ${btnn}
          </div>
          <div class="card-body">
      <div class="alert alert-dismissible bg-light-info border border-info d-flex flex-column flex-sm-row p-5 mb-5">
          <div class="d-flex flex-column pe-0 pe-sm-10">
              <h4 class="fw-semibold">Penjelasan Penyelesaian</h4>
              ${
                e.explain == "<p><br></p>" ? "<p>Tidak ada data</p>" : e.explain
              }
          </div>
      </div>
      </div>
      </div>
    `;
  }

  $("#tab_explain").html(html);
}

function show_form_edit(type, id, subj = null, grad = null, parent = null) {
  if (type == -14 || type == -15 || type == -16) {
    let urls =
      type == -16
        ? "/teacher/question-bank/standart/get-title-list"
        : "/teacher/question-bank/additional/get-title-list";

    $.ajax({
      url: base_url + urls,
      data: { subj, grad, parent },
      method: "post",
      dataType: "json",
      success: function (e) {
        let form = "";
        if (e.length > 0) {
          $.each(e, function (i, v) {
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
              `;
          });
        } else {
          form = "<p>Tidak ada judul soal lain</p>";
        }

        $("#head_content_modal_std").html(`
              <input type="hidden" name="form_type" value="${type}" />
              <input type="hidden" name="quest_id" value="${id}" />
              <h3 class="modal-title">${
                type == -14 ? "Pindahkan" : "Salin"
              } Soal Ke</h3>
          `);
        $("#body_content_modal_quest").html(form);

        $("#modal_update_content_quest").modal("show");
      },
    });
  } else {
    $.ajax({
      url: base_url + "/teacher/question-bank/additional/get-question",
      data: { id, type:null},
      method: "post",
      dataType: "json",
      success: function (e) {
        show_edit_task(e, type, id);
      },
    });
  }
}

function show_edit_task(e, type, id) {
  if (type == -11) {
    $("#repeater_edit").removeClass("hide");
    let opt = `<option value="0">Pilih Tipe Soal</option>`;
    $.each(e.list_quest, function (i, v) {
      opt += `<option value="${i}" ${
        i == e.type ? "selected" : ""
      }>${v}</option>`;
    });

    let choose = "";
    let iddx = 0;
    $.each(e.option, function (i, v) {
      if (e.type == 1) {
        choose += `
          <div class="mt-5" id="opt_mc_rem${iddx}">
              <div class="position-relative">
                  <div class="d-flex justify-content-left" style="min-width: 200px; padding-left:8px">
                      <div class="form-check form-check-custom form-switch form-check-success form-check-solid mb-2" style="margin-right: 4px">
                          <input class="form-check-input mc_option_edit ${
                            e.keys.includes(i) ? "checked_mc" : ""
                          }" type="radio" value="" ${
                            e.keys.includes(i) ? "checked" : ""
                          } />
                          <label class="form-check-label">
                              Jawaban Benar
                          </label>
                      </div>
                      <button onclick="rem_elem_id('opt_mc_rem${iddx}')" type="button" class="m-2 btn btn-danger btn-sm btn-icon"><i class="bi bi-trash fs-2"></i></button>
                  </div>
                  <div id="edit_optmc${iddx}" name="optmc${iddx}" class="optmc_n_edit"></div>
              </div>
          </div>
        `;
      } else if (e.type == 2) {
        choose += `
          <div class="mt-5" id="opt_mcx_rem${iddx}">
              <div class="position-relative">
                  <div class="d-flex justify-content-left" style="min-width: 200px; padding-left:8px">
                      <div class="form-check form-check-custom form-switch form-check-success form-check-solid mb-2" style="margin-right: 4px">
                          <input class="form-check-input mcx_option_edit ${
                            e.keys.includes(i) ? "checked_mcx" : ""
                          }" type="checkbox" value="" ${
                            e.keys.includes(i) ? "checked" : ""
                          } />
                          <label class="form-check-label">
                              Jawaban Benar
                          </label>
                      </div>
                      <button onclick="rem_elem_id('opt_mcx_rem${iddx}')" type="button" class="m-2 btn btn-danger btn-sm btn-icon"><i class="bi bi-trash fs-2"></i></button>
                  </div>
                  <div id="edit_optmcx${iddx}" name="optmcx${iddx}" class="optmcx_n_edit"></div>
              </div>
          </div>
        `;
      } else if (e.type == 3) {
        choose += `
          <div class="form-check form-check-custom form-switch form-check-success form-check-solid m-2">
              <input class="form-check-input tf_option" type="radio" name="tfopt_edit" value="${v}" id="ctrue_edit" ${
          iddx == v ? "checked" : ""
        } />
              <label class="form-check-label" for="ctrue">
                  ${v == 1 ? "Benar" : "Salah"}
              </label>
          </div>
        `;
      }
      iddx++;
    });

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
                        <select name="quest_type" id="quest_type_edit" class="form-control" disabled="true">
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
    `;
    if (e.type == 1) {
      $("#task_edit").html(task);
      $("#modal_update_task").modal("show");
    } else if (e.type == 2) {
      $("#task_edit_mcx").html(task);
      $("#modal_update_task_mcx").modal("show");
    } else if (e.type == 3) {
      $("#repeater_edit").addClass("hide");
      $("#task_edit").html(task);
      $("#modal_update_task").modal("show");
    }

    var task_quest_edit = new Quill("#task_quest_edit", {
      modules: {
        toolbar: toolbarOptions,
      },
      theme: "snow", // or 'bubble'
    });
    $("#task_quest_edit > .ql-editor").html(e.question);

    let iddy = 0;
    if (e.type == 1) {
      $.each(e.option, function (i, v) {
        var edit_optmc0 = new Quill("#edit_optmc" + iddy, {
          modules: {
            toolbar: toolbarOptions,
          },
          theme: "snow", // or 'bubble'
        });
        $("#edit_optmc" + iddy + " > .ql-editor").html(v);

        iddy++;
      });
    } else if (e.type == 2) {
      $.each(e.option, function (i, v) {
        var edit_optmcx0 = new Quill("#edit_optmcx" + iddy, {
          modules: {
            toolbar: toolbarOptions,
          },
          theme: "snow", // or 'bubble'
        });
        $("#edit_optmcx" + iddy + " > .ql-editor").html(v);

        iddy++;
      });
    }
  } else if (type == -12) {
    $("#repeater_edit").addClass("hide");
    let hint = `
    <input type="hidden" name="id_quest_edit" value="${id}" />
    <input type="hidden" name="form_type" value="${type}" />
        <div class="card" id="content_value">
            <div id="hint_quest_edit"></div>
        </div>
    </div>
    `;
    $("#task_edit").html(hint);
    $("#modal_update_task").modal("show");

    var hint_quest_edit = new Quill("#hint_quest_edit", {
      modules: {
        toolbar: toolbarOptions,
      },
      theme: "snow", // or 'bubble'
    });
    $("#hint_quest_edit > .ql-editor").html(e.hint);
  } else if (type == -13) {
    $("#repeater_edit").addClass("hide");
    let hint = `
    <input type="hidden" name="id_quest_edit" value="${id}" />
    <input type="hidden" name="form_type" value="${type}" />
        <div class="card" id="content_value">
            <div id="explain_quest_edit"></div>
        </div>
    </div>
    `;
    $("#task_edit").html(hint);
    $("#modal_update_task").modal("show");

    var explain_quest_edit = new Quill("#explain_quest_edit", {
      modules: {
        toolbar: toolbarOptions,
      },
      theme: "snow", // or 'bubble'
    });
    $("#explain_quest_edit > .ql-editor").html(e.explain);
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
      $("#" + id).remove();
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
  } else if (e == -2) {
    form = `
              <input type="hidden" name="form_type" value="${e}" />
              <input type="hidden" name="id_quest" value="${id}" />
          `;

    $("#head_content_modal_upl").html(
      `<h3 class="modal-title">Upload Soal ke ${chap}</h3>`
    );
    $("#body_content_modal_upl").html(form);
    $("#modal_upload_tasks").modal("show");
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
  $("#modal_update_task_mcx").modal("hide");
  $("#rmsg").addClass("hide");
}

function save_content_quest() {
  let type = $("input[name=form_type]").val();
  let form = true;

  if (type == 1) {
    chap = $("input[name=chapter]").val();
    subj = $("input[name=subject]").val();
    grad = $("input[name=grade]").val();
    if (chap != "") {
      store_content_quest(type, "", [chap, subj, grad]);
    } else {
      form = false;
      $("#msg_err_mdl").html("Judul soal tidak boleh kosong!");
    }
  } else if (type == 2) {
    id = $("input[name=id_quest]").val();
    chap = $("input[name=chapter]").val();
    subj = $("input[name=subject]").val();
    grad = $("input[name=grade]").val();
    if (chap != "") {
      store_content_quest(type, id, [chap, subj, grad]);
    } else {
      form = false;
      $("#msg_err_mdl").html("Judul soal tidak boleh kosong!");
    }
  } else if (type == -1) {
    pre_question(type);
  } else if (type == -11) {
    pre_question_edit(type);
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
  } else if (type == -16) {
    id = $("input[name=quest_id]").val();
    new_id = $('input[name="move_task"]:checked').val();
    store_content_quest(type, id, [new_id]);
  }

  if (form) {
    $("#modal_update_content_quest").modal("hide");
  } else {
    $("#rmsg").removeClass("hide");
  }
}

function pre_question(type) {
  let qtype = $("#quest_type").find(":selected").val();
  let idx_a = [];
  let option = [];
  let answer = [];
  let right_ans = true;
  let c_option = "";
  let c_check = "";
  let c_editor = "";

  if (qtype == 1) {
    c_option = ".mc_option";
    c_check = "checked_mc";
    c_editor = ".optmc_n";
  } else if (qtype == 2) {
    c_option = ".mcx_option";
    c_check = "checked_mcx";
    c_editor = ".optmcx_n";
  }

  if (qtype == 1 || qtype == 2) {
    let ch_opt = [];
    $(`${c_editor} > .ql-editor`).each(function () {
      if ($(this).html() != "<p><br></p>") {
        ch_opt.push($(this).html()); //or $(this).text();
      } else {
        ch_opt.push(null);
      }
    });

    let ii = 0;
    let chk = [];
    $(`${c_option}`).each(function () {
      if ($(this).hasClass(c_check)) {
        chk.push(ch_opt[ii]);
      } else {
        chk.push(false);
      }
      ii++;
    });

    for (let i = 0; i < ch_opt.length; i++) {
      if (chk[i] != false) {
        if (ch_opt[i] != null) {
          idx_a.push(true);
        } else {
          idx_a.push(false);
        }
      }
    }

    if (idx_a.includes(false)) {
      right_ans = false;
    }

    option = ch_opt.filter(function (el) {
      return el != null;
    });

    answer = chk.filter(function (el) {
      return el != false;
    });
  } else if (qtype == 3) {
    let tf_c = $('input[name="tfopt"]:checked').val();
    if (tf_c) {
      idx_a.push(tf_c);
    }
    answer.push(tf_c);
    option.push(1);
    option.push(2);
  }

  id = $("input[name=id_quest]").val();
  subj = $("input[name=subject]").val();
  grad = $("input[name=grade]").val();
  poin = $("input[name=poin]").val();
  quest_type = qtype;
  question = $("#quilleditor_question > .ql-editor").html();
  hint = $("#hint_quest > .ql-editor").html();
  explain = $("#explain_quest > .ql-editor").html();

  if (quest_type != 0) {
    if (question != "<p><br></p>") {
      if (option.length > 0) {
        if (right_ans) {
          if (!idx_a.includes(false) && idx_a.length > 0) {
            // al_swal("Jawaban ok", "success")
            store_content_quest(type, id, [
              subj,
              grad,
              quest_type,
              question,
              JSON.stringify(option),
              JSON.stringify(answer),
              poin,
              hint,
              explain,
            ]);
          } else {
            al_swal("Jawaban benar belum dipilih!", "error");
          }
        } else {
          al_swal("Pilihan jawaban benar tidak sesuai!", "error");
        }
      } else {
        al_swal("Kolom pilihan jawaban harus diisi!", "error");
      }
    } else {
      al_swal("Kolom pertanyaan harus diisi!", "error");
    }
  } else {
    al_swal("Tipe soal harus dipilih!", "error");
  }
}

function pre_question_edit(type) {
  let qtype = $("#quest_type_edit").find(":selected").val();
  let idx_a = [];
  let option = [];
  let answer = [];
  let right_ans = true;
  let c_option = "";
  let c_check = "";
  let c_editor = "";

  if (qtype == 1) {
    c_option = ".mc_option_edit";
    c_check = "checked_mc";
    c_editor = ".optmc_n_edit";
  } else if (qtype == 2) {
    c_option = ".mcx_option_edit";
    c_check = "checked_mcx";
    c_editor = ".optmcx_n_edit";
  }

  if (qtype == 1 || qtype == 2) {
    let ch_opt = [];
    $(`${c_editor} > .ql-editor`).each(function () {
      if ($(this).html() != "<p><br></p>") {
        ch_opt.push($(this).html()); //or $(this).text();
      } else {
        ch_opt.push(null);
      }
    });

    let ii = 0;
    let chk = [];
    $(`${c_option}`).each(function () {
      if ($(this).hasClass(c_check)) {
        chk.push(ch_opt[ii]);
      } else {
        chk.push(false);
      }
      ii++;
    });

    for (let i = 0; i < ch_opt.length; i++) {
      if (chk[i] != false) {
        if (ch_opt[i] != null) {
          idx_a.push(true);
        } else {
          idx_a.push(false);
        }
      }
    }

    if (idx_a.includes(false)) {
      right_ans = false;
    }

    option = ch_opt.filter(function (el) {
      return el != null;
    });

    answer = chk.filter(function (el) {
      return el != false;
    });
  } else if (qtype == 3) {
    let tf_c = $('input[name="tfopt_edit"]:checked').val();
    if (tf_c) {
      idx_a.push(tf_c);
    }
    answer.push(tf_c);
    option.push(1);
    option.push(2);
  }

  id = $("input[name=id_quest_edit]").val();
  subj = $("input[name=subject]").val();
  grad = $("input[name=grade]").val();
  poin = $("input[name=poin_edit]").val();
  quest_type = qtype;
  question = $("#task_quest_edit > .ql-editor").html();

  if (quest_type != 0) {
    if (question != "<p><br></p>") {
      if (option.length > 0) {
        if (right_ans) {
          if (!idx_a.includes(false) && idx_a.length > 0) {
            store_content_quest(type, id, [
              subj,
              grad,
              quest_type,
              question,
              JSON.stringify(option),
              JSON.stringify(answer),
              poin,
            ]);
          } else {
            al_swal("Jawaban benar belum dipilih!", "error");
          }
        } else {
          al_swal("Pilihan jawaban benar tidak sesuai!", "error");
        }
      } else {
        al_swal("Kolom pilihan jawaban harus diisi!", "error");
      }
    } else {
      al_swal("Kolom pertanyaan harus diisi!", "error");
    }
  } else {
    al_swal("Tipe soal harus dipilih!", "error");
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

$(document).on("click", ".mcx_option", function () {
  $(this).toggleClass("checked_mcx");
});

$(document).on("click", ".mcx_option_edit", function () {
  $(this).toggleClass("checked_mcx");
});

function store_content_quest(type, id, val) {
  let urls =
    type == -16
      ? "/teacher/question-bank/standart/update-content"
      : "/teacher/question-bank/additional/update-content";
  $.ajax({
    url: base_url + urls,
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
  var quilleditor_optmcx_edit = new Quill("#quilleditor_optmcx_edit", {
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
  var quilleditor_optmcx4 = new Quill("#quilleditor_optmcx4", {
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
  let url = window.location.href;
  if (url.includes("question-bank/additional/view-content")) {
    act_repeater();
  }
});

$(document).on("click", ".qtact", function (e) {
  e.preventDefault();
  $(".qtact").each(function () {
    if ($(this).hasClass("btn-primary")) {
      $(this).removeClass("btn-primary");
      $(this).addClass("btn-outline btn-outline-primary");
    }
  });
  $(this).addClass("btn-primary");
  $(this).removeClass("btn-outline btn-outline-primary");
});
