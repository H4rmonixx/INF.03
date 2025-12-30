<?php
try{
    $pdo = new PDO("mysql:hostname=localhost;dbname=kupauto", "root", "");
} catch(PDOException $e){
    die("Nie udalo sie polaczyc z baza danych: " . $e);
}
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Komis aut</title>
        <link rel="stylesheet" href="styl.css" type="text/css">
    </head>
    <body>
        <header>
            <h1><em>KupAuto!</em>  Internetowy  Komis Samochodow</h1>
        </header>
        <main>
            <section id="glowny1">
                <?php

                $result = $pdo->query("SELECT model, rocznik, przebieg, paliwo, cena, zdjecie FROM samochody WHERE id = 10");
                $data = $result->fetch(PDO::FETCH_ASSOC);

                echo '
                <img src="'.$data['zdjecie'].'" alt="oferta dnia">
                <h4>Oferta Dnia: Toyota '.$data['model'].'</h4>
                <p>Rocznik '.$data['rocznik'].', przebieg: '.$data['przebieg'].', rodzaj paliwa: '.$data['paliwo'].'</p>
                <h4>Cena: '.$data['cena'].'</h4>
                ';

                ?>
            </section>
            <section id="glowny2">
                <h2>Oferty Wyróżnione</h2>
                <?php

                $result = $pdo->query("SELECT m.nazwa, s.model, s.rocznik, s.cena, s.zdjecie FROM samochody s INNER JOIN marki m ON s.marki_id = m.id WHERE s.wyrozniony = 1 LIMIT 4");
                while($row = $result->fetch(PDO::FETCH_ASSOC)){
                    echo '
                    <div class="oferta">
                        <img src="'.$row['zdjecie'].'" alt="'.$row['model'].'">
                        <h4>'.$row['nazwa'].' '.$row['model'].'</h4>
                        <p>Rocznik: '.$row['rocznik'].'</p>
                        <h4>Cena: '.$row['cena'].'</h4>
                    </div>
                    ';
                }

                ?>
                <div class="reset_float"></div>
            </section>
            <section id="glowny3">
                <h2>Wybierz markę</h2>
                <form action="" method="post">
                    <select name="marka">
                        <?php

                        $result = $pdo->query("SELECT nazwa FROM marki");
                        while($row = $result->fetch(PDO::FETCH_ASSOC)){
                            echo '<option value="'.$row['nazwa'].'">'.$row['nazwa'].'</option>';
                        }

                        ?>
                    </select>
                    <input type="submit" value="Wyszukaj">
                </form>
                <?php

                if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['marka'])){
                    $stmt = $pdo->prepare("SELECT s.model, s.cena, s.zdjecie FROM samochody s INNER JOIN marki m ON s.marki_id = m.id WHERE m.nazwa LIKE ?");
                    $stmt->execute([$_POST['marka']]);

                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        echo '
                        <div class="oferta">
                            <img src="'.$row['zdjecie'].'" alt="'.$row['model'].'">
                            <h4>'.$_POST['marka'].' '.$row['model'].'</h4>
                            <h4>Cena: '.$row['cena'].'</h4>
                        </div>
                        ';
                    }
                }

                ?>
                <div class="reset_float"></div>
            </section>
        </main>
        <footer>
            <p>Stronę wykonał: 00000000000</p>
            <p>
                <a href="http://firmy.pl/komis">Znajdź nas także</a>
            </p>
        </footer>
    </body>
</html>
<?php
$pdo = null;
?>