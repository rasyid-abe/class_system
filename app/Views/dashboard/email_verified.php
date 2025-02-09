<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Blaze
Product Version: 1.0.1
Purchase: https://keenthemes.com/products/blaze-html-pro
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
	<!--begin::Head-->
	<head>
		<title>Blaze HTML Pro- Bootstrap 5 HTML Multipurpose Admin Dashboard Theme by Keenthemes</title>
		<meta charset="utf-8" />
		<meta name="description" content="Blaze admin dashboard live demo. Check out all the features of the admin panel. A large number of settings, additional services and widgets." />
		<meta name="keywords" content="Blaze theme, bootstrap, bootstrap 5, admin themes, free admin themes, bootstrap admin, bootstrap dashboard" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Blaze HTML Pro - Bootstrap 5 HTML Multipurpose Admin Dashboard Theme" />
		<meta property="og:url" content="https://keenthemes.com/products/blaze-html-pro" />
		<meta property="og:site_name" content="Keenthemes | Blaze HTML Pro" />
		<link rel="canonical" href="https://preview.keenthemes.com/blaze-html-pro" />
		<link rel="shortcut icon" href="<?= base_url() ?>blaze-assets/media/logos/favicon.ico" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="<?= base_url() ?>blaze-assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?= base_url() ?>blaze-assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
		<script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="app-blank">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Authentication - Signup Verify Email -->
			<div class="d-flex flex-column flex-column-fluid">
				<!--begin::Content-->
				<div class="d-flex flex-row-fluid flex-column flex-column-fluid text-center p-10 py-lg-20">
					<!--begin::Logo-->
					<a href="../dist/index.html" class="pt-lg-20 mb-12">
						<img alt="Logo" src="<?= base_url() ?>blaze-assets/media/logos/default-dark.svg" class="theme-light-show h-40px h-lg-50px" />
						<img alt="Logo" src="<?= base_url() ?>blaze-assets/media/logos/default.svg" class="theme-dark-show h-40px h-lg-50px" />
					</a>
					<!--end::Logo-->
					<!--begin::Logo-->
					<h1 class="fw-bold fs-2qx text-gray-800 mb-7"><?= $head ?></h1>
					<!--end::Logo-->
					<!--begin::Message-->
					<div class="fs-3 fw-semibold text-muted mb-10"><?= $msg ?></div>
					<!--end::Message-->
					<!--begin::Action-->
					<div class="text-center mb-10">
						<a href="<?= base_url('/dashboard/school') ?>" class="btn btn-lg btn-primary fw-bold">Dashboard</a>
					</div>
					<!--end::Action-->
				</div>
				<!--end::Content-->
				<!--begin::Illustration-->
				<div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-150px min-h-lg-350px" style="background-image: url(<?= base_url() ?>blaze-assets/media/illustrations/sketchy-1/7.png)"></div>
				<!--end::Illustration-->
			</div>
			<!--end::Authentication - Signup Verify Email-->
		</div>
		<!--end::Root-->
		<!--begin::Javascript-->
		<script>var hostUrl = "<?= base_url() ?>blaze-assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="<?= base_url() ?>blaze-assets/plugins/global/plugins.bundle.js"></script>
		<script src="<?= base_url() ?>blaze-assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>