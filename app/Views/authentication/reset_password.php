<?php $this->extend('templates/auth') ?>
<?php $this->section('content'); ?>

<div class="d-flex flex-column flex-lg-row-fluid">
    <div class="d-flex flex-center flex-column flex-column-fluid">
            <form action="<?= base_url('/submit-reset-password') ?>" method="POST" id="form-password">
                <?= csrf_field(); ?>
                <input type="hidden" name="email" value="<?= $email ?>">
                <div class="text-center mb-10">
                    <h1 class="text-dark mb-3">Reset Password</h1>
                    <div class="text-gray-400 fw-semibold fs-4">Kembali ke halaman 
                        <a href="<?= base_url('/sign-in') ?>" class="link-primary fw-bold">Login</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-10 fv-row" data-kt-password-meter="true">
                            <?php
                            $fe = $le = $msg = '';
                            if (session('valid') && array_key_exists("new_password", session('valid'))) {
                                $le = 'text-danger';
                                $msg = '<small class="text-danger">' . session('valid')['new_password'] . '</small>';
                            }
                            ?>
                            <div class="mb-1">
                                <label class="form-label fw-semibold fs-6 mb-2 required <?= $le ?>">
                                    Password Baru
                                </label>

                                <div class="position-relative mb-3">
                                    <input class="form-control form-control-md form-control-solid" type="password"
                                        name="new_password" id="new_password" autocomplete="off" />
                                    <span
                                        class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                        data-kt-password-meter-control="visibility">
                                        <i class="ki-duotone ki-eye-slash fs-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                        </i>
                                        <i class="ki-duotone ki-eye d-none fs-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </div>

                                <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                </div>
                            </div>
                            <div class="text-muted">Min 8 karakter dengan campuran huruf, angka atau simbol</div>
                            <?= $msg ?>
                        </div>

                        <div class="fv-row mb-10">
                            <?php
                            $fe = $le = $msg = '';
                            if (session('valid') && array_key_exists("repeat_password", session('valid'))) {
                                $le = 'text-danger';
                                $msg = '<small class="text-danger">' . session('valid')['repeat_password'] . '</small>';
                            }
                            ?>
                            <label class="form-label fw-semibold fs-6 mb-2 required <?= $le ?>">Konfirmasi
                                Password</label>
                            <input class="form-control form-control-md form-control-solid" type="password"
                                placeholder="" name="repeat_password" id="repeat_password" autocomplete="off" />
                            <?= $msg ?>
                        </div>
                    </div>
                    <div class="text-center">
                    <button type="submit" class="btn btn-lg btn-primary w-100 mb-5" id="submit-form">
                        <span class="indicator-label">Ubah Password</span>
                        <span class="indicator-progress">mohon tunggu...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>

                </div>
                </div>
            </form>
    </div>
    <div class="d-flex flex-center flex-wrap fs-6 p-5 pb-0">
        <div class="d-flex flex-center fw-semibold fs-6">
            <a href="#" class="text-muted text-hover-primary px-2" target="_blank">About</a>
            <a href="#" class="text-muted text-hover-primary px-2" target="_blank">Support</a>
            <a href="#" class="text-muted text-hover-primary px-2" target="_blank">Purchase</a>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {            
        const submitButton = document.querySelector('#submit-form');
        const newPasswordInput = document.querySelector("#new_password");
        const repeatPasswordInput = document.querySelector("#repeat_password");
        const regexPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/;

        submitButton.addEventListener('click', function(event) {
            event.preventDefault();
            const newPassword = newPasswordInput.value;
            const repeatPassword = repeatPasswordInput.value;
            if (!regexPassword.test(newPassword)) {
                Swal.fire({
                    text: "Password harus memiliki minimal 8 karakter dengan campuran huruf, angka, atau simbol!",
                    icon: "error",
                    confirmButtonColor: "#d33",
                    confirmButtonText: "OK",
                }).then((result) => {});
            } else if (newPassword !== repeatPassword) {
                Swal.fire({
                    text: "Password konfirmasi tidak sama dengan Password baru!",
                    icon: "error",
                    confirmButtonColor: "#d33",
                    confirmButtonText: "OK",
                }).then((result) => {});
            } else {
                document.querySelector('#form-password').submit();
            }
        });
    });
</script>

<?php $this->endSection(); ?>