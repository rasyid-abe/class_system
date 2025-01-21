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
                                Bank Soal Standar
                            </a>
                        </div>
                    </div>

                </div>

                <div class="d-flex flex-wrap flex-stack">
                    <div class="d-flex flex-column flex-grow-1 pe-8">
                        <div class="d-flex flex-wrap">
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="fs-2 fw-bold text-light" id="count_qbtitle">memuat ...</div>
                                </div>

                                <div class="fw-semibold fs-6 text-gray-500">Judul Soal</div>
                            </div>

                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="fs-2 fw-bold text-light" id="count_qbquest">memuat ...</div>
                                </div>

                                <div class="fw-semibold fs-6 text-gray-500">Total Soal</div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5" id="list_class"></ul>
    </div>
</div>

<div class="card mb-5 mb-xl-10">

  <div class="card-body border-top p-9 hide" id="body_tbl_list_standart">
    <div id="tbl_list_qbstd"></div>
  </div>

</div>

<?php $this->endSection(); ?>