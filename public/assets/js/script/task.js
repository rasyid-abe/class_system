function grab_data_lesson(
	type,
	id = null,
	subj = null,
	grad = null,
	param = null
) {
	$.ajax({
		url: base_url + "/teacher/task/grab-data-lesson",
		data: { type, id, subj, grad, param },
		method: "post",
		dataType: "json",
		beforeSend: function () {
			show_loading()
		},
		success: function (e) {
			if (type == 1) {
				treeview_task_ch(e, subj, grad);
			} else if (type == 2) {

				$('#content_lesson').html('')
				$('#video_lesson').html('')
				$('#attachment_lesson').html('')
				$('#task_lesson').html('')

				generate_view_lesson_s(e);
				generate_view_video_s(e);
				generate_view_attachment_s(e);
				generate_view_task_s(
					e.task,
					e.lesson_standart_id,
					e.lesson_standart_subject_id,
					e.lesson_standart_grade
				);

				if ($("#content_tab_ct").hasClass("hide")) {
					$("#content_tab_ct").removeClass("hide");
					$("#content_value_ct").removeClass("hide");
				}
			}
			hide_loading()
		},
	});
}

function chk_range_task(save_type = null) {
	let start = $("#start_task").val();
	let end = $("#end_task").val();

	if (start != "" && end != "") {
		let dtstart = new Date(Date.parse(start.replace(" ", "T") + ":00Z"));
		let dtend = new Date(Date.parse(end.replace(" ", "T") + ":00Z"));

		curr = new Date(datetimenow);
		if (dtstart < curr) {
			if (save_type == 2) {
				let old_start = $("#old_start_task").val()
				let dtold = new Date(Date.parse(old_start.replace(" ", "T") + ":00Z"));

				if (dtstart.getTime() === dtold.getTime()) {
					return 1;
				} else {
					return 3;
				}
			} else {
				return 3;
			}
		} else {
			if (dtstart < dtend) {
				return 1;
			} else {
				return 2;
			}
		}
	}
}

function close_modal() {
	$("#task_prev_less").modal("hide");
}

$(document.body).on("click", "#btnshow_lesson", function () {
	let subj = $(this).data("subjs");
	let grad = $(this).data("grade");
	grab_data_lesson(1, "", subj, grad);
	set_datepicker();
	$("#task_prev_less").modal("show");
});

function treeview_task_ch(e, subj, grad) {
	let content = "";
	let bdi1 = 1;
	$.each(e.datas, function (i, v) {
		let bd1 = "";
		let bdi2 = 1;

		$.each(v.nodes, function (idx, val) {
			let child = "";
			let ii = 1;
			$.each(val.nodes, function (index, value) {
				let tsks = value.tasks != "" ? 1 : 0

				child += `
				<div class="form-check my-2">
					<input class="form-check-input" type="radio" name="task_choose" data-lessonsrc=${v.ind} data-taskname="${value.text}" data-taskchapter="${value.chapter}" data-tasks="${tsks}" value="${value.lesson_id}" />
					<label class="form-check-label" onclick="getlessonbyid(${value.lesson_id}, ${v.ind})">
						${value.text}
					</label>
				</div>
				`;
				ii++;
			});


			let child_body = `
				<ul class="list-group list-group-flush hide task_child" id="i${bdi1}${bdi2}" style="padding-left: 10px">
					${child}
				</ul>
			`;

			if (v.text == "Materi Publik") {
				let tsks = val.lesson_additional_tasks != "" ? 1 : 0
				bd1 += `
					<div class="form-check my-2">
						<input class="form-check-input" type="radio" name="task_choose" data-taskname="${val.lesson_additional_subchapter}" data-tasks="${tsks}" data-lessonsrc="${v.ind}" data-taskchapter="${val.lesson_additional_chapter}" value="${val.lesson_additional_id}" />
						<label class="form-check-label" onclick="getlessonbyid(${val.lesson_additional_id}, ${v.ind})">
							${val.lesson_additional_subchapter}
						</label>
					</div>
				`
			} else {
				bd1 += `
						<li class="list-group-item parent2" data-source="${bdi1}${bdi2}"><a href="#" style="color: black">${val.text}</a></li>
						${val.nodes.length > 0 ? child_body : ''}    
					`;
			}


			bdi2++;
		});

		let bd1_body = `
            <ul class="list-group hide list-group-flush head_parent2" id="i${bdi1}">
                ${bd1}
            </ul>
        `;

		content += `
            <li class="list-group-item bg-secondary parent1" data-source="${bdi1}"><a href="#"><h6 style="margin-top:5px">${v.text}</h6></a></li>
            ${v.nodes.length > 0 ? bd1_body : `<ul class="list-group list-group-flush hide task_child p-2" id="i${bdi1}">Materi Pelajaran tidak tersedia</ul>`}
        `;

		bdi1++;
	});

	let page = `
        <div id="idass_subj" data-subj="${subj}" data-subjname="${e.subjname}"></div>
        <div id="idass_grad" data-grad="${grad}" data-gradname="Kelas ${e.gradname}"></div>
        <ul class="list-group list-group-flush head_parent1">
            ${content}
        </ul>
    `;
	$("#treeview_task__").html(page);
}

function getlessonbyid(id, src) {
	grab_data_lesson(2, id, "", "", src);
}

function choose_task() {
	let task_less = $("input[name=task_choose]:checked").val();
	let task_name = $("input[name=task_choose]:checked").data("taskname");
	let task_chap = $("input[name=task_choose]:checked").data("taskchapter");
	let task_task = $("input[name=task_choose]:checked").data("tasks");
	let lessonsrc = $("input[name=task_choose]:checked").data("lessonsrc");
	let subj_ass = $("#idass_subj").data("subj");
	let subj_name = $("#idass_subj").data("subjname");
	let grad_ass = $("#idass_grad").data("grad");
	let grad_name = $("#idass_grad").data("gradname");

	let ssrc = ["Saya", "Standar", "Publik"];
	let txtsrc = "Materi " + ssrc[lessonsrc - 1]

	if (task_less != undefined) {
		$("input[name=selected_task]")
			.val(task_chap + " - " + task_name)
			.attr("readonly", true);
		$("input[name=lessonid]").val(task_less);
		$("input[name=lessonsrc]").val(lessonsrc);
		$("input[name=selected_subj]")
			.val(subj_name + " - " + grad_name)
			.attr("readonly", true);
		$("input[name=subjid]").val(subj_ass);
		$("input[name=selected_grad]").val(grad_name).attr("readonly", true);
		$("input[name=source_lesson_task]").val(txtsrc).attr("readonly", true);
		$("input[name=gradid]").val(grad_ass);

		if (task_task < 1) {
			$('#no_tasks_message').html(`Materi ${task_chap + " - " + task_name} tidak memiliki soal latihan!`)
			$('#no_tasks_alert').removeClass('hide')
			$('#tsks_ext').remove()
		}

		$("#modal_task_ch").modal("show");
		get_religion();
		set_datepicker();
		check_group(subj_ass, grad_ass);

	} else {
		$("#select_tk_alert").removeClass("hide");
		setTimeout(function () {
			$("#select_tk_alert").addClass("hide");
		}, 5000);
	}
}

function clear_form_task() {
	$("input[name=title]").val('')
	$("input[name=selected_subj]").val('')
	$("input[name=subjid]").val('')
	$("#start_task").val('')
	$("#end_task").val('')
	$("#instruction_task > .ql-editor").html('<p><br></p>')

	$(".inpsubm").html('<input class="form-check-input asscheck w-45px h-30px" type="checkbox" id="autosumbit">');
	$(".inpreli").html('<input class="form-check-input asscheck" name="religion_assign" id="religion_assign" type="checkbox" value="1">');

	$('.end_ass').addClass('hide')
	$('.start_ass').addClass('hide')
	$('.group_ass').addClass('hide')
	$('.title_ass').addClass('hide')
	$('.selreli').addClass('hide')
}

function show_prev() {
	clear_form_task()
	$('#modal_task_ch').modal('hide')
	$('#task_prev_less').modal('show')
}

function save_task(status = null, save_type = null) {
	let id_task_ = $("input[name=task_id]").val();
	let lesson_name = $("input[name=selected_task]").val();
	let subj_name = $("input[name=selected_subj]").val();
	let lesson = $("input[name=lessonid]").val();
	let lessonsrc = $("input[name=lessonsrc]").val();
	let subj = $("input[name=subjid]").val();
	let grad = $("input[name=gradid]").val();
	let title = $("input[name=title]").val();
	let group = $("#multiple-select-group").select2("data");
	let start = $("#start_task").val();
	let end = $("#end_task").val();
	let submit = $("#autosumbit").hasClass("checked");
	let reli_sel = $('#select_religion_test').val();
	let isreli = $("#religion_assign").hasClass("checked");

	let reli_sts = isreli ? (reli_sel != 0 ? true : false) : true;

	let instask = ''
	if (save_type == 2) {
		instask = $("#instruction_task_upd > .ql-editor").html();
	} else {
		instask = $("#instruction_task > .ql-editor").html();
	}

	let msg = ["title_ass", "group_ass", "start_ass", "end_ass", "reli_ass"];
	let chk = [title != "", group.length > 0, start != "", end != "", reli_sts];

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
		if (chk_range_task(save_type) == 1) {
			let data = [
				title,
				subj,
				grad,
				group,
				start,
				end,
				submit ? 0 : 1,
				instask,
				lesson,
				lesson_name,
				subj_name,
				lessonsrc,
				status,
				save_type,
				reli_sel,
			];

			store_task(1, id_task_, JSON.stringify(data));
			$('#content_tab_ct').addClass('hide')
		} else {
			let msg =
				chk_range_task() == 2
					? "Periode awal tidak boleh lebih besar dari periode akhir!"
					: "Periode awal tidak boleh lebih kecil dari hari ini!";
			$(".anom_period").html(msg).removeClass("hide");
			// toast_act('','Periode tidak sesuai!', 'error')
		}
	}
}

function close_mdl_task_choose() {
	$("#modal_task_choose").modal("hide");
	$('#preview_task').html('')
}

function store_task(type, id, param, title = null) {
	$.ajax({
		url: base_url + "/teacher/task/store-data",
		data: { type, id, param, title },
		method: "post",
		dataType: "json",
		beforeSend: function () {
			show_loading()
		},
		success: function (e) {
			// $("#modal_task_choose").modal("hide");
			close_mdl_task_choose()
			$("#modal_task_upd").modal("hide");
			$("#modal_task_ch").modal("hide");
			$("#task_prev_less").modal("hide");
			reload_tabulator();
			Toast.fire({
				icon: e.icn,
				title: e.msg,
			});
			hide_modal()
			hide_loading()
		},
	});
}

function edit_task(id) {
	$.ajax({
		url: base_url + "/teacher/task/get-edit",
		data: { id },
		method: "post",
		dataType: "json",
		beforeSend: function () {
			show_loading()
		},
		success: function (e) {
			check_group(e.task_subject_id, e.task_grade);
			set_datepicker();
			setTimeout(function () {
				view_edit_task(e);
			}, 1000);
		},
	});
}

function view_edit_task(e) {
	get_religion(parseInt(e.task_religion))
	let title_chap = ''
	if (e.task_lesson_src == 2) {
		title_chap = e.lesson_standart_chapter + ' - ' + e.lesson_standart_subchapter
	} else {
		title_chap = e.lesson_additional_chapter + ' - ' + e.lesson_additional_subchapter
	}

	$("input[name=task_id]").val(e.task_id);
	$("input[name=subjid]").val(e.task_subject_id);
	$("input[name=gradid]").val(e.task_grade);
	$("input[name=lessonid]").val(e.task_lesson_id);
	$("input[name=lessonsrc]").val(e.task_lesson_src);
	$("input[name=selected_task]").val(title_chap);
	$("input[name=selected_subj]").val(e.subject_name + ' - Kelas ' + e.task_grade);
	$("input[name=title]").val(e.task_title);

	let ssrc = ["Saya", "Standar", "Publik"];
	let txtsrc = "Materi " + ssrc[e.task_lesson_src - 1]

	$("input[name=source_lesson_task]").val(txtsrc);

	let start = e.task_start.substring(0, 16);
	let end = e.task_end.substring(0, 16);
	$("#old_start_task").val(start);
	$("#start_task").val(start);
	$("#end_task").val(end);

	if (e.task_is_ignored_time_submit == 0) {
		$("#autosumbit").addClass("checked").prop("checked", true);
	} else {
		$("#autosumbit").removeClass("checked").prop("checked", false);
	}

	if (parseInt(e.task_religion) > 0) {
		$("#religion_assign").addClass("checked").prop("checked", true);
		$(".selreli").removeClass("hide");
	} else {
		$("#religion_assign").removeClass("checked").prop("checked", false);
	}

	if (e.task_task_ids == null || e.task_task_ids == "") {
		$('#edt_tsk_').addClass('hide')
	} else {
		$('#edt_tsk_').removeClass('hide')
	}

	let selected_group = [];
	$.each(JSON.parse(e.task_group), function (i, v) {
		selected_group.push(v.id);
	});
	$("#multiple-select-group").val(selected_group).trigger("change");

	$("#instruction_task_upd > .ql-editor").html(e.task_instruction);

	$('#modal_task_upd').modal('show')
}

function lesson_preview(id, src, task_id) {
	if (id != "") {
		$.ajax({
			url: base_url + "/teacher/task/task-lesson",
			data: { id, src, task_id },
			method: "post",
			dataType: "json",
			beforeSend: function () {
				show_loading()
			},
			success: function (e) {
				generate_view_lesson_p(e.lesson);
				generate_view_video_p(e.lesson);
				generate_view_attachment_p(e.lesson);
				generate_view_task_p(
					e.task.task_task_ids != '' ? JSON.parse(e.task.task_task_ids) : [],
					e.lesson.lesson_additional_id,
					e.lesson.lesson_additional_subject_id,
					e.lesson.lesson_additional_grade
				);
				$("#task_prev_less").modal("show");
				hide_loading()
			},
		});
	}
}

function view_quest_bank(id, subj, grad) {
	let title = $('#tt' + id).data('title');
	$.ajax({
		url: base_url + "/teacher/lesson/additional/question-bank",
		data: { subj, grad },
		method: "post",
		dataType: "json",
		beforeSend: function () {
			show_loading()
		},
		success: function (e) {
			choose_task_view(e, id, title);
			$("#modal_task_choose").modal("show");
			hide_loading()
		},
	});
}

function choose_task_view(e, id, title) {
	let content = "";
	let i1 = 1;
	$.each(e, function (i, v) {
		let ch1 = "";
		let i2 = 1;
		$.each(v.content, function (idx, val) {
			let child = "";
			let ii = 1;
			$.each(val["child"], function (index, value) {
				child += `
              <div class="form-check my-2">
                  <input class="form-check-input" type="checkbox" name="task_${i1}" value="${value.id}" />
                  <label class="form-check-label" onclick="view_task(${i1}, ${value.id})">
                      Soal ${ii}
                  </label>
              </div>
              `;
				ii++;
				// <li class="list-group-item">Soal ${ii}</li>
			});

			let child_body = `
               <ul class="list-group list-group-flush hide task_child" id="i${i1}${i2}" style="padding-left: 10px">
                  ${child}
              </ul>
          `;

			ch1 += `
              <li class="list-group-item parent2" data-source="${i1}${i2}"><a href="#" style="color: black">${val.title}</a></li>
              ${val.child.length > 0 ? child_body : ''}    
          `;

			i2++;
		});

		let ch1_body = `
          <ul class="list-group list-group-flush hide head_parent2" id="i${i1}">
              ${ch1}
          </ul>
      `;
		content += `
          <li class="list-group-item bg-secondary parent1" data-source="${i1}"><a href="#"><h6 style="margin-top:5px">${v.head}</h6></a></li>
          ${v.content.length > 0 ? ch1_body : `<ul class="list-group list-group-flush hide head_parent2" id="i${i1}"><li class="list-group-item">Soal belum tersedia.</li></ul>`}
      `;

		i1++;
	});

	let page = `
    <input type="hidden" name="task_id_upd" value="${id}" />
    <input type="hidden" name="title_task" value="${title}" />
      <ul class="list-group list-group-flush head_parent1">
          ${content}
      </ul>
  `;

	$("#view_select_task").html(page);
}

function selected_task() {
	let title = $('input[name=title_task]').val()
	let std_task = [];
	$('input[name="task_1"]:checked').each(function () {
		std_task.push(this.value);
	});

	let me_task = [];
	$('input[name="task_2"]:checked').each(function () {
		me_task.push(this.value);
	});

	let pub_task = [];
	$('input[name="task_3"]:checked').each(function () {
		pub_task.push(this.value);
	});

	let idt = $("input[name=task_id_upd]").val();

	let send_std = std_task.length > 0 ? std_task : "empty";
	let send_me = me_task.length > 0 ? me_task : "empty";
	let send_pub = pub_task.length > 0 ? pub_task : "empty";

	store_task(3, idt, [send_std, send_me, send_pub, title]);
}

function type_task(type, ids, sts, titles = []) {
	let msg = ''
	if (sts == 9) {
		msg = 'hapus'
	} else if (sts == 2) {
		msg = 'terbitkan'
	} else if (sts == 1) {
		msg = 'batalkan'
	} else if (sts == 3) {
		msg = 'tampilkan petunjuk'
	} else if (sts == 4) {
		msg = 'sembunyikan petunjuk'
	} else if (sts == 5) {
		msg = 'tampilkan penjelasan'
	} else if (sts == 6) {
		msg = 'sembunyikan penjelasan'
	} else if (sts == 7) {
		msg = 'tampilkan jawaban benar'
	} else if (sts == 8) {
		msg = 'sembunyikan jawaban benar'
	} else if (sts == 10) {
		msg = 'aktifkan batas waktu'
	} else if (sts == 11) {
		msg = 'abaikan batas waktu'
	}

	Swal.fire({
		html: `Apakah anda yakin ${msg} ${ids.length} tugas terpilih?`,
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
			store_task(type, ids, sts, titles);
		}
	});
}

function reload_tabulator() {
	if (url.includes("teacher/task/index-draft")) {
		task_draft.replaceData();
	} else if (url.includes("teacher/task/index-scheduled")) {
		task_scheduled.replaceData();
	} else if (url.includes("teacher/task/index-present")) {
		task_present.replaceData();
	} else if (url.includes("teacher/task/index-done")) {
		task_done.replaceData();
	} else if (url.includes("student/task/present")) {
		task_presents.replaceData();
	}
}

function begin_task(id, temp, title) {
	if (temp < 1) {
		Swal.fire({
			html: `Apakah anda yakin ingin mulai mengerjakan tugas <b>${title}</b>?`,
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
				get_task(id, temp, title)
			}
		});
	} else {
		get_task(id, temp, title)
	}
}

function get_task(id, temp, title) {
	$.ajax({
		url: base_url + "/student/task/act-get-task",
		data: { id, temp, title },
		method: "post",
		dataType: "json",
		beforeSend: function () {
			show_loading()
		},
		success: function (e) {
			$('input[name=tid]').val(e.task_id)
			task_page(e)
			hide_loading()
		},
	});
}

function task_page(e = null) {
	let my_task = localStorage.getItem(e.key)
	if (!my_task) {
		if (e.value) {
			localStorage.setItem(e.key, JSON.stringify(e.value))

			my_task = localStorage.getItem(e.key)
			actview_task(my_task, 0, false, e.tasks)
			$('#task_modal_question').modal('show')
		}
	} else {
		actview_task(my_task, 0, false, e.tasks)
		$('#task_modal_question').modal('show')
	}
}

function actview_task(e, idx = 0, fix = false, ids = []) {
	let data = JSON.parse(e)

	$('#mdltitle_tsk').html(data.title)
	$('#sbtl_tsk').html(data.subject)

	if (Object.keys(ids).length > 0) {
		let number_quest = ''
		let num = 1
		$.each(data.tasks, function (i, v) {
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

			number_quest += `<a href="#" onclick="view_question_act_tsk(${v.question_id})" class="m-1 btn btn-icon  ${btnn} actbtn">${num}</a>`
			num++
		})

		if (!fix) {
			if (idx > 0) {
				view_question_act_tsk(Object.keys(data.tasks[idx]))
			} else {
				view_question_act_tsk(Object.keys(data.tasks)[0])
			}
		}

		let nquest = `
    <div class="alert bg-light border border-dark">
    <span class="d-block fw-semibold text-start py-2 px-3">
    <span class="fw-bold d-block fs-3 text-dark mb-2">Nomor Soal</span>
    ${number_quest}
    </div>
  `

		$('#list_taskact').html(nquest);
	} else {
		$('#list_taskact').html('<h5>Latihan tidak tersedia.</h5>');
	}

	generate_view_lesson_p(data.lesson)
	generate_view_video_p(data.lesson)
	generate_view_attachment_p(data.lesson)

	if (data.ignore_time != 1) {
		let enddate = new Date(data.end)
		let current = new Date(datetimenow);

		if (enddate < current) {
			send_task_act(2)
		}
	}
}

function view_question_act_tsk(id) {
	let tid = $('input[name=tid]').val()

	let my_tasks = localStorage.getItem('bluecode_' + student_id + '_' + tid)
	let data = JSON.parse(my_tasks)
	let row = data.tasks[id]
	let qtype = data.tasks[id].type
	let student_answer = data.tasks[id].student_answer

	if (data.show_hint == 1) {
		$('#view_hint_tsk').remove()
		$('#col_questansw_tsk').removeClass('col-sm-12').addClass('col-sm-8')
		let shint = row.hint != '<p><br></p>' ? row.hint : '-'
		let hint = `
      <div class="alert bg-light-dark border border-dark d-flex flex-column flex-sm-row">
      <span class="d-block fw-semibold text-start py-2 px-3">
        <span class="fw-bold d-block fs-3 text-dark mb-2">Pentunjuk</span>
        <span class="fw-semibold fs-3 text-dark">
          ${shint}
        </span>
      </span>
    </div>
    `

		$('#col_hinttsk').before(`<div class="col-sm-4" id="view_hint_tsk">${hint}</div>`)
	}

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
		let is_choose = student_answer.includes(i) ? 'chk_act_tsk' : ''
		let is_checked = student_answer.includes(i) ? 'checked="checked"' : ''

		option += `
    <div class="col-sm-6">
      <input type="${type}" data-question_id="${id}" data-type="${type}" class="btn-check tglchk_tsk ${is_choose}" ${is_checked} name="choose_opt" value="${i}" id="kt_choose_${num}" />
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

	$('#acttask_question').html(question)

	if (qtype < 4) {
		$('#acttask_option').html(`<div class="row">${option}</div>`)
		$('#acttask_essay_answer').html(``)
	} else {
		$('#acttask_option').html(``)
		$('#acttask_essay_answer').html(`<div id="tsk_essay_answer" class="ansessay" data-id="${id}" style="height: 250px"></div>`)

		var Delta = Quill.import('delta');
		var tsk_essay_answer = new Quill("#tsk_essay_answer", {
			modules: {
				toolbar: toolbarOptions,
			},
			theme: "snow", // or 'bubble'
		});

		var change = new Delta();
		tsk_essay_answer.on('text-change', function (delta) {
			autosave_essay_tsk()
			change = change.compose(delta);
		});

		let sans = data.tasks[id].student_answer
		if (sans != "[]") {
			$("#tsk_essay_answer > .ql-editor").html(sans);
		}
	}
}

function autosave_essay_tsk() {
	let id = $('#tsk_essay_answer').data('id')
	let tid = $('input[name=tid]').val()

	if (id != undefined) {
		let my_tasks = localStorage.getItem('bluecode_' + student_id + '_' + tid)
		let data = JSON.parse(my_tasks)
		let qtype = data.tasks[id].type
		if (qtype == 4) {
			let ans = $("#tsk_essay_answer > .ql-editor").html()

			rans = ans == '<p><br></p>' ? "[]" : ans;
			change_localstorage_tsk('essay', id, rans, true)
		}
	}
}

function save_act_task() {
	$('#task_modal_question').modal('hide')
	send_task_act(1)
}

function alert_submit_task() {
	Swal.fire({
		html: `<h2>Apakah anda yakin?</h2><br><p>Jika sudah dikirimkan, maka tidak dapat mengubah atau mengulang tugas yang sama.</p>`,
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
			send_task_act(2)
		}
	});
}

$(document).on('click', '.tglchk_tsk', function () {
	let question_id = $(this).data('question_id')
	let quest_type = $(this).data('type')

	if (quest_type != 'radio') {
		$(this).toggleClass("chk_act_tsk");
	} else {
		if ($(this).hasClass('chk_act_tsk')) {
			$(this).removeClass('chk_act_tsk')
		} else {
			$(".tglchk_tsk").each(function () {
				if ($(this).hasClass("chk_act_tsk")) {
					$(this).removeClass("chk_act_tsk");
				}
			});
			$(this).toggleClass('chk_act_tsk');
		}
	}

	change_localstorage_tsk('option', question_id)
})

function change_localstorage_tsk(type, key, value = null, stay = false) {
	let tid = $('input[name=tid]').val()
	let key_storage = 'bluecode_' + student_id + '_' + tid;
	let my_data = JSON.parse(localStorage.getItem(key_storage))

	if (type == 'option') {
		let my_choose = []
		$(".tglchk_tsk").each(function () {
			if ($(this).hasClass('chk_act_tsk')) {
				my_choose.push($(this).val())
			}
		})
		localStorage.setItem('tsk_rcop_' + student_id + '_' + tid, JSON.stringify(my_choose))
		let rcop = localStorage.getItem('tsk_rcop_' + student_id + '_' + tid)

		my_data.tasks[key].student_answer = rcop
		localStorage.setItem(key_storage, JSON.stringify(my_data))

		let res_data = localStorage.getItem(key_storage)
		view_question_act_tsk(key)
		actview_task(res_data, key, true, my_data.tasks)
	} else if (type == 'essay') {
		my_data.tasks[key].student_answer = value
		localStorage.setItem(key_storage, JSON.stringify(my_data))

		let res_data = localStorage.getItem(key_storage)
		actview_task(res_data, key, true, my_data.tasks)
		if (!stay) {
			view_question_act_tsk(key)
		}
	}

}

function send_task_act(typ) {
	let tid = $('input[name=tid]').val()

	let row = JSON.parse(localStorage.getItem('bluecode_' + student_id + '_' + tid))
	let send = Object()

	if (typ == 1) {
		send.subject_id = row.subject_id
		send.title = row.title
		send.subject = row.subject
		send.task_id = row.task_id
		send.task_id = row.task_id
		send.data = localStorage.getItem('bluecode_' + student_id + '_' + tid)
		send.type = typ
	} else {
		send.task_id = row.task_id
		send.subject = row.subject
		send.task_title = row.title
		send.task_end = row.end
		send.task_start = row.start
		send.task_begin = row.begin_task

		let curr = new Date(datetimenow);
		let dtend = new Date(Date.parse(row.end));

		if (curr > dtend) {
			if (row.ignore_time == 0) {
				send.submit_msg = 'Submit Otomatis karena Melewati batas waktu'
				send.submit_type = 2
				send.autosubmit = 1
			} else {
				send.submit_msg = 'Melewati batas waktu'
				send.submit_type = 2
				send.autosubmit = 0
			}
		} else {
			send.submit_msg = 'Submit sebelum batas waktu'
			send.submit_type = 1
			send.autosubmit = 0
		}

		let student_answer = []
		$.each(row.tasks, function (i, v) {
			if (v.type != 4) {
				let answer = []
				$.each(JSON.parse(v.student_answer), function (idx, val) {
					answer.push(v.option[val])
				})

				student_answer.push({
					question_id: v.question_id,
					answer: v.student_answer != '[]' ? answer : ['empty'],
					question_type: v.type,
					source: v.source
				})
				send.answer = student_answer
			} else {
				student_answer.push({
					question_id: v.question_id,
					question_type: v.type,
					answer: v.student_answer != '[]' ? v.student_answer : ['empty'],
					source: v.source
				})
				send.answer = student_answer
			}
		})
		send.type = typ
	}

	$.ajax({
		url: base_url + "/student/task/save-action-task",
		data: { send },
		method: "post",
		dataType: "json",
		beforeSend: function () {
			show_loading()
		},
		success: function (e) {
			if (e.sts) {
				$('#task_modal_question').modal('hide')
				if (typ == 1) {
					Toast.fire({
						icon: e.icn,
						title: e.msg,
					});
				} else {
					Swal.fire({
						icon: e.icn,
						html: e.msg,
						confirmButtonText: "OK",
					})
				}
				localStorage.removeItem('bluecode_' + student_id + '_' + tid)
				localStorage.removeItem('tsk_rcop_' + student_id + '_' + tid)

				ajax_dash_student()
			} else {
				Swal.fire({
					icon: e.icn,
					html: e.msg,
					confirmButtonText: type < 2 ? "Simpan Ulang" : "Submit Ulang",
				}).then(function (confirm) {
					location.reload()
				})
				localStorage.removeItem('tsk_rcop_' + student_id + '_' + tid)
			}
			reload_tabulator()
			hide_loading()
		},
	});
}

$(document).on('click', '.view_student_task', function (e) {
	e.preventDefault()
	let task_id = $(this).data('task_id')
	let group_id = $(this).data('group_id')
	let task_title = $(this).data('task')

	$('#title_tsk_lsstd').html(`<span class="text-primary">${task_title}</span>`)
	student_act_tsk.setData(
		base_url + "/teacher/task/get-student-task?tid=" + task_id + "&gid=" + group_id
	);

	$('#modal_look_student_act_task').modal('show')
})

function data_result_student_tsk(result_id, chktrue, group_id) {
	$.ajax({
		url: base_url + "/teacher/task/check-result-task",
		data: { result_id },
		method: "post",
		dataType: "json",
		beforeSend: function () {
			show_loading()
		},
		success: function (e) {
			$('#btn_submit_checking_tsk').val(e.student_id)
			$('#result_id_tsk').val(e.result_id)
			$('#stu_id_tsk').val(e.student_id)
			$('#taskidd').val(e.task_id)
			$('#taskgroupid').val(group_id)
			$('#taskccheck').val(chktrue)
			$('#taskallpoints').val(e.allpoints)

			if (chktrue < 1) {
				$('#btnclschktsk').attr('onclick', 'close_checking_modal_tsk(3)')
				$('#btn_submit_checking_tsk').addClass('hide')
			} else {
				$('#btn_submit_checking_tsk').removeClass('hide')
			}

			checking_page_tsk(e)
			hide_loading()
		},
	});
}

function checking_page_tsk(e) {
	let my_task = localStorage.getItem(e.key)
	if (!my_task) {
		if (e.value) {
			localStorage.setItem(e.key, JSON.stringify(e.value))

			my_task = localStorage.getItem(e.key)
			actview_checking_tsk(e.student_id, my_task, 0, false)
			$('#checking_modal_question_tsk').modal('show')
		}
	} else {
		actview_checking_tsk(e.student_id, my_task, 0, false)
		$('#checking_modal_question_tsk').modal('show')
	}

	$('#modal_look_student_act_task').modal('hide')

	$('#ctt').html(e.student_name)
	$('#cstt2').html(e.task_title)
}

function actview_checking_tsk(sid, e, idx = 0, fix = false) {
	let data = JSON.parse(e)

	$('#cstt1').html(data.subject)
	
	let number_quest = ''
	let num = 1
	$.each(data.tasks, function (i, v) {
		let btnn = ''
		if (!fix) {
			if (num > 1) {
				if (v.checked != 0) {
					btnn = v.res_poin > 0 ? 'btn-success iss' : 'btn-danger isw'
				} else {
					btnn = 'btn-outline btn-outline-dark'
				}
			} else {
				if (v.checked != 0) {
					btnn = v.res_poin > 0 ? 'btn-primary iss' : 'btn-primary isw'
				} else {
					btnn = 'btn-primary'
				}
				// btnn = v.checked != 0 ? 'btn-primary iss' : 'btn-primary'
			}
		} else {
			if (idx == v.question_id) {
				if (v.checked != 0) {
					btnn = v.res_poin > 0 ? 'btn-primary iss' : 'btn-primary isw'
				} else {
					btnn = 'btn-primary'
				}
				// btnn = v.checked != 0 ? 'btn-primary iss' : 'btn-primary'
			} else {
				if (v.checked != 0) {
					btnn = v.res_poin > 0 ? 'btn-success iss' : 'btn-danger isw'
				} else {
					btnn = 'btn-outline btn-outline-dark'
				}
			}
		}

		number_quest += `<a href="#" onclick="view_question_act_chk_tsk('${v.question_id}', ${sid})" class="m-1 btn btn-icon  ${btnn} actbtn_s">${num}</a>`
		num++
	})

	if (!fix) {
		if (idx > 0) {
			view_question_act_chk_tsk(Object.keys(data.tasks[idx]), sid)
		} else {
			view_question_act_chk_tsk(Object.keys(data.tasks)[0], sid)
		}
	}

	let nquest = `
    <div class="alert bg-light border border-primary" style="min-height: 450px;">
    <span class="d-block fw-semibold text-start py-2 px-3">
    <span class="fw-bold d-block fs-3 text-primary mb-2">Nomor Soal</span>
    ${number_quest}
    </div>
  `
	$('#list_questions_tsk').html(nquest);
}

function view_question_act_chk_tsk(id, sid) {
	$('#check_answer_essay_tsk').html('')
	$('#checkpoin_tsk').html('')

	let tsk = $('input[name=taskidd]').val();

	let my_tasks = localStorage.getItem('aquacode_' + teacher_id + '_' + sid + '_' + tsk)
	let data = JSON.parse(my_tasks)

	let rrg = data.tasks[id].right_answer
	
	let row = data.tasks[id]
	let qtype = data.tasks[id].type
	let spoin = data.tasks[id].res_poin
	let poin = data.tasks[id].poin
	let student_answer = data.tasks[id].student_answer
	let right_answer = rrg != "" ? JSON.parse(rrg) : ""
	let nchk = data.tasks[id].note_check
	let ischk = data.tasks[id].checked

	let tpoint = 0;
	$.each(data.tasks, function (i, v) {
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

	let sas = qtype == 3 ? student_answer[0].map(function (x) { return parseInt(x, 10) }) : student_answer[0];
	let ras = qtype == 3 ? right_answer.map(function (x) { return parseInt(x, 10) }) : right_answer;

	$.each(row.option, function (i, v) {
		let btn_cls = 'bg-light-primary border border-primary'
		let txt_cls = "text-primary"
		if (sas.includes(v)) {
			txt_cls = "text-white"
			if (ras.includes(v)) {
				btn_cls = 'bg-success border border-success'
			} else {
				btn_cls = 'bg-warning border border-warning'
			}
		} else if (ras.includes(v)) {
			txt_cls = "text-white"
			btn_cls = 'bg-primary border border-primary'
		}

		let opt_val = row.type == 3 ? (v == 1 ? 'Benar' : 'Salah') : v
		option += `
    
    <div class="col-sm-6">
      <div class="alert ${btn_cls} d-flex flex-column flex-sm-row mb-5">
        <span class="d-block fw-semibold text-start py-2 px-3">
          <span class="fw-bold d-block fs-3 ${txt_cls} mb-2">Pilihan Jawaban ${num}</span>
          <span class="fw-bold fs-3 ${txt_cls}">
            ${opt_val}
          </span>
        </span>
      </div>
    </div>
    `
		num++;
	})

	$('#check_question_tsk').html(question)
	let setpoin = ''
	let colorcode = ''
	if (qtype < 4) {
		$('#check_answer_essay_tsk').html('')
		$('#check_answer_tsk').html(`<div class="row">${option}</div>`)

		//   colorcode = `
		//   <div id="code_color my-2" style="margin-top: 10px;">
		//     <span class="fw-bold d-block fs-3 text-primary mb-2">Kode Warna</span>
		//     <span class="btn btn-sm btn-warning">Jawaban Siswa</span><br>
		//     <span class="btn btn-sm btn-primary my-2">Jawaban Benar</span><br>
		//     <span class="btn btn-sm btn-success">Jawaban Tepat</span>
		//   </div>
		// `
	} else {
		$('#check_answer_tsk').html('')

		let formspoin = ''
		if (ischk == 1) {
			formspoin = `<input type="number" min="0" max="${poin}" class="form-control" id="percent_essay_poin_tsk" placeholder="Persen jawaban benar" value="${parseInt(spoin * 100)}" onchange="setpercent_tsk(${id}, ${poin}, ${sid}, ${tpoint})" style="border: 2px solid #5014D0">`
		} else {
			formspoin = `<input type="number" min="0" max="${poin}" class="form-control" id="percent_essay_poin_tsk" placeholder="Persen jawaban benar" onchange="setpercent(${id}, ${poin}, ${sid}, ${tpoint})" style="border: 2px solid #5014D0">`
		}

		setpoin = `
      <span class="fw-bold d-block fs-3 text-primary mb-2">Nilai %</span>
      <div class="d-flex justify-content-between">
        <div class="btn-group" style="width: 100%">
          <button class="btn ${ischk == 1 ? spoin / poin * 100 == 0 ? 'btn-primary' : 'btn-dark' : 'btn-dark'} btn_vlchk_tsk" data-key="${id}" data-poin="${poin}" data-sid="${sid}" data-val="0" type="button">0</button>
          <button class="btn ${ischk == 1 ? spoin / poin * 100 == 25 ? 'btn-primary' : 'btn-dark' : 'btn-dark'} btn_vlchk_tsk" data-key="${id}" data-poin="${poin}" data-sid="${sid}" data-val="25" type="button">25</button>
          <button class="btn ${ischk == 1 ? spoin / poin * 100 == 50 ? 'btn-primary' : 'btn-dark' : 'btn-dark'} btn_vlchk_tsk" data-key="${id}" data-poin="${poin}" data-sid="${sid}" data-val="50" type="button">50</button>
          <button class="btn ${ischk == 1 ? spoin / poin * 100 == 75 ? 'btn-primary' : 'btn-dark' : 'btn-dark'} btn_vlchk_tsk" data-key="${id}" data-poin="${poin}" data-sid="${sid}" data-val="75" type="button">75</button>
          <button class="btn ${ischk == 1 ? spoin / poin * 100 == 100 ? 'btn-primary' : 'btn-dark' : 'btn-dark'} btn_vlchk_tsk" data-key="${id}" data-poin="${poin}" data-sid="${sid}" data-val="100" type="button">100</button>
        </div>
      </div>
      <p class="text-danger err_poin_tsk hide">Nilai maksimal dibatasi hanya 100!</p>
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
		$('#check_answer_essay_tsk').html(essay)
	}

	let checkpoin = `
  <div class="alert bg-light border border-primary">
    <span class="d-block fw-semibold text-start py-2 px-3">
      <div class="d-flex justify-content-between mb-3">
        <badge class="badge badge-info fs-3 p-5">Poin : ${poin}<span class="fw-bold fs-6">/${spoin}</span></badge>
        <badge class="badge badge-success fs-3 p-5"><b id="allpoint_tsk">Total Poin : ${tpoint % 1 == 0 ? tpoint : tpoint.toFixed(2)}</b></badge>
        <input type="hidden" name="allpoint_tsk" value="${tpoint}"/>
      </div>
      ${setpoin}
      <span class="fw-bold d-block fs-3 text-primary my-2 ">Catatan</span>
      <div id="checked_note_tsk" style="height: 250px"></div>
      ${colorcode}
    </span>
  </div>  
  `;

	var Delta = Quill.import('delta');
	$('#checkpoin_tsk').html(checkpoin)
	var checked_note = new Quill("#checked_note_tsk", {
		modules: {
			toolbar: toolbarOptions,
		},
		theme: "snow", // or 'bubble'
	});

	var change = new Delta();
	checked_note.on('text-change', function (delta) {
		autosave_check_note_tsk(id, sid)
		change = change.compose(delta);
	});

	$("#checked_note_tsk > .ql-editor").html(nchk != '' ? nchk : '<p><br></p>');
}

$(document).on('click', '.btn_vlchk_tsk', function (e) {
	e.preventDefault()
	let val = $(this).data('val')
	let sid = $(this).data('sid')
	let key = $(this).data('key')
	let poin = $(this).data('poin')
	let allpoint = $('input[name=allpoint_tsk]').val()

	let nval = val * poin / 100;
	let newpoint = parseFloat(allpoint) + parseFloat(nval)

	$('#percent_essay_poin_tsk').val(parseFloat(val))
	$('#allpoint_tsk').html('Total Poin : ' + newpoint)

	update_localstorage_chk_tsk(sid, 'checking', key, nval)
})

function autosave_check_note_tsk(key, sid) {
	let note = $("#checked_note_tsk > .ql-editor").html()
	update_localstorage_chk_tsk(sid, 'check_note', key, note)
}

function setpercent(key, val, sid, tpoint) {
	spoin = $('#percent_essay_poin_tsk').val();
	if (spoin <= 100) {
		let nval = spoin * val / 100;

		let newpoint = parseFloat(tpoint) + parseFloat(nval)
		$('#allpoint_tsk').html('Total Poin : ' + newpoint)

		update_localstorage_chk_tsk(sid, 'checking', key, nval)
		$('.err_poin_tsk').addClass('hide')
	} else {
		$('.err_poin_tsk').removeClass('hide')
	}
}

function update_localstorage_chk_tsk(sid, type, key, value = null) {
	let tsk = $('input[name=taskidd]').val();
	let key_storage = 'aquacode_' + teacher_id + '_' + sid + '_' + tsk;
	let my_data = JSON.parse(localStorage.getItem(key_storage))

	if (type == 'checking') {
		// let chk = value > 0 ? 1 : 0;
		my_data.tasks[key].student_poin = value
		my_data.tasks[key].res_poin = value
		my_data.tasks[key].checked = 1
		localStorage.setItem(key_storage, JSON.stringify(my_data))

		let res_data = localStorage.getItem(key_storage)
		view_question_act_chk_tsk(key, sid)
		actview_checking_tsk(sid, res_data, key, true)
	} else if (type == 'check_note') {
		let notes = value != '<p><br></p>' ? value : "";
		my_data.tasks[key].note_check = notes

		localStorage.setItem(key_storage, JSON.stringify(my_data))
	}
}

function act_close_chkmdl_tsk(task_id = null, group_id = null) {
	if (task_id != null && group_id != null) {
		student_act_tsk.setData(
			base_url + "/teacher/task/get-student-task?tid=" + task_id + "&gid=" + group_id
		);
	}

	$('#checking_modal_question_tsk').modal('hide')
	$('#modal_look_student_act_task').modal('show')

	let sid = $('#btn_submit_checking_tsk').val()
	let tsk = $('input[name=taskidd]').val();

	let key_storage = 'aquacode_' + teacher_id + '_' + sid + '_' + tsk;
	localStorage.removeItem(key_storage)
}

function close_checking_modal_tsk(type = 1, task_id = null, group_id = null) {
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
				act_close_chkmdl_tsk()
			}
		});
	} else if (type == 2) {
		act_close_chkmdl_tsk(task_id, group_id)
		if (url.includes("dashboard/teacher")) {
			ajax_dash_teacher()
		}
	} else {
		act_close_chkmdl_tsk()
	}
}

$('#btn_submit_checking_tsk').on('click', function () {
	let sid = $(this).val()
	let resid = $('#result_id_tsk').val()
	let tsk = $('input[name=taskidd]').val();
	let student = $('#ctt').html()
	let title = $('#cstt2').html()
	let allpoints = $('input[name=taskallpoints]').val();
	let task_id = $('input[name=taskidd]').val();
	let group_id = $('input[name=taskgroupid]').val();

	let key_storage = 'aquacode_' + teacher_id + '_' + sid + '_' + tsk;
	let my_data = JSON.parse(localStorage.getItem(key_storage))

	let status_checked = [];
	$.each(my_data.tasks, function (i, v) {
		if (v.checked == 1) {
			status_checked.push(true)
		} else {
			status_checked.push(false)
		}
	})

	if (status_checked.includes(false)) {
		toast_act('Gagal!', 'Masih ada yang belum diperiksa!', 'error')
	} else {
		submit_checking_act_tsk(my_data, resid, student, title, sid, allpoints, task_id, group_id)
	}
})

function submit_checking_act_tsk(e, res, student, title, sid, allpoints, task_id, group_id) {
	let result = e.tasks

	$.ajax({
		url: base_url + "/teacher/task/submit-check-task",
		data: { res, result, student, title, sid, allpoints },
		method: "post",
		dataType: "json",
		beforeSend: function () {
			show_loading()
		},
		success: function (e) {
			if (e.sts) {
				close_checking_modal_tsk(2, task_id, group_id)
			}
			toast_act('', e.msg, e.icn)
			hide_loading()
		},
	});
}

if (url.includes("teacher/task/index-draft")) {
	let c = [
		// { title: "#Aksi", field: "acts", width: 150, formatter: "html", headerVisible:false},
		{ title: "ID", field: "id", sorter: "string", width: 200, visible: false },
		{ title: "Akhir", field: "end_date", visible: false },
		{ title: "Tasks", field: "task_ids", visible: false },
		{ field: "lists", formatter: "html", headerFilter: "input", headerSort: false },
	];

	tbconf.columns = c;
	var task_draft = new Tabulator("#task_draft_table", tbconf);
} else if (url.includes("teacher/task/index-scheduled")) {
	let c = [
		{ title: "ID", field: "id", sorter: "string", width: 200, visible: false },
		{ title: "Akhir", field: "end_date", visible: false },
		{ field: "lists", formatter: "html", headerFilter: "input", headerSort: false },
	];

	tbconf.columns = c;
	var task_scheduled = new Tabulator("#task_scheduled_table", tbconf);
} else if (url.includes("teacher/task/index-present")) {
	let c = [
		{ field: "lists", formatter: "html", headerFilter: "input", headerSort: false },
	];

	tbconf.columns = c;
	tbconf.selectableRows = true;
	var task_present = new Tabulator("#task_present_table", tbconf);

	let cl = [
		{ title: "ID", field: "id", sorter: "string", width: 200, visible: false },
		{ field: "lists", formatter: "html", headerFilter: "input", headerSort: false },
	]

	tbconf.columns = cl;
	tbconf.selectableRows = false;
	var student_act_tsk = new Tabulator('#task_student_act', tbconf)
} else if (url.includes("teacher/task/index-done")) {
	let c = [
		{ field: "lists", formatter: "html", headerFilter: "input", headerSort: false },
	];

	tbconf.columns = c;
	tbconf.selectableRows = false;
	var task_done = new Tabulator("#task_done_table", tbconf);

	let cl = [
		{ title: "ID", field: "id", sorter: "string", width: 200, visible: false },
		{ field: "lists", formatter: "html", headerFilter: "input", headerSort: false },
	]

	tbconf.columns = cl;
	tbconf.selectableRows = false;
	var student_act_tsk = new Tabulator('#task_student_act', tbconf)
} else if (url.includes("student/task/present")) {
	let c = [
		{ field: "lists", formatter: "html", headerFilter: "input", headerSort: false },
	];

	tbconf.columns = c;
	tbconf.selectableRows = false;
	var task_presents = new Tabulator("#task_presents_table", tbconf);
} else if (url.includes("student/task/done")) {
	let c = [
		{ field: "lists", formatter: "html", headerFilter: "input", headerSort: false },
	];

	tbconf.columns = c;
	tbconf.selectableRows = false;
	var task_dones = new Tabulator("#task_dones_table", tbconf);
} else if (url.includes("student/task/missed")) {
	let c = [
		{ field: "lists", formatter: "html", headerFilter: "input", headerSort: false },
	];

	tbconf.columns = c;
	tbconf.selectableRows = false;
	var task_misseds = new Tabulator("#task_misseds_table", tbconf);
}

if (url.includes("teacher/task")) {
	if (url.includes("task/index-draft")) {
		document
			.getElementById("select-all")
			.addEventListener("click", function () {
				task_draft.selectRow();
			});

		document
			.getElementById("deselect-all")
			.addEventListener("click", function () {
				task_draft.deselectRow();
			});

		document
			.getElementById("publish-btn")
			.addEventListener("click", function () {
				let sel_data = task_draft.getSelectedData();
				let ids = sel_data.map((i) => i.id);
				let eds = sel_data.map((i) => i.end_date);
				let titles = sel_data.map((i) => i.title);
				let tasks = sel_data.map((i) => i.task_ext);

				if (ids.length < 1) {
					toast_act('', "Belum ada data terpilih", "error");
				} else {
					if (tasks.includes(0)) {
						toast_act('',
							"Tidak bisa diterbitkan karena terdapat materi yang tidak memiliki soal latihan",
							"error"
						);
						return false;
					}

					if (check_good_date(eds)) {
						toast_act('',
							"Tidak bisa diterbitkan karena terdapat data kedaluarsa",
							"error"
						);
						return false;
					}

					type_task(2, ids, 2, titles);
				}
			});

		document
			.getElementById("delete-btn")
			.addEventListener("click", function () {
				let sel_data = task_draft.getSelectedData();
				let ids = sel_data.map((i) => i.id);
				let titles = sel_data.map((i) => i.title);
				if (ids.length < 1) {
					toast_act('', "Belum ada data terpilih", "error");
				} else {
					type_task(2, ids, 9, titles);
				}
			});

		document
			.getElementById("show-hint-btn")
			.addEventListener("click", function () {
				let sel_data = task_draft.getSelectedData();
				let ids = sel_data.map((i) => i.id);
				let titles = sel_data.map((i) => i.title);
				if (ids.length < 1) {
					toast_act('', "Belum ada data terpilih", "error");
				} else {
					type_task(2, ids, 3, titles);
				}
			});

		document
			.getElementById("hide-hint-btn")
			.addEventListener("click", function () {
				let sel_data = task_draft.getSelectedData();
				let ids = sel_data.map((i) => i.id);
				let titles = sel_data.map((i) => i.title);
				if (ids.length < 1) {
					toast_act('', "Belum ada data terpilih", "error");
				} else {
					type_task(2, ids, 4, titles);
				}
			});

		document
			.getElementById("active-time-btn")
			.addEventListener("click", function () {
				let sel_data = task_draft.getSelectedData();
				let ids = sel_data.map((i) => i.id);
				let titles = sel_data.map((i) => i.title);
				if (ids.length < 1) {
					toast_act('', "Belum ada data terpilih", "error");
				} else {
					type_task(2, ids, 10, titles);
				}
			});

		document
			.getElementById("ignore-time-btn")
			.addEventListener("click", function () {
				let sel_data = task_draft.getSelectedData();
				let ids = sel_data.map((i) => i.id);
				let titles = sel_data.map((i) => i.title);
				if (ids.length < 1) {
					toast_act('', "Belum ada data terpilih", "error");
				} else {
					type_task(2, ids, 11, titles);
				}
			});
	}

	if (url.includes("task/index-scheduled")) {
		document
			.getElementById("select-all")
			.addEventListener("click", function () {
				task_scheduled.selectRow();
			});

		document
			.getElementById("deselect-all")
			.addEventListener("click", function () {
				task_scheduled.deselectRow();
			});

		document
			.getElementById("unpublish-btn")
			.addEventListener("click", function () {
				let sel_data = task_scheduled.getSelectedData();
				let ids = sel_data.map((i) => i.id);
				let titles = sel_data.map((i) => i.title);
				if (ids.length < 1) {
					toast_act('', "Belum ada data terpilih", "error");
				} else {
					type_task(2, ids, 1, titles);
				}
			});

		document
			.getElementById("show-hint-btn")
			.addEventListener("click", function () {
				let sel_data = task_scheduled.getSelectedData();
				let ids = sel_data.map((i) => i.id);
				let titles = sel_data.map((i) => i.title);
				if (ids.length < 1) {
					toast_act('', "Belum ada data terpilih", "error");
				} else {
					type_task(2, ids, 3, titles);
				}
			});

		document
			.getElementById("hide-hint-btn")
			.addEventListener("click", function () {
				let sel_data = task_scheduled.getSelectedData();
				let ids = sel_data.map((i) => i.id);
				let titles = sel_data.map((i) => i.title);
				if (ids.length < 1) {
					toast_act('', "Belum ada data terpilih", "error");
				} else {
					type_task(2, ids, 4, titles);
				}
			});

		document
			.getElementById("active-time-btn")
			.addEventListener("click", function () {
				let sel_data = task_scheduled.getSelectedData();
				let ids = sel_data.map((i) => i.id);
				let titles = sel_data.map((i) => i.title);
				if (ids.length < 1) {
					toast_act('', "Belum ada data terpilih", "error");
				} else {
					type_task(2, ids, 10, titles);
				}
			});

		document
			.getElementById("ignore-time-btn")
			.addEventListener("click", function () {
				let sel_data = task_scheduled.getSelectedData();
				let ids = sel_data.map((i) => i.id);
				let titles = sel_data.map((i) => i.title);
				if (ids.length < 1) {
					toast_act('', "Belum ada data terpilih", "error");
				} else {
					type_task(2, ids, 11, titles);
				}
			});
	}

	if (url.includes("task/index-present")) {
		document
			.getElementById("select-all")
			.addEventListener("click", function () {
				task_present.selectRow();
			});

		document
			.getElementById("deselect-all")
			.addEventListener("click", function () {
				task_present.deselectRow();
			});

		document
			.getElementById("active-time-btn")
			.addEventListener("click", function () {
				let sel_data = task_present.getSelectedData();
				let ids = sel_data.map((i) => i.id);
				let titles = sel_data.map((i) => i.title);
				if (ids.length < 1) {
					toast_act('', "Belum ada data terpilih", "error");
				} else {
					type_task(2, ids, 10, titles);
				}
			});

		document
			.getElementById("ignore-time-btn")
			.addEventListener("click", function () {
				let sel_data = task_present.getSelectedData();
				let ids = sel_data.map((i) => i.id);
				let titles = sel_data.map((i) => i.title);
				if (ids.length < 1) {
					toast_act('', "Belum ada data terpilih", "error");
				} else {
					type_task(2, ids, 11, titles);
				}
			});
	}

	if (url.includes("task/index-done")) {
		document
			.getElementById("select-all")
			.addEventListener("click", function () {
				task_done.selectRow();
			});

		document
			.getElementById("deselect-all")
			.addEventListener("click", function () {
				task_done.deselectRow();
			});

		document
			.getElementById("show-hint-btn")
			.addEventListener("click", function () {
				let sel_data = task_done.getSelectedData();
				let ids = sel_data.map((i) => i.id);
				let titles = sel_data.map((i) => i.title);
				if (ids.length < 1) {
					toast_act('', "Belum ada data terpilih", "error");
				} else {
					type_task(2, ids, 3, titles);
				}
			});

		document
			.getElementById("hide-hint-btn")
			.addEventListener("click", function () {
				let sel_data = task_done.getSelectedData();
				let ids = sel_data.map((i) => i.id);
				let titles = sel_data.map((i) => i.title);
				if (ids.length < 1) {
					toast_act('', "Belum ada data terpilih", "error");
				} else {
					type_task(2, ids, 4, titles);
				}
			});

		document
			.getElementById("show-explain-btn")
			.addEventListener("click", function () {
				let sel_data = task_done.getSelectedData();
				let ids = sel_data.map((i) => i.id);
				let titles = sel_data.map((i) => i.title);
				if (ids.length < 1) {
					toast_act('', "Belum ada data terpilih", "error");
				} else {
					type_task(2, ids, 5, titles);
				}
			});

		document
			.getElementById("hide-explain-btn")
			.addEventListener("click", function () {
				let sel_data = task_done.getSelectedData();
				let ids = sel_data.map((i) => i.id);
				let titles = sel_data.map((i) => i.title);
				if (ids.length < 1) {
					toast_act('', "Belum ada data terpilih", "error");
				} else {
					type_task(2, ids, 6, titles);
				}
			});

		document
			.getElementById("show-answer-btn")
			.addEventListener("click", function () {
				let sel_data = task_done.getSelectedData();
				let ids = sel_data.map((i) => i.id);
				let titles = sel_data.map((i) => i.title);
				if (ids.length < 1) {
					toast_act('', "Belum ada data terpilih", "error");
				} else {
					type_task(2, ids, 7, titles);
				}
			});

		document
			.getElementById("hide-answer-btn")
			.addEventListener("click", function () {
				let sel_data = task_done.getSelectedData();
				let ids = sel_data.map((i) => i.id);
				let titles = sel_data.map((i) => i.title);
				if (ids.length < 1) {
					toast_act('', "Belum ada data terpilih", "error");
				} else {
					type_task(2, ids, 8, titles);
				}
			});
	}
}

$(document).ready(function () {
	$('.tabulator-header-filter input').attr('placeholder', 'Cari data ...')
	if (url.includes("teacher/task/index-add")) {
		var instruction_task = new Quill("#instruction_task", {
			modules: {
				toolbar: toolbarOptions,
			},
			theme: "snow", // or 'bubble'
		});
	} else if (url.includes("teacher/task/index-draft")) {
		var instruction_task_upd = new Quill("#instruction_task_upd", {
			modules: {
				toolbar: toolbarOptions,
			},
			theme: "snow", // or 'bubble'
		});
		task_draft.setData(base_url + "/teacher/task/list-task?page-task=1");
	} else if (url.includes("teacher/task/index-scheduled")) {
		task_scheduled.setData(base_url + "/teacher/task/list-task?page-task=2");
	} else if (url.includes("teacher/task/index-present")) {
		task_present.setData(base_url + "/teacher/task/list-task?page-task=3");
	} else if (url.includes("teacher/task/index-done")) {
		task_done.setData(base_url + "/teacher/task/list-task?page-task=4");
	} else if (url.includes("student/task/present")) {
		task_presents.setData(base_url + "/student/task/list-task?page-task=1");
	} else if (url.includes("student/task/missed")) {
		task_misseds.setData(base_url + "/student/task/list-task?page-task=2");
	} else if (url.includes("student/task/done")) {
		task_dones.setData(base_url + "/student/task/list-task?page-task=3");
	}
});

function close_view_task_student() {
	$('#modal_look_student_act_task').modal('hide')
	$('#bd_list_task_student').html('<div id="task_student_act"></div>')
	let cl = [
		{ title: "ID", field: "id", sorter: "string", width: 200, visible: false },
		{ field: "lists", formatter: "html", headerFilter: "input", headerSort: false },
	]

	tbconf.columns = cl;
	tbconf.selectableRows = false;
	student_act_tsk = new Tabulator('#task_student_act', tbconf)
}

$(document).on('click', '.view_done_task', function (e) {
	e.preventDefault();

	let taskid = $(this).data('id');
	let studentid = $(this).data('student');
	let schoolid = $(this).data('school');
	$.ajax({
		url: base_url + "/student/task/get-task-done",
		data: { taskid, studentid, schoolid },
		method: "post",
		dataType: "json",
		beforeSend: function () {
			show_loading()
		},
		success: function (e) {
			$('#doneresult_id_tsk').val(e.result_id)
			$('#donestu_id_tsk').val(e.student_id)
			$('#donetaskid').val(e.task_id)
			checking_page_done_tsk(e)
			hide_loading()
		},
	})
})

function close_checking_mydone_task() {
	let tsk = $('input[name=donetaskid]').val();
	localStorage.removeItem('browncode_' + student_id + '_' + tsk)
	$('#checking_mydone_task').modal('hide')
}

function checking_page_done_tsk(e) {
	let my_task = localStorage.getItem(e.key)
	if (!my_task) {
		if (e.value) {
			localStorage.setItem(e.key, JSON.stringify(e.value))

			my_task = localStorage.getItem(e.key)
			actview_checking_done_tsk(e.student_id, my_task, 0, false)
			$('#checking_mydone_task').modal('show')
		}
	} else {
		actview_checking_done_tsk(e.student_id, my_task, 0, false)
		$('#checking_mydone_task').modal('show')
	}

	$('#donetaskname').html(e.task_title)
}

function actview_checking_done_tsk(sid, e, idx = 0, fix = false) {
	let data = JSON.parse(e)
	$('#donesubject').html(data.subject)

	let number_quest = ''
	let num = 1
	$.each(data.tasks, function (i, v) {
		let btnn = ''
		if (!fix) {
			if (num > 1) {
				if (v.checked != 0) {
					btnn = v.res_poin > 0 ? 'btn-success iss' : 'btn-danger isw'
				} else {
					btnn = 'btn-outline btn-outline-dark'
				}
			} else {
				if (v.checked != 0) {
					btnn = v.res_poin > 0 ? 'btn-primary iss' : 'btn-primary isw'
				} else {
					btnn = 'btn-primary'
				}
				// btnn = v.checked != 0 ? 'btn-primary iss' : 'btn-primary'
			}
		} else {
			if (idx == v.question_id) {
				if (v.checked != 0) {
					btnn = v.res_poin > 0 ? 'btn-primary iss' : 'btn-primary isw'
				} else {
					btnn = 'btn-primary'
				}
				// btnn = v.checked != 0 ? 'btn-primary iss' : 'btn-primary'
			} else {
				if (v.checked != 0) {
					btnn = v.res_poin > 0 ? 'btn-success iss' : 'btn-danger isw'
				} else {
					btnn = 'btn-outline btn-outline-dark'
				}
			}
		}

		number_quest += `<a href="#" onclick="view_question_act_chk_done_tsk('${v.question_id}', ${sid})" class="m-1 btn btn-icon  ${btnn} actbtn_s">${num}</a>`
		num++
	})

	if (!fix) {
		if (idx > 0) {
			view_question_act_chk_done_tsk(Object.keys(data.tasks[idx]), sid)
		} else {
			view_question_act_chk_done_tsk(Object.keys(data.tasks)[0], sid)
		}
	}

	let nquest = `
    <div class="alert bg-light border border-primary">
    <span class="d-block fw-semibold text-start py-2 px-3">
    <span class="fw-bold d-block fs-3 text-primary mb-2">Nomor Soal</span>
    ${number_quest}
    </div>
  `
	$('#list_questions_tsk_done').html(nquest);
}

function view_question_act_chk_done_tsk(id, sid) {
	$('#check_answer_essay_tskdone').html('')
	$('#checkpoin_tskdone').html('')

	let tsk = $('input[name=donetaskid]').val();

	let my_tasks = localStorage.getItem('browncode_' + student_id + '_' + tsk)
	let data = JSON.parse(my_tasks)

	let rra = data.tasks[id].right_answer

	let row = data.tasks[id]
	let qtype = data.tasks[id].type
	let spoin = data.tasks[id].res_poin
	let poin = data.tasks[id].poin
	let student_answer = data.tasks[id].student_answer
	let right_answer = rra != "" ? JSON.parse(rra) : ""
	let nchk = data.tasks[id].note_check
	let ischk = data.tasks[id].checked

	if (data.show_hint == 1) {
		let shint = row.hint != '<p><br></p>' ? row.hint : '-'
		let hint = `
		<div class="alert bg-light-dark border border-dark d-flex flex-column flex-sm-row">
		<span class="d-block fw-semibold text-start py-2 px-3">
			<span class="fw-bold d-block fs-3 text-dark mb-2">Pentunjuk</span>
			<span class="fw-semibold fs-3 text-dark">
			${shint}
			</span>
		</span>
		</div>
		`

		$('#check_hinttsk').html(hint)
	} else {
		$('#check_hinttsk').html('')
	}

	if (data.show_explain == 1) {
		let expl = row.explain != '<p><br></p>' ? row.explain : '-'
		let explain = `
		<div class="alert bg-light-dark border border-dark d-flex flex-column flex-sm-row">
		<span class="d-block fw-semibold text-start py-2 px-3">
			<span class="fw-bold d-block fs-3 text-dark mb-2">Penjelasan</span>
			<span class="fw-semibold fs-3 text-dark">
			${expl}
			</span>
		</span>
		</div>
		`

		$('#check_explaintsk').html(explain)
	} else {
		$('#check_explaintsk').html('')
	}

	let tpoint = 0;
	$.each(data.tasks, function (i, v) {
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

	let sas = qtype == 3 ? student_answer[0].map(function (x) { return parseInt(x, 10) }) : student_answer[0];
	let ras = qtype == 3 ? right_answer.map(function (x) { return parseInt(x, 10) }) : right_answer;

	$.each(row.option, function (i, v) {
		let btn_cls = 'bg-light-primary border border-primary'
		let txt_cls = "text-primary"
		if (sas.includes(v)) {
			txt_cls = "text-white"
			if (ras.includes(v)) {
				btn_cls = 'bg-success border border-success'
			} else {
				btn_cls = 'bg-warning border border-warning'
			}
		} else if (ras.includes(v)) {
			if (data.show_right_answer == 1) {
				txt_cls = "text-white"
				btn_cls = 'bg-primary border border-primary'
			}
		}

		let opt_val = row.type == 3 ? (v == 1 ? 'Benar' : 'Salah') : v
		option += `
		<div class="col-sm-6">
		<div class="alert ${btn_cls} d-flex flex-column flex-sm-row mb-5">
			<span class="d-block fw-semibold text-start py-2 px-3">
			<span class="fw-bold d-block fs-3 ${txt_cls} mb-2">Pilihan Jawaban ${num}</span>
			<span class="fw-bold fs-3 ${txt_cls}">
				${opt_val}
			</span>
			</span>
		</div>
		</div>
		`
		num++;
	})

	$('#check_question_tskdone').html(question)
	let setpoin = ''
	let colorcode = ''
	if (qtype < 4) {
		$('#check_answer_essay_tskdone').html('')
		$('#check_answer_tskdone').html(`<div class="row">${option}</div>`)

		//   colorcode = `
		//   <div id="code_color my-2" style="margin-top: 10px;">
		//     <span class="fw-bold d-block fs-3 text-primary mb-2">Kode Warna</span>
		//     <span class="btn btn-sm btn-warning">Jawaban Siswa</span><br>
		//     <span class="btn btn-sm btn-primary my-2">Jawaban Benar</span><br>
		//     <span class="btn btn-sm btn-success">Jawaban Tepat</span>
		//   </div>
		// `
	} else {
		$('#check_answer_tskdone').html('')

		let formspoin = ''
		if (ischk == 1) {
			formspoin = `<input type="number" min="0" max="${poin}" class="form-control" id="percent_essay_poin_tsk" placeholder="Persen jawaban benar" value="${parseInt(spoin * 100)}" onchange="setpercent_tsk(${id}, ${poin}, ${sid}, ${tpoint})" style="border: 2px solid #5014D0">`
		} else {
			formspoin = `<input type="number" min="0" max="${poin}" class="form-control" id="percent_essay_poin_tsk" placeholder="Persen jawaban benar" onchange="setpercent(${id}, ${poin}, ${sid}, ${tpoint})" style="border: 2px solid #5014D0">`
		}

		setpoin = `
      <span class="fw-bold d-block fs-3 text-primary mb-2">Nilai</span>
      <div class="d-flex justify-content-between">
        <div class="btn-group" style="width: 100%">
          <button class="btn ${ischk == 1 ? spoin / poin * 100 == 0 ? 'btn-info' : 'btn-primary' : 'btn-primary'} btn_vlchk_tsk" data-key="${id}" data-poin="${poin}" data-sid="${sid}" data-val="0" type="button">0</button>
          <button class="btn ${ischk == 1 ? spoin / poin * 100 == 25 ? 'btn-info' : 'btn-primary' : 'btn-primary'} btn_vlchk_tsk" data-key="${id}" data-poin="${poin}" data-sid="${sid}" data-val="25" type="button">25</button>
          <button class="btn ${ischk == 1 ? spoin / poin * 100 == 50 ? 'btn-info' : 'btn-primary' : 'btn-primary'} btn_vlchk_tsk" data-key="${id}" data-poin="${poin}" data-sid="${sid}" data-val="50" type="button">50</button>
          <button class="btn ${ischk == 1 ? spoin / poin * 100 == 75 ? 'btn-info' : 'btn-primary' : 'btn-primary'} btn_vlchk_tsk" data-key="${id}" data-poin="${poin}" data-sid="${sid}" data-val="75" type="button">75</button>
          <button class="btn ${ischk == 1 ? spoin / poin * 100 == 100 ? 'btn-info' : 'btn-primary' : 'btn-primary'} btn_vlchk_tsk" data-key="${id}" data-poin="${poin}" data-sid="${sid}" data-val="100" type="button">100</button>
        </div>
      </div>
      <p class="text-danger err_poin_tsk hide">Nilai maksimal dibatasi hanya 100!</p>
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
		$('#check_answer_essay_tskdone').html(essay)
	}

	let checkpoin = `
  <div class="alert bg-light border border-primary">
    <span class="d-block fw-semibold text-start py-2 px-3">
      <div class="d-flex justify-content-between mb-3">
        <badge class="badge badge-info fs-3 p-5">Poin : ${poin}<span class="fw-bold fs-6">/${spoin}</span></badge>
        <badge class="badge badge-success fs-3 p-5"><b id="allpoint_tsk">Total Poin : ${tpoint % 1 == 0 ? tpoint : tpoint.toFixed(2)}</b></badge>
        <input type="hidden" name="allpoint_tsk" value="${tpoint}"/>
      </div>
      <span class="fw-bold d-block fs-3 text-dark mb-2">Catatan</span>
      <span class="fw-semibold fs-3 text-dark">
        <div id="checked_note_tskdone"></div>
      </span>
    </span>
  </div>  
  `;

	$('#checkpoin_tskdone').html(checkpoin)
	$("#checked_note_tskdone").html(nchk != '' ? nchk : '-');
}

$(document).on("click", ".actbtn_s", function (e) {
	e.preventDefault();
	$(".actbtn_s").each(function () {
		if ($(this).hasClass("btn-primary")) {
			$(this).removeClass("btn-primary");
			if ($(this).hasClass('iss')) {
				$(this).addClass("btn-success");
			} else if ($(this).hasClass('isw')) {
				$(this).addClass("btn-danger");
			} else {
				$(this).addClass("btn-outline btn-outline-primary");
			}
		}
	});
	if ($(this).hasClass('btn-success') || $(this).hasClass('btn-danger')) {
		$(this).addClass("btn-primary");
		$(this).removeClass("btn-success").removeClass("btn-danger");
	} else {
		$(this).addClass("btn-primary");
		$(this).removeClass("btn-outline btn-outline-primary");
	}
});
