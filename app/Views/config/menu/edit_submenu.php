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
                </div>
            </div>
            <div class="card-body">
                <form action="<?= base_url('/config/menu/update') ?>" method="POST">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="menu_id" value="<?= $menu['menu_id'] ?>">
                    <input type="hidden" name="parent" value="<?= $parent ?>">
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
                        <input type="text" class="form-control form-control-sm <?= $fe ?>" name="name" id="name" value="<?= old('name') ? old('name') : $menu['menu_name'] ?>" />
                        <?= $msg ?>
                    </div>
                    <div class="mb-10">
                        <?php 
                            $fe = $le = $msg = '';
                            if (session('valid') && array_key_exists("url", session('valid'))) {
                                $fe = "is-invalid";
                                $le = 'text-danger';
                                $msg = '<small class="text-danger">'.session('valid')['url'].'</small>';
                            }
                        ?>
                        <label for="url" class="required form-label <?= $le ?>">URL</label>
                        <input type="text" class="form-control form-control-sm <?= $fe ?>" name="url" id="url" value="<?= old('url') ? old('url') : $menu['menu_url'] ?>" />
                        <?= $msg ?>
                    </div>
                    <div class="mb-10">
                        <?php 
                            $fe = $le = $msg = '';
                            if (session('valid') && array_key_exists("icon", session('valid'))) {
                                $fe = "is-invalid";
                                $le = 'text-danger';
                                $msg = '<small class="text-danger">'.session('valid')['icon'].'</small>';
                            }
                        ?>
                        <label for="icon" class="form-label <?= $le ?>">Ikon</label>
                        <input type="text" class="form-control form-control-sm <?= $fe ?>" name="icon" id="icon" value="<?= old('icon') ? old('icon') : $menu['menu_icon'] ?>" />
                        <?= $msg ?>
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