<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-toolbar">
            <?= button_add('/sms/master/subject/create') ?>
        </div>
    </div>
    <div class="card-body py-4">
        <table id="kt_datatable_dom_positioning" class="table table-striped">
            <thead>
                <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                    <th class="text-center">#</th>
                    <th>Mata Pelajaran</th>
                    <th>Jurusan</th>
                    <th class="text-center">Kelas</th>
                    <th>Keterangan</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($row as $k => $v): ?>
                    <tr>
                        <td class="text-center">
                            <?= $k + 1 ?>
                        </td>
                        <td><?= $v['subject_name'] ?></td>
                        <td><?= major_name($v['subject_major_id']) ?></td>
                        <td class="text-center"><?= $grade[$v['subject_grade']] ?></td>
                        <td><?= $v['subject_description'] ?></td>
                        <td class="d-flex">
                            <div
                                class="d-flex flex-grow-1 justify-content-center form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" id="chx_<?= $v['subject_id'] ?>" type="checkbox" value="<?= $v['subject_status'] ?>" data-id="<?= $v['subject_id'] ?>"
                                    <?= check_status($v['subject_status']) ?> />
                            </div>
                        </td>
                        <td class="text-center">
                            <?= button_edit('/sms/master/subject/edit/' . $v['subject_id']) ?>
                            <?= button_delete('/sms/master/subject/destroy/',  $v['subject_id']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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
                    url: '<?= base_url('/sms/master/subject/status') ?>',
                    data: { 'id':id, 'sts':sts },
                    method: 'post',
                    dataType: 'json',
                    success: function (e) {
                        sts < 1 ? $('#chx_'+id).val(1) : $('#chx_'+id).val(0) 
                        sts < 1 ? $('#chx_'+id).prop('checked', true) : $('#chx_'+id).prop('checked', false) 
                        $.toast({
                            heading: 'Success',
                            text: 'Data berhasil di' + e.msg,
                            showHideTransition: 'fade',
                            position: 'top-right',
                            icon: 'success'
                        })

                    }
                })
            }
        });
    });

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
                            text: 'Data berhasil di' + e.msg,
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