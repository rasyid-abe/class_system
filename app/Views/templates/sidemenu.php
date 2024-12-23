<div class="tab-content">
    <?php if(session()->get('c_role') == 11): ?>
        <!--begin::Tab pane-->
        <div class="tab-pane fade <?= $page == "Dashboard" ? 'active show' : '' ?>" id="home_dashboard" role="tabpanel">
            <!--begin::Tasks-->
            <div class="mx-5">
                <!--begin::Body-->
                <div class="mb-12">
                    <!--begin::Item-->
                    <div class="me-7 mb-4 d-flex justify-content-center">
                        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                            <img src="<?= base_url() ?>images/default-user2.png" alt="image">
                            <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                        </div>
                    </div>
                    <h3 class="fw-semibold text-gray-800 text-center lh-lg">           
                        Nama Lengkap, S.Pd
                    </h3>
                    <div class="text-gray-500 fw-semibold text-center lh-lg">Users from all channels</div>
                    <!--end::Item-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Tasks-->
        </div>
        <!--end::Tab pane-->
        <!--begin::Tab pane-->
        <div class="tab-pane fade <?= $page == "Lesson" ? 'active show' : '' ?>" id="subjects_menu" role="tabpanel">
            <!--begin::Tasks-->
            <div class="mx-5">
                <!--begin::Header-->
                <h3 class="fw-bolder text-dark mb-10 mx-0">Materi Pelajaran</h3>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="mb-12">
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <i class="bi bi-journal-bookmark-fill text-primary fs-2hx"></i>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Text-->
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/lesson/standart') ?>"
                                class="<?= $sidebar != 'Standart' ? 'text-gray-800' : 'text-primary' ?> text-hover-primary fs-6 fw-bold">Standar</a>
                            <!-- <span class="text-muted fw-bold">Project Manager</span> -->
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <i class="bi bi-journal-medical text-success fs-2hx"></i>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Text-->
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/lesson/additional') ?>"
                                class="<?= $sidebar != 'Additional' ? 'text-gray-800' : 'text-success' ?> text-hover-success fs-6 fw-bold">Saya</a>
                            <!-- <span class="text-muted fw-bold">Project Manager</span> -->
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <i class="bi bi-journal-text text-info fs-2hx"></i>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Text-->
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/lesson/school') ?>"
                                class="<?= $sidebar != 'School' ? 'text-gray-800' : 'text-info' ?> text-hover-info fs-6 fw-bold">Sekolah</a>
                            <!-- <span class="text-muted fw-bold">Project Manager</span> -->
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <i class="bi bi-journal-album text-danger fs-2hx"></i>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Text-->
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/lesson/public') ?>"
                                class="<?= $sidebar != 'Public' ? 'text-gray-800' : 'text-danger' ?> text-hover-danger fs-6 fw-bold">Publik</a>
                            <!-- <span class="text-muted fw-bold">Project Manager</span> -->
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Tasks-->
        </div>
        <!--end::Tab pane-->
        <!--begin::Tab pane-->
        <div class="tab-pane fade <?= $page == "Question" ? 'active show' : '' ?>" id="question_bank_menu" role="tabpanel">
            <!--begin::Tasks-->
            <div class="mx-5">
                <!--begin::Header-->
                <h3 class="fw-bolder text-dark mb-10 mx-0">Bank Soal</h3>
                <!--end::Header-->

                <!--begin::Body-->
                <div class="mb-12">
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <i class="bi bi-bookmark-check-fill text-primary fs-2hx"></i>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Text-->
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/question-bank/standart') ?>"
                                class="<?= $sidebar != 'QB_Standart' ? 'text-gray-800' : 'text-primary' ?> text-hover-primary fs-6 fw-bold">Standar</a>
                            <!-- <span class="text-muted fw-bold">Project Manager</span> -->
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <i class="bi bi-bookmark-heart-fill text-success fs-2hx"></i>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Text-->
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/question-bank/additional') ?>"
                                class="<?= $sidebar != 'QB_Additional' ? 'text-gray-800' : 'text-success' ?> text-hover-success fs-6 fw-bold">Saya</a>
                            <!-- <span class="text-muted fw-bold">Project Manager</span> -->
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <i class="bi bi-bookmark-star-fill text-danger fs-2hx"></i>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Text-->
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/question-bank/public') ?>"
                                class="<?= $sidebar != 'QB_Public' ? 'text-gray-800' : 'text-danger' ?> text-hover-danger fs-6 fw-bold">Publik</a>
                            <!-- <span class="text-muted fw-bold">Project Manager</span> -->
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Tasks-->
        </div>
        <!--end::Tab pane-->
        <!--begin::Tab pane-->
        <div class="tab-pane fade <?= $page == "Assessment" ? 'active show' : '' ?>" id="evaluation_menu" role="tabpanel">
            <!--begin::Tasks-->
            <div class="mx-5">
                <!--begin::Header-->
                <h3 class="fw-bolder text-dark mb-10 mx-0">Penilaian</h3>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="mb-12">
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <i class="bi bi-file-earmark-plus-fill text-primary fs-2hx"></i>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Text-->
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/assessment/index-add') ?>"
                                class="<?= $sidebar != 'Add_Assessment' ? 'text-gray-800' : 'text-primary' ?>  text-hover-primary fs-6 fw-bold">Tambah Penilaian</a>
                            <!-- <span class="text-muted fw-bold">Project Manager</span> -->
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <i class="bi bi-file-earmark-post text-warning fs-2hx"></i>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Text-->
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/assessment/index-draft') ?>"
                                class="<?= $sidebar != 'Draft_Assessment' ? 'text-gray-800' : 'text-warning' ?>  text-hover-warning fs-6 fw-bold">Draft</a>
                            <!-- <span class="text-muted fw-bold">Project Manager</span> -->
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <i class="bi bi-file-earmark-spreadsheet-fill text-success fs-2hx"></i>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Text-->
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/assessment/index-scheduled') ?>"
                                class="<?= $sidebar != 'Scheduled_Assessment' ? 'text-gray-800' : 'text-success' ?> text-hover-success fs-6 fw-bold">Terjadwal</a>
                            <!-- <span class="text-muted fw-bold">Project Manager</span> -->
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <i class="bi bi-file-earmark-text-fill text-info fs-2hx"></i>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Text-->
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/assessment/index-present') ?>"
                                class="<?= $sidebar != 'Present_Assessment' ? 'text-gray-800' : 'text-info' ?>  text-hover-info fs-6 fw-bold">Saat Ini</a>
                            <!-- <span class="text-muted fw-bold">Project Manager</span> -->
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <i class="bi bi-file-earmark-check-fill text-danger fs-2hx"></i>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Text-->
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/assessment/index-done') ?>"
                                class="<?= $sidebar != 'Done_Assessment' ? 'text-gray-800' : 'text-danger' ?> text-hover-danger fs-6 fw-bold">Selesai</a>
                            <!-- <span class="text-muted fw-bold">Project Manager</span> -->
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Tasks-->
        </div>
        <!--end::Tab pane-->
        <!--begin::Tab pane-->
        <div class="tab-pane fade <?= $page == "Task" ? 'active show' : '' ?>" id="task_menu" role="tabpanel">
            <!--begin::Tasks-->
            <div class="mx-5">
                <!--begin::Header-->
                <h3 class="fw-bolder text-dark mb-10 mx-0">Tugas</h3>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="mb-12">
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <i class="bi bi-calendar3-event-fill text-gray-700 fs-2hx"></i>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Text-->
                        <div class="d-flex flex-column">
                            <a href="../dist/pages/profile/overview.html"
                                class="text-gray-800 text-hover-success fs-6 fw-bold">Draft</a>
                            <!-- <span class="text-muted fw-bold">Project Manager</span> -->
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <i class="bi bi-calendar3-week-fill text-success fs-2hx"></i>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Text-->
                        <div class="d-flex flex-column">
                            <a href="../dist/pages/profile/overview.html"
                                class="text-gray-800 text-hover-success fs-6 fw-bold">Terjadwal</a>
                            <!-- <span class="text-muted fw-bold">Project Manager</span> -->
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <i class="bi bi-calendar3-range-fill text-info fs-2hx"></i>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Text-->
                        <div class="d-flex flex-column">
                            <a href="../dist/pages/profile/overview.html"
                                class="text-gray-800 text-hover-info fs-6 fw-bold">Saat Ini</a>
                            <!-- <span class="text-muted fw-bold">Project Manager</span> -->
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <i class="bi bi-calendar3-fill text-danger fs-2hx"></i>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Text-->
                        <div class="d-flex flex-column">
                            <a href="../dist/pages/profile/overview.html"
                                class="text-gray-800 text-hover-danger fs-6 fw-bold">Selesai</a>
                            <!-- <span class="text-muted fw-bold">Project Manager</span> -->
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Tasks-->
        </div>
        <!--end::Tab pane-->
        <!--begin::Tab pane-->
        <div class="tab-pane fade <?= $page == "Group" ? 'active show' : '' ?>" id="group_menu" role="tabpanel">
            <!--begin::Tasks-->
            <div class="mx-5">
                <!--begin::Header-->
                <h3 class="fw-bolder text-dark mb-10 mx-0">Daftar Kelas</h3>
                <!--end::Header-->
            
                
            </div>
            <!--end::Tasks-->
        </div>
        <!--end::Tab pane-->
        <!--begin::Tab pane-->
    <?php elseif(session()->get('c_role') == 12): ?>
        <div class="tab-pane fade active show" id="self_study" role="tabpanel">
            <!--begin::Tasks-->
            <div class="mx-5">
                <!--begin::Header-->
                <h3 class="fw-bolder text-dark mb-10 mx-0">Belajar Mandiri</h3>
                <!--end::Header-->
            <!--begin::Body-->
            <div class="mb-12">
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <i class="bi bi-journal-bookmark-fill text-primary fs-2hx"></i>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Text-->
                        <div class="d-flex flex-column">
                            <a href="../dist/pages/profile/overview.html"
                                class="text-gray-800 text-hover-primary fs-6 fw-bold">Materi Standar</a>
                            <!-- <span class="text-muted fw-bold">Project Manager</span> -->
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <i class="bi bi-journal-text text-info fs-2hx"></i>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Text-->
                        <div class="d-flex flex-column">
                            <a href="../dist/pages/profile/overview.html"
                                class="text-gray-800 text-hover-info fs-6 fw-bold">Materi Sekolah</a>
                            <!-- <span class="text-muted fw-bold">Project Manager</span> -->
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->
                </div>
                <!--end::Body-->
                
            </div>
            <!--end::Tasks-->
        </div>
        <div class="tab-pane fade" id="student_result" role="tabpanel">
            <!--begin::Tasks-->
            <div class="mx-5">
                <!--begin::Header-->
                <h3 class="fw-bolder text-dark mb-10 mx-0">Penilaian</h3>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="mb-12">
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <i class="bi bi-file-earmark-spreadsheet-fill text-success fs-2hx"></i>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Text-->
                        <div class="d-flex flex-column">
                            <a href="../dist/pages/profile/overview.html"
                                class="text-gray-800 text-hover-success fs-6 fw-bold">Tugas Aktif</a>
                            <!-- <span class="text-muted fw-bold">Project Manager</span> -->
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <i class="bi bi-file-earmark-text-fill text-danger fs-2hx"></i>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Text-->
                        <div class="d-flex flex-column">
                            <a href="../dist/pages/profile/overview.html"
                                class="text-gray-800 text-hover-danger fs-6 fw-bold">Tugas Terlewat</a>
                            <!-- <span class="text-muted fw-bold">Project Manager</span> -->
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <i class="bi bi-file-earmark-check-fill text-info fs-2hx"></i>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Text-->
                        <div class="d-flex flex-column">
                            <a href="../dist/pages/profile/overview.html"
                                class="text-gray-800 text-hover-info fs-6 fw-bold">Tugas Selesai</a>
                            <!-- <span class="text-muted fw-bold">Project Manager</span> -->
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Tasks-->
        </div>
        <div class="tab-pane fade" id="student_task" role="tabpanel">
            <!--begin::Tasks-->
            <div class="mx-5">
                <!--begin::Header-->
                <h3 class="fw-bolder text-dark mb-10 mx-0">Tugas</h3>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="mb-12">
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <i class="bi bi-calendar3-week-fill text-success fs-2hx"></i>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Text-->
                        <div class="d-flex flex-column">
                            <a href="../dist/pages/profile/overview.html"
                                class="text-gray-800 text-hover-success fs-6 fw-bold">Tugas Aktif</a>
                            <!-- <span class="text-muted fw-bold">Project Manager</span> -->
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <i class="bi bi-calendar3-range-fill text-danger fs-2hx"></i>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Text-->
                        <div class="d-flex flex-column">
                            <a href="../dist/pages/profile/overview.html"
                                class="text-gray-800 text-hover-danger fs-6 fw-bold">Tugas Terlewat</a>
                            <!-- <span class="text-muted fw-bold">Project Manager</span> -->
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <i class="bi bi-calendar3-fill text-info fs-2hx"></i>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Text-->
                        <div class="d-flex flex-column">
                            <a href="../dist/pages/profile/overview.html"
                                class="text-gray-800 text-hover-info fs-6 fw-bold">Tugas Selesai</a>
                            <!-- <span class="text-muted fw-bold">Project Manager</span> -->
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Item-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Tasks-->
        </div>
        <!--end::Tab pane-->
<?php endif; ?>
</div>