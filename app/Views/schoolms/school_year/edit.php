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
                <form action="<?= base_url('/sms/master/school-year/update') ?>" method="POST">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="school_year_id" value="<?= $row['school_year_id'] ?>">
                    <div class="mb-10">
                        <?php 
                            $fe = $le = $msg = '';
                            if (session('valid') && array_key_exists("year_period", session('valid'))) {
                                $fe = "is-invalid";
                                $le = 'text-danger';
                                $msg = '<small class="text-danger">'.session('valid')['year_period'].'</small>';
                            }
                        ?>
                        <label for="name" class="required form-label <?= $le ?>">Tahun Pelajaran</label>
                        <input type="text" class="form-control form-control-sm <?= $fe ?>" name="year_period" id="year_period" value="<?= old('year_period') ? old('year_period') : $row['school_year_period'] ?>" />
                        <?= $msg ?>
                    </div>
                    <div class="mb-10">
                        <?php 
                            $fe = $le = $msg = '';
                            if (session('valid') && array_key_exists("start_date_one", session('valid'))) {
                                $fe = "is-invalid";
                                $le = 'text-danger';
                                $msg = '<small class="text-danger">'.session('valid')['start_date_one'].'</small>';
                            }
                        ?>
                        <label for="name" class="required form-label <?= $le ?>">Awal Semester Gasal</label>
                        <input type="date" class="form-control form-control-sm <?= $fe ?>" name="start_date_one" id="start_date_one" value="<?= old('start_date_one') ? old('start_date_one') : $row['school_year_start_date_one'] ?>" />
                        <?= $msg ?>
                    </div>
                    <div class="mb-10">
                        <?php 
                            $fe = $le = $msg = '';
                            if (session('valid') && array_key_exists("end_date_one", session('valid'))) {
                                $fe = "is-invalid";
                                $le = 'text-danger';
                                $msg = '<small class="text-danger">'.session('valid')['end_date_one'].'</small>';
                            }
                        ?>
                        <label for="name" class="required form-label <?= $le ?>">Akhir Semester Gasal</label>
                        <input type="date" class="form-control form-control-sm <?= $fe ?>" name="end_date_one" id="end_date_one" value="<?= old('end_date_one') ? old('end_date_one') : $row['school_year_end_date_one'] ?>" />
                        <?= $msg ?>
                    </div>
                    <div class="mb-10">
                        <?php 
                            $fe = $le = $msg = '';
                            if (session('valid') && array_key_exists("start_date_two", session('valid'))) {
                                $fe = "is-invalid";
                                $le = 'text-danger';
                                $msg = '<small class="text-danger">'.session('valid')['start_date_two'].'</small>';
                            }
                        ?>
                        <label for="name" class="required form-label <?= $le ?>">Awal Semester Genap</label>
                        <input type="date" class="form-control form-control-sm <?= $fe ?>" name="start_date_two" id="start_date_two" value="<?= old('start_date_two') ? old('start_date_two') : $row['school_year_start_date_two'] ?>" />
                        <?= $msg ?>
                    </div>
                    <div class="mb-10">
                        <?php 
                            $fe = $le = $msg = '';
                            if (session('valid') && array_key_exists("end_date_two", session('valid'))) {
                                $fe = "is-invalid";
                                $le = 'text-danger';
                                $msg = '<small class="text-danger">'.session('valid')['end_date_two'].'</small>';
                            }
                        ?>
                        <label for="name" class="required form-label <?= $le ?>">Ahir Semester Genap</label>
                        <input type="date" class="form-control form-control-sm <?= $fe ?>" name="end_date_two" id="end_date_two" value="<?= old('end_date_two') ? old('end_date_two') : $row['school_year_end_date_two'] ?>" />
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