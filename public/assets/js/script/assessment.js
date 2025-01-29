function show_modal() {
  $("#modal_assessment").modal("show");
  set_datepicker();
}

function show_qb(subj, grad) {
  // let subj = $("select[name=subject]").val();
  // let grad = $("select[name=grade]").val();

  let msg = ["sub_ass", "grade_ass"];
  let chk = [subj != 0, grad != 0];

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
    al_swal("Mata Pelajaran dan Kelas harus dipilih terlebih dahulu!", "error");
  } else {
    $.ajax({
      url: base_url + "/teacher/assessment/view-question-bank",
      data: { subj, grad },
      method: "post",
      dataType: "json",
      success: function (e) {
        preview_qb(e.res, subj, e.sub_name, grad, e.grd_name);
      },
    });
  }
}

function preview_qb(e, subj, subjname, grad, gradname) {
  let content = "";
  let i1 = 1;
  $.each(e, function (i, v) {
    if (v.content.length > 0) {
      let ch1 = "";
      let i2 = 1;
      $.each(v.content, function (idx, val) {
        let child = "";
        let ii = 1;
        let chi = 1;
        $.each(val["child"], function (index, value) {
          let cch = "";
          $.each(value, function (a, b) {
            cch += `<a href="#" onclick="view_tasks(${i1}, ${b})" class="m-1 btn btn-icon btn-sm btn-outline btn-outline-primary">${chi}</a>`;
            chi++;
          });
          child += `
                <div style="margin-left: 8px; margin-bottom: 10px;" class="d-flex justify-content-start">
                    ${cch}
                </div>
                `;
          // child += `
          // <li class="list-group-item">
          //   <a href="#" onclick="view_tasks(${i1}, ${value.id})" style="text-decoration: none;">Soal ${ii}</a>
          // </li>
          // `
          ii++;
        });

        let child_body = `
                 <ul class="list-group list-group-flush hide task_child" id="i${i1}${i2}">
                    ${child}
                </ul>
            `;

        ch1 += `
                 <div class="form-check my-2 form-switch form-check-custom form-check-solid" style="margin-left: 10px">
                    <input class="form-check-input h-20px w-30px" type="radio" name="task_ass_check" data-tasksrc=${
                      v.src
                    } data-taskname="${val.title}" value="${val.id}" />
                    <label class="form-check-label head22" data-source="${i1}${i2}">
                      ${val.title}
                    </label>
                </div>
                ${val.child.length > 0 ? child_body : ""}    
                `;
        // <li class="list-group-item head22" data-source="${i1}${i2}">${val.title}</li>

        i2++;
      });

      let ch1_body = `
            <ul class="list-group list-group-flush hide head_head22 text-bold" id="i${i1}">
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
    }
  });

  let page = `
        <div id="idass_subj" data-subj="${subj}" data-subjname="${subjname}"></div>
        <div id="idass_grad" data-grad="${grad}" data-gradname="Kelas ${gradname}"></div>
        <ul class="list-group list-group-flush head_parent1">
            ${content}
        </ul>
    `;

  $("#view_select_task").html(page);
  $("#preview_task").html("");
  $("#task_prev_ass").modal("show");
}

$(document.body).on("click", ".head22", function () {
  id = $(this).data("source");
  if ($("#i" + id).hasClass("hide")) {
    $("#i" + id).removeClass("hide");
  } else {
    $("#i" + id).addClass("hide");
  }
});

function set_task_ass() {
  let task_ass = $("input[name=task_ass_check]:checked").val();
  let task_name = $("input[name=task_ass_check]:checked").data("taskname");
  let task_src = $("input[name=task_ass_check]:checked").data("tasksrc");
  let subj_ass = $("#idass_subj").data("subj");
  let subj_name = $("#idass_subj").data("subjname");
  let grad_ass = $("#idass_grad").data("grad");
  let grad_name = $("#idass_grad").data("gradname");

  if (task_ass == undefined) {
    $("#select_qb_alert").removeClass("hide");
    setTimeout(function () {
      $("#select_qb_alert").addClass("hide");
    }, 5000);
  } else {
    $("input[name=selected_task]").val(task_name).attr("readonly", true);
    $("input[name=taskid]").val(task_ass);
    $("input[name=tasksrc]").val(task_src);
    $("input[name=selected_subj]")
      .val(subj_name + " - " + grad_name)
      .attr("readonly", true);
    $("input[name=subjid]").val(subj_ass);
    $("input[name=selected_grad]").val(grad_name).attr("readonly", true);
    $("input[name=gradid]").val(grad_ass);

    $("#modal_assessment").modal("show");
    set_datepicker();
    check_group(subj_ass, grad_ass);
  }
}

function set_datepicker() {
  $(".periode_date").flatpickr({
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    minDate: "today",
  });
}

function hide_modal() {
  // $("input[name=title]").val('');
  // $("select[name=subject]").val('');
  // $("select[name=grade]").val('');
  // $("#multiple-select-group").val(null).trigger("change");
  // $("#start_assessment").val('');
  // $("#end_assessment").val('');
  // $("input[name=timer]").val('');
  // $("#ass_random").toggleClass("checked");
  // $("#ass_cheat").toggleClass("checked");
  // $("#autosumbit").toggleClass("checked");
  // $("#instruction_assessment").html('');
  $("#modal_tasks_ch").modal("hide");
  $("#modal_assessment").modal("hide");
  $("#task_prev_ass").modal("hide");
}

function hide_modal_edit() {
  $("#modal_assessment_edit").modal("hide");
}

function check_group(subs, grad) {
  let groups = $("#multiple-select-group").select2();
  $.ajax({
    url: base_url + "/teacher/assessment/data-option",
    data: { subs, grad },
    method: "post",
    dataType: "json",
    success: function (e) {
      if (e) {
        let option = "";
        $.each(e, function (i, v) {
          option += `<option value="${v.id}">${v.name}</option>`;
        });
        groups.html(option);
      } else {
        groups.val(null).trigger("change");
        groups.attr("disabled", true);
      }
    },
  });
}

function view_task_assessment(id,src) {
  $.ajax({
    url: base_url + "/teacher/assessment/view-assessment-question",
    data: { id, src },
    method: "post",
    dataType: "json",
    success: function (e) {
      list_ass_question(e)
    },
  });
}

function list_ass_question(e) {
  let lists = '';
  $.each(e, function(i,v) {
    lists += `<a href="#" onclick="view_question(${v['id']})" class="m-1 btn btn-icon btn-outline btn-outline-primary btn-active-primary">${i+1}</a>`
  })
  $('#lists_questions').html(lists)
  $('#modal_look_question').modal('show')
}

$(document.body).on("click", ".asscheck", function () {
  $(this).toggleClass("checked");
});

$(document.body).on("click", "#ass_timer", function () {
  $("#c_timer").toggleClass("hide");
});

function chk_range() {
  let start = $("#start_assessment").val();
  let end = $("#end_assessment").val();

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

function save_assessment(status = null, save_type = null) {
  let id_ass = $("input[name=assessment_id]").val();
  let task_name = $("input[name=selected_task]").val();
  let subj_name = $("input[name=selected_subj]").val();
  let task = $("input[name=taskid]").val();
  let task_src = $("input[name=tasksrc]").val();
  let subj = $("input[name=subjid]").val();
  let grad = $("input[name=gradid]").val();
  let title = $("input[name=title]").val();
  let group = $("#multiple-select-group").select2("data");
  let start = $("#start_assessment").val();
  let end = $("#end_assessment").val();
  let timer = $("input[name=timer]").val();
  let istimer = $("#ass_timer").hasClass("checked");
  let random = $("#ass_random").hasClass("checked");
  let cheat = $("#ass_cheat").hasClass("checked");
  let submit = $("#autosumbit").hasClass("checked");
  let insass = $("#instruction_assessment > .ql-editor").html();

  let timer_sts = istimer ? (timer != 0 ? true : false) : true;
  let msg = ["title_ass", "group_ass", "start_ass", "end_ass", "timer_ass"];
  let chk = [title != "", group.length > 0, start != "", end != "", timer_sts];

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
    if (chk_range() == 1) {
      let data = [
        title,
        subj,
        grad,
        group,
        start,
        end,
        timer,
        random,
        cheat,
        submit,
        insass,
        task,
        task_name,
        subj_name,
        task_src,
        status,
        save_type,
      ];

      store_data(1, JSON.stringify(data), id_ass);
    } else {
      let msg =
        chk_range() == 2
          ? "Periode awal tidak boleh lebih besar dari periode akhir!"
          : "Periode awal tidak boleh lebih kecil dari hari ini!";
      $(".anom_period").html(msg).removeClass("hide");
      // al_swal('Periode tidak sesuai!', 'error')
    }
  }
}

function store_data(type, data, id = null) {
  $.ajax({
    url: base_url + "/teacher/assessment/store-data",
    data: { type, data, id },
    method: "post",
    dataType: "json",
    success: function (e) {
      $("#modal_assessment_edit").modal("hide");
      $("#modal_assessment").modal("hide");
      $("#task_prev_ass").modal("hide");
      reload_tabulator_ass();
      Toast.fire({
        icon: e.icn,
        title: e.msg,
      });
    },
  });
}

function edit_draft(id) {
  $.ajax({
    url: base_url + "/teacher/assessment/get-edit",
    data: { id },
    method: "post",
    dataType: "json",
    success: function (e) {
      check_group(e.assessment_subject_id, e.assessment_grade);
      set_datepicker();
      setTimeout(function () {
        view_edit(e);
      }, 1000);
    },
  });
}

function view_edit(e) {
  let task_title = ''
  if (e.assessment_question_bank_src != 2) {
    task_title = e.question_bank_standart_title
  } else {
    task_title = e.question_bank_title
  }
  
  $("input[name=assessment_id]").val(e.assessment_id);
  $("input[name=taskid]").val(e.assessment_question_bank_id);
  $("input[name=tasksrc]").val(e.assessment_question_bank_src);
  $("input[name=selected_task]").val(task_title);
  $("input[name=selected_subj]").val(e.subject_name + ' - Kelas ' + e.assessment_grade);
  $("input[name=subjid]").val(e.assessment_subject_id);
  $("input[name=gradid]").val(e.assessment_grade);
  $("input[name=title]").val(e.assessment_title);

  let selected_group = [];
  $.each(JSON.parse(e.assessment_group), function (i, v) {
    selected_group.push(v.id);
  });
  $("#multiple-select-group").val(selected_group).trigger("change");

  let start = e.assessment_start.substring(0, 16);
  let end = e.assessment_end.substring(0, 16);
  $("#start_assessment").val(start);
  $("#end_assessment").val(end);

  if (e.assessment_is_autosubmit == 1) {
    $("#autosumbit").addClass("checked").prop("checked", true);
  } else {
    $("#autosumbit").removeClass("checked").prop("checked", false);
  }

  if (e.assessment_duration > 1) {
    $("#ass_timer").addClass("checked").prop("checked", true);
    $("#c_timer").removeClass("hide").val(e.assessment_duration);
  } else {
    $("#ass_timer").removeClass("checked").prop("checked", false);
  }

  e.assessment_is_random == 1
    ? $("#ass_random").addClass("checked").prop("checked", true)
    : $("#ass_random").removeClass("checked").prop("checked", false);
  e.assessment_is_prevent_cheat == 1
    ? $("#ass_cheat").addClass("checked").prop("checked", true)
    : $("#ass_cheat").removeClass("checked").prop("checked", false);

  $("#instruction_assessment_edit > .ql-editor").html(e.assessment_instruction);

  $("#modal_assessment_edit").modal("show");
}

function type_assessment(type, ids, sts) {
  let msg = sts == 9 ? 'hapus' : sts == 2 ? 'terbitkan' : 'batalkan' 
  Swal.fire({
    html:
      sts == 2
        ? `Apakah anda yakin ${msg} ${ids.length} penilaian terpilih?`
        : `Apakah anda yakin ${msg} ${ids.length} penilaian terpilih?`,
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
      store_data(type, sts, ids);
    }
  });
}

function reload_tabulator_ass() {
  if (url.includes("assessment/index-draft")) {
    draft.replaceData();
    
  } else if (url.includes("assessment/index-scheduled")) {
    scheduled.replaceData();
  }
}

if (url.includes("teacher/assessment/index-draft")) {
  let c = [
    // { title: "#Aksi", field: "acts", width: 150, formatter: "html", headerVisible:false},
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    { title: "Akhir", field: "end_date", visible: false },
    { field: "lists", formatter: "html", headerFilter:"input", headerSort:false},
  ];

  tbconf.columns = c;
  var draft = new Tabulator("#ass_draft_table", tbconf);
} else if (url.includes("teacher/assessment/index-scheduled")) {
  let c = [
    { field: "lists", formatter: "html", headerFilter:"input", headerSort:false},
  ];

  tbconf.columns = c;
  var scheduled = new Tabulator("#ass_scheduled_table", tbconf);
} else if (url.includes("teacher/assessment/index-present")) {
  let c = [
    { field: "lists", formatter: "html", headerFilter:"input", headerSort:false},
  ];

  tbconf.columns = c;
  var present = new Tabulator("#ass_present_table", tbconf);
} else if (url.includes("teacher/assessment/index-done")) {
  let c = [
    { field: "lists", formatter: "html", headerFilter:"input", headerSort:false},
  ];

  tbconf.columns = c;
  var done = new Tabulator("#ass_done_table", tbconf);
} else if (url.includes("groups/view-students")) {
  let c = [
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    { field: "lists", formatter: "html", headerFilter:"input", headerSort:false},
  ];
  tbconf.selectableRows = false;
  tbconf.columns = c;
  var vstudent = new Tabulator("#student_group_view", tbconf);
} else if (url.includes("student/assessment/missed")){
  let c = [
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    { field: "lists", formatter: "html", headerFilter:"input", headerSort:false},
  ];
  tbconf.selectableRows = false;
  tbconf.columns = c;
  var ass_missed_table = new Tabulator("#ass_missed_table", tbconf);
} else if (url.includes("student/assessment/present")){
  let c = [
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    { field: "lists", formatter: "html", headerFilter:"input", headerSort:false},
  ];

  tbconf.columns = c;
  tbconf.selectableRows = false;
  var ass_present_table = new Tabulator("#ass_present_table", tbconf);
} else if (url.includes("student/assessment/done")){
  let c = [
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    { field: "lists", formatter: "html", headerFilter:"input", headerSort:false},
  ];
  tbconf.selectableRows = false;
  tbconf.columns = c;
  var ass_done_table = new Tabulator("#ass_done_table", tbconf);
}

if (url.includes("teacher/assessment")) {
  if (url.includes("assessment/index-draft")) {
    document
      .getElementById("select-all")
      .addEventListener("click", function () {
        draft.selectRow();
      });
  }
  if (url.includes("assessment/index-scheduled")) {
    document
      .getElementById("select-all")
      .addEventListener("click", function () {
        scheduled.selectRow();
      });
  }
  if (url.includes("assessment/index-draft")) {
    document
      .getElementById("deselect-all")
      .addEventListener("click", function () {
        draft.deselectRow();
      });
  }
  if (url.includes("assessment/index-scheduled")) {
    document
      .getElementById("deselect-all")
      .addEventListener("click", function () {
        scheduled.deselectRow();
      });
  }

  if (url.includes("assessment/index-draft")) {
    document
      .getElementById("publish-btn")
      .addEventListener("click", function () {
        let sel_data = draft.getSelectedData();
        let eds = sel_data.map((i) => i.end_date);
        let ids = sel_data.map((i) => i.id);
        if (ids.length < 1) {
          al_swal("Belum ada data terpilih", "error");
        } else {
          if (check_good_date(eds)) {
            al_swal("Tidak bisa diterbitkan karena terdapat data kedaluarsa", "error")
          } else {
            type_assessment(2, ids, 2);
          }
        }
      });
    
    document
      .getElementById("delete-btn")
      .addEventListener("click", function () {
        let sel_data = draft.getSelectedData();
        let ids = sel_data.map((i) => i.id);
        if (ids.length < 1) {
          al_swal("Belum ada data terpilih", "error");
        } else {
          type_assessment(2, ids, 9);
        }
      });
  }

  if (url.includes("assessment/index-scheduled")) {
    document
      .getElementById("unpublish-btn")
      .addEventListener("click", function () {
        let sel_data = scheduled.getSelectedData();
        let ids = sel_data.map((i) => i.id);
        if (ids.length < 1) {
          al_swal("Belum ada data terpilih", "error");
        } else {
          type_assessment(2, ids, 1);
        }
      });
  }
}

$(document).ready(function () {
  if (url.includes("assessment/index-add")) {
    var instruction_assessment = new Quill("#instruction_assessment", {
      modules: {
        toolbar: toolbarOptions,
      },
      theme: "snow", // or 'bubble'
    });
  } else if (url.includes("teacher/assessment/index-draft")) {
    var instruction_assessment_edit = new Quill(
      "#instruction_assessment_edit",
      {
        modules: {
          toolbar: toolbarOptions,
        },
        theme: "snow", // or 'bubble'
      }
    );
    draft.setData(base_url + "/teacher/assessment/list-assessment?page-ass=1");
  } else if (url.includes("teacher/assessment/index-scheduled")) {
    scheduled.setData(
      base_url + "/teacher/assessment/list-assessment?page-ass=2"
    );
  } else if (url.includes("teacher/assessment/index-present")) {
    present.setData(
      base_url + "/teacher/assessment/list-assessment?page-ass=3"
    );
  } else if (url.includes("teacher/assessment/index-done")) {
    done.setData(base_url + "/teacher/assessment/list-assessment?page-ass=4");
  } else if (url.includes("groups/view-students")) {
    gid = $("input[name=group_id]").val();
    vstudent.setData(base_url + "/teacher/groups/get-list-student?id=" + gid);
  } else if (url.includes("student/assessment/present")) {
    ass_present_table.setData(base_url + "/student/assessment/list-assessment?page-ass=1")
  } else if (url.includes("student/assessment/missed")) {
    ass_missed_table.setData(base_url + "/student/assessment/list-assessment?page-ass=2")
  } else if (url.includes("student/assessment/done")) {
    ass_done_table.setData(base_url + "/student/assessment/list-assessment?page-ass=3")
  }
});

function check_good_date(eds) {
  let curr = new Date();
  let result = [] 
  $.each(eds, function(i, v) {
    if (new Date(v) > curr) {
      result.push(true)
    } else {
      result.push(false)
    }
  });
  
  return result.includes(false)
}

// Begin Action Assessment
function alert_begin_assessment(assessment) {
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
        get_assessment(1, assessment)
    }
  });
}

function info_begin_assessment(e) {
  console.log(e.assessment_duration);
  
  let deg = e.teacher_degree != '' ? ', ' + e.teacher_degree : ''
  let name = e.teacher_first_name + ' ' + e.teacher_last_name + deg
  let timer = e.assessment_duration > 0 ? e.assessment_duration + ' Menit' : '-';
  let timer_note = e.assessment_duration > 0 ? e.assessment_duration + ' Menit atau ' : '';
  $('.title_assessment').html(e.assessment_title)
  $('.subject_assessment').html(e.subject_name)
  $('.teacher_assessment').html(name)
  $('.period_assessment').html(e.period)
  $('.duration_assessment').html(timer)
  $('.instruction_assessment').html(e.instruction)

  let auto_submit = e.assessment_is_autosubmit > 0 ? '<li>Ketika waktu mengerjakan sudah habis, maka jawaban akan terkirim secara otomatis.</li>' : '<li>Soal masih dapat dikerjakan walaupun waktu mengerjakan telah habis.</li>'

  let notes = `
    <ul>
      <li>Setelah selesai mengerjakan harus menekan tombol Submit untuk mengirimkan jawaban.</li>
      <li>Batas akhir mengerjakan ujian ini adalah ${timer_note}${e.end}.</li>
      ${auto_submit}
      <li>Ujian ini bersifat tutup buku (tidak boleh menutup atau meninggalkan halaman ujian).</li>
    </ul>
  `

  $('#assessment_notes').html(notes)
  $('#betin_assessment').html(`<button type="sumbit" class="btn btn-sm btn-primary ml-2" onclick="get_assessment(2, ${e.assessment_question_bank_id}, ${e.assessment_question_bank_src})">Mulai</button>`)
  $('#modal_assessment_information').modal('show')
}

function assessment_page(e) {
  $('#modal_assessment_information').modal('hide')
  $('#assessment_modal_question').modal('show')
}

function get_assessment(type, id, src=null) {
  $.ajax({
    url: base_url + "/student/assessment/get-assessment",
    data: { type, id, src },
    method: "post",
    dataType: "json",
    success: function (e) {
      if (type == 1) {
        info_begin_assessment(e)
      } else if (type == 2) {
        $('#modal_assessment_information').modal('hide')
        assessment_page(e)
      }
    },
  });
}


// function toggleFullScreen() {
//   if (!document.fullscreenElement &&    // alternative standard method
//       !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement ) {  // current working methods
//     if (document.documentElement.requestFullscreen) {
//       document.documentElement.requestFullscreen();
//     } else if (document.documentElement.msRequestFullscreen) {
//       document.documentElement.msRequestFullscreen();
//     } else if (document.documentElement.mozRequestFullScreen) {
//       document.documentElement.mozRequestFullScreen();
//     } else if (document.documentElement.webkitRequestFullscreen) {
//       document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
//     }
//   } else {
//     if (document.exitFullscreen) {
//       document.exitFullscreen();
//     } else if (document.msExitFullscreen) {
//       document.msExitFullscreen();
//     } else if (document.mozCancelFullScreen) {
//       document.mozCancelFullScreen();
//     } else if (document.webkitExitFullscreen) {
//       document.webkitExitFullscreen();
//     }
//   }
// }