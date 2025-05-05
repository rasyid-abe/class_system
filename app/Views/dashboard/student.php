<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<style>
    .container-card {
        padding-left: 10px;
        padding-right: 15px;
    }

    .row-task {
        align-items: stretch;
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        overflow-x: auto;
        overflow-y: hidden;
    }

    .card-task {
        /*float: left;*/
        width: 30%;
        /* padding: .75rem; */
        margin-bottom: 4px;
        margin-right: 10px;
        border: 0;
        /* flex-basis: 30%; */
        flex-grow: 0;
        flex-shrink: 0;
    }

    .card .container-body {
        height: 245px !important;
        padding: 15px !important;
    }

    .card-text {
        font-size: 85%;
        margin-bottom: -1px;
    }
</style>

<?php if(count($subj_school) > 0): ?>
<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
    <div class="col-xxl-6">

        <div class="card card-flush h-md-100" style="background: linear-gradient(112.14deg, #009EF7 0%, #293EB4 100%)">
            <div class="card-body py-9">
                <div class="row gx-9 h-100">

                    <div class="col-sm-12">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-7">
                                <div class="d-flex flex-stack text-white mb-6">
                                    <div class="flex-shrink-0 me-5">
                                        <span class="fs-7 fw-bold me-2 d-block lh-1 pb-1">Belajar Mandiri</span>

                                        <span class="fs-1 fw-bold">Materi Sekolah</span>
                                    </div>

                                    <a href="<?= base_url('student/lesson/school') ?>" class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end align-items-baseline" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                                        <i class="bi bi-three-dots text-white fs-1"></i>
                                    </a>
                                </div>
                                <?php foreach ($subj_school as $v): ?>
                                    <a href="<?= base_url('student/lesson/school/view-content/' . $v['subject_id'] . '/' . $grade) ?>" class="badge badge-primary p-5 my-1"><?= $v['subject_name'] ?></a>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-6">

        <div class="card card-flush h-md-100" style="background: linear-gradient(112.14deg, #293EB4 0%, #192440 100%)">
            <div class="card-body py-9">
                <div class="row gx-9 h-100">

                    <div class="col-sm-12">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-7">
                                <div class="d-flex flex-stack text-white mb-6">
                                    <div class="flex-shrink-0 me-5">
                                        <span class="fs-7 fw-bold me-2 d-block lh-1 pb-1">Belajar Mandiri</span>

                                        <span class="fs-1 fw-bold">Materi Standar</span>
                                    </div>

                                    <a href="<?= base_url('student/lesson/standart') ?>" class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end align-items-baseline mt-2 mr-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                                        <i class="bi bi-three-dots text-white fs-1"></i>
                                    </a>
                                </div>

                                <?php foreach ($subj_standart as $v): ?>
                                    <a href="<?= base_url('student/lesson/standart/view-content/' . $v['subject_id'] . '/' . $grade) ?>" class="badge badge-light p-5 my-1"><?= $v['subject_name'] ?></a>
                                <?php endforeach; ?>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

</div>
<?php endif; ?>

<div class="row">
    <?php if (count($assessment) > 0): ?>
        <div class="col-sm-12 mb-5">
            <div class="alert alert-primary" style="border-radius:10px;">
                <div class="d-flex flex-stack text-white mb-3">
                    <div class="flex-shrink-0">
                        <span class="mb-3 p-3 fw-bold text-gray-900 fs-2 m-0">Penilaian Aktif</span>
                    </div>

                    <a href="<?= base_url('student/assessment/present') ?>" class="btn btn-icon btn-color-gray-500 btn-active-color-primary pt-2 pr-4" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                        <i class="bi bi-three-dots text-dark fs-1"></i>
                    </a>
                </div>
                <div class="container-card">
                    <div class="row-task">
                        <?php foreach ($assessment as $v):
                            $deg = $v['teacher_degree'] != '' ? ', ' . $v['teacher_degree'] : '';
                            $name = $v['teacher_first_name'] . ' ' . $v['teacher_last_name'] . $deg;
                            $duration = $v['assessment_duration'] > 0 ? $v['assessment_duration'] . " Menit" : '-';
                        ?>
                            <div class="card-task">
                                <div class="card">
                                    <div class="card-body container-body">
                                        <div class="d-flex align-items-start flex-column bd-highlight mb-3" style="height: 200px;">
                                            <div class="mb-auto p-2 bd-highlight">
                                                <p class="fs-3 text-primary fw-bold mb-auto bd-highlight"><?= $v['assessment_title'] ?></p>
                                                <badge class="badge badge-info"><i class="bi-alarm text-white"></i> <?= $duration ?></badge>
                                            </div>
                                            <div class="p-2 bd-highlight" style="margin-bottom: -17px;">
                                                <p class="card-text fs-5 text-dark fw-semibold"><?= $v['subject_name'] ?></p>
                                                <p class="text-dark"><?= datetime_indo($v['assessment_start']) . ' s/d ' . datetime_indo($v['assessment_end']) ?></p>
                                                <p class="card-text fs-6 mb-2"><?= $name ?></p>
                                                <button class="btn btn-primary btn-sm" onclick="alert_begin_assessment('<?= $v['assessment_id'] ?>')">Kerjakan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (count($task) > 0): ?>
        <div class="col-sm-12 mb-5">
            <div class="alert alert-info" style="border-radius:10px;">
                <div class="d-flex flex-stack text-white mb-3">
                    <div class="flex-shrink-0">
                        <span class="mb-3 p-3 fw-bold text-gray-900 fs-2 m-0">Tugas Aktif</span>
                    </div>

                    <a href="<?= base_url('student/task/present') ?>" class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-start pt-2 pr-4" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                        <i class="bi bi-three-dots text-dark fs-1"></i>
                    </a>
                </div>
                <div class="container-card">
                    <div class="row-task">
                        <?php foreach ($task as $v):
                            $deg = $v['teacher_degree'] != '' ? ', ' . $v['teacher_degree'] : '';
                            $name = $v['teacher_first_name'] . ' ' . $v['teacher_last_name'] . $deg;
                            $tmp_exists = in_array($v['task_id'], $arr_temp_task) ? 1 : 0;
                            $bdg_exsists = '';
                            if (in_array($v['task_id'], $arr_temp_task)) {
                                $bdg_exsists = '<badge class="badge badge-danger">Belum dikirim</badge>';
                            } else {
                                $bdg_exsists = '<badge class="badge badge-info">Belum dikerjakan</badge>';
                            }
                        ?>

                            <?php if (in_array($v['task_id'], $list_idx)): ?>
                                <?php if ($v['task_end'] > date('Y-m-d H:i:s') || ($v['task_end'] < date('Y-m-d H:i:s') && $v['task_is_ignored_time_submit'] == 1)): ?>
                                    <div class="card-task">
                                        <div class="card">
                                            <div class="card-body container-body">
                                                <div class="d-flex align-items-start flex-column bd-highlight mb-3" style="height: 200px;">
                                                    <div class="mb-auto p-2 bd-highlight">
                                                        <p class="fs-3 text-primary fw-bold mb-auto bd-highlight"><?= $v['task_title'] ?></p>
                                                        <?= $bdg_exsists; ?>
                                                    </div>
                                                    <div class="p-2 bd-highlight" style="margin-bottom: -17px;">
                                                        <p class="card-text fs-5 text-dark fw-semibold"><?= $v['subject_name'] ?></p>
                                                        <p class="text-dark"><?= datetime_indo($v['task_start']) . ' s/d ' . datetime_indo($v['task_end']) ?></p>
                                                        <p class="card-text fs-6 mb-2"><?= $name ?></p>
                                                        <button class="btn btn-primary btn-sm" onclick="begin_task('<?= $v['task_id'] ?>', '<?= $tmp_exists ?>')">Kerjakan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>


<div class="row gx-5 gx-xl-10 mb-xl-10">

    <div class="col-md-6 col-xl-12">
        <div class="card bg-light-success">
            <div class="card-header align-items-center border-0">
                <h3 class="fw-bold text-gray-900 fs-2 m-0">Informasi Terkini</h3>

                <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">

                    <i class="bi bi-three-dots text-dark fs-1"></i>
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

                    <div class="p-5 rounded bg-white text-gray-900 fw-semibold text-start" data-kt-element="message-text">
                        <h4>Judul Informasi</h4>
                        How likely are you to recommend our company How likely are you to recommend our company to your friends and family ? Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis, obcaecati, cum culpa facilis provident corrupti distinctio accusantium rem reiciendis ea, natus iure at labore laudantium quae eligendi excepturi? Voluptatum, enim?
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

                    <div class="p-5 rounded bg-white text-gray-900 fw-semibold text-start" data-kt-element="message-text">
                        <h4>Judul Informasi</h4>
                        How likely are you to recommend our company How likely are you to recommend our company to your friends and family ?
                        <a href="">Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<?php $this->endSection(); ?>