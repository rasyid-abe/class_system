<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>
<style> #stepper-profile{ font-size: 1.25rem; } </style>

<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container">
            
            <?php include 'card-profile.php'; ?>

            <form class="form" action="<?= base_url('dashboard/school/update') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="school_id" value="<?= $row['school_id'] ?>">
                <input type="hidden" name="old_logo" value="<?= $row['school_logo'] ?>">
                <input type="hidden" name="old_ttd" value="<?= $row['school_principal_sign'] ?>">

                <div class="row mb-5 mb-xl-10">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center mx-2">                                
                                    <h3 class="fw-bold m-0">Ubah Profile</h3>
                                </div>
                            </div>
                            <?php                    
                                $valid = session('valid');
                                $stepper = 'first';
                                $label1 = 'current';
                                $label2 = $label3 = 'pending';
                                $step1 = 'current';
                                $step2 = $step3 = '';
                                
                                if ($valid) {
                                    if ( array_key_exists("phone", $valid) || array_key_exists("logo", $valid) || array_key_exists("ttdhead", $valid) || array_key_exists("name", $valid) || array_key_exists("level", $valid) || array_key_exists("principal", $valid) ) {
                                        $stepper = 'first';
                                        $label1 = 'current';
                                        $label2 = $label3 = 'pending';
                                        $step1 = 'current';
                                        $step2 = $step3 = '';
                                    } elseif ( array_key_exists("phone", $valid) || array_key_exists("email", $valid) ) {
                                        $stepper = 'between';
                                        $label1 = 'completed';
                                        $label2 = 'current';
                                        $step2 = 'current';
                                    } else {
                                        $stepper = 'last';
                                        $label1 = $label2 = 'completed';
                                        $label3 = 'current';
                                        $step3 = 'current';
                                    }
                                }                            
                            ?>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="stepper stepper-pills stepper-column d-flex flex-column flex-lg-row <?= $stepper ?>" id="kt_stepper_example_vertical">
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
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex-row-fluid">                                            
                                                <div class="mb-5" style="min-height: 400px">
                                                    <div class="flex-column <?= $step1 ?>" data-kt-stepper-element="content">
                                                        <div class="row mb-5">
                                                            <div class="col-md-4">
                                                                <?php 
                                                                    $fe = $le = $msg = '';
                                                                    if (session('valid') && array_key_exists("logo", session('valid'))) {
                                                                        $fe = "is-invalid";
                                                                        $le = 'text-danger';
                                                                        $msg = '<small class="text-danger">'.session('valid')['logo'].'</small>';
                                                                    }
                                                                ?>                                                                
                                                                <label class="d-block fw-semibold fs-6 mb-5 <?= $le ?> ">Logo Sekolah</label>
                                                                <style>
                                                                    .image-input-placeholder {
                                                                        background-image: url('<?= base_url('/blaze-assets/media/svg/files/blank-image.svg') ?>');
                                                                    }

                                                                    [data-bs-theme="dark"] .image-input-placeholder {
                                                                        background-image: url('<?= base_url('/blaze-assets/media/svg/files/blank-image-dark.svg') ?>');
                                                                    }
                                                                </style>
                                                                <div class="image-input image-input-outline image-input-placeholder image-input-empty" data-kt-image-input="true">
                                                                    <div class="image-input-wrapper w-125px h-125px foto-profil-edit" style="background-image: none;"></div>
                                                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change avatar" data-bs-original-title="Change avatar" data-kt-initialized="1">
                                                                        <i class="ki-duotone ki-pencil fs-7">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>
                                                                        <input type="file" name="logo" accept=".png, .jpg, .jpeg">
                                                                        <input type="hidden" name="old_logo" value="1">
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
                                                            <div class="col-md-4">
                                                                <?php 
                                                                    $fe = $le = $msg = '';
                                                                    if (session('valid') && array_key_exists("ttdhead", session('valid'))) {
                                                                        $fe = "is-invalid";
                                                                        $le = 'text-danger';
                                                                        $msg = '<small class="text-danger">'.session('valid')['ttdhead'].'</small>';
                                                                    }
                                                                ?>
                                                                <label class="d-block fw-semibold fs-6 mb-5 <?= $le ?> ">Tanda Tangan Kepala Sekolah</label>
                                                                <style>
                                                                    .image-input-placeholder {
                                                                        background-image: url('<?= base_url('/blaze-assets/media/svg/files/blank-image.svg') ?>');
                                                                    }

                                                                    [data-bs-theme="dark"] .image-input-placeholder {
                                                                        background-image: url('<?= base_url('/blaze-assets/media/svg/files/blank-image-dark.svg') ?>');
                                                                    }
                                                                </style>
                                                                <div class="image-input image-input-outline image-input-placeholder image-input-empty" data-kt-image-input="true">
                                                                    <div class="image-input-wrapper w-125px h-125px foto-ttd-edit" style="background-image: none;"></div>
                                                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change avatar" data-bs-original-title="Change avatar" data-kt-initialized="1">
                                                                        <i class="ki-duotone ki-pencil fs-7">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>
                                                                        <input type="file" name="ttdhead" accept=".png">
                                                                        <input type="hidden" name="old_ttd" value="1">
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
                                                                <div class="form-text">Tipe file yang diizinkan: png.</div>
                                                                <?= $msg ?>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-5">
                                                            <div class="col-md-4 col-sm-12">
                                                                <div class="mb-3">
                                                                    <?php 
                                                                        $fe = $le = $msg = '';
                                                                        if (session('valid') && array_key_exists("npsn", session('valid'))) {
                                                                            $fe = "is-invalid";
                                                                            $le = 'text-danger';
                                                                            $msg = '<small class="text-danger">'.session('valid')['npsn'].'</small>';
                                                                        }
                                                                    ?>
                                                                    <label class="required form-label <?= $le ?>">NPSN</label>
                                                                    <input type="text" class="form-control form-control-md <?= $fe ?>" value="<?= old('npsn') ? old('npsn') : $row['school_npsn'] ?>" name="npsn" readonly/>
                                                                    <?= $msg ?>
                                                                </div>        
                                                            </div>
                                                            <div class="col-md-8 col-sm-12">
                                                                <div class="mb-3">
                                                                    <?php 
                                                                        $fe = $le = $msg = '';
                                                                        if (session('valid') && array_key_exists("foundation", session('valid'))) {
                                                                            $fe = "is-invalid";
                                                                            $le = 'text-danger';
                                                                            $msg = '<small class="text-danger">'.session('valid')['foundation'].'</small>';
                                                                        }
                                                                    ?>
                                                                    <label class="form-label <?= $le ?>">Yayasan/Dinas Pendidikan</label>
                                                                    <input type="text" class="form-control form-control-md <?= $fe ?>" value="<?= old('foundation') ? old('foundation') : $row['school_foundation'] ?>" name="foundation" />
                                                                    <?= $msg ?>
                                                                </div>        
                                                            </div>
                                                        </div>
                                                        <div class="row mb-5">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <?php 
                                                                        $fe = $le = $msg = '';
                                                                        if (session('valid') && array_key_exists("name", session('valid'))) {
                                                                            $fe = "is-invalid";
                                                                            $le = 'text-danger';
                                                                            $msg = '<small class="text-danger">'.session('valid')['name'].'</small>';
                                                                        }
                                                                    ?>
                                                                    <label class="required form-label <?= $le ?>">Nama Sekolah</label>
                                                                    <input type="text" class="form-control form-control-md <?= $fe ?>" value="<?= $row['school_name'] ?>" name="name" />
                                                                    <?= $msg ?>
                                                                </div>        
                                                            </div>
                                                        </div>
                                                        <div class="row mb-5">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Alias Sekolah</label>
                                                                    <input type="text" class="form-control form-control-md" value="<?= $row['school_alias'] ?>" name="alias" />
                                                                </div>        
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <?php 
                                                                        $fe = $le = $msg = '';
                                                                        if (session('valid') && array_key_exists("level", session('valid'))) {
                                                                            $fe = "is-invalid";
                                                                            $le = 'text-danger';
                                                                            $msg = '<small class="text-danger">'.session('valid')['level'].'</small>';
                                                                        }
                                                                        $val = old('level') ? old('level') : $row['school_level'];
                                                                    ?>
                                                                    <label class="required form-label <?= $le ?>">Jenjang Sekolah</label>
                                                                    <select class="form-select form-control-md <?= $fe ?>" data-control="select2" id="level" name="level">
                                                                        <option value="">Pilih Jenjang Sekolah</option>
                                                                        <?php foreach ($level as $k => $v): ?>
                                                                            <option value="<?= $k ?>" <?= $k == $val ? 'selected' : '' ?>>
                                                                                <?= $v ?>
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                    <?= $msg ?>
                                                                </div>        
                                                            </div>    
                                                        </div>
                                                        <div class="row mb-5">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <?php 
                                                                        $fe = $le = $msg = '';
                                                                        if (session('valid') && array_key_exists("principal", session('valid'))) {
                                                                            $fe = "is-invalid";
                                                                            $le = 'text-danger';
                                                                            $msg = '<small class="text-danger">'.session('valid')['principal'].'</small>';
                                                                        }
                                                                    ?>
                                                                    <label class="required form-label <?= $le ?>">Nama Kepala Sekolah</label>
                                                                    <input type="text" class="form-control form-control-md <?= $fe ?>" value="<?= $row['school_principal'] ?>" name="principal" />
                                                                    <?= $msg ?>
                                                                </div>        
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">NIP Kepala Sekolah</label>
                                                                    <input type="text" class="form-control form-control-md" value="<?= $row['school_principal_nip'] ?>" name="principal_nip" />
                                                                </div>        
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="flex-column <?= $step2 ?>" data-kt-stepper-element="content">
                                                        <div class="row mb-5">
                                                            <div class="col-md-6 col-sm-12">
                                                                <div class="mb-3">
                                                                    <?php 
                                                                        $fe = $le = $msg = '';
                                                                        if (session('valid') && array_key_exists("phone", session('valid'))) {
                                                                            $fe = "is-invalid";
                                                                            $le = 'text-danger';
                                                                            $msg = '<small class="text-danger">'.session('valid')['phone'].'</small>';
                                                                        }
                                                                    ?>
                                                                    <label class="required form-label <?= $le ?>">No. Telpon/WA</label>
                                                                    <input type="text" class="form-control form-control-md <?= $fe ?>" value="<?= $row['school_phone'] ?>" name="phone" />
                                                                    <?= $msg ?>
                                                                </div>        
                                                            </div>
                                                        </div>
                                                        <div class="row mb-5">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <?php 
                                                                        $fe = $le = $msg = '';
                                                                        if (session('valid') && array_key_exists("email", session('valid'))) {
                                                                            $fe = "is-invalid";
                                                                            $le = 'text-danger';
                                                                            $msg = '<small class="text-danger">'.session('valid')['email'].'</small>';
                                                                        }
                                                                    ?>
                                                                    <label class="required form-label <?= $le ?>">Email Sekolah</label>
                                                                    <input type="text" class="form-control form-control-md <?= $fe ?>" value="<?= $row['user_email'] ?>" name="email" />
                                                                    <?= $msg ?>
                                                                </div>        
                                                            </div>
                                                        </div>
                                                        <div class="row mb-5">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Website</label>
                                                                    <input type="text" class="form-control form-control-md" value="<?= $row['school_website'] ?>" name="website" />
                                                                </div>        
                                                            </div>    
                                                        </div>
                                                    </div>

                                                    <div class="flex-column <?= $step3 ?>" data-kt-stepper-element="content">
                                                        <div class="row mb-5">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <?php 
                                                                        $fe = $le = $msg = '';
                                                                        if (session('valid') && array_key_exists("province", session('valid'))) {
                                                                            $fe = "is-invalid";
                                                                            $le = 'text-danger';
                                                                            $msg = '<small class="text-danger">'.session('valid')['province'].'</small>';
                                                                        }
                                                                        $val = old('province') ? old('province') : $row['school_province'];
                                                                    ?>
                                                                    <label for="province" class="required form-label <?= $le ?>">Provinsi</label>
                                                                    <select class="form-select form-control-md <?= $fe ?>" data-control="select2" id="province" name="province">
                                                                        <option value="">Pilih Provinsi</option>
                                                                        <?php foreach ($province as $k => $v): ?>
                                                                            <option value="<?= $v['territory_code'] ?>" <?= $v['territory_code'] == $val ? 'selected' : '' ?>>
                                                                                <?= $v['territory_name'] ?>
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                    <?= $msg ?>
                                                                </div>        
                                                            </div>
                                                        </div>
                                                        <div class="row mb-5">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <?php 
                                                                        $fe = $le = $msg = '';
                                                                        if (session('valid') && array_key_exists("regency", session('valid'))) {
                                                                            $fe = "is-invalid";
                                                                            $le = 'text-danger';
                                                                            $msg = '<small class="text-danger">'.session('valid')['regency'].'</small>';
                                                                        }
                                                                    ?>
                                                                    <label for="regency" class="required form-label <?= $le ?>">Kabupaten/Kota</label>
                                                                    <select class="form-select form-control-md <?= $fe ?>" data-control="select2" id="regency" name="regency">
                                                                        <option value="0">Pilih Kabupaten/Kota</option>
                                                                    </select>
                                                                    <?= $msg ?>
                                                                </div>        
                                                            </div>
                                                        </div>
                                                        <div class="row mb-5">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <?php 
                                                                        $fe = $le = $msg = '';
                                                                        if (session('valid') && array_key_exists("subdistrict", session('valid'))) {
                                                                            $fe = "is-invalid";
                                                                            $le = 'text-danger';
                                                                            $msg = '<small class="text-danger">'.session('valid')['subdistrict'].'</small>';
                                                                        }
                                                                    ?>
                                                                    <label for="subdistrict" class="required form-label <?= $le ?>">Kecamatan</label>
                                                                    <select class="form-select form-control-md <?= $fe ?>" data-control="select2" id="subdistrict" name="subdistrict">
                                                                        <option value="0">Pilih Kecamatan</option>
                                                                    </select>
                                                                    <?= $msg ?>
                                                                </div>        
                                                            </div>
                                                        </div>
                                                        <div class="row mb-5">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <?php 
                                                                        $fe = $le = $msg = '';
                                                                        if (session('valid') && array_key_exists("postal_code", session('valid'))) {
                                                                            $fe = "is-invalid";
                                                                            $le = 'text-danger';
                                                                            $msg = '<small class="text-danger">'.session('valid')['postal_code'].'</small>';
                                                                        }
                                                                    ?>
                                                                    <label class="required form-label <?= $le ?>">Kode Pos</label>
                                                                    <input type="number" class="form-control form-control-md <?= $fe ?>" value="<?= $row['school_postal_code'] ?>" name="postal_code" />
                                                                    <?= $msg ?>
                                                                </div>        
                                                            </div>
                                                        </div>
                                                        <div class="row mb-5">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Latitude</label>
                                                                    <input type="text" class="form-control form-control-md" value="<?= $row['school_map_latitude'] ?>" name="map_latitude" />
                                                                </div>        
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Longitude</label>
                                                                    <input type="text" class="form-control form-control-md" value="<?= $row['school_map_longitude'] ?>" name="map_longitude" />
                                                                </div>        
                                                            </div>
                                                        </div>
                                                        <div class="row mb-5">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <?php 
                                                                        $fe = $le = $msg = '';
                                                                        if (session('valid') && array_key_exists("address", session('valid'))) {
                                                                            $fe = "is-invalid";
                                                                            $le = 'text-danger';
                                                                            $msg = '<small class="text-danger">'.session('valid')['address'].'</small>';
                                                                        }
                                                                    ?>
                                                                    <label class="required form-label <?= $le ?>">Alamat Lengkap</label>
                                                                    <textarea class="form-control <?= $fe ?>" cols="30" rows="3" name="address"><?= $row['school_address'] ?></textarea>
                                                                    <?= $msg ?>
                                                                </div>        
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex flex-row-reverse">
                                                    <button type="submit" class="btn btn-success" id="submit-form">
                                                        <span class="indicator-label">
                                                            Simpan Perubahan
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalMaps" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modalMapsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMapsLabel">Maps</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="myMap" style="box-sizing: border-box;width:100%;height:500px;padding: 5px;"></div>
            </div>
        </div>
    </div>
</div>

<script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=AgH-zcVyIv80VQONSzKeM7UrveS7GSTwPFqTXn0zo_VTym_tPhiaLsGiRbL-nwPI' async defer></script>

<script type='text/javascript'>
    $(document).ready(function () {    
        if ($('#province').val() != 0) {
            let params = {
                'code': '<?= old('province') ? old('province') : $row['school_province'] ?>',
                'len': 5,
                'fillen': 2,
                'title': 'regency',
                'old': '<?= old('regency') ?  old('regency') : $row['school_regency'] ?>'
            }
            get_location(params);
        }

        const submitButton = document.querySelector('#submit-form');

        submitButton.addEventListener('click', function(event) {
            event.preventDefault();
            Swal.fire({
                text: "Apakah Anda yakin ingin menyimpan perubahan?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Simpan Perubahan!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.querySelector('.form').submit();
                }
            });
        });

        var imageUrlFp = "<?php echo base_url() . 'images/school/' . $row['school_logo']; ?>";
        var imageUrlTtd = "<?php echo base_url() . 'images/school/' . $row['school_principal_sign']; ?>";

        var imageWrapperFp = document.querySelector('.foto-profil-edit');
        var imageWrapperTtd = document.querySelector('.foto-ttd-edit');

        imageWrapperFp.style.backgroundImage = "url('" + imageUrlFp + "')";
        imageWrapperTtd.style.backgroundImage = "url('" + imageUrlTtd + "')";

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
        <?php elseif($stepper == 'last'): ?>
            stepper.goNext();
            stepper.goNext();
            stepper.goNext();
        <?php endif; ?>

        stepper.on("kt.stepper.click", function (stepper) {
            stepper.goTo(stepper.getClickedStepIndex()); 
        });

        stepper.on("kt.stepper.next", function (stepper) {
            stepper.goNext(); 
        });

        stepper.on("kt.stepper.previous", function (stepper) {
            stepper.goPrevious(); 
        });
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
            url: "<?= isset($url_territory) ? base_url($url_territory) : base_url('/sms/user/school/list_area') ?>",
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
                        'old': '<?= old('subdistrict') ? old('subdistrict') : $row['school_subdistrict'] ?>'
                    }

                    get_location(params)
                }
            },
        });
    };

    $('#logo').on('change', function () {
        let input = $('#logo').prop('files');
        if (input[0]) {

            let reader = new FileReader();

            reader.onload = function (e) {
                $('.logo-preview').attr('src', e.target.result);
            };

            reader.readAsDataURL(input[0]);
        }
        console.log(input[0]);
    })

    $('#imgttd').on('change', function () {
        let input = $('#imgttd').prop('files');
        if (input[0]) {

            let reader = new FileReader();

            reader.onload = function (e) {
                $('#ttdimg').attr('src', e.target.result);
            };

            reader.readAsDataURL(input[0]);
        }
        console.log(input[0]);
    })

    function GetMap() {
        var map = new Microsoft.Maps.Map(document.getElementById('myMap'), {
            center: new Microsoft.Maps.Location(-1.6352124445319873, 111.98814453917079),
            zoom: 5
        });
        Microsoft.Maps.Events.addHandler(map, 'click', function (e) { set_latitudes_and_longitude(e); });
    }

    function set_latitudes_and_longitude(map) {
        $('#lat').html(map.location.latitude)
        $('#long').html(map.location.longitude)
        $('input[name="map_latitude"]').val(map.location.latitude)
        $('input[name="map_longitude"]').val(map.location.longitude)
        $('#modalMaps').modal('toggle');
    }
</script>

<?php $this->endSection(); ?>