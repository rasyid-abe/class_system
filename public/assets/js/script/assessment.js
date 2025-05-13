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
      beforeSend: function () {
        show_loading()
      },
      success: function (e) {
        preview_qb(e.res, subj, e.sub_name, grad, e.grd_name);
        hide_loading()
      },
    });
  }
}

function preview_qb(e, subj, subjname, grad, gradname) {
  let content = "";
  let i1 = 1;
  $.each(e, function (i, v) {
    // if (v.content.length > 0) {
    let ch1 = "";
    let i2 = 1;
    $.each(v.content, function (idx, val) {
      let child = "";
      let ii = 1;
      let chi = 1;
      $.each(val["child"], function (index, value) {
        let cch = "";

        $.each(value, function (a, b) {
          cch += `<a href="#" onclick="view_task(${i1}, ${b})" class="m-1 btn btn-icon btn-sm btn-outline btn-outline-primary">${chi}</a>`;
          chi++;
        });

        child += `
          <div style="margin-left: 8px; margin-bottom: 10px;" class="d-flex justify-content-start">
              ${cch}
          </div>
          `;
        ii++;
      });

      let child_body = `
          <ul class="list-group list-group-flush hide task_child" id="i${i1}${i2}">
            ${child}
          </ul>
        `;

      ch1 += `
          <div class="form-check my-2 form-switch form-check-custom form-check-solid" style="margin-left: 10px">
            <input class="form-check-input h-20px w-30px" type="radio" name="task_ass_check" data-taskrc=${v.src} data-taskname="${val.title}" value="${val.id}" />
            <label class="form-check-label head22" data-source="${i1}${i2}">
              ${val.title}
            </label>
          </div>
          ${val.child.length > 0 ? child_body : ''}    
          `;

      i2++;
    });

    let ch1_body = `
        <ul class="list-group list-group-flush hide head_head22 text-bold" id="i${i1}">
          ${ch1}
        </ul>
      `;

    content += `
            <li class="list-group-item bg-secondary parent1" data-source="${i1}"><h6 style="margin-top:5px">${v.head}</h6></li>
            ${v.content.length > 0 ? ch1_body : `<ul class="list-group list-group-flush hide task_child p-2" id="i${i1}">Soal tidak tersedia</ul>`}
        `;

    i1++;
    // }
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
  let task_src = $("input[name=task_ass_check]:checked").data("taskrc");
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
    $("input[name=syi]").val('T.P ' + active_year).attr("readonly", true);
    $("input[name=schoolyearid]").val(active_year_id);
    $("input[name=selected_task]").val(task_name).attr("readonly", true);
    $("input[name=taskid]").val(task_ass);
    $("input[name=taskrc]").val(task_src);
    $("input[name=selected_subj]")
      .val(subj_name + " - " + grad_name)
      .attr("readonly", true);
    $("input[name=subjid]").val(subj_ass);
    $("input[name=selected_grad]").val(grad_name).attr("readonly", true);
    $("input[name=gradid]").val(grad_ass);

    get_religion()
    set_datepicker();
    check_group(subj_ass, grad_ass);

    $("#modal_assessment").modal("show");
  }
}

function get_religion(reli = null) {

  let relig = $("#select_religion_test");
  $.ajax({
    url: base_url + "/teacher/assessment/get-list-religion",
    method: "post",
    dataType: "json",
    beforeSend: function () {
      show_loading()
    },
    success: function (e) {
      let option = "<option value=0>Pilih Agama</option>";
      $.each(e, function (i, v) {
        if (reli != null) {
          option += `<option value="${i}" ${reli == i ? 'selected' : ''}>${v}</option>`;
        } else {
          option += `<option value="${i}">${v}</option>`;
        }
      });
      relig.html(option);
      hide_loading()
    },
  });
}

function set_datepicker() {
  $(".periode_date").flatpickr({
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    minDate: "today",
  });
}

function clear_form_assessment() {
  $("input[name=title]").val('');
  $("select[name=subject]").val('');
  $("select[name=grade]").val('');
  $("#multiple-select-group").val(null).trigger("change");
  $("#start_assessment").val('');
  $("#end_assessment").val('');
  $(".inprand").html('<input class="form-check-input asscheck" name="random" id="ass_random" type="checkbox" value="1">');
  $(".inptime").html('<input class="form-check-input asscheck" name="ass_timer" id="ass_timer" type="checkbox" value="1">');
  $(".inpchea").html('<input class="form-check-input asscheck" name="cheat" id="ass_cheat" type="checkbox" value="2">');
  $(".inpsubm").html('<input class="form-check-input asscheck checked w-45px h-30px" type="checkbox" id="autosumbit" checked="true">');
  $(".inpreli").html('<input class="form-check-input asscheck" name="religion_assign" id="religion_assign" type="checkbox" value="1">');
  $("input[name=timer]").val('').addClass('hide');
  $("#instruction_assessment > .ql-editor").html('<p><br></p>');

  $('.end_ass').addClass('hide')
  $('.start_ass').addClass('hide')
  $('.group_ass').addClass('hide')
  $('.title_ass').addClass('hide')
  $('.timer_ass').addClass('hide')
  $('.selreli').addClass('hide')
  $('.reli_ass').addClass('hide')
}

function hide_modal() {
  clear_form_assessment()
  clear_form_task()

  $('#treeview_task__').html('')
  $("#task_prev_less").modal("hide");
  $("#modal_task_ch").modal("hide");
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
    beforeSend: function () {
      show_loading()
    },
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
      hide_loading()
    },
  });
}

function view_task_assessment(id, src) {
  // $(this).preventDefault()
  $.ajax({
    url: base_url + "/teacher/assessment/view-assessment-question",
    data: { id, src },
    method: "post",
    dataType: "json",
    beforeSend: function () {
      show_loading()
    },
    success: function (e) {
      list_ass_question(e)
      hide_loading()
    },
  });
}

function list_ass_question(e) {
  let lists = '';
  $.each(e, function (i, v) {
    lists += `<a href="#" onclick="view_question(${v['id']})" class="m-1 btn btn-icon btn-outline btn-outline-primary btn-active-primary">${i + 1}</a>`
  })
  $('#lists_questions').html(lists)
  $('#modal_look_question').modal('show')
}

$(document.body).on("click", ".asscheck", function () {
  $(this).toggleClass("checked");
});

$(document.body).on("click", "#religion_assign", function () {
  $(".selreli").toggleClass("hide");
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
  let task_src = $("input[name=taskrc]").val();
  let subj = $("input[name=subjid]").val();
  let grad = $("input[name=gradid]").val();
  let title = $("input[name=title]").val();
  let group = $("#multiple-select-group").select2("data");
  let start = $("#start_assessment").val();
  let end = $("#end_assessment").val();
  let timer = $("input[name=timer]").val();
  let istimer = $("#ass_timer").hasClass("checked");
  let isreli = $("#religion_assign").hasClass("checked");
  let random = $("#ass_random").hasClass("checked");
  let cheat = $("#ass_cheat").hasClass("checked");
  let submit = $("#autosumbit").hasClass("checked");
  let insass = $("#instruction_assessment > .ql-editor").html();
  let sch_year_id = $("input[name=schoolyearid]").val();
  let reli_sel = $('#select_religion_test').val();

  let timer_sts = istimer ? (timer != 0 ? true : false) : true;
  let reli_sts = isreli ? (reli_sel != 0 ? true : false) : true;

  let msg = ["title_ass", "group_ass", "start_ass", "end_ass", "timer_ass", "reli_ass"];
  let chk = [title != "", group.length > 0, start != "", end != "", timer_sts, reli_sts];

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
        istimer ? timer : 0,
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
        sch_year_id,
        reli_sel,
      ];

      clear_form_assessment()
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
    beforeSend: function () {
      show_loading()
    },
    success: function (e) {
      $("#modal_assessment_edit").modal("hide");
      $("#modal_assessment").modal("hide");
      $("#task_prev_ass").modal("hide");
      reload_tabulator_ass();
      Toast.fire({
        icon: e.icn,
        title: e.msg,
      });
      hide_loading()
    },
  });
}

function edit_draft(id) {
  $.ajax({
    url: base_url + "/teacher/assessment/get-edit",
    data: { id },
    method: "post",
    dataType: "json",
    beforeSend: function () {
      show_loading()
    },
    success: function (e) {
      check_group(e.assessment_subject_id, e.assessment_grade);
      set_datepicker();
      setTimeout(function () {
        view_edit(e);
      }, 1000);
      hide_loading()
    },
  });
}

function view_edit(e) {
  get_religion(parseInt(e.assessment_religion))
  let task_title = ''
  if (e.assessment_question_bank_src == 1) {
    task_title = e.question_bank_standart_title
  } else {
    task_title = e.question_bank_title
  }

  $("input[name=syi]").val('T.P ' + active_year).attr("readonly", true);
  $("input[name=schoolyearid]").val(active_year_id);
  $("input[name=assessment_id]").val(e.assessment_id);
  $("input[name=taskid]").val(e.assessment_question_bank_id);
  $("input[name=taskrc]").val(e.assessment_question_bank_src);
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

  if (parseInt(e.assessment_religion) > 0) {
    $("#religion_assign").addClass("checked").prop("checked", true);
    $(".selreli").removeClass("hide");
  } else {
    $("#religion_assign").removeClass("checked").prop("checked", false);
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
    { field: "lists", formatter: "html", headerFilter: "input", headerSort: false },
  ];

  tbconf.columns = c;
  var draft = new Tabulator("#ass_draft_table", tbconf);
} else if (url.includes("teacher/assessment/index-scheduled")) {
  let c = [
    { field: "lists", formatter: "html", headerFilter: "input", headerSort: false },
  ];

  tbconf.columns = c;
  var scheduled = new Tabulator("#ass_scheduled_table", tbconf);
} else if (url.includes("teacher/assessment/index-present")) {
  let c = [
    { field: "lists", formatter: "html", headerFilter: "input", headerSort: false },
  ];

  tbconf.columns = c;
  tbconf.selectableRows = false;
  var present = new Tabulator("#ass_present_table", tbconf);

  let cl = [
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    { field: "lists", formatter: "html", headerFilter: "input", headerSort: false },
  ]

  tbconf.columns = cl
  tbconf.selectableRows = false;
  var student_act = new Tabulator('#ass_student_act', tbconf)
} else if (url.includes("teacher/assessment/index-done")) {
  let c = [
    { field: "lists", formatter: "html", headerFilter: "input", headerSort: false },
  ];

  tbconf.columns = c;
  tbconf.selectableRows = false;
  var done = new Tabulator("#ass_done_table", tbconf);

  let cl = [
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    { field: "lists", formatter: "html", headerFilter: "input", headerSort: false },
  ]

  tbconf.columns = cl;
  tbconf.selectableRows = false;
  var student_act = new Tabulator('#ass_student_act', tbconf)
} else if (url.includes("groups/view-students")) {
  let c = [
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    { field: "lists", formatter: "html", headerFilter: "input", headerSort: false },
  ];
  tbconf.selectableRows = false;
  tbconf.columns = c;
  var vstudent = new Tabulator("#student_group_view", tbconf);
} else if (url.includes("student/assessment/missed")) {
  let c = [
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    { field: "lists", formatter: "html", headerFilter: "input", headerSort: false },
  ];
  tbconf.selectableRows = false;
  tbconf.columns = c;
  var ass_missed_table = new Tabulator("#ass_missed_table", tbconf);
} else if (url.includes("student/assessment/present")) {
  let c = [
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    { field: "lists", formatter: "html", headerFilter: "input", headerSort: false },
  ];

  tbconf.columns = c;
  tbconf.selectableRows = false;
  var ass_present_table = new Tabulator("#ass_present_table", tbconf);
} else if (url.includes("student/assessment/done")) {
  let c = [
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    { field: "lists", formatter: "html", headerFilter: "input", headerSort: false },
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

function close_view_assess_student() {
  $('#modal_look_student_act_assessment').modal('hide')
  $('#bd_list_ass_student').html('<div id="ass_student_act"></div>')

  let cl = [
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    { field: "lists", formatter: "html", headerFilter: "input", headerSort: false },
  ]

  tbconf.columns = cl;
  tbconf.selectableRows = false;
  student_act = new Tabulator('#ass_student_act', tbconf)

  // if (url.includes("dashboard/teacher")) {
    
  // }
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
  $.each(eds, function (i, v) {
    if (new Date(v) > curr) {
      result.push(true)
    } else {
      result.push(false)
    }
  });

  return result.includes(false)
}

$(document).on('click', '.view_student', function (e) {
  e.preventDefault()
  let assessment_id = $(this).data('assessment_id')
  let group_id = $(this).data('group_id')
  let title = $(this).data('title')

  $('#title_ass_lsstd').html(`<span class="text-primary">${title}</span>`)
  student_act.setData(
    base_url + "/teacher/assessment/get-student-assessment?aid=" + assessment_id + "&gid=" + group_id
  );

  $('#modal_look_student_act_assessment').modal('show')
})

function data_result_student(result_id) {
  $.ajax({
    url: base_url + "/teacher/assessment/check-result-assessment",
    data: { result_id },
    method: "post",
    dataType: "json",
    beforeSend: function () {
      show_loading()
    },
    success: function (e) {
      $('#checking_title').html(e.student_name)
      $('#checking_subtitle2').html(e.assessment_title)
      $('#modal_look_student_act_assessment').modal('hide')
      $('#btn_submit_checking').val(e.student_id)
      $('#result_id').val(e.result_id)
      $('#stu_id').val(e.student_id)
      $('#asse_id').val(e.assessment_id)
      checking_page(e)
      hide_loading()
    },
  });
}

function checking_page(e = null) {
  let my_assessment = localStorage.getItem(e.key)
  if (!my_assessment) {
    if (e.value) {
      localStorage.setItem(e.key, JSON.stringify(e.value))

      my_assessment = localStorage.getItem(e.key)
      actview_checking(e.student_id, my_assessment, 0, false)
      $('#checking_modal_question').modal('show')
    }
  } else {
    actview_checking(e.student_id, my_assessment, 0, false)
    $('#checking_modal_question').modal('show')
  }
}

function act_close_chkmdl() {
  $('#checking_modal_question').modal('hide')
  $('#modal_look_student_act_assessment').modal('show')

  let asse_id = $('#asse_id').val()
  let sid = $('#btn_submit_checking').val()
  let key = 'limecode_' + teacher_id + '_' + sid + '_' + asse_id;

  localStorage.removeItem(key)
}

function close_checking_modal(type = 1) {
  if (type == 1) {
    Swal.fire({ 
      html: `<h3>Anda yakin menutup halaman pemeriksaan?</h3><br><p>Anda akan kehilahan data pemeriksaan jika menutup halamana ini.</p>`,
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
        act_close_chkmdl()
      }
    });
  } else {
    act_close_chkmdl()
    if (url.includes("dashboard/teacher")) {
      ajax_dash_teacher()
    }
  }

}

function actview_checking(sid, e, idx = 0, fix = false) {
  let data = JSON.parse(e)
  $('#checking_title').html(data.title)
  $('#checking_subtitle').html(data.subject)

  let number_quest = ''
  let num = 1
  $.each(data.assessment, function (i, v) {
    let btnn = ''
    if (!fix) {
      if (num > 1) {
        if (v.checked != 0) {
          btnn = 'btn-success iss'
        } else {
          btnn = 'btn-outline btn-outline-dark'
        }
      } else {
        btnn = v.checked != 0 ? 'btn-primary iss' : 'btn-primary'
      }
    } else {
      if (idx == v.question_id) {
        btnn = v.checked != 0 ? 'btn-primary iss' : 'btn-primary'
      } else {
        if (v.checked != 0) {
          btnn = 'btn-success iss'
        } else {
          btnn = 'btn-outline btn-outline-dark'
        }
      }
    }

    number_quest += `<a href="#" onclick="view_question_act_chk(${v.question_id}, ${sid})" class="m-1 btn btn-icon  ${btnn} actbtn">${num}</a>`
    num++
  })

  if (!fix) {
    if (idx > 0) {
      view_question_act_chk(Object.keys(data.assessment[idx]), sid)
    } else {
      view_question_act_chk(Object.keys(data.assessment)[0], sid)
    }
  }

  let nquest = `
    <div class="alert bg-light border border-primary" style="min-height: 450px;">
    <span class="d-block fw-semibold text-start py-2 px-3">
    <span class="fw-bold d-block fs-3 text-primary mb-2">Nomor Soal</span>
    ${number_quest}
    </div>
  `
  $('#list_questions').html(nquest);
}

function view_question_act_chk(id, sid) {
  $('#check_answer_essay').html('')
  $('#checkpoin').html('')

  let asse_id = $('#asse_id').val()

  let my_assessment = localStorage.getItem('limecode_' + teacher_id + '_' + sid + '_' + asse_id)
  let data = JSON.parse(my_assessment)
  
  let row = data.assessment[id]
  let qtype = data.assessment[id].type
  let spoin = data.assessment[id].res_poin
  let poin = data.assessment[id].poin
  let student_answer = data.assessment[id].student_answer
  let right_answer = JSON.parse(data.assessment[id].right_answer)
  let nchk = data.assessment[id].note_check
  let ischk = data.assessment[id].checked

  
  
  let tpoint = 0;
  $.each(data.assessment, function(i,v) {
    tpoint += parseFloat(v.res_poin)
  })

  let question = `
    <div class="alert bg-light-info border border-info d-flex flex-column flex-sm-row mb-5">
      <span class="d-block fw-semibold text-start py-2 px-3">
        <span class="fw-bold d-block fs-3 text-info mb-2">Pertanyaan</span>
        <span class="fw-bold fs-3 text-info">
          ${row.question}
        </span>
      </span>
    </div>
  `;

  let option = ''
  let num = 1
  let type = qtype == 2 ? 'checkbox' : 'radio'
  
  let saws = null;
  if (qtype == 3) {
    saws = student_answer[0].map(function (x) {return parseInt(x, 10)})
  } else {
    saws = student_answer[0]
  }
  
  $.each(row.option, function (i, v) {     
    let btn_cls = 'btn-outline btn-outline-primary'
    if (saws.includes(v)) {
      if (right_answer.includes(v)) {
        btn_cls = 'btn-success'
      } else {
        btn_cls = 'btn-warning'
      }
    } else if (right_answer.includes(v)) {
      btn_cls = 'btn-primary'
    }

    let opt_val = row.type == 3 ? (v == "1" ? 'Benar' : 'Salah') : v
    option += `
    <div class="col-sm-6">
      
      <label class="btn ${btn_cls} p-7 d-flex align-items-center mb-5" for="kt_choose_${num}">
        <span class="d-block fw-semibold text-start">
          <span class="fw-bold d-block fs-3 mb-2">Pilihan Jawaban ${num}</span>
          <span class="fs-3">${opt_val}</span>
        </span>
      </label>
    </div>
    `
    num++;
  })

  $('#check_question').html(question)
  let setpoin = ''
  let colorcode = ''
  if (qtype < 4) {
    $('#check_answer_essay').html('')
    $('#check_answer').html(`<div class="row">${option}</div>`)

  //   colorcode = `
  //   <div id="code_color my-2" style="margin-top: 10px;">
  //     <span class="fw-bold d-block fs-3 text-primary mb-2">Kode Warna</span>
  //     <span class="btn btn-sm btn-warning">Jawaban Siswa</span><br>
  //     <span class="btn btn-sm btn-primary my-2">Jawaban Benar</span><br>
  //     <span class="btn btn-sm btn-success">Jawaban Tepat</span>
  //   </div>
  // `
  } else {
    $('#check_answer').html('')
    
    let formspoin = ''
    if (ischk == 1) {
      formspoin = `<input type="number" min="0" max="${poin}" class="form-control" id="percent_essay_poin" placeholder="Persen jawaban benar" value="${parseInt(spoin*100)}" onchange="setpercent(${id}, ${poin}, ${sid}, ${tpoint})" style="border: 2px solid #5014D0">`
    } else {
      formspoin = `<input type="number" min="0" max="${poin}" class="form-control" id="percent_essay_poin" placeholder="Persen jawaban benar" onchange="setpercent(${id}, ${poin}, ${sid}, ${tpoint})" style="border: 2px solid #5014D0">`
    }

    setpoin = `
      <span class="fw-bold d-block fs-3 text-primary mb-2">Nilai</span>
      <div class="d-flex justify-content-between">
        <div class="input-group" style="width: 100%">
          ${formspoin}
          <button class="btn btn-primary btn_vlchk" data-key="${id}" data-poin="${poin}" data-sid="${sid}" data-val="0" type="button">0</button>
          <button class="btn btn-primary btn_vlchk" data-key="${id}" data-poin="${poin}" data-sid="${sid}" data-val="25" type="button">25</button>
          <button class="btn btn-primary btn_vlchk" data-key="${id}" data-poin="${poin}" data-sid="${sid}" data-val="50" type="button">50</button>
          <button class="btn btn-primary btn_vlchk" data-key="${id}" data-poin="${poin}" data-sid="${sid}" data-val="75" type="button">75</button>
          <button class="btn btn-primary btn_vlchk" data-key="${id}" data-poin="${poin}" data-sid="${sid}" data-val="100" type="button">100</button>
        </div>
      </div>
      <p class="text-danger err_poin hide">Nilai maksimal dibatasi hanya 100!</p>
      `

    let essay = `
    <div class="alert bg-light-dark border border-dark d-flex flex-column flex-sm-row mb-5">
      <span class="d-block fw-semibold text-start py-2 px-3">
        <span class="fw-bold d-block fs-3 text-dark mb-2">Jawaban Uraian</span>
        <span class="fw-semibold fs-3 text-dark">
          ${student_answer}
        </span>
      </span>
    </div>
    `;
    $('#check_answer_essay').html(essay)
  }

  let checkpoin = `
  <div class="alert bg-light border border-primary">
    <span class="d-block fw-semibold text-start py-2 px-3">
      <div class="d-flex justify-content-between mb-3">
        <badge class="badge badge-info fs-3 p-5">Poin : ${poin}<span class="fw-bold fs-6">/${spoin}</span></badge>
        <badge class="badge badge-success fs-3 p-5"><b id="allpoint">Total Poin : ${tpoint % 1 == 0 ? tpoint : tpoint.toFixed(2)}</b></badge>
        <input type="hidden" name="allpoint" value="${tpoint}"/>
      </div>
      ${setpoin}
      <span class="fw-bold d-block fs-3 text-primary my-2 ">Catatan</span>
      <div id="checked_note"></div>
      ${colorcode}
    </span>
  </div>  
  `;

  var Delta = Quill.import('delta');
  $('#checkpoin').html(checkpoin)
  var checked_note = new Quill("#checked_note", {
    modules: {
      toolbar: toolbarOptions,
    },
    theme: "snow", // or 'bubble'
  });

  var change = new Delta();
  checked_note.on('text-change', function (delta) {
    autosave_check_note(id, sid)
    change = change.compose(delta);
  });

  $("#checked_note > .ql-editor").html(nchk != '' ? nchk : '<p><br></p>');
}

function autosave_check_note(key, sid) {
  let note = $("#checked_note > .ql-editor").html()
  update_localstorage_chk(sid, 'check_note', key, note)
}

function setpercent(key, val, sid, tpoint) {
  spoin = $('#percent_essay_poin').val();
  if (spoin <= 100) {
    let nval = spoin * val / 100;
  
    let newpoint = parseFloat(tpoint) + parseFloat(nval)
    $('#allpoint').html('Total Poin : ' + newpoint)
  
    update_localstorage_chk(sid, 'checking', key, nval)
    $('.err_poin').addClass('hide')
  } else {
    $('.err_poin').removeClass('hide')
  }
}

$(document).on('click', '.btn_vlchk', function (e) {
  e.preventDefault()
  let val = $(this).data('val')
  let sid = $(this).data('sid')
  let key = $(this).data('key')
  let poin = $(this).data('poin')
  let allpoint = $('input[name=allpoint]').val()
  
  let nval = val * poin / 100;
  let newpoint = parseFloat(allpoint) + parseFloat(nval)
  
  $('#percent_essay_poin').val(parseFloat(val))
  $('#allpoint').html('Total Poin : ' + newpoint)

  update_localstorage_chk(sid, 'checking', key, nval)
})

function update_localstorage_chk(sid, type, key, value = null) {
  let asse_id = $('#asse_id').val()
  let key_storage = 'limecode_' + teacher_id + '_' + sid + '_' + asse_id;
  let my_data = JSON.parse(localStorage.getItem(key_storage))
  
  if (type == 'checking') {
    // let chk = value > 0 ? 1 : 0;
    my_data.assessment[key].student_poin = value
    my_data.assessment[key].res_poin = value
    my_data.assessment[key].checked = 1
    localStorage.setItem(key_storage, JSON.stringify(my_data))

    let res_data = localStorage.getItem(key_storage)
    view_question_act_chk(key, sid)
    actview_checking(sid, res_data, key, true)
  } else if (type == 'check_note') {
    let notes = value != '<p><br></p>' ? value : "";
    my_data.assessment[key].note_check = notes

    localStorage.setItem(key_storage, JSON.stringify(my_data))   
  }
}

$('#btn_submit_checking').on('click', function() {
  let sid = $(this).val()
  let resid = $('#result_id').val()
  let asse_id = $('#asse_id').val()

  let key_storage = 'limecode_' + teacher_id + '_' + sid + '_' + asse_id;
  let my_data = JSON.parse(localStorage.getItem(key_storage))
  
  let status_checked = [];
  $.each(my_data.assessment, function(i,v) {
    if (v.checked == 1) {
      status_checked.push(true)
    } else {
      status_checked.push(false)
    }
  })

  if (status_checked.includes(false)) {
    toast_act('Gagal!','Masih ada yang belum diperiksa!', 'error')
  } else {
    submit_checking_act(my_data, resid, key_storage)
  }
  
})

function submit_checking_act(e, res, key)
{
  let result = e.assessment
  $.ajax({
    url: base_url + "/teacher/assessment/submit-check-assessment",
    data: { res, result },
    method: "post",
    dataType: "json",
    beforeSend: function () {
      show_loading()
    },
    success: function (e) {
      if (e.sts) {
        // localStorage.removeItem(key)
        close_checking_modal(2)
      }
      toast_act('', e.msg, e.icn)
      hide_loading()

    },
  });
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
  let deg = e.teacher_degree != '' ? ', ' + e.teacher_degree : ''
  let name = e.teacher_first_name + ' ' + e.teacher_last_name + deg
  let timer = e.assessment_duration > 0 ? e.assessment_duration + ' Menit' : '-';
  let timer_note = e.assessment_duration > 0 ? 'atau timer selama ' + e.assessment_duration + ' Menit' : '';
  $('.title_assessment').html(e.assessment_title)
  $('.subject_assessment').html(e.subject_name)
  $('.teacher_assessment').html(name)
  $('.period_assessment').html(e.period)
  $('.duration_assessment').html(timer)
  $('.instruction_assessment').html(e.instruction)
  $('.source_question_bank').html(e.assessment_question_bank_src)
  $('.end_time').html(e.end_time)
  $('.timer').html(e.assessment_duration)
  $('.autosubmit').html(e.assessment_is_autosubmit)
  $('.random').html(e.assessment_is_random)
  $('.no_cheat').html(e.assessment_is_prevent_cheat)
  $('.assesst_id').html(e.assessment_id)
  $('.sch_year_id').html(e.assessment_school_year_id)

  let allow_cheat = e.assessment_is_prevent_cheat > 0 ? '<li>Ujian ini bersifat tutup buku (tidak boleh menutup atau meninggalkan halaman ujian)</li>' : ''
  let auto_submit = e.assessment_is_autosubmit > 0 ? '<li>Ketika waktu mengerjakan sudah habis, maka jawaban akan terkirim secara otomatis.</li>' : ''

  let notes = `
    <ul>
      <li>Setelah selesai mengerjakan harus menekan tombol Submit untuk mengirimkan jawaban</li>
      <li>Batas akhir mengerjakan ujian ini adalah ${e.end} ${timer_note}</li>
      ${auto_submit}
      ${allow_cheat}
    </ul>
  `

  $('#assessment_notes').html(notes)
  $('#betin_assessment').html(`<button type="sumbit" class="btn btn-sm btn-primary ml-2" onclick="get_assessment(2, ${e.assessment_question_bank_id})">Mulai</button>`)
  $('#modal_assessment_information').modal('show')
}

function reload_assessment() {
  if (url.includes("student")) {
    let ls = Object()
    ls.key = 'redcode_' + student_id
    assessment_page(ls);
  }
}

function assessment_page(e = null) {
  let my_assessment = localStorage.getItem(e.key)
  if (!my_assessment) {
    if (e.value) {
      localStorage.setItem(e.key, JSON.stringify(e.value))

      let timer = localStorage.getItem('tmr_' + student_id)
      let tim = parseInt(e.value.timer)
      if (tim > 0) {
        if (!timer) {
          let end = new Date(e.value.end_date)
          let beg = new Date(e.value.begin_assign)

          Date.prototype.addMins = function (m) {
            this.setTime(this.getTime() + (m * 60 * 1000));
            return this;
          }

          beg.addMins(tim);

          if (beg > end) {
            localStorage.setItem('tmr_' + student_id, end.getTime())
          } else {
            localStorage.setItem('tmr_' + student_id, beg.getTime())
          }

        }
      }

      my_assessment = localStorage.getItem(e.key)
      actview_assessment(my_assessment)
      $('#modal_assessment_information').modal('hide')
      $('#assessment_modal_question').modal('show')
    }
  } else {
    actview_assessment(my_assessment)
    $('#assessment_modal_question').modal('show')
  }


}

window.onblur = function () {
  let row = JSON.parse(localStorage.getItem('redcode_' + student_id))
  if (row) {
    if (parseInt(row.no_cheat) > 0) {
      let allow_cheat = 5
      let rcop = JSON.parse(localStorage.getItem('redcode_' + student_id))
      if (rcop) {
        let cheat = rcop.fault
        change_localstorage('fault', 0, cheat + 1)

        Swal.fire({
          icon: "error",
          html: `<h2>Oops...</h2><br><p>Anda membuat <b>${cheat + 1} kesalahan</b> karena meinggalkan halaman penilaian!</p><br><p>Toleransi kesalahan maksimal ${allow_cheat} kali.</p>`,
          confirmButtonText: "Ya, Saya Mengerti",
        })

        if (allow_cheat <= cheat + 1) {
          submit_assessment_act(2, 'Melakukan kesalahan sebanyak ' + allow_cheat + ' kali.')
        }
      }
    }
  }
};

function alert_submit_assessment() {
  Swal.fire({
    html: `<h2>Apakah anda yakin?</h2><br><p>Jika sudah dikirimkan, maka tidak dapat mengubah atau mengulang penilaian yang sama.</p>`,
    icon: "warning",
    buttonsStyling: false,
    showCancelButton: true,
    confirmButtonText: "Ya, Kirimkan",
    cancelButtonText: "Periksa Kembali",
    customClass: {
      confirmButton: "btn btn-sm btn-primary",
      cancelButton: "btn btn-sm btn-info",
    },
  }).then(function (confirm) {
    if (confirm.isConfirmed) {
      submit_assessment_act(1, 'Menekan tombol submit')
    }
  });
}

function actview_assessment(e, idx = 0, fix = false) {
  runtimer()
  let data = JSON.parse(e)
  $('#mdltitle').html(data.assessment_title)
  $('#sbtl').html(data.subject)

  let number_assest = ''
  let num = 1
  $.each(data.assessment, function (i, v) {
    let btnn = ''
    if (!fix) {
      if (num > 1) {
        if (v.student_answer != '[]') {
          btnn = 'btn-success iss'
        } else {
          btnn = 'btn-outline btn-outline-dark'
        }
      } else {
        btnn = v.student_answer != '[]' ? 'btn-primary iss' : 'btn-primary'
      }
    } else {
      if (idx == v.question_id) {
        btnn = v.student_answer != '[]' ? 'btn-primary iss' : 'btn-primary'
      } else {
        if (v.student_answer != '[]') {
          btnn = 'btn-success iss'
        } else {
          btnn = 'btn-outline btn-outline-dark'
        }
      }
    }

    number_assest += `<a href="#" onclick="view_question_act(${v.question_id})" class="m-1 btn btn-icon  ${btnn} actbtn">${num}</a>`
    num++
  })

  if (!fix) {
    if (idx > 0) {
      view_question_act(Object.keys(data.assessment[idx]))
    } else {
      view_question_act(Object.keys(data.assessment)[0])
    }
  }

  let nquest = `
    <div class="alert bg-light border border-dark" style="min-height: 450px;">
    <span class="d-block fw-semibold text-start py-2 px-3">
    <span class="fw-bold d-block fs-3 text-dark mb-2">Nomor Soal</span>
    ${number_assest}
    </div>
  `
  $('#list_assact').html(nquest);
}

function view_question_act(id) {
  let my_assessment = localStorage.getItem('redcode_' + student_id)
  let data = JSON.parse(my_assessment)
  
  let row = data.assessment[id]
  let qtype = data.assessment[id].type
  let student_answer = data.assessment[id].student_answer

  let question = `
    <div class="alert bg-light-dark border border-dark d-flex flex-column flex-sm-row mb-5">
      <span class="d-block fw-semibold text-start py-2 px-3">
        <span class="fw-bold d-block fs-3 text-dark mb-2">Pertanyaan</span>
        <span class="fw-semibold fs-3 text-dark">
          ${row.question}
        </span>
      </span>
    </div>
  `;

  let option = ''
  let num = 1
  let type = qtype == 2 ? 'checkbox' : 'radio'
  $.each(row.option, function (i, v) {
    let opt_val = row.type == 3 ? (v == 1 ? 'Benar' : 'Salah') : v
    let is_choose = student_answer.includes(i) ? 'chk_act_ass' : ''
    let is_checked = student_answer.includes(i) ? 'checked="checked"' : ''

    option += `
    <div class="col-sm-6">
      <input type="${type}" data-question_id="${id}" data-type="${type}" class="btn-check tglchk ${is_choose}" ${is_checked} name="choose_opt" value="${i}" id="kt_choose_${num}" />
      <label class="btn btn-outline btn-outline-primary p-7 d-flex align-items-center mb-5" for="kt_choose_${num}">
        <span class="d-block fw-semibold text-start">
          <span class="fw-bold d-block fs-3 mb-2">Pilihan Jawaban ${num}</span>
          <span class="fs-3">${opt_val}</span>
        </span>
      </label>
    </div>
    `
    num++;
  })

  $('#actass_question').html(question)
  if (qtype < 4) {
    $('#actass_essay_answer').html('')
    $('#actass_option').html(`<div class="row">${option}</div>`)
  } else if (qtype == 4) {
    $('#actass_option').html('')
    $('#actass_essay_answer').html(`
      <div id="essay_answer" class="ansessay" data-id="${id}"></div>
    `)
      // <button class="btn btn-sm btn-success mt-4 save_esans" data-id="${id}">Simpan Jawaban</button>

    var Delta = Quill.import('delta');
    var essay_answer = new Quill("#essay_answer", {
      modules: {
        toolbar: toolbarOptions,
      },
      theme: "snow", // or 'bubble'
    });

    var change = new Delta();
    essay_answer.on('text-change', function (delta) {
      autosave_essay()
      change = change.compose(delta);
    });
  }

  if (qtype == 4) {
    let sans = data.assessment[id].student_answer
    if (sans != "[]") {
      $("#essay_answer > .ql-editor").html(sans);
    }

  }
}

function autosave_essay() {
  let id = $('#essay_answer').data('id')
  if (id != undefined) {
    let my_assessment = localStorage.getItem('redcode_' + student_id)
    let data = JSON.parse(my_assessment)
    let qtype = data.assessment[id].type
    if (qtype == 4) {
      let ans = $("#essay_answer > .ql-editor").html()

      rans = ans == '<p><br></p>' ? "[]" : ans;
      change_localstorage('essay', id, rans, true)
    }
  }
}

$(document).on('click', '.save_esans', function () {
  let id = $(this).data('id')
  let ans = $("#essay_answer > .ql-editor").html()
  rans = ans == '<p><br></p>' ? "[]" : ans;

  change_localstorage('essay', id, rans)
})

$(document).on('click', '.tglchk', function () {
  let question_id = $(this).data('question_id')
  let quest_type = $(this).data('type')

  if (quest_type != 'radio') {
    $(this).toggleClass("chk_act_ass");
  } else {
    if ($(this).hasClass('chk_act_ass')) {
      $(this).removeClass('chk_act_ass')
    } else {
      $(".tglchk").each(function () {
        if ($(this).hasClass("chk_act_ass")) {
          $(this).removeClass("chk_act_ass");
        }
      });
      $(this).toggleClass('chk_act_ass');
    }
  }

  change_localstorage('option', question_id)
})

function change_localstorage(type, key, value = null, stay = false) {
  let key_storage = 'redcode_' + student_id
  let my_data = JSON.parse(localStorage.getItem(key_storage))

  if (type == 'option') {
    let my_choose = []
    $(".tglchk").each(function () {
      if ($(this).hasClass('chk_act_ass')) {
        my_choose.push($(this).val())
      }
    })
    localStorage.setItem('rcop_' + student_id, JSON.stringify(my_choose))
    let rcop = localStorage.getItem('rcop_' + student_id)

    my_data.assessment[key].student_answer = rcop
    localStorage.setItem(key_storage, JSON.stringify(my_data))

    let res_data = localStorage.getItem(key_storage)
    view_question_act(key)
    actview_assessment(res_data, key, true)
  } else if (type == 'essay') {
    my_data.assessment[key].student_answer = value
    localStorage.setItem(key_storage, JSON.stringify(my_data))

    let res_data = localStorage.getItem(key_storage)
    actview_assessment(res_data, key, true)
    if (!stay) {
      view_question_act(key)
    }
  } else if (type == 'fault') {
    my_data.fault = value
    localStorage.setItem(key_storage, JSON.stringify(my_data))
  }
}

function get_assessment(type, id, src = null) {
  if (type == 2) {
    src = [
      document.querySelector('.title_assessment').innerHTML,
      document.querySelector('.subject_assessment').innerHTML,
      document.querySelector('.end_time').innerHTML,
      document.querySelector('.timer').innerHTML,
      document.querySelector('.autosubmit').innerHTML,
      document.querySelector('.random').innerHTML,
      document.querySelector('.no_cheat').innerHTML,
      document.querySelector('.source_question_bank').innerHTML,
      document.querySelector('.assesst_id').innerHTML,
      document.querySelector('.sch_year_id').innerHTML,
    ];
  }

  $.ajax({
    url: base_url + "/student/assessment/get-assessment",
    data: { type, id, src },
    method: "post",
    dataType: "json",
    beforeSend: function () {
      show_loading()
    },
    success: function (e) {
      if (type == 1) {
        info_begin_assessment(e)
      } else if (type == 2) {
        $('#modal_assessment_information').modal('hide')
        assessment_page(e)
      }
      hide_loading()
    },
  });
}

function submit_assessment_act(submit_type, submit_msg) {
  let row = JSON.parse(localStorage.getItem('redcode_' + student_id))
  let msg_submit = submit_msg != 1 ? submit_msg : 'Menekan tombol submit'

  let send = Object()
  send.assessment_id = row.assessment_id
  send.subject = row.subject
  send.assessment_title = row.assessment_title
  send.fault = row.fault
  send.msg_submit = msg_submit
  send.submit_type = submit_type
  send.source_qb = row.source_qb
  send.qb_parent_id = row.qb_parent_id
  send.begin_assign = row.begin_assign
  send.end_date = row.end_date
  send.sch_year_id = row.sch_year_id

  let student_answer = []
  $.each(row.assessment, function (i, v) {
    if (v.type != 4) {
      let answer = []
      $.each(JSON.parse(v.student_answer), function (idx, val) {
        answer.push(v.option[val])
      })

      student_answer.push({
        question_id: v.question_id,
        question_type: v.type,
        answer: v.student_answer != '[]' ? answer : ['empty']
      })
      send.answer = student_answer
    } else {
      student_answer.push({
        question_id: v.question_id,
        question_type: v.type,
        answer: v.student_answer != '[]' ? v.student_answer : ['empty']
      })
      send.answer = student_answer
    }
  })

  $.ajax({
    url: base_url + "/student/assessment/submit-assessment",
    data: { send },
    method: "post",
    dataType: "json",
    beforeSend: function () {
      show_loading()
    },
    success: function (e) {
      $('.assessment_modal_act').modal('hide')
      if (e.sts) {
        Swal.fire({
          icon: e.icn,
          html: e.msg,
          confirmButtonText: "OK",
        })
        localStorage.removeItem('redcode_' + student_id)
        localStorage.removeItem('rcop_' + student_id)
        localStorage.removeItem('tmr_' + student_id)

        // ajax_dash_student()
      } else {
        Swal.fire({
          icon: e.icn,
          html: e.msg,
          confirmButtonText: "Kirim Ulang",
        }).then(function (confirm) {
          location.reload()
        })
      }
      hide_loading()

    },
  });
}

$(document).on("click", ".actbtn", function (e) {
  e.preventDefault();
  $(".actbtn").each(function () {
    if ($(this).hasClass("btn-primary")) {
      $(this).removeClass("btn-primary");
      if ($(this).hasClass('iss')) {
        $(this).addClass("btn-success");
      } else {
        $(this).addClass("btn-outline btn-outline-primary");
      }
    }
  });
  if ($(this).hasClass('btn-success')) {
    $(this).addClass("btn-primary");
    $(this).removeClass("btn-success");
  } else {
    $(this).addClass("btn-primary");
    $(this).removeClass("btn-outline btn-outline-primary");
  }
});

function runtimer() {
  let timer = localStorage.getItem('tmr_' + student_id)
  if (timer) {
    let countDownDate = timer;

    let x = setInterval(function () {
      let now = new Date().getTime();
      let distance = countDownDate - now;

      let days = Math.floor(distance / (1000 * 60 * 60 * 24));
      let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      let seconds = Math.floor((distance % (1000 * 60)) / 1000);

      document.getElementById("left_time_assessment").innerHTML = "Sisa Waktu : " + hours + " Jam "
        + minutes + " Menit " + seconds + " Detik";

      if (distance < 0) {
        document.getElementById("left_time_assessment").innerHTML = "EXPIRED";
        clearInterval(x);
        submit_assessment_act(3, 'Waktu habis')
      } else if (minutes < 15) {
        $('#left_time_assessment').removeClass('hide')
      }
    }, 1000);

  }
}

// let cl = [
//   { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
//   { field: "lists", formatter: "html", headerFilter: "input", headerSort: false },
// ]

// tbconf.columns = cl
// tbconf.selectableRows = false;
// var student_act = new Tabulator('#ass_student_act', tbconf)