<?php

require_once '../setup.php';
require_once '../database/conexion.php';
require_once '../helpers/helpers.php';

// Impide acceder sin estar logeado
if ( empty($_SESSION) ){
    header("Location: ".APP_URL.'login');
    die();
}
$user_id = $_SESSION['userdata']['id'];

// Comprobar que se recibe un id por get
if ( !isset($_GET['id']) ){
    header("Location: ".APP_URL.'login');
    die();
}
$concert_id = $_GET['id'];

// Comprobar que el concierto pertenece al usuario logeado
if( !checkConcertOwner($db, $concert_id, $user_id) ){
    header("Location: ".APP_URL);
    die();
}

$query = "DELETE FROM concerts WHERE id = $concert_id AND user_id = $user_id LIMIT 1";
$result = mysqli_query($db, $query);

header('Location: ' . $_SERVER['HTTP_REFERER']);