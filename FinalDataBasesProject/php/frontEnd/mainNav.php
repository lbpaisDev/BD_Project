<!-- BackEnd PhP-->
<?php include('../backEnd/credentialsCheck.php');
include('../backEnd/serverActions.php');
include('userAdminNotificationBack.php');
?>

<?php

$conn = OpenCon();


if (!isset($_SESSION['loggedin'])) {
    header('Location: userNL.php');
    exit();
}
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
    <link rel="stylesheet" href="../../css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/bootstrap/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../../css/fontAwesome.css">
    <link rel="stylesheet" href="../../css/lightbox.css">
    <link rel="stylesheet" href="../../css/userAdmin.css">
    <link rel="stylesheet" type="css" href="http://compass-style.org/reference/compass/css3/" />
    <link rel="stylesheet" href="../../css/userNLStyle.css">

    <!--Scripts-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
    <script src="../../js/libs/bootstrap.min.js"></script>
    <script src="../../js/userNL.js"></script>
    <script src="../../js/plugins.js"></script>
    <script src="../../js/main.js"></script>
    <script src="../../js/userAdmin.js"></script>

</head>

<!--Body-->

<body>
    <div class="header">
        <div class="container">
            <nav class="navbar navbar-inverse" role="navigation">
                <div class="navbar-header">
                    <button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse"
                        data-target="#main-nav"></button>
                    <div id="navbox">
                        <a href="mainNav.php" id="mainNav">
                            <em>FOOT</em>
                            <span>'R'</span>US</a>
                    </div>
                </div>

                <!--/Nav options-->
                <div id="main-nav" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <?php
                            if (array_key_exists('logOut', $_POST)) {
                                logOut();
                            }
                            ?>
                            <form id="logout" method="post">
                                <input type="submit" name="logOut" class="button" value="LOG OUT" />
                            </form>
                        </li>
                    </ul>
                </div>
                <!--/.navbar-collapse-->
            </nav>
            <!--/.navbar-->
        </div>
        <!--/.container-->
    </div>

    <div class="section">

        <img src="../../img/img_avatar.png" alt="Avatar" class="avatar">


        <div id="options">
            <h2><b>Navigation</b></h2>

            <div class="choicecontainer">

                <?php
                $cc_temp = $_SESSION['cc'];
                $result = $conn->query("SELECT * FROM user WHERE cc LIKE $cc_temp");

                $resultsCount = mysqli_num_rows($result);
                if ($resultsCount > 0) {

                    echo '
            <table id="msgTable">
                <tr>
                    <th style="display:none;">Buttom</th>
                </tr>';
                    $row = mysqli_fetch_assoc($result);
                    $isadmin = $row['isadmin'];
                    $ismanager = $row['ismanager'];
                    $iscaptain = $row['iscaptain'];

                    if ($isadmin == 1) {
                        echo ' <td><form action="userAdmin.php"><button href="userAdmin.php" class="button">Admin</button></form>';
                    }

                    if ($ismanager == 1) {
                        echo ' <td><form action="../../indexGestao.php"><button href="../../indexGestao.php" class="button">My Tournament</button></form>';
                    }
                    if ($iscaptain == 1) {
                        echo ' <td><form action="../../indexcapitan.php"><button href="../../indexcapitan.php" class="button">My Team</button></form>';
                    }

                    echo ' <td><form action="../backEnd/checkTeam.php"><button  class="button">Play!</button></form>';
                    echo '</tr>';
                    echo '</table>';
                }
                ?>
            </div>
        </div>

    </div>
    <!--Footer-->
    <footer>
        <div class="container ">
            <div class="row ">
                <div class="col-md-4 col-sm-12 ">
                    <div class="logo ">
                        <a class="logo-ft scroll-top " href="# ">
                            <em>FOOT</em>'R'US</a>
                        <p>Copyright &copy; 2019 @lbpaisDev
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 "></div>
                <div class="col-md-2 col-sm-12 "></div>
                <div class="col-md-2 col-sm-12 ">
                    <div class="connect-us ">
                        <h4>Get Social with us</h4>
                        <ul>
                            <li>
                                <a href="# ">
                                    <i class="fa fa-twitter "></i>
                                </a>
                            </li>
                            <li>
                                <a href="# ">
                                    <i class="fa fa-facebook "></i>
                                </a>
                            </li>
                            <li>
                                <a href="# ">
                                    <i class="fa fa-google "></i>
                                </a>
                            </li>
                            <li>
                                <a href="# ">
                                    <i class="fa fa-rss "></i>
                                </a>
                            </li>
                            <li>
                                <a href="# ">
                                    <i class="fa fa-dribbble "></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>