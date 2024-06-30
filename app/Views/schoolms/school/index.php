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
                    <div class="ml-auto">
                        <?= button_export('/sms/user/school/export') ?>
                        <?= button_add('/sms/user/school/create') ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="add-row" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">NPSN</th>
                                <th>Nama Sekolah</th>
                                <th class="text-center">Jenjang</th>
                                <th class="text-center">Logo</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($school as $k => $v): ?>
                                <tr>
                                    <td class="text-center">
                                        <?= $k + 1 ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $v['school_npsn'] ?>
                                    </td>
                                    <td>
                                        <?= $v['school_name'] ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $level[$v['school_level']] ?>
                                    </td>
                                    <td class="text-center">
                                        <img src="<?= base_url() ?>images/school/<?= $v['school_logo'] ?>" width="80"
                                            class="py-2">
                                    </td>
                                    <td class="text-center">
                                        <?= $v['school_status'] > 0 ? '<span class="badge badge-pill badge-success p-2">Aktif</span>' : '<span class="badge badge-pill badge-secondary p-2">Tidak Aktif</span>' ?>
                                    </td>
                                    <td class="text-center">
                                        <?= button_detail('/sms/user/school/show/' . $v['school_id']) ?>
                                        <?= button_activate('/sms/user/school/status/' . $v['school_id'] . '/' . $v['school_status'], $v['school_status']) ?>
                                        <?= button_reset_password($v['school_id']) ?>
                                        <?= button_edit('/sms/user/school/edit/' . $v['school_id']) ?>
                                        <?= button_delete('/sms/user/school/destroy/' . $v['school_id']) ?>
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

<div class="modal fade" id="addRowModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h5 class="modal-title">
                    <span class="fw-mediumbold">
                        Import</span>
                    <span class="fw-light">
                        Data
                    </span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="small d-inline">
                    Download template excel berikut untuk import data: 
                    <form action="<?= base_url('/sms/user/school/export') ?>" method="post" class="d-inline">
                        <?= csrf_field() ?>
                        <button type="submit" id="addRowButton" class="btn btn-primary btn-xs">Template Excel</button> 
                    </form>
                </p>
                <p class="small">
                    <b>Catatan :</b>
                    Anda hanya dapat mengubah cel yang berwarna putih.
                </p>
                <hr>
                <form action="<?= base_url('/sms/user/school/import/') ?>" method="post" enctype="multipart/form-data">
                    <?php csrf_field() ?>
                    </label>
                    <input type="file" name="import" class="form-control-file"
                        accept="applicatlion/xlsx">
                    </div>
            <div class="modal-footer no-bd">
                <button type="submit" class="btn btn-sm btn-round btn-primary">Import</button>
                <button type="button" class="btn btn-danger btn-round btn-sm" data-dismiss="modal">Close</button>
            </div>
        </form>
        </div>
    </div>
</div>

<script>
    function reset_password(id) {
        $.ajax({
            url: "<?= base_url('/sms/user/school/reset-password') ?>",
            type: "post",
            data: {id},
            dataType: "json",
            success: function (data) {
                $.toast({
                    heading: data.status ? 'Berhasil Reset Password' : 'Gagal Reset Password',
                    text: data.status ? 'Password Baru : '+ data.new_pass : 'Terjadi kesalahan.',
                    showHideTransition: 'fade',
                    position: 'top-right',
                    icon: data.status ? 'success' : 'error',
                    hideAfter: false,
                })
            },
        });
    }
</script>

<?php $this->endSection(); ?>