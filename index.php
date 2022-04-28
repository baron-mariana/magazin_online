<?php 
session_start();
require_once 'functii/sql_functions.php';
if (isset($_POST['conectare'])) {
    $email = $_POST['email_utilizator'];
    $parola = $_POST['pass'];
    $rezultatConectare = conectare($email, $parola);
    if ($rezultatConectare) {
        if (isset($_SESSION['eroare_login'])) {
            unset($_SESSION['eroare_login']);
        }
        $_SESSION['user'] = $email;
    } else {
        $_SESSION['eroare_login'] = "Conectare esuata";
    }
}

if (isset($_GET['id_produs'])) {
    $id = $_GET['id_produs'];
    //verific daca am produsul in cos
    if (isset($_SESSION['cos'][$id])) {
        $_SESSION['cos'][$id]++;
    } else {
        //nu am deja produsul in cos, pun valoarea 1 pe cheia coresp id-ului produsului
        $_SESSION['cos'][$id] = 1;
    }       
}
if (isset($_GET['sterge'])) {
    $id = $_GET['sterge'];
    if ($_SESSION['cos'][$id] > 1) {
        $_SESSION['cos'][$id]--;
    } else {
        unset($_SESSION['cos'][$id]);
    }
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
    </head>
    <body>
        <header id="banner"></header>
        <?php
        if (isset($_SESSION['user'])) {
            require_once 'templates/template_conectat.php';
        } else {
            require_once 'templates/template_neconectat.php';
        }       
        ?>
    </body>
</html>
