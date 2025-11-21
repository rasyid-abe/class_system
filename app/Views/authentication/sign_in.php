<?php $this->extend('templates/auth') ?>
<?php $this->section('content'); ?>

<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
    <a href="<?= base_url('/') ?>" class="mb-12">
        <img alt="Logo" src="<?= base_url() ?>assets/media/logos/logo-default.svg" class="h-60px" />
    </a>

    <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">

        <form class="form w-100" novalidate="novalidate" method="post" action="<?= base_url('/login') ?>">
            <?= csrf_field(); ?>
            <div class="text-center mb-10">
                <h1 class="text-dark mb-3">
                    Selamat Datang di Kelas Online </h1>

                <div class="text-gray-400 fw-semibold fs-4">
                    Login untuk masuk ke sistem
                </div>
            </div>

            <div class="fv-row mb-10">
                <label class="form-label fs-6 fw-bold text-dark">Username</label>

                <input class="form-control form-control-lg form-control-solid" type="text" name="username"
                    autocomplete="off" />
            </div>

            <div class="fv-row mb-10">
                <div class="d-flex flex-stack mb-2">
                    <label class="form-label fw-bold text-dark fs-6 mb-0">Password</label>

                    <a href="<?= base_url('/forgot-password') ?>" class="link-primary fs-6 fw-bold">
                        Lupa Password ?
                    </a>
                </div>

                <div class="position-relative mb-3">
                    <input class="form-control form-control-lg form-control-solid" id="pass_" type="password" name="password" autocomplete="off">

                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2 pl-4" data-kt-password-meter-control="visibility">
                        <i class="fs-1 mr-2 bi bi-eye-slash-fill show_password"></i>&nbsp;
                    </span>
                </div>
            </div>

            <div class="fv-row mb-10">
                <label class="form-label fs-6 fw-bold text-dark">QA Date</label>

                <input class="form-control form-control-lg form-control-solid" type="date" name="fake_date"
                    autocomplete="off" />
            </div>

            <div class="text-center">
                <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                    <span class="indicator-label">
                        Login
                    </span>

                    <span class="indicator-progress">
                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>

            </div>
        </form>
    </div>

    <div class="tbl-request"></div>
</div>


<script>
    // $(document).ready(function() {
    //     let val_period = [1000, 850, 765, 688.5, 619.65, 557.69, 501.92]

    //     let rows = ''
    //     for (let i0 = 0; i0 <= 7; i0++) {
    //         for (let i1 = 0; i1 < i0; i1++) {
    //             for (let i2 = 0; i2 < 12; i2++) {
    //                 rows += `
    //                     <tr>
    //                         <td>AMORT_MOTOR_${i1+1}Y</td>
    //                         <td>${i2}</td>
    //                         <td>MTH</td>
    //                         <td>${val_period[i1]}</td>
    //                     </tr>
    //                 `
    //             }
    //         }
    //     }

    //     let table = `
    //         <table class="table">
    //         <thead>
    //             <tr>
    //                 <th>PATTERN</th>
    //                 <th>PERIOD</th>
    //                 <th>FREQUENCY</th>
    //                 <th>RATIO</th>
    //             </tr>
    //         </thead>
    //         <tbody>
    //             ${rows}
    //         </tbody>
    //         </table>
    //     `

    //     $('.tbl-request').html(table)
    // })
</script>


<?php $this->endSection(); ?>