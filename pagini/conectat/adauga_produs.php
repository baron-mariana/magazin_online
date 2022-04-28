<?php if ($_SESSION['user'] != 'admin@magazinonline.ro') { ?>
    <h1>Pagina restrictionata</h1>
<?php } else { ?>
    <h1>Adauga Produs</h1>
    <form method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td>Denumire</td>
                <td>
                    <input type="text" name="denumire"/>
                </td>
            </tr>
            <tr>
                <td>Pret</td>
                <td>
                    <input type="text" name="pret"/>
                </td>
            </tr>
            <tr>
                <td>Imagine</td>
                <td>
                    <input type="file" name="img"/>
                </td>
            </tr>
            <tr>
                <th colspan="2">
                    <input type="submit" name="adauga" value="Adauga"/>
                </th>
            </tr>
        </table>
    </form>
    <?php
    if (isset($_POST['adauga'])) {
        $denumire = $_POST['denumire'];
        $pret = $_POST['pret'];
        if (isset($_FILES['img'])) {
            if ($_FILES['img']['error'] == 0) {
                switch ($_FILES['img']['type']) {
                    case 'image/jpg':
                    case 'image/jpeg':
                    case 'image/png':
                    case 'image/bmp':
                    case 'image/gif':
                        #$_FILES['img']['name'] nume_din_pc_user.jpg
                        $numeImagine = uniqid() . $_FILES['img']['name'];
                        $salvareServer = move_uploaded_file(
                                $_FILES['img']['tmp_name'],
                                'imagini/' . $numeImagine
                                );
                        if ($salvareServer) {
                            $salvareBd = adaugaProdus($denumire, $pret, $numeImagine);
                            if ($salvareBd) {
                                print 'Produs adugat cu succes';
                            } else {
                                unlink('imagini/' . $numeImagine);
                                print 'Eroare la salvarea in baza de date';
                            }
                        } else {
                            print 'Eroare la salvarea pe server';
                        }
                        break;
                    default:
                        print 'Fisierul adaugat nu este o imagine';
                        break;
                }
            } else {
                print 'Eroare la salvarea fisierului';
            }
        }
    }
}