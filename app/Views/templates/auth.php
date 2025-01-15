<!DOCTYPE html>
<html lang="en">

<head>
    <title>Live Learn - Login</title>
    <meta charset="utf-8" />
    <meta name="description"
        content="Seven admin dashboard live demo. Check out all the features of the admin panel. Light & dark skins. A large number of settings, additional services and widgets." />
    <meta name="keywords"
        content="Seven, bootstrap, bootstrap 5, dmin themes, free admin themes, bootstrap admin, bootstrap dashboard" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title"
        content="Seven HTML Pro - Bootstrap 5 HTML Multipurpose Light/Dark Admin Dashboard Theme - Seven HTML Free by KeenThemes" />
    <meta property="og:url" content="https://keenthemes.com/products/seven-html-pro" />
    <meta property="og:site_name" content="Seven HTML Free by Keenthemes" />
    <link rel="canonical" href="https://preview.keenthemes.com/seven-html-pro" />
    <link rel="shortcut icon" href="<?= base_url() ?>assets/media/logos/favicon.ico" />

    <link href="<?= base_url() ?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

    <!-- <script src="<?= base_url() ?>assets/js/jquery.3.2.1.min.js"></script> -->
    <script src="<?= base_url() ?>assets/plugins/global/plugins.bundle.js"></script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-37564768-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-37564768-1');
    </script>
    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
    <style>
        .swal2-toast {
            background-color: rgba(54,70,93,.99) !important;
        }
        .swal2-title {
            color: #fff !important;
        }
        .swal2-timer-progress-bar {
            background-color: lightblue !important;
        }
    </style>
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

    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5FS8GGP" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>

    <div class="d-flex flex-column flex-root">
        <style>
            .auth-page-bg {
                background-image: url('<?= base_url() ?>assets/media/illustrations/sigma-1/14.png');
            }

            [data-bs-theme="dark"] .auth-page-bg {
                background-image: url('<?= base_url() ?>assets/media/illustrations/sigma-1/14-dark.png');
            }
        </style>

        <div
            class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed auth-page-bg">
            <?php $this->renderSection('content'); ?>
            <div class="d-flex flex-center flex-column-auto p-10">
                <div class="d-flex align-items-center fw-semibold fs-6">
                    <a href="#" class="text-muted text-hover-primary px-2">About</a>
                    <a href="#" class="text-muted text-hover-primary px-2">Support</a>
                    <a href="#" class="text-muted text-hover-primary px-2">
                        Upgrade To Pro
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 
    <script>var hostUrl = "<?= base_url() ?>assets/";</script>
    <script src="<?= base_url() ?>assets/plugins/global/plugins.bundle.js"></script>
    <script src="<?= base_url() ?>assets/js/scripts.bundle.js"></script>
    <script src="<?= base_url() ?>assets/js/custom/authentication/sign-in/general.js"></script> -->
</body>


<script type="text/javascript">
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

    function show_toast() {
        Toast.fire({
            icon: "success",
            title: "Signed in successfully"
        });
    }

    function show_loading() {
        const loadingEl = document.createElement("div");
        document.body.prepend(loadingEl);
        loadingEl.classList.add("page-loader");
        loadingEl.classList.add("flex-column");
        loadingEl.classList.add("bg-dark");
        loadingEl.classList.add("bg-opacity-25");
        loadingEl.innerHTML = `
            <span class="spinner-border text-primary" role="status"></span>
            <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
        `;

        // Show page loading
        KTApp.showPageLoading();
    }

    function hide_loading() {
        KTApp.hidePageLoading();
        $('.page-loader').remove();
    }

    function toast_act(heading, text, icon, hide) {
        Toast.fire({
            icon: icon,
            title: text
        });
        // $.toast({
        //     heading: heading,
        //     text: text,
        //     showHideTransition: 'fade',
        //     position: 'top-right',
        //     icon: icon,
        //     hideAfter: hide
        // })
    }

    $(document.body).on('click', '.show_password', function() {
        if ($(this).hasClass('bi-eye-slash-fill')) {
            $(this).removeClass('bi-eye-slash-fill')
            $(this).addClass('bi-eye-fill')
            $('#pass_').attr('type', 'text')
        } else {
            $('#pass_').attr('type', 'password')
            $(this).addClass('bi-eye-slash-fill')
            $(this).removeClass('bi-eye-fill')
        }
    })
</script>
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

</html>