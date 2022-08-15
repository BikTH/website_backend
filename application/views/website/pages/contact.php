<?php
$currentLang = (array_key_exists("lang", $_SESSION) && $_SESSION['lang']) ? $_SESSION['lang'] : $self->defaultLanguage;
?>

<main>
    <section id="" class="section-header _bg">
        <div class="container text-center">
            <h1 class="display-3 h-curved text-center"><?= $self->lang("section-1-header"); ?></h1>
            <p class="page-description"><?= $self->lang("section-1-content"); ?></p>
        </div>
    </section>


    <section class="section form border-top _">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h3 class="fw-bold"><?= $self->lang("section-2-text-header"); ?></h3>
                    <p class="fs-5"><?= $self->lang("section-2-text-subheader"); ?></p>
                    <address>
                        <h6 class="fw-bold"><i class="bi bi-geo-alt-fill"></i> <?= config("support_address"); ?></h6>
                        <ul class="list-unstyled">
                            <li><?= $self->lang("section-2-text-phone"); ?> 1 <i class="bi bi-arrow-right-short"></i> <a href="tel:<?= config("support_call"); ?>"><?= config("support_phone"); ?></a></li>
                            <li><?= $self->lang("section-2-text-phone"); ?> 2 <i class="bi bi-arrow-right-short"></i> <a href="tel:<?= config("support_call3"); ?>"><?= config("support_phone3"); ?></a></li>
                            <li><?= $self->lang("section-2-text-phone"); ?> 3 <i class="bi bi-arrow-right-short"></i> <a href="tel:<?= config("support_call2"); ?>"><?= config("support_phone2"); ?></a></li>
                            <li><?= $self->lang("section-2-text-mailbox"); ?> <i class="bi bi-arrow-right-short"></i> <a href="mailto:<?= config("support_email"); ?>"><?= config("support_email"); ?></li></a>
                        </ul>
                    </address>
                    <iframe style="width:100%; height: 300px;" id="gmap_canvas" src="https://maps.google.com/maps?q=mary%20funerals&t=&z=15&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                </div>
                <hr class="d-block d-md-none my-4" />
                <div class="col-md-6">
                    <form action="/app/sendmessage" method="post">
                        <?php if ($this->alert->has_alert('security')) : ?>
                            <div class="alert bg-warning"><span class="mdi mdi-robot-angry"></span> <?= $self->lang("section-2-form-alert-1"); ?></div>
                        <?php elseif ($this->alert->has_alert('mail_sent')) : ?>
                            <div class="alert bg-success text-white"> <?= $self->lang("section-2-form-alert-2"); ?></div>
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="label"><?= $self->lang("section-2-form-label-1"); ?></label>
                                    <input name="name" required autofocus type="text" class="form-control" id="name" placeholder="<?= $self->lang("section-2-form-placeholder-1"); ?>" />
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="contact" class="label"><?= $self->lang("section-2-form-label-2"); ?></label>
                                    <input name="contact" inputmode="text" required type="text" class="form-control" id="contact" placeholder="<?= $self->lang("section-2-form-placeholder-2"); ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <select class="form-select" id="topic" name="topic">
                                    <option value="appointment"><?= $self->lang("section-2-form-select-1"); ?></option>
                                    <option value="more_information"><?= $self->lang("section-2-form-select-2"); ?></option>
                                </select>
                                <label for="topic"><?= $self->lang("section-2-form-label-3"); ?></label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="label"><?= $self->lang("section-2-form-label-4"); ?></label>
                            <textarea name="message" required class="form-control" maxlength="500" style="height: 140px" id="message" placeholder="<?= $self->lang("section-2-form-placeholder-4"); ?>"></textarea>
                            <div class="mt-1 font-notice text-muted"><?= $self->lang("section-2-form-label-4-notice"); ?></div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="<?= config("google-recaptcha-site-key"); ?>"></div>
                            </div>
                        </div>
                        <div class=""><button type="submit" class="btn btn-dark"><?= $self->lang("section-2-form-submit"); ?><i class="bi bi-arrow-right-circle ms-1"></i></button></div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>