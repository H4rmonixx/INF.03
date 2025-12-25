<?php

try{
    $pdo = new PDO("mysql:hostname=localhost;dbname=kalendarz", "root", "");
} catch(PDOException $e){
    die("Nie udalo sie polaczyc z baza: " . $e);
}

?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Sierpniowy kalendarz</title>
        <link rel="stylesheet" type="text/css" href="styl5.css">
    </head>
    <body>
        <header>
            <section>
                <h1>Organizer: SIERPIEŃ</h1>
            </section>
            <section>
                <form action="" method="post">
                    <label for="event">Zapisz wydarzenie: </label>
                    <input type="text" id="event" name="event">
                    <input type="submit" value="OK">
                </form>
                <?php

                if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['event'])){
                    $stmt = $pdo->prepare("UPDATE zadania SET wpis = ? WHERE dataZadania LIKE '2020-08-09'");
                    $stmt->execute([$_POST['event']]);
                    $stmt->closeCursor();
                }

                ?>
            </section>
            <section>
                <img src="logo2.png" alt="sierpień">
            </section>
        </header>
        <main>
            <?php

            $result = $pdo->query("SELECT dataZadania, wpis FROM zadania WHERE miesiac LIKE 'sierpien'");
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                echo '
                <div class="calendar-card">
                    <h5>'.$row['dataZadania'].'</h5>
                    <p>'.$row['wpis'].'</p>
                </div>
                ';
            }

            ?>
        </main>
        <footer>
            <p>Stronę wykonał: 00000000000</p>
        </footer>
    </body>
</html>
<?php

$pdo = null;

?>