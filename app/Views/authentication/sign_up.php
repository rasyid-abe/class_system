<?php $this->extend('templates/auth') ?>
<?php $this->section('content'); ?>

<div class="d-flex flex-column flex-lg-row-fluid py-10">
    <div class="d-flex flex-center flex-column flex-column-fluid">
        <div class="w-lg-600px p-10 p-lg-15 mx-auto">
        <form class="form w-100" novalidate="novalidate" method="post" action="<?= base_url('/register') ?>">
            <?= csrf_field(); ?>
                <div class="mb-10 text-center">
                    <h1 class="text-dark mb-3">Registrasi</h1>
                    <div class="text-gray-400 fw-semibold fs-4">Sudah punya akun?
                        <a href="<?= base_url('/sign-in') ?>" class="link-primary fw-bold">Login</a>
                    </div>
                </div>

                <div class="fv-row mb-7">
                    <label class="form-label fw-bold text-dark fs-6">Nama Sekolah</label>
                    <input class="form-control form-control-lg form-control-solid" type="text" placeholder=""
                        name="school_name" autocomplete="off" />
                    <?php if (session('valid') && array_key_exists("school_name", session('valid'))): ?>
                        <small class="text-danger">
                            <?= session('valid')['school_name'] ?>
                        </small>
                    <?php endif; ?>
                </div>
                <div class="row fv-row mb-7">
                    <div class="col-xl-6">
                        <label class="form-label fw-bold text-dark fs-6">Alias Sekolah</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" placeholder=""
                            name="school_alias" autocomplete="off" />
                        <?php if (session('valid') && array_key_exists("school_alias", session('valid'))): ?>
                            <small class="text-danger">
                                <?= session('valid')['school_alias'] ?>
                            </small>
                        <?php endif; ?>
                    </div>
                    <div class="col-xl-6">
                        <label class="form-label fw-bold text-dark fs-6">NPSN</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" placeholder=""
                            name="school_npsn" autocomplete="off" />
                        <?php if (session('valid') && array_key_exists("school_npsn", session('valid'))): ?>
                            <small class="text-danger">
                                <?= session('valid')['school_npsn'] ?>
                            </small>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="fv-row mb-7">
                    <label class="form-label fw-bold text-dark fs-6">Jenjang Sekolah</label>
                    <select class="form-select form-select-solid" name="school_level">
                        <option>Pilih Jenjang Sekolah</option>
                        <?php foreach ($level as $k => $v): ?>
                            <option value="<?= $k ?>" <?= $k == old('school_level') ? 'selected' : '' ?>>
                                <?= $v ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (session('valid') && array_key_exists("school_level", session('valid'))): ?>
                        <small class="text-danger">
                            <?= session('valid')['school_level'] ?>
                        </small>
                    <?php endif; ?>
                </div>
                <div class="fv-row mb-7">
                    <label class="form-label fw-bold text-dark fs-6">Email</label>
                    <input class="form-control form-control-lg form-control-solid" type="email" placeholder=""
                        name="school_email" autocomplete="off" />
                    <?php if (session('valid') && array_key_exists("school_email", session('valid'))): ?>
                        <small class="text-danger">
                            <?= session('valid')['school_email'] ?>
                        </small>
                    <?php endif; ?>
                </div>
                <div class="row fv-row mb-7">
                    <div class="col-xl-6">
                        <label class="form-label fw-bold text-dark fs-6">No. Telepon</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" placeholder=""
                            name="school_phone" autocomplete="off" />
                        <?php if (session('valid') && array_key_exists("school_phone", session('valid'))): ?>
                            <small class="text-danger">
                                <?= session('valid')['school_phone'] ?>
                            </small>
                        <?php endif; ?>
                    </div>
                    <div class="col-xl-6">
                        <label class="form-label fw-bold text-dark fs-6">WA Admin Sekolah</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" placeholder=""
                            name="school_wa" autocomplete="off" />
                        <?php if (session('valid') && array_key_exists("school_wa", session('valid'))): ?>
                            <small class="text-danger">
                                <?= session('valid')['school_wa'] ?>
                            </small>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="mb-10 fv-row" data-kt-password-meter="true">
                    <div class="mb-1">
                        <label class="form-label fw-semibold fs-6 mb-2">
                            Password
                        </label>

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

                        <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                        </div>
                    </div>
                    <div class="text-muted">Min 8 karakter dengan campuran huruf, angka dan simbol</div>
                    <?php if (session('valid') && array_key_exists("password", session('valid'))): ?>
                        <small class="text-danger">
                            <?= session('valid')['password'] ?>
                        </small>
                    <?php endif; ?>
                </div>

                <div class="fv-row mb-10">
                    <label class="form-label fw-semibold fs-6 mb-2">Konfirmasi Password</label>

                    <input class="form-control form-control-lg form-control-solid" type="password" placeholder=""
                        name="confirm_password" autocomplete="off" />
                    <?php if (session('valid') && array_key_exists("confirm_password", session('valid'))): ?>
                        <small class="text-danger">
                            <?= session('valid')['confirm_password'] ?>
                        </small>
                    <?php endif; ?>
                </div>

                <div class="text-center">
                    <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                        <span class="indicator-label">Submit</span>
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
<!-- <style>
    <style>

    /* Popup container - can be anything you want */
    .popup {
        position: relative;
        display: inline-block;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* The actual popup */
    .popup .popuptext {
        visibility: hidden;
        width: 160px;
        background-color: #555;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 8px 0;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        left: 50%;
        margin-left: -80px;
    }

    /* Popup arrow */
    .popup .popuptext::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #555 transparent transparent transparent;
    }

    /* Toggle this class - hide and show the popup */
    .popup .show {
        visibility: visible;
        -webkit-animation: fadeIn 1s;
        animation: fadeIn 1s;
    }

    /* Add animation (fade in the popup) */
    @-webkit-keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }
</style>
</style>

<div class="card-body p-3 p-md-4 p-xl-5">
    <div class="row">
        <div class="col-12">
            <div class="mb-4">
                <h3>Registrasi</h3>
                <p>Sudah punya akun? <a href="<?= base_url('/sign-in') ?>">Login</a> </p>

            </div>
        </div>
    </div>
    <form method="post" action="<?= base_url('/register') ?>">
        <?= csrf_field(); ?>
        <div class="row gy-3 overflow-hidden">
            <div class="col-12">
                <div class="form-floating">
                    <input type="text"
                        class="form-control form-control-md <?= session('validation') && session('validation')->getError('school_name') ? 'is-invalid' : '' ?>"
                        name="school_name" id="school_name" value="<?= old('school_name') ?>">
                    <label for="school_name" class="form-label">Nama Sekolah</label>
                    <?php if (session('validation') && session('validation')->getError('school_name')): ?>
                        <small class="text-danger">
                            <?= session('validation')->getError('school_name') ?>
                        </small>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="number"
                        class="form-control form-control-md <?= session('validation') && session('validation')->getError('school_npsn') ? 'is-invalid' : '' ?>"
                        name="school_npsn" id="school_npsn" value="<?= old('school_npsn') ?>">
                    <label for="school_npsn" class="form-label">NPSN (Nomor Pokok Sekolah Nasional)</label>
                    <?php if (session('validation') && session('validation')->getError('school_npsn')): ?>
                        <small class="text-danger">
                            <?= session('validation')->getError('school_npsn') ?>
                        </small>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text"
                        class="form-control form-control-md <?= session('validation') && session('validation')->getError('school_alias') ? 'is-invalid' : '' ?>"
                        name="school_alias" id="school_alias" value="<?= old('school_alias') ?>">
                    <label for="school_alias" class="form-label">Alias Sekolah <span id="alias_info"></span></label>
                    <?php if (session('validation') && session('validation')->getError('school_alias')): ?>
                        <small class="text-danger">
                            <?= session('validation')->getError('school_alias') ?>
                        </small>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <select
                        class="form-select <?= session('validation') && session('validation')->getError('school_level') ? 'is-invalid' : '' ?>"
                        name="school_level" id="school_level">
                        <option value="">Pilih Jenjang Sekolah</option>
                        <?php foreach ($level as $k => $v): ?>
                            <option value="<?= $k ?>" <?= $k == old('school_level') ? 'selected' : '' ?>>
                                <?= $v ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label for="floatingSelect">Jenjang Sekolah</label>
                    <?php if (session('validation') && session('validation')->getError('school_level')): ?>
                        <small class="text-danger">
                            <?= session('validation')->getError('school_level') ?>
                        </small>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text"
                        class="form-control form-control-md <?= session('validation') && session('validation')->getError('school_email') ? 'is-invalid' : '' ?>"
                        name="school_email" id="school_email" value="<?= old('school_email') ?>">
                    <label for="school_email" class="form-label">Email Sekolah</label>
                    <?php if (session('validation') && session('validation')->getError('school_email')): ?>
                        <small class="text-danger">
                            <?= session('validation')->getError('school_email') ?>
                        </small>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-floating">
                            <input type="text"
                                class="form-control form-control-md <?= session('validation') && session('validation')->getError('school_phone') ? 'is-invalid' : '' ?>"
                                name="school_phone" id="school_phone" value="<?= old('school_phone') ?>">
                            <label for="school_phone" class="form-label">No. Telepon Sekolah</label>
                            <?php if (session('validation') && session('validation')->getError('school_phone')): ?>
                                <small class="text-danger">
                                    <?= session('validation')->getError('school_phone') ?>
                                </small>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-floating">
                            <input type="text"
                                class="form-control form-control-md <?= session('validation') && session('validation')->getError('school_wa') ? 'is-invalid' : '' ?>"
                                name="school_wa" id="school_wa" value="<?= old('school_wa') ?>">
                            <label for="school_wa" class="form-label">Whatsapp Admin Sekolah</label>
                            <?php if (session('validation') && session('validation')->getError('school_wa')): ?>
                                <small class="text-danger">
                                    <?= session('validation')->getError('school_wa') ?>
                                </small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-floating">
                            <input type="password"
                                class="form-control <?= session('validation') && session('validation')->getError('password') ? 'is-invalid' : '' ?>"
                                name="password" id="password" value="" placeholder="Password">
                            <label for="password" class="form-label">Password</label>
                            <?php if (session('validation') && session('validation')->getError('password')): ?>
                                <small class="text-danger">
                                    <?= session('validation')->getError('password') ?>
                                </small>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-floating">
                            <input type="password"
                                class="form-control <?= session('validation') && session('validation')->getError('confirm_password') ? 'is-invalid' : '' ?>"
                                name="confirm_password" id="confirm_password" value="" placeholder="Ulangi Password">
                            <label for="confirm_password" class="form-label">Ulangi Password</label>
                            <?php if (session('validation') && session('validation')->getError('confirm_password')): ?>
                                <small class="text-danger">
                                    <?= session('validation')->getError('confirm_password') ?>
                                </small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="d-grid">
                    <button class="btn btn-primary btn-lg" type="submit">Daftar</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $('#school_alias').on('focus', function () {
        $('#alias_info').html('<small class="text-info">(Huruf kecil tanpa spasi. Cth: "sman1binjai")</small>')
    })
    $('#school_alias').on('blur', function () {
        $('#alias_info').html('')
    })
</script> -->
<?php $this->endSection(); ?>