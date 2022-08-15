<?php
$currentLang = (array_key_exists("lang", $_SESSION) && $_SESSION['lang']) ? $_SESSION['lang'] : $self->defaultLanguage;
$active = isset($active) ? $active : "home";
?>
<header class="fixed-top">
    <nav class="navbar navbar-expand navbar-dark" id="topheader">
        <div class="container">
            <div class="collapse navbar-collapse" id="">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link fw-bold" href="<?= config("support_whatsapp"); ?>"><?= $self->lang("sup_cta"); ?> <i class="bi bi-arrow-right-short"></i> <?= config("support_phone3"); ?> </a></li>
                    <li class="nav-item"><a class="nav-link fw-bold" href="tel:<?= config("support_call3"); ?>"><span class="bi bi-phone"></span></a></li>
                    <li class="nav-item"><a class="nav-link fw-bold" href="<?= config("support_facebook"); ?>"><span class="bi bi-facebook"></span></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <nav class="navbar navbar-expand-lg navbar-light" id="header">
        <div class="container">
            <a class="navbar-brand p-0" href="/"><img src="<?= assets("img/brand/logo-formel.svg"); ?>" alt="" /></a>
            <div class="collapse navbar-collapse" id="mf__header_menu">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link <?php echo ($active == "home" or $active == "") ? "active" : ""; ?>" href="/"><?= $self->lang("header_link_home"); ?></a></li>
                    <li class="nav-item"><a class="nav-link <?php echo ($active == "services") ? "active" : ""; ?>" href="/services"><?= $self->lang("header_link_services"); ?></a></li>
                    <li class="nav-item"><a class="nav-link <?php echo ($active == "about" or $active == "about") ? "active" : ""; ?>" href="/about"><?= $self->lang("header_link_about"); ?></a></li>
                    <li class="nav-item"><a class="nav-link <?php echo ($active == "contact") ? "active" : ""; ?>" href="/contact"><?= $self->lang("header_link_contact"); ?></a></li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link btn btn-sm btn-dark text-white rounded-pill mx-2 px-3 <?php echo ($active == "quote") ? "active" : ""; ?>" href="/quote"><?= $self->lang("header_link_quote"); ?> <i class="bi bi-chevron-right"></i></a></li>
                    <?php if ($self->language == "en") : ?>
                        <li class="nav-item"><a class="nav-link" href="?lang=fr"><span class="mdi mdi-translate"></span> FR</a></li>
                    <?php else : ?>
                        <li class="nav-item"><a class="nav-link" href="?lang=en"><span class="mdi mdi-translate"></span> EN</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="d-flex align-items-center" id="offcanvas_">
                <a href="#" data-bs-toggle="offcanvas" data-bs-target="#mf_menu" aria-controls="mf_menu" class="d-inline d-lg-none "><i class="bi bi-list text-mary"></i></a>
            </div>
        </div>
    </nav>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="mf_menu">
        <div class="offcanvas-header">
            <h5 id="mf_menu_label"></h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body text-center">
            <div class="offcanvas-menu p-3">
                <ul class="list-group list-group-flush fs-3">
                    <li class="list-group-item"><a href="/"><?= $self->lang("header_link_home"); ?></a></li>
                    <li class="list-group-item"><a href="/services"><?= $self->lang("header_link_services"); ?></a></li>
                    <li class="list-group-item"><a href="/about"><?= $self->lang("header_link_about"); ?></a></li>
                    <li class="list-group-item"><a href="/contact"><?= $self->lang("header_link_contact"); ?></a></li>
                </ul>
            </div>
            <div class="offcanvas-menu p-3">
                <ul class="list-group list-group-flush fs-3">
                    <li class="list-group-item"><a class="btn btn-xl btn-dark text-white" href="/quote"><?= $self->lang("header_link_quote"); ?> <i class="bi bi-chevron-right"></i></a></li>
                    <?php if ($self->language == "en") : ?>
                        <li class="list-group-item"><a href="?lang=fr"><span class="mdi mdi-translate"></span> FR</a></li>
                    <?php else : ?>
                        <li class="list-group-item"><a href="?lang=en"><span class="mdi mdi-translate"></span> EN</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</header>

<div style="position:relative;">
    <div style="overflow:hidden; position: relative; width: 100%; height: 100%;">