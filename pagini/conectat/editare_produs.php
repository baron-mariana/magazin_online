<?php 

    $idProdus = $_GET['editeaza'];
    $produs = preiaProdusDupaId($idProdus);
?>

<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php print $produs['id'];?>"/>
    <table>
        <tr>
            <td>Denumire</td>
            <td>
                <input type="text" name="denumire" value="<?php print $produs['denumire']?>"/>
            </td>
        </tr>
        <tr>
            <td>Pret</td>
            <td>
                <input type="text" name="pret" value="<?php print $produs['pret'];?>"/>
            </td>
        </tr>
        <tr>
            <td>
                <img width="100" src="imagini/<?php print $produs['imagine']; ?>"/>
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
                <input type="submit" name="editeaza" value="Editeaza"/>
            </th>
        </tr>
    </table>
</form>
<?php
    if (isset($_POST['editeaza'])) {
        $denumire = $_POST['denumire'];
        $pret = $_POST['pret'];
        $id = $_POST['id'];
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
                            $salvareBd = actualizeazaProdus($id, $denumire, $pret, $numeImagine);
                            if ($salvareBd) {
                                header('location:index.php');
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
            } else if ($_FILES['img']['error'] == 4) {
                $salvareBd = actualizeazaProdus($id, $denumire, $pret, '');
                if ($salvareBd) {
                    header('location:index.php');
                    } else {
                        print 'Eroare la salvarea in baza de date';
                    }
            } else {
                print 'Eroare la salvarea fisierului';
            }
        }
    }

