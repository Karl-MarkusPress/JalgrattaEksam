<?php
require_once("database.php");

if (!empty($_REQUEST["teooriatulemus"])) {
    $teooriatulemus = $_REQUEST["teooriatulemus"];
    $id = $_REQUEST["id"];

    // Check if the test score is between 1 and 100
    if ($teooriatulemus >= 1 && $teooriatulemus <= 100) {
        // Check if the test score is less than 10
        if ($teooriatulemus < 10) {
            // You failed the test, so you have to redo it
            echo "Teooria eksam ebaõnnestus, said vähem kui 10 punkti. Tee eksam uuesti!";
        } else {
            // Update the database if the conditions are met
            $kask = $yhendus->prepare("UPDATE jalgrattaeksam SET teooriatulemus=? WHERE id=?");
            $kask->bind_param("ii", $teooriatulemus, $id);
            $kask->execute();
            echo "Tulemus on aksepteeritav";
        }
    } else {
        echo "Testi tulemus peab jääma 1-100 punkti vahele";
    }
}

// Fetch and display records with teooriatulemus equal to -1
$kask = $yhendus->prepare("SELECT id, eesnimi, perekonnanimi FROM jalgrattaeksam WHERE teooriatulemus=-1");
$kask->bind_result($id, $eesnimi, $perekonnanimi);
$kask->execute();
?>

<!doctype html>
<html>

<head>
    <?php require("navbar.php"); ?>
    <title>Teooriaeksam</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <table>
        <?php
        while ($kask->fetch()) {
            echo " 
     <tr> 
     <td>$eesnimi</td> 
     <td>$perekonnanimi</td> 
     <td>
         <form action=''> 
             <input type='hidden' name='id' value='$id' /> 
             <input type='number' name='teooriatulemus' min='1' max='100' />
             <input type='submit' value='Sisesta tulemus' /> 
         </form> 
     </td> 
     </tr> 
     ";
        }
        ?>
    </table>
</body>

</html>