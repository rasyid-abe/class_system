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
	<meta property="og:title"
		content="Seven HTML Free - Bootstrap 5 HTML Multipurpose Light/Dark Admin Dashboard Theme" />
	<meta property="og:url" content="https://keenthemes.com/products/seven-html-pro" />
	<meta property="og:site_name" content="Keenthemes | Seven HTML Free" />
	<link rel="canonical" href="Https://preview.keenthemes.com/seven-html-free" />
	<link rel="shortcut icon" href="<?= base_url() ?>assets/media/logos/favicon.ico" />
	<!--begin::Fonts-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Global Stylesheets Bundle(used by all pages)-->
	<link href="<?= base_url() ?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url() ?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url() ?>assets/css/jquery.toast.css" rel="stylesheet">

	<link href="https://unpkg.com/tabulator-tables/dist/css/tabulator_bootstrap4.min.css" rel="stylesheet">
	<!-- <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator_simple.min.css" rel="stylesheet"> -->

	<style>
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
	</style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-enabled">
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
					<button type="button" class="btn btn-info" onclick="reload_tp();">Pilih</button>
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
					<div class="aside-footer d-flex flex-column align-items-center flex-column-auto"
						id="kt_aside_footer">
						<!--begin::Chat-->
						<div class="d-flex align-items-center mb-2">
							<!--begin::Menu wrapper-->
							<div class="btn btn-icon btn-custom" id="kt_drawer_chat_toggle">
								<!--begin::Svg Icon | path: icons/duotune/communication/com012.svg-->
								<span class="svg-icon svg-icon-2 svg-icon-lg-1">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
										fill="none">
										<path opacity="0.3"
											d="M20 3H4C2.89543 3 2 3.89543 2 5V16C2 17.1046 2.89543 18 4 18H4.5C5.05228 18 5.5 18.4477 5.5 19V21.5052C5.5 22.1441 6.21212 22.5253 6.74376 22.1708L11.4885 19.0077C12.4741 18.3506 13.6321 18 14.8167 18H20C21.1046 18 22 17.1046 22 16V5C22 3.89543 21.1046 3 20 3Z"
											fill="black" />
										<rect x="6" y="12" width="7" height="2" rx="1" fill="black" />
										<rect x="6" y="7" width="12" height="2" rx="1" fill="black" />
									</svg>
								</span>
								<!--end::Svg Icon-->
							</div>
							<!--end::Menu wrapper-->
						</div>
						<!--end::Chat-->
						<!--begin::Notifications-->
						<div class="d-flex align-items-center mb-2">
							<!--begin::Menu wrapper-->
							<div class="btn btn-icon btn-custom" data-kt-menu-trigger="click"
								data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-bs-toggle="tooltip"
								data-bs-placement="right" data-bs-dismiss="click" title="Notifications">
								<!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
								<span class="svg-icon svg-icon-2 svg-icon-lg-1">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
										fill="none">
										<rect x="2" y="2" width="9" height="9" rx="2" fill="black" />
										<rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="black" />
										<rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="black" />
										<rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="black" />
									</svg>
								</span>
								<!--end::Svg Icon-->
							</div>
							<!--begin::Menu-->
							<div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px"
								data-kt-menu="true">
								<!--begin::Heading-->
								<div class="d-flex flex-column bgi-no-repeat rounded-top"
									style="background-image:url('<?= base_url() ?>assets/media/misc/dropdown-header-bg.png')">
									<!--begin::Title-->
									<h3 class="text-white fw-bold px-9 mt-10 mb-6">Notifications
										<span class="fs-8 opacity-75 ps-3">24 reports</span>
									</h3>
									<!--end::Title-->
									<!--begin::Tabs-->
									<ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-bold px-9">
										<li class="nav-item">
											<a class="nav-link text-white opacity-75 opacity-state-100 pb-4"
												data-bs-toggle="tab" href="#kt_topbar_notifications_1">Alerts</a>
										</li>
										<li class="nav-item">
											<a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active"
												data-bs-toggle="tab" href="#kt_topbar_notifications_2">Updates</a>
										</li>
										<li class="nav-item">
											<a class="nav-link text-white opacity-75 opacity-state-100 pb-4"
												data-bs-toggle="tab" href="#kt_topbar_notifications_3">Logs</a>
										</li>
									</ul>
									<!--end::Tabs-->
								</div>
								<!--end::Heading-->
								<!--begin::Tab content-->
								<div class="tab-content">
									<!--begin::Tab panel-->
									<div class="tab-pane fade" id="kt_topbar_notifications_1" role="tabpanel">
										<!--begin::Items-->
										<div class="scroll-y mh-325px my-5 px-8">
											<!--begin::Item-->
											<div class="d-flex flex-stack py-4">
												<!--begin::Section-->
												<div class="d-flex align-items-center">
													<!--begin::Symbol-->
													<div class="symbol symbol-35px me-4">
														<span class="symbol-label bg-light-primary">
															<!--begin::Svg Icon | path: icons/duotune/technology/teh008.svg-->
															<span class="svg-icon svg-icon-2 svg-icon-primary">
																<svg xmlns="http://www.w3.org/2000/svg" width="24"
																	height="24" viewBox="0 0 24 24" fill="none">
																	<path opacity="0.3"
																		d="M11 6.5C11 9 9 11 6.5 11C4 11 2 9 2 6.5C2 4 4 2 6.5 2C9 2 11 4 11 6.5ZM17.5 2C15 2 13 4 13 6.5C13 9 15 11 17.5 11C20 11 22 9 22 6.5C22 4 20 2 17.5 2ZM6.5 13C4 13 2 15 2 17.5C2 20 4 22 6.5 22C9 22 11 20 11 17.5C11 15 9 13 6.5 13ZM17.5 13C15 13 13 15 13 17.5C13 20 15 22 17.5 22C20 22 22 20 22 17.5C22 15 20 13 17.5 13Z"
																		fill="black" />
																	<path
																		d="M17.5 16C17.5 16 17.4 16 17.5 16L16.7 15.3C16.1 14.7 15.7 13.9 15.6 13.1C15.5 12.4 15.5 11.6 15.6 10.8C15.7 9.99999 16.1 9.19998 16.7 8.59998L17.4 7.90002H17.5C18.3 7.90002 19 7.20002 19 6.40002C19 5.60002 18.3 4.90002 17.5 4.90002C16.7 4.90002 16 5.60002 16 6.40002V6.5L15.3 7.20001C14.7 7.80001 13.9 8.19999 13.1 8.29999C12.4 8.39999 11.6 8.39999 10.8 8.29999C9.99999 8.19999 9.20001 7.80001 8.60001 7.20001L7.89999 6.5V6.40002C7.89999 5.60002 7.19999 4.90002 6.39999 4.90002C5.59999 4.90002 4.89999 5.60002 4.89999 6.40002C4.89999 7.20002 5.59999 7.90002 6.39999 7.90002H6.5L7.20001 8.59998C7.80001 9.19998 8.19999 9.99999 8.29999 10.8C8.39999 11.5 8.39999 12.3 8.29999 13.1C8.19999 13.9 7.80001 14.7 7.20001 15.3L6.5 16H6.39999C5.59999 16 4.89999 16.7 4.89999 17.5C4.89999 18.3 5.59999 19 6.39999 19C7.19999 19 7.89999 18.3 7.89999 17.5V17.4L8.60001 16.7C9.20001 16.1 9.99999 15.7 10.8 15.6C11.5 15.5 12.3 15.5 13.1 15.6C13.9 15.7 14.7 16.1 15.3 16.7L16 17.4V17.5C16 18.3 16.7 19 17.5 19C18.3 19 19 18.3 19 17.5C19 16.7 18.3 16 17.5 16Z"
																		fill="black" />
																</svg>
															</span>
															<!--end::Svg Icon-->
														</span>
													</div>
													<!--end::Symbol-->
													<!--begin::Title-->
													<div class="mb-0 me-2">
														<a href="#"
															class="fs-6 text-gray-800 text-hover-primary fw-bolder">Project
															Alice</a>
														<div class="text-gray-400 fs-7">Phase 1 development</div>
													</div>
													<!--end::Title-->
												</div>
												<!--end::Section-->
												<!--begin::Label-->
												<span class="badge badge-light fs-8">1 hr</span>
												<!--end::Label-->
											</div>
											<!--end::Item-->
											<!--begin::Item-->
											<div class="d-flex flex-stack py-4">
												<!--begin::Section-->
												<div class="d-flex align-items-center">
													<!--begin::Symbol-->
													<div class="symbol symbol-35px me-4">
														<span class="symbol-label bg-light-danger">
															<!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
															<span class="svg-icon svg-icon-2 svg-icon-danger">
																<svg xmlns="http://www.w3.org/2000/svg" width="24"
																	height="24" viewBox="0 0 24 24" fill="none">
																	<rect opacity="0.3" x="2" y="2" width="20"
																		height="20" rx="10" fill="black" />
																	<rect x="11" y="14" width="7" height="2" rx="1"
																		transform="rotate(-90 11 14)" fill="black" />
																	<rect x="11" y="17" width="2" height="2" rx="1"
																		transform="rotate(-90 11 17)" fill="black" />
																</svg>
															</span>
															<!--end::Svg Icon-->
														</span>
													</div>
													<!--end::Symbol-->
													<!--begin::Title-->
													<div class="mb-0 me-2">
														<a href="#"
															class="fs-6 text-gray-800 text-hover-primary fw-bolder">HR
															Confidential</a>
														<div class="text-gray-400 fs-7">Confidential staff documents
														</div>
													</div>
													<!--end::Title-->
												</div>
												<!--end::Section-->
												<!--begin::Label-->
												<span class="badge badge-light fs-8">2 hrs</span>
												<!--end::Label-->
											</div>
											<!--end::Item-->
											<!--begin::Item-->
											<div class="d-flex flex-stack py-4">
												<!--begin::Section-->
												<div class="d-flex align-items-center">
													<!--begin::Symbol-->
													<div class="symbol symbol-35px me-4">
														<span class="symbol-label bg-light-warning">
															<!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
															<span class="svg-icon svg-icon-2 svg-icon-warning">
																<svg xmlns="http://www.w3.org/2000/svg" width="24"
																	height="24" viewBox="0 0 24 24" fill="none">
																	<path opacity="0.3"
																		d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z"
																		fill="black" />
																	<path
																		d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z"
																		fill="black" />
																</svg>
															</span>
															<!--end::Svg Icon-->
														</span>
													</div>
													<!--end::Symbol-->
													<!--begin::Title-->
													<div class="mb-0 me-2">
														<a href="#"
															class="fs-6 text-gray-800 text-hover-primary fw-bolder">Company
															HR</a>
														<div class="text-gray-400 fs-7">Corporeate staff profiles</div>
													</div>
													<!--end::Title-->
												</div>
												<!--end::Section-->
												<!--begin::Label-->
												<span class="badge badge-light fs-8">5 hrs</span>
												<!--end::Label-->
											</div>
											<!--end::Item-->
											<!--begin::Item-->
											<div class="d-flex flex-stack py-4">
												<!--begin::Section-->
												<div class="d-flex align-items-center">
													<!--begin::Symbol-->
													<div class="symbol symbol-35px me-4">
														<span class="symbol-label bg-light-success">
															<!--begin::Svg Icon | path: icons/duotune/files/fil023.svg-->
															<span class="svg-icon svg-icon-2 svg-icon-success">
																<svg xmlns="http://www.w3.org/2000/svg" width="24"
																	height="24" viewBox="0 0 24 24" fill="none">
																	<path opacity="0.3"
																		d="M5 15C3.3 15 2 13.7 2 12C2 10.3 3.3 9 5 9H5.10001C5.00001 8.7 5 8.3 5 8C5 5.2 7.2 3 10 3C11.9 3 13.5 4 14.3 5.5C14.8 5.2 15.4 5 16 5C17.7 5 19 6.3 19 8C19 8.4 18.9 8.7 18.8 9C18.9 9 18.9 9 19 9C20.7 9 22 10.3 22 12C22 13.7 20.7 15 19 15H5ZM5 12.6H13L9.7 9.29999C9.3 8.89999 8.7 8.89999 8.3 9.29999L5 12.6Z"
																		fill="black" />
																	<path
																		d="M17 17.4V12C17 11.4 16.6 11 16 11C15.4 11 15 11.4 15 12V17.4H17Z"
																		fill="black" />
																	<path opacity="0.3"
																		d="M12 17.4H20L16.7 20.7C16.3 21.1 15.7 21.1 15.3 20.7L12 17.4Z"
																		fill="black" />
																	<path
																		d="M8 12.6V18C8 18.6 8.4 19 9 19C9.6 19 10 18.6 10 18V12.6H8Z"
																		fill="black" />
																</svg>
															</span>
															<!--end::Svg Icon-->
														</span>
													</div>
													<!--end::Symbol-->
													<!--begin::Title-->
													<div class="mb-0 me-2">
														<a href="#"
															class="fs-6 text-gray-800 text-hover-primary fw-bolder">Project
															Redux</a>
														<div class="text-gray-400 fs-7">New frontend admin theme</div>
													</div>
													<!--end::Title-->
												</div>
												<!--end::Section-->
												<!--begin::Label-->
												<span class="badge badge-light fs-8">2 days</span>
												<!--end::Label-->
											</div>
											<!--end::Item-->
											<!--begin::Item-->
											<div class="d-flex flex-stack py-4">
												<!--begin::Section-->
												<div class="d-flex align-items-center">
													<!--begin::Symbol-->
													<div class="symbol symbol-35px me-4">
														<span class="symbol-label bg-light-primary">
															<!--begin::Svg Icon | path: icons/duotune/maps/map001.svg-->
															<span class="svg-icon svg-icon-2 svg-icon-primary">
																<svg xmlns="http://www.w3.org/2000/svg" width="24"
																	height="24" viewBox="0 0 24 24" fill="none">
																	<path opacity="0.3"
																		d="M6 22H4V3C4 2.4 4.4 2 5 2C5.6 2 6 2.4 6 3V22Z"
																		fill="black" />
																	<path
																		d="M18 14H4V4H18C18.8 4 19.2 4.9 18.7 5.5L16 9L18.8 12.5C19.3 13.1 18.8 14 18 14Z"
																		fill="black" />
																</svg>
															</span>
															<!--end::Svg Icon-->
														</span>
													</div>
													<!--end::Symbol-->
													<!--begin::Title-->
													<div class="mb-0 me-2">
														<a href="#"
															class="fs-6 text-gray-800 text-hover-primary fw-bolder">Project
															Breafing</a>
														<div class="text-gray-400 fs-7">Product launch status update
														</div>
													</div>
													<!--end::Title-->
												</div>
												<!--end::Section-->
												<!--begin::Label-->
												<span class="badge badge-light fs-8">21 Jan</span>
												<!--end::Label-->
											</div>
											<!--end::Item-->
											<!--begin::Item-->
											<div class="d-flex flex-stack py-4">
												<!--begin::Section-->
												<div class="d-flex align-items-center">
													<!--begin::Symbol-->
													<div class="symbol symbol-35px me-4">
														<span class="symbol-label bg-light-info">
															<!--begin::Svg Icon | path: icons/duotune/general/gen006.svg-->
															<span class="svg-icon svg-icon-2 svg-icon-info">
																<svg xmlns="http://www.w3.org/2000/svg" width="24"
																	height="24" viewBox="0 0 24 24" fill="none">
																	<path opacity="0.3"
																		d="M22 5V19C22 19.6 21.6 20 21 20H19.5L11.9 12.4C11.5 12 10.9 12 10.5 12.4L3 20C2.5 20 2 19.5 2 19V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5ZM7.5 7C6.7 7 6 7.7 6 8.5C6 9.3 6.7 10 7.5 10C8.3 10 9 9.3 9 8.5C9 7.7 8.3 7 7.5 7Z"
																		fill="black" />
																	<path
																		d="M19.1 10C18.7 9.60001 18.1 9.60001 17.7 10L10.7 17H2V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V12.9L19.1 10Z"
																		fill="black" />
																</svg>
															</span>
															<!--end::Svg Icon-->
														</span>
													</div>
													<!--end::Symbol-->
													<!--begin::Title-->
													<div class="mb-0 me-2">
														<a href="#"
															class="fs-6 text-gray-800 text-hover-primary fw-bolder">Banner
															<?= base_url() ?>assets</a>
														<div class="text-gray-400 fs-7">Collection of banner images
														</div>
													</div>
													<!--end::Title-->
												</div>
												<!--end::Section-->
												<!--begin::Label-->
												<span class="badge badge-light fs-8">21 Jan</span>
												<!--end::Label-->
											</div>
											<!--end::Item-->
											<!--begin::Item-->
											<div class="d-flex flex-stack py-4">
												<!--begin::Section-->
												<div class="d-flex align-items-center">
													<!--begin::Symbol-->
													<div class="symbol symbol-35px me-4">
														<span class="symbol-label bg-light-warning">
															<!--begin::Svg Icon | path: icons/duotune/art/art002.svg-->
															<span class="svg-icon svg-icon-2 svg-icon-warning">
																<svg xmlns="http://www.w3.org/2000/svg" width="24"
																	height="25" viewBox="0 0 24 25" fill="none">
																	<path opacity="0.3"
																		d="M8.9 21L7.19999 22.6999C6.79999 23.0999 6.2 23.0999 5.8 22.6999L4.1 21H8.9ZM4 16.0999L2.3 17.8C1.9 18.2 1.9 18.7999 2.3 19.1999L4 20.9V16.0999ZM19.3 9.1999L15.8 5.6999C15.4 5.2999 14.8 5.2999 14.4 5.6999L9 11.0999V21L19.3 10.6999C19.7 10.2999 19.7 9.5999 19.3 9.1999Z"
																		fill="black" />
																	<path
																		d="M21 15V20C21 20.6 20.6 21 20 21H11.8L18.8 14H20C20.6 14 21 14.4 21 15ZM10 21V4C10 3.4 9.6 3 9 3H4C3.4 3 3 3.4 3 4V21C3 21.6 3.4 22 4 22H9C9.6 22 10 21.6 10 21ZM7.5 18.5C7.5 19.1 7.1 19.5 6.5 19.5C5.9 19.5 5.5 19.1 5.5 18.5C5.5 17.9 5.9 17.5 6.5 17.5C7.1 17.5 7.5 17.9 7.5 18.5Z"
																		fill="black" />
																</svg>
															</span>
															<!--end::Svg Icon-->
														</span>
													</div>
													<!--end::Symbol-->
													<!--begin::Title-->
													<div class="mb-0 me-2">
														<a href="#"
															class="fs-6 text-gray-800 text-hover-primary fw-bolder">Icon
															<?= base_url() ?>assets</a>
														<div class="text-gray-400 fs-7">Collection of SVG icons</div>
													</div>
													<!--end::Title-->
												</div>
												<!--end::Section-->
												<!--begin::Label-->
												<span class="badge badge-light fs-8">20 March</span>
												<!--end::Label-->
											</div>
											<!--end::Item-->
										</div>
										<!--end::Items-->
										<!--begin::View more-->
										<div class="py-3 text-center border-top">
											<a href="../dist/pages/profile/activity.html"
												class="btn btn-color-gray-600 btn-active-color-primary">View All
												<!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
												<span class="svg-icon svg-icon-5">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
														viewBox="0 0 24 24" fill="none">
														<rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
															transform="rotate(-180 18 13)" fill="black" />
														<path
															d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
															fill="black" />
													</svg>
												</span>
												<!--end::Svg Icon--></a>
										</div>
										<!--end::View more-->
									</div>
									<!--end::Tab panel-->
									<!--begin::Tab panel-->
									<div class="tab-pane fade show active" id="kt_topbar_notifications_2"
										role="tabpanel">
										<!--begin::Wrapper-->
										<div class="d-flex flex-column px-9">
											<!--begin::Section-->
											<div class="pt-10 pb-0">
												<!--begin::Title-->
												<h3 class="text-dark text-center fw-bolder">Get Pro Access</h3>
												<!--end::Title-->
												<!--begin::Text-->
												<div class="text-center text-gray-600 fw-bold pt-1">Outlines keep you
													honest. They stoping you from amazing poorly about drive</div>
												<!--end::Text-->
												<!--begin::Action-->
												<div class="text-center mt-5 mb-9">
													<a href="#" class="btn btn-sm btn-primary px-6"
														data-bs-toggle="modal"
														data-bs-target="#kt_modal_upgrade_plan">Upgrade</a>
												</div>
												<!--end::Action-->
											</div>
											<!--end::Section-->
											<!--begin::Illustration-->
											<div class="text-center px-4">
												<img class="mw-100 mh-200px" alt="metronic"
													src="<?= base_url() ?>assets/media/illustrations/sigma-1/6.png" />
											</div>
											<!--end::Illustration-->
										</div>
										<!--end::Wrapper-->
									</div>
									<!--end::Tab panel-->
									<!--begin::Tab panel-->
									<div class="tab-pane fade" id="kt_topbar_notifications_3" role="tabpanel">
										<!--begin::Items-->
										<div class="scroll-y mh-325px my-5 px-8">
											<!--begin::Item-->
											<div class="d-flex flex-stack py-4">
												<!--begin::Section-->
												<div class="d-flex align-items-center me-2">
													<!--begin::Code-->
													<span class="w-70px badge badge-light-success me-4">200 OK</span>
													<!--end::Code-->
													<!--begin::Title-->
													<a href="#" class="text-gray-800 text-hover-primary fw-bold">New
														order</a>
													<!--end::Title-->
												</div>
												<!--end::Section-->
												<!--begin::Label-->
												<span class="badge badge-light fs-8">Just now</span>
												<!--end::Label-->
											</div>
											<!--end::Item-->
											<!--begin::Item-->
											<div class="d-flex flex-stack py-4">
												<!--begin::Section-->
												<div class="d-flex align-items-center me-2">
													<!--begin::Code-->
													<span class="w-70px badge badge-light-danger me-4">500 ERR</span>
													<!--end::Code-->
													<!--begin::Title-->
													<a href="#" class="text-gray-800 text-hover-primary fw-bold">New
														customer</a>
													<!--end::Title-->
												</div>
												<!--end::Section-->
												<!--begin::Label-->
												<span class="badge badge-light fs-8">2 hrs</span>
												<!--end::Label-->
											</div>
											<!--end::Item-->
											<!--begin::Item-->
											<div class="d-flex flex-stack py-4">
												<!--begin::Section-->
												<div class="d-flex align-items-center me-2">
													<!--begin::Code-->
													<span class="w-70px badge badge-light-success me-4">200 OK</span>
													<!--end::Code-->
													<!--begin::Title-->
													<a href="#" class="text-gray-800 text-hover-primary fw-bold">Payment
														process</a>
													<!--end::Title-->
												</div>
												<!--end::Section-->
												<!--begin::Label-->
												<span class="badge badge-light fs-8">5 hrs</span>
												<!--end::Label-->
											</div>
											<!--end::Item-->
											<!--begin::Item-->
											<div class="d-flex flex-stack py-4">
												<!--begin::Section-->
												<div class="d-flex align-items-center me-2">
													<!--begin::Code-->
													<span class="w-70px badge badge-light-warning me-4">300 WRN</span>
													<!--end::Code-->
													<!--begin::Title-->
													<a href="#" class="text-gray-800 text-hover-primary fw-bold">Search
														query</a>
													<!--end::Title-->
												</div>
												<!--end::Section-->
												<!--begin::Label-->
												<span class="badge badge-light fs-8">2 days</span>
												<!--end::Label-->
											</div>
											<!--end::Item-->
											<!--begin::Item-->
											<div class="d-flex flex-stack py-4">
												<!--begin::Section-->
												<div class="d-flex align-items-center me-2">
													<!--begin::Code-->
													<span class="w-70px badge badge-light-success me-4">200 OK</span>
													<!--end::Code-->
													<!--begin::Title-->
													<a href="#" class="text-gray-800 text-hover-primary fw-bold">API
														connection</a>
													<!--end::Title-->
												</div>
												<!--end::Section-->
												<!--begin::Label-->
												<span class="badge badge-light fs-8">1 week</span>
												<!--end::Label-->
											</div>
											<!--end::Item-->
											<!--begin::Item-->
											<div class="d-flex flex-stack py-4">
												<!--begin::Section-->
												<div class="d-flex align-items-center me-2">
													<!--begin::Code-->
													<span class="w-70px badge badge-light-success me-4">200 OK</span>
													<!--end::Code-->
													<!--begin::Title-->
													<a href="#"
														class="text-gray-800 text-hover-primary fw-bold">Database
														restore</a>
													<!--end::Title-->
												</div>
												<!--end::Section-->
												<!--begin::Label-->
												<span class="badge badge-light fs-8">Mar 5</span>
												<!--end::Label-->
											</div>
											<!--end::Item-->
											<!--begin::Item-->
											<div class="d-flex flex-stack py-4">
												<!--begin::Section-->
												<div class="d-flex align-items-center me-2">
													<!--begin::Code-->
													<span class="w-70px badge badge-light-warning me-4">300 WRN</span>
													<!--end::Code-->
													<!--begin::Title-->
													<a href="#" class="text-gray-800 text-hover-primary fw-bold">System
														update</a>
													<!--end::Title-->
												</div>
												<!--end::Section-->
												<!--begin::Label-->
												<span class="badge badge-light fs-8">May 15</span>
												<!--end::Label-->
											</div>
											<!--end::Item-->
											<!--begin::Item-->
											<div class="d-flex flex-stack py-4">
												<!--begin::Section-->
												<div class="d-flex align-items-center me-2">
													<!--begin::Code-->
													<span class="w-70px badge badge-light-warning me-4">300 WRN</span>
													<!--end::Code-->
													<!--begin::Title-->
													<a href="#" class="text-gray-800 text-hover-primary fw-bold">Server
														OS update</a>
													<!--end::Title-->
												</div>
												<!--end::Section-->
												<!--begin::Label-->
												<span class="badge badge-light fs-8">Apr 3</span>
												<!--end::Label-->
											</div>
											<!--end::Item-->
											<!--begin::Item-->
											<div class="d-flex flex-stack py-4">
												<!--begin::Section-->
												<div class="d-flex align-items-center me-2">
													<!--begin::Code-->
													<span class="w-70px badge badge-light-warning me-4">300 WRN</span>
													<!--end::Code-->
													<!--begin::Title-->
													<a href="#" class="text-gray-800 text-hover-primary fw-bold">API
														rollback</a>
													<!--end::Title-->
												</div>
												<!--end::Section-->
												<!--begin::Label-->
												<span class="badge badge-light fs-8">Jun 30</span>
												<!--end::Label-->
											</div>
											<!--end::Item-->
											<!--begin::Item-->
											<div class="d-flex flex-stack py-4">
												<!--begin::Section-->
												<div class="d-flex align-items-center me-2">
													<!--begin::Code-->
													<span class="w-70px badge badge-light-danger me-4">500 ERR</span>
													<!--end::Code-->
													<!--begin::Title-->
													<a href="#" class="text-gray-800 text-hover-primary fw-bold">Refund
														process</a>
													<!--end::Title-->
												</div>
												<!--end::Section-->
												<!--begin::Label-->
												<span class="badge badge-light fs-8">Jul 10</span>
												<!--end::Label-->
											</div>
											<!--end::Item-->
											<!--begin::Item-->
											<div class="d-flex flex-stack py-4">
												<!--begin::Section-->
												<div class="d-flex align-items-center me-2">
													<!--begin::Code-->
													<span class="w-70px badge badge-light-danger me-4">500 ERR</span>
													<!--end::Code-->
													<!--begin::Title-->
													<a href="#"
														class="text-gray-800 text-hover-primary fw-bold">Withdrawal
														process</a>
													<!--end::Title-->
												</div>
												<!--end::Section-->
												<!--begin::Label-->
												<span class="badge badge-light fs-8">Sep 10</span>
												<!--end::Label-->
											</div>
											<!--end::Item-->
											<!--begin::Item-->
											<div class="d-flex flex-stack py-4">
												<!--begin::Section-->
												<div class="d-flex align-items-center me-2">
													<!--begin::Code-->
													<span class="w-70px badge badge-light-danger me-4">500 ERR</span>
													<!--end::Code-->
													<!--begin::Title-->
													<a href="#" class="text-gray-800 text-hover-primary fw-bold">Mail
														tasks</a>
													<!--end::Title-->
												</div>
												<!--end::Section-->
												<!--begin::Label-->
												<span class="badge badge-light fs-8">Dec 10</span>
												<!--end::Label-->
											</div>
											<!--end::Item-->
										</div>
										<!--end::Items-->
										<!--begin::View more-->
										<div class="py-3 text-center border-top">
											<a href="../dist/pages/profile/activity.html"
												class="btn btn-color-gray-600 btn-active-color-primary">View All
												<!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
												<span class="svg-icon svg-icon-5">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
														viewBox="0 0 24 24" fill="none">
														<rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
															transform="rotate(-180 18 13)" fill="black" />
														<path
															d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
															fill="black" />
													</svg>
												</span>
												<!--end::Svg Icon--></a>
										</div>
										<!--end::View more-->
									</div>
									<!--end::Tab panel-->
								</div>
								<!--end::Tab content-->
							</div>
							<!--end::Menu-->
							<!--end::Menu wrapper-->
						</div>
						<!--end::Notifications-->
						<!--begin::Activities-->
						<div class="d-flex align-items-center mb-3">
							<!--begin::Drawer toggle-->
							<div class="btn btn-icon btn-custom" data-kt-menu-trigger="click"
								data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-bs-toggle="tooltip"
								data-bs-placement="right" data-bs-dismiss="click" title="Activity Logs"
								id="kt_activities_toggle">
								<!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
								<span class="svg-icon svg-icon-2 svg-icon-lg-1">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
										fill="none">
										<rect x="8" y="9" width="3" height="10" rx="1.5" fill="black" />
										<rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="black" />
										<rect x="18" y="11" width="3" height="8" rx="1.5" fill="black" />
										<rect x="3" y="13" width="3" height="6" rx="1.5" fill="black" />
									</svg>
								</span>
								<!--end::Svg Icon-->
							</div>
							<!--end::drawer toggle-->
						</div>
						<!--end::Activities-->
						<!--begin::User-->
						<div class="d-flex align-items-center mb-10" id="kt_header_user_menu_toggle">
							<!--begin::Menu wrapper-->
							<div class="cursor-pointer symbol symbol-40px" data-kt-menu-trigger="click"
								data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-bs-toggle="tooltip"
								data-bs-placement="right" data-bs-dismiss="click" title="User profile">
								<img src="<?= base_url() ?>assets/media/avatars/150-26.jpg" alt="image" />
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
											<div class="fw-bolder d-flex align-items-center fs-5">Max Smith
												<span
													class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">Pro</span>
											</div>
											<a href="#"
												class="fw-bold text-muted text-hover-primary fs-7">max@kt.com</a>
										</div>
										<!--end::Username-->
									</div>
								</div>
								<!--end::Menu item-->
								<!--begin::Menu separator-->
								<div class="separator my-2"></div>
								<!--end::Menu separator-->
								<!--begin::Menu item-->
								<div class="menu-item px-5">
									<a href="../dist/account/overview.html" class="menu-link px-5">My Profile</a>
								</div>
								<!--end::Menu item-->
								<!--begin::Menu item-->
								<div id="school_active_year" data-id="<?= year_active() != null ? year_active()['school_year_id'] : '' ?>"></div>
								<<div class="menu-item px-5"
									data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
									<a onclick="show_tp();" class="menu-link px-5">
										<span class="menu-title position-relative"><?= year_active() != null ? 'T.P ' . year_active()['school_year_period'] : 'T.P [belum dipilih]' ?>
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
							<div class="menu-item px-5" data-kt-menu-trigger="hover"
								data-kt-menu-placement="right-end">
								<a href="#" class="menu-link px-5">
									<span class="menu-title">My Subscription</span>
									<span class="menu-arrow"></span>
								</a>
								<!--begin::Menu sub-->
								<div class="menu-sub menu-sub-dropdown w-175px py-4">
									<!--begin::Menu item-->
									<div class="menu-item px-3">
										<a href="#" class="menu-link px-5">Referrals</a>
									</div>
									<!--end::Menu item-->
									<!--begin::Menu item-->
									<div class="menu-item px-3">
										<a href="#" class="menu-link px-5">Billing</a>
									</div>
									<!--end::Menu item-->
									<!--begin::Menu item-->
									<div class="menu-item px-3">
										<a href="#" class="menu-link px-5">Payments</a>
									</div>
									<!--end::Menu item-->
									<!--begin::Menu item-->
									<div class="menu-item px-3">
										<a href="#" class="menu-link d-flex flex-stack px-5">Statements
											<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
												title="View your statements"></i></a>
									</div>
									<!--end::Menu item-->
									<!--begin::Menu separator-->
									<div class="separator my-2"></div>
									<!--end::Menu separator-->
									<!--begin::Menu item-->
									<div class="menu-item px-3">
										<div class="menu-content px-3">
											<label
												class="form-check form-switch form-check-custom form-check-solid">
												<input class="form-check-input w-30px h-20px" type="checkbox"
													value="1" checked="checked" name="notifications" />
												<span class="form-check-label text-muted fs-7">Notifications</span>
											</label>
										</div>
									</div>
									<!--end::Menu item-->
								</div>
								<!--end::Menu sub-->
							</div>
							<!--end::Menu item-->
							<!--begin::Menu item-->
							<div class="menu-item px-5">
								<a href="#" class="menu-link px-5">My Activities</a>
							</div>
							<!--end::Menu item-->
							<!--begin::Menu separator-->
							<div class="separator my-2"></div>
							<!--end::Menu separator-->
							<!--begin::Menu item-->
							<div class="menu-item px-5" data-kt-menu-trigger="hover"
								data-kt-menu-placement="right-end">
								<a href="#" class="menu-link px-5">
									<span class="menu-title position-relative">Language
										<span
											class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">English
											<img class="w-15px h-15px rounded-1 ms-2"
												src="<?= base_url() ?>assets/media/flags/united-states.svg"
												alt="" /></span></span>
								</a>
								<!--begin::Menu sub-->
								<div class="menu-sub menu-sub-dropdown w-175px py-4">
									<!--begin::Menu item-->
									<div class="menu-item px-3">
										<a href="#" class="menu-link d-flex px-5 active">
											<span class="symbol symbol-20px me-4">
												<img class="rounded-1"
													src="<?= base_url() ?>assets/media/flags/united-states.svg"
													alt="" />
											</span>English</a>
									</div>
									<!--end::Menu item-->
									<!--begin::Menu item-->
									<div class="menu-item px-3">
										<a href="#" class="menu-link d-flex px-5">
											<span class="symbol symbol-20px me-4">
												<img class="rounded-1"
													src="<?= base_url() ?>assets/media/flags/spain.svg" alt="" />
											</span>Spanish</a>
									</div>
									<!--end::Menu item-->
									<!--begin::Menu item-->
									<div class="menu-item px-3">
										<a href="#" class="menu-link d-flex px-5">
											<span class="symbol symbol-20px me-4">
												<img class="rounded-1"
													src="<?= base_url() ?>assets/media/flags/germany.svg" alt="" />
											</span>German</a>
									</div>
									<!--end::Menu item-->
									<!--begin::Menu item-->
									<div class="menu-item px-3">
										<a href="#" class="menu-link d-flex px-5">
											<span class="symbol symbol-20px me-4">
												<img class="rounded-1"
													src="<?= base_url() ?>assets/media/flags/japan.svg" alt="" />
											</span>Japanese</a>
									</div>
									<!--end::Menu item-->
									<!--begin::Menu item-->
									<div class="menu-item px-3">
										<a href="#" class="menu-link d-flex px-5">
											<span class="symbol symbol-20px me-4">
												<img class="rounded-1"
													src="<?= base_url() ?>assets/media/flags/france.svg" alt="" />
											</span>French</a>
									</div>
									<!--end::Menu item-->
								</div>
								<!--end::Menu sub-->
							</div>
							<!--end::Menu item-->
							<!--begin::Menu item-->
							<div class="menu-item px-5 my-1">
								<a href="#" class="menu-link px-5">Account Settings</a>
							</div>
							<!--end::Menu item-->
							<!--begin::Menu item-->
							<div class="menu-item px-5">
								<a href="<?= base_url() ?>logout" class="menu-link px-5">Keluar</a>
							</div>
							<!--end::Menu item-->
							<!--begin::Menu separator-->
							<div class="separator my-2"></div>
							<!--end::Menu separator-->
							<!--begin::Menu item-->
							<div class="menu-item px-5">
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
							</div>
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
						<div class="d-flex ms-3">
							<a href="#" class="btn bg-body btn-color-gray-600 btn-active-info" tooltip="New Member"
								data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends">New User</a>
						</div>
						<!--end::Invite user-->
						<!--begin::Create app-->
						<div class="d-flex ms-3">
							<a href="#" class="btn btn-info" tooltip="New App" data-bs-toggle="modal"
								data-bs-target="#kt_modal_create_app" id="kt_toolbar_primary_button">New Goal</a>
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
						<a href="https://keenthemes.com" target="_blank"
							class="text-muted text-hover-primary fw-bold me-2 fs-6">Keenthemes</a>
					</div>
					<!--end::Copyright-->
					<!--begin::Menu-->
					<ul class="menu menu-gray-600 menu-hover-primary fw-bold order-1">
						<li class="menu-item">
							<a href="https://keenthemes.com" target="_blank" class="menu-link px-2">About</a>
						</li>
						<li class="menu-item">
							<a href="https://keenthemes.com/support" target="_blank"
								class="menu-link px-2">Support</a>
						</li>
						<li class="menu-item">
							<a href="https://keenthemes.com/products/seven-html-pro" target="_blank"
								class="menu-link px-2">Purchase</a>
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
	<script>
		const base_url = document.getElementById('base').value;
		let idc_public = '<?= session()->getFlashdata('id_content') ?>'
		let att_id = '<?= session()->getFlashdata('att_id') ?>'
		let file_id = '<?= session()->getFlashdata('file_id') ?>'
		let hostUrl = "<?= base_url() ?>assets/";
		let active_year = '<?= year_active() != null ? year_active()['school_year_period'] : '' ?>'
		let level = '<?= session()->get('c_role') ?>'
		const url = window.location.href;
	</script>
	<!--begin::Javascript-->
	<!--begin::Global Javascript Bundle(used by all pages)-->
	<script src="<?= base_url() ?>assets/js/jquery.3.2.1.min.js"></script>
	<script src="<?= base_url() ?>assets/plugins/global/plugins.bundle.js"></script>
	<!-- <script src="<?= base_url() ?>assets/plugins/custom/datatables/datatables.bundle.js"></script> -->

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	<script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>

	<script src="<?= base_url() ?>assets/js/scripts.bundle.js"></script>
	<script src="<?= base_url() ?>assets/js/jquery.toast.js"></script>
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
			position: "top-end",
			showConfirmButton: false,
			timer: 5000,
			timerProgressBar: true,
			didOpen: (toast) => {
				toast.onmouseenter = Swal.stopTimer;
				toast.onmouseleave = Swal.resumeTimer;
			}
		});

		function al_swal(msg, type) {
			Swal.fire({
				text: msg,
				icon: type,
				buttonsStyling: false,
				confirmButtonText: "Ok",
				customClass: {
					confirmButton: "btn btn-primary"
				}
			});
		}

		function set_year(e) {
			$.ajax({
				url: "<?= base_url('/config-teacher-student/active-year/set-year') ?>",
				type: "post",
				data: {
					'year_id': $('input[name="radio_tp"]:checked').val()
				},
				dataType: "json",
				beforeSend: function() {
					// show_loading()
				},
				success: function(data) {
					// hide_loading()
				}
			})
		}

		function generate_years(e) {
			let view = ''
			let active = '<?= year_active() != null ? year_active()['school_year_id'] : '' ?>'
			console.log(active);
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

		function show_tp() {
			$.ajax({
				url: "<?= base_url('/config-teacher-student/active-year/list-year') ?>",
				type: "post",
				// data: {'menu_id': param},
				dataType: "json",
				beforeSend: function() {
					// show_loading()
				},
				success: function(data) {
					generate_years(data)
					// hide_loading()
				}
			})
		}
	</script>

	<script src="<?= base_url() ?>assets/js/script/lesson_school.js"></script>
	<script src="<?= base_url() ?>assets/js/script/lesson_additional.js"></script>
	<script src="<?= base_url() ?>assets/js/script/lesson_standard.js"></script>
	<script src="<?= base_url() ?>assets/js/script/lesson_public.js"></script>
	<script src="<?= base_url() ?>assets/js/script/question_bank.js"></script>
	<script src="<?= base_url() ?>assets/js/script/assessment.js"></script>
	<script src="<?= base_url() ?>assets/js/script/first_page.js"></script>
	<script src="<?= base_url() ?>assets/js/script/tasks.js"></script>
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