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
    success: function (e) {
      if (type == 1) {
        gen_header_std(e);
      } else if (type == 2) {
        gen_list_lesson(e);
      }
    },
  });
}

function ajax_add_less(type, param = null) {
  $.ajax({
    url: base_url + "/teacher/lesson/additional/first-page",
    data: { type, param },
    method: "post",
    dataType: "json",
    success: function (e) {
      console.log(e);
      $("#lesadd_subchap").html(e.t_subchap);
      $("#lesadd_chap").html(e.t_chap);
    },
  });
}

function ajax_sch_less(type, param = null) {
  $.ajax({
    url: base_url + "/teacher/lesson/school/first-page",
    data: { type, param },
    method: "post",
    dataType: "json",
    success: function (e) {
      $("#lessch_subchap").html(e.t_subchap);
      $("#lessch_chap").html(e.t_chap);
    },
  });
}

function ajax_pub_less(type, param = null) {
  $.ajax({
    url: base_url + "/teacher/lesson/public/first-page",
    data: { type, param },
    method: "post",
    dataType: "json",
    success: function (e) {
      gen_header_pub(e);
    },
  });
}

function ajax_std_qb(type, param = null) {
  $.ajax({
    url: base_url + "/teacher/question-bank/standart/first-page",
    data: { type, param },
    method: "post",
    dataType: "json",
    success: function (e) {
      gen_head_qb_std(e)
    },
  });
}

function ajax_add_qb(type, param = null) {
  $.ajax({
    url: base_url + "/teacher/question-bank/additional/first-page",
    data: { type, param },
    method: "post",
    dataType: "json",
    success: function (e) {
      console.log(e);
      $("#lesadd_title").html(e.t_title);
      $("#lesadd_quest").html(e.t_quest);
    },
  });
}

function ajax_pub_qb(type, param = null) {
  $.ajax({
    url: base_url + "/teacher/question-bank/public/first-page",
    data: { type, param },
    method: "post",
    dataType: "json",
    success: function (e) {
      gen_header_qbpub(e);
    },
  });
}

function ajax_std_less_s(type, param = null) {
  $.ajax({
    url: base_url + "/student/lesson/standart/first-page",
    data: { type, param },
    method: "post",
    dataType: "json",
    success: function (e) {
      $('#count_chap').html(e.ch)
      $('#count_schap').html(e.sch)
    },
  });
}

function ajax_sch_less_s(type, param = null) {
  $.ajax({
    url: base_url + "/student/lesson/school/first-page",
    data: { type, param },
    method: "post",
    dataType: "json",
    success: function (e) {
      $('#count_chap').html(e.t_chap)
      $('#count_schap').html(e.t_subchap)
    },
  });
}

$(document).ready(function () {
  if (url.includes("teacher/lesson/standart")) {
    ajax_std_less(1);
  } else if (url.includes("teacher/lesson/additional")) {
    ajax_add_less(1);
  } else if (url.includes("teacher/lesson/school")) {
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
