<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-toolbar">
            <?= button_add('/config/role/add') ?>
        </div>
    </div>
    <div class="card-body py-4">
        <table id="kt_datatable_dom_positioning" class="table table-striped">
            <thead>
                <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                    <th class="text-center">#</th>
                    <th>Nama</th>
                    <th>Keterangan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($role as $k => $v): ?>
                    <tr>
                        <td class="text-center">
                            <?= $k + 1 ?>
                        </td>
                        <td class="text-left">
                            <?= $v['role_name'] ?>
                        </td>
                        <td>
                            <?= $v['role_description'] ?>
                        </td>
                        <td class="text-center">
                            <a href="<?= base_url('/config/role/access/' . $v['role_id']) ?>"
                                class="btn btn-sm btn-icon btn-info" data-toggle="tooltip" data-placement="top"
                                title="Akses"><i class="fa fa-cogs"></i></a>
                            <?= button_edit('/config/role/edit/' . $v['role_id']) ?>
                            <?= button_delete('/config/role/delete/',  $v['role_id']) ?>
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

<?php $this->endSection(); ?>