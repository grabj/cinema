<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Potwierdzenie rezerwacji - Cinema</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="grafika/icon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style_seats.css">
</head>
<body>
    <!-- Navigation layout -->
    <header class="container-fluid">
        <section class="row">
            <div class="col-9 col-sm-10 col-md-5 col-xl-4">
                <a href="index.html"><img src="grafika/logo.png" alt="logo kina" /></a>
            </div>
            <nav class="col align-self-end">
                <ul class="navbar justify-content-around">
                    <li class="nav-item">
                        <a class="nav-link btn-lg btn-outline-dark" href="repertuar.php">REPERTUAR</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-lg btn-outline-dark" href="index.html">PREMIERY</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-lg btn-outline-dark" href="about.html">O NAS</a>
                    </li>
                </ul>
            </nav>
        </section>
    </header>
    <!-- Main content layout -->  
    <main class="container">
        <?php
        // Check if all reqired values were set
            if((isset($_POST["seats"])) && isset($_POST["sala"]) && isset($_POST["imie"]) && isset($_POST["nazwisko"]) && isset($_POST["day"]) && isset($_POST["tel"]))
            {
            // Connect to DB
                $bazaDanych= new mysqli('sql200.epizy.com','epiz_33102002', 'P1sNgTfDqxlzO', 'epiz_33102002_cinema');
                if ($bazaDanych->connect_error)
                {
                    die('Błąd połączenia z bazą danych (numer błędu: '
                    . $bazaDanych->connect_errno. ') Komunikat błędu: '
                    . $bazaDanych->connect_error);
                }
                mysqli_set_charset($bazaDanych, 'utf8mb4');
            // Get all required values 
                $dzien = $_POST['day'];
                $imie = $_POST["imie"];
                $nazwisko = $_POST["nazwisko"];
                $tel = $_POST["tel"];
                $sala = $_POST["sala"];
                $seats = $_POST["seats"];
                $tytul = $_POST['title'];
                $day = $_POST['day'];
                $godzina = $_POST['hour'];
                $seatsArray = explode("_", $seats);
                $length = count($seatsArray);

            // Check every seat
                for ($i = 0; $i < $length-1; $i++)
                {
                    $currentSeat = 1;
                    for($rzad=1; $rzad<7; $rzad++)
                    {
                        for($miejsce=1;$miejsce<9;$miejsce++)
                        {
                        // Send info to DB if seat of X number was selected
                            if (intval($seatsArray[$i]) == $currentSeat)
                            {
                                $query2 = "INSERT INTO `rezerwacje` VALUES ($i, '$sala','$tytul', '$dzien', '$godzina', '$rzad','$miejsce', '$nazwisko', '$tel')";
                                $bazaDanych->query($query2);
                                $query = "INSERT INTO `miejsca`(`sala`, `rzad`, `miejsce`, `imie`, `nazwisko`, `tel`, `dzien`, `godzina`, `tytul`) VALUES ('$sala','$rzad','$miejsce','$imie','$nazwisko', '$tel', '$dzien','$godzina', '$tytul')";
                                $bazaDanych->query($query);
                            }
                            $currentSeat+=1;
                        }
                    }
                }
                $bazaDanych->close();
           }  
        ?>  
        <section class="row justify-content-center row-cols-1 row-cols-md-2 row-cols-xl-3">
            <article class="col col-md-12 col-lg-11 col-xl-8" id="formularz">
       <?php
        // Get all values and print them for user to see
            $imie = $_POST["imie"];
            $nazwisko = $_POST["nazwisko"];
            $tel = $_POST["tel"];
            $sala = $_POST["sala"];
            $seats = $_POST["seats"];
            $title = $_POST['title'];
            $day = $_POST['day'];
            $hour = $_POST['hour'];
            echo("<h4>Dziękujemy za rezerwację biletów! Poniżej znajdziesz dokładne informacje na temat swojej rezerwacji:&nbsp</h4>");
            echo("<p>Imię:&nbsp".$imie."</p>");
            echo("<p>Nazwisko:&nbsp".$nazwisko."</p>");
            echo("<p>Telefon:&nbsp".$tel."</p>");
            echo("<p>Bilety&nbspna&nbspfilm:&nbsp".$title."</p>");
            echo("<p>Sala:&nbsp".$sala."</p>");
            echo("<p>Dzień:&nbsp".$day."</p>");
            echo("<p>Godzina:&nbsp".$hour."</p>");
        // Print all selected seats
            if (!empty($seats))
            {
                $seatsArray = explode("_", $seats);
                $length = count($seatsArray);
                echo("<p>Zarezerwowane miejsca:&nbsp");
                for ($i = 0; $i < $length-1; $i++)
                {
                    echo($seatsArray[$i]. ", ");
                }
            }
            echo("</p>");
        ?>
            </article>
        </section>
    </main>
    <!-- Footer with basic information -->
    <footer class="container">
        <section class="d-flex flex-row-reverse">
            <div>
                <address>
                    Cinema<br />
                    ul. Dworcowa 20<br />
                    61-890 Poznań<br />
                    tel. 61 222 33 33<br />
                </address>
            </div>
        </section>
    </footer>
    <script src="script.js"></script>
</body>
</html>