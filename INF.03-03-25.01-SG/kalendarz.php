<?php
try{
    $pdo = new PDO("mysql:hostname=localhost;dbname=kalendarz", "root", "");
} catch(PDOException $e){
    die("Nie udalo sie polaczyc z baza danych: " . $e);
}
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Kalendarz</title>
        <link rel="stylesheet" type="text/css" href="styl.css">
    </head>
    <body>
        <header>
            <h1>Dni, miesiące, lata...</h1>
        </header>
        <section id="napis">
            <p>
                <?php

                $days = ["niedziela", "poniedziałek", "wtorek", "środa", "czwartek", "piątek", "sobota"];

                $stmt = $pdo->prepare("SELECT imiona FROM imieniny WHERE data LIKE ?");
                $stmt->execute([date("m-d")]);
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                $stmt->closeCursor();

                echo '<p>Dzisiaj jest '.$days[date("w")].', '.date("d-m-Y").', imieniny: '.$data['imiona'].'</p>';

                ?>
            </p>
        </section>
        <main>
            <section id="lewy">
                <table>
                    <thead>
                        <tr>
                            <th>liczba dni</th>
                            <th>miesiąc</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="7">31</td>
                            <td>styczeń</td>
                        </tr>
                        <tr><td>marzec</td></tr>
                        <tr><td>maj</td></tr>
                        <tr><td>lipiec</td></tr>
                        <tr><td>sierpień</td></tr>
                        <tr><td>październik</td></tr>
                        <tr><td>grudzień</td></tr>
                        <tr>
                            <td rowspan="4">30</td>
                            <td>kwiecień</td>
                        </tr>
                        <tr><td>czerwiec</td></tr>
                        <tr><td>wrzesień</td></tr>
                        <tr><td>listopad</td></tr>
                        <tr>
                            <td>28 lub 29</td>
                            <td>luty</td>
                        </tr>
                    </tbody>
                </table>
            </section>
            <section id="srodkowy">
                <h2>Sprawdź kto ma urodziny</h2>
                <form action="" method="post">
                    <input type="date" name="data" min="2024-01-01" max="2024-12-31" value="2024-01-01" required>
                    <input type="submit" value="wyślij">
                </form>
                <?php

                if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['data'])){
                    $stmt = $pdo->prepare("SELECT imiona FROM imieniny WHERE data LIKE ?");
                    $stmt->execute([date("m-d", strtotime($_POST['data']))]);
                    $data = $stmt->fetch(PDO::FETCH_ASSOC);
                    $stmt->closeCursor();

                    echo 'Dnia '.$_POST['data'].' są imieniny: '.$data['imiona'];
                }

                ?>
            </section>
            <section id="prawy">
                <a href="https://pl.wikipedia.org/wiki/Kalendarz_Majów" target="_blank">
                    <img src="kalendarz.gif" alt="Kalendarz Majów">
                </a>
                <h2>Rodzaje kalendarzy</h2>
                <ol>
                    <li>
                        słoneczny
                        <ul>
                            <li>kalendarz Majów</li>
                            <li>juliański</li>
                            <li>gregoriański</li>
                        </ul>
                    </li>
                    <li>
                        księżycowy
                        <ul>
                            <li>starogrecki</li>
                            <li>babiloński</li>
                        </ul>
                    </li>
                </ol>
            </section>
        </main>
        <footer>
            <p>Stronę opracował(a): 00000000000</p>
        </footer>
    </body>
</html>
<?php
$pdo = null;
?>