if (url.includes("lesson/standart")) {
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
      console.log(e);
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
  }
});

function gen_header_pub(e) {
  let cls = "";
  let ii = 0;
  let tc = 0;
  let ts = 0;
  $.each(e, function (i, v) {
    tc += Object.keys(v.chapter).length
    ts += Object.keys(v.subchapter).length
    cls += `
      <li class="nav-item mt-2">
        <a class="nav-link text-active-light ms-0 me-10 py-5 head_tab_group" id="head_tab_group${i}"  onclick="gen_listpub_lesson(${v.subject_id}, 'head_tab_group${i}')" href="#">${v.subject_name} </a>
      </li>
    `;
    ii++;
  });

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
