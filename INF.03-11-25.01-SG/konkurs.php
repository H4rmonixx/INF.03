<?php
try{
    $pdo = new PDO("mysql:hostname=localhost;dbname=konkurs", "root", "");
} catch(PDOException $e){
    die("Nie udalo sie polaczyc z baza danych: " . $e);
}
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>WOLONTARIAT SZKOLNY</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
        <header>
            <h1>KONKURS - WOLONTARIAT SZKOLNY</h1>
        </header>
        <main>
            <section>
                <h3>Konkursowe nagrody</h3>
                <button onclick="window.location.reload()">Losuj nowe nagrody</button>
                <table>
                    <thead>
                        <tr>
                            <th>Nr</th>
                            <th>Nazwa</th>
                            <th>Opis</th>
                            <th>Wartość</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $result = $pdo->query("SELECT nazwa, opis, cena FROM nagrody ORDER BY RAND() LIMIT 5");
                        $index = 1;
                        while($row = $result->fetch(PDO::FETCH_ASSOC)){
                            echo '
                            <tr>
                                <td>'.($index++).'</td>
                                <td>'.$row['nazwa'].'</td>
                                <td>'.$row['opis'].'</td>
                                <td>'.$row['cena'].'</td>
                            </tr>
                            ';
                        }

                        ?>
                    </tbody>
                </table>
            </section>
            <aside>
                <img src="puchar.png" alt="Puchar dla wolontariusza">
                <h4>Polecane linki</h4>
                <ul>
                    <li><a href="kw1.png">Kwerenda1</a></li>
                    <li><a href="kw2.png">Kwerenda2</a></li>
                    <li><a href="kw3.png">Kwerenda3</a></li>
                    <li><a href="kw4.png">Kwerenda4</a></li>
                </ul>
            </aside>
        </main>
        <footer>
            <p>Numer zdającego: 00000000000</p>
        </footer>
    </body>
</html>
<?php
$pdo = null;
?>