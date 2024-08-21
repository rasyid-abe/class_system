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
                <form action="<?= base_url('/sms/master/major/store') ?>" method="POST">
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
                        <label for="name" class="required form-label <?= $le ?>">Jurusan</label>
                        <input type="text" class="form-control form-control-sm <?= $fe ?>" name="name" id="name" value="<?= old('name') ?>" />
                        <?= $msg ?>
                    </div>
                    <div class="mb-10">
                        <?php 
                            $fe = $le = $msg = '';
                            if (session('valid') && array_key_exists("phase", session('valid'))) {
                                $fe = "is-invalid";
                                $le = 'text-danger';
                                $msg = '<small class="text-danger">'.session('valid')['phase'].'</small>';
                            }
                        ?>
                        <label for="phase" class="form-label <?= $le ?>">Fase Belajar</label>
                        <select class="form-select form-control-md" data-control="select2" id="phase" name="phase">
                            <option value="0">Pilih Fase Belajar</option>
                        </select>
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
                        <label for="grade" class="form-label <?= $le ?>">Kelas</label>
                        <select class="form-select form-control-md" data-control="select2" id="grade" name="grade">
                            <option value="0">Pilih Kelas</option>
                        </select>
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

<script>

    $(document).ready(function(){
        ref_data();
    })

    $('#phase').on('change', function () {
        let params = {
            'code': $(this).val(),
            'len': 8,
            'fillen': 5,
            'title': 'subdistrict',
            'old': ''
        }
        if ($(this).val() == "0") {
            $("#phase").html("<option value=\'0\'>Pilih Fase Belajar</option>");
        } else {
            ref_data(params);
        }
    })

    function ref_data() {
        jQuery.ajax({
            url: "<?= base_url('/teacher/lesson/standart/ref-data') ?>",
            type: "post",
            data: {'id':0},
            dataType: "json",
            success: function (data) {
                console.log(data);
                // let selected = params.old != '' ? params.old : '';
                let option = `<option value="0">Pilih Fase Belajar</option>`;
                $.each(data, function (k, v) {
                    option += `<option value="${k}">${v.name}</option>`;
                });
                $("#phase").html(option);
                
                // jQuery.toast({
                //     heading: data.status ? 'Sukses' : 'Gagal',
                //     text: data.status ? 'Password Baru : '+ data.new_pass : 'Terjadi kesalahan.',
                //     showHideTransition: 'fade',
                //     position: 'top-right',
                //     icon: data.status ? 'success' : 'error',
                //     hideAfter: false,
                // })
            },
        });
    }


</script>

<?php $this->endSection(); ?>