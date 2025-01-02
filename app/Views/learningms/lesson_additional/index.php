<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="row">
  <div class="col-lg-4">

    <!--begin::Card widget 1-->
    <div class="card card-flush border-0 h-xl-100" data-bs-theme="light" style="background-color:rgb(42, 34, 43)">
      <!--begin::Header-->
      <div class="card-header pt-2">
        <!--begin::Title-->
        <h3 class="card-title">
          <span class="text-white fs-3 fw-bold me-2">Ringkasan Informasi</span>
        </h3>
        <!--end::Title-->

      </div>
      <!--end::Header-->

      <!--begin::Body-->
      <div class="card-body d-flex justify-content-between flex-column pt-1 px-0 pb-0">
        <!--begin::Wrapper-->
        <div class="d-flex flex-wrap px-9 mb-5">
          <!--begin::Stat-->
          <div class="rounded min-w-125px py-3 px-4 my-1 me-6" style="border: 1px dashed rgba(255, 255, 255, 0.15)">
            <!--begin::Number-->
            <div class="d-flex align-items-center">
              <div class="text-white fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="4368" data-kt-countup-prefix="$" data-kt-initialized="1">4</div>
            </div>
            <!--end::Number-->

            <!--begin::Label-->
            <div class="fw-semibold fs-6 text-white opacity-50">Mata Pelajaran</div>
            <!--end::Label-->
          </div>
          <!--end::Stat-->

          <!--begin::Stat-->
          <div class="rounded min-w-125px py-3 px-4 my-1" style="border: 1px dashed rgba(255, 255, 255, 0.15)">
            <!--begin::Number-->
            <div class="d-flex align-items-center">
              <div class="text-white fs-2 fw-bold counted" data-kt-countup="true" data-kt-countup-value="120,000" data-kt-initialized="1">120</div>
            </div>
            <!--end::Number-->

            <!--begin::Label-->
            <div class="fw-semibold fs-6 text-white opacity-50">BAB Materi</div>
            <!--end::Label-->
          </div>
          <!--end::Stat-->
        </div>
        <!--end::Wrapper-->

      </div>
      <!--end::Body-->
    </div>
    <!--end::Card widget 1-->


  </div>
</div>

<table id="tbl_additional" class="table table-striped">
  <thead>
    <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
      <th class="text-center">#</th>
      <th>Mata Pelajaran</th>
      <th class="text-center">Kelas</th>
      <th class="text-center">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($subjects as $k => $v) : ?>
      <tr>
        <td class="text-center"><?= $k + 1 ?></td>
        <td><?= $v['subject_name'] ?></td>
        <td class="text-center"><?= $v['student_group_grade'] ?></td>
        <td class="text-center">
          <?= view_content('teacher/lesson/additional/view-content/' . $v['subject_id'] . '/' . $v['student_group_grade']) ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
</div>


<?php $this->endSection(); ?>