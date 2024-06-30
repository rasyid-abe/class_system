<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>
<style> #stepper-profile{ font-size: 1.25rem; } </style>

<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container">
            
            <?php include 'card-profile.php'; ?>

            <div class="row mb-5 mb-xl-10">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center mx-2">                                
                                <h3 class="fw-bold m-0">Profile Details</h3>
                            </div>
                            <?php if(isset($edit_btn)): ?>
                                <a href="<?= base_url($edit_btn) ?>" class="btn btn-sm btn-primary align-self-center">Edit Profile</a>
                            <?php endif; ?>
                        </div>
                        <?php                    
                            $valid = session('valid');
                            $stepper = 'first';
                            $label1 = $label2 = $label3 = 'current';
                            $label2 = $label3 = 'pending';
                            $step1 = 'current';
                            $step2 = $step3 = '';
                        ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="stepper stepper-pills stepper-column d-flex flex-column flex-lg-row <?= $stepper ?>" id="kt_stepper_example_vertical">
                                        <div class="d-flex flex-row-auto w-100 w-lg-300px">
                                            <div class="stepper-nav">
                                                <div class="stepper-item me-5 <?= $label1 ?>" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                                    <div class="stepper-wrapper d-flex align-items-center">
                                                        <div class="stepper-icon w-40px h-40px">
                                                            <b class="stepper-check" id="stepper-profile">1</b>
                                                            <span class="stepper-number">1</span>
                                                        </div>

                                                        <div class="stepper-label">
                                                            <div class="stepper-desc">
                                                                Step 1
                                                            </div>
                                                            <h3 class="stepper-title">
                                                                Biodata
                                                            </h3>
                                                        </div>
                                                    </div>

                                                    <div class="stepper-line h-40px"></div>
                                                </div>

                                                <div class="stepper-item me-5 <?= $label2 ?>" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                                    <div class="stepper-wrapper d-flex align-items-center">
                                                        <div class="stepper-icon w-40px h-40px">
                                                            <b class="stepper-check" id="stepper-profile">2</b>
                                                            <span class="stepper-number">2</span>
                                                        </div>

                                                        <div class="stepper-label">
                                                            <div class="stepper-desc">
                                                                Step 2
                                                            </div>
                                                            <h3 class="stepper-title">
                                                                Kontak
                                                            </h3>
                                                        </div>
                                                    </div>

                                                    <div class="stepper-line h-40px"></div>
                                                </div>

                                                <div class="stepper-item me-5 <?= $label3 ?>" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                                    <div class="stepper-wrapper d-flex align-items-center">
                                                        <div class="stepper-icon w-40px h-40px">
                                                            <b class="stepper-check" id="stepper-profile">3</b>
                                                            <span class="stepper-number">3</span>
                                                        </div>

                                                        <div class="stepper-label">
                                                            <div class="stepper-desc">
                                                                Step 3
                                                            </div>
                                                            <h3 class="stepper-title">
                                                                Alamat
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex-row-fluid">                                            
                                            <div class="mb-5">
                                                <div class="flex-column <?= $step1 ?>" data-kt-stepper-element="content">
                                                    <div class="row mb-5">                                                        
                                                        <div class="col-md-4">                                                            
                                                            <label class="d-block fw-semibold fs-6 mb-5">Tanda Tangan Kepala Sekolah</label>  
                                                            <style>
                                                                    .image-input-placeholder {
                                                                        background-image: url('<?= base_url('/blaze-assets/media/svg/files/blank-image.svg') ?>');
                                                                    }

                                                                    [data-bs-theme="dark"] .image-input-placeholder {
                                                                        background-image: url('<?= base_url('/blaze-assets/media/svg/files/blank-image-dark.svg') ?>');
                                                                    }
                                                                </style>                                                          
                                                            <div class="image-input image-input-outline image-input-placeholder image-input-empty" data-kt-image-input="true">
                                                                <div class="image-input-wrapper w-125px h-125px foto-ttd-edit" style="background-image: none;"></div>
                                                            </div>
                                                            <div class="form-text">Tipe file yang diizinkan: png.</div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-4 col-sm-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">NPSN</label>
                                                                <input type="text" class="form-control form-control-md" value="<?= $row['school_npsn'] ?>" readonly />
                                                            </div>        
                                                        </div>
                                                        <div class="col-md-8 col-sm-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">Yayasan/Dinas Pendidikan</label>
                                                                <input type="text" class="form-control form-control-md" value="<?= $row['school_foundation'] ?>" readonly />
                                                            </div>        
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">Nama Sekolah</label>
                                                                <input type="text" class="form-control form-control-md" value="<?= $row['school_name'] ?>" readonly />
                                                            </div>        
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">Alias Sekolah</label>
                                                                <input type="text" class="form-control form-control-md" value="<?= $row['school_alias'] ?>" readonly />
                                                            </div>        
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">Jenjang Sekolah</label>
                                                                <input type="text" class="form-control form-control-md" value="<?= $level[$row['school_level']] ?>" readonly />
                                                            </div>        
                                                        </div>    
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">Nama Kepala Sekolah</label>
                                                                <input type="text" class="form-control form-control-md" value="<?= $row['school_principal'] ?>" readonly />
                                                            </div>        
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">NIP Kepala Sekolah</label>
                                                                <input type="text" class="form-control form-control-md" value="<?= $row['school_principal_nip'] ?>" readonly />
                                                            </div>        
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="flex-column <?= $step2 ?>" data-kt-stepper-element="content">
                                                    <div class="row mb-5">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">No. Telpon/WA</label>
                                                                <input type="text" class="form-control form-control-md" value="<?= $row['school_phone'] ?>" readonly />
                                                            </div>        
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">Email Sekolah &nbsp;
                                                                    <?php if($row['user_email_verified'] == 1): ?>
                                                                        <span class="badge badge-light-success">Terverifikasi</span>
                                                                    <?php else: ?>
                                                                        <a class="btn btn-sm" id="verify_email"><span class="badge badge-light-danger">Verifikasi Email</span></a>
                                                                    <?php endif; ?>
                                                                </label>
                                                                <input type="text" id="val_email" class="form-control form-control-md" value="<?= $row['user_email'] ?>" readonly />
                                                            </div>        
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">Website</label>
                                                                <input type="text" class="form-control form-control-md" value="<?= $row['school_website'] ?>" readonly />
                                                            </div>        
                                                        </div>    
                                                    </div>
                                                </div>

                                                <div class="flex-column <?= $step3 ?>" data-kt-stepper-element="content">
                                                    <div class="row mb-5">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label for="province" class="form-label">Provinsi</label>
                                                                <input type="text" class="form-control form-control-md" value="<?= territory_name($row['school_province']) ?>" readonly />
                                                            </div>        
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label for="regency" class="form-label">Kabupaten/Kota</label>
                                                                <input type="text" class="form-control form-control-md" value="<?= territory_name($row['school_regency']) ?>" readonly />
                                                            </div>        
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label for="subdistrict" class="form-label">Kecamatan</label>
                                                                <input type="text" class="form-control form-control-md" value="<?= territory_name($row['school_subdistrict']) ?>" readonly />
                                                            </div>        
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">Kode Pos</label>
                                                                <input type="text" class="form-control form-control-md" value="<?= $row['school_postal_code'] ?>" readonly />
                                                            </div>        
                                                        </div>
                                                    </div>
                                                    <div class="row mb-5">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Latitude</label>
                                                                    <input type="text" class="form-control form-control-md" value="<?= $row['school_map_latitude'] ?>" readonly />
                                                                </div>        
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Longitude</label>
                                                                    <input type="text" class="form-control form-control-md" value="<?= $row['school_map_longitude'] ?>" readonly />
                                                                </div>        
                                                            </div>
                                                        </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">Alamat Lengkap</label>
                                                                <textarea class="form-control" cols="30" rows="3" readonly><?= $row['school_address'] ?></textarea>
                                                            </div>        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        var element = document.querySelector("#kt_stepper_example_vertical");
        var stepper = new KTStepper(element);
        var imageUrlTtd = "<?php echo base_url() . 'images/school/' . $row['school_principal_sign']; ?>";
        var imageWrapperTtd = document.querySelector('.foto-ttd-edit');
        imageWrapperTtd.style.backgroundImage = "url('" + imageUrlTtd + "')";        
        
        stepper.on("kt.stepper.click", function (stepper) {
            stepper.goTo(stepper.getClickedStepIndex()); 
        });

        if ($('#province').val() != 0) {
            let params = {
                'code': '<?= $row['school_province'] ?>',
                'len': 5,
                'fillen': 2,
                'title': 'regency',
                'old': '<?= $row['school_regency'] ?>'
            }
            get_location(params);
        }        
    })

    var get_location = (params) => {
        $.ajax({
            url: "<?= isset($url_territory) ? base_url($url_territory) : base_url('/sms/user/school/list_area') ?>",
            type: "post",
            data: params,
            dataType: "json",
            success: function (data) {
                let selected = params.old != '' ? params.old : '';
                let option = `<option value="0">Pilih ${((params.title == "regency") ? "Kabupaten/Kota" : "Kecamatan")}</option>`;
                $.each(data, function (k, v) {
                    option += `<option value="${v.territory_code}" ${selected == v.territory_code ? 'selected' : ''}>${v.territory_name}</option>`;
                });
                $("#" + params.title.toLowerCase()).html(option);

                if (selected != '' && params.title == 'regency') {
                    let params = {
                        'code': selected,
                        'len': 8,
                        'fillen': 5,
                        'title': 'subdistrict',
                        'old': '<?= old('subdistrict') ? old('subdistrict') : $row['school_subdistrict'] ?>'
                    }

                    get_location(params)
                }
            },
        });
    };

    $('#verify_email').on('click', function(){
        let email = $('#val_email').val();
        $.ajax({
            url: "<?= base_url('/dashboard/school/email-verify') ?>",
            type: "post",
            data: {'email': email},
            dataType: "json",
            beforeSend: function() {
                show_loading()
            },
            success: function (data) {
                console.log(data);
                response(data)
                hide_loading()
            }
        })
    })

    function response(data) {
        if (data.sts == false) {
            $.toast({
                heading: 'Gagal',
                text: data.msg,
                showHideTransition: 'fade',
                position: 'top-right',
                icon: 'error'
            })
        } else {
            Swal.fire({
                html: data.msg,
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Ok",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }
    }

</script>

<?php $this->endSection(); ?>