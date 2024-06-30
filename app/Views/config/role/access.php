<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<style>
    .line_menu {
        border-top: 1px solid gray;
        margin-top: 5px;
    }

    .line_submenu {
        border-top: 1px solid lightgray;
        padding-top: 10px;
        padding-bottom: -10px;
    }

    .submenu {
        margin-left: 50px;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">
                        <?= end($breadcrumb) ?>
                    </h4>
                </div>
            </div>
            <div class="card-body">
                
                <table>
                    <tbody>
                        <?php foreach ($menu as $k => $v): ?>
                            <tr>
                                <td colspan="3">
                                    <label class="mb-4 form-check form-switch form-label form-check-primary form-check-solid">
                                        <input class="form-check-input" type="checkbox" <?= check_access($role, $v['menu_id']) ?> 
                                            data-role="<?= $role ?>" data-menu="<?= $v['menu_id'] ?>" />
                                        <span class="form-check-label fw-semibold text-dark">
                                            <?= $v['menu_name'] ?>
                                        </span>
                                    </label>
                                </td>
                            </tr>
                            <?php foreach ($submenu[$k] as $vs): ?>
                                <tr class="">
                                    <td></td>
                                    <td colspan="2">
                                        <label class=" submenu mb-4 form-check form-check-warning form-switch form-check-solid">
                                            <input class="form-check-input" type="checkbox" <?= check_access($role, $vs['menu_id']) ?> 
                                                data-role="<?= $role ?>" data-menu="<?= $vs['menu_id'] ?>" />
                                            <span class="form-check-label fw-semibold text-dark">
                                                <?= $vs['menu_name'] ?>
                                            </span>
                                        </label>
                                        <?php if (count($vs[0]) > 0): ?>
                                            <div style="margin-left: 50px;">
                                                <?php foreach ($vs[0] as $i => $va): ?>
                                                    <label class=" submenu mb-4 form-check form-check-inline form-check-success form-switch form-check-solid">
                                                        <input class="form-check-input" type="checkbox" <?= check_access($role, $va['menu_id']) ?> 
                                                            data-role="<?= $role ?>" data-menu="<?= $va['menu_id'] ?>" />
                                                        <span class="form-check-label fw-semibold text-dark">
                                                            <?= $va['menu_name'] ?>
                                                        </span>
                                                    </label>
                                                    <!-- <div class="form-check form-check-inline" style="margin-top: -25px">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" <?= check_access($role, $va['menu_id']) ?>
                                                                data-role="<?= $role ?>" data-menu="<?= $va['menu_id'] ?>">
                                                            <span class="form-check-sign"><b>
                                                                    <?= $va['menu_name'] ?>
                                                                </b></span>
                                                        </label>
                                                    </div> -->
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- <?php foreach ($menu as $k => $v): ?>
                    <div class="form-check" style="margin-top: -15px">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" <?= check_access($role, $v['menu_id']) ?>
                                data-role="<?= $role ?>" data-menu="<?= $v['menu_id'] ?>">
                            <span class="form-check-sign"><b>
                                    <?= $v['menu_name'] ?>
                                </b></span>
                        </label>
                    </div>
                    <?php foreach ($submenu[$k] as $vs): ?>
                        <div class="form-check ml-5" style="margin-top: -15px">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" <?= check_access($role, $vs['menu_id']) ?>
                                    data-role="<?= $role ?>" data-menu="<?= $vs['menu_id'] ?>">
                                <span class="form-check-sign"><b>
                                        <?= $vs['menu_name'] ?>
                                    </b></span>
                            </label>
                        </div>
                        <div class="form-check form-check-inline ml-5" style="margin-top: -15px">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" <?= check_access($role, $vs['menu_id']) ?>
                                    data-role="<?= $role ?>" data-menu="<?= $vs['menu_id'] ?>">
                                <span class="form-check-sign"><b>
                                        <?= $vs['menu_name'] ?>
                                    </b></span>
                            </label>
                        </div>
                        <div class="form-check form-check-inline ml-5" style="margin-top: -15px">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" <?= check_access($role, $vs['menu_id']) ?>
                                    data-role="<?= $role ?>" data-menu="<?= $vs['menu_id'] ?>">
                                <span class="form-check-sign"><b>
                                        <?= $vs['menu_name'] ?>
                                    </b></span>
                            </label>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?> -->
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.form-check-input').on('click', function () {
        const role = $(this).data('role');
        const menu = $(this).data('menu');
        $.ajax({
            url: '<?= base_url('config/role/change-access') ?>',
            method: 'post',
            data: { role, menu },
            success: function () {
                $.toast({
                    heading: 'Success',
                    text: 'Akses berhasil diubah',
                    showHideTransition: 'fade',
                    position: 'top-right',
                    icon: 'success'
                })
            }
        })
    })
</script>

<?php $this->endSection(); ?>