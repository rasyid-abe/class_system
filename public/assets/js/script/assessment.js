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
  let content = ''
    let i1 = 1
    $.each(e, function(i,v) {
      if (v.content.length > 0) {
        console.log(v);
        
        let ch1 = ''
        let i2 = 1
        $.each(v.content, function(idx, val) {
            let child = ''
            let ii = 1
            $.each(val['child'], function(index, value) {
                child += `
                <li class="list-group-item">
                  <a href="#" onclick="view_tasks(${i1}, ${value.id})" style="text-decoration: none;">Soal ${ii}</a>
                </li>
                `
                ii++
                // <div class="form-check my-2">
                //     <input class="form-check-input" type="checkbox" name="task_${i1}" value="${value.id}" />
                //     <label class="form-check-label" onclick="view_tasks(${i1}, ${value.id})">
                //         Soal ${ii}
                //     </label>
                // </div>
              })

            let child_body = `
                 <ul class="list-group list-group-flush hide task_child" id="i${i1}${i2}">
                    ${child}
                </ul>
            `
            
            ch1 += `
                 <div class="form-check my-2 form-switch form-check-custom form-check-solid" style="margin-left: 10px">
                    <input class="form-check-input h-20px w-30px" type="radio" name="task_ass_check" data-tasksrc=${v.src} data-taskname="${val.title}" value="${val.id}" />
                    <label class="form-check-label head22" data-source="${i1}${i2}">
                      ${val.title}
                    </label>
                </div>
                ${val.child.length > 0 ? child_body : ''}    
                `
                // <li class="list-group-item head22" data-source="${i1}${i2}">${val.title}</li>

            i2++ 
        })

        let ch1_body = `
            <ul class="list-group list-group-flush hide head_head22 text-bold" id="i${i1}">
                ${ch1}
            </ul>
        `
        content += `
            <li class="list-group-item bg-secondary parent1" data-source="${i1}"><h6 style="margin-top:5px">${v.head}</h6></li>
            ${v.content.length > 0 ? ch1_body : ''}
        `

        i1++
      }
    })

    let page = `
        <div id="idass_subj" data-subj="${subj}" data-subjname="${subjname}"></div>
        <div id="idass_grad" data-grad="${grad}" data-gradname="Kelas ${gradname}"></div>
        <ul class="list-group list-group-flush head_parent1">
            ${content}
        </ul>
    `

  $("#view_select_task").html(page);
  $("#preview_task").html('')
  $('#task_prev_ass').modal('show')
}

$(document.body).on('click', '.head22', function() {
  id = $(this).data('source')
  if ($('#i' + id).hasClass('hide')) {
      $('#i' + id).removeClass('hide')
  } else {
      // $(`.task_child`).each(function () {
      //     if (!$(this).hasClass('hide')) {
      //         $(this).addClass('hide') 
      //     }
      // });
  
      $('#i' + id).addClass('hide')
  }
})

function set_task_ass() {
  let task_ass = $('input[name=task_ass_check]:checked').val()
  let task_name = $('input[name=task_ass_check]:checked').data('taskname')
  let task_src = $('input[name=task_ass_check]:checked').data('tasksrc')
  let subj_ass = $('#idass_subj').data('subj')
  let subj_name = $('#idass_subj').data('subjname')
  let grad_ass = $('#idass_grad').data('grad')
  let grad_name = $('#idass_grad').data('gradname')

  $('input[name=selected_task]').val(task_name).attr('readonly', true)
  $('input[name=taskid]').val(task_ass)
  $('input[name=tasksrc]').val(task_src)
  $('input[name=selected_subj]').val(subj_name + ' - ' +grad_name).attr('readonly', true)
  $('input[name=subjid]').val(subj_ass)
  $('input[name=selected_grad]').val(grad_name).attr('readonly', true)
  $('input[name=gradid]').val(grad_ass)

  
  $("#modal_assessment").modal("show");
  set_datepicker();
  check_group(subj_ass, grad_ass)
}

function set_datepicker() {
  $(".assessment_periode_date").flatpickr({
    enableTime: true,
    dateFormat: "Y-m-d H:i",
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
  $("#modal_assessment").modal("hide");
}

function check_group(subs, grad) {
  let groups = $("#multiple-select-group").select2();
  $.ajax({
    url: base_url + "/teacher/assessment/data-option",
    data: { subs, grad },
    method: "post",
    dataType: "json",
    success: function (e) {
      console.log(e);
      
      if (e) {
        let option = "";
        $.each(e, function (i, v) {
          option += `<option value="${v.id}">${v.name}</option>`;
        });
        groups.html(option);
        console.log('aa');
        
      } else {
        console.log('bb');
        
        groups.val(null).trigger("change");
        groups.attr("disabled", true);
      }
    },
  });
}

$(document.body).on("click", ".asscheck", function () {
  $(this).toggleClass("checked");
});

$(document.body).on('click', '#ass_timer', function() {
  $('#c_timer').toggleClass('hide')
})

function chk_range() {
  let start = $("#start_assessment").val();
  let end = $("#end_assessment").val();

  if (start != "" && end != "") {
    dtstart = new Date(Date.parse(start.replace(" ", "T") + ":00Z"));
    dtend = new Date(Date.parse(end.replace(" ", "T") + ":00Z"));

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

function save_assessment() {
  let task_name = $("input[name=selected_task]").val()
  let subj_name = $("input[name=selected_subj]").val()
  let task = $("input[name=taskid]").val();
  let task_src = $("input[name=tasksrc]").val();
  let subj = $("input[name=subjid]").val();
  let grad = $("input[name=gradid]").val();
  let title = $("input[name=title]").val();
  let group = $("#multiple-select-group").select2("data");
  let start = $("#start_assessment").val();
  let end = $("#end_assessment").val();
  let timer = $("input[name=timer]").val();
  let istimer = $("#ass_timer").hasClass('checked');
  let random = $("#ass_random").hasClass("checked");
  let cheat = $("#ass_cheat").hasClass("checked");
  let submit = $("#autosumbit").hasClass("checked");
  let insass = $("#instruction_assessment > .ql-editor").html();

  let timer_sts = istimer ? (timer != 0 ? true : false) : true;
  let msg = [
    "title_ass",
    "group_ass",
    "start_ass",
    "end_ass",
    "timer_ass",
  ];
  let chk = [
    title != "",
    group.length > 0,
    start != "",
    end != "",
    timer_sts,
  ];

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
        title,subj,grad,group,start,end,timer,random,cheat,submit,insass,task,task_name,subj_name,task_src
      ];
      
      store_data(1, JSON.stringify(data));
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
      $("#modal_assessment").modal("hide");
      $('#task_prev_ass').modal('hide');
      Toast.fire({
        icon: e.icn,
        title: e.msg
      });
    },
  });
}

let url = window.location.href
const tbconf = {
  height: "600px",
  layout: "fitDataStretch",
  renderHorizontal: "virtual",
  pagination: "local",
  paginationSize: 10,
  paginationSizeSelector: [10, 50, 100, 200],
  movableColumns: true,
  paginationCounter: "rows",
  langs: {
    default: {
      pagination: {
        page_size: "Jumlah Baris",
        first: "<<",
        last: ">>",
        prev: "<",
        next: ">",
        counter: {
          showing: "Menampilkan",
          of: "dari total",
          rows: "data",
          pages: "halaman",
        },
      },
    },
  },
}

var printIcon = function (cell, formatterParams) {
  return `<button class="btn btn-icon btn-sm btn-primary"><svg width="20" height="20" fill="currentColor" class="bi bi-send-check-fill" viewBox="0 0 16 16">
  <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 1.59 2.498C8 14 8 13 8 12.5a4.5 4.5 0 0 1 5.026-4.47zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471z"/>
  <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-1.993-1.679a.5.5 0 0 0-.686.172l-1.17 1.95-.547-.547a.5.5 0 0 0-.708.708l.774.773a.75.75 0 0 0 1.174-.144l1.335-2.226a.5.5 0 0 0-.172-.686"/>
  </svg></buton>`;
};

if (url.includes("index-draft")){
  let c = [
    {
      title: "#",
      formatter: printIcon,
      width: 80,
      align: "center",
      cellClick: function (e, cell) {
        Swal.fire({
          html: `Apakah anda yakin publis penilaian ini?`,
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
            store_data(2, '', cell.getRow().getData().id)
            draft.replaceData()
            // alert("Printing row data for: " + cell.getRow().getData().id);
          }
        });
      },
    },
    { title: "ID", field: "id", sorter: "string", width: 200, visible:false },
    { title: "Penilaian", field: "title"},
    { title: "Mata Pelajaran", field: "mapel" },
    { title: "Kelompok Belajar", field: "group", formatter:"html" },
    { title: "Judul Soal", field: "task" },
    { title: "Periode", field: "period" },

  ]

  tbconf.columns = c 
  var draft = new Tabulator("#ass_draft_table", tbconf);

} else if (url.includes("index-scheduled")) {
  let c = [
    {
      title: "#",
      formatter: printIcon,
      width: 80,
      align: "center",
      cellClick: function (e, cell) {
        alert("Printing row data for: " + cell.getRow().getData().id);
      },
    },
    { title: "ID", field: "id", sorter: "string", width: 200, visible:false },
    { title: "Penilaian", field: "title", width: 250},
    { title: "Mata Pelajaran", field: "mapel" },
    { title: "Kelompok Belajar", field: "group", formatter:"html" },
    { title: "Judul Soal", field: "task" },
    { title: "Periode", field: "period" },
  ]

  tbconf.columns = c 
  var scheduled = new Tabulator("#ass_scheduled_table", tbconf);

} else if (url.includes("index-present")) {
  let c = [
    {
      title: "#",
      formatter: printIcon,
      width: 80,
      align: "center",
      cellClick: function (e, cell) {
        alert("Printing row data for: " + cell.getRow().getData().id);
      },
    },
    { title: "ID", field: "id", sorter: "string", width: 200, visible:false },
    { title: "Penilaian", field: "title", width: 250},
    { title: "Mata Pelajaran", field: "mapel" },
    { title: "Kelompok Belajar", field: "group", formatter:"html" },
    { title: "Judul Soal", field: "task" },
    { title: "Periode", field: "period" },
  ]

  tbconf.columns = c 
  var present = new Tabulator("#ass_present_table", tbconf);

} else if (url.includes("index-done")) {
  let c = [
    {
      title: "#",
      formatter: printIcon,
      width: 80,
      align: "center",
      cellClick: function (e, cell) {
        alert("Printing row data for: " + cell.getRow().getData().id);
      },
    },
    { title: "ID", field: "id", sorter: "string", width: 200, visible:false },
    { title: "Penilaian", field: "title", width: 250},
    { title: "Mata Pelajaran", field: "mapel" },
    { title: "Kelompok Belajar", field: "group", formatter:"html" },
    { title: "Judul Soal", field: "task" },
    { title: "Periode", field: "period" },
  ]

  tbconf.columns = c 
  var done = new Tabulator("#ass_done_table", tbconf);

}

$(document).ready(function () {
  if (url.includes("index-add")){
    var instruction_assessment = new Quill("#instruction_assessment", {
      modules: {
        toolbar: toolbarOptions,
      },
      theme: "snow", // or 'bubble'
    });
  } else if (url.includes('index-draft')) {
    draft.setData(base_url + "/teacher/assessment/list-assessment?page-ass=1");
  } else if (url.includes("index-scheduled")) {
    scheduled.setData(base_url + "/teacher/assessment/list-assessment?page-ass=2");
  } else if (url.includes("index-present")) {
    present.setData(base_url + "/teacher/assessment/list-assessment?page-ass=3");
  } else if (url.includes("index-done")) {
    done.setData(base_url + "/teacher/assessment/list-assessment?page-ass=4");
  }
});

