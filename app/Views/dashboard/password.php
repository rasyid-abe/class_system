<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="card mb-5 mb-xl-10">
    <div class="card-body pt-9 pb-0">
        <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
            <div class="me-7 mb-4">
                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                    <img src="<?= !empty($row['school_logo']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/images/school/' . $row['school_logo']) ? base_url() . 'images/school/' . $row['school_logo'] : base_url('blaze-assets/media/avatars/blank.png') ?>" alt="Logo Sekolah">
                    <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                </div>
            </div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center mb-2">
                            <p class="text-gray-900 text-hover-primary fs-2 fw-bold me-1"><?= $row['school_name'] ?></p>
                        </div>
                        <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                            <p class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                            <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i><?= $row['school_alias'] ?></p>
                            <p class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                            <i class="ki-duotone ki-geolocation fs-4 me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i><?php $join_date = new DateTime($row['school_created_at']); echo 'Terdaftar: ' . $join_date->format('d-m-Y'); ?></p>
                            <p class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                            <i class="ki-duotone ki-sms fs-4 me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i><?= $row['user_email'] ?></p>
                        </div>
                    </div>
                    <div class="d-flex my-4">
                        <a href="#" class="btn btn-sm btn-light me-2" id="kt_user_follow_button">
                            <i class="ki-duotone ki-check fs-2 d-none"></i>
                            <span class="indicator-label">Follow</span>
                            <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </a>
                        <a href="#" class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#kt_modal_offer_a_deal">Hire Me</a>                                    
                    </div>
                </div>
                <div class="d-flex flex-wrap flex-stack">
                    <div class="d-flex flex-column flex-grow-1 pe-8">
                        <div class="d-flex flex-wrap">
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="ki-duotone ki-arrow-up fs-2 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="45" data-kt-countup-prefix="">0</div>
                                </div>
                                <div class="fw-semibold fs-6 text-gray-400">Jumlah Murid</div>
                            </div>
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="ki-duotone ki-arrow-down fs-2 text-danger me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="75">0</div>
                                </div>
                                <div class="fw-semibold fs-6 text-gray-400">Jumlah Guru</div>
                            </div>
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="ki-duotone ki-arrow-up fs-2 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="120" data-kt-countup-prefix="">0</div>
                                </div>
                                <div class="fw-semibold fs-6 text-gray-400">Jumlah Pegawai</div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                        <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                            <span class="fw-semibold fs-6 text-gray-400">Profile Compleation</span>
                            <span class="fw-bold fs-6">50%</span>
                        </div>
                        <div class="h-5px mx-3 w-100 bg-light mb-3">
                            <div class="bg-success rounded h-5px" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
            <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5" href="<?= base_url('dashboard/school/show/' . userdata()['id_profile']) ?>">Overview</a>
            </li>
            <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="<?= base_url('dashboard/school/change-password') ?>">Ganti Password</a>
            </li>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0"><?= end($breadcrumb) ?></h3>
                </div>
            </div>    
            <div class="card-body p-9">
                <form action="<?= base_url(userdata()['update_password']) ?>" method="POST" id="form-password">
                    <?= csrf_field(); ?>
                    <div class="row mb-6">
                        <div class="col-lg-6">
                            <div class="mb-10 fv-row" data-kt-password-meter="false">
                                <?php 
                                    $fe = $le = $msg = '';
                                    if (session('valid') && array_key_exists("old_password", session('valid'))) {
                                        $le = 'text-danger';
                                        $msg = '<small class="text-danger">'.session('valid')['old_password'].'</small>';
                                    }
                                ?>
                                <div class="mb-1">
                                    <label class="form-label fw-semibold fs-6 mb-2 required <?= $le ?>">
                                        Password Lama
                                    </label>

                                    <div class="position-relative mb-3">
                                        <input class="form-control form-control-md form-control-solid" type="password"
                                            name="old_password" autocomplete="off" />

                                        <span
                                            class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                            data-kt-password-meter-control="visibility">
                                            <i class="ki-duotone ki-eye-slash fs-1"><span class="path1"></span><span
                                                    class="path2"></span><span class="path3"></span><span
                                                    class="path4"></span></i>
                                            <i class="ki-duotone ki-eye d-none fs-1"><span class="path1"></span><span
                                                    class="path2"></span><span class="path3"></span></i>
                                        </span>
                                    </div>
                                </div>
                                <?= $msg ?>
                            </div>

                            <div class="mb-10 fv-row" data-kt-password-meter="true">
                                <?php 
                                    $fe = $le = $msg = '';
                                    if (session('valid') && array_key_exists("new_password", session('valid'))) {
                                        $le = 'text-danger';
                                        $msg = '<small class="text-danger">'.session('valid')['new_password'].'</small>';
                                    }
                                ?>
                                <div class="mb-1">
                                    <label class="form-label fw-semibold fs-6 mb-2 required <?= $le ?>">
                                        Password Baru
                                    </label>

                                    <div class="position-relative mb-3">
                                        <input class="form-control form-control-md form-control-solid" type="password" name="new_password" id="new_password" autocomplete="off" />
                                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
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
                                        $msg = '<small class="text-danger">'.session('valid')['repeat_password'].'</small>';
                                    }
                                ?>
                                <label class="form-label fw-semibold fs-6 mb-2 required <?= $le ?>">Konfirmasi Password</label>
                                <input class="form-control form-control-md form-control-solid" type="password" placeholder="" name="repeat_password" id="repeat_password" autocomplete="off" />
                                <?= $msg ?>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <button type="reset" class="btn btn-light btn-active-light-primary me-2">Reset</button>
                                <button type="submit" class="btn btn-md btn-round btn-primary" id="submit-form">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type='text/javascript'>
    $(document).ready(function () {            
        const submitButton = document.querySelector('#submit-form');
        const newPasswordInput = document.querySelector("#new_password");
        const repeatPasswordInput = document.querySelector("#repeat_password");
        const regexPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/;

        submitButton.addEventListener('click', function(event) {
            event.preventDefault();
            const newPassword = newPasswordInput.value;
            const repeatPassword = repeatPasswordInput.value;
            Swal.fire({
                text: "Apakah Anda yakin ingin simpan ganti password?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Simpan Perubahan!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
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
                }
            });
        });
    });
</script>

<?php $this->endSection(); ?>