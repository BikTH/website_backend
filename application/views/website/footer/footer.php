<?php
$currentLang = (array_key_exists("lang", $_SESSION) && $_SESSION['lang']) ? $_SESSION['lang'] : $self->defaultLanguage;
?>
<div class="call-to-action bg-black py-5 m-0">
    <div class="container">
        <div class="row align-items-center flex-wrap-reverse">
            <div class="col-lg-12">
                <h2 class="text-white fw-bold"><?= $self->lang("cta-header"); ?></h2>
                <p class="text-white fs-5"><?= $self->lang("cta-content"); ?></p>
                <a href="/quote" class="btn btn-light"><?= $self->lang("cta-quote"); ?></a>
            </div>
        </div>
    </div>
</div>
<footer class="footer border-top border-dark">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 text-md-start text-center">
                <div class=""><?= $self->lang("footer_copyright_text"); ?></div>
            </div>
            <div class="col-12 col-md-6 text-md-end text-center">
                <div class="mt-4 d-block d-md-none"></div>
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="<?= config("support_whatsapp"); ?>"><span class="bi bi-whatsapp"></span></a></li>
                    <li class="list-inline-item"><a href="<?= config("support_facebook"); ?>"><span class="bi bi-facebook"></a></li>
                    <li class="list-inline-item"><a href="/legal/privacy"><?= $self->lang("footer_link_privacy_policy"); ?></a></li>
                    <li class="list-inline-item"><a href="/legal/terms"><?= $self->lang("footer_link_terms_of_use"); ?></a></li>
                </ul>
            </div>
        </div>
        <div class="text-center">
            <ul class="list-inline">
                <li class="list-inline-item font-notice text-muted">Proudly designed by <a class="text-mute devtext" href="https://www.openxtech.com/" target="_blank">Openxtech</a> </li>
            </ul>
        </div>
    </div>
</footer>
<div class="cookie-alert-footer" id="cookiefooter">
    <div class="container text-center">
        <div class="font-14">
            <div class="py-2"><?= $self->lang("cookie-1"); ?> <a class="a text-white" href="/legal/privacy"><?= $self->lang("footer_link_privacy_policy"); ?></a></div>
            <div><a href="#" class="btn btn-light" data-action="dismiss"><?= $self->lang("cookie-2"); ?></a></div>
        </div>
    </div>
</div>
</div></div>

<!--END LINKS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script type="application/javascript" src="<?= assets("js/jquery-loading.js"); ?>"></script>

<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script type="application/javascript" src="<?= assets("js/website.js", false, true); ?>"></script>
<script type="application/javascript" src="<?= assets("js/owl.js", false, true); ?>"></script>
<script type="application/javascript" src="https://unpkg.com/lightgallery@2.5.0/lightgallery.min.js"></script>
<script type="application/javascript" src="https://unpkg.com/lightgallery@2.5.0/plugins/thumbnail/lg-thumbnail.umd.js"></script>
<script type="application/javascript" src="https://unpkg.com/lightgallery@2.5.0/plugins/zoom/lg-zoom.min.js"></script>


</body>

</html>