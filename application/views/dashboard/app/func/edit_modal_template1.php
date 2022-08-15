<?php
$title = _get("action") == "edit" ? "Modifier" : "Nouveau";
$cta = _get("action") == "edit" ? "Mettre à jour" : "Publier maintenant";
$action = "save";

$edit = _get("action") == "edit";
if ($edit) {
    $casket = $master->_get("casket", array("uid" => _get("id")));
    if (!$casket) {
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
    <form action="" id="formcasket">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="form-floating">
                        <input type="text" maxlength="64" value="<?php echo $edit ? $casket->name : ""; ?>" class="form-control" id="name" name="name" placeholder="Nom, modèle..." />
                        <label for="name">Nom, modèle...</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-floating">
                        <select class="form-select" name="type" id="type">
                            <option <?php echo $edit && $casket->type == "local" ? "selected" : ""; ?> value="local">Fabrication locale</option>
                            <option <?php echo $edit && $casket->type == "imported" ? "selected" : ""; ?> value="imported">Importé</option>
                        </select>
                        <label for="type">Sélectionner la catégorie</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-floating">
                        <textarea maxlength="500" class="form-control" placeholder="Ecrivez quelque chose..." name="description" id="description" style="height: 160px"><?php echo $edit ? json_decode($casket->description) : ""; ?></textarea>
                        <label for="description">Ajoutez une description</label>
                    </div>
                    <span class="text-muted font-notice">500 caractères aux max est recommandé.</span>
                </div>

                <div class="form-group">
                    <div class="form-check form-switch">
                        <input class="form-check-input" <?php echo $edit && $casket->featured == "true" ? "checked" : ""; ?> type="checkbox" name="featured" value="true" role="switch" id="featured" />
                        <label class="form-check-label" for="featured">Mettre en avant</label>
                    </div>
                </div>

                <input type="hidden" name="id" value="<?php echo $edit ? $casket->uid : ""; ?>" />
            </div>
            <div class="col-md-6">
                <h6><span class="bi bi-image"></span> Importer des images depuis votre appareil</h6>
                <hr>
                <div>
                    <button type="button" class="btn btn-secondary btn-sm" id="filetrigger"><span class="bi bi-plus"></span>Importer une image</button>
                    <input class="form-control _file" hidden type="file" id="file" />
                </div>
                <ul class="list-group list-group-flush" id="imagecontainer"></ul>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" id="trigger" class="btn btn-dark"><?= $cta; ?></button>
</div>
<script>
    var images = [];
    var imageItem = `<li data-id="" class="list-group-item d-flex align-items-center justify-content-between casket-image-item">
					<div class="d-flex align-items-center"><img id="image" class="border p-2" width="120" src="" alt="" /> <h6 class="ms-3 text-break" style="width: 200px;" id="filename"></h6></div>
					<input type="hidden" value="" name="images[]" id="imageValue" />
					<input type="hidden" value="" name="saves[]" id="imageID" />
					<div><a onclick="clearImage(this, event);" href="#"><span class="bi bi-trash3-fill"></span></a></div>
				</li>`;

    $(document).ready(function() {
        $("#filetrigger").click(function() {
            $("input#file").trigger("click");
        });

        $("input#file").on("change", function(e) {
            var file_ = null;
            var self = $(this);
            if ((file_ = $(this)[0].files[0])) {
                img = new Image();
                filename = file_.name;
                var allowedTypes = new RegExp("(.*?)\.(png|jpg|jpeg)$");
                if (allowedTypes.test(filename.toLowerCase())) {
                    if (file_.size <= 4194304) {
                        var upload_ = $(imageItem);

                        var reader = new FileReader();
                        reader.addEventListener("load", function() { // Setting up base64 URL on image
                            upload_.find("#filename").text(filename);
                            upload_.find("#image").attr("src", reader.result);
                            upload_.find("#imageValue").val(reader.result);

                            $("#imagecontainer").prepend(upload_);
                        }, false);
                        reader.readAsDataURL(file_);

                    } else {
                        $(e.target).val("");
                        $.alert(_t("error_filesize"));
                    }
                } else {
                    $(e.target).val("");
                    $.alert(_t("error_type_image"));
                }
            }
            $(this).val("");
        });

        $("#trigger").on("click", function(e) {
            var form = $("#formcasket").serialize();
            $.ajax({
                type: "post",
                url: "/backoffice/casket/<?= $action; ?>",
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
                        $.alert("Produit publiée avec succès");
                        if (modal && modal._isShown) {
                            modal.hide();
                        }
                    }
                }
            });
        });

        <?php if ($edit) : ?>

            $.getJSON("/backoffice/casket/images?id=<?= $casket->uid; ?>", function(data) {
                if (data) {
                    $.each(data, function() {
                        images.push(this.uid);
                        //
                        var temp = $(imageItem);
                        temp.find("#filename").text(this.name);
                        temp.find("#image").attr("src", "/backoffice/getimage/" + this.name + "?s=std&w=120&c=false");
                        temp.find("#imageID").val(this.uid);

                        $("#imagecontainer").prepend(temp);
                    });
                }
            });

        <?php endif; ?>
    });

    function clearImage(el, e) {
        e.preventDefault();
        $(el).parents(".casket-image-item").remove();
    }
</script>