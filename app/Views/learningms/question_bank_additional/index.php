<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>


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
          <?= view_content('teacher/question-bank/additional/view-content/' . $v['subject_id'] . '/' . $v['student_group_grade']) ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
</div>


<?php $this->endSection(); ?>