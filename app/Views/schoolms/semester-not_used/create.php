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
                <form action="<?= base_url('/sms/master/semester/store') ?>" method="POST">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id_ta" value="<?= $id_ta ?>">
                    <div
                        class="form-group <?= session('valid') && array_key_exists("semester_name", session('valid')) ? 'has-error has-feedback' : '' ?>">
                        <label for="semester_name">Semester <span class="text-danger">*</span></label>
                        <select class="form-control" name="semester_name" id="semester_name">
                            <option value="">Pilih Semester</option>
                            <option value="Gasal" <?= old('semester_name') == 'Gasal' ? 'selected' : '' ?> >Gasal</option>
                            <option value="Genap" <?= old('semester_name') == 'Genap' ? 'selected' : '' ?> >Genap</option>
                        </select>
                        <?php if (session('valid') && array_key_exists("semester_name", session('valid'))): ?>
                            <small class="text-danger">
                                <?= session('valid')['semester_name'] ?>
                            </small>
                        <?php endif; ?>
                    </div>
                    <div
                        class="form-group <?= session('valid') && array_key_exists("start_date", session('valid')) ? 'has-error has-feedback' : '' ?>">
                        <label for="start_date">Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="start_date" id="start_date"
                            value="<?= old('start_date') ?>">
                        <?php if (session('valid') && array_key_exists("start_date", session('valid'))): ?>
                            <small class="text-danger">
                                <?= session('valid')['start_date'] ?>
                            </small>
                        <?php endif; ?>
                    </div>
                    <div
                        class="form-group <?= session('valid') && array_key_exists("end_date", session('valid')) ? 'has-error has-feedback' : '' ?>">
                        <label for="end_date">Tanggal Akhir <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="end_date" id="end_date"
                            value="<?= old('end_date') ?>">
                        <?php if (session('valid') && array_key_exists("end_date", session('valid'))): ?>
                            <small class="text-danger">
                                <?= session('valid')['end_date'] ?>
                            </small>
                        <?php endif; ?>
                    </div>
                    <hr>
                    <div class="form-group">
                        <button type="submit" class="btn btn-md btn-round btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>