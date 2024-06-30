<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center mx-2">
                    <h4 class="card-title">
                        <?= end($breadcrumb) ?>
                    </h4>
                </div>
            </div>
            <div class="card-body">
                <form action="<?= base_url('/config/role/update') ?>" method="POST">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="role_id" value="<?= $role['role_id'] ?>">
                    <div class="mb-10">
                        <?php 
                            $fe = $le = $msg = '';
                            if (session('valid') && array_key_exists("name", session('valid'))) {
                                $fe = "is-invalid";
                                $le = 'text-danger';
                                $msg = '<small class="text-danger">'.session('valid')['name'].'</small>';
                            }
                        ?>
                        <label for="name" class="required form-label <?= $le ?>">Nama Role</label>
                        <input type="text" class="form-control form-control-sm <?= $fe ?>" name="name" id="name" value="<?= old('name') ? old('name') : $role['role_name'] ?>" />
                        <?= $msg ?>
                    </div>
                    <div class="mb-10">
                        <label for="url" class="form-label">Keterangan</label>
                        <textarea class="form-control  form-control-sm" name="desc" id="desc" cols="30" rows="3"><?= old('desc') ? old('desc') : $role['role_description'] ?></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-md btn-round btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>