<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center mx-2">
                    <h4 class="card-title">
                        <?= end($breadcrumb) ?>
                    </h4>
                    <?= button_add('/sms/master/semester/create/'.$id_ta) ?>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="add-row" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Semester</th>
                                <th class="text-center">Tanggal Mulai</th>
                                <th class="text-center">Tanggal Akhir</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($row as $k => $v): ?>
                                <tr>
                                    <td class="text-center"><?= $k+1 ?></td>
                                    <td class="text-center"><?= $v['semester_name'] ?></td>
                                    <td class="text-center"><?= $v['semester_start_date'] ?></td>
                                    <td class="text-center"><?= $v['semester_end_date'] ?></td>
                                    <td class="text-center">
                                        <?= button_edit('/sms/master/semester/edit/'.$v['semester_school_period_id'] .'/'. $v['semester_id']) ?>
                                        <?= button_delete('/sms/master/semester/destroy/'.$v['semester_school_period_id'] .'/'. $v['semester_id']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>