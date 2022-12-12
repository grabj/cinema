<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Cinema - Wybór miejsc</title>
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
        
        <?php 
            // Get all data
            $sala = $_GET["sala"]; 
            $title=$_GET['title'];
            $day = $_GET["day"];
            $hour=$_GET['hour']; 
            $arr = array();

            echo('<h1 class="display-3">' .$title. ', Sala ' .$sala. ', ' .$day. ' ' .$hour. '</h1>');
            echo('<section class="row row-cols-1 justify-content-center">
                    <article class="col col-md-8 col-lg-7" id="sala-content">
                <h4>Zaznacz miejsca, które chcesz zarezerwować (max. 6)</h4><br />');

                // Make an array for seats
                    for($i = 1; $i<7; $i++)
                    {
                        $arr[$i] = array_fill(1, 9, false);
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
                // Get values from DB about already sold seats
                    $query = "SELECT DISTINCT * FROM miejsca WHERE (sala = $sala) AND (dzien = '$day') AND (godzina = '$hour')";
                    if ($result = $bazaDanych->query($query))
                    {
                        while($row = $result->fetch_assoc())
                        {
                            $arr[$row["rzad"]][$row["miejsce"]] = true;
                        }
                    }  
                    
                    $seatNumber = 0;
                    echo('<div class="panel panel-default">
                    <div class="panel-heading">EKRAN</div></div>');
                // Print all seats
                    for($i = 1; $i<7; $i++)
                    {
                        echo('<div class="row" id="rzad">');
                        for($j=1;$j<9;$j++)
                        {
                        // Check if seat was found in DB, if so - mark it as sold
                            if($arr[$i][$j] == true)
                            {
                                $seatNumber = $seatNumber + 1;
                                echo('<a class="seat sold"></a>');
                            }
                        // Otherwise print it as usual
                            else
                            {
                                $seatNumber = $seatNumber + 1;
                                echo("<a class=\"seat\" onClick=\"changeColor(this.id)\" id=\"seat".$seatNumber."\"></a>");
                            }
                        }
                        echo('</div>');
                    }
                $bazaDanych->close();
        ?> 
                <br />
                <button type="submit" class="btn btn-primary" onclick="getValues();" value="Wybierz miejsca">Wybierz miejsca</button>
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
    <script>
        var seat = new Int32Array(50);
    // Change seat colors onclilck
        function changeColor(seatID)
        {
            const colors = ['#22192b', '#64ac64'];
            var numberOfSelectedSeats = 0;
            var seatToChange = document.getElementById(seatID);
            var seatNumberInText = seatID.replace( /^\D+/g, '');
            var seatNumber = parseInt(seatNumberInText);
        // Count all selected seats (to later check if user can select more)
            for (let i = 0; i < seat.length; i++)
            {
                if(seat[i] > 0)
                {
                    numberOfSelectedSeats += 1;
                }
            } 
        // Unset a selected seat
            if (seat[seatNumber] > 0)
            {
                seat[seatNumber] = 0;
                seatToChange.style.backgroundColor = colors[0];
            }
            else{
            // Check if user won't exceed max seats to select. If not - color and add them to the list of selected ones
                if (numberOfSelectedSeats < 6)
                {
                    seat[seatNumber] = 1;
                    seatToChange.style.backgroundColor = colors[1];
                }
            }
        }
    // Get values from PHP and redirect to another page 
        function getValues() {
        // Get values from PHP
            var occupiedSeats = "";
            var title = "<?php echo $title;?>";
            var day = "<?php echo $day ?>";
            var hour = "<?php echo $hour ?>";
            var nrSali = "<?php echo $sala ?>";
        // Make a string that has numbers of all selected seats
            for (let i = 0; i < seat.length; i++)
            {
                if(seat[i] > 0)
                {
                    occupiedSeats = occupiedSeats + i + "_";
                }
            }
        // Check if any seats were selected. If not - print a message. If they are - put PHP values in link and redirect
            if(occupiedSeats=="")
                window.alert("Prosimy wybrać miejsca do rezerwacji!");
            else    
                window.location.href="formularz.php?sala=" + nrSali + "&title=" + title + "&day=" + day + "&hour=" + hour + "&seats=" + occupiedSeats;
        }
    </script>
</body>
</html>