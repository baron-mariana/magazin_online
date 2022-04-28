<?php
function conectareBD(
        $host = 'localhost',
        $user = 'root',
        $password = '',
        $database = 'agenda'
        )
{
    return mysqli_connect($host, $user, $password, $database);
}

function clearData($input, $link)
{
    $input = trim($input);
    $input = htmlspecialchars($input);
    $input = stripslashes($input);
    $input = mysqli_real_escape_string($link, $input);
    
    return $input;
}

function inregistrare($email, $pass)
{
    $link = conectareBD();
    $email = clearData($email, $link);
    $pass = clearData($pass, $link);
    $pass = md5($pass);
    $utilizator = preiaUtilizatorDupaEmail($email);
    if ($utilizator) {
        return false; //la primul return intalnit functia se opreste
    }
    $query = "INSERT INTO utilizator VALUES(NULL, '$email', '$pass')";
    return mysqli_query($link, $query);
}

function preiaUtilizatorDupaEmail($adresaEmail)
{
    $link = conectareBD();
    $adresaEmail = clearData($adresaEmail, $link);
    $query = "SELECT * FROM utilizator WHERE email = '$adresaEmail'";
                                            //nume atribut bd
    $utilizator = mysqli_query($link, $query); //result set - o structura de date
    $utilizatorArray = mysqli_fetch_array($utilizator, MYSQLI_ASSOC);

    //Warning: mysqli_fetch_array() expects parameter 1 to be mysqli_result, boolean given
    //mysqli_query nu a dat rezultat ci a dat false - exista o problema cu query-ul
    //debugging pt situatia descrisa mai sus
    // 1 -  vreau sa vad ce am in variabila query -> var dump dupa definirea var query
    //vreau sa ma opresc la var_dump, dupa var_dump, pun die(); - opreste executia
    //luam query-ul si il rulam in mysql - in tab-ul sql - obtinem astfel erori detaliate
    return $utilizatorArray; //returneaza un array cu datele unui utilizator sau false
}

function preiaUtilizatori() 
{
    $link = conectareBD();
    $query = "SELECT id, email FROM utilizator";
    $utilizatori = mysqli_query($link, $query);
    $utilizatoriArray = mysqli_fetch_all($utilizatori, MYSQLI_ASSOC);
    
    return $utilizatoriArray;
}

function conectare($email, $parola)
{
    $link = conectareBD();
    $email = clearData($email, $link);
    $parola = clearData($parola, $link);
    $utilizator = preiaUtilizatorDupaEmail($email); //array cu datele utilizatorului sau false
    if ($utilizator) {
//        if (md5($parola) == $utilizator['parola']) {
//            return true;
//        } else {
//            return false;
//        }
        //echivalent cu
        return md5($parola) == $utilizator['parola'];
    } else {
        return false;
    }
}

function adaugaProdus($denumire, $pret, $imagine)
{
    $link = conectareBD();
    $denumire = clearData($denumire, $link);
    $pret = clearData($pret, $link);
    $imagine = clearData($imagine, $link);
    $query = "INSERT INTO produs VALUES(NULL, '$denumire', $pret, '$imagine')";
    return mysqli_query($link, $query);
}

function preiaProduse()
{
    $link = conectareBD();
    $query = "SELECT * FROM produs";
    $produse = mysqli_query($link, $query);
    $produseArray = mysqli_fetch_all($produse, MYSQLI_ASSOC);
    
    return $produseArray;
}

function preiaProduseDupaConditie($conditie)
{
    $link = conectareBD();
    $conditie = clearData($conditie, $link);
    $query = "SELECT * FROM produs WHERE denumire LIKE '%$conditie%'";
    #LIKE %'$conditie'% - denumirea sa contina $conditie
    #%laptop% -> denumirea sa contina laptop => laptop/un laptop/laptop lenovo
    $produse = mysqli_query($link, $query);
    $produseArray = mysqli_fetch_all($produse, MYSQLI_ASSOC);
    
    return $produseArray;
}

function preiaProdusDupaId($idProdus)
{
    $link = conectareBD();
    $idProdus = clearData($idProdus, $link);
    $query = "SELECT * FROM produs WHERE id = $idProdus";
    $produs = mysqli_query($link, $query);
    $produsArray = mysqli_fetch_array($produs, MYSQLI_ASSOC);
    
    return $produsArray;
}

function actualizeazaProdus($id, $denumire, $pret, $imagine)
{
    $link = conectareBD();
    $denumire = clearData($denumire, $link);
    $pret = clearData($pret, $link);
    $imagine = clearData($imagine, $link);
    $id = clearData($id, $link);
    if (!empty($imagine)) {
        $query = "UPDATE produs SET denumire = '$denumire', pret = $pret, imagine = '$imagine' WHERE id = $id ";
    } else {
        $query = "UPDATE produs SET denumire = '$denumire', pret = $pret WHERE id = $id ";
    }  
    
    return mysqli_query($link, $query);
}