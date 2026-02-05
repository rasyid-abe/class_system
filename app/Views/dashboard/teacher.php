<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>


<?php if (year_active() == null) : ?>
    <!-- <div class="alert alert-danger d-flex align-items-center p-5  my-xl-5">
        <i class="bi bi-exclamation-octagon-fill fs-2hx text-danger me4"></i>
        <div class="d-flex flex-column mx-4">
            <h4 class="mb-1 text-danger">Peringatan</h4>
            <span>Pilih tahun pelajaran untuk mengaktifkan seluruh Fitur</span>
        </div>
    </div> -->
<?php endif ?>

<input type="hidden" name="temp_day" value="<?= $days ?>">
<div class="row gx-5 gx-xl-10 my-xl-5">

    <div class="col-md-6 col-xl-3 my-xl-5">

        <div class="card h-lg-100 bg-hover-info mb-5" style="background-color: #192440" onclick="window.location.replace('<?= base_url('teacher/lesson/additional') ?>')">
            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                <div class="m-0">
                    <i class="text-white bi bi-grid-1x2-fill fs-2x"></i>
                </div>

                <div class="d-flex flex-column my-4">
                    <span class="fw-semibold fs-3x text-white lh-1 ls-n2"><span id="dash_t_chap">memuat ...</span></span>

                    <div class="m-0">
                        <span class="fw-semibold fs-6 text-white">BAB Pelajaran </span>
                    </div>
                </div>

                <!-- <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-start">
                    <i class="text-white bi bi-three-dots fs-2x"></i>
                </button> -->
            </div>
        </div>


    </div>

    <div class="col-sm-6 col-xl-3 my-xl-5">

        <div class="card h-lg-100 bg-hover-info mb-5" style="background-color: #192440" onclick="window.location.replace('<?= base_url('teacher/lesson/additional') ?>')">
            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                <div class="m-0">
                    <i class="text-white fas fa-tasks fs-2x"></i>
                </div>

                <div class="d-flex flex-column my-4">
                    <span class="fw-semibold fs-3x text-white lh-1 ls-n2"><span id="dash_t_subchap">memuat ...</span></span>

                    <div class="m-0">
                        <span class="fw-semibold fs-6 text-white">Topik Pelajaran </span>
                    </div>
                </div>

                <!-- <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-start">
                    <i class="text-white bi bi-three-dots fs-2x"></i>
                </button> -->
            </div>
        </div>


    </div>

    <div class="col-sm-6 col-xl-3 my-xl-5">

        <div class="card h-lg-100 bg-hover-info mb-5" style="background-color: #192440" onclick="window.location.replace('<?= base_url('teacher/question-bank/additional') ?>')">
            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                <div class="m-0">
                    <i class="text-white fas fa-th-list fs-2x"></i>
                </div>

                <div class="d-flex flex-column my-4">
                    <span class="fw-semibold fs-3x text-white lh-1 ls-n2"><span id="dash_t_tqb">memuat ...</span></span>

                    <div class="m-0">
                        <span class="fw-semibold fs-6 text-white">Judul Bank Soal </span>
                    </div>
                </div>
                <!-- 
                <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-start">
                    <i class="text-white bi bi-three-dots fs-2x"></i>
                </button> -->
            </div>
        </div>


    </div>

    <div class="col-sm-6 col-xl-3 my-xl-5">

        <div class="card h-lg-100 bg-hover-info mb-5" style="background-color: #192440" onclick="window.location.replace('<?= base_url('teacher/question-bank/additional') ?>')">
            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                <div class="m-0">
                    <i class="text-white bi bi-grid-3x3-gap-fill fs-2x"></i>
                </div>

                <div class="d-flex flex-column my-4">
                    <span class="fw-semibold fs-3x text-white lh-1 ls-n2"><span id="dash_t_qb">memuat ...</span></span>

                    <div class="m-0">
                        <span class="fw-semibold fs-6 text-white">Total Soal </span>
                    </div>
                </div>

                <!-- <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-start">
                    <i class="text-white bi bi-three-dots fs-2x"></i>
                </button> -->
            </div>
        </div>


    </div>

    <div class="checked_asstsk" id="checked_asstsk"></div>

    <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-4 my-xl-5">

        <div class="row">
            <div class="col-sm-12">
                <div class="card card-flush h-lg-70 mb-10">
                    <div class="card-header align-items-center border-0">
                        <h3 class="fw-bold text-gray-900 m-0">BAB Pelajaran</h3>

                        <!-- <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end">
                            <i class="bi bi-three-dots fs-1"></i>
                        </button> -->
                    </div>

                    <div class="card-body pt-2">

                        <div class="d-flex fw-semibold align-items-center mb-4">
                            <div class="bullet w-8px h-6px rounded-2 bg-primary me-3"></div>

                            <div class="text-gray-700 fw-semibold fs-6 flex-grow-1 me-4">Saya</div>

                            <div class="text-gray-900 fw-bolder text-xxl-end"><span id="dash_add_less">memuat ...</span></div>
                        </div>

                        <div class="d-flex fw-semibold align-items-center mb-4">
                            <div class="bullet w-8px h-6px rounded-2 bg-success me-3"></div>

                            <div class="text-gray-700 fw-semibold fs-6 flex-grow-1 me-4">Dibagikan</div>

                            <div class="text-gray-900 fw-bolder text-xxl-end"><span id="dash_chp_shared">memuat ...</span></div>
                        </div>

                        <div class="d-flex fw-semibold align-items-center mb-4">
                            <div class="bullet w-8px h-6px rounded-2 bg-info me-3"></div>

                            <div class="text-gray-700 fw-semibold fs-6 flex-grow-1 me-4">Sekolah</div>

                            <div class="text-gray-900 fw-bolder text-xxl-end"><span id="dash_sch_less">memuat ...</span></div>
                        </div>

                        <div class="d-flex fw-semibold align-items-center mb-4">
                            <div class="bullet w-8px h-6px rounded-2 bg-danger me-3"></div>

                            <div class="text-gray-700 fw-semibold fs-6 flex-grow-1 me-4">Publik</div>

                            <div class="text-gray-900 fw-bolder text-xxl-end"><span id="dash_pub_less">memuat ...</span></div>
                        </div>


                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card card-flush h-lg-100">
                    <div class="card-header align-items-center border-0">
                        <h3 class="fw-bold text-gray-900 m-0">Bank Soal</h3>

                        <!-- <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end">
                            <i class="bi bi-three-dots fs-1"></i>
                        </button> -->
                    </div>

                    <div class="card-body pt-2">

                        <div class="d-flex fw-semibold align-items-center">
                            <div class="bullet w-8px h-3px rounded-2 bg-primary me-3"></div>

                            <div class="text-gray-700 fw-semibold fs-6 flex-grow-1 me-4">Saya</div>

                            <div class="text-gray-900 fw-bolder text-xxl-end"><span id="t_qb_me">memuat ...</span></div>
                        </div>

                        <div class="separator separator-dashed my-3"></div>

                        <div class="d-flex fw-semibold align-items-center">
                            <div class="bullet w-8px h-3px rounded-2 bg-success me-3"></div>

                            <div class="text-gray-700 fw-semibold fs-6 flex-grow-1 me-4">Dibagikan</div>

                            <div class="text-gray-900 fw-bolder text-xxl-end"><span id="t_qb_shr">memuat ...</span></div>
                        </div>

                        <div class="separator separator-dashed my-3"></div>

                        <div class="d-flex fw-semibold align-items-center">
                            <div class="bullet w-8px h-3px rounded-2 bg-danger me-3"></div>

                            <div class="text-gray-700 fw-semibold fs-6 flex-grow-1 me-4">Publik</div>

                            <div class="text-gray-900 fw-bolder text-xxl-end"><span id="t_qb_pub">memuat ...</span></div>
                        </div>



                    </div>
                </div>
            </div>
        </div>


    </div>



    <div class="col-md-6 col-xl-4 my-xl-5">
        <div class="card h-md-100">
            <div class="card-header align-items-center border-0">
                <h3 class="fw-bold text-gray-900 m-0">Ringkasan Penilaian</h3>

                <!-- <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">

                    <i class="bi bi-three-dots fs-1"></i>
                </button>

                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">
                    <div class="menu-item px-3">
                        <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">Quick Actions</div>
                    </div>

                    <div class="separator mb-3 opacity-75"></div>

                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">
                            New Ticket
                        </a>
                    </div>

                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">
                            New Customer
                        </a>
                    </div>

                    <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
                        <a href="#" class="menu-link px-3">
                            <span class="menu-title">New Group</span>
                            <span class="menu-arrow"></span>
                        </a>

                        <div class="menu-sub menu-sub-dropdown w-175px py-4">
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">
                                    Admin Group
                                </a>
                            </div>

                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">
                                    Staff Group
                                </a>
                            </div>

                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">
                                    Member Group
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">
                            New Contact
                        </a>
                    </div>

                    <div class="separator mt-3 opacity-75"></div>

                    <div class="menu-item px-3">
                        <div class="menu-content px-3 py-3">
                            <a class="btn btn-primary  btn-sm px-4" href="#">
                                Generate Reports
                            </a>
                        </div>
                    </div>
                </div> -->

            </div>
            <div class="card-body pt-2">
                <div class="d-flex align-items-center mb-6">
                    <!-- <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-info"></span> -->
                    <!-- <i class="bi bi-file-earmark-text-fill text-info fs-3x"></i> -->
                    <i class="bi bi-file-earmark-post text-warning fs-3x"></i>
                    &nbsp;
                    <div class="flex-grow-1 me-5">
                        <div class="text-gray-800 fw-semibold fs-2">
                            <span id="as_draft">memuat ...</span>
                        </div>

                        <div class="text-gray-700 fw-semibold fs-6">
                            Draft</div>

                        <!-- <div class="text-gray-500 fw-semibold fs-7">
                            Lead by
                            <a href="#" class="text-primary opacity-75-hover fw-semibold">Peter Marcus</a>
                        </div> -->
                    </div>

                    <a href="<?= base_url('teacher/assessment/index-draft') ?>" class="btn btn-sm btn-light-primary btn-icon"><i class="bi bi-arrow-up-right-square fs-2x"></i></a>
                </div>
                <div class="separator my-5"></div>
                <div class="d-flex align-items-center mb-6">
                    <!-- <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-info"></span> -->
                    <i class="bi bi-file-earmark-spreadsheet-fill text-success fs-3x"></i>
                    &nbsp;
                    <div class="flex-grow-1 me-5">
                        <div class="text-gray-800 fw-semibold fs-2">
                            <span id="as_scheduled">memuat ...</span>
                        </div>

                        <div class="text-gray-700 fw-semibold fs-6">
                            Terjadwal</div>

                        <!-- <div class="text-gray-500 fw-semibold fs-7">
                            Lead by
                            <a href="#" class="text-primary opacity-75-hover fw-semibold">Peter Marcus</a>
                        </div> -->
                    </div>

                    <a href="<?= base_url('teacher/assessment/index-scheduled') ?>" class="btn btn-sm btn-light-primary btn-icon"><i class="bi bi-arrow-up-right-square fs-2x"></i></a>
                </div>
                <div class="separator my-5"></div>
                <div class="d-flex align-items-center mb-6">
                    <!-- <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-info"></span> -->
                    <i class="bi bi-file-earmark-text-fill text-info fs-3x"></i>
                    &nbsp;
                    <div class="flex-grow-1 me-5">
                        <div class="text-gray-800 fw-semibold fs-2">
                            <span id="as_present">memuat ...</span>
                        </div>

                        <div class="text-gray-700 fw-semibold fs-6">
                            Saat Ini</div>

                        <!-- <div class="text-gray-500 fw-semibold fs-7">
                            Lead by
                            <a href="#" class="text-primary opacity-75-hover fw-semibold">Peter Marcus</a>
                        </div> -->
                    </div>

                    <a href="<?= base_url('teacher/assessment/index-present') ?>" class="btn btn-sm btn-light-primary btn-icon"><i class="bi bi-arrow-up-right-square fs-2x"></i></a>
                </div>
                <div class="separator my-5"></div>
                <div class="d-flex align-items-center mb-6">
                    <!-- <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-info"></span> -->
                    <i class="bi bi-file-earmark-check-fill text-danger fs-3x"></i>
                    &nbsp;
                    <div class="flex-grow-1 me-5">
                        <div class="text-gray-800 fw-semibold fs-2">
                            <span id="as_done">memuat ...</span>
                        </div>

                        <div class="text-gray-700 fw-semibold fs-6">
                            Selesai</div>

                        <!-- <div class="text-gray-500 fw-semibold fs-7">
                            Lead by
                            <a href="#" class="text-primary opacity-75-hover fw-semibold">Peter Marcus</a>
                        </div> -->
                    </div>

                    <a href="<?= base_url('teacher/assessment/index-done') ?>" class="btn btn-sm btn-light-primary btn-icon"><i class="bi bi-arrow-up-right-square fs-2x"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-4 my-xl-5">
        <div class="card h-md-100">
            <div class="card-header align-items-center border-0">
                <h3 class="fw-bold text-gray-900 m-0">Ringkasan Tugas</h3>

                <!-- <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">

                    <i class="bi bi-three-dots fs-1"></i>
                </button>

                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">
                    <div class="menu-item px-3">
                        <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">Quick Actions</div>
                    </div>

                    <div class="separator mb-3 opacity-75"></div>

                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">
                            New Ticket
                        </a>
                    </div>

                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">
                            New Customer
                        </a>
                    </div>

                    <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
                        <a href="#" class="menu-link px-3">
                            <span class="menu-title">New Group</span>
                            <span class="menu-arrow"></span>
                        </a>

                        <div class="menu-sub menu-sub-dropdown w-175px py-4">
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">
                                    Admin Group
                                </a>
                            </div>

                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">
                                    Staff Group
                                </a>
                            </div>

                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">
                                    Member Group
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">
                            New Contact
                        </a>
                    </div>

                    <div class="separator mt-3 opacity-75"></div>

                    <div class="menu-item px-3">
                        <div class="menu-content px-3 py-3">
                            <a class="btn btn-primary  btn-sm px-4" href="#">
                                Generate Reports
                            </a>
                        </div>
                    </div>
                </div> -->

            </div>
            <div class="card-body pt-2">
                <div class="d-flex align-items-center mb-6">
                    <!-- <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-info"></span> -->
                    <!-- <i class="bi bi-file-earmark-text-fill text-info fs-3x"></i> -->
                    <i class="bi bi-file-earmark-post text-warning fs-3x"></i>
                    &nbsp;
                    <div class="flex-grow-1 me-5">
                        <div class="text-gray-800 fw-semibold fs-2">
                            <span id="tk_draft">memuat ...</span>
                        </div>

                        <div class="text-gray-700 fw-semibold fs-6">
                            Draft</div>

                        <!-- <div class="text-gray-500 fw-semibold fs-7">
                            Lead by
                            <a href="#" class="text-primary opacity-75-hover fw-semibold">Peter Marcus</a>
                        </div> -->
                    </div>

                    <a href="<?= base_url('teacher/task/index-draft') ?>" class="btn btn-sm btn-light-primary btn-icon"><i class="bi bi-arrow-up-right-square fs-2x"></i></a>
                </div>
                <div class="separator my-5"></div>
                <div class="d-flex align-items-center mb-6">
                    <!-- <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-info"></span> -->
                    <i class="bi bi-file-earmark-spreadsheet-fill text-success fs-3x"></i>
                    &nbsp;
                    <div class="flex-grow-1 me-5">
                        <div class="text-gray-800 fw-semibold fs-2">
                            <span id="tk_scheduled">memuat ...</span>
                        </div>

                        <div class="text-gray-700 fw-semibold fs-6">
                            Terjadwal</div>

                        <!-- <div class="text-gray-500 fw-semibold fs-7">
                            Lead by
                            <a href="#" class="text-primary opacity-75-hover fw-semibold">Peter Marcus</a>
                        </div> -->
                    </div>

                    <a href="<?= base_url('teacher/task/index-scheduled') ?>" class="btn btn-sm btn-light-primary btn-icon"><i class="bi bi-arrow-up-right-square fs-2x"></i></a>
                </div>
                <div class="separator my-5"></div>
                <div class="d-flex align-items-center mb-6">
                    <!-- <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-info"></span> -->
                    <i class="bi bi-file-earmark-text-fill text-info fs-3x"></i>
                    &nbsp;
                    <div class="flex-grow-1 me-5">
                        <div class="text-gray-800 fw-semibold fs-2">
                            <span id="tk_present">memuat ...</span>
                        </div>

                        <div class="text-gray-700 fw-semibold fs-6">
                            Saat Ini</div>

                        <!-- <div class="text-gray-500 fw-semibold fs-7">
                            Lead by
                            <a href="#" class="text-primary opacity-75-hover fw-semibold">Peter Marcus</a>
                        </div> -->
                    </div>

                    <a href="<?= base_url('teacher/task/index-present') ?>" class="btn btn-sm btn-light-primary btn-icon"><i class="bi bi-arrow-up-right-square fs-2x"></i></a>
                </div>
                <div class="separator my-5"></div>
                <div class="d-flex align-items-center mb-6">
                    <!-- <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-info"></span> -->
                    <i class="bi bi-file-earmark-check-fill text-danger fs-3x"></i>
                    &nbsp;
                    <div class="flex-grow-1 me-5">
                        <div class="text-gray-800 fw-semibold fs-2">
                            <span id="tk_done">memuat ...</span>
                        </div>

                        <div class="text-gray-700 fw-semibold fs-6">
                            Selesai</div>

                        <!-- <div class="text-gray-500 fw-semibold fs-7">
                            Lead by
                            <a href="#" class="text-primary opacity-75-hover fw-semibold">Peter Marcus</a>
                        </div> -->
                    </div>

                    <a href="<?= base_url('teacher/task/index-done') ?>" class="btn btn-sm btn-light-primary btn-icon"><i class="bi bi-arrow-up-right-square fs-2x"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- 
    <div class="col-md-6 col-xl-12 my-xl-5">
        <div class="card h-md-100">
            <div class="card-header align-items-center border-0">
                <h3 class="fw-bold text-gray-900 m-0">Informasi Terkini</h3>

                <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">

                    <i class="bi bi-three-dots fs-1"></i>
                </button>

                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">
                    <div class="menu-item px-3">
                        <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">Quick Actions</div>
                    </div>

                    <div class="separator mb-3 opacity-75"></div>

                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">
                            New Ticket
                        </a>
                    </div>

                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">
                            New Customer
                        </a>
                    </div>

                    <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
                        <a href="#" class="menu-link px-3">
                            <span class="menu-title">New Group</span>
                            <span class="menu-arrow"></span>
                        </a>

                        <div class="menu-sub menu-sub-dropdown w-175px py-4">
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">
                                    Admin Group
                                </a>
                            </div>

                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">
                                    Staff Group
                                </a>
                            </div>

                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">
                                    Member Group
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">
                            New Contact
                        </a>
                    </div>

                    <div class="separator mt-3 opacity-75"></div>

                    <div class="menu-item px-3">
                        <div class="menu-content px-3 py-3">
                            <a class="btn btn-primary  btn-sm px-4" href="#">
                                Generate Reports
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-body pt-2 d-grid gap-3">
                <div class="d-flex flex-column align-items-start">
                    <div class="d-flex align-items-center mb-2">
                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" data-bs-original-title="Alan Warden" data-kt-initialized="1">
                            <span class="symbol-label bg-warning text-inverse-warning fw-bold">A</span>
                        </div>
                        <div class="ms-3">
                            <a href="#" class="fs-6 fw-bold text-gray-900 text-hover-primary me-1">Brian Cox</a>
                            <span class="text-muted fs-7 mb-1">2 mins</span>
                        </div>

                    </div>

                    <div class="p-5 rounded bg-light-info text-gray-900 fw-semibold text-start" data-kt-element="message-text">
                        <h4>Judul Informasi</h4>
                        How likely are you to recommend our company How likely are you to recommend our company to your friends and family ?
                        <a href="">Selengkapnya</a>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-start">
                    <div class="d-flex align-items-center mb-2">
                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" data-bs-original-title="Alan Warden" data-kt-initialized="1">
                            <span class="symbol-label bg-warning text-inverse-warning fw-bold">A</span>
                        </div>
                        <div class="ms-3">
                            <a href="#" class="fs-6 fw-bold text-gray-900 text-hover-primary me-1">Brian Cox</a>
                            <span class="text-muted fs-7 mb-1">2 mins</span>
                        </div>

                    </div>

                    <div class="p-5 rounded bg-light-info text-gray-900 fw-semibold text-start" data-kt-element="message-text">
                        <h4>Judul Informasi</h4>
                        How likely are you to recommend our company How likely are you to recommend our company to your friends and family ?
                        <a href="">Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->


</div>

<div class="row gx-5 gx-xl-10 my-xl-5">
   <div class="col-sm-12">
        <div class="card mb-5 mb-xl-10" data-select2-id="select2-data-149-yjw4">
            <div class="card-header" data-select2-id="select2-data-148-fypg">
                <div class="card-title">
                    <h3>Aktivitas Terakhir</h3>
                </div>

                <div class="card-toolbar">
                    <a href="<?= base_url('teacher/activity') ?>" class="btn btn-sm btn-primary my-1">
                        Lihat
                    </a>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-row-bordered table-row-solid gy-4 gs-9">
                        <thead class="border-gray-200 fs-5 fw-semibold bg-lighten">
                            <tr>
                                <th class="min-w-150px">Waktu</th>
                                <th class="min-w-150px">Halaman</th>
                                <th class="min-w-150px">Keterangan</th>
                            </tr>
                        </thead>

                        <tbody class="fw-6 fw-semibold text-gray-600">
                            <?php foreach($activity as $k => $v): ?>
                                <tr>
                                    <td><?= datetime_indo($v['activity_timestamp']) ?></td>
                                    <td><?= $v['activity_page'] ?></td>
                                    <td><?= $v['activity_desc'] ?></td>
                                </tr>
                            
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- 
    <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-10">

        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-center border-0 h-md-50 mb-5 my-xl-5" style="background-color: #080655">
            <div class="card-header align-items-center border-0">
                <h3 class="fw-bold text-white m-0">Saya Berbagi</h3>

                <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end">
                    <i class="bi bi-three-dots fs-1"></i>
                </button>
            </div>

            <div class="card-body">
                <div class="card-title d-flex flex-column">
                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2"><span id="dash_chp_shared">memuat ...</span></span>

                    <span class="text-white opacity-50 pt-1 fw-semibold fs-6">Topik Pelajaran</span>
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="card-title d-flex flex-column">
                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2"><span id="dash_schp_shared">memuat ...</span></span>

                    <span class="text-white opacity-50 pt-1 fw-semibold fs-6">Judul Bank Soal</span>
                </div>
            </div>
        </div>

        <div class="card card-flush h-md-50 mb-5 my-xl-5"  style="background-color: #080655">
            <div class="card-header pt-5">
                <div class="card-title d-flex flex-column">
                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">357</span>

                    <span class="text-white pt-1 fw-semibold fs-6">Lampiran Dokumen</span>
                </div>
            </div>

            <div class="card-body d-flex flex-column justify-content-end pe-0">
                <div class="symbol-group symbol-hover flex-nowrap">
                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" data-bs-original-title="Alan Warden" data-kt-initialized="1">
                        <span class="symbol-label bg-warning text-inverse-warning fw-bold">A</span>
                    </div>
                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" data-bs-original-title="Susan Redwood" data-kt-initialized="1">
                        <span class="symbol-label bg-primary text-inverse-primary fw-bold">S</span>
                    </div>
                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" data-bs-original-title="Perry Matthew" data-kt-initialized="1">
                        <span class="symbol-label bg-danger text-inverse-danger fw-bold">P</span>
                    </div>
                    <a href="#" class="symbol symbol-35px symbol-circle" data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">
                        <span class="symbol-label bg-dark text-gray-300 fs-8 fw-bold">+42</span>
                    </a>
                </div>
            </div>
        </div>
    </div> -->



</div>




<?php $this->endSection(); ?>