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
                                Kelas <?= $title ?>
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

                                <div class="fw-semibold fs-6 text-gray-500">Laki-laki</div>
                            </div>

                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="fs-2 fw-bold text-light" id="count_chap">memuat ...</div>
                                </div>

                                <div class="fw-semibold fs-6 text-gray-500">Perempuan</div>
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

  <input type="hidden" name="group_id" value="<?= $group_id ?>">
  <div class="card-body border-top p-9">
    <div id="student_group_view"></div>
  </div>

</div>

<?php $this->endSection(); ?>