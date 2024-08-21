<?php $this->extend('templates/auth') ?>
<?php $this->section('content'); ?>

<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
    <a href="<?= base_url('/') ?>" class="mb-12">
        <img alt="Logo" src="<?= base_url() ?>assets/media/logos/logo-default.svg" class="h-60px">
    </a>

    <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">

        <div class="text-center mb-10">
            <h1 class="text-dark mb-3">
                Lupa Password ?
            </h1>

            <div class="text-gray-400 fw-semibold fs-4">
                Masukkan email untuk reset password kamu.
            </div>
        </div>

        <div class="fv-row mb-10 fv-plugins-icon-container">
            <label class="form-label fw-bold text-gray-900 fs-6">Email</label>
            <input class="form-control form-control-solid" type="email" placeholder="" name="email" autocomplete="off">
            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
        </div>

        <div class="d-flex flex-wrap justify-content-center pb-lg-0">
            <button type="button" id="send_email" class="btn btn-lg btn-primary fw-bold me-4">
                <span class="indicator-label">
                    Kirim
                </span>
                <span class="indicator-progress">
                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>

            <a href="<?= base_url('/') ?>" class="btn btn-lg btn-light-primary fw-bold">Kembali</a>
        </div>
    </div>
</div>

<script>

    $('#send_email').on('click', function () {
        let email = $('#val_email').val();
        console.log(email);
        $.ajax({
            url: "<?= base_url('/request-reset') ?>",
            type: "post",
            data: { 'email': email },
            dataType: "json",
            beforeSend: function () {
                show_loading()
            },
            success: function (data) {
                response(data)
                hide_loading()
            }
        })
    })

    function response(data) {
        if (data.sts == false) {
            $.toast({
                heading: 'Gagal',
                text: data.msg,
                showHideTransition: 'fade',
                position: 'top-right',
                icon: 'error'
            })
        } else {
            $('#val_email').val('');
            Swal.fire({
                html: data.msg,
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Ok",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }
    }
</script>

<?php $this->endSection(); ?>