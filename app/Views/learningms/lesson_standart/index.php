<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-toolbar">
            <?= button_add('/teacher/lesson/standart/create') ?>
        </div>
    </div>
    <div class="card-body py-4">
        <table id="kt_datatable_dom_positioning" class="table table-striped">
            <thead>
                <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                    <th class="text-center">#</th>
                    <th>Jurusan</th>
                    <th>Keterangan</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            
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
                    url: '<?= base_url('/sms/master/major/status') ?>',
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