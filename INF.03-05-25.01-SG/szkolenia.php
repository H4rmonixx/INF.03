<?php
try{
    $pdo = new PDO("mysql:hostname=localhost;dbname=firma", "root", "");
} catch(PDOException $e){
    die("Nie udalo sie polaczyc z baza: " . $e);
}
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Firma szkoleniowa</title>
        <link rel="stylesheet" href="style.css" type="text/css">
    </head>
    <body>
        <div id="container">
            <header>
                <img src="baner.jpg" alt="Szkolenia">
            </header>
            <nav>
                <ul>
                    <li><a href="index.html">Strona główna</a></li>
                    <li><a href="szkolenia.php">Szkolenia</a></li>
                </ul>
            </nav>
            <main>
                <?php

                $file = fopen("harmonogram.txt", "w");

                $result = $pdo->query("SELECT Data, Temat FROM szkolenia ORDER BY Data ASC");
                while($row = $result->fetch(PDO::FETCH_ASSOC)){
                    echo '<p>'.$row['Data'].' '.$row['Temat'].'</p>';
                    fwrite($file, $row['Data'] . " " . $row['Temat'] . "\r\n");
                }

                fclose($file);

                ?>
            </main>
            <footer>
                <h2>Firma szkoleniowa, ul. Główna 1, 23-456 Warszawa</h2>
                <p>Autor: 00000000000</p>
            </footer>
        </div>
    </body>
</html>
<?php
$pdo = null;
?>