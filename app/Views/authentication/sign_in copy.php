
<?php $this->extend('templates/auth') ?>
<?php $this->section('content'); ?>

<div class="d-flex flex-column flex-lg-row-fluid py-10">
    <div class="d-flex flex-center flex-column flex-column-fluid">
        <div class="w-lg-500px p-10 p-lg-15 mx-auto">

            <form class="form w-100" novalidate="novalidate" method="post" action="<?= base_url('/login') ?>">
            <?= csrf_field(); ?>

                <div class="text-center mb-10">
                    <h1 class="text-dark mb-3">Login ke SchoolMS</h1>
                    <div class="text-gray-400 fw-semibold fs-4">Belum punya akun?
                        <a href="<?= base_url('/sign-up') ?>" class="link-primary fw-bold">Registrasi</a>
                    </div>
                </div>

                <div class="fv-row mb-10">
                    <label class="form-label fs-6 fw-bold text-dark">Username</label>
                    <input class="form-control form-control-lg form-control-solid" type="text" name="username" value="<?= session()->getFlashdata('user') ? session()->getFlashdata('user') : old('username') ?>"
                        autocomplete="off" />
                    <?php if (session('valid') && array_key_exists("username", session('valid'))): ?>
                        <small class="text-danger">
                            <?= session('valid')['username'] ?>
                        </small>
                    <?php endif; ?>
                </div>

                <div class="mb-10 fv-row" data-kt-password-meter="true">
                    <div class="mb-1">
                    <div class="d-flex flex-stack mb-2">
                        <label class="form-label fw-bold text-dark fs-6 mb-0">Password</label>
                        <a href="<?= base_url('/forgot-password') ?>"
                            class="link-primary fs-6 fw-bold">Lupa Password ?</a>
                    </div>
                        <div class="position-relative mb-3">
                            <input class="form-control form-control-lg form-control-solid" type="password"
                                name="password" autocomplete="off" />

                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                data-kt-password-meter-control="visibility">
                                <i class="ki-duotone ki-eye-slash fs-1"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                <i class="ki-duotone ki-eye d-none fs-1"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span></i>
                            </span>
                        </div>

                    </div>
                    <?php if (session('valid') && array_key_exists("password", session('valid'))): ?>
                        <small class="text-danger">
                            <?= session('valid')['password'] ?>
                        </small>
                    <?php endif; ?>
                </div>

                <div class="text-center">
                    <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                        <span class="indicator-label">Masuk</span>
                        <span class="indicator-progress">mohon tunggu...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>

                </div>
            </form>
        </div>
    </div>

    <div class="d-flex flex-center flex-wrap fs-6 p-5 pb-0">

        <div class="d-flex flex-center fw-semibold fs-6">
            <a href="#" class="text-muted text-hover-primary px-2" target="_blank">About</a>
            <a href="#" class="text-muted text-hover-primary px-2" target="_blank">Support</a>
            <a href="#" class="text-muted text-hover-primary px-2" target="_blank">Purchase</a>
        </div>

    </div>

</div>

<?php $this->endSection(); ?>