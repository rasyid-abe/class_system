<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="card mb-5 mb-xl-10">
<input type="hidden" name="temp_day" value="<?= $days ?>">
  <div class="card-body border-top p-9">
    <div id="activity_table_teacher"></div>
  </div>

</div>


<?php $this->endSection(); ?>