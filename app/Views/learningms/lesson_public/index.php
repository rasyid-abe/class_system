<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="card">
    <div class="card-body py-4">
        <table id="kt_datatable_dom_positioning" class="table table-striped">
            <thead>
                <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                    <th class="text-center">#</th>
                    <th>Mata Pelajaran</th>
                    <th class="text-center">Kelas</th>
                    <th>BAB</th>
                    <th>Topik</th>
                    <th>Dibagikan Oleh</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($shared as $k => $v): ?>
                    <?php $degr = $v['teacher_degree'] != '' ? ', ' . $v['teacher_degree'] : ''  ?>
                    <tr>
                        <td class="text-center"><?= $k+1 ?></td>
                        <td><?= $v['subject_name'] ?></td>
                        <td class="text-center"><?= $v['lesson_additional_grade'] ?></td>
                        <td><?= $v['lesson_additional_chapter'] ?></td>
                        <td><?= $v['lesson_additional_subchapter'] ?></td>
                        <td><?= $v['teacher_first_name'] . ' ' . $v['teacher_last_name'] . $degr ?></td>
                        <td class="text-center">
                            <?= view_content('teacher/lesson/public/view-content/' . $v['lesson_additional_id']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<?php $this->endSection(); ?>