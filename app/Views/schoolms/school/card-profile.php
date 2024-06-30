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
                <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="<?= base_url('dashboard/school/show/' . userdata()['id_profile']) ?>">Overview</a>
            </li>
            <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5" href="<?= base_url('dashboard/school/change-password') ?>">Ganti Password</a>
            </li>
        </ul>
    </div>
</div>