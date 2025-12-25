<?php

try{
    $pdo = new PDO("mysql:hostname=localhost;dbname=wazenietirow", "root", "");
} catch (PDOException $e){
    die("Nie udalo sie polaczyc z baza danych: " . $e);
}

$pdo->query("INSERT INTO wagi (lokalizacje_id, waga, rejestracja, dzien, czas) VALUES (5, FLOOR(RAND()*10+1), 'DW12345', CURRENT_DATE, CURRENT_TIME)");
header("Refresh: 10");

?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Ważenie samochodów ciężarowych</title>
        <link rel="stylesheet" href="styl.css">
    </head>
    <body>
        <header>
            <section>
                <h1>Ważenie  pojazdów  we Wrocławiu</h1>
            </section>
            <section>
                <img src="obraz1.png" alt="waga">
            </section>
        </header>
        <main>
            <aside id="left">
                <h2>Lokalizacje wag</h2>
                <ol>
                    <?php

                    $result = $pdo->query("SELECT ulica FROM lokalizacje");
                    while($row = $result->fetch(PDO::FETCH_ASSOC)){
                        echo '<li>ulica '.$row['ulica'].'</li>';
                    }

                    ?>
                </ol>
                <h2>Kontakt</h2>
                <a href="mailto:wazenie@wroclaw.pl">napisz</a>
            </aside>
            <section>
                <h2>Alerty</h2>
                <table>
                    <thead>
                        <tr>
                            <th>rejestracja</th>
                            <th>ulica</th>
                            <th>waga</th>
                            <th>dzień</th>
                            <th>czas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $result = $pdo->query("SELECT rejestracja, ulica, waga, dzien, czas FROM wagi w INNER JOIN lokalizacje l ON w.lokalizacje_id = l.id WHERE waga > 5");
                        while($row = $result->fetch(PDO::FETCH_ASSOC)){
                            echo '
                            <tr>
                                <td>'.$row['rejestracja'].'</td>
                                <td>'.$row['ulica'].'</td>
                                <td>'.$row['waga'].'</td>
                                <td>'.$row['dzien'].'</td>
                                <td>'.$row['czas'].'</td>
                            </tr>
                            ';
                        }

                        ?>
                    </tbody>
                </table>
            </section>
            <aside id="right">
                <img src="obraz2.jpg" alt="tir">
            </aside>
        </main>
        <footer>
            <p>Stronę wykonał: 00000000000</p>
        </footer>
    </body>
</html>
<?php

$pdo = null;

?>