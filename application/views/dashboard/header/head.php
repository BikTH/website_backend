<?php

$bodyID = isset( $body ) ? $bodyID : "app";

?>
<!DOCTYPE html>
<head>
    <title><?php echo ( isset( $title ) ) ? $title : ""; ?></title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <link rel="icon" type="image/png" href="/public/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="<?=assets("css/jquery-confirm.min.css");?>" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />

    <link rel="stylesheet" href="<?=assets("css/app/website.css", true, false)."?".now();?> ?>" />
    <link rel="stylesheet" href="<?=assets("css/app/core.css", true, false);?> ?>" />
    
    <!--<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">-->
    <link rel="stylesheet" href="<?=assets("css/image-uploader.css", false, true);?> ?>" />
    <!--<link type="text/css" rel="stylesheet" href="http://example.com/image-uploader.min.css">-->

    <script src="<?=assets("js/jquery.min.js", false, true);?>"></script>
    <script src="<?=assets("js/jquery-confirm.min.js", false, true);?>"></script>
    <script src="<?=assets("js/jquery-loading.js", true, true);?>"></script>
    <script src="<?=assets("js/jquery.hashroute.js", false, true);?>"></script>
    <script src="<?=assets("js/jquery.sticky.js", false, true);?>"></script>

    
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    
    <script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>
</head>
<body class="" id="<?=$bodyID;?>">
    <!--<div class="preloader_"><span class="isloading-wrapper" style="top: 223.5px;"><div class="centered">     <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>    </div></span></div>-->
    <script type="text/javascript">
        $(window).on("load resize", function(){ var w__ = parseInt( $(this).outerWidth(), 10);if( w__ < 768){ window.isMobile = true; } else { window.isMobile = false; }});
        // $(document).ready(function(){setTimeout(function () {$(".preloader_").fadeOut(100); $("body").css("overflow", "auto");}, 1000);});
    </script>