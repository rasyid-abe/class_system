function ajax_std_less(type, param) {
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

$(document).ready(function () {
  ajax_std_less(1);
});

function gen_header(e) {
  $("#count_subj").html(e.t_less)
  $("#count_chap").html(e.t_chap)

  let cls = ""
  $.each(e.grades, function(i,v) {
    cls += `
        <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5" onclick="get_lesson_list(2, ${i})" href="#">
                    Kelas ${v} </a>
            </li>
    `
  })

  $('#list_class').html(cls)
}

function get_lesson_list(type, param) {
    ajax_std_less(type, param)
}

function gen_list_lesson(e) {
    console.log(e);
    
}
