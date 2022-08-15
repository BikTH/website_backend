<?php
$title = _get("action") == "edit" ? "Modfier" : "Nouveau";
$cta = _get("action") == "edit" ? "Mettre à jour" : "Publier maintenant";
$action = "save";

$edit = _get("action") == "edit";
if ($edit) {
    $testimonial = $master->_get("testimonial", array("uid" => _get("id")));
    if (!$testimonial) {
        return;
    }

    $action = "update";
}
?>

<div class="modal-header">
    <h5 class="modal-title"><?= $title; ?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form action="" id="formtestimonial">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="form-floating">
                        <input type="text" maxlength="20" value="<?php echo $edit ? json_decode($testimonial->name) : ""; ?>" class="form-control" id="name" name="name" placeholder="Nom" required />
                        <label for="name">Nom</label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <p class="label-text2">Civilité</p>
                    <input value="male" type="radio" class="btn-check" name="gender" id="gender1" autocomplete="off" required="required" <?php echo $edit ? $testimonial->gender == 'male' ? 'checked' : "" : ""; ?>>
                    <label class="btn btn-outline-dark" for="gender1">Monsieur</label>

                    <input value="female" type="radio" class="btn-check" name="gender" id="gender2" autocomplete="off" <?php echo $edit ? $testimonial->gender == 'female' ? 'checked' : "" : ""; ?>>
                    <label class="btn btn-outline-dark" for="gender2">Madame</label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="form-floating">
                <textarea style="height: 150px;" maxlength="300" class="form-control" placeholder="Ecrivez Ici..." name="message" id="message"><?php echo $edit ? json_decode($testimonial->comment) : ""; ?></textarea>
                <label for="description">Message</label>
            </div>
            <span class="text-muted font-notice">300 caractères maximum sont recommandés.</span>
        </div>
        <input type="hidden" name="id" value="<?php echo $edit ? $testimonial->uid : ""; ?>" />
    </form>
</div>
<div class="modal-footer">
    <button type="button" id="trigger" class="btn btn-dark"><?= $cta; ?></button>
</div>

<script>
    $(document).ready(function() {

        $("#trigger").on("click", function(e) {
            var form = $("#formtestimonial").serialize();
            $.ajax({
                type: "post",
                url: "/backoffice/testimonial/<?= $action; ?>",
                dataType: "json",
                data: form,
                beforeSend: function() {
                    $.isLoading();
                },
                complete: function() {
                    $.isLoading("hide");
                },
                success: function(data) {
                    if (data && data.status) {
                        $.alert("Témoignage publié avec succès");
                        if (modal && modal._isShown) {
                            modal.hide();
                        }
                    }
                }
            });
        });
    });
</script>