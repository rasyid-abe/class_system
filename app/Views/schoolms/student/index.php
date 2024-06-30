<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<style>
input[type="file"]::file-selector-button {
    border-radius: 4px;
    padding: 0 16px;
    height: 25px;
    cursor: pointer;
    background-color: #2884EF;
    color: white;
    border: 1px solid rgba(0, 0, 0, 0.16);
    box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.05);
    margin-right: 16px;
    margin-left: 0px;
    transition: background-color 200ms;
}

input[type="file"]::file-selector-button:hover {
    background-color: #f3f4f6;
}

input[type="file"]::file-selector-button:active {
    background-color: #e5e7eb;
}
</style>

<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-toolbar">
            <?= button_import() ?>&nbsp;
            <?= button_export('/sms/user/student/export') ?>&nbsp;
            <?= button_add('/sms/user/student/create') ?>
        </div>
    </div>
    <div class="card-body py-4">
        <table id="kt_datatable_dom_positioning" class="table table-striped align-middle">
            <thead>
                <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                    <th class="text-center">#</th>
                    <th>Siswa</th>
                    <th class="text-center">Jenjang Kelas</th>
                    <th class="text-center">Nama Kelas</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($student as $k => $v): ?>
                    <tr>
                        <td class="text-center">
                            <?= $k + 1 ?>
                        </td>
                        <td class="d-flex align-items-center">
                            <!--begin:: Avatar -->
                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                <a href="<?= base_url('/sms/user/student/show/' . $v['student_id']) ?>">
                                    <div class="symbol-label">
                                        <img src="<?= base_url('images/student/') . $v['student_image'] ?>" alt="<?= $v['student_first_name'].' '.$v['student_last_name'] ?>"
                                            class="w-100" />
                                    </div>
                                </a>
                            </div>
                            <!--end::Avatar-->
                            <!--begin::User details-->
                            <div class="d-flex flex-column">
                                <a href="<?= base_url('/sms/user/student/show/' . $v['student_id']) ?>"
                                    class="text-gray-800 text-hover-primary mb-1"><?= $v['student_first_name'].' '.$v['student_last_name'] ?></a>
                                <span><?= $v['student_nisn'] ?></span>
                            </div>
                            <!--begin::User details-->
                        </td>
                        <td class="text-center"><?= $grade[$v['grade']] ?></td>
                        <td class="text-center"><?= $v['student_group_name'] ?></td>
                        <td>
                            <div
                                class="d-flex flex-grow-1 justify-content-center align-items-center form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" id="chx_<?= $v['student_id'] ?>" type="checkbox" value="<?= $v['student_status'] ?>" data-id="<?= $v['student_id'] ?>"
                                    <?= check_status($v['student_status']) ?> />
                            </div>
                        </td>
                        <td class="text-center">
                            <?= button_detail('/sms/user/student/show/' . $v['student_id']) ?>
                            <?= button_credential('/sms/user/student/view-credential', $v['student_id']) ?>
                            <?= button_edit('/sms/user/student/edit/' . $v['student_id']) ?>
                            <?= button_delete('/sms/user/student/destroy/',  $v['student_id']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_insert">
    <div class="modal-dialog">
        <div class="modal-content" id="content_modal">
            <form action="<?= base_url('/sms/user/student/import-insert/') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <p class="d-inline" style="font-size: 9pt">
                        <b>Catatan :</b>
                        <br>
                        Download
                        <a href="<?= base_url('/sms/user/student/download'); ?>" class="btn btn-link btn-sm mb-1 btn-color-primary btn-active-color-warning">template </a>
                        berikut untuk import data baru.
                    </p>
                    
                    <div class="mt-5">
                        <input class="form-control form-control-sm btn-light" name="import" id="import" type="file">
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-light-danger" data-bs-dismiss="modal">Tutup</button>
                    <button type="sumbit" class="btn btn-sm btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_update">
    <div class="modal-dialog">
        <div class="modal-content" id="content_modal">
            <form action="<?= base_url('/sms/user/student/import-update/') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <p class="d-inline" style="font-size: 9pt">
                        <b>Catatan :</b>
                        <br>
                        Export excel terlebih dahulu untuk merubah data masal .
                    </p>
                    
                    <div class="mt-5">
                        <input class="form-control form-control-sm btn-light" name="import" id="import" type="file">
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-light-danger" data-bs-dismiss="modal">Tutup</button>
                    <button type="sumbit" class="btn btn-sm btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_credential">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <textarea name="myInput" class="form-control" id="myInput" cols="30" rows="6"></textarea>
                <br>
                <div class="justify-content-end">
                    <input type="button" id="btncopy" class="btn btn-sm btn-primary" onclick="myFunction()" value="Salin Informasi" />
                    <button type="button" class="btn btn-sm btn-light-danger" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $("#kt_datatable_dom_positioning").DataTable({
        "language": {
            "lengthMenu": "_MENU_",
        },
        "dom":
            "<'row'" +
            "<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'l>" +
            "<'col-sm-12 col-md-6 d-flex align-items-center justify-content-end justify-content-md-end'f>" +
            ">" +

            "<'table-responsive'tr>" +
            "<'row'" +
            "<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start justify-content-md-start'i>" +
            "<'col-sm-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            ">"
    });
    
</script>

<script type="text/javascript">
    jQuery('.form-check-input').on('click',function(e) {
        const id = $(this).data('id');
        const sts = $(this).val();
        e.preventDefault();

        Swal.fire({
            html: `Apakah anda ingin mengubah status?`,
            icon: "info",
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: 'Tidak',
            customClass: {
                confirmButton: "btn btn-sm btn-primary",
                cancelButton: 'btn btn-sm btn-danger'
            }
        }).then(function(confirm){
            if (confirm.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('/sms/user/student/status') ?>',
                    data: { 'id':id, 'sts':sts },
                    method: 'post',
                    dataType: 'json',
                    success: function (e) {
                        sts < 1 ? $('#chx_'+id).val(1) : $('#chx_'+id).val(0) 
                        sts < 1 ? $('#chx_'+id).prop('checked', true) : $('#chx_'+id).prop('checked', false) 
                        $.toast({
                            heading: 'Success',
                            text: 'Guru berhasil di' + e.msg,
                            showHideTransition: 'fade',
                            position: 'top-right',
                            icon: 'success'
                        })

                    }
                })
            }
        });
    });

    function reset_password(id) {
        jQuery.ajax({
            url: "<?= base_url('/sms/user/student/reset-password') ?>",
            type: "post",
            data: {id},
            dataType: "json",
            success: function (data) {
                jQuery.toast({
                    heading: data.status ? 'Sukses' : 'Gagal',
                    text: data.status ? 'Password Baru : '+ data.new_pass : 'Terjadi kesalahan.',
                    showHideTransition: 'fade',
                    position: 'top-right',
                    icon: data.status ? 'success' : 'error',
                    hideAfter: false,
                })
            },
        });
    }

    function myFunction() {
        // Get the text field
        var copyText = document.getElementById("myInput");

        // Select the text field
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.value);
        
        $('#btncopy').val('Disalin!')
    }

    $('.credential').on('click',function(e) {
        const id = $(this).data('id');
        const url = $(this).data('url');

        Swal.fire({
            html: `Apakah anda ingin reset password pengguna?`,
            icon: "info",
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: 'Tidak',
            customClass: {
                confirmButton: "btn btn-sm btn-primary",
                cancelButton: 'btn btn-sm btn-danger'
            }
        }).then(function(confirm){
            if (confirm.isConfirmed) {
                jQuery.ajax({
                    url: url,
                    type: "post",
                    data: {id},
                    dataType: "json",
                    success: function (data) {
                        let content = `BERIKUT PASSWORD BARU ANDA

Akun : ${data.user}
Username : ${data.username}
Passowrd : ${data.password}`;
                        $('#btncopy').val('Salin Informasi')
                        $('#myInput').val(content)
                        $('#modal_credential').modal("show")
                    },
                });
            }
        });
    })

    $('.delete').on('click',function(e) {
        const id = $(this).data('id');
        const url = $(this).data('url');

        Swal.fire({
            html: `Apakah anda ingin menghapus data?`,
            icon: "info",
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: 'Tidak',
            customClass: {
                confirmButton: "btn btn-sm btn-primary",
                cancelButton: 'btn btn-sm btn-danger'
            }
        }).then(function(confirm){
            if (confirm.isConfirmed) {
                $.ajax({
                    url: url+ '?' + $.param({id: id}),
                    method: 'delete',
                    dataType: 'json',
                    success: function (e) {
                        location.reload();
                        $.toast({
                            heading: 'Success',
                            text: 'Guru berhasil di' + e.msg,
                            showHideTransition: 'fade',
                            position: 'top-right',
                            icon: 'success'
                        })
                    }
                })
            }
        });
    })
</script>

<?php $this->endSection(); ?>