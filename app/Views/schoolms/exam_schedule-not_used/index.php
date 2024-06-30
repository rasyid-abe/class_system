<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-toolbar">
            <?= button_add('/sms/master/exam-schedule/create') ?>
        </div>
    </div>
    <div class="card-body py-4">
        <table id="kt_datatable_dom_positioning" class="table table-striped">
            <thead>
                <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                    <th class="text-center">#</th>
                    <th class="text-center">Hari</th>
                    <th class="text-center">Jam Ke</th>
                    <th class="text-center">Waktu</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($row as $k => $v): ?>
                    <tr>
                        <td class="text-center"><?= $k+1 ?></td>
                        <td class="text-center"><?= $days[$v['exam_schedule_day']] ?></td>
                        <td class="text-center"><?= $v['exam_schedule_order'] ?></td>
                        <td class="text-center"><?= $v['exam_schedule_time'] ?></td>
                        <td class="text-center">
                            <?= button_edit('/sms/master/exam-schedule/edit/' . $v['exam_schedule_id']) ?>
                            <?= button_delete('/sms/master/exam-schedule/destroy/' . $v['exam_schedule_id']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $("#kt_datatable_dom_positioning").DataTable({
        "language": {
            "lengthMenu": "_MENU_",
        },
        "dom":
            "<'row'" +
            "<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'l>" +
            "<'col-sm-12 col-md-6 d-flex align-items-center justify-content-end justify-content-md-end'f>" +
            ">" +

            "<'table-responsive'tr>" +
            "<'row'" +
            "<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start justify-content-md-start'i>" +
            "<'col-sm-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            ">"
    });
</script>

<?php $this->endSection(); ?>