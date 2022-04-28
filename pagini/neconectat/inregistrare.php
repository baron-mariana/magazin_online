<h1>Inregistrare</h1>
<form method="post">
    <table>
        <tr>
            <td>Email</td>
            <td>
                <input type="email" name="email_utilizator"/>
            </td>
        </tr>
        <tr>
            <td>Parola</td>
            <td>
                <input type="password" name="pass"/>
            </td>
        </tr>
        <tr>
            <th colspan="2">
                <input type="submit" name="inregistrare" value="Inregistrare"/>
            </th>
        </tr>
    </table>
</form>
<?php 
if (isset($_POST['inregistrare'])) {
    $email = $_POST['email_utilizator'];
    $parola = $_POST['pass'];
    $rezultatInregistrare = inregistrare($email, $parola);
    if ($rezultatInregistrare) {
        //autologin
        $_SESSION['user'] = $email;
        header('location:index.php');
    } else {
        print 'Eroare la inregistrare';
    }
}

//afisam un tabel
//id    email
//4     test
//5     test2
$utilizatori = preiaUtilizatori();
?>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Email</th>
    </tr>
<?php
foreach ($utilizatori as $utilizator) {
    print "<tr>";
    print "<td>" . $utilizator['id'] . "</td>";
    print "<td>" . $utilizator['email'] . "</td>";
    print "</tr>";
}
print "</table>";
