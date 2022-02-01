<!-- BackEnd PhP-->
<?php 

include('../backEnd/credentialsCheck.php');

// session_start();

// $servername = "127.0.0.1";
// $username = "root";
// $password = "";
// $dbname = "bd_project";

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);
// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
?>

<!DOCTYPE html>
<html>

<!-- Header -->
<!-- References all css and js usages -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>FOOTBALLERS'R'US</title>
    <meta name="description" content="">

    <!-- View Port - reactive -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Page Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">

    <!-- Styling -->
    <link rel="stylesheet" href="../../css/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="../../css/bootstrap/bootstrap-theme.css">
    <link rel="stylesheet" href="../../css/userNLStyle.css">

    <!--Scripts-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="../../js/userNL.js"></script>

</head>

<!--Body-->

<body>

    <!--/Navigation Bar-->
    <div class="header">
        <div class="container">
            <nav class="navbar navbar-inverse" role="navigation">
                <div class="navbar-header">
                    <button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse"
                        data-target="#main-nav"></button>
                    <div id="navbox" style="margin-top: 20px">
                        <a href="mainNav.php" style="color: #FFF; text-decoration: none;font-weight: 600;font-size: 20px;letter-spacing: 0.5px;">
                            <em style="font-weight: 600;color: black;">FOOT</em>
                            <span>'R'</span>US</a>
                    </div>
                </div>

                <!--/Nav options-->
                <div id="main-nav" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <!-- <a href="#" class="scroll-top"><b>Jogar Já</b></a> -->
                            <a href="../backEnd/checkTeam.php"><b>Home</b></a>
                        </li>
                        <li>
                            <!-- <a href="#" class="scroll-link" data-id="about"><b>Torneios</b></a> -->
                            <a href="./torneios.php" data-id="about"><b>Torneios</b></a>
                        </li>
                        <li>
                            <!-- <a href="#" class="scroll-link" data-id="reglog"><b>Jogadores</b></a> -->
                            <a href="#" data-id="reglog"><b>Jogadores</b></a>
                        </li>
                        <li>
                            <!-- <a href="#" class="scroll-link" data-id="contact-us"><b>Perfil</b></a> -->
                            <a href="./editPerfil.php" data-id="contact-us"><b>Perfil</b></a>
                        </li>
                        <li>
                            <!-- <a href="#" class="scroll-link" data-id="contact-us"><b>Saldo</b></a> -->
                            <a href="./userNL.php" data-id="contact-us"><b>Logout</b></a>
                        </li>
                    </ul>
                </div>
                <!--/.navbar-collapse-->
            </nav>
            <!--/.navbar-->
        </div>
        <!--/.container-->
    </div>
    <!--/.header-->

    <!--/Home Page-->
    <div class="parallax-content baner-content" id="home"> 
        <div class="container">
            <!-- <div class="col-lg-4">
            <p>So teste </p>
            </div> -->

            
            <div>
                <div class="text-content">
                    <h2>
                        <em>Informação dos Jogadores</em>
                    </h2> 
                    <br>
                    <table class="table">
                        <tr>
                            <th>UserName</th>
                            <th>Nome</th>
                            <!--<th>Apelido</th>-->
                            <!-- <th>Torneio</th>
                            <th>Equipa</th> -->
                            <th>Email</th>
                            <th>Contacto</th>
                        </tr>
                        <?php
                            $sql = "SELECT username, email, contact,name FROM `user` ORDER BY 1";
                            $result = mysqli_query($conn, $sql);
                            
                            if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>".$row["username"]."</td>"."<td>".$row["name"]."</td>"."</td>" ."<td>".$row["email"]."</td>"."<td>".$row["contact"]."</td>";
                                    echo "</tr>";
                                }
                            }
                        ?>
                    </table>

                    <!-- <table class="table">
                        <tr>
                            <th>Jogadores</th>
                        </tr>    
                        <tr>
                            <td>UserTeste1</td>
                            
                        </tr>
                        <tr>
                            <td>UserTeste2</td>
                        </tr> 
                        <tr>
                            <td>UserTeste3</td>
                        </tr>   
                    </table> -->
                </div>
            </div>
        </div>
    </div>

    <!--/About Us-->

    <!--/Register/Login-->

    <!--Contact Us-->
    

    <!--Footer-->
</body>

</html>