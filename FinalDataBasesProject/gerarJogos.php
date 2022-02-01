<?php

    session_start();
    require_once "connect.php";

    $quicko = $_SESSION['editTourId'];

    if (!isset($_SESSION['loggedin'])) {
        header('Location: index.php');
        exit();
    }

    date_default_timezone_set('Europe/Lisbon');
    $DiasDaSemana = array('Domingo','Segunda','Terca','Quarta','Quinta','Sexta','Sabado');
    $Teams = [];
    $Datta0 =[];
    $Datta = [];
    $StartTime0 = [];
    $StartTime = [];
    $EndTime0 = [];
    $EndTime = [];
    $GameField0 = [];
    $GameField = [];
    $Home = [];
    $Away = [];
    $calendar = [];
    $FinalCalendar = [];
    $NoContesto0= [];
    $NoContesto= [];

    $db =  OpenCon();
    echo '<p>A verificar se é posível gerar os jogos...</p><br>';


    $noConstesto = $db->query("SELECT nocontestdate from dates where tournament_tournamentid=$quicko");
    console_log($noConstesto);
    $numberOfNoContest = mysqli_num_rows($noConstesto);
    console_log($numberOfNoContest);

    $basicQ = $db->query("SELECT * FROM game WHERE game.tournament_tournamentid=$quicko");
    $basicResults = mysqli_num_rows($basicQ);

    $result0 = $db->query("SELECT teamname FROM request WHERE accepted='1' and tournament_tournamentid=$quicko");
    $num_of_results0 = mysqli_num_rows($result0);

    $result = $db->query("select currentteams, enddate, startdate from tournament where tournamentid=$quicko");
    $num_of_results = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
    $teamsNumber = $row['currentteams'];
    $enddate = $row['enddate'];
    $startdate = $row['startdate'];


    $gamesCount = $teamsNumber -1;

    $result2 = $db->query("SELECT tournamentdetails.gameweekday from tournamentdetails WHERE tournamentdetails.tournament_tournamentid=$quicko");
    $numberOfDays = mysqli_num_rows($result2);


    $resultStart = $db->query("SELECT tournamentdetails.gamestarttime from tournamentdetails WHERE tournamentdetails.tournament_tournamentid=$quicko");
    $numberOfStart = mysqli_num_rows($resultStart);



    $resultEnd = $db->query("SELECT tournamentdetails.gameendtime from tournamentdetails WHERE tournamentdetails.tournament_tournamentid=$quicko");
    $numberOfEnd = mysqli_num_rows($resultEnd);


    $resultField = $db->query("SELECT tournamentdetails.gamefield from tournamentdetails WHERE tournamentdetails.tournament_tournamentid=$quicko");
    $numberOfFields = mysqli_num_rows($resultField);



    $result4 = $db->query("SELECT CURRENT_DATE, alreadystarted FROM tournament where tournamentid=$quicko");
    $row2 = mysqli_fetch_assoc($result4);
    $todayDate = $row2['CURRENT_DATE'];
    $alreadyStarted = $row2['alreadystarted'];

    if($startdate>$todayDate){
        $todayDate=$startdate;
    }

    $daysDiff = dateDifference($enddate, $todayDate);

    console_log((($daysDiff/7)*$numberOfDays));
    console_log(((($teamsNumber-1)*$teamsNumber)/2));
    console_log((($daysDiff/7)*$numberOfDays)<((($teamsNumber-1)*$teamsNumber)/2));
    console_log($teamsNumber);

    if($teamsNumber < 2){
        echo '<p style="color: red">É necessário ter pelo menos duas equipas inscritas no torneio!</p>';
    }elseif($alreadyStarted=='1'){
        echo '<p style="color: red">O torneio ja começou!</p>';
    }else{
        if((($daysDiff/7)*$numberOfDays)<((($teamsNumber-1)*$teamsNumber)/2)){
            echo '<p style="color: red">Tem de adicionar mais campos/horas durante a semana uma vez que as equipas nao podem jogar pelo menos uma vez uma contra as outras!</p>';
        }elseif ($basicResults>2) {
            echo '<p style="color: red">Já gerou jogos para este torneio! Pode agora inciar o torneio.</p>';
            echo '<p style="color: black">Pretende apagar os jogos para pode-los gerar outra vez?</p>';
            echo '<form method=post>
                <button id="boto2" type="submit" name="deletetudo" class="leButton">Apagar</button>         
            </form>
            ';
        } else{

        if ($teamsNumber%2!=0) {
            echo '<p style="color: red">Equipas impares... A criar uma equipa fantasma</p>';
        }

            $PossibleRounds = floor(((($daysDiff / 7) * $numberOfDays) / ((($teamsNumber - 1) * $teamsNumber) / 2)));

            for ($i = 0; $i < $num_of_results0; $i++) {
                $row0 = mysqli_fetch_assoc($result0);

                $Teams[$i] = $row0['teamname'];
                //array_push($Teams,$teamname);
            }

            if ($teamsNumber%2!=0) {
                $Teams[$i] = 'E. Fantasma';
                $teamsNumber = $teamsNumber + 1;
            }

            for ($i = 0; $i < $numberOfDays; $i++) {
                $rovv = mysqli_fetch_assoc($result2);
                $rovv1 = mysqli_fetch_assoc($resultStart);
                $rovv2 = mysqli_fetch_assoc($resultEnd);
                $rovv3 = mysqli_fetch_assoc($resultField);


                $Datta0[$i] = $rovv['gameweekday'];
                $StartTime0[$i] = $rovv1['gamestarttime'];
                $EndTime0[$i] = $rovv2['gameendtime'];
                $GameField0[$i] = $rovv3['gamefield'];
                //array_push($Teams,$teamname);
            }

            for($i=0; $i<$numberOfNoContest; $i++){
                $rovv4 = mysqli_fetch_assoc($noConstesto);

                $NoContesto[$i] = $rovv4['nocontestdate'];
            }

            $j = 0;
            foreach ($DiasDaSemana as $eachDay) {
                for ($i = 0; $i < $numberOfDays; $i++) {
                    if ($Datta0[$i] == $eachDay) {
                        $Datta[$j] = $Datta0[$i];

                        $StartTime[$j] = $StartTime0[$i];
                        $EndTime[$j] = $EndTime0[$i];
                        $GameField[$j] = $GameField0[$i];
                        $j++;
                    }
                }
            }

            for ($i = 0; $i < $teamsNumber / 2; $i++) {
                $Home[$i] = $Teams[$i];
                $Away[$i] = $Teams[$teamsNumber - 1 - $i];
            }


            for ($i = 0; $i < $gamesCount; $i++) {
                if (($i % 2) == 0) {
                    for ($j = 0; $j < $teamsNumber / 2; $j++) {
                        $calendar[$i][] = [$Away[$j], $Home[$j]];
                    }
                } else {
                    for ($j = 0; $j < $teamsNumber / 2; $j++) {
                        $calendar[$i][] = [$Home[$j], $Away[$j]];
                    }
                }

                $pivot = $Home[0];
                array_unshift($Away, $Home[1]);
                $carryover = array_pop($Away);
                array_shift($Home);
                array_push($Home, $carryover);
                $Home[0] = $pivot;
            }//endfor

            $FinalCalendar = call_user_func_array("array_merge", $calendar);

            $day = (int)date('w', strtotime($todayDate));
            $day2 = 0;
            $startIndex = 10;

            while ($startIndex === false or $startIndex === 10) {
                if ($day == 0 and $startIndex !== false and $startIndex !== 0) {
                    $startIndex = array_search('Domingo', $Datta);

                } elseif ($day == 1 and $startIndex !== false and $startIndex !== 0) {
                    $startIndex = array_search('Segunda', $Datta);

                } elseif ($day == 2 and $startIndex !== false and $startIndex !== 0) {
                    $startIndex = array_search('Terca', $Datta);

                } elseif ($day == 3 and $startIndex !== false and $startIndex !== 0) {
                    $startIndex = array_search('Quarta', $Datta);

                } elseif ($day == 4 and $startIndex !== false and $startIndex !== 0) {
                    $startIndex = array_search('Quinta', $Datta);

                } elseif ($day == 5 and $startIndex !== false and $startIndex !== 0) {
                    $startIndex = array_search('Sexta', $Datta);


                } elseif ($day == 6 and $startIndex !== false and $startIndex !== 0) {
                    $startIndex = array_search('Sabado', $Datta);

                } else {
                    $startIndex = 10;
                    $day = ($day + 1) % 7;
                    $day2++;

                }
            }


            $Datta2 = $Datta;

            $replacements = array(
                'Domingo' => 1,
                'Segunda' => 2,
                'Terca' => 3,
                'Quarta' => 4,
                'Quinta' => 5,
                'Sexta' => 6,
                'Sabado' => 7
            );

            foreach ($Datta2 as $key => $value) {
                if (isset($replacements[$value])) {
                    $Datta2[$key] = $replacements[$value];
                }
            }

            $Datta3 = [];
            for ($i = 0; $i < $numberOfDays - 1; $i++) {
                $Datta3[$i] = $Datta2[$i + 1] - $Datta2[$i];
            }
            $Datta3[$i] = (7 - $Datta2[$i]) + $Datta2[0];



            $OuterCicle = $PossibleRounds;


            $FirstGameDate = date('Y-m-d', strtotime($todayDate . ' +' . $day2 . ' day'));
            $j = 0;
            $cicles = 0;
            $dateToInsert = $FirstGameDate;
            $LastInsertedDate = $FirstGameDate;
            $pp = 0;
            $ss = 0;
            //casa

            for ($a = 1; $a <= $OuterCicle; $a++) {

                if($a%2===1) {
                    $pp++;
                    echo '<br><b style="color: blue;">'.$pp.': Primeira mão:</b><br><br>';
                }elseif ($a%2===0){
                    $ss++;
                    echo '<br><br><br>';
                    echo '<b style="color: blue;">'.$ss.': Segunda mão:</b><br><br>';
                }

                foreach ($FinalCalendar as $ke) {

                    $index = $j + $startIndex < $numberOfDays ? $j + $startIndex : $j + $startIndex - $numberOfDays;

                    if(in_array($dateToInsert, $NoContesto)){
                        $trial = $dateToInsert;
                        $dateToInsert = date('Y-m-d', strtotime($trial . ' +' . $Datta3[$index] . ' day'));
                        $LastInsertedDate = $dateToInsert;
                        continue;
                    }

                    console_log("index: $index");
                    console_log($dateToInsert);


                    if($a%2===1) {
                        echo $ke[0] . " : " . $ke[1] . " ===> " . $Datta[$index];
                        echo '<br>';
                    }elseif ($a%2===0){
                        echo $ke[1] . " : " . $ke[0] . " ===> " . $Datta[$index];
                        echo '<br>';
                    }

                    if($a%2===1) {
                        $query = "INSERT INTO game(gamefield, weekday, gamedate, starttime, endtime, tournament_tournamentid, teamone, teamtwo) VALUES ('$GameField[$index]', '$Datta[$index]','$dateToInsert', $StartTime[$index], $EndTime[$index], $quicko, '$ke[0]', '$ke[1]')";
                        $resp = mysqli_query($db, $query);
                    }elseif ($a%2===0){
                        $query = "INSERT INTO game(gamefield, weekday, gamedate, starttime, endtime, tournament_tournamentid, teamone, teamtwo) VALUES ('$GameField[$index]', '$Datta[$index]','$dateToInsert', $StartTime[$index], $EndTime[$index], $quicko, '$ke[1]', '$ke[0]')";
                        $resp = mysqli_query($db, $query);
                    }
                    $j = ($j + 1) % $numberOfDays;
                    $cicles++;

                    $trial = $dateToInsert;
                    $dateToInsert = date('Y-m-d', strtotime($trial . ' +' . $Datta3[$index] . ' day'));
                    $LastInsertedDate = $dateToInsert;


                }
            }

            $query = "UPDATE tournament SET alreadystarted = '0' where tournamentid=$quicko";
            $resp = mysqli_query($db, $query);

            $FinalArray = call_user_func_array("array_merge", $FinalCalendar);

            echo '<br><br>';
            echo '<b style="color: blue;">Pool de equipas:</b><br>';
            echo implode(', ', $Teams);
            echo '<br><br>';
            echo '<b style="color: blue;">Dias com jogo:</b>';
            echo implode(', ', $Datta);

        }
    }


    if(isset($_POST['deletetudo'])){
        console_log("iojfiuwbviuwefhwpoaijfei");
        $query = "DELETE FROM game where tournament_tournamentid=$quicko";
        $resp = mysqli_query($db, $query);
        console_log($resp);
        $query = "UPDATE tournament SET alreadystarted = null where tournamentid=$quicko";
        $resp = mysqli_query($db, $query);
        echo '<b style="color: green">Dados apagados com sucesso, atualize agora a pagina da gestao de torneio</b>';
    }


?>

    <!DOCTYPE html>
    <html lang="pt">

    <!--Header -->
    <!--References all css and js usages-->

    <head>

    </head>

    <!--Body-->

    <body style="background-color: lightseagreen">

    </body>

    </html>

<?php


?>