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
                <form action="<?= base_url('/teacher/lesson/additional/update') ?>" method="POST">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="lesson_additional_id" value="<?= $row['lesson_additional_id'] ?>">
                    <div class="mb-10 text-dark">
                        <?php
                        $fe = $le = $msg = '';
                        if (session('valid') && array_key_exists("subject", session('valid'))) {
                            $fe = "is-invalid";
                            $le = 'text-danger';
                            $msg = '<small class="text-danger">' . session('valid')['subject'] . '</small>';
                        }
                        $opt_subject = old('subject') ? old('subject') : $row['lesson_additional_subject_id'];
                        ?>
                        <label for="subject" class="required form-label <?= $le ?>">Mata Pelajaran</label>
                        <select class="form-select form-control-md" data-control="select2" id="subject" name="subject">
                            <option value="0">Pilih Mata Pelajaran</option>
                            <?php foreach ($subject as $k => $v): ?>
                                <option value="<?= $v['subject_id'] ?>" <?= $opt_subject == $v['subject_id'] ? 'selected' : '' ?>><?= $v['subject_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= $msg ?>
                    </div>
                    <div class="mb-10">
                        <?php
                        $fe = $le = $msg = '';
                        if (session('valid') && array_key_exists("grade", session('valid'))) {
                            $fe = "is-invalid";
                            $le = 'text-danger';
                            $msg = '<small class="text-danger">' . session('valid')['grade'] . '</small>';
                        }
                        $opt_grade = old('grade') ? old('grade') : $row['lesson_additional_grade'];
                        ?>
                        <label for="grade" class="required form-label <?= $le ?>">Kelas</label>
                        <select class="form-select form-control-md" data-control="select2" id="grade" name="grade">
                            <option value="0">Pilih Kelas</option>
                            <?php foreach ($grade as $k => $v): ?>
                                <option value="<?= $k ?>" <?= $opt_grade == $k ? 'selected' : '' ?>>Kelas <?= $v ?></option>
                            <?php endforeach; ?>
                        </select>
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
                    <div class="mb-10">
                        <?php
                        $fe = $le = $msg = '';
                        if (session('valid') && array_key_exists("chapter", session('valid'))) {
                            $fe = "is-invalid";
                            $le = 'text-danger';
                            $msg = '<small class="text-danger">' . session('valid')['chapter'] . '</small>';
                        }
                        ?>
                        <label for="chapter" class="required form-label <?= $le ?>">Judul BAB</label>
                        <input type="text" class="form-control form-control-md <?= $fe ?>" name="chapter" id="chapter"
                            value="<?= old('chapter') ? old('chapter') : $row['lesson_additional_chapter'] ?>" />
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
                        <label for="sub_chapter" class="required form-label <?= $le ?>">Judul Sub BAB</label>
                        <input type="text" class="form-control form-control-md <?= $fe ?>" name="sub_chapter"
                            id="sub_chapter" value="<?= old('sub_chapter') ? old('sub_chapter') : $row['lesson_additional_subchapter'] ?>" />
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
                        <input type="text" class="form-control form-control-md <?= $fe ?>" name="link" id="link"
                            value="<?= old('link') ? old('link') : $row['lesson_additional_path'] ?>" />
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

    // function view_form() {
    //     let type = $('#doc_type').val();
    //     if (type != 1) {
    //         $('#link_form').removeClass('hide')
    //         $('#content_form').addClass('hide')
    //     } else {
    //         $('#link_form').addClass('hide')
    //         $('#content_form').removeClass('hide')
    //     }

    // }
</script>

<?php $this->endSection(); ?>