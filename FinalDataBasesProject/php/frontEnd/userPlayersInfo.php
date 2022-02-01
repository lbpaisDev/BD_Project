<!-- BackEnd PhP-->
<?php

include('../backEnd/credentialsCheck.php');
include('../backEnd/serverActions.php');
include('userPlayersInfoBack.php');
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
                            <a href="userAdmin.php">Home</a>
                        </li>
                        <li>
                            <a href="userTournamentsInfo.php">Tournaments</a>
                        </li>
                        <li>
                            <a href="userPlayersInfo.php">Players</a>
                        </li>
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
        <a href="userAdminNotification.php" class="notification">
            <span>Notifications</span>
            <?php
            $sql = "SELECT * FROM notifications WHERE isvisible=1";
            $result = $conn->query($sql);
            if (mysqli_num_rows($result)) {
                $countNots = mysqli_num_rows($result);
            } else {
                $countNots = 0;
            }
            if ($countNots > 0) {
                echo '<span class="badge">' . $countNots . '</span>';
            }
            ?>
        </a>

        <div class="supracontainer">
            <div class="innercontainer">
                <h2><b>Users</b></h2>
            </div>
            <div class="anotherinnercontainer">
                <form class="searchBox" action="userPlayersInfo.php" method="post">
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
        <div class="tablediv"></div>
        <?php

        if (isset($_POST['search'])) {
            $search = $_POST['search'];
            if ($search != "") {
                $result = $conn->query("SELECT * FROM user WHERE isvisible=1 AND ( cc LIKE '%$search%' OR name LIKE '%$search%' OR email LIKE '%$search%')");
                $resultsCount = mysqli_num_rows($result);
                if ($resultsCount > 0) {
                    echo '
            <table id="msgTable">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>CC</th>
                    <th>Contact</th>
                </tr>';
                    for ($i = 1; $i <= $resultsCount; $i++) {
                        $row = mysqli_fetch_assoc($result);
                        $name = $row['name'];
                        $email = $row['email'];
                        $cc = $row['cc'];
                        $contact = $row['contact'];
                        $ismanager = $row['ismanager'];
                        $iscaptain = $row['iscaptain'];
                        echo '<tr>
                                <td>' . $name . '</td>
                                <td>' . $email . '</td>
                                <td>' . $cc . '</td>
                                <td>' . $contact
                            . '</td>
                                <td><form method="post" action="userPlayersInfo.php"><button type="submit" name="delete" value=' . "$cc" . ' class="button">DELETE</button></form>
                                </td>';
                        if ($ismanager == 1) {
                            echo ' <td><form method="post" action="userPlayersInfo.php"><button type="submit" name="removeMan" value='
                                . "$cc" . ' class="button">REMOVE MANAGER</button></form>';
                        } else {
                            echo ' <td><form method="post" action="userPlayersInfo.php"><button type="submit" name="allowMan" value='
                                . "$cc" . ' class="button">ALLOW MANAGER</button></form>';
                        }
                        if ($iscaptain == 1) {
                            echo ' <td><form method="post" action="userPlayersInfo.php"><button type="submit" name="removeCap" value='
                                . "$cc" . ' class="button">REMOVE CAPTAIN</button></form>';
                        }
                        echo '</tr>';
                    }
                    echo '</table>';
                }
            } else {

                $result = $conn->query("SELECT * FROM user WHERE isVisible=1");
                $resultsCount = mysqli_num_rows($result);
                if ($resultsCount > 0) {
                    echo '
                    <table id="msgTable">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>CC</th>
                            <th>Contact</th>
                        </tr>';
                    for ($i = 1; $i <= $resultsCount; $i++) {
                        $row = mysqli_fetch_assoc($result);
                        $name = $row['name'];
                        $email = $row['email'];
                        $cc = $row['cc'];
                        $contact = $row['contact'];
                        $ismanager = $row['ismanager'];
                        $iscaptain = $row['iscaptain'];
                        echo '<tr>
                                <td>' . $name . '</td>
                                <td>' . $email . '</td>
                                <td>' . $cc . '</td>
                                <td>' . $contact
                            . '</td>
                                <td><form method="post" action="userPlayersInfo.php"><button type="submit" name="delete" value=' . "$cc" . ' class="button">DELETE</button></form>
                                </td>';
                        if ($ismanager == 1) {
                            echo ' <td><form method="post" action="userPlayersInfo.php"><button type="submit" name="removeMan" value='
                                . "$cc" . ' class="button">REMOVE MANAGER</button></form>';
                        } else {
                            echo ' <td><form method="post" action="userPlayersInfo.php"><button type="submit" name="allowMan" value='
                                . "$cc" . ' class="button">ALLOW MANAGER</button></form>';
                        }
                        if ($iscaptain == 1) {
                            echo ' <td><form method="post" action="userPlayersInfo.php"><button type="submit" name="removeCap" value='
                                . "$cc" . ' class="button">REMOVE CAPTAIN</button></form>';
                        }
                        echo '</tr>';
                    }
                    echo '</table>';
                } else {
                    echo '<div id=nresponse>No players found...</div>';
                }
            }
        } else {
            $result = $conn->query("SELECT * FROM user WHERE isVisible=1");
            $resultsCount = mysqli_num_rows($result);
            if ($resultsCount > 0) {
                echo '
                    <table id="msgTable">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>CC</th>
                            <th>Contact</th>
                        </tr>';
                for ($i = 1; $i <= $resultsCount; $i++) {
                    $row = mysqli_fetch_assoc($result);
                    $name = $row['name'];
                    $email = $row['email'];
                    $cc = $row['cc'];
                    $contact = $row['contact'];
                    $ismanager = $row['ismanager'];
                    $iscaptain = $row['iscaptain'];
                    echo '<tr>
                                <td>' . $name . '</td>
                                <td>' . $email . '</td>
                                <td>' . $cc . '</td>
                                <td>' . $contact
                        . '</td>
                                <td><form method="post" action="userPlayersInfo.php"><button type="submit" name="delete" value=' . "$cc" . ' class="button">DELETE</button></form>
                                </td>';
                    if ($ismanager == 1) {
                        echo ' <td><form method="post" action="userPlayersInfo.php"><button type="submit" name="removeMan" value='
                            . "$cc" . ' class="button">REMOVE MANAGER</button></form>';
                    } else {
                        echo ' <td><form method="post" action="userPlayersInfo.php"><button type="submit" name="allowMan" value='
                            . "$cc" . ' class="button">ALLOW MANAGER</button></form>';
                    }
                    if ($iscaptain == 1) {
                        echo ' <td><form method="post" action="userPlayersInfo.php"><button type="submit" name="removeCap" value='
                            . "$cc" . ' class="button">REMOVE CAPTAIN</button></form>';
                    }
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<div id=nresponse>No players found...</div>';
            }
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