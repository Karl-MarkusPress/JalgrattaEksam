<?php
require_once("conf.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        // Loop through each selected row and delete it
        foreach ($_POST['delete'] as $deleteId) {
            $deleteCommand = $yhendus->prepare("DELETE FROM jalgrattaeksam WHERE id = ?");
            $deleteCommand->bind_param("i", $deleteId);
            $deleteCommand->execute();
        }
    }
}

// Fetch data from the database
$kask = $yhendus->prepare("SELECT id, eesnimi, perekonnanimi, teooriatulemus, slaalom, ringtee, t2nav, luba FROM jalgrattaeksam;");
$kask->bind_result($id, $eesnimi, $perekonnanimi, $teooriatulemus, $slaalom, $ringtee, $t2nav, $luba);
$kask->execute();
?>

<!doctype html>
<html>
<head>
    <title>Lõpetamine</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php require("navbar.php"); ?>
<h1>Lõpetamine</h1>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <table>
        <tr>
            <th></th>
            <th>Eesnimi</th>
            <th>Perekonnanimi</th>
            <th>Teooriatulemus</th>
            <th>Slaalom</th>
            <th>Ringtee</th>
            <th>Tänav</th>
            <th>Luba</th>
        </tr>

        <?php while ($kask->fetch()) : ?>
            <tr>
                <td><input type="checkbox" name="delete[]" value="<?php echo $id; ?>"></td>
                <td><?php echo $eesnimi; ?></td>
                <td><?php echo $perekonnanimi; ?></td>
                <td><?php echo $teooriatulemus; ?></td>
                <!-- Update the following lines to display "Õnnestus" or "Ebaõnnestus" -->
                <td><?php echo ($slaalom == 1) ? 'Õnnestus' : 'Ebaõnnestus'; ?></td>
                <td><?php echo ($ringtee == 1) ? 'Õnnestus' : 'Ebaõnnestus'; ?></td>
                <td><?php echo ($t2nav == 1) ? 'Õnnestus' : 'Ebaõnnestus'; ?></td>
                <td><?php echo (($slaalom == 1) && ($ringtee == 1) && ($t2nav == 1)) ? 'Saad taotleda lube' : 'Lube ei saa taotleda'; ?></td>
            </tr>
        <?php endwhile; ?>

    </table>

    <input type="submit" value="Kustuta valitud read">
</form>

</body>
</html>
