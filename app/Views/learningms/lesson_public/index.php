<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="card mb-5 mb-xl-10" style="background-color: #192440">
    <div class="card-body pt-9 pb-9">
        <div class="d-flex flex-wrap flex-sm-nowrap mb-3">

            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center mb-2">
                            <a href="#" class="text-light fs-2 fw-bold me-1">Ringkasan Informasi</a>
                        </div>

                        <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                            <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                Materi Publik
                            </a>
                        </div>
                    </div>

                </div>

                <div class="d-flex flex-wrap flex-stack">
                    <div class="d-flex flex-column flex-grow-1 pe-8">
                        <div class="d-flex flex-wrap">
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="fs-2 fw-bold text-light" data-kt-countup="true" data-kt-countup-value="75" data-kt-initialized="1">75</div>
                                </div>

                                <div class="fw-semibold fs-6 text-gray-500">Mata Pelajaran</div>
                            </div>

                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="fs-2 fw-bold text-light" data-kt-countup="true" data-kt-countup-value="75" data-kt-initialized="1">75</div>
                                </div>

                                <div class="fw-semibold fs-6 text-gray-500">BAB</div>
                            </div>

                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="fs-2 fw-bold text-light" data-kt-countup="true" data-kt-countup-value="75" data-kt-initialized="1">75</div>
                                </div>

                                <div class="fw-semibold fs-6 text-gray-500">Topik</div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5">
            <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="/seven-html-pro/account/overview.html">
                    Bahasa Indonesia </a>
            </li>
            <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="/seven-html-pro/account/settings.html">
                    Bahasa Inggris</a>
            </li>
            <li class="nav-item mt-2">
                <a class="nav-link text-active-light fw-bold ms-0 me-10 py-5 active" href="#">
                    Matematika </a>
            </li>
        </ul>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between bg-light-primary rounded p-5 mb-7">
            <div class="d-flex align-items-start">
                <button class="btn btn-primary pl-10" data-bs-toggle="modal" data-bs-target="#kt_modal_upgrade_plan">Lihat Materi</button>
                <div class="flex-grow-1 me-2 mx-10">
                    <h3 class="mb-1">Topik Materi</h3>
                    <span class="text-gray-700 fw-semibold d-block">BAB: Aljabar Linier </span>
                </div>
            </div>

            <div class="additional-info">
                <div class="d-flex align-items-end flex-column">
                    <badge class="badge badge-info badge-block mb-1">Kelas XII</badge>
                    <span class="text-gray-700 fw-semibold d-block">Dibagikan oleh: Guru Matematika, S.Pd. </span>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="card">
    <div class="card-body py-4">
        <table id="kt_datatable_dom_positioning" class="table table-striped">
            <thead>
                <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                    <th class="text-center">#</th>
                    <th>Mata Pelajaran</th>
                    <th class="text-center">Kelas</th>
                    <th>BAB</th>
                    <th>Topik</th>
                    <th>Dibagikan Oleh</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($shared as $k => $v): ?>
                    <?php $degr = $v['teacher_degree'] != '' ? ', ' . $v['teacher_degree'] : ''  ?>
                    <tr>
                        <td class="text-center"><?= $k + 1 ?></td>
                        <td><?= $v['subject_name'] ?></td>
                        <td class="text-center"><?= $v['lesson_additional_grade'] ?></td>
                        <td><?= $v['lesson_additional_chapter'] ?></td>
                        <td><?= $v['lesson_additional_subchapter'] ?></td>
                        <td><?= $v['teacher_first_name'] . ' ' . $v['teacher_last_name'] . $degr ?></td>
                        <td class="text-center">
                            <?= view_content('teacher/lesson/public/view-content/' . $v['lesson_additional_id']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<?php $this->endSection(); ?>