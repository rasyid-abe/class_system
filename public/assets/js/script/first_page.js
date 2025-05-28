if (url.includes("lesson/standart") && !url.includes("view-content")) {
  let c = [
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    {
      field: "lists",
      formatter: "html",
      headerFilter: "input",
      headerSort: false,
    },
  ];

  tbconf.columns = c;
  tbconf.selectableRows = false;
  var less_std_list = new Tabulator("#tbl_list_standard", tbconf);
} else if (url.includes("lesson/school") && !url.includes("view-content")) {
  let c = [
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    {
      field: "lists",
      formatter: "html",
      headerFilter: "input",
      headerSort: false,
    },
  ];

  tbconf.columns = c;
  tbconf.selectableRows = false;
  var less_sch_list = new Tabulator("#less_sch_list", tbconf);
} else if (url.includes("lesson/public") && !url.includes("view-content")) {
  let c = [
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    {
      field: "lists",
      formatter: "html",
      headerFilter: "input",
      headerSort: false,
    },
  ];

  tbconf.columns = c;
  tbconf.selectableRows = false;
  var less_pub_list = new Tabulator("#tbl_list_lespublic", tbconf);
} else if (url.includes("question-bank/standart") && !url.includes("view-content")) {
  let c = [
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    {
      field: "lists",
      formatter: "html",
      headerFilter: "input",
      headerSort: false,
    },
  ];

  tbconf.columns = c;
  tbconf.selectableRows = false;
  var tbl_list_qbstd = new Tabulator("#tbl_list_qbstd", tbconf);
} else if (url.includes("question-bank/public")) {
  let c = [
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    {
      field: "lists",
      formatter: "html",
      headerFilter: "input",
      headerSort: false,
    },
  ];

  tbconf.columns = c;
  tbconf.selectableRows = false;
  var tbl_list_qbpublic = new Tabulator("#tbl_list_qbpublic", tbconf);
} else if (url.includes("teacher/activity")) {
  let c = [
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    {
      field: "lists",
      formatter: "html",
      headerFilter: "input",
      headerSort: false,
    },
  ];

  tbconf.columns = c;
  tbconf.selectableRows = false;
  var activity_table_teacher = new Tabulator("#activity_table_teacher", tbconf);
} else if (url.includes("student/activity")) {
  let c = [
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    {
      field: "lists",
      formatter: "html",
      headerFilter: "input",
      headerSort: false,
    },
  ];

  tbconf.columns = c;
  tbconf.selectableRows = false;
  var activity_table_student = new Tabulator("#activity_table_student", tbconf);
}

function ajax_std_less(type, param = null) {
  $.ajax({
    url: base_url + "/teacher/lesson/standart/first-page",
    data: { type, param },
    method: "post",
    dataType: "json",
    beforeSend: function () {
      show_loading()
    },
    success: function (e) {
      if (type == 1) {
        gen_header_std(e);
      } else if (type == 2) {
        gen_list_lesson(e);
      }
      hide_loading()
    },
  });
}

function ajax_add_less(type, param = null) {
  $.ajax({
    url: base_url + "/teacher/lesson/additional/first-page",
    data: { type, param },
    method: "post",
    dataType: "json",
    beforeSend: function () {
      show_loading()
    },
    success: function (e) {
      $("#lesadd_subchap").html(e.t_subchap);
      $("#lesadd_chap").html(e.t_chap);
      hide_loading()
    },
  });
}

function ajax_sch_less(type, param = null) {
  $.ajax({
    url: base_url + "/teacher/lesson/school/first-page",
    data: { type, param },
    method: "post",
    dataType: "json",
    beforeSend: function () {
      show_loading()
    },
    success: function (e) {
      $("#lessch_subchap").html(e.t_subchap);
      $("#lessch_chap").html(e.t_chap);
      hide_loading()
    },
  });
}

function ajax_pub_less(type, param = null) {
  $.ajax({
    url: base_url + "/teacher/lesson/public/first-page",
    data: { type, param },
    method: "post",
    dataType: "json",
    beforeSend: function () {
      show_loading()
    },
    success: function (e) {
      gen_header_pub(e);
      hide_loading()
    },
  });
}

function ajax_std_qb(type, param = null) {
  $.ajax({
    url: base_url + "/teacher/question-bank/standart/first-page",
    data: { type, param },
    method: "post",
    dataType: "json",
    beforeSend: function () {
      show_loading()
    },
    success: function (e) {
      gen_head_qb_std(e)
      hide_loading()
    },
  });
}

function ajax_add_qb(type, param = null) {
  $.ajax({
    url: base_url + "/teacher/question-bank/additional/first-page",
    data: { type, param },
    method: "post",
    dataType: "json",
    beforeSend: function () {
      show_loading()
    },
    success: function (e) {
      $("#lesadd_title").html(e.t_title);
      $("#lesadd_quest").html(e.t_quest);
      hide_loading()
    },
  });
}

function ajax_pub_qb(type, param = null) {
  $.ajax({
    url: base_url + "/teacher/question-bank/public/first-page",
    data: { type, param },
    method: "post",
    dataType: "json",
    beforeSend: function () {
      show_loading()
    },
    success: function (e) {
      gen_header_qbpub(e);
      hide_loading()
    },
  });
}

function ajax_std_less_s(type, param = null) {
  $.ajax({
    url: base_url + "/student/lesson/standart/first-page",
    data: { type, param },
    method: "post",
    dataType: "json",
    beforeSend: function () {
      show_loading()
    },
    success: function (e) {
      $('#count_chap').html(e.ch)
      $('#count_schap').html(e.sch)
      hide_loading()
    },
  });
}

function ajax_sch_less_s(type, param = null) {
  $.ajax({
    url: base_url + "/student/lesson/school/first-page",
    data: { type, param },
    method: "post",
    dataType: "json",
    beforeSend: function () {
      show_loading()
    },
    success: function (e) {
      $('#count_chap').html(e.t_chap)
      $('#count_schap').html(e.t_subchap)
      hide_loading()
    },
  });
}

function ajax_dash_teacher() {
  $.ajax({
    url: base_url + "/dashboard/teacher/data-dashboard",
    method: "post",
    dataType: "json",
    beforeSend: function () {
      show_loading()
    },
    success: function (e) {
      gen_dash_teacher(e)
      hide_loading()
    },
  });
}

function ajax_view_student_group(param) {
  $.ajax({
    url: base_url + "/teacher/groups/get-summary",
    data: { param },
    method: "post",
    dataType: "json",
    beforeSend: function () {
      show_loading()
    },
    success: function (e) {
      $('#count_male').html(e.male)
      $('#count_female').html(e.female)
      gen_religion_group(e.religion)
      hide_loading()
    },
  });
}

function ajax_dash_student() {
  $.ajax({
    url: base_url + "/dashboard/student/data-dashboard",
    method: "post",
    dataType: "json",
    beforeSend: function () {
      show_loading()
    },
    success: function (e) {
      gen_dash_student(e)
      hide_loading()
    },
  });
}

$(document).ready(function () {

  let all_locstorage = Object.entries(localStorage);
  $.each(all_locstorage, function (i,v) {
    if (v[0].includes("limecode") || v[0].includes("aquacode") || v[0].includes("browncode") || v[0].includes("yellowcode")) {
      localStorage.removeItem(v[0])
    }
  })

  if (url.includes("dashboard/teacher")) {
    let cl = [
      { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
      { field: "lists", formatter: "html", headerFilter: "input", headerSort: false },
    ]

    tbconf.columns = cl;
    tbconf.selectableRows = false;
    student_act = new Tabulator('#ass_student_act', tbconf)
    student_act_tsk = new Tabulator('#task_student_act', tbconf)

    ajax_dash_teacher()
  } else if (url.includes("teacher/activity")) {
    activity_table_teacher.replaceData(
      base_url + "/teacher/activity/get-data"
    );

    ajax_dash_teacher()
  } else if (url.includes("student/activity")) {
    activity_table_student.replaceData(
      base_url + "/student/activity/get-data"
    );

    // ajax_dash_student()
  } else if (url.includes("teacher/lesson/standart")) {
    ajax_std_less(1);
  } else if (url.includes("teacher/lesson/additional")) {
    ajax_add_less(1);
  } else if (url.includes("teacher/lesson/school") || url.includes("teacher/assessment/index-add") || url.includes("teacher/task/index-add")) {
    if (active_year == '') {
      Swal.fire({
        html: 'Tahun Ajaran harus di aktifkan',
        icon: "info",
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: "AKtifkan Sekarang",
        cancelButtonText: "Nanti Saja",
        customClass: {
          confirmButton: "btn btn-sm btn-primary",
          cancelButton: "btn btn-sm btn-danger",
        },
      }).then(function (confirm) {
        if (confirm.isConfirmed) {
          show_tp()
        } else {
          window.history.go(-1); return false;
        }
      });
    }
    ajax_sch_less(1);
  } else if (url.includes("teacher/lesson/public")) {
    ajax_pub_less(1);
  } else if (url.includes("teacher/question-bank/standart")) {
    ajax_std_qb(1);
  } else if (url.includes("teacher/question-bank/additional")) {
    ajax_add_qb(1);
  } else if (url.includes("teacher/question-bank/public")) {
    ajax_pub_qb(1);
  } else if (url.includes("teacher/groups/view-students")) {
    ajax_view_student_group(url);
  } else if (url.includes("student/lesson/standart") && !url.includes("view-content")) {
    ajax_std_less_s(1);
    less_std_list.replaceData(
      base_url + "/student/lesson/standart/subject-list"
    );
  } else if (url.includes("student/lesson/school") && !url.includes("view-content")) {
    if (active_year == '') {
      Swal.fire({
        html: 'Tahun Ajaran harus di aktifkan',
        icon: "info",
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: "AKtifkan Sekarang",
        cancelButtonText: "Nanti Saja",
        customClass: {
          confirmButton: "btn btn-sm btn-primary",
          cancelButton: "btn btn-sm btn-danger",
        },
      }).then(function (confirm) {
        if (confirm.isConfirmed) {
          show_tp()
        } else {
          window.history.go(-1); return false;
        }
      });
    } else {
      ajax_sch_less_s(1);
      less_sch_list.replaceData(
        base_url + "/student/lesson/school/subject-list"
      );
    }
  } else if (url.includes("dashboard/student")) {
    ajax_dash_student()
  }
});

function gen_dash_student(e) {
  let list_assessment = ''
  if (e.assessment.length > 0) {
    let card_assessment = ''
    $.each(e.assessment, function (i, v) {
      let duration = v.assessment_duration > 0 ? v.assessment_duration + ` Menit` : '-'
      let deg = v.teacher_degree != '' ? ', ' + v.teacher_degree : ''
      let name = v.teacher_first_name + ' ' + v.teacher_last_name + deg

      card_assessment += `
        <div class="card-task">
            <div class="card bg-light-primary card-bordered">
                <div class="card-body container-body">
                    <div class="d-flex align-items-start flex-column bd-highlight mb-3" style="height: 200px;">
                        <div class="mb-auto p-2 bd-highlight">
                            <p class="fs-3 text-primary fw-bold mb-auto bd-highlight">${v.assessment_title}</p>
                            <badge class="badge badge-info"><i class="bi-alarm text-white"></i> ${duration}</badge>
                        </div>
                        <div class="p-2 bd-highlight" style="margin-bottom: -17px;">
                            <p class="card-text fs-5 text-dark fw-semibold">${v.subject_name}</p>
                            <p class="text-dark">${ind_date(v.assessment_start)} s/d ${ind_date(v.assessment_end)}</p>
                            <p class="card-text fs-6 mb-2">${name}</p>
                            <button class="btn btn-primary btn-sm" onclick="alert_begin_assessment(${v.assessment_id})">Kerjakan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      `
    })
    list_assessment = `
      <div class="col-sm-12 mb-5" id="block-assessment">
            <div class="alert alert-white" style="border-radius:10px;">
                <div class="d-flex flex-stack text-white mb-3">
                    <div class="flex-shrink-0">
                        <span class="mb-3 p-3 fw-bold text-gray-900 fs-2 m-0">Penilaian Aktif</span>
                    </div>

                    <a href="<?= base_url('student/assessment/present') ?>" class="btn btn-icon btn-color-gray-500 btn-active-color-primary pt-2 pr-4" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                        <i class="bi bi-three-dots text-dark fs-1"></i>
                    </a>
                </div>
                <div class="container-card">
                    <div class="row-task">
                        ${card_assessment}
                    </div>
                </div>
            </div>
        </div>
    `
  }
  $('#block-assessment').html(list_assessment)

  let list_task = ''
  
  if (Object.values(e.list_idx).length > 0) {
    if (e.task.length > 0) {
      let card_task = ''
      $.each(e.task, function (i, v) {
        if (Object.values(e.list_idx).includes(v.task_id)) {
          let end = new Date(v.task_end)
          let now = new Date();
  
          if ((end > now) || (end < now && v.task_is_ignored_time_submit == 1)) {
            let deg = v.teacher_degree != '' ? ', ' + v.teacher_degree : ''
            let name = v.teacher_first_name + ' ' + v.teacher_last_name + deg
            let temp_exists = e.arr_temp_task.includes(v.task_id) ? 1 : 0
            let bdg_exists = e.arr_temp_task.includes(v.task_id) ? '<badge class="badge badge-danger">Belum dikirim</badge>' : '<badge class="badge badge-info">Belum dikerjakan</badge>'
  
            card_task += `
              <div class="card-task">
                  <div class="card bg-light-info card-bordered">
                      <div class="card-body container-body">
                          <div class="d-flex align-items-start flex-column bd-highlight mb-3" style="height: 200px;">
                              <div class="mb-auto p-2 bd-highlight">
                                  <p class="fs-3 text-primary fw-bold mb-auto bd-highlight">${v.task_title}</p>
                                  ${bdg_exists}
                              </div>
                              <div class="p-2 bd-highlight" style="margin-bottom: -17px;">
                                  <p class="card-text fs-5 text-dark fw-semibold">${v.subject_name}<?= $v['subject_name'] ?></p>
                                  <p class="text-dark">${ind_date(v.task_start)} s/d ${ind_date(v.task_end)}</p>
                                  <p class="card-text fs-6 mb-2">${name}</p>
                                  <button class="btn btn-primary btn-sm" onclick="begin_task(${v.task_id}, ${temp_exists}, '${v.task_title}')">Kerjakan</button>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
            `
          }
        }
      })
  
      list_task += `
        <div class="alert alert-white" style="border-radius:10px;">
            <div class="d-flex flex-stack text-white mb-3">
                <div class="flex-shrink-0">
                    <span class="mb-3 p-3 fw-bold text-gray-900 fs-2 m-0">Tugas Aktif</span>
                </div>
  
                <a href="<?= base_url('student/task/present') ?>" class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-start pt-2 pr-4" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                    <i class="bi bi-three-dots text-dark fs-1"></i>
                </a>
            </div>
            <div class="container-card">
                <div class="row-task">
                    ${card_task}
                </div>
            </div>
        </div>
      `
    }
  }

  $('#block-task').html(list_task)

}

function gen_dash_teacher(e) {
  let my_duty = ''
  if (e.my_duty.length > 0) {
    $.each(e.my_duty, function (i, v) {
      my_duty += `
        <div class="timeline-item pb-5">
          <div class="timeline-content m-0">
            <span class="fs-8 fw-bolder text-primary text-uppercase">${v.student_group_name}</span>
            <a href="#" class="fs-6 text-gray-800 fw-bold d-block text-hover-primary">${v.subject_name}</a>
            <span class="fw-semibold text-gray-500">n / a</span>
          </div>
        </div>
      `
    })
  } else {
    my_duty = '<span>Tidak ada jadwal mengajar.</span>'
  }

  let content = ''
  if (Object.keys(e.assessment_task_check).length > 0) {
    let card = ''

    $.each(e.assessment_task_check, function (i, v) {
      let group = ''
      $.each(v.group, function (idx, val) {
        if (val.checked_all == 'none') {
          if (v.type == 'Tugas') {
            group += `<a href="" data-group_id="${val.id}" data-task_id="${v.id}" data-task="${v.title}" class="badge badge-info mx-1 view_student_task">${val.group}</a>`
          } else {
            group += `<a href="" data-group_id="${val.id}" data-assessment_id="${v.id}" data-title="${v.title}" class="badge badge-info mx-1 view_student">${val.group}</a>`
          }
        }
      })

      card += `
        <div class="card-task">
            <div class="card">
                <div class="card-body container-body1 bg-light-info" style="border-radius: 10px;">
                    <div class="d-flex align-items-start flex-column bd-highlight mb-3" style="height: 200px;">
                        <div class="mb-auto p-2 bd-highlight">
                            <p class="fs-3 text-primary fw-bold mb-2 bd-highlight">${v.title}</p>
                            <badge class="badge badge-${v.type != 'Tugas' ? 'danger' : 'success'} mb-2">${v.type}</badge>
                            ${group}
                        </div>
                        <div class="p-2 bd-highlight">
                            <p class="card-text fs-5 text-dark fw-semibold">${v.subject}</p>
                            <p class="text-dark">${ind_date(v.start)} s/d ${ind_date(v.end)}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      `
    })

    content = `
      <div class="col-md-12 col-xl-12 my-xl-5">
          <div class="card h-md-100">
              <div class="card-header align-items-center border-0">
                  <h3 class="fw-bold text-gray-900 m-0">Butuh Diperiksa</h3>
  
                  <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
  
                      <i class="bi bi-three-dots fs-1"></i>
                  </button>
  
              </div>
              <div class="card-body pt-2">
                  <div class="container-card">
                      <div class="row-task" style="margin-left: -10px; margin-right: -15px;">
                          ${card}
                      </div>
                  </div>
                  
              </div>
          </div>
      </div>
    `
  }

  $('#checked_asstsk').html(content)
  $('#myduty').html(my_duty)
  $('#t_qb_me').html(e.total_qb_me + ' Soal')
  $('#t_qb_pub').html(e.total_qb_pub + ' Soal')
  $('#t_qb_shr').html(e.total_qb_shared + ' Soal')
  $('#dash_t_chap').html(e.total_less_chap)
  $('#dash_t_subchap').html(e.total_less_subchap)
  $('#dash_t_tqb').html(e.total_qb_title)
  $('#dash_t_qb').html(e.total_qb_quest)
  $('#dash_add_less').html(e.total_less_add_chap)
  $('#dash_sch_less').html(e.total_less_sch_chap)
  $('#dash_pub_less').html(e.total_less_pub_chap)
  $('#dash_chp_shared').html(e.total_less_share_chap)
  $('#dash_schp_shared').html(e.total_less_share_subchap)
  $('#as_draft').html(e.as_draft)
  $('#as_scheduled').html(e.as_scheduled)
  $('#as_present').html(e.as_present)
  $('#as_done').html(e.as_done)
  $('#tk_draft').html(e.tk_draft)
  $('#tk_scheduled').html(e.tk_scheduled)
  $('#tk_present').html(e.tk_present)
  $('#tk_done').html(e.tk_done)
}

function gen_head_qb_std(e) {
  $("#count_qbtitle").html(e.t_title);
  $("#count_qbquest").html(e.t_quest);

  let cls = "";
  let ii = 0;
  $.each(e.grades, function (i, v) {
    cls += `
      <li class="nav-item mt-2">
        <a class="nav-link text-active-light ms-0 me-10 py-5 head_tab_group" id="head_tab_group${i}"  onclick="gen_list_qb_std(${i}, 'head_tab_group${i}')" href="#">Kelas ${v} </a>
      </li>
    `;
    ii++;
  });

  $("#list_class").html(cls);
}

function gen_header_qbpub(e) {
  let cls = "";
  let tt = 0;
  let tq = 0;
  $.each(e, function (i, v) {
    tt += Object.keys(v.teacher).length
    tq += parseInt(v.question)
    cls += `
      <li class="nav-item mt-2">
        <a class="nav-link text-active-light ms-0 me-10 py-5 head_tab_group" id="head_tab_group${i}"  onclick="gen_listpub_qb(${v.subject_id}, 'head_tab_group${i}')" href="#">${v.subject_name} </a>
      </li>
    `;
  });

  $('#tpub_quest').html(tq)
  $('#tpub_teacher').html(tt)

  $("#list_class").html(cls);
}

function gen_listpub_qb(e, act) {
  $(".head_tab_group").each(function () {
    $(this).removeClass("active");
  });
  $("#body_tbl_list_standart").removeClass("hide");
  tbl_list_qbpublic.replaceData(
    base_url + "teacher/question-bank/public/quest-list/?subject_id=" + e
  );
  $("#" + act).addClass("active");
}

function gen_header_pub(e) {
  let cls = "";
  let tc = 0;
  let ts = 0;
  $.each(e[0], function (i, v) {
    tc += Object.keys(v.chapter).length
    ts += Object.keys(v.subchapter).length
    cls += `
      <li class="nav-item mt-2">
        <a class="nav-link text-active-light ms-0 me-10 py-5 head_tab_group" id="head_tab_group${i}"  onclick="gen_listpub_lesson(${v.subject_id}, 'head_tab_group${i}')" href="#">${v.subject_name} </a>
      </li>
    `;
  });

  $('#tpub_teacher').html(e[1])
  $('#tpub_chapter').html(tc)
  $('#tpub_subchapter').html(ts)

  $("#list_class").html(cls);
}

function gen_header_std(e) {
  $("#count_subj").html(e.t_less);
  $("#count_chap").html(e.t_chap);

  let cls = "";
  let ii = 0;
  $.each(e.grades, function (i, v) {
    cls += `
      <li class="nav-item mt-2">
        <a class="nav-link text-active-light ms-0 me-10 py-5 head_tab_group" id="head_tab_group${i}"  onclick="gen_list_lesson(${i}, 'head_tab_group${i}')" href="#">Kelas ${v} </a>
      </li>
    `;
    ii++;
  });

  $("#list_class").html(cls);
}

function gen_list_qb_std(e, act) {
  $(".head_tab_group").each(function () {
    $(this).removeClass("active");
  });
  $("#body_tbl_list_standart").removeClass("hide");
  tbl_list_qbstd.setData(
    base_url + "teacher/question-bank/standart/qb-list/?grade=" + e
  );
  $("#" + act).addClass("active");
}

function gen_list_lesson(e, act) {
  $(".head_tab_group").each(function () {
    $(this).removeClass("active");
  });
  $("#body_tbl_list_standart").removeClass("hide");
  less_std_list.replaceData(
    base_url + "/teacher/lesson/standart/lesson-list/?grade=" + e
  );
  $("#" + act).addClass("active");
}

function gen_listpub_lesson(e, act) {
  $(".head_tab_group").each(function () {
    $(this).removeClass("active");
  });
  $("#body_tbl_list_standart").removeClass("hide");
  less_pub_list.replaceData(
    base_url + "/teacher/lesson/public/lesson-list/?subject_id=" + e
  );
  $("#" + act).addClass("active");
}

function gen_religion_group(e) {
  let content = '';
  $.each(e, function (i, v) {

    let count = 0
    $.each(v, function (idx, val) {
      count += parseInt(val)
    })

    content += `
        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
              <div class="d-flex align-items-center">
                  <div class="fs-2 fw-bold text-light" id="count_female">${count}</div>
              </div>

              <div class="fw-semibold fs-6 text-gray-500">${i}</div>
          </div>
    `
  })

  $('#next_').after(content)

}
