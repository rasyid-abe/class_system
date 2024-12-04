<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="card">
    <div class="card-body py-4">
        <table id="kt_datatable_dom_positioning" class="table table-striped">
            <thead>
                <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                    <th class="text-center">#</th>
                    <th>Soal</th>
                    <th class="text-center">Total Soal</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($subjects as $k => $v) : ?>
            <tr>
                <td class="text-center"><?= $k + 1 ?></td>
                <td><?= $v['subject_name'] ?></td>
                <td class="text-center"><?= $v['total'] ?></td>
                <td class="text-center">
                    <?= view_task('teacher/question-bank/standart/view-content/' . $v['teacher_assign_subject_id'] . '/' . $v['teacher_assign_grade']) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
    </div>
</div>

<?php $this->endSection(); ?>