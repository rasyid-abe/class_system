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
                <form action="<?= base_url('/teacher/lesson/additional/store') ?>" method="POST">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="lesson_additional_id" value="<?= $row['lesson_additional_id'] ?>">
                    <input type="hidden" name="subject" value="<?= $row['lesson_additional_subject_id'] ?>">
                    <input type="hidden" name="grade" value="<?= $row['lesson_additional_grade'] ?>">
                    <?php if (count($babs) > 0): ?>
                        <div class="mb-10">
                            <?php
                            $fe = $le = $msg = '';
                            if (session('valid') && array_key_exists("chapter", session('valid'))) {
                                $fe = "is-invalid";
                                $le = 'text-danger';
                                $msg = '<small class="text-danger">' . session('valid')['chapter'] . '</small>';
                            }
                            $opt_chap = old('chapter') ? old('chapter') : $row['lesson_additional_chapter'];
                            ?>
                            <label for="chapter" class="required form-label <?= $le ?>">BAB</label>
                            <select class="form-select form-control-md" data-control="select2" id="chapter" name="chapter" onchange="form_nchap();">
                                <option value="0">Pilih BAB</option>
                                <option value="-1" <?= old('chapter') == '-1' ? 'selected' : '' ?>>Buat BAB Baru</option>
                                <?php foreach($babs as $k => $v): ?>
                                    <option value="<?= $v['lesson_additional_chapter'] ?>" <?= old('chapter') == $v['lesson_additional_chapter'] ? 'selected' : '' ?>><?= $v['lesson_additional_chapter'] ?></option>
                                <?php endforeach ?>
                            </select>
                            <?= $msg ?>
                        </div>
                    <?php endif ?>
                    <div class="mb-10 <?= session('valid') && array_key_exists("chap_2nd", session('valid')) ? '' : 'hide' ?>" id="chap_sec">
                            <?php
                            $fe = $le = $msg = '';
                            if (session('valid') && array_key_exists("chap_2nd", session('valid'))) {
                                $fe = "is-invalid";
                                $le = 'text-danger';
                                $msg = '<small class="text-danger">' . session('valid')['chap_2nd'] . '</small>';
                            }
                            ?>
                            <label for="chap_2nd" class="required form-label <?= $le ?>">BAB Baru</label>
                            <input type="text" onchange="preview_content();" class="form-control form-control-md <?= $fe ?>" name="chap_2nd" id="chap_2nd"
                                value="<?= old('chap_2nd') ?>" />
                            <?= $msg ?>
                        </div> 
                    <div class="mb-10">
                        <?php
                        $fe = $le = $msg = '';
                        if (session('valid') && array_key_exists("sub_chapter", session('valid'))) {
                            $fe = "is-invalid";
                            $le = 'text-danger';
                            $msg = '<small class="text-danger">' . session('valid')['sub_chapter'] . '</small>';
                        }
                        ?>
                        <label for="sub_chapter" class="required form-label <?= $le ?>">Sub BAB</label>
                        <input type="text" class="form-control form-control-md <?= $fe ?>" name="sub_chapter"
                            id="sub_chapter" value="<?= old('sub_chapter') ? old('sub_chapter') : $row['lesson_additional_subchapter'] ?>" />
                        <?= $msg ?>
                    </div>
                    <div class="mb-10">
                        <?php
                        $fe = $le = $msg = '';
                        if (session('valid') && array_key_exists("doc_type", session('valid'))) {
                            $fe = "is-invalid";
                            $le = 'text-danger';
                            $msg = '<small class="text-danger">' . session('valid')['doc_type'] . '</small>';
                        }
                        $opt_type = old('doc_type') ? old('doc_type') : $row['lesson_additional_type'];
                        ?>
                        <label for="doc_type" class="required form-label <?= $le ?>">Tipe Materi</label>
                        <select class="form-select form-control-md" data-control="select2" id="doc_type"
                            name="doc_type">
                            <option value="0">Pilih Tipe Materi</option>
                            <option value="1" <?= $opt_type == "1" ? 'selected' : '' ?>>Teks Manual</option>
                            <option value="2" <?= $opt_type == "2" ? 'selected' : '' ?>>Tautan Dokumen</option>
                            <option value="3" <?= $opt_type == "3" ? 'selected' : '' ?>>Tautan Video</option>
                        </select>
                        <?= $msg ?>
                    </div>
                    <div class="mb-10" id="link_form">
                        <?php
                        $fe = $le = $msg = '';
                        if (session('valid') && array_key_exists("link", session('valid'))) {
                            $fe = "is-invalid";
                            $le = 'text-danger';
                            $msg = '<small class="text-danger">' . session('valid')['link'] . '</small>';
                        }
                        ?>
                        <label for="link" class="form-label <?= $le ?>">Tautan</label>
                        <input type="text" onchange="preview_content();" class="form-control form-control-md <?= $fe ?>" name="link" id="link"
                            value="<?= old('link') ? old('link') : $row['lesson_additional_content_path'] ?>" />
                        <?= $msg ?>
                    </div>
                    <div class="mb-10" id="content_form">
                        <?php
                        $fe = $le = $msg = '';
                        if (session('valid') && array_key_exists("content", session('valid'))) {
                            $fe = "is-invalid";
                            $le = 'text-danger';
                            $msg = '<small class="text-danger">' . session('valid')['content'] . '</small>';
                        }
                        ?>
                        <label for="content" class="form-label <?= $le ?>">Konten</label>
                        <textarea class="tinymce-editor" name="content" id="content"><?= old('content') ? old('content') : $row['lesson_additional_content'] ?></textarea>
                        <?= $msg ?>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-md btn-round btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    function form_nchap(){
        let val = $('#chapter').val();
        if (val == -1) {
            $('#chap_sec').removeClass('hide')
        } else {
            $('#chap_sec').addClass('hide')
        }
    }
    function preview_content(){
        let path  = $('#link').val();
    }
</script>

<?php $this->endSection(); ?>