<?php


// var_dump($_POST['caption']);
//["extension"]
//["filename"]
$filename = $_FILES['file']['name'];

$tmp_name = $_FILES['file']['tmp_name'];
$data = pathinfo($filename);
$new = $_GET['var'] . '-' . uniqid() . '.' . $data["extension"];
$link = 'location: https://' . $_SERVER['SERVER_NAME'] . '/gestionimage/new/' . $new . '/' . $_GET['var'] . '/' . $_GET['id'];
move_uploaded_file($tmp_name, './assets/uploads/' . $new);
header($link);
//traitement stockage bcadd