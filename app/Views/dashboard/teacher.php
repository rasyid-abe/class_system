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

        <div class="card h-lg-100 bg-hover-info" style="background-color: #192440" onclick="window.location.replace('<?= base_url('teacher/lesson/additional') ?>')">
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

        <div class="card h-lg-100 bg-hover-info" style="background-color: #192440" onclick="window.location.replace('<?= base_url('teacher/lesson/additional') ?>')">
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

        <div class="card h-lg-100 bg-hover-info" style="background-color: #192440" onclick="window.location.replace('<?= base_url('teacher/question-bank/additional') ?>')">
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

        <div class="card h-lg-100 bg-hover-info" style="background-color: #192440" onclick="window.location.replace('<?= base_url('teacher/question-bank/additional') ?>')">
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

                        <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end">
                            <i class="bi bi-three-dots fs-1"></i>
                        </button>
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

                        <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end">
                            <i class="bi bi-three-dots fs-1"></i>
                        </button>
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

    <div class="col-lg-12 col-xl-12 col-xxl-8 my-5">

        <div class="card">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Jadwal Hari Ini</span>

                    <span class="text-muted mt-1 fw-semibold fs-7">Total 424,567 deliveries</span>
                </h3>

                <div class="card-toolbar">
                    <a href="#" class="btn btn-sm btn-light">Report Cecnter</a>
                </div>
            </div>

            <div class="card-body pt-7 px-0">
                <ul class="nav nav-stretch nav-pills nav-pills-custom nav-pills-active-custom d-flex justify-content-between mb-8 px-5" role="tablist">
                    <li class="nav-item p-0 ms-0" role="presentation">
                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px py-4 px-3 btn-active-danger " data-bs-toggle="tab" href="#kt_timeline_widget_3_tab_content_1" aria-selected="false" tabindex="-1" role="tab">
                            <span class="fs-7 fw-semibold">Fr</span>
                            <span class="fs-6 fw-bold">20</span>
                        </a>
                    </li>
                    <li class="nav-item p-0 ms-0" role="presentation">
                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px py-4 px-3 btn-active-danger " data-bs-toggle="tab" href="#kt_timeline_widget_3_tab_content_2" aria-selected="false" tabindex="-1" role="tab">
                            <span class="fs-7 fw-semibold">Sa</span>
                            <span class="fs-6 fw-bold">21</span>
                        </a>
                    </li>
                    <li class="nav-item p-0 ms-0" role="presentation">
                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px py-4 px-3 btn-active-danger " data-bs-toggle="tab" href="#kt_timeline_widget_3_tab_content_3" aria-selected="false" tabindex="-1" role="tab">
                            <span class="fs-7 fw-semibold">Su</span>
                            <span class="fs-6 fw-bold">22</span>
                        </a>
                    </li>
                    <li class="nav-item p-0 ms-0" role="presentation">
                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px py-4 px-3 btn-active-danger active" data-bs-toggle="tab" href="#kt_timeline_widget_3_tab_content_4" aria-selected="true" role="tab">
                            <span class="fs-7 fw-semibold">Tu</span>
                            <span class="fs-6 fw-bold">23</span>
                        </a>
                    </li>
                    <li class="nav-item p-0 ms-0" role="presentation">
                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px py-4 px-3 btn-active-danger " data-bs-toggle="tab" href="#kt_timeline_widget_3_tab_content_5" aria-selected="false" tabindex="-1" role="tab">
                            <span class="fs-7 fw-semibold">Tu</span>
                            <span class="fs-6 fw-bold">24</span>
                        </a>
                    </li>
                    <li class="nav-item p-0 ms-0" role="presentation">
                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px py-4 px-3 btn-active-danger " data-bs-toggle="tab" href="#kt_timeline_widget_3_tab_content_6" aria-selected="false" tabindex="-1" role="tab">
                            <span class="fs-7 fw-semibold">We</span>
                            <span class="fs-6 fw-bold">25</span>
                        </a>
                    </li>
                    <li class="nav-item p-0 ms-0" role="presentation">
                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px py-4 px-3 btn-active-danger " data-bs-toggle="tab" href="#kt_timeline_widget_3_tab_content_7" aria-selected="false" tabindex="-1" role="tab">
                            <span class="fs-7 fw-semibold">Th</span>
                            <span class="fs-6 fw-bold">26</span>
                        </a>
                    </li>
                    <li class="nav-item p-0 ms-0" role="presentation">
                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px py-4 px-3 btn-active-danger " data-bs-toggle="tab" href="#kt_timeline_widget_3_tab_content_8" aria-selected="false" tabindex="-1" role="tab">
                            <span class="fs-7 fw-semibold">Fri</span>
                            <span class="fs-6 fw-bold">27</span>
                        </a>
                    </li>
                    <li class="nav-item p-0 ms-0" role="presentation">
                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px py-4 px-3 btn-active-danger " data-bs-toggle="tab" href="#kt_timeline_widget_3_tab_content_9" aria-selected="false" tabindex="-1" role="tab">
                            <span class="fs-7 fw-semibold">Sa</span>
                            <span class="fs-6 fw-bold">28</span>
                        </a>
                    </li>
                    <li class="nav-item p-0 ms-0" role="presentation">
                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px py-4 px-3 btn-active-danger " data-bs-toggle="tab" href="#kt_timeline_widget_3_tab_content_10" aria-selected="false" tabindex="-1" role="tab">
                            <span class="fs-7 fw-semibold">Su</span>
                            <span class="fs-6 fw-bold">29</span>
                        </a>
                    </li>
                    <li class="nav-item p-0 ms-0" role="presentation">
                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px py-4 px-3 btn-active-danger " data-bs-toggle="tab" href="#kt_timeline_widget_3_tab_content_11" aria-selected="false" tabindex="-1" role="tab">
                            <span class="fs-7 fw-semibold">Mo</span>
                            <span class="fs-6 fw-bold">30</span>
                        </a>
                    </li>

                </ul>

                <div class="tab-content mb-2 px-9">
                    <div class="tab-pane fade show active" id="kt_timeline_widget_3_tab_content_4" role="tabpanel">

                        <div class="d-flex align-items-center mb-6">
                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-info"></span>

                            <div class="flex-grow-1 me-5">
                                <div class="text-gray-800 fw-semibold fs-2">
                                    10:20 - 11:00
                                    <span class="text-gray-500 fw-semibold fs-7">
                                        AM </span>
                                </div>

                                <div class="text-gray-700 fw-semibold fs-6">
                                    9 Degree Project Estimation Meeting </div>

                                <div class="text-gray-500 fw-semibold fs-7">
                                    Lead by
                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Peter Marcus</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>
                        </div>

                        <div class="d-flex align-items-center mb-6">
                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-warning"></span>

                            <div class="flex-grow-1 me-5">
                                <div class="text-gray-800 fw-semibold fs-2">
                                    16:30 - 17:00
                                    <span class="text-gray-500 fw-semibold fs-7">
                                        PM </span>
                                </div>

                                <div class="text-gray-700 fw-semibold fs-6">
                                    Dashboard UI/UX Design Review </div>

                                <div class="text-gray-500 fw-semibold fs-7">
                                    Lead by
                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Lead by Bob</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>
                        </div>

                        <div class="d-flex align-items-center mb-6">
                            <span data-kt-element="bullet" class="bullet bullet-vertical d-flex align-items-center min-h-70px mh-100 me-4 bg-success"></span>

                            <div class="flex-grow-1 me-5">
                                <div class="text-gray-800 fw-semibold fs-2">
                                    12:00 - 13:40
                                    <span class="text-gray-500 fw-semibold fs-7">
                                        AM </span>
                                </div>

                                <div class="text-gray-700 fw-semibold fs-6">
                                    Marketing Campaign Discussion </div>

                                <div class="text-gray-500 fw-semibold fs-7">
                                    Lead by
                                    <a href="#" class="text-primary opacity-75-hover fw-semibold">Lead by Mark Morris</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">View</a>
                        </div>
                    </div>
                </div>

                <div class="float-end d-none">
                    <a href="#" class="btn btn-sm btn-light me-2" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">Add Lesson</a>

                    <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Call Sick for Today</a>
                </div>
            </div>
        </div>




        <div class="card card-flush d-none h-md-100">
            <div class="card-header mt-6">
                <div class="card-title flex-column">
                    <h3 class="fw-bold mb-1">What's on the road?</h3>

                    <div class="fs-6 text-gray-500">Total 482 participants</div>
                </div>

                <div class="card-toolbar">
                    <select name="status" data-control="select2" data-hide-search="true" class="form-select form-select-solid form-select-sm fw-bold w-100px select2-hidden-accessible" data-select2-id="select2-data-9-pt1g" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                        <option value="1" selected="" data-select2-id="select2-data-11-brzj">Options</option>
                        <option value="2">Option 1</option>
                        <option value="3">Option 2</option>
                        <option value="4">Option 3</option>
                    </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-10-yxcs" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-solid form-select-sm fw-bold w-100px" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-status-wz-container" aria-controls="select2-status-wz-container"><span class="select2-selection__rendered" id="select2-status-wz-container" role="textbox" aria-readonly="true" title="Options">Options</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                </div>
            </div>

            <div class="card-body p-0">
                <ul class="nav nav-pills d-flex flex-nowrap hover-scroll-x py-2 ms-4" role="tablist">

                    <li class="nav-item me-1" role="presentation">
                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-color-active-white btn-active-danger " data-bs-toggle="tab" href="#kt_schedule_day_0" aria-selected="false" tabindex="-1" role="tab">

                            <span class="text-gray-500 fs-7 fw-semibold">Fr</span>
                            <span class="fs-6 text-gray-800 fw-bold">20</span>
                        </a>
                    </li>

                    <li class="nav-item me-1" role="presentation">
                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-color-active-white btn-active-danger " data-bs-toggle="tab" href="#kt_schedule_day_1" aria-selected="false" tabindex="-1" role="tab">

                            <span class="text-gray-500 fs-7 fw-semibold">Sa</span>
                            <span class="fs-6 text-gray-800 fw-bold">21</span>
                        </a>
                    </li>

                    <li class="nav-item me-1" role="presentation">
                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-color-active-white btn-active-danger " data-bs-toggle="tab" href="#kt_schedule_day_2" aria-selected="false" tabindex="-1" role="tab">

                            <span class="text-gray-500 fs-7 fw-semibold">Su</span>
                            <span class="fs-6 text-gray-800 fw-bold">22</span>
                        </a>
                    </li>

                    <li class="nav-item me-1" role="presentation">
                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-color-active-white btn-active-danger active" data-bs-toggle="tab" href="#kt_schedule_day_3" aria-selected="true" role="tab">

                            <span class="text-gray-500 fs-7 fw-semibold">Mo</span>
                            <span class="fs-6 text-gray-800 fw-bold">23</span>
                        </a>
                    </li>

                    <li class="nav-item me-1" role="presentation">
                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-color-active-white btn-active-danger " data-bs-toggle="tab" href="#kt_schedule_day_4" aria-selected="false" tabindex="-1" role="tab">

                            <span class="text-gray-500 fs-7 fw-semibold">Tu</span>
                            <span class="fs-6 text-gray-800 fw-bold">24</span>
                        </a>
                    </li>

                    <li class="nav-item me-1" role="presentation">
                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-color-active-white btn-active-danger " data-bs-toggle="tab" href="#kt_schedule_day_5" aria-selected="false" tabindex="-1" role="tab">

                            <span class="text-gray-500 fs-7 fw-semibold">We</span>
                            <span class="fs-6 text-gray-800 fw-bold">25</span>
                        </a>
                    </li>

                    <li class="nav-item me-1" role="presentation">
                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-color-active-white btn-active-danger " data-bs-toggle="tab" href="#kt_schedule_day_6" aria-selected="false" tabindex="-1" role="tab">

                            <span class="text-gray-500 fs-7 fw-semibold">Th</span>
                            <span class="fs-6 text-gray-800 fw-bold">26</span>
                        </a>
                    </li>

                    <li class="nav-item me-1" role="presentation">
                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-color-active-white btn-active-danger " data-bs-toggle="tab" href="#kt_schedule_day_7" aria-selected="false" tabindex="-1" role="tab">

                            <span class="text-gray-500 fs-7 fw-semibold">Fr</span>
                            <span class="fs-6 text-gray-800 fw-bold">27</span>
                        </a>
                    </li>

                    <li class="nav-item me-1" role="presentation">
                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-color-active-white btn-active-danger " data-bs-toggle="tab" href="#kt_schedule_day_8" aria-selected="false" tabindex="-1" role="tab">

                            <span class="text-gray-500 fs-7 fw-semibold">Sa</span>
                            <span class="fs-6 text-gray-800 fw-bold">28</span>
                        </a>
                    </li>

                    <li class="nav-item me-1" role="presentation">
                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-color-active-white btn-active-danger " data-bs-toggle="tab" href="#kt_schedule_day_9" aria-selected="false" tabindex="-1" role="tab">

                            <span class="text-gray-500 fs-7 fw-semibold">Su</span>
                            <span class="fs-6 text-gray-800 fw-bold">29</span>
                        </a>
                    </li>

                    <li class="nav-item me-1" role="presentation">
                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-color-active-white btn-active-danger " data-bs-toggle="tab" href="#kt_schedule_day_10" aria-selected="false" tabindex="-1" role="tab">

                            <span class="text-gray-500 fs-7 fw-semibold">Mo</span>
                            <span class="fs-6 text-gray-800 fw-bold">30</span>
                        </a>
                    </li>

                    <li class="nav-item me-1" role="presentation">
                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-color-active-white btn-active-danger " data-bs-toggle="tab" href="#kt_schedule_day_11" aria-selected="false" tabindex="-1" role="tab">

                            <span class="text-gray-500 fs-7 fw-semibold">Tu</span>
                            <span class="fs-6 text-gray-800 fw-bold">31</span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content px-9">
                    <div id="kt_schedule_day_0" class="tab-pane fade show " role="tabpanel">
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    16:30 - 17:30

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        pm </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Weekly Team Stand-Up </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Mark Randall</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    13:00 - 14:00

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        pm </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Team Backlog Grooming Session </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Kendell Trevor</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    14:30 - 15:30

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        pm </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Dashboard UI/UX Design Review </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Sean Bean</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                    </div>
                    <div id="kt_schedule_day_1" class="tab-pane fade show active" role="tabpanel">
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    11:00 - 11:45

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        am </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Sales Pitch Proposal </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">David Stevenson</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    10:00 - 11:00

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        am </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Project Review &amp; Testing </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Michael Walters</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    13:00 - 14:00

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        pm </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Sales Pitch Proposal </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Kendell Trevor</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                    </div>
                    <div id="kt_schedule_day_2" class="tab-pane fade show " role="tabpanel">
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    9:00 - 10:00

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        am </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Development Team Capacity Review </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Kendell Trevor</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    13:00 - 14:00

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        pm </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Dashboard UI/UX Design Review </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Karina Clarke</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    9:00 - 10:00

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        am </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Marketing Campaign Discussion </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Naomi Hayabusa</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                    </div>
                    <div id="kt_schedule_day_3" class="tab-pane fade show " role="tabpanel">
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    12:00 - 13:00

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        pm </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Creative Content Initiative </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Yannis Gloverson</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    16:30 - 17:30

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        pm </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Project Review &amp; Testing </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Walter White</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    11:00 - 11:45

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        am </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Weekly Team Stand-Up </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Peter Marcus</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                    </div>
                    <div id="kt_schedule_day_4" class="tab-pane fade show " role="tabpanel">
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    12:00 - 13:00

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        pm </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Sales Pitch Proposal </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Michael Walters</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    11:00 - 11:45

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        am </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Weekly Team Stand-Up </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Terry Robins</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    12:00 - 13:00

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        pm </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Committee Review Approvals </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Naomi Hayabusa</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                    </div>
                    <div id="kt_schedule_day_5" class="tab-pane fade show " role="tabpanel">
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    11:00 - 11:45

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        am </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Creative Content Initiative </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Bob Harris</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    12:00 - 13:00

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        pm </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Project Review &amp; Testing </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Naomi Hayabusa</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    12:00 - 13:00

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        pm </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Lunch &amp; Learn Catch Up </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Karina Clarke</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                    </div>
                    <div id="kt_schedule_day_6" class="tab-pane fade show " role="tabpanel">
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    9:00 - 10:00

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        am </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    9 Degree Project Estimation Meeting </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">David Stevenson</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    14:30 - 15:30

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        pm </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Project Review &amp; Testing </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Walter White</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    11:00 - 11:45

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        am </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Team Backlog Grooming Session </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Walter White</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                    </div>
                    <div id="kt_schedule_day_7" class="tab-pane fade show " role="tabpanel">
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    13:00 - 14:00

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        pm </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Weekly Team Stand-Up </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">David Stevenson</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    11:00 - 11:45

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        am </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    9 Degree Project Estimation Meeting </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Michael Walters</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    12:00 - 13:00

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        pm </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Dashboard UI/UX Design Review </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Yannis Gloverson</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                    </div>
                    <div id="kt_schedule_day_8" class="tab-pane fade show " role="tabpanel">
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    16:30 - 17:30

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        pm </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Dashboard UI/UX Design Review </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Walter White</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    12:00 - 13:00

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        pm </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Marketing Campaign Discussion </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Naomi Hayabusa</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    12:00 - 13:00

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        pm </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Sales Pitch Proposal </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Walter White</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                    </div>
                    <div id="kt_schedule_day_9" class="tab-pane fade show " role="tabpanel">
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    9:00 - 10:00

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        am </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Team Backlog Grooming Session </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Mark Randall</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    13:00 - 14:00

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        pm </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Weekly Team Stand-Up </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Naomi Hayabusa</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    12:00 - 13:00

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        pm </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Project Review &amp; Testing </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Terry Robins</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                    </div>
                    <div id="kt_schedule_day_10" class="tab-pane fade show " role="tabpanel">
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    13:00 - 14:00

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        pm </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Team Backlog Grooming Session </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Terry Robins</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    11:00 - 11:45

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        am </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Marketing Campaign Discussion </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Sean Bean</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    16:30 - 17:30

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        pm </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    9 Degree Project Estimation Meeting </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Karina Clarke</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                    </div>
                    <div id="kt_schedule_day_11" class="tab-pane fade show " role="tabpanel">
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    14:30 - 15:30

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        pm </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Creative Content Initiative </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Michael Walters</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    9:00 - 10:00

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        am </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Team Backlog Grooming Session </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Michael Walters</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>

                            <div class="fw-semibold ms-5 text-gray-600">
                                <div class="fs-5">
                                    10:00 - 11:00

                                    <span class="fs-7 text-gray-500 text-uppercase">
                                        am </span>
                                </div>

                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    Sales Pitch Proposal </a>

                                <div class="text-gray-500">
                                    Lead by <a href="#">Karina Clarke</a>
                                </div>
                            </div>

                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3 my-xl-5">
        <div class="card h-md-100">
            <div class="card-header align-items-center border-0">
                <h3 class="fw-bold text-gray-900 m-0">Ringkasan Penilaian</h3>

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

                    <a href="#" class="btn btn-sm btn-light-primary btn-icon" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project"><i class="bi bi-file-earmark-post"></i></a>
                </div>
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

                    <a href="#" class="btn btn-sm btn-light-primary btn-icon" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project"><i class="bi bi-file-earmark-post"></i></a>
                </div>
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

                    <a href="#" class="btn btn-sm btn-light-primary btn-icon" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project"><i class="bi bi-file-earmark-post"></i></a>
                </div>
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

                    <a href="#" class="btn btn-sm btn-light-primary btn-icon" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project"><i class="bi bi-file-earmark-post"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3 my-xl-5">
        <div class="card h-md-100">
            <div class="card-header align-items-center border-0">
                <h3 class="fw-bold text-gray-900 m-0">Ringkasan Tugas</h3>

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

                    <a href="#" class="btn btn-sm btn-light-primary btn-icon" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project"><i class="bi bi-file-earmark-post"></i></a>
                </div>
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

                    <a href="#" class="btn btn-sm btn-light-primary btn-icon" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project"><i class="bi bi-file-earmark-post"></i></a>
                </div>
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

                    <a href="#" class="btn btn-sm btn-light-primary btn-icon" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project"><i class="bi bi-file-earmark-post"></i></a>
                </div>
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

                    <a href="#" class="btn btn-sm btn-light-primary btn-icon" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project"><i class="bi bi-file-earmark-post"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-6 my-xl-5">
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
    </div>

</div>

<div class="row gx-5 gx-xl-10 my-xl-5">
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