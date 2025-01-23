<div class="tab-content">
    <?php if (session()->get('c_role') == 11): ?>
        <div class="tab-pane fade <?= $page == "Dashboard" ? 'active show' : '' ?>" id="home_dashboard" role="tabpanel">
            <div class="mx-5">
                <div class="mb-12">
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
                </div>
            </div>
        </div>
        <div class="tab-pane fade <?= $page == "Lesson" ? 'active show' : '' ?>" id="subjects_menu" role="tabpanel">
            <div class="mx-5">
                <h3 class="fw-bolder text-dark mb-10 mx-0">Materi Pelajaran</h3>
                <div class="mb-12">
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <i class="bi bi-journal-bookmark-fill text-primary fs-2hx"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/lesson/standart') ?>"
                                class="<?= $sidebar != 'Standart' ? 'text-gray-800' : 'fw-bolder text-primary' ?> text-hover-primary fs-6 fw-bold">Standar</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <i class="bi bi-journal-medical text-success fs-2hx"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/lesson/additional') ?>"
                                class="<?= $sidebar != 'Additional' ? 'text-gray-800' : 'fw-bolder text-success' ?> text-hover-success fs-6 fw-bold">Saya</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <i class="bi bi-journal-text text-info fs-2hx"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/lesson/school') ?>"
                                class="<?= $sidebar != 'School' ? 'text-gray-800' : 'fw-bolder text-info' ?> text-hover-info fs-6 fw-bold">Sekolah</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <i class="bi bi-journal-album text-danger fs-2hx"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/lesson/public') ?>"
                                class="<?= $sidebar != 'Public' ? 'text-gray-800' : 'fw-bolder text-danger' ?> text-hover-danger fs-6 fw-bold">Publik</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade <?= $page == "Question" ? 'active show' : '' ?>" id="question_bank_menu" role="tabpanel">
            <div class="mx-5">
                <h3 class="fw-bolder text-dark mb-10 mx-0">Bank Soal</h3>

                <div class="mb-12">
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <i class="bi bi-bookmark-check-fill text-primary fs-2hx"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/question-bank/standart') ?>"
                                class="<?= $sidebar != 'QB_Standart' ? 'text-gray-800' : 'fw-bolder text-primary' ?> text-hover-primary fs-6 fw-bold">Standar</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <i class="bi bi-bookmark-heart-fill text-success fs-2hx"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/question-bank/additional') ?>"
                                class="<?= $sidebar != 'QB_Additional' ? 'text-gray-800' : 'fw-bolder text-success' ?> text-hover-success fs-6 fw-bold">Saya</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <i class="bi bi-bookmark-star-fill text-danger fs-2hx"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/question-bank/public') ?>"
                                class="<?= $sidebar != 'QB_Public' ? 'text-gray-800' : 'fw-bolder text-danger' ?> text-hover-danger fs-6 fw-bold">Publik</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade <?= $page == "Assessment" ? 'active show' : '' ?>" id="evaluation_menu" role="tabpanel">
            <div class="mx-5">
                <h3 class="fw-bolder text-dark mb-10 mx-0">Penilaian</h3>
                <div class="mb-12">
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <i class="bi bi-file-earmark-plus-fill text-primary fs-2hx"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/assessment/index-add') ?>"
                                class="<?= $sidebar != 'Add_Assessment' ? 'text-gray-800' : 'fw-bolder text-primary' ?>  text-hover-primary fs-6 fw-bold">Tambah</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <i class="bi bi-file-earmark-post text-warning fs-2hx"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/assessment/index-draft') ?>"
                                class="<?= $sidebar != 'Draft_Assessment' ? 'text-gray-800' : 'fw-bolder text-warning' ?>  text-hover-warning fs-6 fw-bold">Draft</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <i class="bi bi-file-earmark-spreadsheet-fill text-success fs-2hx"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/assessment/index-scheduled') ?>"
                                class="<?= $sidebar != 'Scheduled_Assessment' ? 'text-gray-800' : 'fw-bolder text-success' ?> text-hover-success fs-6 fw-bold">Terjadwal</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <i class="bi bi-file-earmark-text-fill text-info fs-2hx"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/assessment/index-present') ?>"
                                class="<?= $sidebar != 'Present_Assessment' ? 'text-gray-800' : 'fw-bolder text-info' ?>  text-hover-info fs-6 fw-bold">Saat Ini</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <i class="bi bi-file-earmark-check-fill text-danger fs-2hx"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/assessment/index-done') ?>"
                                class="<?= $sidebar != 'Done_Assessment' ? 'text-gray-800' : 'fw-bolder text-danger' ?> text-hover-danger fs-6 fw-bold">Selesai</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade <?= $page == "Tasks" ? 'active show' : '' ?>" id="task_menu" role="tabpanel">
            <div class="mx-5">
                <h3 class="fw-bolder text-dark mb-10 mx-0">Tugas</h3>
                <div class="mb-12">
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <i class="bi bi-calendar-plus-fill text-primary fs-2hx"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/tasks/index-add') ?>"
                                class="<?= $sidebar != 'Add_Tasks' ? 'text-gray-800' : 'fw-bolder text-primary' ?> text-hover-primary fs-6 fw-bold">Tambah</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <i class="bi bi-calendar3-event-fill text-warning fs-2hx"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/tasks/index-draft') ?>"
                                class="<?= $sidebar != 'Draft_Tasks' ? 'text-gray-800' : 'fw-bolder text-warning' ?> text-hover-warning fs-6 fw-bold">Draft</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <i class="bi bi-calendar3-week-fill text-success fs-2hx"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/tasks/index-scheduled') ?>"
                                class="<?= $sidebar != 'Scheduled_Tasks' ? 'text-gray-800' : 'fw-bolder text-success' ?> text-hover-success fs-6 fw-bold">Terjadwal</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <i class="bi bi-calendar3-range-fill text-info fs-2hx"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/tasks/index-present') ?>"
                                class="<?= $sidebar != 'Present_Tasks' ? 'text-gray-800' : 'fw-bolder text-info' ?> text-hover-info fs-6 fw-bold">Saat Ini</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <i class="bi bi-calendar3-fill text-danger fs-2hx"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/teacher/tasks/index-done') ?>"
                                class="<?= $sidebar != 'Done_Tasks' ? 'text-gray-800' : 'fw-bolder text-danger' ?> text-hover-danger fs-6 fw-bold">Selesai</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade <?= $page == "Groups" ? 'active show' : '' ?>" id="group_menu" role="tabpanel">
            <div class="mx-5">
                <h3 class="fw-bolder text-dark mb-10 mx-0">Mengajar di Kelas</h3>

                <div class="mb-12">
                    <?php foreach (my_groups() as $k => $v): ?>
                        <div class="d-flex align-items-center mb-7">
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label bg-secondary">
                                    <i class="bi bi-people-fill text-primary fs-2hx"></i>
                                </span>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="<?= base_url('/teacher/groups/view-students/') . $v['student_group_id'] ?>"
                                    class="<?= $sidebar == $v['student_group_name'] ? 'fw-bolder text-primary' : 'text-gray-800' ?> text-hover-primary fs-6 fw-bold"><?= $v['student_group_name'] ?></a>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    <?php elseif (session()->get('c_role') == 12): ?>
        <div class="tab-pane fade <?= $page == "Dashboard" ? 'active show' : '' ?>" id="home_dashboard" role="tabpanel">
            <div class="mx-5">
                <div class="mb-12">
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
                </div>
            </div>
        </div>
        <div class="tab-pane fade <?= $page == "Self Study" ? 'active show' : '' ?>" id="self_study" role="tabpanel">
            <div class="mx-5">
                <h3 class="fw-bolder text-dark mb-10 mx-0">Belajar Mandiri</h3>
                <div class="mb-12">
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <i class="bi bi-journal-bookmark-fill text-primary fs-2hx"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/student/lesson/standart') ?>"
                                class="<?= $sidebar != 'Standart' ? 'text-gray-800' : 'fw-bolder text-primary' ?> text-hover-primary fs-6 fw-bold">Materi Standar</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <i class="bi bi-journal-text text-info fs-2hx"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/student/lesson/school') ?>"
                                class="<?= $sidebar != 'School' ? 'text-gray-800' : 'fw-bolder text-info' ?> text-hover-info fs-6 fw-bold">Materi Sekolah</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="tab-pane fade <?= $page == "Student Assessment" ? 'active show' : '' ?>" id="student_result" role="tabpanel">
            <div class="mx-5">
                <h3 class="fw-bolder text-dark mb-10 mx-0">Penilaian</h3>
                <div class="mb-12">
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <i class="bi bi-file-earmark-spreadsheet-fill text-success fs-2hx"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/student/assessment/present') ?>"
                                class="<?= $sidebar != 'Present_Assessment' ? 'text-gray-800' : 'fw-bolder text-success' ?> text-hover-success fs-6 fw-bold">Aktif</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <i class="bi bi-file-earmark-text-fill text-danger fs-2hx"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/student/assessment/missed') ?>"
                                class="<?= $sidebar != 'Missed_Assessment' ? 'text-gray-800' : 'fw-bolder text-danger' ?> text-hover-danger fs-6 fw-bold">Terlewat</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <i class="bi bi-file-earmark-check-fill text-info fs-2hx"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/student/assessment/done') ?>"
                                class="<?= $sidebar != 'Done_Assessment' ? 'text-gray-800' : 'fw-bolder text-info' ?> text-hover-info fs-6 fw-bold">Selesai</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade <?= $page == "Student Task" ? 'active show' : '' ?>" id="student_task" role="tabpanel">
            <div class="mx-5">
                <h3 class="fw-bolder text-dark mb-10 mx-0">Tugas</h3>
                <div class="mb-12">
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <i class="bi bi-calendar3-week-fill text-success fs-2hx"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/student/tasks/present') ?>"
                                class="<?= $sidebar != 'Present_Tasks' ? 'text-gray-800' : 'fw-bolder text-success' ?> text-hover-success fs-6 fw-bold">Aktif</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <i class="bi bi-calendar3-range-fill text-danger fs-2hx"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/student/tasks/missed') ?>"
                                class="<?= $sidebar != 'Missed_Tasks' ? 'text-gray-800' : 'fw-bolder text-daner' ?> text-hover-danger fs-6 fw-bold">Terlewat</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-50px me-5">
                            <span class="symbol-label bg-secondary">
                                <i class="bi bi-calendar3-fill text-info fs-2hx"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="<?= base_url('/student/tasks/done') ?>"
                                class="<?= $sidebar != 'Done_Tasks' ? 'text-gray-800' : 'fw-bolder text-info' ?> text-hover-info fs-6 fw-bold">Selesai</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>