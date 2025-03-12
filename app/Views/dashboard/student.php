<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>
<div class="row gx-5 gx-xl-10 mb-xl-10">

    <div class="col-md-6 col-xl-4 mb-xl-10">
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
    
    <div class="col-md-6 col-xl-8 mb-xl-10">
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

    <div class="col-md-6 col-xl-4 mb-xl-10">
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
                    <i class="bi bi-file-earmark-spreadsheet-fill text-success fs-3x"></i>
                    &nbsp;
                    <div class="flex-grow-1 me-5">
                        <div class="text-gray-800 fw-semibold fs-2">
                            12
                            <!-- <span class="text-gray-500 fw-semibold fs-7"></span> -->
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
                            12
                            <!-- <span class="text-gray-500 fw-semibold fs-7"></span> -->
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
                            12
                            <!-- <span class="text-gray-500 fw-semibold fs-7"></span> -->
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
</div>
<?php $this->endSection(); ?>