<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>
<style> #stepper-profile{ font-size: 1.25rem; } </style>

<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container">

            <div class="card mb-5 mb-xl-10">
                <div class="card-body pt-9 pb-0">
                    <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                        <div class="me-7 mb-4">
                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                <img src="<?= !empty($row['student_image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/images/student/' . $row['student_image']) ? base_url() . 'images/student/' . $row['student_image'] : base_url('blaze-assets/media/avatars/blank.png') ?>" alt="Foto Murid">
                                <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                <div class="d-flex flex-column">
                                    <div class="d-flex align-items-center mb-2">
                                        <p class="text-gray-900 text-hover-primary fs-2 fw-bold me-1"><?= $row['student_first_name'] . ' ' . $row['student_last_name'] ?></p>
                                    </div>
                                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                        <p class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                        <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i><?= $row['student_first_name'] ?></p>
                                        <p class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                        <i class="ki-duotone ki-geolocation fs-4 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i><?php $join_date = new DateTime($row['student_created_at']); echo 'Terdaftar: ' . $join_date->format('d-m-Y'); ?></p>
                                        <p class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                        <i class="ki-duotone ki-sms fs-4 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i><?= $row['user_name'] ?></p>
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
                            <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="<?= base_url('sms/user/student/show/' . $data_id) ?>">Overview</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center mx-2">
                                <h4 class="card-title">
                                    Profil Data Siswa
                                </h4>
                            </div>
                        </div>
                        <?php
                            $stepper = "first";
                            $label1 = 'current';
                            $label2 = $label3 = $label4 = $label5 = $label6 = 'pending';
                            $step1 = 'current';
                            $step2 = $step3 = $step4 = $step5 = $step6 = "";
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
                                                            <b class="stepper-check" id="stepper-profile">1</b>
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
                                                            <b class="stepper-check" id="stepper-profile">2</b>
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
                                                            <b class="stepper-check" id="stepper-profile">3</b>
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
                                                            <b class="stepper-check" id="stepper-profile">4</b>
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
                                                            <b class="stepper-check" id="stepper-profile">5</b>
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
                                                            <b class="stepper-check" id="stepper-profile">6</b>
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
                                            <div class="mb-5" style="min-height: 400px">
                                                <div class="flex-column <?= $step1 ?>" data-kt-stepper-element="content">
                                                    <div class="row mb-5">
                                                        <div class="col-md-12 fv-row">
                                                            <div class="mb-10">
                                                                <?php 
                                                                    $fe = $le = $msg = '';
                                                                    if (session('valid') && array_key_exists("first_name", session('valid'))) {
                                                                        $fe = "is-invalid";
                                                                        $le = 'text-danger';
                                                                        $msg = '<small class="text-danger">'.session('valid')['first_name'].'</small>';
                                                                    }
                                                                ?>
                                                                <label for="first_name" class="form-label">Nama Depan</label>
                                                                <input type="text" class="form-control form-control-md" name="first_name" id="first_name" value="<?= old('first_name') ? old('first_name') : $row['student_first_name'] ?>" readonly />
                                                                
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
                                                                <label for="last_name" class="form-label">Nama Belakang</label>
                                                                <input type="text" class="form-control form-control-md" name="last_name" id="last_name" value="<?= old('last_name') ? old('last_name') : $row['student_last_name'] ?>" readonly />
                                                                
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
                                                            <label for="birth_place" class="form-label">Tempat Lahir</label>
                                                            <input type="text" class="form-control form-control-md" name="birth_place" id="birth_place" value="<?= old('birth_place') ? old('birth_place') : $row['student_birth_place'] ?>" readonly />
                                                            
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
                                                            <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                                            <input type="date" class="form-control form-control-md" name="birth_date" id="birth_date" value="<?= old('birth_date') ? old('birth_date') : $row['student_birth_date'] ?>" readonly />
                                                            
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
                                                            <label for="order_child" class="form-label">Anak Ke</label>
                                                            <input type="number" class="form-control form-control-md" name="order_child" id="order_child" value="<?= old('order_child') ? old('order_child') : $row['student_child_order_in_family'] ?>" readonly />
                                                            
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
                                                                $radio_gender = old('gender') ? old('gender') : $row['student_gender'];
                                                            ?>
                                                            <label for="gender" class="mb-5 form-label">Jenis Kelamin</label>
                                                            <br>
                                                            <div class="form-check form-check-custom form-check-solid me-10 form-check-inline">
                                                                <input class="form-check-input" type="radio" name="gender" value="1" id="opt1" <?= $radio_gender == 1 ? 'checked' : '' ?> disabled />
                                                                <label class="form-check-label text-dark" for="opt1">
                                                                    Laki-laki
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-custom form-check-solid me-10 form-check-inline">
                                                                <input class="form-check-input" type="radio" name="gender" value="2" id="opt2" <?= $radio_gender == 2 ? 'checked' : '' ?> disabled />
                                                                <label class="form-check-label text-dark" for="opt2">
                                                                    Perempuan
                                                                </label>
                                                            </div>
                                                            <br>
                                                            
                                                        </div>
                                                        <div class="col-md-6 fv-row">                                                
                                                            <label for="religion" class="form-label required">Agama</label>
                                                            <select class="form-select form-control-md" id="religion" name="religion" disabled>
                                                                <option value="">Pilih Agama</option>
                                                                <?php foreach ($religion as $k => $v): ?>
                                                                    <option value="<?= $k ?>" <?= $row['student_religion'] == $k ? 'selected' : '' ?>>
                                                                        <?= $v ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>                                                
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
                                                        <label for="phone" class="form-label">No HP</label>
                                                        <input inputmode="number" class="phone form-control form-control-md" name="phone" id="phone" value="<?= old('phone') ? old('phone') : $row['student_phone'] ?>" readonly />
                                                        
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
                                                        <label for="email" class="form-label">Email</label>
                                                        <input inputmode="text" class="email form-control form-control-md" name="email" id="email" value="<?= old('email') ? old('email') : $row['user_email'] ?>" readonly />
                                                        
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
                                                                $val = old('province') ? old('province') : $row['student_province']
                                                            ?>
                                                            <label for="province" class="form-label">Provinsi</label>
                                                            <input type="text" class="form-control form-control-md" value="<?= territory_name($row['student_province']) ?>" readonly /> 
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
                                                            <label for="regency" class="form-label">Kabupaten/Kota</label>
                                                            <input type="text" class="form-control form-control-md" value="<?= territory_name($row['student_regency']) ?>" readonly /> 
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
                                                            <label for="subdistrict" class="form-label">Kecamatan</label>
                                                            <input type="text" class="form-control form-control-md" value="<?= territory_name($row['student_subdistrict']) ?>" readonly /> 
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
                                                            <label for="postal_code" class="form-label">Kode Pos</label>
                                                            <input type="number" class="form-control form-control-md" name="postal_code" id="postal_code" value="<?= old('postal_code') ? old('postal_code') : $row['student_postal_code'] ?>" readonly />
                                                            
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
                                                        <label for="address" class="form-label">Alamat Lengkap</label>
                                                        <textarea class="form-control" name="address" id="address" cols="30" rows="3"><?= old('address') ? old('address') : $row['student_address'] ?></textarea>
                                                        
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
                                                            <label for="father_name" class="form-label">Nama Ayah</label>
                                                            <input type="text" class="form-control form-control-md" name="father_name" id="father_name" value="<?= old('father_name') ? old('father_name') : $row['student_father_name'] ?>" readonly />
                                                            
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
                                                            <label for="father_occupation" class="form-label">Pekerjaan Ayah</label>
                                                            <input type="text" class="form-control form-control-md" name="father_occupation" id="father_occupation" value="<?= old('father_occupation') ? old('father_occupation') : $row['student_father_occupation'] ?>" readonly />
                                                            
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
                                                            <label for="mother_name" class="form-label">Nama Ibu</label>
                                                            <input type="text" class="form-control form-control-md" name="mother_name" id="mother_name" value="<?= old('mother_name') ? old('mother_name') : $row['student_mother_name'] ?>" readonly />
                                                            
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
                                                            <label for="mother_occupation" class="form-label">Pekerjaan Ibu</label>
                                                            <input type="text" class="form-control form-control-md" name="mother_occupation" id="mother_occupation" value="<?= old('mother_occupation') ? old('mother_occupation') : $row['student_mother_occupation'] ?>" readonly />
                                                            
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
                                                        <label for="parent_address" class="form-label">Alamat Orang Tua</label>
                                                        <textarea class="form-control" name="parent_address" id="parent_address" cols="30" rows="3"><?= old('parent_address') ? old('parent_address') : $row['student_parent_address'] ?></textarea>
                                                        
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
                                                            <label for="parent_postal_code" class="form-label">Kode Pos</label>
                                                            <input type="number" class="form-control form-control-md" name="parent_postal_code" id="parent_postal_code" value="<?= old('parent_postal_code') ? old('parent_postal_code') : $row['student_parent_postal_code'] ?>" readonly />
                                                            
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
                                                            <label for="parent_phone" class="form-label">Telp/HP Orang Tua</label>
                                                            <input inputmode="number" class="phone form-control form-control-md" name="parent_phone" id="parent_phone" value="<?= old('parent_phone') ? old('parent_phone') : $row['student_parent_phone'] ?>" readonly />
                                                            
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
                                                            <label for="guardian_name" class="form-label">Nama Wali</label>
                                                            <input type="text" class="form-control form-control-md" name="guardian_name" id="guardian_name" value="<?= old('guardian_name') ? old('guardian_name') : $row['student_guardian_name'] ?>" readonly />
                                                            
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
                                                            <label for="guardian_occupation" class="form-label">Pekerjaan Wali</label>
                                                            <input type="text" class="form-control form-control-md" name="guardian_occupation" id="guardian_occupation" value="<?= old('guardian_occupation') ? old('guardian_occupation') : $row['student_guardian_occupation'] ?>" readonly />
                                                            
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
                                                        <label for="guardian_address" class="form-label">Alamat Wali</label>
                                                        <textarea class="form-control" name="guardian_address" id="guardian_address" cols="30" rows="3"><?= old('guardian_address') ? old('guardian_address') : $row['student_guardian_address'] ?></textarea>
                                                        
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
                                                            <label for="guardian_postal_code" class="form-label">Kode Pos</label>
                                                            <input type="number" class="form-control form-control-md" name="guardian_postal_code" id="guardian_postal_code" value="<?= old('guardian_postal_code') ? old('guardian_postal_code') : $row['student_guardian_postal_code'] ?>" readonly />
                                                            
                                                        </div>
                                                        <div class="col-md-6 fv-row">
                                                            <label for="guardian_phone" class="form-label">Telp/HP Wali</label>
                                                            <input inputmode="number" class="phone form-control form-control-md" name="guardian_phone" id="guardian_phone" value="<?= old('guardian_phone') ? old('guardian_phone') : $row['student_guardian_phone'] ?>" readonly />                                                
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="flex-column <?= $step6 ?>" data-kt-stepper-element="content">
                                                    <div class="row mb-5">
                                                        <div class="col-md-3 fv-row">                                            
                                                            <label for="nisn" class="form-label">NISN</label>
                                                            <input type="number" class="form-control" name="nisn" id="nisn" value="<?= old('nisn') ? old('nisn') : $row['student_nisn'] ?>">                                                
                                                        </div>
                                                        <div class="col-md-4 fv-row">                                                
                                                            <label for="grade" class="form-label">Jenjang Kelas</label>
                                                            <select class="form-select form-control-md" id="grade" name="grade" disabled>
                                                                <option value="0">Pilih Jenjang Kelas</option>
                                                                <?php foreach ($grade as $k => $v): ?>
                                                                    <option value="<?= $k ?>" <?= $row['grade'] == $k ? 'selected' : '' ?> ><?= $v ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-5 fv-row">
                                                            <label for="student_group" class="form-label">Nama Kelas</label>
                                                            <select class="form-select form-control-md" data-control="select2" id="student_group" name="student_group" disabled>
                                                                <option value="0">Pilih Nama Kelas</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row">
                                                            <label for="registered_date" class="form-label">Tanggal Diterima</label>
                                                            <input type="date" class="form-control form-control-md" name="registered_date" id="registered_date" value="<?= old('registered_date') ? old('registered_date') : $row['student_registered_date'] ?>" readonly />                                                
                                                        </div>
                                                        <div class="col-md-6 fv-row">
                                                            <label for="transfer" class="mb-5 form-label">Terdaftar Sebagai Siswa</label>
                                                            <br>
                                                            <div class="form-check form-check-custom form-check-solid me-10 form-check-inline">
                                                                <input class="form-check-input" type="radio" name="transfer" value="1" id="teach1" <?= $row['student_is_transfer'] == 1 ? 'checked' : '' ?> disabled />
                                                                <label class="form-check-label text-dark" for="teach1">
                                                                    Baru
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-custom form-check-solid me-10 form-check-inline">
                                                                <input class="form-check-input" type="radio" name="transfer" value="2" id="teach2" <?= $row['student_is_transfer'] == 2 ? 'checked' : '' ?> disabled />
                                                                <label class="form-check-label text-dark" for="teach2">
                                                                    Pindahan
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-5">                                            
                                                        <label for="previous_school" class="form-label">Asal Sekolah</label>
                                                        <input type="text" class="form-control form-control-md" name="previous_school" id="previous_school" value="<?= old('previous_school') ? old('previous_school') : $row['student_previous_school'] ?>" readonly />                                            
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
                                                        <label for="registered_information" class="form-label">Informasi Pendaftaran</label>
                                                        <textarea class="form-control" name="registered_information" id="registered_information" cols="30" rows="3" readonly ><?= old('registered_information') ? old('registered_information') : $row['student_registered_information'] ?></textarea>
                                                        
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                'code': '<?= old('province') ? old('province') : $row['student_province'] ?>',
                'len': 5,
                'fillen': 2,
                'title': 'regency',
                'old': '<?= old('regency') ?  old('regency') : $row['student_regency'] ?>'
            }
            get_location(params);
        }

        if ($('#grade').val()  != 0) {
            let params = {
                'code': '<?= old('grade') ? old('grade') : $row['grade'] ?>',
                'old': '<?= old('student_group') ? old('student_group') : $row['student_group'] ?>'
            }
            get_group(params);
        }
        
    })
</script>

<?php $this->endSection(); ?>