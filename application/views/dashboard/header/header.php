<?php
$user = isset($user) ? $user : false;
$name = isset($user->name) ? $user->name : $user->name;
?>
<header>
    <nav id="header" class="navbar navbar-expand-lg navbar-light bg-light border-bottom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/"><img src="<?= assets("img/brand/logo-formel.svg"); ?>" height="56" alt="" /></a>
            <div class="d-flex align-items-center">
                <a href="/dashboard/logout" class="d-inline d-md-none"><i class="bi bi-power fs-3"></i></a>
                <button class="navbar-toggler open-nav-menu" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling" type="button">
                    <img src="/cdn/resource?type=pp&w=ad&s=48" id="avatar" height="26px" class="user-image avatar border" alt="" />
                </button>
            </div>
            <div class="collapse navbar-collapse open" id="appheader">
                <?php if ($user) : ?>
                    <ul class="navbar-nav ms-auto navbar-nav-scroll">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="menuapp_" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <img src="/cdn/resource?type=pp&w=ad&s=48" id="avatar" height="26px" class="user-image avatar" alt="" /><span style="position: relative;top: 2px;" class="s-sm-block"> <?= $user->name; ?> </span></span></a>
                            <div class="dropdown-menu menuapp_ mt-2 shadow dropdown-menu-arrow dropdown-menu-end animated slideIn" aria-labelledby="menuapp_" style="min-width: 240px;">
                                <!--<a href="/backoffice#/settings" class="dropdown-item"><span class="bi bi-gear-fill"></span> Paramètres</a>-->
                                <a class="dropdown-item" href="/backoffice/logout/"><span class="bi bi-arrow-left-circle-fill"></span> Déconnexion</a>
                            </div>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>