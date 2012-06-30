<?php if (!isset($page)) $page = '' ?>
<?php if (!isset($subPage)) $subPage = '' ?>
<div class="row">
    <div class="twelve columns">
<ul class="nav-bar" style="margin-top: 10px !important;">
	<li>
		<a href="<?=base_url()?>admin/dashboard" class="main">Почетна</a>
        </li>
        <li>
		<a href="<?=base_url()?>admin/users" class="main">Корисници</a>
        </li>
        <li>
		<a href="<?=base_url()?>admin/fakulteti" class="main">Факултети</a>
        </li>
         <li>
		<a href="<?=base_url()?>admin/predmeti" class="main">Предмети</a>
        </li>
	
</ul>
        </div>
    </div>
<!--
 Start of the main header bar 
<nav id="header_main">
    <div class="container_12">
         Start of the main navigation 
        <ul id="nav_main">
            <li class="<?= $page == 'dashboard' ? 'current' : '' ?>">
                <a href="<?= base_url() ?>admin/dashboard">
                    <img src="<?= base_url() ?>img/icons/25x25/dark/computer-imac.png" width=25 height=25 alt="">
                    Dashboard</a>
            </li>
            <li class="<?= $page == 'admins' ? 'current' : '' ?>">
                <a href="<?= base_url() ?>admin/admins">
                    <img src="<?= base_url() ?>img/icons/25x25/dark/computer-imac.png" width=25 height=25 alt="">
                    Administrators</a>
                <ul>
                    <li class="<?= $subPage == 'all' ? 'current' : '' ?>">
                        <a href="<?=base_url()?>admin/admins/">All Administrators</a>
                    </li>
                    <li class="<?= $subPage == 'add' ? 'current' : '' ?>">
                        <a href="<?=base_url()?>admin/admins/add/">New Administrator</a>
                </ul>

            </li>
            <li class="<?= $page == 'biros' ? 'current' : '' ?>">
                <a href="<?= base_url() ?>admin/biros">
                    <img src="<?= base_url() ?>img/icons/25x25/dark/computer-imac.png" width=25 height=25 alt="">
                    Biros</a>
            </li>
            <li class="<?= $page == 'agents' ? 'current' : '' ?>">
                <a href="<?= base_url() ?>agents">
                    <img src="<?= base_url() ?>img/icons/25x25/dark/computer-imac.png" width=25 height=25 alt="">
                    Agents</a>
            </li>
            <li class="<?= $page == 'clients' ? 'current' : '' ?>">
                <a href="<?= base_url() ?>clients">
                    <img src="<?= base_url() ?>img/icons/25x25/dark/computer-imac.png" width=25 height=25 alt="">
                    Clients</a>
            </li>
        </ul>
         End of the main navigation 
    </div>
</nav>
<div id="nav_sub"></div>
</header>-->