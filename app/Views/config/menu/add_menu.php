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
                <form action="<?= base_url('/config/menu/save') ?>" method="POST">
                    <?= csrf_field(); ?>
                    <div class="mb-10">
                        <?php 
                            $fe = $le = $msg = '';
                            if (session('valid') && array_key_exists("name", session('valid'))) {
                                $fe = "is-invalid";
                                $le = 'text-danger';
                                $msg = '<small class="text-danger">'.session('valid')['name'].'</small>';
                            }
                        ?>
                        <label for="name" class="required form-label <?= $le ?>">Nama</label>
                        <input type="text" class="form-control form-control-sm <?= $fe ?>" name="name" id="name" value="<?= old('name') ?>" />
                        <?= $msg ?>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-md btn-round btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>