<?php

use App\Config\Encriptar;
use App\Models\Usuarios;

$h = new Template();
$h->TITULO   = "TEST HOME";
$h->KEYWORDS = "Home";

$h->header();


$ssid = new SessionManager();



// $user = Usuarios::getUser("username", "ing.leonardo");

// echo "<br>";
// var_dump($user);
// echo "<br>";

// $valid =  Encriptar::verificar("123456", $user["password"]);

// var_dump($valid);
