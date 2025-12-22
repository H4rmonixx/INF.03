<?php

try{
    $pdo = new PDO("mysql:hostname=localhost;dbname=egzamin", "root", "");
} catch(PDOException $e){
    die("Nie udalo sie polaczyc z baza danych: " . $e);
}

?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>piłka nożna</title>
        <link rel="stylesheet" href="styl2.css">
    </head>
    <body>
        <header>
            <h3>Reprezentacja polski w piłce nożnej</h3>
            <img src="obraz1.jpg" alt="reprezentacja">
        </header>
        <section id="container1">
            <div id="block_left">
                <form action="" method="post">
                    <select name="pozycja">
                        <option value="1">Bramkarze</option>
                        <option value="2">Obrońcy</option>
                        <option value="3">Pomocnicy</option>
                        <option value="4">Napastnicy</option>
                    </select>
                    <input type="submit" value="Zobacz">
                </form>
                <img src="zad2.png" alt="piłka">
                <p>Autor: 00000000000</p>
            </div>
            <div id="block_right">
                <ol>
                    <?php
                    
                    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pozycja'])){
                        $stmt = $pdo->prepare("SELECT imie, nazwisko FROM zawodnik WHERE pozycja_id = ?");
                        $stmt->execute([$_POST['pozycja']]);
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            echo '<li><p>'.$row['imie'].' '.$row['nazwisko'].'</p></li>';
                        }
                    }

                    ?>
                </ol>
            </div>
        </section>
        <main>
            <h3>Liga mistrzów</h3>
        </main>
        <section id="league">
            <?php

            $result = $pdo->query("SELECT zespol, punkty, grupa FROM liga ORDER BY punkty DESC");
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                echo '
                <div class="team">
                <h2>'.$row['zespol'].'</h2>
                <h1>'.$row['punkty'].'</h1>
                <p>grupa: '.$row['grupa'].'</p>
                </div>
                ';
            }

            ?>
        </section>
    </body>
</html>

<?php

$pdo = null;

?>