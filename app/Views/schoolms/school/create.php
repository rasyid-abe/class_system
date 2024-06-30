<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center mx-2">
                    <h4 class="card-title">
                        <?= end($breadcrumb) ?>
                    </h4>
                </div>
            </div>
            <div class="card-body">
                <form action="<?= base_url('/sms/user/school/store') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div
                                class="form-group <?= session('valid') && array_key_exists("npsn",session('valid')) ? 'has-error has-feedback' : '' ?>">
                                <label for="name">NPSN <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="npsn" id="npsn"
                                    value="<?= old('npsn') ?>">
                                <?php if (session('valid') && array_key_exists("npsn",session('valid'))): ?>
                                    <small class="text-danger">
                                        <?= session('valid')['npsn'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <div
                                class="form-group">
                                <label for="name">Nama Yayasan/Dinas Pendidikan</label>
                                <input type="text" class="form-control" name="foundation" id="foundation"
                                    value="<?= old('foundation') ?>">
                            </div>
                            <div
                                class="form-group <?= session('valid') && array_key_exists("name",session('valid')) ? 'has-error has-feedback' : '' ?>">
                                <label for="name">Nama Sekolah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="<?= old('name') ?>">
                                <?php if (session('valid') && array_key_exists("name",session('valid'))): ?>
                                    <small class="text-danger">
                                        <?= session('valid')['name'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <div
                                class="form-group <?= session('valid') && array_key_exists("alias",session('valid')) ? 'has-error has-feedback' : '' ?>">
                                <label for="alias">Alias Sekolah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="alias" id="alias"
                                    value="<?= old('alias') ?>">
                                <?php if (session('valid') && array_key_exists("alias",session('valid'))): ?>
                                    <small class="text-danger">
                                        <?= session('valid')['alias'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <div
                                class="form-group <?= session('valid') && array_key_exists("level",session('valid')) ? 'has-error has-feedback' : '' ?>">
                                <label for="level">Jenjang <span class="text-danger">*</span></label>
                                <select class="form-control" id="level" name="level" style="border-color: red;">
                                    <option value="">Pilih Jenjang Sekolah</option>
                                    <?php foreach ($level as $k => $v): ?>
                                        <option value="<?= $k ?>" <?= $k == old('level') ? 'selected' : '' ?>>
                                            <?= $v ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (session('valid') && array_key_exists("level",session('valid'))): ?>
                                    <small class="text-danger">
                                        <?= session('valid')['level'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <div
                                class="form-group <?= session('valid') && array_key_exists("logo",session('valid')) ? 'has-error has-feedback' : '' ?>">
                                <label for="logo">Logo</label><br>
                                <img src="/images/school/default.png" class="logo-preview" style="max-width:180px;">
                                <input type="file" class="form-control-file mt-2" id="logo" name="logo"
                                    accept="image/png, image/jpeg">
                                <?php if (session('valid') && array_key_exists("logo",session('valid'))): ?>
                                    <small class="text-danger">
                                        <?= session('valid')['logo'] ?>
                                    </small>
                                <?php endif; ?>
                                    
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div
                                class="form-group <?= session('valid') && array_key_exists("email",session('valid')) ? 'has-error has-feedback' : '' ?>">
                                <label for="name">Email <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="email" id="email"
                                    value="<?= old('email') ?>">
                                <?php if (session('valid') && array_key_exists("email",session('valid'))): ?>
                                    <small class="text-danger">
                                        <?= session('valid')['email'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <div
                                class="form-group <?= session('valid') && array_key_exists("phone",session('valid')) ? 'has-error has-feedback' : '' ?>">
                                <label for="phone">No. Telp/HP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="phone" id="phone"
                                    value="<?= old('phone') ?>">
                                <?php if (session('valid') && array_key_exists("phone",session('valid'))): ?>
                                    <small class="text-danger">
                                        <?= session('valid')['phone'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <div
                                class="form-group <?= session('valid') && array_key_exists("website",session('valid')) ? 'has-error has-feedback' : '' ?>">
                                <label for="website">Website</label>
                                <input type="text" class="form-control" name="website" id="website"
                                    value="<?= old('website') ?>">
                                <?php if (session('valid') && array_key_exists("website",session('valid'))): ?>
                                    <small class="text-danger">
                                        <?= session('valid')['website'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <div
                                class="form-group <?= session('valid') && array_key_exists("principal",session('valid')) ? 'has-error has-feedback' : '' ?>">
                                <label for="name">Kepala Sekolah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="principal" id="principal"
                                    value="<?= old('principal') ?>">
                                <?php if (session('valid') && array_key_exists("principal",session('valid'))): ?>
                                    <small class="text-danger">
                                        <?= session('valid')['principal'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <div
                                class="form-group <?= session('valid') && array_key_exists("principal_nip",session('valid')) ? 'has-error has-feedback' : '' ?>">
                                <label for="name">NIP Kepala Sekolah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="principal_nip" id="principal_nip"
                                    value="<?= old('principal_nip') ?>">
                                <?php if (session('valid') && array_key_exists("principal_nip",session('valid'))): ?>
                                    <small class="text-danger">
                                        <?= session('valid')['principal_nip'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <div
                                class="form-group <?= session('valid') && array_key_exists("ttdhead",session('valid')) ? 'has-error has-feedback' : '' ?>">
                                <label for="imgttd" class="d-block">Tanda Tangan Kepala Sekolah <span class="text-danger">*</span>
                                </label>
                                <img src="/images/school/default.png" id="ttdimg" style="max-width:180px;">
                                <input type="file" name="ttdhead" class="form-control-file mt-2" id="imgttd"
                                    accept="image/png">
                                <?php if (session('valid') && array_key_exists("ttdhead",session('valid'))): ?>
                                    <small class="text-danger">
                                        <?= session('valid')['ttdhead'] ?>
                                    </small><br>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div
                                class="form-group <?= session('valid') && array_key_exists("province",session('valid')) ? 'has-error has-feedback' : '' ?>">
                                <label for="agama">Provinsi <span class="text-danger">*</span></label>
                                <select class="form-control" id="province" name="province">
                                    <option value="">Pilih Provinsi</option>
                                    <?php foreach ($province as $k => $v): ?>
                                        <option value="<?= $v['territory_code'] ?>" <?= $v['territory_code'] == old('province') ? 'selected' : '' ?>>
                                            <?= $v['territory_name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (session('valid') && array_key_exists("province",session('valid'))): ?>
                                    <small class="text-danger">
                                        <?= session('valid')['province'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <div
                                class="form-group <?= session('valid') && array_key_exists("regency",session('valid')) ? 'has-error has-feedback' : '' ?>">
                                <label for="regency">Kabupaten/Kota <span class="text-danger">*</span></label>
                                <select class="form-control" id="regency" name="regency" readonly>
                                    <option value="0">Pilih Kabupaten/Kota</option>
                                </select>
                                <?php if (session('valid') && array_key_exists("regency",session('valid'))): ?>
                                    <small class="text-danger">
                                        <?= session('valid')['regency'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <div
                                class="form-group <?= session('valid') && array_key_exists("subdistrict",session('valid')) ? 'has-error has-feedback' : '' ?>">
                                <label for="subdistrict">Kecamatan <span class="text-danger">*</span></label>
                                <select class="form-control" id="subdistrict" name="subdistrict">
                                    <option value="0">Pilih Kecamatan</option>
                                </select>
                                <?php if (session('valid') && array_key_exists("subdistrict",session('valid'))): ?>
                                    <small class="text-danger">
                                        <?= session('valid')['subdistrict'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <div
                                class="form-group <?= session('valid') && array_key_exists("postal_code",session('valid')) ? 'has-error has-feedback' : '' ?>">
                                <label for="name">Kode Pos <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="postal_code" id="postal_code" value="<?= old('postal_code') ?>">
                                <?php if (session('valid') && array_key_exists("postal_code",session('valid'))): ?>
                                    <small class="text-danger">
                                        <?= session('valid')['postal_code'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <div
                                class="form-group <?= session('valid') && array_key_exists("address",session('valid')) ? 'has-error has-feedback' : '' ?>">
                                <label for="desc">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="address" id="address" cols="30"
                                    rows="3"><?= old('address') ?></textarea>
                                    <?php if (session('valid') && array_key_exists("address",session('valid'))): ?>
                                    <small class="text-danger">
                                        <?= session('valid')['address'] ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlFile1">Titik Lokasi Sekolah</label><br>

                                <button type="button" class="btn btn-sm btn-primary mr-2" data-toggle="modal"
                                    data-target="#modalMaps">
                                    Buka Maps
                                </button>
                                <label>Lat : <span id="lat"><?= old('map_latitude') ? old('map_latitude') : '-' ?></span> | Long : <span id="long"><?= old('map_longitude') ? old('map_longitude') : '-' ?></span></label>
                                <input type="hidden" name="map_latitude" value="<?= old('map_latitude') ?>">
                                <input type="hidden" name="map_longitude" value="<?= old('map_longitude') ?>">
                            </div>

                        </div>
                        <div class="col-lg-12">
                            <hr>
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-round btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalMaps" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modalMapsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMapsLabel">Maps</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="myMap" style="box-sizing: border-box;width:100%;height:500px;padding: 5px;"></div>
            </div>
        </div>
    </div>
</div>

<script type='text/javascript'
    src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=AgH-zcVyIv80VQONSzKeM7UrveS7GSTwPFqTXn0zo_VTym_tPhiaLsGiRbL-nwPI'
    async defer></script>

<script type='text/javascript'>
    $(document).ready(function () {
        $('.select2').select2();

        if ($('#province').val() != 0) {
            let params = {
                'code': '<?= old('province') ?>',
                'len': 5,
                'fillen': 2,
                'title': 'regency',
                'old': '<?= old('regency') ?>'
            }
            get_location(params);
        }
    })

    $('#province').on('change', function () {
        let params = {
            'code': $('#province').val(),
            'len': 5,
            'fillen': 2,
            'title': 'regency',
            'old': ''
        }
        if ($(this).val() == "0") {
            $("#regency").html("<option value=\'0\'>Pilih Kabupaten/Kota</option>");
        } else {
            get_location(params);
        }
    })

    $('#regency').on('change', function () {
        let params = {
            'code': $(this).val(),
            'len': 8,
            'fillen': 5,
            'title': 'subdistrict',
            'old': ''
        }
        if ($(this).val() == "0") {
            $("#regency").html("<option value=\'0\'>Pilih Kecamatan</option>");
        } else {
            get_location(params);
        }
    })

    var get_location = (params) => {
        console.log(params);
        $.ajax({
            url: "<?= base_url('/sms/user/school/list_area') ?>",
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
                        'old': '<?= old('subdistrict') ?>'
                    }

                    get_location(params)
                }
            },
        });
    };

    $('#logo').on('change', function () {
        let input = $('#logo').prop('files');
        if (input[0]) {

            let reader = new FileReader();

            reader.onload = function (e) {
                $('.logo-preview').attr('src', e.target.result);
            };

            reader.readAsDataURL(input[0]);
        }
        console.log(input[0]);
    })

    $('#imgttd').on('change', function () {
        let input = $('#imgttd').prop('files');
        if (input[0]) {

            let reader = new FileReader();

            reader.onload = function (e) {
                $('#ttdimg').attr('src', e.target.result);
            };

            reader.readAsDataURL(input[0]);
        }
        console.log(input[0]);
    })


    function GetMap() {
        // var map = new Microsoft.Maps.Map('#myMap');
        var map = new Microsoft.Maps.Map(document.getElementById('myMap'), {
            center: new Microsoft.Maps.Location(-1.6352124445319873, 111.98814453917079),
            zoom: 5
        });
        Microsoft.Maps.Events.addHandler(map, 'click', function (e) { set_latitudes_and_longitude(e); });
        //Add your post map load code here.
    }

    function set_latitudes_and_longitude(map) {
        $('#lat').html(map.location.latitude)
        $('#long').html(map.location.longitude)
        $('input[name="map_latitude"]').val(map.location.latitude)
        $('input[name="map_longitude"]').val(map.location.longitude)
        $('#modalMaps').modal('toggle');

    }
</script>

<?php $this->endSection(); ?>