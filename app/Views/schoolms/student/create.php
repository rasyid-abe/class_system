<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="row mb-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center mx-2">
                    <h4 class="card-title">
                        Tambah Data Siswa
                    </h4>
                </div>
            </div>
            <?php
            $stepper = "first";
            $label1 = 'current';
            $label2 = $label3 = $label4 = $label5 = $label6 = 'pending';
            $step1 = 'current';
            $step2 = $step3 = $step4 = $step5 = $step6 = "";
            if (
                (session('valid') && array_key_exists("foto", session('valid'))) ||
                (session('valid') && array_key_exists("first_name", session('valid'))) ||
                (session('valid') && array_key_exists("last_name", session('valid'))) ||
                (session('valid') && array_key_exists("gender", session('valid'))) ||
                (session('valid') && array_key_exists("order_child", session('valid'))) ||
                (session('valid') && array_key_exists("religion", session('valid'))) ||
                (session('valid') && array_key_exists("birth_place", session('valid'))) ||
                (session('valid') && array_key_exists("birth_date", session('valid'))) 
            ) {
                $stepper = "first";
                $label1 = 'current';
                $label2 = $label3 = $label4 = $label5 = $label6 = 'pending';
                $step1 = 'current';
                $step2 = $step3 = $step4 = $step5 = $step6 = "";
            }
            elseif (
                (session('valid') && array_key_exists("phone", session('valid'))) ||
                (session('valid') && array_key_exists("email", session('valid'))) 
            ) {
                $stepper = "between";
                $label1 = 'completed';
                $label2 = 'current';
                $label3 = $label4 = $label5 = $label6 = 'pending';
                $step2 = 'current';
                $step1 = $step3 = $step4 = $step5 = $step6 = "";
            }
            elseif (
                (session('valid') && array_key_exists("province", session('valid'))) ||
                (session('valid') && array_key_exists("regency", session('valid'))) ||
                (session('valid') && array_key_exists("subdistrict", session('valid'))) ||
                (session('valid') && array_key_exists("postal_code", session('valid'))) ||
                (session('valid') && array_key_exists("address", session('valid'))) 
            ) {
                $stepper = "between";
                $label1 = $label2 = 'completed';
                $label3 = 'current';
                $label4 = $label5 = $label6 = 'pending';
                $step3 = 'current';
                $step1 = $step2 = $step4 = $step5 = $step6 = "";
            } 
            elseif (
                (session('valid') && array_key_exists("father_name", session('valid'))) ||
                (session('valid') && array_key_exists("father_occupation", session('valid'))) ||
                (session('valid') && array_key_exists("mother_name", session('valid'))) ||
                (session('valid') && array_key_exists("mother_occupation", session('valid'))) ||
                (session('valid') && array_key_exists("parent_address", session('valid'))) ||
                (session('valid') && array_key_exists("parent_postal_code", session('valid'))) ||
                (session('valid') && array_key_exists("parent_phone", session('valid'))) 
            ) {
                $stepper = "between";
                $label1 = $label2 = $label3 = 'completed';
                $label4 = 'current';
                $label5 = $label6 = 'pending';
                $step4 = 'current';
                $step1 = $step2 = $step3 = $step5 = $step6 = "";
            } 
            elseif (
                (session('valid') && array_key_exists("guardian_name", session('valid'))) ||
                (session('valid') && array_key_exists("guardian_occupation", session('valid'))) ||
                (session('valid') && array_key_exists("guardian_address", session('valid'))) ||
                (session('valid') && array_key_exists("guardian_postal_code", session('valid'))) ||
                (session('valid') && array_key_exists("guardian_phone", session('valid'))) 
            ) {
                $stepper = "between";
                $label1 = $label2 = $label3 = $label4 = 'completed';
                $label5 = 'current';
                $label6 = 'pending';
                $step5 = 'current';
                $step1 = $step2 = $step3 = $step4 = $step6 = "";
            } 
            elseif (
                (session('valid') && array_key_exists("nisn", session('valid'))) ||
                (session('valid') && array_key_exists("registered_date", session('valid'))) ||
                (session('valid') && array_key_exists("transfer", session('valid'))) ||
                (session('valid') && array_key_exists("previous_school", session('valid'))) ||
                (session('valid') && array_key_exists("registered_information", session('valid'))) ||
                (session('valid') && array_key_exists("student_group", session('valid'))) 
            ) {
                $stepper = "last";
                $label1 = $label2 = $label3 = $label4 = $label5 = 'completed';
                $label6 = 'current';
                $step6 = 'current';
                $step1 = $step2 = $step3 = $step4 = $step5 = "";
            }
            ?>
            <div class="card-body" id="student_form">
                <div class="row">
                    <div class="col-sm-12">
                        
                        <div class="stepper stepper-pills stepper-column d-flex flex-column flex-lg-row <?= $stepper ?>"
                            id="kt_stepper_example_vertical">

                            <div class="d-flex flex-row-auto w-100 w-lg-300px">
                                <div class="stepper-nav">

                                    <div class="stepper-item me-5 <?= $label1 ?>" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                        <div class="stepper-wrapper d-flex align-items-center">
                                            <div class="stepper-icon w-40px h-40px">
                                                <i class="stepper-check fas fa-check"></i>
                                                <span class="stepper-number">1</span>
                                            </div>

                                            <div class="stepper-label">
                                                <div class="stepper-desc">
                                                    Step 1
                                                </div>
                                                <h3 class="stepper-title">
                                                    Biodata
                                                </h3>
                                            </div>
                                        </div>

                                        <div class="stepper-line h-40px"></div>
                                    </div>

                                    <div class="stepper-item me-5 <?= $label2 ?>" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                        <div class="stepper-wrapper d-flex align-items-center">
                                            <div class="stepper-icon w-40px h-40px">
                                                <i class="stepper-check fas fa-check"></i>
                                                <span class="stepper-number">2</span>
                                            </div>

                                            <div class="stepper-label">
                                                <div class="stepper-desc">
                                                    Step 2
                                                </div>
                                                <h3 class="stepper-title">
                                                    Kontak
                                                </h3>
                                            </div>
                                        </div>

                                        <div class="stepper-line h-40px"></div>
                                    </div>

                                    <div class="stepper-item me-5 <?= $label3 ?>" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                        <div class="stepper-wrapper d-flex align-items-center">
                                            <div class="stepper-icon w-40px h-40px">
                                                <i class="stepper-check fas fa-check"></i>
                                                <span class="stepper-number">3</span>
                                            </div>

                                            <div class="stepper-label">
                                                <div class="stepper-desc">
                                                    Step 3
                                                </div>
                                                <h3 class="stepper-title">
                                                    Alamat
                                                </h3>
                                            </div>
                                        </div>

                                        <div class="stepper-line h-40px"></div>
                                    </div>
                                    
                                    <div class="stepper-item me-5 <?= $label4 ?>" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                        <div class="stepper-wrapper d-flex align-items-center">
                                            <div class="stepper-icon w-40px h-40px">
                                                <i class="stepper-check fas fa-check"></i>
                                                <span class="stepper-number">4</span>
                                            </div>

                                            <div class="stepper-label">
                                                <div class="stepper-desc">
                                                    Step 4
                                                </div>
                                                <h3 class="stepper-title">
                                                    Orang Tua
                                                </h3>
                                            </div>
                                        </div>

                                        <div class="stepper-line h-40px"></div>
                                    </div>
                                    
                                    <div class="stepper-item me-5 <?= $label5 ?>" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                        <div class="stepper-wrapper d-flex align-items-center">
                                            <div class="stepper-icon w-40px h-40px">
                                                <i class="stepper-check fas fa-check"></i>
                                                <span class="stepper-number">5</span>
                                            </div>

                                            <div class="stepper-label">
                                                <div class="stepper-desc">
                                                    Step 5
                                                </div>
                                                <h3 class="stepper-title">
                                                    Wali
                                                </h3>
                                            </div>
                                        </div>

                                        <div class="stepper-line h-40px"></div>
                                    </div>

                                    <div class="stepper-item me-5 <?= $label6 ?>" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                        <div class="stepper-wrapper d-flex align-items-center">
                                            <div class="stepper-icon w-40px h-40px">
                                                <i class="stepper-check fas fa-check"></i>
                                                <span class="stepper-number">6</span>
                                            </div>
                                            <div class="stepper-label">
                                                <div class="stepper-desc">
                                                    Step 6
                                                </div>
                                                <h3 class="stepper-title">
                                                    Informasi Pendaftaran
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-row-fluid">
                                <form class="form w-lg-600px mx-auto" novalidate="novalidate" action="<?= base_url('/sms/user/student/store') ?>" method="POST" enctype="multipart/form-data">
                                    <?= csrf_field(); ?>
                                    <div class="mb-5" style="min-height: 400px">
                                        <div class="flex-column <?= $step1 ?>" data-kt-stepper-element="content">
                                            <div class="row mb-5">
                                                <div class="col-md-6 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("foto", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['foto'].'</small>';
                                                        }
                                                    ?>
                                                    <label class="d-block fw-semibold fs-6 mb-5 <?= $le ?> ">Foto</label>
                                                    <style>
                                                        .image-input-placeholder {
                                                            background-image: url('<?= base_url('/blaze-assets/media/svg/files/blank-image.svg') ?>');
                                                        }

                                                        [data-bs-theme="dark"] .image-input-placeholder {
                                                            background-image: url('<?= base_url('/blaze-assets/media/svg/files/blank-image-dark.svg') ?>');
                                                        }
                                                    </style>
                                                    <div class="image-input image-input-outline image-input-placeholder image-input-empty" data-kt-image-input="true">
                                                        <div class="image-input-wrapper w-125px h-125px" style="background-image: none;">
                                                        </div>
                                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change foto" data-bs-original-title="Change foto" data-kt-initialized="1">
                                                            <i class="ki-duotone ki-pencil fs-7">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                            <input type="file" name="foto" accept=".png, .jpg, .jpeg">
                                                            <input type="hidden" name="foto_remove" value="1">
                                                        </label>
                                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel foto" data-bs-original-title="Cancel foto" data-kt-initialized="1">
                                                            <i class="ki-duotone ki-cross fs-2">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        </span>
                                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="Remove foto" data-bs-original-title="Remove foto" data-kt-initialized="1">
                                                            <i class="ki-duotone ki-cross fs-2">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        </span>
                                                    </div>
                                                    <div class="form-text">Tipe file yang diizinkan: png, jpg, jpeg.</div>
                                                    <?= $msg ?>
                                                </div>
                                                <div class="col-md-6 fv-row">
                                                    <div class="mb-10">
                                                        <?php 
                                                            $fe = $le = $msg = '';
                                                            if (session('valid') && array_key_exists("first_name", session('valid'))) {
                                                                $fe = "is-invalid";
                                                                $le = 'text-danger';
                                                                $msg = '<small class="text-danger">'.session('valid')['first_name'].'</small>';
                                                            }
                                                        ?>
                                                        <label for="first_name" class="required form-label <?= $le ?>">Nama Depan</label>
                                                        <input type="text" class="form-control form-control-md <?= $fe ?>" name="first_name" id="first_name" value="<?= old('first_name') ?>" />
                                                        <?= $msg ?>
                                                    </div>
                                                    <div class="">
                                                        <?php 
                                                            $fe = $le = $msg = '';
                                                            if (session('valid') && array_key_exists("last_name", session('valid'))) {
                                                                $fe = "is-invalid";
                                                                $le = 'text-danger';
                                                                $msg = '<small class="text-danger">'.session('valid')['last_name'].'</small>';
                                                            }
                                                        ?>
                                                        <label for="last_name" class="required form-label <?= $le ?>">Nama Belakang</label>
                                                        <input type="text" class="form-control form-control-md <?= $fe ?>" name="last_name" id="last_name" value="<?= old('last_name') ?>" />
                                                        <?= $msg ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-5">
                                                <div class="col-md-4 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("birth_place", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['birth_place'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="birth_place" class="required form-label <?= $le ?>">Tempat Lahir</label>
                                                    <input type="text" class="form-control form-control-md <?= $fe ?>" name="birth_place" id="birth_place" value="<?= old('birth_place') ?>" />
                                                    <?= $msg ?>
                                                </div>
                                                <div class="col-md-4 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("birth_date", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['birth_date'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="birth_date" class="required form-label <?= $le ?>">Tanggal Lahir</label>
                                                    <input type="date" class="form-control form-control-md <?= $fe ?>" name="birth_date" id="birth_date" value="<?= old('birth_date') ?>" />
                                                    <?= $msg ?>
                                                </div>
                                                <div class="col-md-4 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("order_child", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['order_child'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="order_child" class="form-label <?= $le ?>">Anak Ke</label>
                                                    <input type="number" class="form-control form-control-md <?= $fe ?>" name="order_child" id="order_child" value="<?= old('order_child') ?>" />
                                                    <?= $msg ?>
                                                </div>
                                            </div>
                                            
                                            <div class="row mb-5">
                                                <div class="col-md-6 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("gender", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['gender'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="gender" class="mb-5 required form-label <?= $le ?>">Jenis Kelamin</label>
                                                    <br>
                                                    <div class="form-check form-check-custom form-check-solid me-10 form-check-inline">
                                                        <input class="form-check-input" type="radio" name="gender" value="1" id="opt1" <?= old("gender") == 1 ? 'checked' : '' ?> />
                                                        <label class="form-check-label text-dark" for="opt1">
                                                            Laki-laki
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid me-10 form-check-inline">
                                                        <input class="form-check-input" type="radio" name="gender" value="2" id="opt2" <?= old("gender") == 2 ? 'checked' : '' ?>/>
                                                        <label class="form-check-label text-dark" for="opt2">
                                                            Perempuan
                                                        </label>
                                                    </div>
                                                    <br>
                                                    <?= $msg ?>
                                                </div>
                                                <div class="col-md-6 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("religion", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['religion'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="religion" class="form-label required <?= $le ?>">Agama</label>
                                                    <select class="form-select form-control-md" id="religion" name="religion">
                                                        <option value="">Pilih Agama</option>
                                                        <?php foreach ($religion as $k => $v): ?>
                                                            <option value="<?= $k ?>" <?= old('religion') == $k ? 'selected' : '' ?>>
                                                                <?= $v ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <?= $msg ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex-column <?= $step2 ?>" data-kt-stepper-element="content">
                                            <div class="mb-5">
                                                <?php 
                                                    $fe = $le = $msg = '';
                                                    if (session('valid') && array_key_exists("phone", session('valid'))) {
                                                        $fe = "is-invalid";
                                                        $le = 'text-danger';
                                                        $msg = '<small class="text-danger">'.session('valid')['phone'].'</small>';
                                                    }
                                                ?>
                                                <label for="phone" class="form-label <?= $le ?>">No HP</label>
                                                <input inputmode="number" class="phone form-control form-control-md <?= $fe ?>" name="phone" id="phone" value="<?= old('phone') ?>" />
                                                <?= $msg ?>
                                            </div>

                                            <div class="mb-5">
                                                <?php 
                                                    $fe = $le = $msg = '';
                                                    if (session('valid') && array_key_exists("email", session('valid'))) {
                                                        $fe = "is-invalid";
                                                        $le = 'text-danger';
                                                        $msg = '<small class="text-danger">'.session('valid')['email'].'</small>';
                                                    }
                                                ?>
                                                <label for="email" class="form-label <?= $le ?>">Email</label>
                                                <input inputmode="text" class="email form-control form-control-md <?= $fe ?>" name="email" id="email" value="<?= old('email') ?>" />
                                                <?= $msg ?>
                                            </div>
                                        </div>
                                        
                                        <div class="flex-column <?= $step3 ?>" data-kt-stepper-element="content">
                                            <div class="row mb-5">
                                                <div class="col-md-6 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("province", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['province'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="province" class="form-label <?= $le ?>">Provinsi</label>
                                                    <select class="form-select form-control-md" data-control="select2" id="province" name="province">
                                                        <option value="">Pilih Provinsi</option>
                                                        <?php foreach ($province as $k => $v): ?>
                                                            <option value="<?= $v['territory_code'] ?>" <?= $v['territory_code'] == old('province') ? 'selected' : '' ?>>
                                                                <?= $v['territory_name'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <?= $msg ?>
                                                </div>
                                                <div class="col-md-6 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("regency", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['regency'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="regency" class="form-label <?= $le ?>">Kabupaten/Kota</label>
                                                    <select class="form-select form-control-md" data-control="select2" id="regency" name="regency">
                                                        <option value="0">Pilih Kabupaten/Kota</option>
                                                    </select>
                                                    <?= $msg ?>
                                                </div>
                                            </div>
                                            
                                            <div class="row mb-5">
                                                <div class="col-md-6 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("subdistrict", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['subdistrict'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="subdistrict" class="form-label <?= $le ?>">Kecamatan</label>
                                                    <select class="form-select form-control-md" data-control="select2" id="subdistrict" name="subdistrict">
                                                        <option value="0">Kecamatan</option>
                                                    </select>
                                                    <?= $msg ?>
                                                </div>
                                                <div class="col-md-6 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("postal_code", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['postal_code'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="postal_code" class="form-label <?= $le ?>">Kode Pos</label>
                                                    <input type="number" class="form-control form-control-md <?= $fe ?>" name="postal_code" id="postal_code" value="<?= old('postal_code') ?>" />
                                                    <?= $msg ?>
                                                </div>
                                            </div>

                                            <div class="mb-5">
                                                <?php 
                                                    $fe = $le = $msg = '';
                                                    if (session('valid') && array_key_exists("address", session('valid'))) {
                                                        $fe = "is-invalid";
                                                        $le = 'text-danger';
                                                        $msg = '<small class="text-danger">'.session('valid')['address'].'</small>';
                                                    }
                                                ?>
                                                <label for="address" class="form-label <?= $le ?>">Alamat Lengkap</label>
                                                <textarea class="form-control" name="address" id="address" cols="30" rows="3"><?= old('address') ?></textarea>
                                                <?= $msg ?>
                                            </div>
                                            
                                        </div>

                                        <div class="flex-column <?= $step4 ?>" data-kt-stepper-element="content">
                                            <div class="row mb-5">
                                                <div class="col-md-6 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("father_name", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['father_name'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="father_name" class="form-label <?= $le ?>">Nama Ayah</label>
                                                    <input type="text" class="form-control form-control-md <?= $fe ?>" name="father_name" id="father_name" value="<?= old('father_name') ?>" />
                                                    <?= $msg ?>
                                                </div>
                                                <div class="col-md-6 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("father_occupation", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['father_occupation'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="father_occupation" class="form-label <?= $le ?>">Pekerjaan Ayah</label>
                                                    <input type="text" class="form-control form-control-md <?= $fe ?>" name="father_occupation" id="father_occupation" value="<?= old('father_occupation') ?>" />
                                                    <?= $msg ?>
                                                </div>
                                            </div>
                                            
                                            <div class="row mb-5">
                                                <div class="col-md-6 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("mother_name", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['mother_name'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="mother_name" class="form-label <?= $le ?>">Nama Ibu</label>
                                                    <input type="text" class="form-control form-control-md <?= $fe ?>" name="mother_name" id="mother_name" value="<?= old('mother_name') ?>" />
                                                    <?= $msg ?>
                                                </div>
                                                <div class="col-md-6 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("mother_occupation", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['mother_occupation'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="mother_occupation" class="form-label <?= $le ?>">Pekerjaan Ibu</label>
                                                    <input type="text" class="form-control form-control-md <?= $fe ?>" name="mother_occupation" id="mother_occupation" value="<?= old('mother_occupation') ?>" />
                                                    <?= $msg ?>
                                                </div>
                                            </div>

                                            <div class="mb-5">
                                                <?php 
                                                    $fe = $le = $msg = '';
                                                    if (session('valid') && array_key_exists("parent_address", session('valid'))) {
                                                        $fe = "is-invalid";
                                                        $le = 'text-danger';
                                                        $msg = '<small class="text-danger">'.session('valid')['parent_address'].'</small>';
                                                    }
                                                ?>
                                                <label for="parent_address" class="form-label <?= $le ?>">Alamat Orang Tua</label>
                                                <textarea class="form-control" name="parent_address" id="parent_address" cols="30" rows="3"><?= old('parent_address') ?></textarea>
                                                <?= $msg ?>
                                            </div>

                                            <div class="row mb-5">
                                                <div class="col-md-6 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("parent_postal_code", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['parent_postal_code'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="parent_postal_code" class="form-label <?= $le ?>">Kode Pos</label>
                                                    <input type="number" class="form-control form-control-md <?= $fe ?>" name="parent_postal_code" id="parent_postal_code" value="<?= old('parent_postal_code') ?>" />
                                                    <?= $msg ?>
                                                </div>
                                                <div class="col-md-6 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("parent_phone", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['parent_phone'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="parent_phone" class="form-label <?= $le ?>">Telp/HP Orang Tua</label>
                                                    <input inputmode="number" class="phone form-control form-control-md <?= $fe ?>" name="parent_phone" id="parent_phone" value="<?= old('parent_phone') ?>" />
                                                    <?= $msg ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex-column <?= $step5 ?>" data-kt-stepper-element="content">
                                            <div class="row mb-5">
                                                <div class="col-md-6 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("guardian_name", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['guardian_name'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="guardian_name" class="form-label <?= $le ?>">Nama Wali</label>
                                                    <input type="text" class="form-control form-control-md <?= $fe ?>" name="guardian_name" id="guardian_name" value="<?= old('guardian_name') ?>" />
                                                    <?= $msg ?>
                                                </div>
                                                <div class="col-md-6 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("guardian_occupation", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['guardian_occupation'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="guardian_occupation" class="form-label <?= $le ?>">Pekerjaan Wali</label>
                                                    <input type="text" class="form-control form-control-md <?= $fe ?>" name="guardian_occupation" id="guardian_occupation" value="<?= old('guardian_occupation') ?>" />
                                                    <?= $msg ?>
                                                </div>
                                            </div>

                                            <div class="mb-5">
                                                <?php 
                                                    $fe = $le = $msg = '';
                                                    if (session('valid') && array_key_exists("guardian_address", session('valid'))) {
                                                        $fe = "is-invalid";
                                                        $le = 'text-danger';
                                                        $msg = '<small class="text-danger">'.session('valid')['guardian_address'].'</small>';
                                                    }
                                                ?>
                                                <label for="guardian_address" class="form-label <?= $le ?>">Alamat Wali</label>
                                                <textarea class="form-control" name="guardian_address" id="guardian_address" cols="30" rows="3"><?= old('guardian_address') ?></textarea>
                                                <?= $msg ?>
                                            </div>

                                            <div class="row mb-5">
                                                <div class="col-md-6 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("guardian_postal_code", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['guardian_postal_code'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="guardian_postal_code" class="form-label <?= $le ?>">Kode Pos</label>
                                                    <input type="number" class="form-control form-control-md <?= $fe ?>" name="guardian_postal_code" id="guardian_postal_code" value="<?= old('guardian_postal_code') ?>" />
                                                    <?= $msg ?>
                                                </div>
                                                <div class="col-md-6 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("guardian_phone", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['guardian_phone'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="guardian_phone" class="form-label <?= $le ?>">Telp/HP Wali</label>
                                                    <input inputmode="number" class="phone form-control form-control-md <?= $fe ?>" name="guardian_phone" id="guardian_phone" value="<?= old('guardian_phone') ?>" />
                                                    <?= $msg ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex-column <?= $step6 ?>" data-kt-stepper-element="content">
                                            <div class="row mb-5">
                                                <div class="col-md-3 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("nisn", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['nisn'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="nisn" class="required form-label <?= $le ?>">NISN</label>
                                                    <input class="nisn form-control" name="nisn" id="nisn" value="<?= old('nisn') ?>">
                                                    <?= $msg ?>
                                                </div>
                                                <div class="col-md-4 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("grade", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['grade'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="grade" class="required form-label <?= $le ?>">Jenjang Kelas</label>
                                                    <select class="form-select form-control-md" id="grade" name="grade">
                                                    <option value="0">Pilih Jenjang Kelas</option>
                                                        <?php foreach ($grade as $k => $v): ?>
                                                            <option value="<?= $k ?>" <?= old('grade') == $k ? 'selected' : '' ?> ><?= $v ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <?= $msg ?>
                                                </div>
                                                <div class="col-md-5 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("student_group", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['student_group'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="student_group" class="required form-label <?= $le ?>">Nama Kelas</label>
                                                    <select class="form-select form-control-md" data-control="select2" id="student_group" name="student_group">
                                                        <option value="0">Pilih Nama Kelas</option>
                                                    </select>
                                                    <?= $msg ?>
                                                </div>
                                            </div>
                                            
                                            <div class="row mb-5">
                                                <div class="col-md-6 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("registered_date", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['registered_date'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="registered_date" class="required form-label <?= $le ?>">Tanggal Diterima</label>
                                                    <input type="date" class="form-control form-control-md <?= $fe ?>" name="registered_date" id="registered_date" value="<?= old('registered_date') ?>" />
                                                    <?= $msg ?>
                                                </div>
                                                <div class="col-md-6 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("transfer", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['transfer'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="transfer" class="mb-5 required form-label <?= $le ?>">Terdaftar Sebagai Siswa</label>
                                                    <br>
                                                    <div class="form-check form-check-custom form-check-solid me-10 form-check-inline">
                                                        <input class="form-check-input" type="radio" name="transfer" value="1" id="teach1" <?= old("transfer") == 1 ? 'checked' : '' ?> />
                                                        <label class="form-check-label text-dark" for="teach1">
                                                            Baru
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid me-10 form-check-inline">
                                                        <input class="form-check-input" type="radio" name="transfer" value="2" id="teach2" <?= old("transfer") == 2 ? 'checked' : '' ?>/>
                                                        <label class="form-check-label text-dark" for="teach2">
                                                            Pindahan
                                                        </label>
                                                    </div>
                                                    <br>
                                                    <?= $msg ?>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-5">
                                                <?php 
                                                    $fe = $le = $msg = '';
                                                    if (session('valid') && array_key_exists("previous_school", session('valid'))) {
                                                        $fe = "is-invalid";
                                                        $le = 'text-danger';
                                                        $msg = '<small class="text-danger">'.session('valid')['previous_school'].'</small>';
                                                    }
                                                ?>
                                                <label for="previous_school" class="required form-label <?= $le ?>">Asal Sekolah</label>
                                                <input type="text" class="form-control form-control-md <?= $fe ?>" name="previous_school" id="previous_school" value="<?= old('previous_school') ?>" />
                                                <?= $msg ?>
                                            </div>
                                            
                                            <div class="mb-5">
                                                <?php 
                                                    $fe = $le = $msg = '';
                                                    if (session('valid') && array_key_exists("registered_information", session('valid'))) {
                                                        $fe = "is-invalid";
                                                        $le = 'text-danger';
                                                        $msg = '<small class="text-danger">'.session('valid')['registered_information'].'</small>';
                                                    }
                                                ?>
                                                <label for="registered_information" class="form-label <?= $le ?>">Informasi Pendaftaran</label>
                                                <textarea class="form-control" name="registered_information" id="registered_information" cols="30" rows="3"><?= old('registered_information') ?></textarea>
                                                <?= $msg ?>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="d-flex flex-stack">
                                        <div class="me-2">
                                            <button type="button" class="btn btn-light btn-active-light-primary"
                                                data-kt-stepper-action="previous">
                                                Kembali
                                            </button>
                                        </div>

                                        <div>
                                            <button type="submit" class="btn btn-success"
                                                data-kt-stepper-action="submit">
                                                <span class="indicator-label">
                                                    Simpan
                                                </span>
                                                <span class="indicator-progress">
                                                    Please wait... <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                </span>
                                            </button>

                                            <button type="button" class="btn btn-primary" data-kt-stepper-action="next">
                                                Selanjutnya
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {

        var element = document.querySelector("#kt_stepper_example_vertical");

        var stepper = new KTStepper(element);
        <?php if (
            (session('valid') && array_key_exists("phone", session('valid'))) ||
            (session('valid') && array_key_exists("email", session('valid'))) 
        ): ?>
            stepper.goNext();
        <?php elseif(
            (session('valid') && array_key_exists("province", session('valid'))) ||
            (session('valid') && array_key_exists("regency", session('valid'))) ||
            (session('valid') && array_key_exists("subdistrict", session('valid'))) ||
            (session('valid') && array_key_exists("postal_code", session('valid'))) ||
            (session('valid') && array_key_exists("address", session('valid'))) 
        ): ?>
            stepper.goNext();
            stepper.goNext();
        <?php elseif(
            (session('valid') && array_key_exists("father_name", session('valid'))) ||
            (session('valid') && array_key_exists("father_occupation", session('valid'))) ||
            (session('valid') && array_key_exists("mother_name", session('valid'))) ||
            (session('valid') && array_key_exists("mother_occupation", session('valid'))) ||
            (session('valid') && array_key_exists("parent_address", session('valid'))) ||
            (session('valid') && array_key_exists("parent_postal_code", session('valid'))) ||
            (session('valid') && array_key_exists("parent_phone", session('valid'))) 
        ): ?>
            stepper.goNext();
            stepper.goNext();
            stepper.goNext();
        <?php elseif(
            (session('valid') && array_key_exists("guardian_name", session('valid'))) ||
            (session('valid') && array_key_exists("guardian_occupation", session('valid'))) ||
            (session('valid') && array_key_exists("guardian_address", session('valid'))) ||
            (session('valid') && array_key_exists("guardian_postal_code", session('valid'))) ||
            (session('valid') && array_key_exists("guardian_phone", session('valid'))) 
        ): ?>
            stepper.goNext();
            stepper.goNext();
            stepper.goNext();
            stepper.goNext();
        <?php elseif($stepper == 'last'): ?>
            stepper.goNext();
            stepper.goNext();
            stepper.goNext();
            stepper.goNext();
            stepper.goNext();
        <?php endif; ?>

        stepper.on("kt.stepper.click", function (stepper) {
            stepper.goTo(stepper.getClickedStepIndex()); // go to clicked step
        });

        stepper.on("kt.stepper.next", function (stepper) {
            stepper.goNext(); // go next step
        });

        stepper.on("kt.stepper.previous", function (stepper) {
            stepper.goPrevious(); // go previous step
        });

        if ($('#province').val() != 0) {
            let params = {
                'code': '<?= old('province') ?>',
                'len': 5,
                'fillen': 2,
                'title': 'regency',
                'old': '<?= old('regency') ?>'
            }
            get_location(params);
        }

        if ($('#grade').val()  != 0) {
            let params = {
                'code': '<?= old('grade') ?>',
                'old': '<?= old('student_group') ?>'
            }
            get_group(params);
        }
        
    })

    $('#grade').on('change', function () {
        let params = {
            'code': $('#grade').val(),
            'old': ''
        }
        if ($('#grade').val() == "0") {
            $("#student_group").html("<option value=\'0\'>Pilih Nama Kelas</option>");
        } else {
            get_group(params);
        }
    })

    function get_group(params) {
        $.ajax({
            url: "<?= base_url('/sms/user/student/student-group') ?>",
            type: "post",
            data: params,
            dataType: "json",
            success: function (data) {
                let selected = params.old != '' ? params.old : '';
                console.log(selected);
                let option = `<option value="0">Pilih Nama Kelas</option>`;
                $.each(data, function (k, v) {
                    option += `<option value="${v.student_group_id}" ${selected == v.student_group_id ? 'selected' : ''}>${v.student_group_name}</option>`;
                });
                $("#student_group").html(option);
            },
        });
    }

    $('#province').on('change', function () {
        let params = {
            'code': $('#province').val(),
            'len': 5,
            'fillen': 2,
            'title': 'regency',
            'old': ''
        }
        if ($(this).val() == "0") {
            $("#regency").html("<option value=\'0\'>Pilih Kabupaten/Kota</option>");
        } else {
            get_location(params);
        }
    })

    $('#regency').on('change', function () {
        let params = {
            'code': $(this).val(),
            'len': 8,
            'fillen': 5,
            'title': 'subdistrict',
            'old': ''
        }
        if ($(this).val() == "0") {
            $("#regency").html("<option value=\'0\'>Pilih Kecamatan</option>");
        } else {
            get_location(params);
        }
    })

    var get_location = (params) => {
        $.ajax({
            url: "<?= base_url('/sms/user/student/list_area') ?>",
            type: "post",
            data: params,
            dataType: "json",
            success: function (data) {
                let selected = params.old != '' ? params.old : '';
                let option = `<option value="0">Pilih ${((params.title == "regency") ? "Kabupaten/Kota" : "Kecamatan")}</option>`;
                $.each(data, function (k, v) {
                    option += `<option value="${v.territory_code}" ${selected == v.territory_code ? 'selected' : ''}>${v.territory_name}</option>`;
                });
                $("#" + params.title.toLowerCase()).html(option);

                if (selected != '' && params.title == 'regency') {
                    let params = {
                        'code': selected,
                        'len': 8,
                        'fillen': 5,
                        'title': 'subdistrict',
                        'old': '<?= old('subdistrict') ?>'
                    }

                    get_location(params)
                }
            },
        });
    };
</script>

<?php $this->endSection(); ?>