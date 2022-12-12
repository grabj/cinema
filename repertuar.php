<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Repertuar - Cinema</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="grafika/icon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
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
        <h1 class="display-3">REPERTUAR</h1>
        <section class="row row-cols-1 justify-content-center" id="repertuar">   
            <!-- Buttons for changing selected day -->
            <form action="repertuar.php">
                <input type="submit" class="button" name="Dzien" value="Czwartek" />
                <input type="submit" class="button" name="Dzien" value="Piątek" />
                <input type="submit" class="button" name="Dzien" value="Sobota" />
                <input type="submit" class="button" name="Dzien" value="Niedziela" />
                <input type="submit" class="button" name="Dzien" value="Poniedziałek" />
                <input type="submit" class="button" name="Dzien" value="Wtorek" />
                <input type="submit" class="button" name="Dzien" value="Środa" />
            </form>
            <table class="table table-fixed" style="background: white;">
                <thead>
                    <tr>
                        <th colspan="3">
                        <?php
                    // Print selected day, if nothing selected print current as default
                        $days = array('Niedziela', 'Poniedziałek', 'Wtorek', 'Środa','Czwartek','Piątek', 'Sobota');
                        $currentDayOfWeek = (int) date('w');
                         print(isset($_GET["Dzien"]) ? $_GET["Dzien"] : $days[$currentDayOfWeek]);
                         ?>
                         </th>
                    </tr>
                    <tr>
                        <th class="col-6">Film</th>
                        <th class="col-auto">Godzina</th>
                        <th class="col-1">Sala</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        //$currentDay = 5;
                    // Check if day was set
                        if(isset($_GET["Dzien"]))
                        {
                            $formValue = $_GET["Dzien"];
                        }
                        else
                        {
                        // If nothing selected select current day  
                            $days = array('Niedziela', 'Poniedziałek', 'Wtorek', 'Środa','Czwartek','Piątek', 'Sobota');
                            $currentDayOfWeek = (int) date('w');
                            $currentDay = $currentDayOfWeek;
                            $formValue = $days[$currentDayOfWeek];
                        }
                    // Set the right day to be displayed
                        switch($formValue)
                        {
                            case "Czwartek":
                                $currentDay = 5;
                                break;
                            case "Piątek":
                                $currentDay = 6;
                                break;
                            case "Sobota":
                                $currentDay = 7;
                                break;
                            case "Niedziela":
                                $currentDay = 1;
                                break;
                            case "Poniedziałek":
                                $currentDay = 2;
                                break;
                            case "Wtorek":
                                $currentDay = 3;
                                break;
                            case "Środa":
                                $currentDay = 4;
                                break;
                            default:
                                $currentDay = 5;
                                break;
                        }
                // Connect to DB
                    $bazaDanych= new mysqli('sql200.epizy.com','epiz_33102002', 'P1sNgTfDqxlzO', 'epiz_33102002_cinema');
                    if ($bazaDanych->connect_error)
                    {
                        die('Błąd połączenia z bazą danych (numer błędu: '
                        . $bazaDanych->connect_errno. ') Komunikat błędu: '
                        . $bazaDanych->connect_error);
                    }
                    mysqli_set_charset($bazaDanych, 'utf8mb4');
                // Get information from DB and display them for user to see
                    $query = "SELECT * FROM repertuar WHERE DAYOFWEEK(date_start) = $currentDay ORDER BY date_start";
                    if ($result = $bazaDanych->query($query))
                    {
                        while($row = $result->fetch_assoc())
                        {
                            $timestamp = strtotime($row["date_start"]);
                            $hour = date("H:i", $timestamp);
                            $sala = $row["sala"];
                            $title = $row["title"];
                            echo "<tr><td>".$row["title"]."</td><td><a class='btn btn-primary' href=\"sala.php?sala=$sala&title=$title&day=$formValue&hour=$hour\">".$hour."</a></td><td>".$sala."</td></tr>";
                        }
                    }
                    $bazaDanych->close();
                    ?>
                </tbody>
            </table>
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