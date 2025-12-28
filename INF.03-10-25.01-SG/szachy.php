<?php
try{
    $pdo = new PDO("mysql:hostname=localhost;dbname=szachy", "root", "");
} catch(PDOException $e){
    die("Nie udalo sie polaczyc z baza danych: " . $e);
}
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>KOŁO SZACHOWE</title>
        <link rel="stylesheet" href="styles.css" type="text/css">
    </head>
    <body>
        <header>
            <h2>Koło szachowe <em>gambit piona</em></h2>
        </header>
        <main>
            <aside>
                <h4>Polecane linki</h4>
                <ul>
                    <li><a href="kw1.png">kwerenda1</a></li>
                    <li><a href="kw2.png">kwerenda2</a></li>
                    <li><a href="kw3.png">kwerenda3</a></li>
                    <li><a href="kw4.png">kwerenda4</a></li>
                </ul>
                <img src="logo.png" alt="Logo koła">
            </aside>
            <section>
                <h3>Najlepsi gracze naszego koła</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Pozycja</th>
                            <th>Pseudonim</th>
                            <th>Tytuł</th>
                            <th>Ranking</th>
                            <th>Klasa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $result = $pdo->query("SELECT pseudonim, tytul, ranking, klasa FROM zawodnicy WHERE ranking > 2787 ORDER BY ranking DESC");
                        $index = 1;
                        while($row = $result->fetch(PDO::FETCH_ASSOC)){
                            echo '
                            <tr>
                                <td>'.($index++).'</td>
                                <td>'.$row['pseudonim'].'</td>
                                <td>'.$row['tytul'].'</td>
                                <td>'.$row['ranking'].'</td>
                                <td>'.$row['klasa'].'</td>
                            </tr>
                            ';
                        }

                        ?>
                    </tbody>
                </table>
                <form action="" method="post">
                    <input type="submit" value="Losuj  nową  parę  graczy" name="random">
                </form>
                <?php

                if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['random'])){
                        $result = $pdo->query("SELECT pseudonim, klasa FROM zawodnicy ORDER BY RAND() LIMIT 2");
                    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

                    echo '<h4>'.$rows[0]['pseudonim'].' '.$rows[0]['klasa'].' '.$rows[1]['pseudonim'].' '.$rows[1]['klasa'].'</h4>';     
                }

                ?>
                <p>Legenda: AM - Absolutny Mistrz, SM - Szkolny Mistrz, PM - Mistrz Poziomu, KM - Mistrz Klasowy</p>
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