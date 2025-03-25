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
} else if (url.includes("lesson/public")) {
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
} else if (url.includes("question-bank/standart")) {
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

$(document).ready(function () {
  if (url.includes("dashboard/teacher")) {
    ajax_dash_teacher()
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
  }
});

function gen_dash_teacher(e) {
  console.log(e);
  
  let my_duty = ''
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

  $('#myduty').html(my_duty)
  $('#t_qb_me').html(e.total_qb_me + ' Soal')
  $('#t_qb_pub').html(e.total_qb_pub + ' Soal')
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
  console.log(e);

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
  tbl_list_qbstd.replaceData(
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
  $.each(e, function(i,v) {

    let count = 0
    $.each(v, function(idx, val){
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
