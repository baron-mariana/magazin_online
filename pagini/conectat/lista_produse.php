<h1>Lista Produse</h1>
</br>
<form>
    <input type="text" name="kw" placeholder="Cauta produse..."/>
    <input type="submit" name="cauta" value="Cauta"/>
</form>
</br>
<a href="index.php?reseteaza">Reseteaza cautare</a>
<?php
if (isset($_GET['reseteaza'])) {
    setcookie('keyword', '', time()-1);
    $produse = preiaProduse();
} else {
    if (isset($_GET['cauta'])) {
        $keyword = $_GET['kw'];
        $produse = preiaProduseDupaConditie($keyword);
        setcookie('keyword', $keyword, time()+24*60*60);
    } else if (isset($_COOKIE['keyword'])) {
        $keyword = $_COOKIE['keyword'];
        $produse = preiaProduseDupaConditie($keyword);
    } else {
        $produse = preiaProduse();  
    }
}
if (count($produse) == 0) {
    print "Fara produse in stoc";
} else {
?>
<table>
    <tr>
        <th>Imagine</th>
        <th>Denumire</th>
        <th>Pret</th>
        <th></th>
    </tr>
<?php
    foreach ($produse as $produs) {
        print "<tr>";
        print "<td>";
?>
    <img width="50" src="imagini/<?php print $produs['imagine']; ?>"/>
    <?php
    print "</td>";
    print "<td>" . $produs['denumire'] . "</td>";
    print "<td>" . $produs['pret'] . "</td>";
    print "<td>"
    ?>
    <?php if($_SESSION['user'] == 'admin@magazinonline.ro') { ?>
        <a href="index.php?editeaza=<?php print $produs['id']; ?>">Editeaza</a>
    <?php } else {?>
        <a href="index.php?id_produs=<?php print $produs['id'];?>">Adauga in Cos</a>
    <?php } ?>
    <?php
    print "</td>";
    print "</tr>";
    }
}
?>
</table>
</br>
<?php 
if (isset($_GET['editeaza']) && !empty($_GET['editeaza']) && $_SESSION['user'] == 'admin@magazinonline.ro') {
    require_once 'pagini/conectat/editare_produs.php';
}
?>