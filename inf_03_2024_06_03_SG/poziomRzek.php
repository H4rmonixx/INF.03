<?php

try{
    $pdo = new PDO("mysql:hostname=localhost;dbname=rzeki", "root", "");
} catch (PDOException $e){
    die("Nie udalo sie polaczyc z baza danych: " . $e);
}

?>
<!DOCTYPE html>
<html>
    <head lang="pl">
        <meta charset="UTF-8">
        <title>Poziomy rzek</title>
        <link rel="stylesheet" type="text/css" href="styl.css">
    </head>
    <body>
        <header>
            <section>
                <img src="obraz1.png" alt="Mapa Polski">
            </section>
            <section>
                <h1>Rzeki  w  województwie dolnośląskim</h1>
            </section>
        </header>
        <nav>
            <form action="" method="post">
                <label class="radio-label"><input type="radio" name="view" value="all">Wszystkie</label>
                <label class="radio-label"><input type="radio" name="view" value="warning">Ponad stan ostrzegawczy</label>
                <label class="radio-label"><input type="radio" name="view" value="danger">Ponad stan alarmowy</label>
                <input type="submit" value="Pokaż">
            </form>
        </nav>
        <main>
            <section>
                <h3>Stany na dzień 2022-05-05</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Wodomierz</th>
                            <th>Rzeka</th>
                            <th>Ostrzegawczy</th>
                            <th>Alarmowy</th>
                            <th>Aktualny</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['view'])){

                            if($_POST['view'] == 'warning')
                                $sql = "SELECT w.nazwa, w.rzeka, w.stanOstrzegawczy, w.stanAlarmowy, p.stanWody FROM wodowskazy w INNER JOIN pomiary p ON w.id = p.wodowskazy_id WHERE p.dataPomiaru LIKE '2022-05-05' AND p.stanWody > w.stanOstrzegawczy";
                            else if ($_POST['view'] == 'danger')
                                $sql = "SELECT w.nazwa, w.rzeka, w.stanOstrzegawczy, w.stanAlarmowy, p.stanWody FROM wodowskazy w INNER JOIN pomiary p ON w.id = p.wodowskazy_id WHERE p.dataPomiaru LIKE '2022-05-05' AND p.stanWody > w.stanAlarmowy";
                            else
                                $sql = "SELECT w.nazwa, w.rzeka, w.stanOstrzegawczy, w.stanAlarmowy, p.stanWody FROM wodowskazy w INNER JOIN pomiary p ON w.id = p.wodowskazy_id WHERE p.dataPomiaru LIKE '2022-05-05'";

                            $result = $pdo->query($sql);
                            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                                echo '
                                <tr>
                                    <td>'.$row['nazwa'].'</td>
                                    <td>'.$row['rzeka'].'</td>
                                    <td>'.$row['stanOstrzegawczy'].'</td>
                                    <td>'.$row['stanAlarmowy'].'</td>
                                    <td>'.$row['stanWody'].'</td>
                                </tr>
                                ';
                            }

                        }

                        ?>
                    </tbody>
                </table>
            </section>
            <aside>
                <h3>Informacje</h3>
                <ul>
                    <li>Brak  ostrzeżeń  o  burzach z gradem</li>
                    <li>Smog w mieście Wrocław</li>
                    <li>Silny wiatr w Karkonoszach</li>
                </ul>
                <h3>Średnie stany wód</h3>
                <?php

                $sql = "SELECT dataPomiaru, AVG(stanWody) as SredniStan FROM pomiary GROUP BY dataPomiaru";
                $result = $pdo->query($sql);

                while($row = $result->fetch(PDO::FETCH_ASSOC)){
                    echo '<p>'.$row['dataPomiaru'].': '.$row['SredniStan'].'</p>';
                }

                ?>
                <a href="https://komunikaty.pl">Dowiedz się więcej</a>
                <img src="obraz2.jpg" alt="rzeka">
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