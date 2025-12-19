<div id="kt_drawer_chat" class="bg-body drawer drawer-end" data-kt-drawer="true" data-kt-drawer-name="chat" data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'md': '500px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_drawer_chat_toggle" data-kt-drawer-close="#kt_drawer_chat_close" style="width: 500px !important;">

    <div class="card w-100 border-0 rounded-0" id="kt_drawer_chat_messenger">
        <div class="card-header pe-5" id="kt_drawer_chat_messenger_header">
            <div class="card-title">
                <div class="d-flex justify-content-center flex-column me-3">
                    <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 mb-2 lh-1 pt-2">Notifikasi</a>
                </div>
            </div>
            <div class="card-toolbar">
                <?php if(count(get_notification()) > 1): ?>
                    <span class="badge badge-light-danger p-2 hand btn_clear_notification">Bersihkan Notifikasi</span>
                <?php endif ?>
                <div class="btn btn-sm btn-icon btn-active-color-primary" id="kt_drawer_chat_close">
                   <i class="bi bi-x-square fs-1"></i>
                </div>
            </div>
        </div>

        <div class="card-body" id="kt_drawer_chat_messenger_body">
            <div class="scroll-y me-n5 pe-5" data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_drawer_chat_messenger_header, #kt_drawer_chat_messenger_footer" data-kt-scroll-wrappers="#kt_drawer_chat_messenger_body" data-kt-scroll-offset="0px" style="height: 929px;">

                <div class="d-flex justify-content-start mb-10" id="notif_4">
                    <div class="d-flex flex-column align-items-start" style="width: 100%">
                        <?php foreach(get_notification() as $k => $v): 
                            $link = base_url('student/task/done/' . $v['notification_lms_id']);
                            if ($v['notification_lms_source_type'] == 1) {
                                $link = base_url('student/assessment/present/' . $v['notification_lms_id']);
                            } elseif ($v['notification_lms_source_type'] == 2) {
                                $link = base_url('student/task/present/' . $v['notification_lms_id']);
                            } elseif ($v['notification_lms_source_type'] == 3) {
                                $link = base_url('student/assessment/done/' . $v['notification_lms_id']);
                            }
                            ?>
                            <div class="p-5 rounded bg-light-info text-start mb-5 clear_notification" id="nn_<?= $v['notification_lms_id'] ?>" data-id="<?= $v['notification_lms_id'] ?>">
                                <span class="fs-2 fw-bold text-dark"><?= $v['notification_lms_title'] ?></span>
                                <p class="fs-5 fw-semibold text-dark"></p><p><?= $v['notification_lms_message'] ?></p>
                                <div class="d-flex justify-content-between pt-5">
                                    <span class="fs-6 text-gray-700"><i class="fa fa-clock fs-5 fw-semibold"></i> &nbsp;<?= datetime_indo($v['notification_lms_created_at']) ?></span>
                                    <i class="bi text-danger bi-x-circle-fill fs-5 close_notification" data-id="<?= $v['notification_lms_id'] ?>"></i>
                                    <!-- <div class="btnact">
                                        <a href="#" class="btn btn-sm btn-primary">Lihat</a>
                                        <button class="btn btn-sm btn-danger btn-icon close_notification"><i class="bi text-danger bi-x-square fs-5close_notification" data-id="4" data-kind="crisug"></i></button>
                                    </div> -->
                                    <!-- <span></span> -->
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>