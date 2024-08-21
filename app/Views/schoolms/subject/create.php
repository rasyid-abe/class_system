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
                <form action="<?= base_url('/sms/master/subject/store') ?>" method="POST">
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
                        <label for="name" class="required form-label <?= $le ?>">Mata Pelajaran</label>
                        <input type="text" class="form-control form-control-sm <?= $fe ?>" name="name" id="name" value="<?= old('name') ?>" />
                        <?= $msg ?>
                    </div>
                    <div class="mb-10">
                        <?php 
                            $fe = $le = $msg = '';
                            if (session('valid') && array_key_exists("grade", session('valid'))) {
                                $fe = "is-invalid";
                                $le = 'text-danger';
                                $msg = '<small class="text-danger">'.session('valid')['grade'].'</small>';
                            }
                        ?>
                        <label for="grade" class="required form-label <?= $le ?>">Kelas</label>
                        <select class="form-select form-control-md" id="grade" name="grade">
                        <option value="">Pilih Kelas</option>
                            <?php foreach ($grade as $k => $v): ?>
                                <option value="<?= $k ?>" <?= old('grade') == $k ? 'selected' : '' ?> ><?= $v ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= $msg ?>
                    </div>
                    <div class="mb-10">
                        <?php 
                            $fe = $le = $msg = '';
                            if (session('valid') && array_key_exists("major", session('valid'))) {
                                $fe = "is-invalid";
                                $le = 'text-danger';
                                $msg = '<small class="text-danger">'.session('valid')['major'].'</small>';
                            }
                        ?>
                        <label for="major" class="form-label <?= $le ?>">Jurusan</label>
                        <select class="form-select form-control-md" id="major" name="major">
                            <option value="">Pilih Jurusan</option>
                            <?php foreach ($major as $k => $v): ?>
                                <option value="<?= $v['major_id'] ?>" <?= old('major') == $v['major_id'] ? 'selected' : '' ?> ><?= $v['major_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= $msg ?>
                    </div>
                    <div class="mb-10">
                        <?php 
                            $fe = $le = $msg = '';
                            if (session('valid') && array_key_exists("option", session('valid'))) {
                                $fe = "is-invalid";
                                $le = 'text-danger';
                                $msg = '<small class="text-danger">'.session('valid')['option'].'</small>';
                            }
                        ?>
                        <label for="option" class="required form-label <?= $le ?>">Tipe Mata Pelajaran</label>
                        <br>
                        <div class="form-check form-check-custom form-check-solid me-10 form-check-inline">
                            <input class="form-check-input" type="radio" name="option" value="1" id="opt1" <?= old("option") == 1 ? 'checked' : '' ?> />
                            <label class="form-check-label text-dark" for="opt1">
                                Wajib
                            </label>
                        </div>
                        <div class="form-check form-check-custom form-check-solid me-10 form-check-inline">
                            <input class="form-check-input" type="radio" name="option" value="2" id="opt2" <?= old("option") == 2 ? 'checked' : '' ?>/>
                            <label class="form-check-label text-dark" for="opt2">
                                Pilihan
                            </label>
                        </div>
                        <br>
                        <?= $msg ?>
                    </div>
                    <div class="mb-10">
                        <?php 
                            $fe = $le = $msg = '';
                            if (session('valid') && array_key_exists("desc", session('valid'))) {
                                $fe = "is-invalid";
                                $le = 'text-danger';
                                $msg = '<small class="text-danger">'.session('valid')['desc'].'</small>';
                            }
                        ?>
                        <label for="name" class="form-label <?= $le ?>">Deskripsi</label>
                        <textarea class="form-control form-control-sm" name="desc" id="desc" cols="30" rows="3"><?= old('desc') ?></textarea>
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