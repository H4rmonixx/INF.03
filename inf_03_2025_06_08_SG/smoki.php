<?php
try{
    $pdo = new PDO("mysql:hostname=localhost;dbname=smoki", "root", "");
} catch(PDOException $e){
    die("Nie udalo sie polaczyc z baza danych: " . $e);
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smoki</title>
    <link rel="stylesheet" href="styl.css" type="text/css">
</head>
<body>
    <header>
        <h2>Poznaj smoki!</h2>
    </header>
    <nav>
        <section class="nawigacja aktywna">Baza</section>
        <section class="nawigacja">Opisy</section>
        <section class="nawigacja">Galeria</section>
    </nav>
    <main>
        <section class="sekcja widoczna">
            <h3>Baza Smoków</h3>
            <form action="" method="post">
                <select name="kraj">
                    <?php
                    $result = $pdo->query("SELECT DISTINCT pochodzenie FROM smok ORDER BY pochodzenie ASC");
                    while($row = $result->fetch(PDO::FETCH_ASSOC)){
                        echo '<option value="'.$row['pochodzenie'].'">'.$row['pochodzenie'].'</option>';
                    }

                    ?>
                </select>
                <input type="submit" value="Szukaj">
            </form>
            <table>
                <tr>
                    <th>Nazwa</th>
                    <th>Długość</th>
                    <th>Szerokość</th>
                </tr>
                <?php
                
                if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['kraj'])){
                    $stmt = $pdo->prepare("SELECT nazwa, dlugosc, szerokosc FROM smok WHERE pochodzenie LIKE ?");
                    $stmt->execute([$_POST['kraj']]);
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        echo '
                        <tr>
                            <td>'.$row['nazwa'].'</td>
                            <td>'.$row['dlugosc'].'</td>
                            <td>'.$row['szerokosc'].'</td>
                        </tr>
                        ';
                    }
                    $stmt->closeCursor();
                }

                ?>
            </table>
        </section>
        <section class="sekcja">
            <h3>Opisy smoków</h3>
            <dl>
                <dt>Smok czerwony</dt>
                <dd>Pochodzi z Chin. Ma 1000 lat. Żywi się mniejszymi zwierzętami. Posiada łuski cenne na rynkach wschodnich do wyrabiania lekarstw. Jest dziki i groźny.</dd>
                <dt>Smok zielony</dt>
                <dd>Pochodzi z Bułgarii. Ma 10000 lat. Żywi się mniejszymi zwierzętami, ale tylko w kolorze zielonym. Jest kosmaty. Z sierści zgubionej przez niego, tka się najdroższe materiały.</dd>
                <dt>Smok niebieski</dt>
                <dd>Pochodzi z Francji. Ma 100 lat. Żywi się owocami morza. Jest natchnieniem dla najlepszych malarzy. Często im pozuje. Smok ten jest przyjacielem ludzi i czasami im pomaga. Jest jednak próżny i nie lubi się przepracowywać.</dd>
            </dl>
        </section>
        <section class="sekcja">
            <h3>Galeria</h3>
            <img src="smok1.jpg" alt="Smok czerwony">
            <img src="smok2.jpg" alt="Smok wielki">
            <img src="smok3.jpg" alt="Skrzydlaty łaciaty">
        </section>
    </main>
    <footer>
        <p>Stronę opracował: 00000000000</p>
    </footer>

    <script>

        const nawigacje = document.getElementsByClassName("nawigacja");
        const sekcje = document.getElementsByClassName("sekcja");

        for(let i=0; i<nawigacje.length; i++){
            nawigacje[i].addEventListener("click", ()=>{
                zmienSekcje(i);
            });
        }

        function zmienSekcje(numer){
            for(let i=0; i<nawigacje.length; i++){
                if(i == numer) nawigacje[i].classList.add("aktywna");
                else nawigacje[i].classList.remove("aktywna");
            }
            for(let i=0; i<sekcje.length; i++){
                if(i == numer) sekcje[i].classList.add("widoczna");
                else sekcje[i].classList.remove("widoczna");
            }
        }
    </script>

</body>
</html>
<?php
$pdo = null;
?>