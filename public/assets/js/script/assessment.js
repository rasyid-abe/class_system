function show_modal() {
  var instruction_assessment = new Quill("#instruction_assessment", {
    modules: {
      toolbar: toolbarOptions,
    },
    theme: "snow", // or 'bubble'
  });
  $("#modal_assessment").modal("show");
  set_datepicker();
}

function set_datepicker() {
  $(".assessment_periode_date").flatpickr({
    enableTime: true,
    dateFormat: "Y-m-d H:i",
});
}

function hide_modal() {
  $("#modal_assessment").modal("hide");
}

function check_group() {
  let subs = $("#sub_ass").val();
  let grad = $("#grade_ass").val();
  let groups = $("#multiple-select-group").select2();
  if (subs != 0 && grad != 0) {
    $.ajax({
      url: base_url + "/teacher/assessment/group-exists",
      data: { subs, grad },
      method: "post",
      dataType: "json",
      success: function (e) {
        if (e) {
          let option = '';
          $.each(e, function (i, v) {
            option += `<option value="${v.id}">${v.name}</option>`;
          });
          groups.attr("disabled", false).html(option);
        } else {
          groups.val(null).trigger("change");
          groups.attr("disabled", true);
        }
      },
    });
  } else {
    groups.val(null).trigger("change");
    groups.attr("disabled", true);
  }
}

$(document.body).on('click', '.asscheck', function() {
  $(this).toggleClass('checked')
})

function chk_range() {
  let start = $('#start_assessment').val()
  let end = $('#end_assessment').val()

  if (start != '' && end != '') {
    dtstart = new Date(Date.parse(start.replace(' ', 'T') + ':00Z'));
    dtend = new Date(Date.parse(end.replace(' ', 'T') + ':00Z'));
    
    if (dtstart < dtend) {
      return true
    } else {
      return false
    }
  }

  console.log(start);
  console.log(end);
  
}

function save_assessment() {
  let title = $('input[name=title]').val()
  let subj = $('select[name=subject]').val()
  let grad = $('select[name=grade]').val()
  let group = $('#multiple-select-group').select2('data');
  let start = $('#start_assessment').val()
  let end = $('#end_assessment').val()
  let timer = $('input[name=timer]').val()
  let random = $('#ass_random').hasClass('checked')
  let cheat = $('#ass_cheat').hasClass('checked')
  let submit = $('#autosumbit').hasClass('checked')
  let insass = $("#instruction_assessment > .ql-editor").html();

  let msg = ['title_ass', 'sub_ass', 'grade_ass', 'group_ass', 'start_ass', 'end_ass', 'timer_ass']
  let chk = [title != '', subj != 0, grad != 0, group.length > 0, start != '', end != '', timer != 0 ]
  
  for (let i = 0; i < chk.length; i++) {
    if (chk[i] != true) {
      if ($('.'+msg[i]).hasClass('hide')) {
        $('.'+msg[i]).removeClass('hide')
      }
    } else {
      if (!$('.'+msg[i]).hasClass('hide')) {
        $('.'+msg[i]).addClass('hide')
      }
    }
  }

  console.log(chk);
  console.log(chk_range());
  
  
  if (chk.includes(false)) {
    return false
  } else {
    if (chk_range()) {
      al_swal('Periode sesuai!', 'success')
      // return false
      // let data = [title, subj, grad, group, start, end, timer, random, cheat, submit, insass]
    } else {
      $('.anom_period').html('Periode awal tidak boleh lebih besar dari periode akhir!').removeClass('hide')
      // al_swal('Periode tidak sesuai!', 'error')

      // store_assessment(1, data)
    }
    
  }
  
}

function store_assessment(type, data, id = null) {
  $.ajax({
    url: base_url + "/teacher/assessment/store-data",
    data: { type, data, id },
    method: "post",
    dataType: "json",
    success: function (e) {
      console.log(e);
      load_data()
    },
  });
}

var printIcon = function (cell, formatterParams) {
  //plain text value
  return `<button class="btn btn-icon btn-sm btn-primary"><i class='fa fa-print'></i></buton>`;
};

var table = new Tabulator("#example-table", {
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
  columns: [
    {
      title: "#",
      formatter: printIcon,
      width: 80,
      align: "center",
      cellClick: function (e, cell) {
        alert("Printing row data for: " + cell.getRow().getData().id);
      },
    },
    { title: "ID", field: "id", sorter: "string", width: 200 },
    { title: "Name", field: "name" },
  ],
});

function load_data() {
  table.setData(base_url + "/teacher/assessment/example-tabulator");
}

$(document).ready(function () {
  load_data()
});
