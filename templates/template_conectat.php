<nav id="meniu">
    <ul>
        <li><a href="index.php">Lista Produse</a></li>
         <?php if($_SESSION['user'] == 'admin@magazinonline.ro') { ?>
            <li><a href="index.php?page=1">Adauga Produs</a></li>
         <?php } ?>
        <?php if ($_SESSION['user'] != 'admin@magazinonline.ro') { ?>
            <li><a href="index.php?page=2">Cos Cumparaturi</a></li>
        <?php } ?>
        <li><a href="index.php?deconectare">Deconectare, <?php print $_SESSION['user'];?></a></li>
    </ul>
</nav>
<section id="continut">
<?php
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 1:
            require_once 'pagini/conectat/adauga_produs.php';
            break;
        case 2:
            require_once 'pagini/conectat/cos_cumparaturi.php';
            break;
        default:
     require_once 'pagini/eroare.php';
    }
} else {
    require_once 'pagini/conectat/lista_produse.php';
}

if (isset($_GET['deconectare'])) {
    session_destroy();
    setcookie('keyword', '', time()-1);
    header("location:index.php");
}
?>
</section>


