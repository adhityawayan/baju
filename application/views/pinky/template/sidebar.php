<div class="page-sidebar-wrapper">
    <!-- END SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu page-header-fixed page-sidebar-menu-hover-submenu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">

            <li class="nav-item <?= $this->session->flashdata('parent_menu_active') == 'dashboard' ? 'active': '';?>">

                <a href="<?=base_url('/')?>" class="nav-link">
                    <i class="icon-pie-chart"></i>
                    <span class="title">Dashboard</span>
                    <span class="arrow "></span>
                </a>

            </li>

            <li class="nav-item <?= $this->session->flashdata('parent_menu_active') == 'bisnis' ? 'active': '';?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-bag"></i>
                    <span class="title">Proses Bisnis</span>
                    <span class="arrow "></span>
                </a>

                <ul class="sub-menu">

                    <li class="nav-item <?= $this->session->flashdata('child_menu_active') == 'appointment' ? 'active': '';?>">
                        <a href="<?=base_url('bisnis/appointment')?>" class="nav-link">
                            <i class="icon-action-redo"></i> Appointment
                            <span class="arrow"></span>
                        </a>
                    </li>
                    <li class="nav-item <?= $this->session->flashdata('child_menu_active') == 'history' ? 'active': '';?>">
                        <a href="<?=base_url('bisnis/history')?>" class="nav-link">
                            <i class="icon-action-undo"></i> History
                            <span class="arrow"></span>
                        </a>
                    </li>
                    <li class="nav-item <?= $this->session->flashdata('child_menu_active') == 'operasional' ? 'active': '';?>">
                        <a href="<?=base_url('bisnis/operasional')?>" class="nav-link">
                            <i class="icon-social-dropbox"></i> Operasional
                            <span class="arrow"></span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item <?= $this->session->flashdata('parent_menu_active') == 'laporan' ? 'active': '';?>">

                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Laporan</span>
                    <span class="arrow "></span>
                </a>

                <ul class="sub-menu">

                    <li class="nav-item <?= $this->session->flashdata('child_menu_active') == 'aruskas' ? 'active': '';?>">
                        <a href="<?=base_url('laporan/aruskas')?>" class="nav-link">
                            <i class="icon-bag"></i> Arus Kas
                            <span class="arrow"></span>
                        </a>
                    </li>

                    <li class="nav-item <?= $this->session->flashdata('child_menu_active') == 'labarugi' ? 'active': '';?>">
                        <a href="<?=base_url('laporan/labarugi')?>" class="nav-link">
                            <i class="icon-calculator"></i> Laba Rugi
                            <span class="arrow"></span>
                        </a>
                    </li>

                </ul>
            </li>

            <li class="nav-item <?= $this->session->flashdata('parent_menu_active') == 'master' ? 'active': '';?> ">

                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">Master</span>
                    <span class="arrow "></span>
                </a>

                <ul class="sub-menu">

                    <li class="nav-item <?= $this->session->flashdata('child_menu_active') == 'type' ? 'active': '';?> ">
                        <a href="<?=base_url('master/type')?>" class="nav-link">
                            <i class="icon-layers"></i> Type
                            <span class="arrow"></span>
                        </a>
                    </li>

                    <li class="nav-item <?= $this->session->flashdata('child_menu_active') == 'kategori' ? 'active': '';?> ">
                        <a href="<?=base_url('master/kategori')?>" class="nav-link">
                            <i class="icon-layers"></i> Kategori
                            <span class="arrow"></span>
                        </a>
                    </li>

                    <li class="nav-item <?= $this->session->flashdata('child_menu_active') == 'baju' ? 'active': '';?> ">
                        <a href="<?=base_url('master/baju')?>" class="nav-link">
                            <i class="icon-puzzle"></i> Baju
                            <span class="arrow"></span>
                        </a>
                    </li>

                    <li class="nav-item <?= $this->session->flashdata('child_menu_active') == 'customer' ? 'active': '';?> ">
                        <a href="<?=base_url('master/customer')?>" class="nav-link">
                            <i class="icon-users"></i> Customer
                            <span class="arrow"></span>
                        </a>
                    </li>

                    <li class="nav-item <?= $this->session->flashdata('child_menu_active') == 'partner' ? 'active': '';?> ">
                        <a href="<?=base_url('master/partner')?>" class="nav-link">
                            <i class="icon-users"></i> Partner
                            <span class="arrow"></span>
                        </a>
                    </li>

                    <li class="nav-item <?= $this->session->flashdata('child_menu_active') == 'promo' ? 'active': '';?> ">
                        <a href="<?=base_url('master/promo')?>" class="nav-link">
                            <i class="icon-present"></i> Promo
                            <span class="arrow"></span>
                        </a>
                    </li>

                    <li class="nav-item <?= $this->session->flashdata('child_menu_active') == 'voucher' ? 'active': '';?> ">
                        <a href="<?=base_url('master/voucher')?>" class="nav-link">
                            <i class="icon-disc"></i> Voucher
                            <span class="arrow"></span>
                        </a>
                    </li>

                    <li class="nav-item <?= $this->session->flashdata('child_menu_active') == 'accessories' ? 'active': '';?> ">
                        <a href="<?=base_url('master/acces')?>" class="nav-link">
                            <i class="icon-users"></i> Accessoris
                            <span class="arrow"></span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item <?= $this->session->flashdata('parent_menu_active') == 'setting' ? 'active': '';?> ">

                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-wrench"></i>
                    <span class="title">Setting</span>
                    <span class="arrow "></span>
                </a>

                <ul class="sub-menu">
                    <li class="nav-item <?= $this->session->flashdata('child_menu_active') == 'user_group' ? 'active': '';?> ">
                        <a href="<?=base_url('setting/group')?>" class="nav-link">
                            <i class="icon-users"></i> User Group
                            <span class="arrow"></span>
                        </a>
                    </li>

                    <li class="nav-item <?= $this->session->flashdata('child_menu_active') == 'user' ? 'active': '';?> ">
                        <a href="<?=base_url('setting/user')?>" class="nav-link">
                            <i class="icon-user"></i> User
                            <span class="arrow"></span>
                        </a>
                    </li>

                    <li class="nav-item <?= $this->session->flashdata('child_menu_active') == 'log' ? 'active': '';?> ">
                        <a href="<?=base_url('setting/log')?>" class="nav-link">
                            <i class="icon-clock"></i> Log
                            <span class="arrow"></span>
                        </a>
                    </li>

                    <li class="nav-item <?= $this->session->flashdata('child_menu_active') == 'company' ? 'active': '';?> ">
                        <a href="<?=base_url('setting/company')?>" class="nav-link">
                            <i class="icon-settings"></i> Company
                            <span class="arrow"></span>
                        </a>
                    </li>

                </ul>
            </li>

        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->

<!-- BEGIN CONTENT -->

<div class="page-content-wrapper">

    <!-- BEGIN CONTENT BODY -->

    <div class="page-content">