        <title>Seven HTML Pro - Bootstrap 5 HTML Multipurpose Light/Dark Admin Dashboard Theme by KeenThemes</title>
        <meta charset="utf-8">
        <meta name="description" content="Seven admin dashboard live demo. Check out all the features of the admin panel. Light &amp; dark skins. A large number of settings, additional services and widgets.">
        <meta name="keywords" content="Seven, bootstrap, bootstrap 5, dmin themes, free admin themes, bootstrap admin, bootstrap dashboard">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="og:locale" content="en_US">
        <meta property="og:type" content="article">
        <meta property="og:title" content="Seven HTML Pro - Bootstrap 5 HTML Multipurpose Light/Dark Admin Dashboard Theme by KeenThemes">
        <meta property="og:url" content="https://keenthemes.com/products/seven-html-pro">
        <meta property="og:site_name" content="Seven HTML Pro by Keenthemes">
        <link rel="canonical" href="https://preview.keenthemes.com/seven-html-pro/authentication/general/error-500.html">
        <link rel="shortcut icon" href="<?= base_url() ?>assets/media/logos/favicon.ico">




        <link href="<?= base_url() ?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css">
        <link href="<?= base_url() ?>assets/css/style.bundle.css" rel="stylesheet" type="text/css">

        <script async="" src="https://www.googletagmanager.com/gtag/js?id=G-52YZ3XGZJ6"></script>
        <script>
             window.dataLayer = window.dataLayer || [];

             function gtag() {
                  dataLayer.push(arguments);
             }
             gtag('js', new Date());

             gtag('config', 'G-52YZ3XGZJ6');
        </script>
        <script>
             // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
             if (window.top != window.self) {
                  window.top.location.replace(window.self.location.href);
             }
        </script>
        </head>

        <body id="kt_body" class="auth-bg">
             <script>
                  var defaultThemeMode = "light";
                  var themeMode;

                  if (document.documentElement) {
                       if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                            themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
                       } else {
                            if (localStorage.getItem("data-bs-theme") !== null) {
                                 themeMode = localStorage.getItem("data-bs-theme");
                            } else {
                                 themeMode = defaultThemeMode;
                            }
                       }

                       if (themeMode === "system") {
                            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
                       }

                       document.documentElement.setAttribute("data-bs-theme", themeMode);
                  }
             </script>

             <div class="d-flex flex-column flex-root">
                  <div class="d-flex flex-column flex-column-fluid">
                       <div class="d-flex flex-column flex-column-fluid text-center p-10 py-lg-10">
                            <a href="/seven-html-pro/index.html" class="pt-lg-20">
                                 <img alt="Logo" src="<?= base_url() ?>assets/media/logos/logo-default.svg" class="h-75px mb-5">
                            </a>

                            <div class="pt-lg-10 mb-10">

                                 <h1 class="fw-bold fs-4x text-gray-900 mb-10">OOPS....!</h1>

                                 <p class="fw-bold fs-2 mb-5">Maaf, akses anda kami blok karena anda tidak memiliki akses untuk mengunjungi halaman ini. </p>
                                 <p class="fw-bold fs-2 mb-10">Silahkan kembail untuk melajutkan aktifitas anda.</p>

                                 <div class="text-center">
                                      <a href="javascript:history.back()" class="btn btn-lg btn-primary fw-bold">Kembali</a>
                                 </div>

                            </div>

                            <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px" style="background-image: url(<?= base_url() ?>assets/media/illustrations/sigma-1/20.png">
                            </div>
                       </div>

                       <div class="d-flex flex-center flex-column-auto p-10">
                            <div class="d-flex align-items-center fw-semibold fs-6">
                                 <a href="https://keenthemes.com" class="text-muted text-hover-primary px-2">About</a>

                                 <a href="https://devs.keenthemes.com" class="text-muted text-hover-primary px-2">Support</a>

                                 <a href="https://keenthemes.com/products/seven-html-pro" class="text-muted text-hover-primary px-2">
                                      Purchase
                                 </a>
                            </div>
                       </div>
                  </div>
             </div>


             <script>
                  var hostUrl = "<?= base_url() ?>assets/";
             </script>

             <script src="<?= base_url() ?>assets/plugins/global/plugins.bundle.js"></script>
             <script src="<?= base_url() ?>assets/js/scripts.bundle.js"></script>