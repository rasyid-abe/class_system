<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<style>
    .profile {
        width: 150px;
        height: 150px;
        background-color: white;
        border-radius: 5px;
        justify-content: center;
    }
</style>

<div class="row">
    <div class="col-md-3">
        <div class="card card-pricing card-pricing-focus card-primary">
            <div class="card-header d-flex justify-content-center">
                <h4 class="card-title profile">
                    <img src="<?= base_url() . '/assets/user_img/' . $row['student_image'] ?>" width="120px" class="py-2" alt="">
                </h4>
            </div>
            <div class="card-price my-2">
                <h1><?= $row['student_fullname'] ?></h1>
                <h6>NIS : 193409 / NISN: 091348</h6>
            </div>
            <div class="card-body">
                <ul class="specification-list">
                    <li>
                        <span class="name-specification"><b>E-Mail :</b></span>
                        <span class="status-specification">Yes</span>
                    </li>
                    <li>
                        <span class="name-specification"><b>No. HP :</b></span>
                        <span class="status-specification">3 Month</span>
                    </li>
                    <li>
                        <span class="name-specification"><b>Agama :</b></span>
                        <span class="status-specification">3 Month</span>
                    </li>
                    <li>
                        <span class="name-specification"><b>Jenis Kelamin :</b></span>
                        <span class="status-specification">Yes</span>
                    </li>
                    <li>
                        <span class="name-specification"><b>Alamat Lengkap :</b></span><br>
                        <span class="name-specification">Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum neque quibusdam nemo? Harum facilis porro molestias at quisquam impedit eos sed velit odit laborum eligendi corrupti maxime, est nesciunt cum.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-pricing">
            <div class="card-body">
                <ul class="specification-list">
                    <li>
                        <h3 class="text-left"><b>Data Orang Tua</b></h3>
                    </li>
                    <li>
                        <span class="name-specification"><b>Nama Ayah :</b></span>
                        <span class="status-specification">Yes</span>
                    </li>
                    <li>
                        <span class="name-specification"><b>Nama Ibu :</b></span>
                        <span class="status-specification">1 Year</span>
                    </li>
                    <li>
                        <span class="name-specification"><b>No. HP : </b></span>
                        <span class="status-specification">1 Year</span>
                    </li>
                    <li>
                        <span class="name-specification"><b>Alamat Lengkap :</b></span><br>
                        <span class="name-specification">Lorem, ipsum dolor sit amet consectetur adipisicing
                            elit.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-pricing">
            <div class="card-body">
                <ul class="specification-list">
                    <li>
                        <h3 class="text-left"><b>Data Wali</b></h3>
                    </li>
                    <li>
                        <span class="name-specification"><b>Nama Wali :</b></span>
                        <span class="status-specification">Yes</span>
                    </li>
                    <li>
                        <span class="name-specification"><b>No. HP : </b></span>
                        <span class="status-specification">1 Year</span>
                    </li>
                    <li>
                        <span class="name-specification"><b>Alamat Lengkap :</b></span><br>
                        <span class="name-specification">Lorem, ipsum dolor sit amet consectetur adipisicing
                            elit.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>