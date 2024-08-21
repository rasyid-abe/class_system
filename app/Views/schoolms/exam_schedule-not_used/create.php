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
                <form action="<?= base_url('/sms/master/exam-schedule/store') ?>" method="POST">
                    <?= csrf_field(); ?>
                    <div class="mb-10">
                        <?php
                        $fe = $le = $msg = '';
                        if (session('valid') && array_key_exists("day", session('valid'))) {
                            $fe = "is-invalid";
                            $le = 'text-danger';
                            $msg = '<small class="text-danger">' . session('valid')['day'] . '</small>';
                        }
                        ?>
                        <label for="day" class="required form-label <?= $le ?>">Hari</label>
                        <select class="form-select form-control-md" id="day" name="day">
                            <option value="">Pilih Hari</option>
                            <?php foreach ($days as $k => $v): ?>
                                <option value="<?= $k ?>" <?= old('day') == $k ? 'selected' : '' ?>>
                                    <?= $v ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?= $msg ?>
                    </div>
                    <div class="mb-10">
                        <?php
                        $fe = $le = $msg = '';
                        if (session('valid') && array_key_exists("order", session('valid'))) {
                            $fe = "is-invalid";
                            $le = 'text-danger';
                            $msg = '<small class="text-danger">' . session('valid')['order'] . '</small>';
                        }
                        ?>
                        <label for="order" class="form-label required <?= $le ?>">Jam Ke</label>
                        <select class="form-select form-control-md" id="order" name="order">
                            <option value="">Pilih Jam Ke</option>
                            <?php for($i=1; $i <= 16; $i++): ?>
                                <option value="<?= $i ?>" <?= old('order') == $i ? 'selected' : '' ?>>
                                    <?= $i ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                        <?= $msg ?>
                    </div>
                    <div class="col-md-12 fv-row">
                        <div class="row mb-5">
                            <div class="col-md-6 fv-row">
                                <?php
                                $fe = $le = $msg = '';
                                if (session('valid') && array_key_exists("time1", session('valid'))) {
                                    $fe = "is-invalid";
                                    $le = 'text-danger';
                                    $msg = '<small class="text-danger">' . session('valid')['time1'] . '</small>';
                                }
                                ?>
                                <label for="time1" class="form-label required <?= $le ?>">Mulai</label>
                                <input class="form-control <?= $fe ?>" name="time1" id="time1"
                                    value="<?= old('time1') ?>" />
                                <?= $msg ?>
                            </div>
                            <div class="col-md-6 fv-row">
                                <?php
                                $fe = $le = $msg = $msg2 = '';
                                if (session('valid') && array_key_exists("time2", session('valid'))) {
                                    $fe = session('valid')['time2'] == "Kolom waktu akhir harus diisi" ? "is-invalid" : '';
                                    $le = session('valid')['time2'] == "Kolom waktu akhir harus diisi" ? 'text-danger' : '';
                                    $msg = '<small class="text-danger">' . session('valid')['time2'] . '</small>';
                                    $msg2 = '<small class="text-danger">' . session('valid')['time2'] . '</small>';
                                }
                                ?>
                                <label for="time2" class="form-label required <?= $le ?>">Akhir</label>
                                <input class="form-control <?= $fe ?>" name="time2" id="time2"
                                    value="<?= old('time2') ?>" />
                                <?php if (session('valid') && array_key_exists("time2", session('valid'))): ?>
                                    <?= session('valid')['time2'] == "Kolom waktu akhir harus diisi" ? $msg : '' ?>
                                <?php endif; ?>
                            </div>
                            <?php if (session('valid') && array_key_exists("time2", session('valid'))): ?>
                                <?= session('valid')['time2'] != "Kolom waktu akhir harus diisi" ? $msg2 : '' ?>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-md btn-round btn-primary">Submit</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $("#time1").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
    });
    $("#time2").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
    });

</script>

<?php $this->endSection(); ?>