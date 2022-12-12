<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rezerwacja - Cinema</title>
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
        <section class="row justify-content-center row-cols-1 row-cols-md-2 row-cols-xl-3">
            <article class="col col-md-12 col-lg-11 col-xl-8" id="formularz">
                <form action="potwierdzenie.php" method="POST">
                    <?php
                    // Get all values
                        $sala = $_GET["sala"];
                        $seats = $_GET["seats"];
                        $title = $_GET['title'];
                        $day = $_GET['day'];
                        $hour = $_GET['hour'];
                        $seatsArray = array();
                        $compare = "_";
                        $numberOfSelectedSeats = 0;
                    // Print values for user to see
                        echo("<br /><label>Bilety na film:&nbsp;" .$title."</label><br />");
                        echo("<label>Dzień:&nbsp;".$day."</label><br />");
                        echo("<label>Godzina:&nbsp;".$hour."</label><br />");
                        echo("<label>Sala:&nbsp;".$sala. "</label>");
                    // Check if seats were selected
                        if (!empty($seats))
                        {
                        // Get seats string and separate it. Then print all selected seats individually
                            $seatsArray = explode("_", $seats);
                            $length = count($seatsArray);
                            echo("<h4>Zarezerwowane miejsca:</h4>");
                            for ($i = 0; $i < $length-1; $i++)
                            {
                                echo("<label>".$seatsArray[$i]."</label>, ");
                                $numberOfSelectedSeats+=1;
                            }
                        }
                    // Silently POST rest of the values to another site
                        echo("<input hidden=\"true\" type=\"number\" name=\"sala\" readonly=\"true\" value=\"$sala\">");
                        echo("<input hidden=\"true\" type=\"text\" name=\"seats\" readonly=\"true\" value=\"$seats\">");
                        echo("<input hidden=\"true\" type=\"text\" name=\"title\" readonly=\"true\" value=\"$title\">");
                        echo("<input hidden=\"true\" type=\"text\" name=\"day\" readonly=\"true\" value=\"$day\">");
                        echo("<input hidden=\"true\" type=\"text\" name=\"hour\" readonly=\"true\" value=\"$hour\">");
                    ?>
                        <br />
                        <h4>Dane osoby składającej rezerwację:</h4>
                        <div class="row">
                            <div class="col">
                                <label for="imie-input">Imię</label>
                                <input type="text" class="form-control" id="imie-input" name="imie"  tabindex="1" required>
                            </div>
                            <div class="col">
                                <label for="nazwisko-input">Nazwisko</label>
                                <input type="text" class="form-control" id="nazwisko-input" name="nazwisko" tabindex="2" required>
                            </div>
                        </div>
                        <div>
                            <label for="tel-input">Numer telefoniczny</label>
                            <input type="tel" class="form-control" id="tel-input" name="tel" tabindex="3" required>
                        </div><br />
                            <div class="form-check">
                            <input type="checkbox" class="check-input" value="" tabindex="4" required>
                            <label class="form-check-label" for="check-regulamin">Zapoznałem się z regulaminem i akceptuję jego postanowienia.</label>
                        </div><br />
                        <button type="submit" class="btn btn-primary" tabindex="5">Dokonaj rezerwacji</button>
                    </form>
                </form>
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
</body>
</html>