<?php if(session()->get('c_role') == 11): ?>
    <div class="aside-nav d-flex flex-column align-items-center flex-column-fluid w-100 pt-5 pt-lg-0" id="kt_aside_nav">
        <!--begin::Wrapper-->
        <div class="hover-scroll-y mb-10" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
            data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_aside_nav"
            data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-offset="0px">
            <!--begin::Nav-->
            <ul class="nav flex-column">
                <li class="nav-item mb-2" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right"
                    data-bs-dismiss="click" title="Beranda">
                    <a class="nav-link btn btn-custom btn-icon <?= $page == "Dashboard" ? 'active' : '' ?>" href="<?= base_url() ?>dashboard/teacher"><i class="bi bi-house-fill fs-2qx"></i></a>
                </li>
                <!--begin::Nav item-->
                <li class="nav-item mb-2" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right"
                    data-bs-dismiss="click" title="Materi Pelajaran">
                    <!--begin::Nav link-->
                    <a class="nav-link btn btn-custom btn-icon <?= $page == "Lesson" ? 'active' : '' ?>" data-bs-toggle="tab" href="#subjects_menu">
                    <i class="bi bi-collection-fill fs-2x"></i>
                    </a>
                    <!--end::Nav link-->
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mb-2" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right"
                    data-bs-dismiss="click" title="Bank Soal">
                    <!--begin::Nav link-->
                    <a class="nav-link btn btn-custom btn-icon <?= $page == "Question" ? 'active' : '' ?>" data-bs-toggle="tab" href="#question_bank_menu">
                        <i class="bi bi-hdd-stack-fill fs-2x"></i>
                    </a>
                    <!--end::Nav link-->
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mb-2" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right"
                    data-bs-dismiss="click" title="Penilaian">
                    <!--begin::Nav link-->
                    <a class="nav-link btn btn-custom btn-icon <?= $page == "Assessment" ? 'active' : '' ?>" data-bs-toggle="tab" href="#evaluation_menu">
                        <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
                        <i class="bi bi-shield-fill-check fs-2x"></i>
                        <!--end::Svg Icon-->
                    </a>
                    <!--end::Nav link-->
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mb-2" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right"
                    data-bs-dismiss="click" title="Tugas">
                    <!--begin::Nav link-->
                    <a class="nav-link btn btn-custom btn-icon <?= $page == "Tasks" ? 'active' : '' ?>" data-bs-toggle="tab" href="#task_menu">
                        <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
                        <i class="bi bi-stack fs-2x"></i>
                        <!--end::Svg Icon-->
                    </a>
                    <!--end::Nav link-->
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mb-2" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right"
                    data-bs-dismiss="click" title="Daftar Kelas">
                    <!--begin::Nav link-->
                    <a class="nav-link btn btn-custom btn-icon <?= $page == "Groups" ? 'active' : '' ?>" data-bs-toggle="tab" href="#group_menu">
                        <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
                        <i class="bi bi-grid-fill fs-2x"></i>
                        <!--end::Svg Icon-->
                    </a>
                    <!--end::Nav link-->
                </li>
                <!--end::Nav item-->
            </ul>
            <!--end::Tabs-->
        </div>
        <!--end::Nav-->
    </div>
<?php elseif(session()->get('c_role') == 12): ?>
    <div class="aside-nav d-flex flex-column align-items-center flex-column-fluid w-100 pt-5 pt-lg-0" id="kt_aside_nav">
        <!--begin::Wrapper-->
        <div class="hover-scroll-y mb-10" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
            data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_aside_nav"
            data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-offset="0px">
            <!--begin::Nav-->
            <ul class="nav flex-column">
                <li class="nav-item mb-2" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right"
                data-bs-dismiss="click" title="Dashboard">
                    <a class="nav-link btn btn-custom btn-icon" href="#"><i class="bi bi-bar-chart-fill fs-2x"></i></a>
                </li>
                <!--begin::Nav item-->
                <li class="nav-item mb-2" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right"
                    data-bs-dismiss="click" title="Belajar Mandiri">
                    <!--begin::Nav link-->
                    <a class="nav-link btn btn-custom btn-icon active" data-bs-toggle="tab" href="#self_study">
                        <i class="fas fa-pencil-ruler fs-2x"></i>
                    </a>
                    <!--end::Nav link-->
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mb-2" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right"
                    data-bs-dismiss="click" title="Penilaian">
                    <!--begin::Nav link-->
                    <a class="nav-link btn btn-custom btn-icon" data-bs-toggle="tab" href="#student_result">
                        <i class="fas fa-check-double fs-2x"></i>
                    </a>
                    <!--end::Nav link-->
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mb-2" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right"
                    data-bs-dismiss="click" title="Tugas">
                    <!--begin::Nav link-->
                    <a class="nav-link btn btn-custom btn-icon" data-bs-toggle="tab" href="#student_task">
                        <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
                        <i class="fas fa-edit fs-2x"></i>
                        <!--end::Svg Icon-->
                    </a>
                    <!--end::Nav link-->
                </li>
                <!--end::Nav item-->
            </ul>
            <!--end::Tabs-->
        </div>
        <!--end::Nav-->
    </div>
<?php endif; ?>