<main id="app" class="my-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4 d-md-block d-none">
                <div id="app_nav">
                    <div id="navigation_main_menu" class="d-md-block mb-3 mb-md-0">
                        <div class="list-group list-group-flush main_app_menu fs-5">
                            <a id="a1" href="#/request" class="list-group-item list-group-item-action"><span><i class="bi me-2 bi-patch-question-fill"></i> Devis</span></a>
                            <a id="a2" href="#/store" class="list-group-item list-group-item-action"><span><i class="bi me-2 bi-cart2"></i> Boutique</span></a>
                            <a id="a3" href="#/testimonial" class="list-group-item list-group-item-action"><span><i class="bi bi-chat-right-heart"></i> Testimonial</span></a>
                            <a id="a4" href="#/setting" class="list-group-item list-group-item-action"><span><i class="bi me-2 bi-sliders"></i> Paramètres</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <?php if ($this->alert->has_alert('invalid_password')) : ?>
                    <div class="alert alert-warning alert-dismissible fade show">Ce mot de passe n'est pas valide <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
                <?php elseif ($this->alert->has_alert("updated_password")) : ?>
                    <div class="alert alert-success alert-dismissible fade show">Votre profil a été mis à jour <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
                <?php elseif ($this->alert->has_alert("updated_info")) : ?>
                    <div class="alert alert-success alert-dismissible fade show">Votre profil a été mis à jour avec succès <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
                <?php endif; ?>
                <div id="window">
                    <h1>Loading...</h1>
                </div>
            </div>
        </div>
        <div id="navigation_bottom_menu" class="d-md-none d-sm-flex d-flex">
            <div class="list-group main_app_menu">
                <a id="a1" href="#/request" class="list-group-item list-group-item-action text-center"><span><i class="bi me-2 bi-patch-question-fill"></i><br />Devis</span></a>
                <a id="a2" href="#/store" class="list-group-item list-group-item-action text-center"><span><i class="bi me-2 bi-cart2"></i><br />Boutique</span></a>
                <a id="a3" href="#/testimonial" class="list-group-item list-group-item-action text-center"><span><i class="bi bi-chat-right-heart"></i><br />Testimonial</span></a>
                <a id="a4" href="#/setting" class="list-group-item list-group-item-action text-center"><span><i class="bi me-2 bi-sliders"></i><br />Paramètres</span></a>
            </div>
        </div>
    </div>
</main>

<script>isConnected = true;</script>