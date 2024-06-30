<?php $this->extend('templates/auth') ?>
<?php $this->section('content'); ?>

<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
    <a href="<?= base_url('/') ?>" class="mb-12">
        <img alt="Logo" src="<?= base_url() ?>assets/media/logos/logo-default.svg" class="h-60px" />
    </a>

    <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">

        <form class="form w-100" novalidate="novalidate" method="post" action="<?= base_url('/login') ?>">
            <?= csrf_field(); ?>
            <div class="text-center mb-10">
                <h1 class="text-dark mb-3">
                    Selamat Datang di Kelas Online </h1>

                <div class="text-gray-400 fw-semibold fs-4">
                    Login untuk masuk ke sistem
                </div>
            </div>

            <div class="fv-row mb-10">
                <label class="form-label fs-6 fw-bold text-dark">Username</label>

                <input class="form-control form-control-lg form-control-solid" type="text" name="username"
                    autocomplete="off" />
            </div>

            <div class="fv-row mb-10">
                <div class="d-flex flex-stack mb-2">
                    <label class="form-label fw-bold text-dark fs-6 mb-0">Password</label>

                    <a href="<?= base_url('/forgot-password') ?>" class="link-primary fs-6 fw-bold">
                        Lupa Password ?
                    </a>
                </div>

                <input class="form-control form-control-lg form-control-solid" type="password" name="password"
                    autocomplete="off" />
            </div>

            <div class="text-center">
                <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                    <span class="indicator-label">
                        Login
                    </span>

                    <span class="indicator-progress">
                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>

            </div>
        </form>
    </div>
</div>


<?php $this->endSection(); ?>