function grab_data_lesson(
  type,
  id = null,
  subj = null,
  grad = null,
  param = null
) {
  $.ajax({
    url: base_url + "/teacher/tasks/grab-data-lesson",
    data: { type, id, subj, grad, param },
    method: "post",
    dataType: "json",
    success: function (e) {
      if (type == 1) {
        treeview_tasks_ch(e, subj, grad);
      } else if (type == 2) {
        generate_view_lesson_s(e);
        generate_view_video_s(e);
        generate_view_attachment_s(e);
        generate_view_task_s(
          e.tasks,
          e.lesson_standart_id,
          e.lesson_standart_subject_id,
          e.lesson_standart_grade
        );

        if ($("#content_tab").hasClass("hide")) {
          $("#content_tab").removeClass("hide");
          $("#content_value").removeClass("hide");
        }
      }
    },
  });
}

function chk_range_tasks() {
  let start = $("#start_tasks").val();
  let end = $("#end_tasks").val();

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
  $("#tasks_prev_less").modal("hide");
}

$(document.body).on("click", "#btnshow_lesson", function () {
  let subj = $(this).data("subjs");
  let grad = $(this).data("grade");
  grab_data_lesson(1, "", subj, grad);
  set_datepicker();
  $("#tasks_prev_less").modal("show");
});

function treeview_tasks_ch(e, subj, grad) {
  console.log(e);

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
                    <input class="form-check-input" type="radio" name="tasks_choose" data-lessonsrc=${v.ind} data-taskname="${value.text}" data-taskchapter="${value.chapter}" value="${value.lesson_id}" />
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
  $("#treeview_tasks__").html(page);
}

function getlessonbyid(id, src) {
  grab_data_lesson(2, id, "", "", src);
}

function choose_tasks() {
  let task_less = $("input[name=tasks_choose]:checked").val();
  let task_name = $("input[name=tasks_choose]:checked").data("taskname");
  let task_chap = $("input[name=tasks_choose]:checked").data("taskchapter");
  let lessonsrc = $("input[name=tasks_choose]:checked").data("lessonsrc");
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

    $("#modal_tasks_ch").modal("show");
    set_datepicker();
    check_group(subj_ass, grad_ass);
  } else {
    $("#select_tk_alert").removeClass("hide");
    setTimeout(function () {
      $("#select_tk_alert").addClass("hide");
    }, 5000);
  }
}

function save_tasks(status = null, source = null) {
  let id_ass = $("input[name=tasks_id]").val();
  let lesson_name = $("input[name=selected_task]").val();
  let subj_name = $("input[name=selected_subj]").val();
  let lesson = $("input[name=lessonid]").val();
  let lessonsrc = $("input[name=lessonsrc]").val();
  let subj = $("input[name=subjid]").val();
  let grad = $("input[name=gradid]").val();
  let title = $("input[name=title]").val();
  let group = $("#multiple-select-group").select2("data");
  let start = $("#start_tasks").val();
  let end = $("#end_tasks").val();
  let submit = $("#autosumbit").hasClass("checked");
  let instask = $("#instruction_tasks > .ql-editor").html();

  let msg = ["title_ass", "group_ass", "start_ass", "end_ass"];
  let chk = [title != "", group.length > 0, start != "", end != ""];

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
    if (chk_range_tasks() == 1) {
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
        source, //belum di gunakan
      ];

      store_tasks(1, "", JSON.stringify(data));
    } else {
      let msg =
        chk_range_tasks() == 2
          ? "Periode awal tidak boleh lebih besar dari periode akhir!"
          : "Periode awal tidak boleh lebih kecil dari hari ini!";
      $(".anom_period").html(msg).removeClass("hide");
      // al_swal('Periode tidak sesuai!', 'error')
    }
  }
}

function store_tasks(type, id, param) {
  $.ajax({
    url: base_url + "/teacher/tasks/store-data",
    data: { type, id, param },
    method: "post",
    dataType: "json",
    success: function (e) {
      $("#modal_task_choose").modal("hide");
      $("#modal_tasks_ch").modal("hide");
      $("#tasks_prev_less").modal("hide");
      reload_tabulator();
      Toast.fire({
        icon: e.icn,
        title: e.msg,
      });
    },
  });
}

function lesson_preview(id, src, task_id) {
  if (id != "") {
    $.ajax({
      url: base_url + "/teacher/tasks/task-lesson",
      data: { id, src, task_id },
      method: "post",
      dataType: "json",
      success: function (e) {
        generate_view_lesson_p(e.lesson);
        generate_view_video_p(e.lesson);
        generate_view_attachment_p(e.lesson);
        generate_view_task_p(JSON.parse(e.task.task_task_ids), e.lesson.lesson_additional_id, e.lesson.lesson_additional_subject_id, e.lesson.lesson_additional_grade);
        $("#tasks_prev_less").modal("show");
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
    success: function (e) {
      choose_task_view(e, id);
      $("#modal_task_choose").modal("show");
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
                  <label class="form-check-label" onclick="view_tasks(${i1}, ${value.id})">
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

function selected_tasks() {
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

  console.log(send_std);
  console.log(send_me);
  console.log(send_pub);

  store_tasks(3, idt, [send_std, send_me, send_pub])
}

var printIcon = function (cell, formatterParams) {
  return `<button class="btn btn-icon btn-sm btn-primary"><svg width="20" height="20" fill="currentColor" class="bi bi-send-check-fill" viewBox="0 0 16 16">
    <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 1.59 2.498C8 14 8 13 8 12.5a4.5 4.5 0 0 1 5.026-4.47zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471z"/>
    <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-1.993-1.679a.5.5 0 0 0-.686.172l-1.17 1.95-.547-.547a.5.5 0 0 0-.708.708l.774.773a.75.75 0 0 0 1.174-.144l1.335-2.226a.5.5 0 0 0-.172-.686"/>
    </svg></buton>`;
};

function type_tasks(type, ids, sts) {
  Swal.fire({
    html:
      sts == 2
        ? `Apakah anda yakin terbitkan ${ids.length} tugas terpilih?`
        : `Apakah anda yakin batalkan ${ids.length} tugas terpilih?`,
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
      store_tasks(type, ids, sts);
      reload_tabulator();
      // alert("Printing row data for: " + cell.getRow().getData().id);
    }
  });
}

function reload_tabulator() {
  if (url.includes("tasks/index-draft")) {
    task_draft.replaceData();
  } else if (url.includes("tasks/index-scheduled")) {
    task_scheduled.replaceData();
  }
}

if (url.includes("tasks/index-draft")) {
  let c = [
    { title: "#Aksi", field: "acts", width: 150, formatter: "html" },
    { title: "Periode", field: "period" },
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    { title: "Penilaian", field: "title" },
    { title: "Mata Pelajaran", field: "mapel", formatter: "html" },
    { title: "Kelompok Belajar", field: "group", formatter: "html" },
  ];

  tbconf.columns = c;
  var task_draft = new Tabulator("#task_draft_table", tbconf);
} else if (url.includes("tasks/index-scheduled")) {
  let c = [
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    { title: "Periode", field: "period" },
    { title: "Penilaian", field: "title", width: 250 },
    { title: "Mata Pelajaran", field: "mapel", formatter: "html" },
    { title: "Kelompok Belajar", field: "group", formatter: "html" },
    // { title: "Judul Soal", field: "task" },
  ];

  tbconf.columns = c;
  var task_scheduled = new Tabulator("#task_scheduled_table", tbconf);
} else if (url.includes("tasks/index-present")) {
  let c = [
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    { title: "Periode", field: "period" },
    { title: "Penilaian", field: "title", width: 250 },
    { title: "Mata Pelajaran", field: "mapel", formatter: "html" },
    { title: "Kelompok Belajar", field: "group", formatter: "html" },
    // { title: "Judul Soal", field: "task" },
  ];

  tbconf.columns = c;
  var task_present = new Tabulator("#task_present_table", tbconf);
} else if (url.includes("tasks/index-done")) {
  let c = [
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    { title: "Periode", field: "period" },
    { title: "Penilaian", field: "title", width: 250},
    { title: "Mata Pelajaran", field: "mapel", formatter: "html"},
    { title: "Kelompok Belajar", field: "group", formatter: "html" },
    // { title: "Judul Soal", field: "task" },
  ];

  tbconf.columns = c;
  var task_done = new Tabulator("#task_done_table", tbconf);
}

document.getElementById("select-all").addEventListener("click", function(){
  if (url.includes("tasks/index-draft")) {
    task_draft.selectRow();
  } else if (url.includes("tasks/index-scheduled")) {
    task_scheduled.selectRow();
  }
});
document.getElementById("deselect-all").addEventListener("click", function(){
  if (url.includes("tasks/index-draft")) {
    task_draft.deselectRow();
  } else if (url.includes("tasks/index-scheduled")) {
    task_scheduled.deselectRow();
  }
});

if (url.includes("tasks/index-draft")) {
  document.getElementById("publish-btn").addEventListener("click", function(){
    let sel_data = task_draft.getSelectedData();
    let ids = sel_data.map(i => i.id)
    if (ids.length < 1) {
      al_swal('Belum ada data terpilih', 'error')
    } else {
      type_tasks(2, ids, 2)
    }
  });
}

if (url.includes("tasks/index-scheduled")) {
  document.getElementById("unpublish-btn").addEventListener("click", function(){
    let sel_data = task_scheduled.getSelectedData();
    let ids = sel_data.map(i => i.id)
    if (ids.length < 1) {
      al_swal('Belum ada data terpilih', 'error')
    } else {
      type_tasks(2, ids, 1)
    }
  });
}
// document.getElementById("delete-btn").addEventListener("click", function(){
//   let sel_data = '';
//   if (url.includes("tasks/index-draft")) {
//     sel_data = task_draft.getSelectedData();
//   } else if (url.includes("tasks/index-scheduled")) {
//     sel_data = task_scheduled.getSelectedData();
//   }
// });

$(document).ready(function () {
  if (url.includes("tasks/index-add")) {
    var instruction_tasks = new Quill("#instruction_tasks", {
      modules: {
        toolbar: toolbarOptions,
      },
      theme: "snow", // or 'bubble'
    });
  } else if (url.includes("tasks/index-draft")) {
    // var instruction_tasks_edit = new Quill("#instruction_tasks_edit", {
    //   modules: {
    //     toolbar: toolbarOptions,
    //   },
    //   theme: "snow", // or 'bubble'
    // });
    task_draft.setData(base_url + "/teacher/tasks/list-tasks?page-task=1");
  } else if (url.includes("tasks/index-scheduled")) {
    task_scheduled.setData(base_url + "/teacher/tasks/list-tasks?page-task=2");
  } else if (url.includes("tasks/index-present")) {
    task_present.setData(base_url + "/teacher/tasks/list-tasks?page-task=3");
  } else if (url.includes("tasks/index-done")) {
    task_done.setData(base_url + "/teacher/tasks/list-tasks?page-task=4");
  }
});
