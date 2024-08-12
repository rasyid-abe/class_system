<?php $this->extend('templates/core') ?>
<?php $this->section('content'); ?>

<div class="row">

    <div class="col-sm-3">
        <div class="rounded border">
            <div class="" id="kt_accordion_1">

                <?php if (count($chapters) > 0) : ?>

                    <div class="d-grid mb-2">
                        <a href="<?= base_url('/teacher/lesson/additional/create/' . $subject . '/' . $grade) ?>" class="btn btn-primary" type="button"><i class="mb-1 fa fa-plus"></i> Tambah Materi</a>
                    </div>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button">
                                    Accordion Item #1
                                </button>
                            </h2>
                            <div id="collapseOne" class="hide">
                                <div class="accordion-body">
                                    <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button" type="button">
                                    Accordion Item #2
                                </button>
                            </h2>
                            <div id="collapseTwo" class="hide">
                                <div class="accordion-body">
                                    <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button" type="button">
                                    Accordion Item #3
                                </button>
                            </h2>
                            <div id="collapseThree" class="hide">
                                <div class="accordion-body">
                                    <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                </div>
                            </div>
                        </div>
                    </div>


                <?php else : ?>
                    <div class="d-grid mb-2">
                        <a href="<?= base_url('/teacher/lesson/additional/create/' . $subject . '/' . $grade) ?>" class="btn btn-primary" type="button"><i class="mb-1 fa fa-plus"></i> Tambah Materi</a>
                    </div>
                <?php endif ?>

            </div>
        </div>
    </div>

    <div class="col-sm-9">
        <div class="hover-scroll-x">
            <div class="d-grid">
                <ul class="nav nav-tabs flex-nowrap text-nowrap">
                    <li class="nav-item">
                        <a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0 active" data-bs-toggle="tab" href="#kt_tab_pane_1">Materi Belajar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0" data-bs-toggle="tab" href="#kt_tab_pane_2">Ringkasan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0" data-bs-toggle="tab" href="#kt_tab_pane_3">Lampiran</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-secondary btn-color-gray-600 btn-active-info rounded-bottom-0" data-bs-toggle="tab" href="#kt_tab_pane_4">Latihan</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card p-5">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
                    <p>page 1</p>
                </div>
                <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                    <p>page 2</p>
                </div>
            </div>
        </div>
    </div>

</div>



<script>
    $("#kt_datatable_dom_positioning").DataTable({
        "language": {
            "lengthMenu": "_MENU_",
        },
        "dom": "<'row'" +
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
    function edit_content() {
        alert('ubah data')
    }

    function delete_content() {
        alert('hapus data')
    }

    // $('.accordion-collapse ').on('click', function(e){
    //     console.log(e);

    //     // $(this).toggleClass('show')
    // })

    function toggle_collapse(e) {
        if ($(`#kt_accordion_${e}_header_${e}`).hasClass('collapsed')) {
            console.log('ada kelas');
            $(`#kt_accordion_${e}_header_${e}`).removeClass('collapsed')
            $(`#kt_accordion_${e}_header_${e}`).attr("aria-expanded", "true");
            $(`#kt_accordion_${e}_body_${e}`).removeClass('show')
        } else {
            console.log('gak ada kelas');
            $(`#kt_accordion_${e}_header_${e}`).addClass('collapsed')
            $(`#kt_accordion_${e}_header_${e}`).attr("aria-expanded", "false");
            $(`#kt_accordion_${e}_body_${e}`).addClass('show')
        }
        console.log(e);

    }

    // <button 
    //     class="accordion-button fs-6 fw-semibold collapsed" 
    //     type="button" 
    //     data-bs-toggle="collapse" 
    //     data-bs-target="#kt_accordion_0_body_0" 
    //     aria-expanded="false" 
    //     aria-controls="kt_accordion_0_body_0">
    //     <span class="badge badge-square badge-warning" onclick="edit_content();"><i class="fa fa-pen text-light"></i></span>&nbsp;
    //     <span class="badge badge-square badge-danger" onclick="delete_content();"><i class="fa fa-trash text-light"></i></span>&nbsp;
    //     BAB 1
    // </button>

    // <button 
    //     class="accordion-button fs-6 fw-semibold" 
    //     type="button" 
    //     data-bs-toggle="collapse" 
    //     data-bs-target="#kt_accordion_0_body_0" 
    //     aria-expanded="true" 
    //     aria-controls="kt_accordion_0_body_0">
    //     <span class="badge badge-square badge-warning" onclick="edit_content();"><i class="fa fa-pen text-light"></i></span>&nbsp;
    //     <span class="badge badge-square badge-danger" onclick="delete_content();"><i class="fa fa-trash text-light"></i></span>&nbsp;
    //     BAB 1                                
    // </button>

    jQuery('.form-check-input').on('click', function(e) {
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
        }).then(function(confirm) {
            if (confirm.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('/teacher/lesson/additional/status') ?>',
                    data: {
                        'id': id,
                        'sts': sts
                    },
                    method: 'post',
                    dataType: 'json',
                    success: function(e) {
                        sts < 1 ? $('#chx_' + id).val(1) : $('#chx_' + id).val(0)
                        sts < 1 ? $('#chx_' + id).prop('checked', true) : $('#chx_' + id).prop('checked', false)
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

    $('.delete').on('click', function(e) {
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
        }).then(function(confirm) {
            if (confirm.isConfirmed) {
                $.ajax({
                    url: url + '?' + $.param({
                        id: id
                    }),
                    method: 'delete',
                    dataType: 'json',
                    success: function(e) {
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