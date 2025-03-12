function grab_data_lesson(
  type,
  id = null,
  subj = null,
  grad = null,
  param = null
) {
  $.ajax({
    url: base_url + "/teacher/task/grab-data-lesson",
    data: { type, id, subj, grad, param },
    method: "post",
    dataType: "json",
    beforeSend: function () {
      show_loading()
    },
    success: function (e) {
      if (type == 1) {
        treeview_task_ch(e, subj, grad);
      } else if (type == 2) {
        generate_view_lesson_s(e);
        generate_view_video_s(e);
        generate_view_attachment_s(e);
        generate_view_task_s(
          e.task,
          e.lesson_standart_id,
          e.lesson_standart_subject_id,
          e.lesson_standart_grade
        );

        if ($("#content_tab").hasClass("hide")) {
          $("#content_tab").removeClass("hide");
          $("#content_value").removeClass("hide");
        }
      }
      hide_loading()
    },
  });
}

function chk_range_task() {
  let start = $("#start_task").val();
  let end = $("#end_task").val();

  if (start != "" && end != "") {
    let dtstart = new Date(Date.parse(start.replace(" ", "T") + ":00Z"));
    let dtend = new Date(Date.parse(end.replace(" ", "T") + ":00Z"));

    curr = new Date();
    if (dtstart < curr) {
      return 3;
    } else {
      if (dtstart < dtend) {
        return 1;
      } else {
        return 2;
      }
    }
  }
}

function close_modal() {
  $("#task_prev_less").modal("hide");
}

$(document.body).on("click", "#btnshow_lesson", function () {
  let subj = $(this).data("subjs");
  let grad = $(this).data("grade");
  grab_data_lesson(1, "", subj, grad);
  set_datepicker();
  $("#task_prev_less").modal("show");
});

function treeview_task_ch(e, subj, grad) {  
  let content = "";
  let bdi1 = 1;
  $.each(e.datas, function (i, v) {
    let bd1 = "";
    let bdi2 = 1;
    $.each(v.nodes, function (idx, val) {
      let child = "";
      let ii = 1;
      $.each(val.nodes, function (index, value) {
        child += `
                <div class="form-check my-2">
                    <input class="form-check-input" type="radio" name="task_choose" data-lessonsrc=${v.ind} data-taskname="${value.text}" data-taskchapter="${value.chapter}" value="${value.lesson_id}" />
                    <label class="form-check-label" onclick="getlessonbyid(${value.lesson_id}, ${v.ind})">
                        ${value.text}
                    </label>
                </div>
                `;
        ii++;
      });

      let child_body = `
                 <ul class="list-group list-group-flush hide task_child" id="i${bdi1}${bdi2}" style="padding-left: 10px">
                    ${child}
                </ul>
            `;

      bd1 += `
                <li class="list-group-item parent2" data-source="${bdi1}${bdi2}">${val.text}</li>
                ${child_body}    
            `;

      bdi2++;
    });

    let bd1_body = `
            <ul class="list-group hide list-group-flush head_parent2" id="i${bdi1}">
                ${bd1}
            </ul>
        `;
    content += `
            <li class="list-group-item bg-secondary parent1" data-source="${bdi1}"><h6 style="margin-top:5px">${v.text}</h6></li>
            ${bd1_body}
        `;

    bdi1++;
  });

  let page = `
        <div id="idass_subj" data-subj="${subj}" data-subjname="${e.subjname}"></div>
        <div id="idass_grad" data-grad="${grad}" data-gradname="Kelas ${e.gradname}"></div>
        <ul class="list-group list-group-flush head_parent1">
            ${content}
        </ul>
    `;
  $("#treeview_task__").html(page);
}

function getlessonbyid(id, src) {
  grab_data_lesson(2, id, "", "", src);
}

function choose_task() {
  let task_less = $("input[name=task_choose]:checked").val();
  let task_name = $("input[name=task_choose]:checked").data("taskname");
  let task_chap = $("input[name=task_choose]:checked").data("taskchapter");
  let lessonsrc = $("input[name=task_choose]:checked").data("lessonsrc");
  let subj_ass = $("#idass_subj").data("subj");
  let subj_name = $("#idass_subj").data("subjname");
  let grad_ass = $("#idass_grad").data("grad");
  let grad_name = $("#idass_grad").data("gradname");

  if (task_less != undefined) {
    $("input[name=selected_task]")
      .val(task_chap + " - " + task_name)
      .attr("readonly", true);
    $("input[name=lessonid]").val(task_less);
    $("input[name=lessonsrc]").val(lessonsrc);
    $("input[name=selected_subj]")
      .val(subj_name + " - " + grad_name)
      .attr("readonly", true);
    $("input[name=subjid]").val(subj_ass);
    $("input[name=selected_grad]").val(grad_name).attr("readonly", true);
    $("input[name=gradid]").val(grad_ass);

    $("#modal_task_ch").modal("show");
    get_religion();
    set_datepicker();
    check_group(subj_ass, grad_ass);
  } else {
    $("#select_tk_alert").removeClass("hide");
    setTimeout(function () {
      $("#select_tk_alert").addClass("hide");
    }, 5000);
  }
}

function clear_form_task() {
  $("input[name=title]").val('')
  $("input[name=selected_subj]").val('')
  $("input[name=subjid]").val('')
  $("#start_task").val('')
  $("#end_task").val('')
  $("#instruction_task > .ql-editor").html('<p><br></p>')

  $(".inpsubm").html('<input class="form-check-input asscheck w-45px h-30px" type="checkbox" id="autosumbit">');
  $(".inpreli").html('<input class="form-check-input asscheck" name="religion_assign" id="religion_assign" type="checkbox" value="1">');

  $('.end_ass').addClass('hide')
  $('.start_ass').addClass('hide')
  $('.group_ass').addClass('hide')
  $('.title_ass').addClass('hide')
  $('.selreli').addClass('hide')
}

function save_task(status = null, save_type = null) {
  let id_task_ = $("input[name=task_id]").val();
  let lesson_name = $("input[name=selected_task]").val();
  let subj_name = $("input[name=selected_subj]").val();
  let lesson = $("input[name=lessonid]").val();
  let lessonsrc = $("input[name=lessonsrc]").val();
  let subj = $("input[name=subjid]").val();
  let grad = $("input[name=gradid]").val();
  let title = $("input[name=title]").val();
  let group = $("#multiple-select-group").select2("data");
  let start = $("#start_task").val();
  let end = $("#end_task").val();
  let submit = $("#autosumbit").hasClass("checked");
  let reli_sel = $('#select_religion_test').val();
  let isreli = $("#religion_assign").hasClass("checked");

  let reli_sts = isreli ? (reli_sel != 0 ? true : false) : true;

  let instask = ''
  if (save_type == 2) {
    instask = $("#instruction_task_upd > .ql-editor").html();
  } else {
    instask = $("#instruction_task > .ql-editor").html();
  }

  let msg = ["title_ass", "group_ass", "start_ass", "end_ass", "reli_ass"];
  let chk = [title != "", group.length > 0, start != "", end != "", reli_sts];

  for (let i = 0; i < chk.length; i++) {
    if (chk[i] != true) {
      if ($("." + msg[i]).hasClass("hide")) {
        $("." + msg[i]).removeClass("hide");
      }
    } else {
      if (!$("." + msg[i]).hasClass("hide")) {
        $("." + msg[i]).addClass("hide");
      }
    }
  }

  if (chk.includes(false)) {
    return false;
  } else {
    if (chk_range_task() == 1) {
      let data = [
        title,
        subj,
        grad,
        group,
        start,
        end,
        submit,
        instask,
        lesson,
        lesson_name,
        subj_name,
        lessonsrc,
        status,
        save_type,
        reli_sel,
      ];

      store_task(1, id_task_, JSON.stringify(data));
    } else {
      let msg =
        chk_range_task() == 2
          ? "Periode awal tidak boleh lebih besar dari periode akhir!"
          : "Periode awal tidak boleh lebih kecil dari hari ini!";
      $(".anom_period").html(msg).removeClass("hide");
      // al_swal('Periode tidak sesuai!', 'error')
    }
  }
}

function store_task(type, id, param) {
  $.ajax({
    url: base_url + "/teacher/task/store-data",
    data: { type, id, param },
    method: "post",
    dataType: "json",
    beforeSend: function () {
      show_loading()
    },
    success: function (e) {
      $("#modal_task_choose").modal("hide");
      $("#modal_task_upd").modal("hide");
      $("#modal_task_ch").modal("hide");
      $("#task_prev_less").modal("hide");
      reload_tabulator();
      Toast.fire({
        icon: e.icn,
        title: e.msg,
      });
      hide_modal()
      hide_loading()
    },
  });
}

function edit_task(id) {
  $.ajax({
    url: base_url + "/teacher/task/get-edit",
    data: { id },
    method: "post",
    dataType: "json",
    beforeSend: function () {
      show_loading()
    },
    success: function (e) {
      check_group(e.task_subject_id, e.task_grade);
      set_datepicker();
      setTimeout(function () {
        view_edit_task(e);
      }, 1000);
    },
  });
}

function view_edit_task(e) {
  get_religion(parseInt(e.task_religion))
  let title_chap = ''
  if (e.task_lesson_src == 2) {
    title_chap = e.lesson_standart_chapter + ' - ' + e.lesson_standart_subchapter
  } else {
    title_chap = e.lesson_additional_chapter + ' - ' + e.lesson_additional_subchapter
  }

  $("input[name=task_id]").val(e.task_id);
  $("input[name=subjid]").val(e.task_subject_id);
  $("input[name=gradid]").val(e.task_grade);
  $("input[name=lessonid]").val(e.task_lesson_id);
  $("input[name=lessonsrc]").val(e.task_lesson_src);
  $("input[name=selected_task]").val(title_chap);
  $("input[name=selected_subj]").val(e.subject_name  + ' - Kelas ' + e.task_grade );
  $("input[name=title]").val(e.task_title);

  let start = e.task_start.substring(0, 16);
  let end = e.task_end.substring(0, 16);
  $("#start_task").val(start);
  $("#end_task").val(end);

  if (e.task_is_autosubmit == 1) {
    $("#autosumbit").addClass("checked").prop("checked", true);
  } else {
    $("#autosumbit").removeClass("checked").prop("checked", false);
  }

  if (parseInt(e.task_religion) > 0) {
    $("#religion_assign").addClass("checked").prop("checked", true);
    $(".selreli").removeClass("hide");
  } else {
    $("#religion_assign").removeClass("checked").prop("checked", false);
  }

  let selected_group = [];
  $.each(JSON.parse(e.task_group), function (i, v) {
    selected_group.push(v.id);
  });
  $("#multiple-select-group").val(selected_group).trigger("change");

  $("#instruction_task_upd > .ql-editor").html(e.task_instruction);

  $('#modal_task_upd').modal('show')
}

function lesson_preview(id, src, task_id) {
  if (id != "") {
    $.ajax({
      url: base_url + "/teacher/task/task-lesson",
      data: { id, src, task_id },
      method: "post",
      dataType: "json",
      beforeSend: function () {
        show_loading()
      },
      success: function (e) {
        generate_view_lesson_p(e.lesson);
        generate_view_video_p(e.lesson);
        generate_view_attachment_p(e.lesson);
        generate_view_task_p(
          JSON.parse(e.task.task_task_ids),
          e.lesson.lesson_additional_id,
          e.lesson.lesson_additional_subject_id,
          e.lesson.lesson_additional_grade
        );
        $("#task_prev_less").modal("show");
        hide_loading()
      },
    });
  }
}

function view_quest_bank(id, subj, grad) {
  $.ajax({
    url: base_url + "/teacher/lesson/additional/question-bank",
    data: { subj, grad },
    method: "post",
    dataType: "json",
    beforeSend: function () {
      show_loading()
    },
    success: function (e) {
      choose_task_view(e, id);
      $("#modal_task_choose").modal("show");
      hide_loading()
    },
  });
}

function choose_task_view(e, id) {
  let content = "";
  let i1 = 1;
  $.each(e, function (i, v) {
    let ch1 = "";
    let i2 = 1;
    $.each(v.content, function (idx, val) {
      let child = "";
      let ii = 1;
      $.each(val["child"], function (index, value) {
        child += `
              <div class="form-check my-2">
                  <input class="form-check-input" type="checkbox" name="task_${i1}" value="${value.id}" />
                  <label class="form-check-label" onclick="view_task(${i1}, ${value.id})">
                      Soal ${ii}
                  </label>
              </div>
              `;
        ii++;
        // <li class="list-group-item">Soal ${ii}</li>
      });

      let child_body = `
               <ul class="list-group list-group-flush hide task_child" id="i${i1}${i2}" style="padding-left: 10px">
                  ${child}
              </ul>
          `;

      ch1 += `
              <li class="list-group-item parent2" data-source="${i1}${i2}">${
        val.title
      }</li>
              ${val.child.length > 0 ? child_body : ""}    
          `;

      i2++;
    });

    let ch1_body = `
          <ul class="list-group list-group-flush hide head_parent2" id="i${i1}">
              ${ch1}
          </ul>
      `;
    content += `
          <li class="list-group-item bg-secondary parent1" data-source="${i1}"><h6 style="margin-top:5px">${
      v.head
    }</h6></li>
          ${v.content.length > 0 ? ch1_body : ""}
      `;

    i1++;
  });

  let page = `
    <input type="hidden" name="task_id_upd" value="${id}" />
      <ul class="list-group list-group-flush head_parent1">
          ${content}
      </ul>
  `;

  $("#view_select_task").html(page);
}

function selected_task() {
  let std_task = [];
  $('input[name="task_1"]:checked').each(function () {
    std_task.push(this.value);
  });

  let me_task = [];
  $('input[name="task_2"]:checked').each(function () {
    me_task.push(this.value);
  });

  let pub_task = [];
  $('input[name="task_3"]:checked').each(function () {
    pub_task.push(this.value);
  });

  let idt = $("input[name=task_id_upd]").val();

  let send_std = std_task.length > 0 ? std_task : "empty";
  let send_me = me_task.length > 0 ? me_task : "empty";
  let send_pub = pub_task.length > 0 ? pub_task : "empty";

  store_task(3, idt, [send_std, send_me, send_pub]);
}

function type_task(type, ids, sts) {
  let msg = sts == 9 ? "hapus" : sts == 2 ? "terbitkan" : "batalkan";

  Swal.fire({
    html:
      sts == 2
        ? `Apakah anda yakin ${msg} ${ids.length} tugas terpilih?`
        : `Apakah anda yakin ${msg} ${ids.length} tugas terpilih?`,
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
      store_task(type, ids, sts);
    }
  });
}

function reload_tabulator() {
  if (url.includes("task/index-draft")) {
    task_draft.replaceData();
  } else if (url.includes("task/index-scheduled")) {
    task_scheduled.replaceData();
  }
}

function begin_task(id) {
  Swal.fire({
    html: `Apakah anda yakin ingin mulai mengerjakan?`,
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
      get_task(id)
    }
  });
}

function get_task(id) {
  $.ajax({
    url: base_url + "/student/task/act-get-task",
    data: { id },
    method: "post",
    dataType: "json",
    beforeSend: function () {
      show_loading()
    },
    success: function (e) {
      console.log(e);
      hide_loading()
    },
  });
}

function show_modal_task() {
  $('#mdltitle_tsk').html('Tugas')
  $('#task_modal_question').modal('show')
}

if (url.includes("teacher/task/index-draft")) {
  let c = [
    // { title: "#Aksi", field: "acts", width: 150, formatter: "html", headerVisible:false},
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    { title: "Akhir", field: "end_date", visible: false },
    { field: "lists", formatter: "html", headerFilter:"input", headerSort:false},
  ];

  tbconf.columns = c;
  var task_draft = new Tabulator("#task_draft_table", tbconf);
} else if (url.includes("teacher/task/index-scheduled")) {
  let c = [
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    { title: "Akhir", field: "end_date", visible: false },
    { field: "lists", formatter: "html", headerFilter:"input", headerSort:false},
  ];

  tbconf.columns = c;
  var task_scheduled = new Tabulator("#task_scheduled_table", tbconf);
} else if (url.includes("teacher/task/index-present")) {
  let c = [
    { field: "lists", formatter: "html", headerFilter:"input", headerSort:false},
  ];

  tbconf.columns = c;
  var task_present = new Tabulator("#task_present_table", tbconf);
} else if (url.includes("teacher/task/index-done")) {
  let c = [
    { field: "lists", formatter: "html", headerFilter:"input", headerSort:false},
  ];

  tbconf.columns = c;
  var task_done = new Tabulator("#task_done_table", tbconf);
} else if (url.includes("student/task/present")) {
  let c = [
    { field: "lists", formatter: "html", headerFilter:"input", headerSort:false},
  ];

  tbconf.columns = c;
  var task_presents = new Tabulator("#task_presents_table", tbconf);
} else if (url.includes("student/task/done")) {
  let c = [
    { field: "lists", formatter: "html", headerFilter:"input", headerSort:false},
  ];

  tbconf.columns = c;
  var task_dones = new Tabulator("#task_dones_table", tbconf);
} else if (url.includes("student/task/missed")) {
  let c = [
    { field: "lists", formatter: "html", headerFilter:"input", headerSort:false},
  ];

  tbconf.columns = c;
  var task_misseds = new Tabulator("#task_misseds_table", tbconf);
}

if (url.includes("teacher/task")) {
  if (url.includes("task/index-draft")) {
    document
      .getElementById("select-all")
      .addEventListener("click", function () {
        task_draft.selectRow();
      });
  }
  if (url.includes("task/index-scheduled")) {
    document
      .getElementById("select-all")
      .addEventListener("click", function () {
        task_scheduled.selectRow();
      });
  }
  if (url.includes("task/index-draft")) {
    document
      .getElementById("deselect-all")
      .addEventListener("click", function () {
        task_draft.deselectRow();
      });
  }
  if (url.includes("task/index-scheduled")) {
    document
      .getElementById("deselect-all")
      .addEventListener("click", function () {
        task_scheduled.deselectRow();
      });
  }

  if (url.includes("task/index-draft")) {
    document
      .getElementById("publish-btn")
      .addEventListener("click", function () {
        let sel_data = task_draft.getSelectedData();
        let ids = sel_data.map((i) => i.id);
        let eds = sel_data.map((i) => i.end_date);

        if (ids.length < 1) {
          al_swal("Belum ada data terpilih", "error");
        } else {
          if (check_good_date(eds)) {
            al_swal(
              "Tidak bisa diterbitkan karena terdapat data kedaluarsa",
              "error"
            );
          } else {
            type_task(2, ids, 2);
          }
        }
      });

    document
      .getElementById("delete-btn")
      .addEventListener("click", function () {
        let sel_data = task_draft.getSelectedData();
        let ids = sel_data.map((i) => i.id);
        if (ids.length < 1) {
          al_swal("Belum ada data terpilih", "error");
        } else {
          type_task(2, ids, 9);
        }
      });
  }

  if (url.includes("task/index-scheduled")) {
    document
      .getElementById("unpublish-btn")
      .addEventListener("click", function () {
        let sel_data = task_scheduled.getSelectedData();
        let ids = sel_data.map((i) => i.id);
        if (ids.length < 1) {
          al_swal("Belum ada data terpilih", "error");
        } else {
          type_task(2, ids, 1);
        }
      });
  }
}

$(document).ready(function () {
  $('.tabulator-header-filter input').attr('placeholder', 'Cari data ...')
  if (url.includes("teacher/task/index-add")) {
    var instruction_task = new Quill("#instruction_task", {
      modules: {
        toolbar: toolbarOptions,
      },
      theme: "snow", // or 'bubble'
    });
  } else if (url.includes("teacher/task/index-draft")) {
    var instruction_task_upd = new Quill("#instruction_task_upd", {
      modules: {
        toolbar: toolbarOptions,
      },
      theme: "snow", // or 'bubble'
    });
    task_draft.setData(base_url + "/teacher/task/list-task?page-task=1");
  } else if (url.includes("teacher/task/index-scheduled")) {
    task_scheduled.setData(base_url + "/teacher/task/list-task?page-task=2");
  } else if (url.includes("teacher/task/index-present")) {
    task_present.setData(base_url + "/teacher/task/list-task?page-task=3");
  } else if (url.includes("teacher/task/index-done")) {
    task_done.setData(base_url + "/teacher/task/list-task?page-task=4");
  } else if (url.includes("student/task/present")) {
    task_presents.setData(base_url + "/student/task/list-task?page-task=1");
  } else if (url.includes("student/task/missed")) {
    task_misseds.setData(base_url + "/student/task/list-task?page-task=2");
  } else if (url.includes("student/task/done")) {
    task_dones.setData(base_url + "/student/task/list-task?page-task=3");
  }
});
