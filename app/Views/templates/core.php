<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
	<base href="">
	<?php
	end($breadcrumb);
	$z = prev($breadcrumb);
	?>
	<title>eLearn - <?= $z . ' ' . $title ?></title>
	<meta name="description"
		content="Seven admin dashboard live demo. Check out all the features of the admin panel. Light &amp; dark skins. A large number of settings, additional services and widgets." />
	<meta name="keywords"
		content="Seven, bootstrap, bootstrap 5, dmin themes, free admin themes, bootstrap admin, bootstrap dashboard" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta charset="utf-8" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="article" />
	<link rel="shortcut icon" href="<?= base_url() ?>assets/media/logos/favicon.ico" />
	<!--begin::Fonts-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Global Stylesheets Bundle(used by all pages)-->
	<link href="<?= base_url() ?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url() ?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url() ?>assets/css/jquery.toast.css" rel="stylesheet">

	<link href="<?= base_url() ?>assets/css/tabulator_bootstrap4.min.css" rel="stylesheet">
	<!-- <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator_simple.min.css" rel="stylesheet"> -->

	<script src="<?= base_url() ?>assets/js/jquery.3.2.1.min.js"></script>
	<script src="<?= base_url() ?>assets/plugins/global/plugins.bundle.js"></script>
	<style>
		.hand {
			cursor: pointer;
		}

		.tabulator-headers,
		.tabulator-table {
			width: 100%;
		}

		.tabulator .tabulator-col {
			width: 100% !important;
			min-width: 40px !important;
			/* height: 45px; */
		}

		.tabulator .tabulator-cell {
			width: 100% !important;
			min-width: 40px !important;
			/* height: 45px; */
		}

		.underline {
			border-bottom: 2px solid #5014D0;
		}

		.container-card {
			padding-left: 10px;
			padding-right: 15px;
		}

		.row-task {
			align-items: stretch;
			display: flex;
			flex-direction: row;
			flex-wrap: nowrap;
			overflow-x: auto;
			overflow-y: hidden;
		}

		.card-task {
			/*float: left;*/
			width: 350px;
			/* padding: .75rem; */
			margin-bottom: 4px;
			margin-right: 10px;
			border: 0;
			/* flex-basis: 30%; */
			flex-grow: 0;
			flex-shrink: 0;
		}

		.card .container-body {
			height: 245px !important;
			padding: 15px !important;
		}

		.card .container-body1 {
			height: 215px !important;
			padding: 15px !important;
		}

		.card-text {
			font-size: 85%;
			margin-bottom: -1px;
		}

		.tabulator .tabulator-header .tabulator-col .tabulator-col-content {
			padding: 1px !important;
		}

		.tabulator-paginator {
			padding-bottom: 10px;
			border-radius: 5px;
		}

		.tabulator-footer-contents {
			overflow: auto;
		}

		.tabulator-header-filter input {
			padding: 10px !important;
			background-color: #E6E6E6 !important;
			margin: 0 !important;
		}

		.tabulator-tableholder {
			margin-top: 5px;
		}

		.tabulator-cell,
		.tabulator-selectable {
			margin: 1px !important;
			border-left: 5px solid #192440;
		}

		.tabulator-row,
		.tabulator-header {
			border: none !important;
		}

		.tabulator-col-title-holder {
			display: none;
		}


		.swal2-toast {
			background-color: rgba(54, 70, 93, .99) !important;
		}

		.swal2-title {
			color: #fff !important;
		}

		.swal2-timer-progress-bar {
			background-color: lightblue !important;
		}

		.alert img {
			max-width: 70%;
		}

		.hide {
			display: none;
		}

		#files-area {
			width: 100%;
			margin: 0 auto;
		}

		.file-block {
			border-radius: 10px;
			background-color: darkgray;
			margin: 5px;
			color: initial;
			display: inline-flex;

			&>span.name {
				padding-right: 10px;
				width: max-content;
				display: inline-flex;
			}
		}

		.file-delete {
			display: flex;
			width: 24px;
			color: initial;
			background-color: #6eb4ff00;
			font-size: large;
			justify-content: center;
			margin-right: 3px;
			margin-top: 0px;
			cursor: pointer;

			&:hover {
				background-color: rgba(144, 163, 203, 0.2);
				border-radius: 10px;
			}

			&>span {
				transform: rotate(45deg);
			}
		}

		.file-block>.name {
			margin-top: 3px;
		}

		.video-container {
			position: relative;
			padding-bottom: 56.25%;
			/* 16:9 */
			height: 0;
		}

		.video-container iframe {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
		}

		.center {
			margin: auto;
			margin-left: 0;
			padding-right: 0;
		}

		.animate_loader {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(0, 0, 0, 0.3);
			z-index: 9999;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		/* From Uiverse.io by bociKond */
		.spinner {
			width: 70.4px;
			height: 70.4px;
			--clr: rgb(57, 38, 163);
			--clr-alpha: rgb(247, 197, 159, .1);
			animation: spinner 1.6s infinite ease;
			transform-style: preserve-3d;
		}

		.spinner>div {
			background-color: var(--clr-alpha);
			height: 100%;
			position: absolute;
			width: 100%;
			border: 3.5px solid var(--clr);
		}

		.spinner div:nth-of-type(1) {
			transform: translateZ(-35.2px) rotateY(180deg);
		}

		.spinner div:nth-of-type(2) {
			transform: rotateY(-270deg) translateX(50%);
			transform-origin: top right;
		}

		.spinner div:nth-of-type(3) {
			transform: rotateY(270deg) translateX(-50%);
			transform-origin: center left;
		}

		.spinner div:nth-of-type(4) {
			transform: rotateX(90deg) translateY(-50%);
			transform-origin: top center;
		}

		.spinner div:nth-of-type(5) {
			transform: rotateX(-90deg) translateY(50%);
			transform-origin: bottom center;
		}

		.spinner div:nth-of-type(6) {
			transform: translateZ(35.2px);
		}

		@keyframes spinner {
			0% {
				transform: rotate(45deg) rotateX(-25deg) rotateY(25deg);
			}

			50% {
				transform: rotate(45deg) rotateX(-385deg) rotateY(25deg);
			}

			100% {
				transform: rotate(45deg) rotateX(-385deg) rotateY(385deg);
			}
		}

		.ql-container {
			min-height: 200px;
			background-color: #fff;
		}

		.ql-container,
		.ql-toolbar {
			border: 1px solid darkgrey !important;
		}

		/* 
		You want a simple and fancy tooltip?
		Just copy all [data-tooltip] blocks:
		*/
		[data-tooltip] {
			--arrow-size: 5px;
			position: relative;
			z-index: 9999999999999;
		}

		/* Positioning and visibility settings of the tooltip */
		[data-tooltip]:before,
		[data-tooltip]:after {
			position: absolute;
			visibility: hidden;
			opacity: 0;
			left: 50%;
			bottom: calc(100% + var(--arrow-size));
			pointer-events: none;
			transition: 0.2s;
			will-change: transform;
		}

		/* The actual tooltip with a dynamic width */
		[data-tooltip]:before {
			content: attr(data-tooltip);
			padding: 10px 10px;
			min-width: 50px;
			max-width: 300px;
			width: max-content;
			width: -moz-max-content;
			border-radius: 6px;
			font-size: 14px;
			background-color: rgba(59, 72, 80, 0.9);
			background-image: linear-gradient(30deg,
					rgba(59, 72, 80, 0.44),
					rgba(59, 68, 75, 0.44),
					rgba(60, 82, 88, 0.44));
			box-shadow: 0px 0px 24px rgba(0, 0, 0, 0.2);
			color: #fff;
			text-align: center;
			white-space: pre-wrap;
			transform: translate(-50%, calc(0px - var(--arrow-size))) scale(0.5);
			z-index: 9999;
		}

		/* Tooltip arrow */
		[data-tooltip]:after {
			content: '';
			border-style: solid;
			border-width: var(--arrow-size) var(--arrow-size) 0px var(--arrow-size);
			/* CSS triangle */
			border-color: rgba(55, 64, 70, 0.9) transparent transparent transparent;
			transition-duration: 0s;
			/* If the mouse leaves the element, 
                              the transition effects for the 
                              tooltip arrow are "turned off" */
			transform-origin: top;
			/* Orientation setting for the
                              slide-down effect */
			transform: translateX(-50%) scaleY(0);
		}

		/* Tooltip becomes visible at hover */
		[data-tooltip]:hover:before,
		[data-tooltip]:hover:after {
			visibility: visible;
			opacity: 1;
		}

		/* Scales from 0.5 to 1 -> grow effect */
		[data-tooltip]:hover:before {
			transition-delay: 0.3s;
			transform: translate(-50%, calc(0px - var(--arrow-size))) scale(1);
		}

		/* 
		Arrow slide down effect only on mouseenter (NOT on mouseleave)
		*/
		[data-tooltip]:hover:after {
			transition-delay: 0.5s;
			/* Starting after the grow effect */
			transition-duration: 0.2s;
			transform: translateX(-50%) scaleY(1);
		}

		/*
		That's it for the basic tooltip.

		If you want some adjustability
		here are some orientation settings you can use:
		*/

		/* LEFT */
		/* Tooltip + arrow */
		[data-tooltip-location="left"]:before,
		[data-tooltip-location="left"]:after {
			left: auto;
			right: calc(100% + var(--arrow-size));
			bottom: 50%;
		}

		/* Tooltip */
		[data-tooltip-location="left"]:before {
			transform: translate(calc(0px - var(--arrow-size)), 50%) scale(0.5);
		}

		[data-tooltip-location="left"]:hover:before {
			transform: translate(calc(0px - var(--arrow-size)), 50%) scale(1);
		}

		/* Arrow */
		[data-tooltip-location="left"]:after {
			border-width: var(--arrow-size) 0px var(--arrow-size) var(--arrow-size);
			border-color: transparent transparent transparent rgba(55, 64, 70, 0.9);
			transform-origin: left;
			transform: translateY(50%) scaleX(0);
		}

		[data-tooltip-location="left"]:hover:after {
			transform: translateY(50%) scaleX(1);
		}



		/* RIGHT */
		[data-tooltip-location="right"]:before,
		[data-tooltip-location="right"]:after {
			left: calc(100% + var(--arrow-size));
			bottom: 50%;
		}

		[data-tooltip-location="right"]:before {
			transform: translate(var(--arrow-size), 50%) scale(0.5);
		}

		[data-tooltip-location="right"]:hover:before {
			transform: translate(var(--arrow-size), 50%) scale(1);
		}

		[data-tooltip-location="right"]:after {
			border-width: var(--arrow-size) var(--arrow-size) var(--arrow-size) 0px;
			border-color: transparent rgba(55, 64, 70, 0.9) transparent transparent;
			transform-origin: right;
			transform: translateY(50%) scaleX(0);
		}

		[data-tooltip-location="right"]:hover:after {
			transform: translateY(50%) scaleX(1);
		}



		/* BOTTOM */
		[data-tooltip-location="bottom"]:before,
		[data-tooltip-location="bottom"]:after {
			top: calc(100% + var(--arrow-size));
			bottom: auto;
		}

		[data-tooltip-location="bottom"]:before {
			transform: translate(-50%, var(--arrow-size)) scale(0.5);
		}

		[data-tooltip-location="bottom"]:hover:before {
			transform: translate(-50%, var(--arrow-size)) scale(1);
		}

		[data-tooltip-location="bottom"]:after {
			border-width: 0px var(--arrow-size) var(--arrow-size) var(--arrow-size);
			border-color: transparent transparent rgba(55, 64, 70, 0.9) transparent;
			transform-origin: bottom;
		}
	</style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-enabled" onload="reload_assessment()">

	<div class="modal bg-body fade assessment_modal_act" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="assessment_modal_question">
		<div class="modal-dialog modal-fullscreen">
			<div class="modal-content shadow-none">
				<div class="modal-header">
					<div class="modal-title">
						<h5 id="mdltitle"></h5>
						<badge id="sbtl" class="badge badge-info mt-2"></badge>
					</div>

					<!-- <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close"> -->
					<div class="buttonn">
						<span class="fw-bold mx-5 fs-3"><span id="left_time_assessment" class="hide"></span></span>
						<button type="button" class="btn btn-primary" onclick="alert_submit_assessment();">Submit</button>
					</div>
					<!-- </div> -->
				</div>

				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="list_assact" id="list_assact"></div>
						</div>
						<div class="col-sm-12" id="col_questansw_ass">
							<div id="actass_question"></div>
							<div id="actass_option"></div>
							<div id="actass_essay_answer"></div>
						</div>
						<div class="col_hintass" id="col_hintass"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal bg-body fade task_modal_act" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="task_modal_question">
		<div class="modal-dialog modal-fullscreen">
			<div class="modal-content shadow-none">
				<div class="modal-header">
					<div class="modal-title">
						<h5 id="mdltitle_tsk"></h5>
						<badge id="sbtl_tsk" class="badge badge-secondary mt-2"></badge>
					</div>

					<div class="buttonn">
						<span class="fw-bold mx-5 fs-3"><span id="left_time_task" class="hide"></span></span>
						<input type="hidden" name="tid" value="">
						<button type="button" class="btn btn-success" onclick="save_act_task();">Simpan</button>
						<button type="button" class="btn btn-primary" onclick="alert_submit_task();">Submit</button>
					</div>
				</div>

				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<!-- <div class="hover-scroll-x"> -->
							<div class="d-grid">
								<ul class="nav nav-tabs flex-nowrap text-nowrap">
									<li class="nav-item">
										<a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0 tab_topic active" id="tab_topic_content" data-bs-toggle="tab" href="#tab_content_public">Materi</a>
									</li>
									<li class="nav-item">
										<a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0 tab_topic" id="tab_topic_video" data-bs-toggle="tab" href="#tab_video_public">Video</a>
									</li>
									<li class="nav-item">
										<a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0 tab_topic" id="tab_topic_attachment" data-bs-toggle="tab" href="#tab_attachment_public">Lampiran</a>
									</li>
									<li class="nav-item">
										<a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0 tab_topic" id="tab_topic_task" data-bs-toggle="tab" href="#tab_task_public">Latihan</a>
									</li>
								</ul>
							</div>
							<!-- </div> -->

							<div class="card p-5" id="content_value">
								<div class="tab-content" id="myTabContent">
									<div class="tab-pane fade content_topic show active" id="tab_content_public" role="tabpanel">
										<div class="content_lesson_pub"></div>
									</div>
									<div class="tab-pane fade content_topic" id="tab_video_public" role="tabpanel">
										<div id="btn_conf_vid_"></div>
										<div class="video_lesson_pub"></div>
									</div>
									<div class="tab-pane fade content_topic" id="tab_attachment_public" role="tabpanel">
										<div id="btn_conf_attach_"></div>
										<div class="attachment_lesson_pub"></div>
									</div>
									<div class="tab-pane fade content_topic" id="tab_task_public" role="tabpanel">
										<div class="row">
											<div class="col-sm-12">
												<div class="list_taskact" id="list_taskact"></div>
											</div>
											<div class="col-sm-12" id="col_questansw_tsk">
												<div id="acttask_question"></div>
												<div id="acttask_option"></div>
												<div id="acttask_essay_answer"></div>
											</div>
											<div class="col_hinttsk" id="col_hinttsk"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal bg-body fade task_modal_act" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="checking_modal_question">
		<div class="modal-dialog modal-fullscreen">
			<div class="modal-content shadow-none">
				<div class="modal-header">
					<div class="modal-title">
						<h5 id="checking_title"></h5>
						<badge id="checking_subtitle2" class="badge badge-info mt-2"></badge>
						<badge id="checking_subtitle" class="badge badge-secondary mt-2"></badge>
					</div>
					<div class="buttonn">
						<span class="fw-bold mx-5 fs-3"><span id="left_time_task" class="hide"></span></span>
						<button type="button" class="btn btn-danger" onclick="close_checking_modal()">Tutup</button>
						<button type="button" class="btn btn-primary" id="btn_submit_checking">Submit</button>
						<input type="hidden" name="result_id" id="result_id">
						<input type="hidden" name="stu_id" id="stu_id">
						<input type="hidden" name="asse_id" id="asse_id">
					</div>
				</div>

				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="list_questions" id="list_questions"></div>
						</div>
						<div class="col-sm-8">
							<div id="check_question"></div>
							<div id="check_answer"></div>
							<div id="check_answer_essay"></div>
						</div>
						<div class="col-sm-4">
							<div id="checkpoin"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal bg-body fade task_modal_act" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="checking_modal_question_tsk">
		<div class="modal-dialog modal-fullscreen">
			<div class="modal-content shadow-none">
				<div class="modal-header">
					<div class="modal-title">
						<h5 id="ctt"></h5>
						<badge id="cstt2" class="badge badge-info mt-2"></badge>
						<badge id="cstt1" class="badge badge-secondary mt-2"></badge>
					</div>
					<div class="buttonn">
						<span class="fw-bold mx-5 fs-3"><span id="left_time_task" class="hide"></span></span>
						<button type="button" class="btn btn-danger" onclick="close_checking_modal_tsk()">Tutup</button>
						<button type="button" class="btn btn-primary" id="btn_submit_checking_tsk">Submit</button>
						<input type="hidden" name="result_id_tsk" id="result_id_tsk">
						<input type="hidden" name="stu_id_tsk" id="stu_id_tsk">
						<input type="hidden" name="taskidd" id="taskidd">
					</div>
				</div>

				<div class="modal-body">
					<div class="row">
						<div class="col-sm-2" style="overflow-y: scroll; max-height:690px;">
							<div class="list_questions_tsk" id="list_questions_tsk"></div>
						</div>
						<div class="col-sm-6">
							<div id="check_question_tsk"></div>
							<div id="check_answer_tsk"></div>
							<div id="check_answer_essay_tsk"></div>
						</div>
						<div class="col-sm-4">
							<div id="checkpoin_tsk"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_assessment_information">
		<div class="modal-dialog modal-md">
			<div class="modal-content" id="content_modal">
				<div class="modal-header">
					<div class="text-gray-900 fw-bolder fs-6">Informasi Penilaian</div>
				</div>
				<div class="modal-body">
					<div class="card-body">
						<div class="d-flex flex-stack">
							<div class="text-gray-700 fw-semibold fs-6 me-2">Penilaian</div>
							<div class="d-flex align-items-senter">
								<span class="text-gray-900 fw-bolder fs-6">
									<div class="title_assessment"></div>
								</span>
							</div>
						</div>

						<div class="separator separator-dashed my-3"></div>

						<div class="d-flex flex-stack">
							<div class="text-gray-700 fw-semibold fs-6 me-2">Bidang Studi</div>
							<div class="d-flex align-items-senter">
								<span class="text-gray-900 fw-bolder fs-6">
									<div class="subject_assessment"></div>
								</span>
							</div>
						</div>

						<div class="separator separator-dashed my-3"></div>

						<div class="d-flex flex-stack">
							<div class="text-gray-700 fw-semibold fs-6 me-2">Guru</div>
							<div class="d-flex align-items-senter">
								<span class="text-gray-900 fw-bolder fs-6">
									<div class="teacher_assessment"></div>
								</span>
							</div>
						</div>
						<div class="separator separator-dashed my-3"></div>

						<div class="d-flex flex-stack">
							<div class="text-gray-700 fw-semibold fs-6 me-2">Periode</div>
							<div class="d-flex align-items-senter">
								<span class="text-gray-900 fw-bolder fs-6">
									<div class="period_assessment"></div>
								</span>
							</div>
						</div>
						<div class="separator separator-dashed my-3"></div>

						<div class="d-flex flex-stack">
							<div class="text-gray-700 fw-semibold fs-6 me-2">Waktu Mengerjakan</div>
							<div class="d-flex align-items-senter">
								<span class="text-gray-900 fw-bolder fs-6">
									<div class="duration_assessment"></div>
								</span>
							</div>
						</div>
					</div>
					<div class="source_question_bank hide"></div>
					<div class="end_time hide"></div>
					<div class="timer hide"></div>
					<div class="autosubmit hide"></div>
					<div class="random hide"></div>
					<div class="no_cheat hide"></div>
					<div class="show_hint hide"></div>
					<div class="assesst_id hide"></div>
					<div class="sch_year_id hide"></div>
					<br>

					<div class="mb-3 bg-light-info p-3 rounded">
						<p class="d-inline" style="font-size: 9pt">
							<b>Instruksi :</b>
							<br>
						<div class="instruction_assessment"></div>
						</p>
					</div>
					<br>

					<div class="mb-3 bg-light-danger p-3 rounded">
						<p class="d-inline" style="font-size: 9pt">
							<b>Catatan :</b>
							<br>
							<span id="assessment_notes"></span>
						</p>
					</div>

					<div class="btn_footer d-flex justify-content-end">
						<button type="button" class="btn btn-sm btn-light-danger mx-2" data-bs-dismiss="modal">Batal</button>
						<div class="start" id="betin_assessment"></div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<input type="hidden" id="base" value="<?php echo base_url(); ?>">
	<div class="modal fade" id="active_tp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Tahun Pelajaran Aktif</h3>

					<!--begin::Close-->
					<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
						<i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
					</div>
					<!--end::Close-->
				</div>

				<div class="modal-body">
					<div id="lists_year"></div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-light-danger" onclick="close_tp();">Batal</button>
					<button type="button" class="btn btn-info" onclick="pick_year();">Pilih</button>
				</div>

			</div>
		</div>
	</div>

	<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_look_student_act_task">
		<div class="modal-dialog modal-xl">
			<div class="modal-content" id="content_modal">
				<div class="modal-header">
					<h3 class="modal-title">Dafta Siswa Mengerjakan Tugas <span id="title_tsk_lsstd"></span></h3>
					<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" onclick="close_view_task_student()">
						<i class="bi bi-x-square fs-2x"></i>
					</div>
				</div>
				<div class="modal-body">
					<div id="bd_list_task_std">
						<div id="task_student_act"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal_look_student_act_assessment">
		<div class="modal-dialog modal-xl">
			<div class="modal-content" id="content_modal">
				<div class="modal-header">
					<h3 class="modal-title">Dafta Siswa Mengerjakan Penilaian <span id="title_ass_lsstd"></span></h3>
					<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" onclick="close_view_assess_student()">
						<i class="bi bi-x-square fs-2x"></i>
					</div>
				</div>
				<div class="modal-body">
					<div class="bd_list_ass_student">
						<div id="ass_student_act"></div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!--begin::Main-->
	<!--begin::Root-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Page-->
		<div class="page d-flex flex-row flex-column-fluid">
			<!--begin::Aside-->
			<div id="kt_aside" class="aside aside-extended bg-white" data-kt-drawer="true" data-kt-drawer-name="aside"
				data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
				data-kt-drawer-width="auto" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
				<!--begin::Primary-->
				<div class="aside-primary d-flex flex-column align-items-lg-center flex-row-auto">
					<!--begin::Logo-->
					<div class="aside-logo d-none d-lg-flex flex-column align-items-center flex-column-auto py-10"
						id="kt_aside_logo">
						<a href="../dist/index.html">
							<img alt="Logo" src="<?= base_url() ?>assets/media/logos/logo-default.svg" class="h-50px" />
						</a>
					</div>
					<!--end::Logo-->
					<!--begin::Nav-->
					<?= $this->include('templates/sidenav') ?>
					<!--end::Nav-->
					<!--begin::Footer-->
					<div class="aside-footer d-flex flex-column align-items-center flex-column-auto" id="kt_aside_footer">
						<?php if(in_array(12, session()->get('c_role'))): ?>
						<div class="d-flex align-items-center mb-2">
							<!--begin::Menu wrapper-->
							<div class="btn btn-icon btn-custom" id="kt_drawer_chat_toggle">
								<?php if(count(get_notification()) > 0): ?>
									<i class="bi bi-bell-fill fs-2x"></i>
								<?php else: ?>
									<i class="bi bi-bell fs-2x"></i>
								<?php endif ?>
							</div>
							<!--end::Menu wrapper-->
						</div>
						<?php endif; ?>
						<!--begin::Notifications-->
						
						<!--end::Notifications-->
						<!--begin::Activities-->
						<!-- <div class="d-flex align-items-center mb-3">
							<a href="#" class="btn btn-icon btn-custom" data-kt-menu-trigger="click"
								data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-bs-toggle="tooltip"
								data-bs-placement="right" data-bs-dismiss="click" title="Aktivitas Saya"
								id="kt_activities_toggle">
								<span class="svg-icon svg-icon-2 svg-icon-lg-1">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
										fill="none">
										<rect x="8" y="9" width="3" height="10" rx="1.5" fill="black" />
										<rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="black" />
										<rect x="18" y="11" width="3" height="8" rx="1.5" fill="black" />
										<rect x="3" y="13" width="3" height="6" rx="1.5" fill="black" />
									</svg>
								</span>
							</a>
						</div> -->
						<!--end::Activities-->
						<!--begin::User-->
						<div class="d-flex align-items-center mb-10" id="kt_header_user_menu_toggle">
							<!--begin::Menu wrapper-->
							<div class="cursor-pointer symbol symbol-40px" data-kt-menu-trigger="click"
								data-kt-menu-overflow="true" data-kt-menu-placement="top-start" title="User profile">
								<img src="<?= userdata()['image'] != 'default.png' ? getenv()['S3_BUCKET_LINK'] . userdata()['image'] : base_url('assets/media/avatars/blank.png') ?>" alt="image" />
							</div>
							<!--begin::Menu-->
							<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px"
								data-kt-menu="true">
								<!--begin::Menu item-->
								<div class="menu-item px-3">
									<div class="menu-content d-flex align-items-center px-3">
										<!--begin::Avatar-->
										<div class="symbol symbol-50px me-5">
											<img alt="Logo" src="<?= base_url() ?>assets/media/avatars/150-26.jpg" />
										</div>
										<!--end::Avatar-->
										<!--begin::Username-->
										<div class="d-flex flex-column">
											<?php $loginname = isset(userdata()['degree']) ? userdata()['name'] . ', ' . userdata()['degree'] : userdata()['name']; ?>
											<div class="fw-bolder d-flex align-items-center fs-5"><?= $loginname ?>
												<!-- <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">Pro</span> -->
											</div>
											<a href="#"
												class="fw-bold text-muted text-hover-primary fs-7"><?= userdata()['user_name'] ?></a>
										</div>
										<!--end::Username-->
									</div>
								</div>
								<!--end::Menu item-->
								<!--begin::Menu separator-->
								<div class="separator my-2"></div>
								<!--end::Menu separator-->
								<!--begin::Menu item-->
								<div id="school_active_year" data-id="<?= school_year() != null ? school_year()['id'] : '' ?>"></div>
								<<div class="menu-item px-5"
									data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
									<a onclick="show_tp();" class="menu-link px-5">
										<span class="menu-title position-relative"><?= school_year() != null ? 'T.P ' . school_year()['period'] : 'T.P [belum dipilih]' ?>
											<span class="ms-5 position-absolute translate-middle-y top-50 end-0">
												<i class="ki-duotone ki-calendar-2 fs-2">
													<span class="path1"></span>
													<span class="path2"></span>
													<span class="path3"></span>
													<span class="path4"></span>
													<span class="path5"></span>
												</i>
											</span>
										</span>
									</a>
							</div>
							<!--end::Menu item-->
							<!--begin::Menu item-->
							<div class="menu-item px-5">
								<a href="<?= in_array(11, session()->get('c_role')) ? base_url('teacher/activity') : base_url('student/activity') ?>" class="menu-link px-5">Aktivitas Saya</a>
							</div>
							<!--end::Menu item-->
							<!--begin::Menu separator-->
							<div class="separator my-2"></div>
							<!--end::Menu separator-->
							<!--begin::Menu item-->
							<div class="menu-item px-5">
								<a href="<?= base_url() ?>logout" class="menu-link px-5">Keluar</a>
							</div>
							<!--end::Menu item-->
							<!--begin::Menu separator-->
							<div class="separator my-2"></div>
							<!--end::Menu separator-->
							<!--begin::Menu item-->
							<!-- <div class="menu-item px-5">
								<div class="menu-content px-5">
									<label
										class="form-check form-switch form-check-custom form-check-solid pulse pulse-success"
										for="kt_user_menu_dark_mode_toggle">
										<input class="form-check-input w-30px h-20px" type="checkbox" value="1"
											name="mode" id="kt_user_menu_dark_mode_toggle"
											data-kt-url="../dist/index.html" />
										<span class="pulse-ring ms-n1"></span>
										<span class="form-check-label text-gray-600 fs-7">Dark Mode</span>
									</label>
								</div>
							</div> -->
							<!--end::Menu item-->
						</div>
						<!--end::Menu-->
						<!--end::Menu wrapper-->
					</div>
					<!--end::User-->
				</div>
				<!--end::Footer-->
			</div>
			<!--end::Primary-->
			<!--begin::Secondary-->
			<div class="aside-secondary d-flex flex-row-fluid">
				<!--begin::Workspace-->
				<div class="aside-workspace my-5 p-5" id="kt_aside_wordspace">
					<div class="d-flex h-100 flex-column">
						<!--begin::Wrapper-->

						<div class="flex-column-fluid hover-scroll-y" data-kt-scroll="true"
							data-kt-scroll-activate="true" data-kt-scroll-height="auto"
							data-kt-scroll-wrappers="#kt_aside_wordspace"
							data-kt-scroll-dependencies="#kt_aside_secondary_footer" data-kt-scroll-offset="0px">
							<!--begin::Tab content-->
							<?= $this->include('templates/sidemenu') ?>
							<!--end::Tab content-->
						</div>
						<!--end::Wrapper-->
					</div>
				</div>
				<!--end::Workspace-->
			</div>
			<!--end::Secondary-->
			<!--begin::Aside Toggle-->
			<button
				class="btn btn-sm btn-icon bg-body btn-color-gray-600 btn-active-primary position-absolute translate-middle start-100 end-0 bottom-0 shadow-sm d-none d-lg-flex"
				data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
				data-kt-toggle-name="aside-minimize" style="margin-bottom: 1.35rem">
				<!--begin::Svg Icon | path: icons/duotune/arrows/arr063.svg-->
				<span class="svg-icon svg-icon-2 rotate-180">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						<rect opacity="0.5" x="6" y="11" width="13" height="2" rx="1" fill="black" />
						<path
							d="M8.56569 11.4343L12.75 7.25C13.1642 6.83579 13.1642 6.16421 12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75L5.70711 11.2929C5.31658 11.6834 5.31658 12.3166 5.70711 12.7071L11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25C13.1642 17.8358 13.1642 17.1642 12.75 16.75L8.56569 12.5657C8.25327 12.2533 8.25327 11.7467 8.56569 11.4343Z"
							fill="black" />
					</svg>
				</span>
				<!--end::Svg Icon-->
			</button>
			<!--end::Aside Toggle-->
		</div>
		<!--end::Aside-->
		<!--begin::Wrapper-->
		<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
			<!--begin::Header-->
			<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header"
				data-kt-sticky-offset="{default: '200px', lg: '300px'}">
				<!--begin::Container-->
				<div class="container-xxl d-flex align-items-center justify-content-between"
					id="kt_header_container">
					<!--begin::Page title-->
					<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-5 pb-lg-0"
						data-kt-swapper="true" data-kt-swapper-mode="prepend"
						data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
						<!--begin::Heading-->
						<h1 class="text-dark fw-bold my-0 fs-2"><?= $title ?></h1>
						<!--end::Heading-->
						<!--begin::Breadcrumb-->
						<ul class="breadcrumb breadcrumb-line text-muted fw-bold fs-base my-1">
							<li class="breadcrumb-item text-muted">
								<a href="<?= base_url() ?>" class="text-muted">Home</a>
							</li>
							<?php foreach ($breadcrumb as $k => $v): ?>
								<li class="breadcrumb-item text-muted">
									<a href="<?= $k ?>" class="text-muted"><?= $v ?></a>
								</li>
							<?php endforeach; ?>
						</ul>
						<!--end::Breadcrumb-->
					</div>
					<!--end::Page title=-->
					<!--begin::Wrapper-->
					<div class="d-flex d-lg-none align-items-center ms-n2 me-2">
						<!--begin::Aside mobile toggle-->
						<div class="btn btn-icon btn-active-icon-primary" id="kt_aside_toggle">
							<!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
							<span class="svg-icon svg-icon-2x">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
									fill="none">
									<path
										d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z"
										fill="black" />
									<path opacity="0.3"
										d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z"
										fill="black" />
								</svg>
							</span>
							<!--end::Svg Icon-->
						</div>
						<!--end::Aside mobile toggle-->
						<!--begin::Logo-->
						<a href="../dist/index.html" class="d-flex align-items-center">
							<img alt="Logo" src="<?= base_url() ?>assets/media/logos/logo-default.svg"
								class="h-40px" />
						</a>
						<!--end::Logo-->
					</div>
					<!--end::Wrapper-->
					<!--begin::Toolbar wrapper-->
					<div class="d-flex flex-shrink-0">
						<!--begin::Invite user-->
						<!-- <div class="d-flex ms-3">
							<a href="#" class="btn bg-body btn-color-gray-600 btn-active-info" tooltip="New Member"
								data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends">New User</a>
						</div> -->
						<!--end::Invite user-->
						<!--begin::Create app-->
						<div class="d-flex ms-3">
							<!-- Example single danger button -->
							<div class="btn-group">
								<?php if (school_year() != null) : ?>
									<button type="button" class="btn btn-primary" onclick="show_tp()" aria-expanded="false">
										<?= 'T.P ' . school_year()['period'] ?>
									</button>
								<?php else: ?>
									<button type="button" class="btn btn-danger" onclick="show_tp()" aria-expanded="false">
										Pilih Tahun Pelajaran
									</button>
								<?php endif ?>
							</div>
						</div>
						<!--end::Create app-->
					</div>
					<!--end::Toolbar wrapper-->
				</div>
				<!--end::Container-->
			</div>
			<!--end::Header-->
			<!--begin::Content-->
			<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
				<!--begin::Container-->
				<div class="container-xxl" id="kt_content_container">
					<?php $this->renderSection('content'); ?>
				</div>
				<!--end::Container-->
			</div>
			<!--end::Content-->
			<!--begin::Footer-->
			<div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
				<!--begin::Container-->
				<div class="container-xxl d-flex flex-column flex-md-row flex-stack">
					<!--begin::Copyright-->
					<div class="text-dark order-2 order-md-1">
						<span class="text-gray-400 fw-bold me-1">Created by</span>
						<a href="#" class="text-muted text-hover-primary fw-bold me-2 fs-6">LifEco.id</a>
					</div>
					<!--end::Copyright-->
					<!--begin::Menu-->
					<ul class="menu menu-gray-600 menu-hover-primary fw-bold order-1">
						<li class="menu-item">
							<a href="https://keenthemes.com" target="_blank" class="menu-link px-2">Tentang</a>
						</li>
						<li class="menu-item">
							<a href="https://keenthemes.com/support" target="_blank"
								class="menu-link px-2">Bantuan</a>
						</li>
					</ul>
					<!--end::Menu-->
				</div>
				<!--end::Container-->
			</div>
			<!--end::Footer-->
		</div>
		<!--end::Wrapper-->
	</div>
	<!--end::Page-->
	</div>
	<!--end::Root-->
	<!--begin::Scrolltop-->
	<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
		<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
		<span class="svg-icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
				<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)"
					fill="black" />
				<path
					d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
					fill="black" />
			</svg>
		</span>
		<!--end::Svg Icon-->
	</div>
	<!--end::Scrolltop-->
	<!--end::Main-->

	<?php if(in_array(12, session()->get('c_role'))): ?>
	<?= $this->include('templates/notification') ?>
	<?php endif; ?>

	<div class="animate_loader" style="display:none;">
		<div class="spinner">
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
		</div>
	</div>

	<script>
		const url = window.location.href;
		const base_url = document.getElementById('base').value;
		const s3_url = '<?= getenv()['S3_BUCKET_LINK'] ?>';
		
		let idc_public = '<?= session()->getFlashdata('id_content') ?>'
		let att_id = '<?= session()->getFlashdata('att_id') ?>'
		let hostUrl = "<?= base_url() ?>assets/";
		let active_year = '<?= school_year() != null ? school_year()['period'] : '' ?>'
		let active_year_id = '<?= school_year() != null ? school_year()['id'] : '' ?>'
		let level = '<?= in_array(11, session()->get('c_role')) ? 11 : 12 ?>'

		let file_id = '<?= session()->getFlashdata('file_id') ?>'
		let file_coll = '<?= session()->getFlashdata('file_coll') ?>'
		let file_chd = '<?= session()->getFlashdata('file_chd') ?>'

		let file_path = 'https://devabe-s3.s3.ap-southeast-1.amazonaws.com/'


		let student_id = 0
		if (url.includes("student")) {
			student_id = '<?= userdata()['id_profile'] ?>'
		}
		let teacher_id = 0
		if (url.includes("teacher")) {
			teacher_id = '<?= userdata()['id_profile'] ?>'
		}
	</script>
	<!--begin::Javascript-->
	<!--begin::Global Javascript Bundle(used by all pages)-->
	<!-- <script src="<?= base_url() ?>assets/plugins/custom/datatables/datatables.bundle.js"></script> -->

	<script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>assets/js/tabulator.min.js"></script>

	<script src="<?= base_url() ?>assets/js/scripts.bundle.js"></script>
	<!-- <script src="<?= base_url() ?>assets/js/jquery.toast.js"></script> -->
	<script src="<?= base_url() ?>assets/js/common.js"></script>

	<script>
		const tbconf = {
			height: "600px",
			layout: "fitDataStretch",
			renderHorizontal: "virtual",
			pagination: "local",
			paginationSize: 10,
			paginationSizeSelector: [10, 50, 100, 200],
			movableColumns: true,
			selectableRows: true,
			paginationCounter: "rows",
			// headerVisible:false,
			placeholder: '<h6>Data tidak tersedia.</h6>',
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
		};

		const Toast = Swal.mixin({
			toast: true,
			position: "bottom-end",
			showConfirmButton: false,
			timer: 5000,
			timerProgressBar: true,
			didOpen: (toast) => {
				toast.onmouseenter = Swal.stopTimer;
				toast.onmouseleave = Swal.resumeTimer;
			}
		});

		function toast_act(heading = '', text = '', icon = '', hide = '') {
			Toast.fire({
				icon: icon,
				title: text
			});
		}

		// function al_swal(msg, type) {
		// 	Swal.fire({
		// 		text: msg,
		// 		icon: type,
		// 		buttonsStyling: false,
		// 		confirmButtonText: "Ok",
		// 		customClass: {
		// 			confirmButton: "btn btn-primary"
		// 		}
		// 	});

		// 	// Swal.fire({
		// 	// position: "top-end",
		// 	// icon: "success",
		// 	// title: "Your work has been saved",
		// 	// showConfirmButton: false,
		// 	// timer: 1500
		// 	// });
		// }

		// function set_year(e) {
		// 	$.ajax({
		// 		url: "<?= base_url('/config-teacher-student/active-year/set-year') ?>",
		// 		type: "post",
		// 		data: {
		// 			'year_id': $('input[name="radio_tp"]:checked').val()
		// 		},
		// 		dataType: "json",
		// 		beforeSend: function() {
		// 			show_loading()
		// 		},
		// 		success: function(data) {
		// 			hide_loading()
		// 		}
		// 	})
		// }

		function pick_year() {
			$.ajax({
				url: "<?= base_url('/config-teacher-student/active-year/set-year') ?>",
				type: "post",
				data: {
					'year_id': $('input[name="radio_tp"]:checked').val()
				},
				dataType: "json",
				beforeSend: function() {
					show_loading()
				},
				success: function(data) {
					if (data) {
						location.reload();
					} else {
						toast_act('Gagal', 'Terjadi Kesalahan', 'error')
					}
					hide_loading()
				}
			})
		}

		function generate_years(e) {
			let view = ''
			let active = '<?= school_year() != null ? school_year()['id'] : '' ?>'

			$.each(e, function(i, v) {
				chk = ''
				if (active != '') {
					chk = v.school_year_id == active ? 'checked' : '';
				}

				view += `
					<div class="form-check form-check-custom form-check-solid mb-2">
						<input class="form-check-input" type="radio" onclick="set_year(${v.school_year_id})" name="radio_tp" value="${v.school_year_id}" id="opt${v.school_year_id}" ${chk} />
						<label class="form-check-label text-dark" for="opt${v.school_year_id}">
							T.P ${v.school_year_period}
						</label>
					</div>
				`
			})
			$('#lists_year').html(view)
			$('#active_tp').modal('show');
		}

		function close_tp() {
			$('#lists_year').html('')
			$('#active_tp').modal('hide');
		}

		function show_tp() {
			$.ajax({
				url: "<?= base_url('/config-teacher-student/active-year/list-year') ?>",
				type: "post",
				dataType: "json",
				beforeSend: function() {
					show_loading()
				},
				success: function(data) {
					generate_years(data)
					hide_loading()
				}
			})
		}

		function show_loading() {
			$(".animate_loader").removeAttr('style')
		}

		function removeLoader() {
			$(".animate_loader").fadeOut(500, function() {});
		}

		function hide_loading() {
			removeLoader()
		}

		const ind_date = (tgl) => new Date(tgl).toLocaleString('id-ID', {
			timeZone: 'Asia/Jakarta',
			// weekday: 'long',
			year: 'numeric',
			month: 'short',
			day: 'numeric',
			hour: '2-digit',
			minute: '2-digit',
			// second: '2-digit',
			// timeZoneName: 'short',
		}).replace(/\./g, ':');
	</script>

	<script src="<?= base_url() ?>assets/js/script/lesson_school.js"></script>
	<script src="<?= base_url() ?>assets/js/script/lesson_additional.js"></script>
	<script src="<?= base_url() ?>assets/js/script/lesson_standard.js"></script>
	<script src="<?= base_url() ?>assets/js/script/lesson_public.js"></script>
	<script src="<?= base_url() ?>assets/js/script/question_bank.js"></script>
	<script src="<?= base_url() ?>assets/js/script/assessment.js"></script>
	<script src="<?= base_url() ?>assets/js/script/first_page.js"></script>
	<script src="<?= base_url() ?>assets/js/script/task.js"></script>
	<script src="<?= base_url() ?>assets/js/form.repeater.js"></script>

	<?php if (session()->getFlashdata('msg')): ?>
		<?=
		'<script type="text/javascript">',
		'toast_act( 
			"<h6>' . ucfirst(session()->getFlashdata('head')) . '</h6>",',
		'"' . session()->getFlashdata('msg') . '",',
		'"' . session()->getFlashdata('icon') . '",',
		'"' . session()->getFlashdata('hide') . '",',
		')</script>';
		?>
	<?php endif; ?>
</body>
<!--end::Body-->

</html>