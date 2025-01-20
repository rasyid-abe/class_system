<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="row">
  <div class="col-lg-4 mb-5">

    <div class="card card-flush border-0 h-xl-100" data-bs-theme="light" style="background-color: #192440">
      <div class="card-header pt-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
          <!--begin::User-->
          <div class="d-flex flex-column">
            <!--begin::Name-->
            <div class="d-flex align-items-center mb-2">
              <a href="#" class="text-light fs-2 fw-bold me-1">Ringkasan Informasi</a>
            </div>
            <!--end::Name-->

            <!--begin::Info-->
            <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
              <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5">
                Materi Sekolah
              </a>
            </div>
            <!--end::Info-->
          </div>
          <!--end::User-->

        </div>
      </div>
      <div class="card-body d-flex justify-content-between flex-column pt-1 px-0 pb-0">
        <div class="d-flex flex-wrap px-9 mb-5">
          <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
            <!--begin::Number-->
            <div class="d-flex align-items-center">
              <div class="fs-2 fw-bold text-light" id="lessch_chap">memuat...</div>
            </div>
            <!--end::Number-->

            <!--begin::Label-->
            <div class="fw-semibold fs-6 text-gray-500">BAB Pelajaran</div>
            <!--end::Label-->
          </div>

          <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
            <!--begin::Number-->
            <div class="d-flex align-items-center">
              <div class="fs-2 fw-bold text-light" id="lessch_subchap">memuat...</div>
            </div>
            <!--end::Number-->

            <!--begin::Label-->
            <div class="fw-semibold fs-6 text-gray-500">Topik</div>
            <!--end::Label-->
          </div>
        </div>
      </div>
    </div>


  </div>

  <?php foreach($mysubs as $k => $v):?>
    <div class="col-lg-4 mb-5" style="min-height: 180px">
      <div class="card h-100">
        <div class="card-body p-5">
          <div class="fw-bold">
            <h3><?= $v['subj_name'] ?></h3>
          </div>
          <div class="fs-4 fw-semibold text-gray-500 mb-7"></div>
          <?php foreach($v['grade'] as $key => $val): ?>
            <div class="fs-6 d-flex justify-content-between mb-4">
            <span class="card-label fw-bold text-gray-900"><?= grade_label($val) ?></span>
              <div class="d-flex fw-bold">
                <a href="<?= base_url('teacher/lesson/school/view-content/' . $v['subj_id'] . '/' . $v['grade'][$key]) ?>" class="badge badge-primary">Buat Penilaian</a>
              </div>
            </div>
          <?php endforeach ?>
  
        </div>
      </div>
  
    </div>
  <?php endforeach ?>
</div>


<?php $this->endSection(); ?>