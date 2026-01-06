<?php
try{
    $pdo = new PDO("mysql:hostname=localhost;dbname=przewozy", "root", "");
} catch(PDOException $e){
    die("Nie udalo sie polaczyc z baza danych: " . $e);
}

// Skrypt 1, czesc: usuwanie rekordu
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['usun_zadanie'])){
    $stmt = $pdo->prepare("DELETE FROM zadania WHERE id_zadania = ?");
    $stmt->execute([$_GET['usun_zadanie']]);
    $stmt->closeCursor();
    header("Location: przewozy.php");
    exit;
}

// Skrypt 2
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['zadanie']) && isset($_POST['data'])){
    $stmt = $pdo->prepare("INSERT INTO zadania (zadanie, `data`, osoba_id) VALUES (?, ?, 1)");
    $stmt->execute([$_POST['zadanie'], $_POST['data']]);
    $stmt->closeCursor();
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Firma Przewozowa</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>Frima przewozowa Półdarmo</h1>
    </header>
    <nav>
        <a href="kw1.PNG">kwerenda1</a>
        <a href="kw2.PNG">kwerenda2</a>
        <a href="kw3.PNG">kwerenda3</a>
        <a href="kw4.PNG">kwerenda4</a>
    </nav>
    <main>
        <section id="sekcja_lewa">
            <h2>Zadania do wykonania</h2>
            <table>
                <tr>
                    <th>Zadanie do wykonania</th>
                    <th>Data realizacji</th>
                    <th>Akcja</th>
                </tr>
                <?php

                // Skrypt 1, czesc: wyswietlanie danych w tabeli
                $result = $pdo->query("SELECT id_zadania, zadanie, `data` FROM zadania");
                while($row = $result->fetch(PDO::FETCH_ASSOC)){
                    echo '
                    <tr>
                        <td>'.$row['zadanie'].'</td>
                        <td>'.$row['data'].'</td>
                        <td><a href="przewozy.php?usun_zadanie='.$row['id_zadania'].'">Usuń</a></td>
                    </tr>
                    ';
                }

                ?>
            </table>
            <form action="" method="post">
                <label for="pole_zadanie">Zadanie do wykonania: </label>
                <input type="text" name="zadanie" id="pole_zadanie"><br>
                <label for="pole_data">Data realizacji: </label>
                <input type="date" name="data" id="pole_data">
                <input type="submit" value="Dodaj">
            </form>
        </section>
        <section id="sekcja_prawa">
            <img src="auto.png" alt="auto firmowe">
            <h3>Nasza specjalność</h3>
            <ul>
                <li>Przeprowadzki</li>
                <li>Przewóz mebli</li>
                <li>Przesyłki gabarytowe</li>
                <li>Wynajem pojazdów</li>
                <li>Zakupy towarów</li>
            </ul>
        </section>
    </main>
    <footer>
        <p>Stronę wykonał: 00000000000</p>
    </footer>
</body>
</html>
<?php
$pdo = null;
?>