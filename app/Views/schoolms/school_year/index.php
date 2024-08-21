<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-toolbar">
            <?= button_add('/sms/master/school-year/create') ?>
        </div>
    </div>
    <div class="card-body py-4">
        <table id="kt_datatable_dom_positioning" class="table table-striped">
            <thead>
            <tr>
                <th rowspan="2">#</th>
                <th rowspan="2" class="text-center align-middle">Tahun Ajaran</th>
                <th colspan="2" class="text-center">Semester Gasal</th>
                <th colspan="2" class="text-center">Semester Genap</th>
                <th rowspan="2" class="text-center align-middle">Aksi</th>
            </tr>
            <tr>
                <th class="text-center">Awal</th>
                <th class="text-center">Akhir</th>
                <th class="text-center">Awal</th>
                <th class="text-center">Akhir</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($row as $k => $v): ?>
                    <tr>
                        <td class="text-center"><?= $k+1 ?></td>
                        <td class="text-center"><?= $v['school_year_period'] ?></td>
                        <td class="text-center"><?= $v['school_year_start_date_one'] ?></td>
                        <td class="text-center"><?= $v['school_year_end_date_one'] ?></td>
                        <td class="text-center"><?= $v['school_year_start_date_two'] ?></td>
                        <td class="text-center"><?= $v['school_year_end_date_two'] ?></td>
                        <td class="text-center">
                            <?= button_edit('/sms/master/school-year/edit/' . $v['school_year_id']) ?>
                            <?= button_delete('/sms/master/school-year/destroy/',  $v['school_year_id']) ?>
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