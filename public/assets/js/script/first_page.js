if (url.includes("lesson/standart")) {
  let c = [
    { title: "ID", field: "id", sorter: "string", width: 200, visible: false },
    { field: "lists", formatter: "html", headerFilter:"input", headerSort:false},
  ];

  tbconf.columns = c;
  tbconf.selectableRows = false;
  var less_std_list = new Tabulator("#tbl_list_standard", tbconf);
}

function ajax_std_less(type, param = null) {
  
  $.ajax({
    url: base_url + "/teacher/lesson/standart/first-page",
    data: {type, param},
    method: "post",
    dataType: "json",
    success: function (e) {
      
      if (type == 1) {
        gen_header(e);
      } else if (type == 2) {
        gen_list_lesson(e)
      }
    },
  });
}

function ajax_add_less(type, param = null) {
  
  $.ajax({
    url: base_url + "/teacher/lesson/additional/first-page",
    data: {type, param},
    method: "post",
    dataType: "json",
    success: function (e) {
      console.log(e);
      $('#lesadd_subchap').html(e.t_subchap)
      $('#lesadd_chap').html(e.t_chap)
      
    },
  });
}

$(document).ready(function () {
  if (url.includes("teacher/lesson/standart")) {
    ajax_std_less(1);
  } else if (url.includes("teacher/lesson/additional")) {
    ajax_add_less(1);
  }
});

function gen_header(e) {
  $("#count_subj").html(e.t_less)
  $("#count_chap").html(e.t_chap)

  let cls = ""
  let ii = 0;
  $.each(e.grades, function(i,v) {
    cls += `
      <li class="nav-item mt-2">
        <a class="nav-link text-active-light ms-0 me-10 py-5 head_tab_group" id="head_tab_group${i}"  onclick="gen_list_lesson(${i}, 'head_tab_group${i}')" href="#">Kelas ${v} </a>
      </li>
    `
    ii++
  })

  $('#list_class').html(cls)
}

function gen_list_lesson(e, act) {
  console.log(act);
  
  $('.head_tab_group').each(function(){
    $(this).removeClass('active')
  })
  $('#body_tbl_list_standart').removeClass('hide')
  less_std_list.replaceData(base_url + "/teacher/lesson/standart/lesson-list/?grade=" + e);
  $('#'+act).addClass('active')
}
