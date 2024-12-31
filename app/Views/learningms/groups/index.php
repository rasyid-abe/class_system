<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="card mb-5 mb-xl-10">

  <input type="hidden" name="group_id" value="<?= $group_id ?>">
  <div class="card-body border-top p-9">
    <div id="student_group_view"></div>
  </div>

</div>

<?php $this->endSection(); ?>