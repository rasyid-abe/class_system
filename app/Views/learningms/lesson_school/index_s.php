<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="card mb-5 mb-xl-10" style="background-color: #192440">
    <div class="card-body pt-9">
        <div class="d-flex flex-wrap flex-sm-nowrap">

            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center mb-2">
                            <a href="#" class="text-light fs-2 fw-bold me-1">Ringkasan Informasi</a>
                        </div>

                        <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                            <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                Materi Sekolah
                            </a>
                        </div>
                    </div>

                </div>

                <div class="d-flex flex-wrap flex-stack">
                    <div class="d-flex flex-column flex-grow-1 pe-8">
                        <div class="d-flex flex-wrap">
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="fs-2 fw-bold text-light" id="count_chap">memuat ...</div>
                                </div>

                                <div class="fw-semibold fs-6 text-gray-500">BAB Pelajaran</div>
                            </div>

                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="fs-2 fw-bold text-light" id="count_schap">memuat ...</div>
                                </div>

                                <div class="fw-semibold fs-6 text-gray-500">Topik</div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-5 mb-xl-10">

  <div class="card-body border-top p-9">
    <div id="less_sch_list"></div>
  </div>

</div>


<?php $this->endSection(); ?>