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
                                <img src="<?= !empty($row['teacher_image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/images/teacher/' . $row['teacher_image']) ? base_url() . 'images/teacher/' . $row['teacher_image'] : base_url('blaze-assets/media/avatars/blank.png') ?>" alt="Foto Guru">
                                <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                <div class="d-flex flex-column">
                                    <div class="d-flex align-items-center mb-2">
                                        <p class="text-gray-900 text-hover-primary fs-2 fw-bold me-1"><?= $row['teacher_first_name'] . ' ' . $row['teacher_last_name'] ?></p>
                                    </div>
                                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                        <p class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                        <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i><?= $row['teacher_first_name'] ?></p>
                                        <p class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                        <i class="ki-duotone ki-geolocation fs-4 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i><?php $join_date = new DateTime($row['teacher_created_at']); echo 'Terdaftar: ' . $join_date->format('d-m-Y'); ?></p>
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
                            <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="<?= base_url('sms/user/teacher/show/' . $data_id) ?>">Overview</a>
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
                                    Ubah Data Guru
                                </h4>
                            </div>
                        </div>
                        <?php
                            $stepper = "first";
                            $label1 = 'current';
                            $label2 = $label3 = $label4 = 'pending';
                            $step1 = 'current';
                            $step2 = $step3 = $step4 = "";
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
                                                                Kepegawaian
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
                                                                <label for="first_name" class="form-label">Nama Depan</label>
                                                                <input type="text" class="form-control form-control-md" name="first_name" id="first_name" value="<?= old('first_name') ? old('first_name') : $row['teacher_first_name'] ?>" readonly />
                                                            </div>
                                                            <div class="">    
                                                                <label for="last_name" class="form-label">Nama Belakang</label>
                                                                <input type="text" class="form-control form-control-md" name="last_name" id="last_name" value="<?= old('last_name') ? old('last_name') : $row['teacher_last_name'] ?>" readonly />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row">
                                                            <label for="gender" class="mb-5 form-label">Jenis Kelamin</label>
                                                            <br>
                                                            <div class="form-check form-check-custom form-check-solid me-10 form-check-inline">
                                                                <input class="form-check-input" type="radio" name="gender" value="1" id="opt1" <?= $row['teacher_gender'] == 1 ? 'checked' : '' ?> disabled />
                                                                <label class="form-check-label text-dark" for="opt1">
                                                                    Laki-laki
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-custom form-check-solid me-10 form-check-inline">
                                                                <input class="form-check-input" type="radio" name="gender" value="2" id="opt2" <?= $row['teacher_gender'] == 2 ? 'checked' : '' ?> disabled />
                                                                <label class="form-check-label text-dark" for="opt2">
                                                                    Perempuan
                                                                </label>
                                                            </div>
                                                            <br>
                                                        </div>
                                                        <div class="col-md-6 fv-row">
                                                            <label for="degree" class="form-label">Gelar Akademik</label>
                                                            <input type="text" class="form-control" name="degree" id="degree" value="<?= old('degree') ? old('degree') : $row['teacher_degree'] ?>" readonly >
                                                        </div>
                                                    </div>

                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row">
                                                            <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                                            <input type="date" class="form-control form-control-md" name="birth_date" id="birth_date" value="<?= old('birth_date') ? old('birth_date') : $row['teacher_birth_date'] ?>" readonly />
                                                        </div>
                                                        <div class="col-md-6 fv-row">                                                
                                                            <label for="religion" class="form-label required">Agama</label>
                                                            <select class="form-select form-control-md" id="religion" name="religion" disabled>
                                                                <option value="">Pilih Agama</option>
                                                                <?php foreach ($religion as $k => $v): ?>
                                                                    <option value="<?= $k ?>" <?= $row['teacher_religion'] == $k ? 'selected' : '' ?>>
                                                                        <?= $v ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="flex-column <?= $step2 ?>" data-kt-stepper-element="content">
                                                    <div class="mb-5">
                                                        <label for="phone" class="form-label">No HP</label>
                                                        <input inputmode="number" class="form-control form-control-md" name="phone" id="phone" value="<?= old('phone') ? old('phone') : $row['teacher_phone'] ?>" readonly />                                            
                                                    </div>

                                                    <div class="mb-5">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input inputmode="text" class="email form-control form-control-md" name="email" id="email" value="<?= old('email') ? old('email') : $row['user_email'] ?>" readonly />                                            
                                                    </div>
                                                </div>

                                                <div class="flex-column <?= $step3 ?>" data-kt-stepper-element="content">
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row">
                                                            <label for="province" class="form-label">Provinsi</label>
                                                            <input type="text" class="form-control form-control-md" value="<?= territory_name($row['teacher_province']) ?>" readonly />
                                                        </div>
                                                        <div class="col-md-6 fv-row">
                                                            <label for="regency" class="form-label">Kabupaten/Kota</label>
                                                            <input type="text" class="form-control form-control-md" value="<?= territory_name($row['teacher_regency']) ?>" readonly />
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 fv-row">
                                                            <label for="subdistrict" class="form-label">Kecamatan</label>
                                                            <input type="text" class="form-control form-control-md" value="<?= territory_name($row['teacher_subdistrict']) ?>" readonly />
                                                        </div>
                                                        <div class="col-md-6 fv-row">                                                
                                                            <label for="postal_code" class="form-label">Kode Pos</label>
                                                            <input type="number" class="form-control form-control-md" name="postal_code" id="postal_code" value="<?= old('postal_code') ? old('postal_code') : $row['teacher_postal_code'] ?>" readonly />
                                                        </div>
                                                    </div>

                                                    <div class="mb-5">                                            
                                                        <label for="address" class="form-label">Alamat Lengkap</label>
                                                        <textarea class="form-control" name="address" id="address" cols="30" rows="3" readonly ><?= old('address') ? old('address') : $row['teacher_address'] ?></textarea>                                            
                                                    </div>                                        
                                                </div>

                                                <div class="flex-column <?= $step4 ?>" data-kt-stepper-element="content">
                                                    <div class="row mb-5">
                                                        <label for="nip" class="form-label">NIP</label>
                                                        <input inputmode="number" class="number form-control" name="nip" id="nip" value="<?= old('nip') ? old('nip') : $row['teacher_nip'] ?>" readonly />
                                                    </div>
                                                    
                                                    <div class="row mb-5">                                            
                                                        <label for="nuptk" class="form-label">NUPTK</label>
                                                        <input inputmode="number" class="number form-control" name="nuptk" id="nuptk" value="<?= old('nuptk') ? old('nuptk') : $row['teacher_nuptk'] ?>" readonly />
                                                    </div>
                                                    
                                                    <div class="row mb-5">
                                                        <label for="nick_name" class="form-label required">Kode Guru/Nama Singkatan</label>
                                                        <input type="text" class="form-control" name="nick_name" id="nick_name" value="<?= old('nick_name') ? old('nick_name') : $row['teacher_nick_name'] ?>" readonly />
                                                    </div>
                                                    
                                                    <div class="mb-5">                                            
                                                        <label for="employment_status" class="mb-5 form-label">Status Kepegawaian</label>
                                                        <br>
                                                        <div class="form-check form-check-custom form-check-solid me-10 form-check-inline">
                                                            <input class="form-check-input" type="radio" name="employment_status" value="1" id="emp1" <?= $row['teacher_employment_status'] == 1 ? 'checked' : '' ?> disabled />
                                                            <label class="form-check-label text-dark" for="emp1">
                                                                PNS
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-custom form-check-solid me-10 form-check-inline">
                                                            <input class="form-check-input" type="radio" name="employment_status" value="2" id="emp2" <?= $row['teacher_employment_status'] == 2 ? 'checked' : '' ?> disabled />
                                                            <label class="form-check-label text-dark" for="emp2">
                                                                Tetap
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-custom form-check-solid me-10 form-check-inline">
                                                            <input class="form-check-input" type="radio" name="employment_status" value="3" id="emp3" <?= $row['teacher_employment_status'] == 3 ? 'checked' : '' ?> disabled />
                                                            <label class="form-check-label text-dark" for="emp3">
                                                                Honorer
                                                            </label>
                                                        </div>
                                                        <br>                                            
                                                    </div>
                                                    
                                                    <div class="mb-5">                                            
                                                        <label for="is_teaching" class="mb-5 form-label">Mengajar di kelas</label>
                                                        <br>
                                                        <div class="form-check form-check-custom form-check-solid me-10 form-check-inline">
                                                            <input class="form-check-input" type="radio" name="is_teaching" value="1" id="teach1" <?= $row['teacher_is_teaching'] == 1 ? 'checked' : '' ?> disabled />
                                                            <label class="form-check-label text-dark" for="teach1">
                                                                Ya
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-custom form-check-solid me-10 form-check-inline">
                                                            <input class="form-check-input" type="radio" name="is_teaching" value="2" id="teach2" <?= $row['teacher_is_teaching'] == 2 ? 'checked' : '' ?> disabled />
                                                            <label class="form-check-label text-dark" for="teach2">
                                                                Tidak
                                                            </label>
                                                        </div>
                                                        <br>                                            
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
</script>

<?php $this->endSection(); ?>