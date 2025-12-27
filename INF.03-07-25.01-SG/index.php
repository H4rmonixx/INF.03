<?php
try{
    $pdo = new PDO("mysql:hostname=localhost;dbname=wykaz", "root", "");
} catch(PDOException $e){
    die("Nie udalo sie polaczyc z baza danych: " . $e);
}
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Wyszukiwarka miast</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="shortcut icon" type="image/png" href="fav.png">
    </head>
    <body>

        <div id="container">
            <header>
                <img src="baner.jpg" alt="Polska">
            </header>
            <main>
                <aside>
                    <article id="left1">
                        <h4>Podaj początek nazwy miasta</h4>
                        <form action="" method="post">
                            <input type="text" name="search">
                            <input type="submit" value="Szukaj">
                        </form>
                    </article>
                    <article id="left2">
                        <p>Egzamin INF.03</p>
                        <p>Autor: 00000000000</p>
                    </article>
                </aside>
                <section>
                    <h1>Wyniki wyszukiwania miast z uwzględnieniem filtra:</h1>
                    <?php

                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])){

                        echo '<p class="filter-p">'.$_POST['search'].'</p>';
                        echo '
                        <table>
                            <thead>
                                <tr>
                                    <th>Miasto</th>
                                    <th>Województwo</th>
                                </tr>
                            </thead>
                            <tbody>
                        ';

                        $stmt = $pdo->prepare("SELECT m.nazwa as miasto, w.nazwa as wojewodztwo FROM miasta m INNER JOIN wojewodztwa w ON m.id_wojewodztwa = w.id WHERE m.nazwa LIKE ? ORDER BY m.nazwa ASC");
                        $stmt->execute([$_POST['search']."%"]);
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            echo '
                            <tr>
                                <td>'.$row['miasto'].'</td>
                                <td>'.$row['wojewodztwo'].'</td>
                            </tr>
                            ';
                        }

                        echo '
                            </tbody>
                        </table>
                        ';
                    }

                    ?>
                </section>
            </main>
        </div>
        
    </body>
</html>
<?php
$pdo = null;
?>