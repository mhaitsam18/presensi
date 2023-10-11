<!-- Sidebar --> 
<!-- bg-gradient-primary -->
        <ul class="navbar-nav <?php // echo "bg-gradient-primary"; ?> bg-danger sidebar sidebar-dark accordion" style="background-color: #c2280a !important;" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url() ?>">
                <?php $dashboard = $this->db->get('dashboard')->row_array(); ?>
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="<?= $dashboard['icon'] ?>"></i>
                     <!-- style="color: #F6A5B8;" -->
                </div>
                <div class="sidebar-brand-text mx-3"><?= $dashboard['title'] ?></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- QUERY MENU -->

            <?php
            $role_id = $this->session->userdata('role_id'); 
            $queryMenu = "SELECT um.id, menu FROM user_menu AS um JOIN user_access_menu AS uam ON um.id = uam.menu_id WHERE uam.role_id = $role_id AND active = 1 ORDER BY uam.menu_id ASC";
            $menu = $this->db->query($queryMenu)->result_array();
             ?>
             <?php foreach ($menu as $m): ?>
                 
            <!-- Heading -->
            <div class="sidebar-heading">
                <?= $m['menu'] ?>
            </div>
            <?php      
            $queryMenu = "SELECT * FROM user_sub_menu AS usm JOIN user_menu AS um ON usm.menu_id = um.id WHERE usm.menu_id = $m[id] AND usm.is_active = 1";
            $subMenu = $this->db->query($queryMenu)->result_array();
             ?>
                 <?php foreach ($subMenu as $sm): ?> 
                    <!-- Nav Item - Dashboard -->
                    <?php if ($sm['title']==$title): ?>
                        <li class="nav-item active">
                    <?php else: ?>
                        <li class="nav-item">
                    <?php endif ?>
                        <a class="nav-link pb-0" href="<?= base_url($sm['url']) ?>">
                            <i class="<?= $sm['icon'] ?>"></i>
                            <span><?= $sm['title'] ?></span></a>
                    </li>
                 <?php endforeach ?>
                <!-- Divider -->
                <hr class="sidebar-divider mt-3">
             <?php endforeach ?>

             <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('auth/logout') ?>">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Log Out</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        