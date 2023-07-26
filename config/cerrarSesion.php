<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
<style>
        #contendor{
            width: 40%;
            margin: auto;
        }
        body{
            margin-top: 250px;
        }
    </style>
<?php
echo " <div class='container' id='contenedor'>
<div class='alert alert-success text-center' role='alert'>
<h1 style='text-align: center;'>¡Hasta La Proxima!</h1>
<img src='.'../img/uu.gif.'.' alt=''>   
</div>
</div>   "; 
session_start();
session_destroy();
header("refresh:2 ../index.php");
?>
</body>
</html>