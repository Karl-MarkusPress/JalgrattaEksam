<?php  
require_once("conf.php"); 

if (isset($_REQUEST["sisestusnupp"])) {
    // Validate input using regular expressions
    $validEesnimi = preg_match("/^[A-Za-züÜõÕäÄöÖšŠžŽ ]+$/", $_REQUEST["eesnimi"]);
    $validPerekonnanimi = preg_match("/^[A-Za-züÜõÕäÄöÖšŠžŽ ]+$/", $_REQUEST["perekonnanimi"]);

    // Additional check to ensure the name is not only spaces
    $notEmptyEesnimi = trim($_REQUEST["eesnimi"]) !== "";
    $notEmptyPerekonnanimi = trim($_REQUEST["perekonnanimi"]) !== "";

    if ($validEesnimi && $validPerekonnanimi && $notEmptyEesnimi && $notEmptyPerekonnanimi) {
        // If input is valid, proceed with database insertion
        $kask = $yhendus->prepare("INSERT INTO jalgrattaeksam(eesnimi, perekonnanimi) VALUES (?, ?)");
        $kask->bind_param("ss", $_REQUEST["eesnimi"], $_REQUEST["perekonnanimi"]);
        $kask->execute();

        $yhendus->close();
        header("Location: $_SERVER[PHP_SELF]?lisatudeesnimi=$_REQUEST[eesnimi]");
        exit();
    } else {
        // Display an error message if input is invalid
        echo "Nimi ei tohi sisaldada numbreid ega tühikuid";
    }
}
?> 

<!doctype html> 
<html> 
<head> 
    <title>Kasutaja registreerimine</title>
    <link rel="stylesheet" type="text/css" href="style.css"> 
</head> 
<body> 
    <h1>Registreerimine</h1> 
    <?php 
    require("navbar.php");
    if (isset($_REQUEST["lisatudeesnimi"])) { 
        echo "Lisati $_REQUEST[lisatudeesnimi]"; 
    } 
    ?> 

    <form action="?"> 
        <dl> 
            <dt>Eesnimi:</dt> 
            <dd><input type="text" name="eesnimi" /></dd> 

            <dt>Perekonnanimi:</dt> 
            <dd><input type="text" name="perekonnanimi" /></dd> 
            <dt><input type="submit" name="sisestusnupp" value="sisesta" /></dt>  
        </dl> 
    </form> 
</body> 
</html>
