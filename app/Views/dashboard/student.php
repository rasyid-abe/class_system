<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<?php if(year_active() == null ) : ?>
<!-- <div class="alert alert-danger d-flex align-items-center p-5 mb-5">
    <i class="bi bi-exclamation-octagon-fill fs-2hx text-danger me4"></i>
    <div class="d-flex flex-column mx-4">
        <h4 class="mb-1 text-danger">Peringatan</h4>
        <span>Pilih tahun pelajaran untuk mengaktifkan seluruh Fitur</span>
    </div>
</div> -->
<?php endif ?>

<?php if (count($subj_school) > 0): ?>
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

<div class="row" id="block-assessment-task">
    <div class="col-sm-12" id="block-assessment"></div>
    <div class="col-sm-12" id="block-task"></div>
</div>


<div class="row gx-5 gx-xl-10 mb-xl-10">
     <div class="col-sm-12">
        <div class="card mb-5 mb-xl-10" data-select2-id="select2-data-149-yjw4">
            <div class="card-header" data-select2-id="select2-data-148-fypg">
                <div class="card-title">
                    <h3>Aktivitas Terakhir</h3>
                </div>

                <div class="card-toolbar">
                    <a href="<?= base_url('student/activity') ?>" class="btn btn-sm btn-primary my-1">
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
    <div class="col-md-6 col-xl-6">
        <div class="card bg-white">
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

                    <div class="p-5 rounded bg-light-danger text-gray-900 fw-semibold text-start" data-kt-element="message-text">
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

                    <div class="p-5 rounded bg-light-danger text-gray-900 fw-semibold text-start" data-kt-element="message-text">
                        <h4>Judul Informasi</h4>
                        How likely are you to recommend our company How likely are you to recommend our company to your friends and family ?
                        <a href="">Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

</div>


<?php $this->endSection(); ?>