<?php
try{
    $pdo = new PDO("mysql:hostname=localhost;dbname=psy", "root", "");
} catch(PDOException $e){
    die("Nie udalo sie polaczyc z baza danych: " . $e);
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum o psach</title>
    <link rel="stylesheet" href="styl4.css" type="text/css">
</head>
<body>
    <header>
        <h1>Forum wielbicieli psów</h1>
    </header>
    <main>
        <aside>
            <img src="obraz.jpg" alt="foksterier">
        </aside>
        <section>
            <article>
                <h2>Zapisz się</h2>
                <form action="" method="post">
                    <label for="login">login: </label><input type="text" name="login" id="login"><br>
                    <label for="password1">hasło: </label><input type="password" name="password1" id="password1"><br>
                    <label for="password2">powtórz hasło: </label><input type="password" name="password2" id="password2"><br>
                    <input type="submit" value="Zapisz">
                </form>
                <?php

                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    if(isset($_POST['login']) && isset($_POST['password1']) && isset($_POST['password2']) &&
                        !empty($_POST['login']) && !empty($_POST['password1']) && !empty($_POST['password2'])){
                        $result = $pdo->query("SELECT login FROM uzytkownicy");
                        $existing = false;
                        while($row = $result->fetch(PDO::FETCH_ASSOC)){
                            if($row['login'] == $_POST['login']){
                                echo '<p>login występuje w bazie danych, konto nie zostało dodane</p>';
                                $existing = true;
                                break;
                            }
                        }
                        if(!$existing && $_POST['password1'] != $_POST['password2']){
                            echo '<p>hasła nie są takie same, konto nie zostało dodane</p>';
                        } else {
                            $stmt = $pdo->prepare("INSERT INTO uzytkownicy (`login`, `haslo`) VALUES (?, ?)");
                            $stmt->execute([$_POST['login'], sha1($_POST['password1'])]);
                            $stmt->closeCursor();
                            echo '<p>Konto zostało dodane</p>';
                        }
                    } else {
                        echo '<p>wypełnij wszystkie pola</p>';
                    }
                }

                ?>
            </article>
            <article>
                <h2>Zapraszamy wszystkich</h2>
                <ol>
                    <li>właścicieli psów</li>
                    <li>weterynarzy</li>
                    <li>tych, co chcą kupić psa</li>
                    <li>tych, co lubią psy</li>
                </ol>
                <a href="regulamin.html">Przeczytaj regulamin forum</a>
            </article>
        </section>
    </main>
    <footer>Stronę wykonał: 00000000000</footer>
</body>
</html>
<?php
$pdo = null;
?>