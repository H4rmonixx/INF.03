<?php
try{
    $pdo = new PDO("mysql:hostname=localhost;dbname=portal", "root", "");
} catch(PDOException $e){
    die("Nie udalo sie polaczyc z baza danych: " . $e);
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal społecznościowy</title>
    <link rel="stylesheet" href="styl5.css" type="text/css">
</head>
<body>
    <header>
        <section>
            <h2>Nasze osiedle</h2>
        </section>
        <section>
                <?php
                
                $result = $pdo->query("SELECT Count(*) as ilosc FROM dane");
                $data = $result->fetch(PDO::FETCH_ASSOC);
                echo '<h5>Liczba użytkowników portalu: '.$data['ilosc'].'</h5>';

                ?>
        </section>
    </header>
    <main>
        <aside>
            <h3>Logowanie</h3>
            <form action="" method="post">
                <label for="login">login</label><br>
                <input type="text" name="login" id="login"><br>
                <label for="haslo">hasło</label><br>
                <input type="password" name="haslo" id="haslo"><br>
                <input type="submit" value="Zaloguj">
            </form>
        </aside>
        <section>
            <h3>Wizytówka</h3>
            <div id="wizytowka">
                <?php

                if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login']) && isset($_POST['haslo'])){
                    $stmt = $pdo->prepare("SELECT haslo FROM uzytkownicy WHERE login LIKE ?");
                    $stmt->execute([$_POST['login']]);
                    $data = $stmt->fetch(PDO::FETCH_ASSOC);
                    $stmt->closeCursor();
                    if(!$data){
                        echo 'login nie istnieje';
                    } else if($data['haslo'] == sha1($_POST['haslo'])){
                        $stmt = $pdo->prepare("SELECT login, rok_urodz, przyjaciol, hobby, zdjecie FROM uzytkownicy u INNER JOIN dane d ON u.id = d.id WHERE login LIKE ?");
                        $stmt->execute([$_POST['login']]);
                        $data = $stmt->fetch(PDO::FETCH_ASSOC);
                        $stmt->closeCursor();

                        echo '
                        <img src="'.$data['zdjecie'].'" alt="osoba">
                        <h4>'.$data['login'].' ('.((int)(date("Y")) - (int)($data['rok_urodz'])).')</h4>
                        <p>hobby: '.$data['hobby'].'</p>
                        <h1><img src="icon-on.png" alt="serce">'.$data['przyjaciol'].'</h1>
                        <a href="dane.html"><button>Więcej informacji</button></a>
                        ';

                    } else {
                        echo 'hasło nieprawidłowe';
                    }
                }

                ?>
            </div>
        </section>
    </main>
    <footer>
        Stronę wykonał: 00000000000
    </footer>
</body>
</html>
<?php
$pdo = null;
?>