<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/fabc1f8cf6.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="shortcut icon" href="../view/assets/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../view/assets/css/style.css">

    <?php
        if(!isset($titulo) || empty($titulo)) {
            $titulo = 'FrancisGol';
        }
        echo "<title>$titulo</title>";

        if(!empty($css)){ 
            echo '<link rel="stylesheet" href="../view/assets/css/'.$css.'">'; 
        }

    ?>

</head>
<body>