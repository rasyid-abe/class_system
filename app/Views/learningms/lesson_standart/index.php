<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="card">
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