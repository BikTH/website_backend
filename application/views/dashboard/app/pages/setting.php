<div>
    <div class="h5 fw-bold"><i class="bi bi-sliders me-2"></i> Paramétres</div>
</div>
<hr />
<main class="main">
    <form action="/backoffice/updatepw" id="infoform" autocomplete="off" enctype="multipart/form-data" method="post">
        <!--<div class="form-group">-->
        <!--    <div class="form-floating mb-3">-->
        <!--        <input type="text" required class="form-control form-control-sm" value="<?= $user->name; ?>" maxlength="14" id="label_name" name="name" placeholder="Name" />-->
        <!--        <label for="label_name">Name</label>-->
        <!--    </div>-->
        <!--</div>-->
        <div class="row align-items-center justify-content-center">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="form-floating mb-3">
                        <input type="password" required name="old" inputmode="text" class="form-control form-control-sm" id="label_password" placeholder="Current password" />
                        <label for="label_password">Mot de passe actuel</label>
                    </div>
                </div>
            </div> 
            <div class="col-md-6">
                <div class="form-group">
                    <div class="form-floating mb-3">
                        <input type="password" required placeholder="New password" name="new" inputmode="text" class="form-control form-control-sm" id="password" />
                        <label for="password">Nouveau mot de passe</label>
                    </div>
                </div>
            </div>
            <div class="col-12 text-center">
                <div class="form-group d-grid d-md-block align-end my-4">
                    <button type="submit" class="btn btn-secondary">Mettre à jour</button>
                </div>
            </div>
        </div>
    </form>
</main>