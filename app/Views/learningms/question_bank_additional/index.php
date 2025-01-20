<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="row">
  <div class="col-lg-4 mb-5">

    <div class="card card-flush border-0 h-xl-100" data-bs-theme="light" style="background-color: #192440">
      <div class="card-header pt-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
          <div class="d-flex flex-column">
            <div class="d-flex align-items-center mb-2">
              <a href="#" class="text-light fs-2 fw-bold me-1">Ringkasan Informasi</a>
            </div>

            <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
              <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5">
                Bank Soal Saya
              </a>
            </div>
          </div>

        </div>
      </div>
      <div class="card-body d-flex justify-content-between flex-column pt-1 px-0 pb-0">
        <div class="d-flex flex-wrap px-9 mb-5">
          <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
            <div class="d-flex align-items-center">
              <div class="fs-2 fw-bold text-light" id="lesadd_chap">memuat...</div>
            </div>

            <div class="fw-semibold fs-6 text-gray-500">Judul Soal</div>
          </div>

          <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
            <div class="d-flex align-items-center">
              <div class="fs-2 fw-bold text-light" id="lesadd_subchap">memuat...</div>
            </div>

            <div class="fw-semibold fs-6 text-gray-500">Soal</div>
          </div>
        </div>
      </div>
    </div>


  </div>
</div>

<div class="list_subject_qb" id="list_subject_qb"></div>
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
          <?= view_task('teacher/question-bank/additional/view-content/' . $v['subject_id'] . '/' . $v['student_group_grade']) ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
</div>


<?php $this->endSection(); ?>