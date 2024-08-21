<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="row mb-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center mx-2">
                    <h4 class="card-title">
                        Tambah Data Guru
                    </h4>
                </div>
            </div>
            <?php
            $stepper = "first";
            $label1 = 'current';
            $label2 = $label3 = $label4 = 'pending';
            $step1 = 'current';
            $step2 = $step3 = $step4 = "";
            if (
                (session('valid') && array_key_exists("avatar", session('valid'))) ||
                (session('valid') && array_key_exists("first_name", session('valid'))) ||
                (session('valid') && array_key_exists("last_name", session('valid'))) ||
                (session('valid') && array_key_exists("gender", session('valid'))) ||
                (session('valid') && array_key_exists("degree", session('valid'))) ||
                (session('valid') && array_key_exists("religion", session('valid'))) ||
                (session('valid') && array_key_exists("birth_date", session('valid'))) 
            ) {
                $stepper = "first";
                $label1 = 'current';
                $label2 = $label3 = $label4 = 'pending';
                $step1 = 'current';
                $step2 = $step3 = $step4 = "";
            }
            elseif (
                (session('valid') && array_key_exists("phone", session('valid'))) ||
                (session('valid') && array_key_exists("email", session('valid'))) 
            ) {
                $stepper = "between";
                $label1 = 'completed';
                $label2 = 'current';
                $label3 = $label4 = 'pending';
                $step2 = 'current';
                $step1 = $step3 = $step4 = "";
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
                $label4 = 'pending';
                $step3 = 'current';
                $step1 = $step2 = $step4 = "";
            } elseif (
                (session('valid') && array_key_exists("nip", session('valid'))) ||
                (session('valid') && array_key_exists("nuptk", session('valid'))) ||
                (session('valid') && array_key_exists("nick_name", session('valid'))) ||
                (session('valid') && array_key_exists("employment_status", session('valid'))) ||
                (session('valid') && array_key_exists("is_teaching", session('valid'))) 
            ) {
                $stepper = "last";
                $label1 = $label2 = $label3 = 'completed';
                $label4 = 'current';
                $step4 = 'current';
                $step1 = $step2 = $step3 = "";
            }
            ?>
            <div class="card-body" id="teacher_form">
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
                                                    Kepegawaian
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-row-fluid">
                                <form action="<?= base_url('/sms/user/teacher/update') ?>" method="POST" enctype="multipart/form-data">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="teacher_id" value="<?= $row['teacher_id'] ?>">
                                    <input type="hidden" name="old_avatar" value="<?= $row['teacher_image'] ?>">
                                    <div class="mb-5" style="min-height: 400px">
                                        <div class="flex-column <?= $step1 ?>" data-kt-stepper-element="content">
                                            <div class="row mb-5">
                                                <div class="col-md-6 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("avatar", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['avatar'].'</small>';
                                                        }
                                                    ?>
                                                    <label class="d-block fw-semibold fs-6 mb-5 <?= $le ?> ">Foto</label>
                                                    <style>
                                                        .image-input-placeholder {
                                                            background-image: url('<?= base_url('images/teacher/').$row['teacher_image'] ?>');
                                                        }

                                                        [data-bs-theme="dark"] .image-input-placeholder {
                                                            background-image: url('<?= base_url('images/teacher/').$row['teacher_image'] ?>');
                                                        }
                                                    </style>
                                                    <div class="image-input image-input-outline image-input-placeholder image-input-empty" data-kt-image-input="true">
                                                        <div class="image-input-wrapper w-125px h-125px" style="background-image: none;">
                                                        </div>
                                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change avatar" data-bs-original-title="Change avatar" data-kt-initialized="1">
                                                            <i class="ki-duotone ki-pencil fs-7">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                            <input type="file" name="avatar" accept=".png, .jpg, .jpeg">
                                                            <input type="hidden" name="avatar_remove" value="1">
                                                        </label>
                                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel avatar" data-bs-original-title="Cancel avatar" data-kt-initialized="1">
                                                            <i class="ki-duotone ki-cross fs-2">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        </span>
                                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="Remove avatar" data-bs-original-title="Remove avatar" data-kt-initialized="1">
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
                                                        <input type="text" class="form-control form-control-md <?= $fe ?>" name="first_name" id="first_name" value="<?= old('first_name') ? old('first_name') : $row['teacher_first_name'] ?>" />
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
                                                        <input type="text" class="form-control form-control-md <?= $fe ?>" name="last_name" id="last_name" value="<?= old('last_name') ? old('last_name') : $row['teacher_last_name'] ?>" />
                                                        <?= $msg ?>
                                                    </div>
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
                                                        $radio_gender = old('gender') ? old('gender') : $row['teacher_gender'];
                                                    ?>
                                                    <label for="gender" class="mb-5 required form-label <?= $le ?>">Jenis Kelamin</label>
                                                    <br>
                                                    <div class="form-check form-check-custom form-check-solid me-10 form-check-inline">
                                                        <input class="form-check-input" type="radio" name="gender" value="1" id="opt1" <?= $radio_gender == 1 ? 'checked' : '' ?> />
                                                        <label class="form-check-label text-dark" for="opt1">
                                                            Laki-laki
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid me-10 form-check-inline">
                                                        <input class="form-check-input" type="radio" name="gender" value="2" id="opt2" <?= $radio_gender == 2 ? 'checked' : '' ?>/>
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
                                                        if (session('valid') && array_key_exists("degree", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['degree'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="degree" class="form-label <?= $le ?>">Gelar Akademik</label>
                                                    <input type="text" class="form-control" name="degree" id="degree" value="<?= old('degree') ? old('degree') : $row['teacher_degree'] ?>">
                                                    <?= $msg ?>
                                                </div>
                                            </div>

                                            <div class="row mb-5">
                                                <div class="col-md-6 fv-row">
                                                    <?php 
                                                        $fe = $le = $msg = '';
                                                        if (session('valid') && array_key_exists("birth_date", session('valid'))) {
                                                            $fe = "is-invalid";
                                                            $le = 'text-danger';
                                                            $msg = '<small class="text-danger">'.session('valid')['birth_date'].'</small>';
                                                        }
                                                    ?>
                                                    <label for="birth_date" class="required form-label <?= $le ?>">Tanggal Lahir</label>
                                                    <!-- <input class="date form-control form-control-md <?= $fe ?>" name="birth_date" id="birth_date" value="2024/05/04" /> -->
                                                    <input type="date" class="form-control form-control-md <?= $fe ?>" name="birth_date" id="birth_date" value="<?= old('birth_date') ? old('birth_date') : $row['teacher_birth_date'] ?>" />
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
                                                        $option_religion = old('religion') ? old('religion') : $row['teacher_religion'];
                                                    ?>
                                                    <label for="religion" class="form-label required <?= $le ?>">Agama</label>
                                                    <select class="form-select form-control-md" id="religion" name="religion">
                                                        <option value="">Pilih Agama</option>
                                                        <?php foreach ($religion as $k => $v): ?>
                                                            <option value="<?= $k ?>" <?= $option_religion == $k ? 'selected' : '' ?>>
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
                                                <input inputmode="number" class="phone form-control form-control-md <?= $fe ?>" name="phone" id="phone" value="<?= old('phone') ? old('phone') : $row['teacher_phone'] ?>" />
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
                                                <input inputmode="text" class="email form-control form-control-md <?= $fe ?>" name="email" id="email" value="<?= old('email') ? old('email') : $row['user_email'] ?>" />
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
                                                        $val = old('province') ? old('province') : $row['teacher_province'];
                                                    ?>
                                                    <label for="province" class="form-label <?= $le ?>">Provinsi</label>
                                                    <select class="form-select form-control-md" data-control="select2" id="province" name="province">
                                                        <option value="">Pilih Provinsi</option>
                                                        <?php foreach ($province as $k => $v): ?>
                                                            <option value="<?= $v['territory_code'] ?>" <?= $v['territory_code'] == $val ? 'selected' : '' ?>>
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
                                                    <input type="number" class="form-control form-control-md <?= $fe ?>" name="postal_code" id="postal_code" value="<?= old('postal_code') ? old('postal_code') : $row['teacher_postal_code'] ?>" />
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
                                                <textarea class="form-control" name="address" id="address" cols="30" rows="3"><?= old('address') ? old('address') : $row['teacher_address'] ?></textarea>
                                                <?= $msg ?>
                                            </div>
                                            
                                        </div>

                                        <div class="flex-column <?= $step4 ?>" data-kt-stepper-element="content">
                                            <div class="row mb-5">
                                                <?php 
                                                    $fe = $le = $msg = '';
                                                    if (session('valid') && array_key_exists("nip", session('valid'))) {
                                                        $fe = "is-invalid";
                                                        $le = 'text-danger';
                                                        $msg = '<small class="text-danger">'.session('valid')['nip'].'</small>';
                                                    }
                                                ?>
                                                <label for="nip" class="form-label <?= $le ?>">NIP</label>
                                                <input inputmode="number" class="nip form-control" name="nip" id="nip" value="<?= old('nip') ? old('nip') : $row['teacher_nip'] ?>">
                                                <?= $msg ?>
                                            </div>
                                            
                                            <div class="row mb-5">
                                                <?php 
                                                    $fe = $le = $msg = '';
                                                    if (session('valid') && array_key_exists("nuptk", session('valid'))) {
                                                        $fe = "is-invalid";
                                                        $le = 'text-danger';
                                                        $msg = '<small class="text-danger">'.session('valid')['nuptk'].'</small>';
                                                    }
                                                ?>
                                                <label for="nuptk" class="form-label <?= $le ?>">NUPTK</label>
                                                <input inputmode="number" class="nuptk form-control" name="nuptk" id="nuptk" value="<?= old('nuptk') ? old('nuptk') : $row['teacher_nuptk'] ?>">
                                                <?= $msg ?>
                                            </div>
                                            
                                            <div class="row mb-5">
                                                <?php 
                                                    $fe = $le = $msg = '';
                                                    if (session('valid') && array_key_exists("nick_name", session('valid'))) {
                                                        $fe = "is-invalid";
                                                        $le = 'text-danger';
                                                        $msg = '<small class="text-danger">'.session('valid')['nick_name'].'</small>';
                                                    }
                                                ?>
                                                <label for="nick_name" class="form-label required <?= $le ?>">Kode Guru/Nama Singkatan</label>
                                                <input type="text" class="form-control" name="nick_name" id="nick_name" value="<?= old('nick_name') ? old('nick_name') : $row['teacher_nick_name'] ?>">
                                                <?= $msg ?>
                                            </div>
                                            
                                            <div class="mb-5">
                                                <?php 
                                                    $fe = $le = $msg = '';
                                                    if (session('valid') && array_key_exists("employment_status", session('valid'))) {
                                                        $fe = "is-invalid";
                                                        $le = 'text-danger';
                                                        $msg = '<small class="text-danger">'.session('valid')['employment_status'].'</small>';
                                                    }
                                                    $radio_employment = old('employment_status') ? old('employment_status') : $row['teacher_employment_status'];
                                                ?>
                                                <label for="employment_status" class="mb-5 required form-label <?= $le ?>">Status Kepegawaian</label>
                                                <br>
                                                <div class="form-check form-check-custom form-check-solid me-10 form-check-inline">
                                                    <input class="form-check-input" type="radio" name="employment_status" value="1" id="emp1" <?= $radio_employment == 1 ? 'checked' : '' ?> />
                                                    <label class="form-check-label text-dark" for="emp1">
                                                        PNS
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-custom form-check-solid me-10 form-check-inline">
                                                    <input class="form-check-input" type="radio" name="employment_status" value="2" id="emp2" <?= $radio_employment == 2 ? 'checked' : '' ?>/>
                                                    <label class="form-check-label text-dark" for="emp2">
                                                        Tetap
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-custom form-check-solid me-10 form-check-inline">
                                                    <input class="form-check-input" type="radio" name="employment_status" value="3" id="emp3" <?= $radio_employment == 3 ? 'checked' : '' ?>/>
                                                    <label class="form-check-label text-dark" for="emp3">
                                                        Honorer
                                                    </label>
                                                </div>
                                                <br>
                                                <?= $msg ?>
                                            </div>
                                            
                                            <div class="mb-5">
                                                <?php 
                                                    $fe = $le = $msg = '';
                                                    if (session('valid') && array_key_exists("is_teaching", session('valid'))) {
                                                        $fe = "is-invalid";
                                                        $le = 'text-danger';
                                                        $msg = '<small class="text-danger">'.session('valid')['is_teaching'].'</small>';
                                                    }
                                                    $radio_is_teaching = old('is_teaching') ? old('is_teaching') : $row['teacher_is_teaching'];
                                                ?>
                                                <label for="is_teaching" class="mb-5 required form-label <?= $le ?>">Mengajar di kelas</label>
                                                <br>
                                                <div class="form-check form-check-custom form-check-solid me-10 form-check-inline">
                                                    <input class="form-check-input" type="radio" name="is_teaching" value="1" id="teach1" <?= $radio_is_teaching == 1 ? 'checked' : '' ?> />
                                                    <label class="form-check-label text-dark" for="teach1">
                                                        Ya
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-custom form-check-solid me-10 form-check-inline">
                                                    <input class="form-check-input" type="radio" name="is_teaching" value="2" id="teach2" <?= $radio_is_teaching == 2 ? 'checked' : '' ?>/>
                                                    <label class="form-check-label text-dark" for="teach2">
                                                        Tidak
                                                    </label>
                                                </div>
                                                <br>
                                                <?= $msg ?>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="d-flex flex-row-reverse">
                                        <button type="submit" class="btn btn-success">
                                                Simpan
                                        </button>
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

        // Initialize Stepper
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
        <?php elseif($stepper == 'last'): ?>
            stepper.goNext();
            stepper.goNext();
            stepper.goNext();
        <?php endif; ?>

        stepper.on("kt.stepper.click", function (stepper) {
            stepper.goTo(stepper.getClickedStepIndex()); // go to clicked step
        });

        // Handle next step
        stepper.on("kt.stepper.next", function (stepper) {
            stepper.goNext(); // go next step
        });

        // Handle previous step
        stepper.on("kt.stepper.previous", function (stepper) {
            stepper.goPrevious(); // go previous step
        });

        if ($('#province').val() != 0) {
            let params = {
                'code': '<?= old('province') ? old('province') : $row['teacher_province'] ?>',
                'len': 5,
                'fillen': 2,
                'title': 'regency',
                'old': '<?= old('regency') ?  old('regency') : $row['teacher_regency'] ?>'
            }
            get_location(params);
        }
    })

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
            url: "<?= base_url('/sms/user/teacher/list_area') ?>",
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
                        'old': '<?= old('subdistrict') ? old('subdistrict') : $row['teacher_subdistrict'] ?>'
                    }

                    get_location(params)
                }
            },
        });
    };
    // Stepper lement
</script>

<?php $this->endSection(); ?>