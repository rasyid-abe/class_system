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
                                Materi Standar
                            </a>
                        </div>
                    </div>

                </div>

                <div class="d-flex flex-wrap flex-stack">
                    <div class="d-flex flex-column flex-grow-1 pe-8">
                        <div class="d-flex flex-wrap">
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="fs-2 fw-bold text-light" id="count_subj">memuat ...</div>
                                </div>

                                <div class="fw-semibold fs-6 text-gray-500">Mata Pelajaran</div>
                            </div>

                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="fs-2 fw-bold text-light" id="count_chap">memuat ...</div>
                                </div>

                                <div class="fw-semibold fs-6 text-gray-500">BAB</div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5" id="list_class">
            <!-- <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="/seven-html-pro/account/overview.html">
                    Kelas X </a>
            </li>
            <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="/seven-html-pro/account/settings.html">
                    Kelas XI </a>
            </li>
            <li class="nav-item mt-2">
                <a class="nav-link text-active-light fw-bold ms-0 me-10 py-5 active" href="#">
                    Kelas XII </a>
            </li> -->
        </ul>
    </div>
</div>

<div class="card mb-5 mb-xl-10">

  <div class="card-body border-top p-9 hide" id="body_tbl_list_standart">
    <div id="tbl_list_standard"></div>
  </div>

</div>

<div class="card hide">
    <div class="card-body py-4">
        <table id="tbl_standard" class="table table-striped">
            <thead>
                <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                    <th class="text-center">#</th>
                    <th>Kelas</th>
                    <th class="text-center">Total Mata Pelajaran</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($grades as $k => $v) : ?>
                    <tr>
                        <td class="text-center"><?= $k + 1 ?></td>
                        <td><?= get_list('grade')[school_level(userdata()['school_id'])][$v['teacher_assign_grade']] ?></td>
                        <td class="text-center"><?= $v['total_subject'] ?></td>
                        <td class="text-center">
                            <?= view_subject_content('teacher/lesson/standart/view-subject/' . $v['teacher_assign_grade']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<?php $this->endSection(); ?>