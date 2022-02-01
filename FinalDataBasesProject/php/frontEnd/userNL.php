<!-- BackEnd PhP-->
<?php include('../backEnd/credentialsCheck.php') ?>
<?php
$conn = OpenCon();
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
    <link rel="stylesheet" type="css" href="http://compass-style.org/reference/compass/css3/" />
    <link rel="stylesheet" href="../../css/userNLStyle.css">

    <!--Scripts-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
    <script src="../../js/libs/bootstrap.min.js"></script>
    <script src="../../js/userNL.js"></script>
    <script src="../../js/plugins.js"></script>
    <script src="../../js/main.js"></script>


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
                    <a href="#" class="navbar-brand scroll-top">
                        <em id="headerban">FOOT</em>
                        <span>'R'</span>US</a>
                </div>

                <!--/Nav options-->
                <div id="main-nav" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="#" class="scroll-top">Home</a>
                        </li>
                        <li>
                            <a href="#" class="scroll-link" data-id="about">About Us</a>
                        </li>
                        <li>
                            <a href="#" class="scroll-link" data-id="reglog">Join Us</a>
                        </li>
                        <li>
                            <a href="#" class="scroll-link" data-id="contact-us">Contact Us</a>
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
            <div class="text-content">
                <h2>
                    <em>FOOTBALLERS</em>
                    <span>'R'</span>
                    US
                </h2>
                <p>Playing amateur football has never been so easy. Register now, to join a team or create one of
                    your
                    own and lead them to victory. For a small fee you are going to able to play in various
                    tournaments
                    across Coimbra!</p>
                <div class="primary-white-button">
                    <a href="#" class="scroll-link" data-id="reglog">Let's Get Started</a>
                </div>
            </div>
        </div>
    </div>

    <!--/About Us-->
    <section id="about" class="page-section">
        <div class="container">

            <!-- 2 by 2 -->
            <div class="row">

                <!--ULC-->
                <div class="col-md-3 col-sm-6 col-xs-12">

                    <div class="service-item">
                        <div class="icon">
                            <img src="../../img/service_icon_01.png" alt="">
                        </div>
                        <h4>The Idea</h4>
                        <div class="line-dec"></div>
                        <p>We're a group of students in Computer Science of the University of Coimbra, that under
                            the
                            data bases class are developing a matchmaking website for people looking to play amateur
                            football.
                        </p>
                    </div>
                </div>

                <!--URC-->
                <div class="col-md-3 col-sm-6 col-xs-12">

                    <div class="service-item">
                        <div class="icon">
                            <img src="../../img/service_icon_02.png" alt="">
                        </div>
                        <h4>Statistics</h4>
                        <div class="line-dec"></div>
                        <?php $sql = "SELECT * FROM user";
                        $result = $conn->query($sql);
                        if (mysqli_num_rows($result)) {
                            $countReg = mysqli_num_rows($result);
                        } else {
                            $countReg = 0;
                        }
                        $sql = "SELECT * FROM user WHERE isLoggedIn = true";
                        $result = $conn->query($sql);
                        if (mysqli_num_rows($result)) {
                            $countLog = mysqli_num_rows($result);
                        } else {
                            $countLog = 0;
                        }
                        $sql = "SELECT * FROM tournament";
                        $result = $conn->query($sql);
                        if (mysqli_num_rows($result)) {
                            $countTours = mysqli_num_rows($result);
                        } else {
                            $countTours = 0;
                        }
                        $sql = "SELECT * FROM captain_team";
                        $result = $conn->query($sql);
                        if (mysqli_num_rows($result)) {
                            $countTeams = mysqli_num_rows($result);
                        } else {
                            $countTeams = 0;
                        }
                        echo  '<p> Registered Users: ' . $countReg . '<br> Currently Online: ' . $countLog . '<br>' . 'Ongoing Tournaments: ' . $countTours . '<br>' . 'Teams: ' . $countTours . '</p>';
                        ?>
                    </div>
                </div>

                <!-- BLC-->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="service-item">
                        <div class="icon">
                            <img src="../../img/service_icon_03.png" alt="">
                        </div>
                        <h4>Legal Warning</h4>
                        <div class="line-dec"></div>
                        <p>Os conteúdos constantes website foram realizados por alunos no âmbito de uma disciplina–
                            Bases de Dados - do 3º ano da licenciatura de Engenharia Informática da Faculdade de
                            Ciências e Tecnologia da Universidade de Coimbra (FCTUC), pelo que a FCTUC não se
                            responsabiliza pelo seu conteúdo.</p>
                    </div>
                </div>

                <!--BRC-->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="service-item">
                        <div class="icon">
                            <img src="../../img/service_icon_04.png" alt="">
                        </div>
                        <h4>Developers</h4>
                        <div class="line-dec"></div>
                        <p>Leandro Pais &ensp;&ensp;&ensp;&ensp;&ensp; Bruno Ferreira</p>
                        <p>Guilherme Costa &ensp;&ensp;&ensp;&ensp;&ensp; Sérgio Machado</p>
                        <div class="primary-blue-button"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--/Register/Login-->
    <div class="container" id="reglog">
        <div class="flat-form">

            <!-- Tabs -->
            <ul class="tabs">
                <li>
                    <a href="#login" class="active">Login</a>
                </li>
                <li>
                    <a href="#register">Register</a>
                </li>
            </ul>

            <!--/#login.form-action-->
            <div id="login" class="form-action show">
                <h1>Log In</h1>
                <p>
                    Insert your email e password to log into the app!
                </p>
                <form action="userNL.php" method="post">
                    <ul>
                        <li>
                            <input type="text" placeholder="Username" name="login">
                        </li>
                        <li>
                            <input type="password" placeholder="Password" name="pass">
                        </li>
                        <li>
                            <input type="submit" value="Login" class="button" name="loginUser">
                        </li>
                    </ul>
                </form>
            </div>

            <!--/#register.form-action-->
            <div id="register" class="form-action hide">
                <h1>Register</h1>
                <form method="post" action="userNL.php">
                    <ul>
                        <li>
                            <input type="text" placeholder="Username" name="userName">
                            <?php
                            if (isset($_SESSION['e_login'])) {
                                echo '<div class="error">' . $_SESSION['e_login'] . '</div>';
                                unset($_SESSION['e_login']);
                            }
                            ?>
                        </li>
                        <li>
                            <input type="text" placeholder="Email" name="email">
                            <?php
                            if (isset($_SESSION['e_email'])) {
                                echo '<div class="error">' . $_SESSION['e_email'] . '</div>';
                                unset($_SESSION['e_email']);
                            }
                            ?>
                        </li>
                        <li>
                            <input type="text" placeholder="CC" name="CC">
                            <?php
                            if (isset($_SESSION['e_cc'])) {
                                echo '<div class="error">' . $_SESSION['e_cc'] . '</div>';
                                unset($_SESSION['e_cc']);
                            }
                            ?>
                        </li>
                        <li>
                            <input type="password" placeholder="Password" name="password">
                            <?php
                            if (isset($_SESSION['e_password'])) {
                                echo '<div class="error">' . $_SESSION['e_password'] . '</div>';
                                unset($_SESSION['e_password']);
                            }
                            ?>
                        </li>
                        <li>
                            <input type="password" placeholder="Repeat Password" name="passwordRepeat">
                            <?php
                            if (isset($_SESSION['e_pass'])) {
                                echo '<div class="error">' . $_SESSION['e_pass'] . '</div>';
                                unset($_SESSION['e_pass']);
                            }
                            ?>
                        </li>
                        <li>
                            <input type="text" placeholder="Name" name="name">
                            <?php
                            if (isset($_SESSION['e_name'])) {
                                echo '<div class="error">' . $_SESSION['e_name'] . '</div>';
                                unset($_SESSION['e_name']);
                            }
                            ?>
                        </li>
                        <li>
                            <input type="text" placeholder="Surname" name="surName">
                            <?php
                            if (isset($_SESSION['e_surname'])) {
                                echo '<div class="error">' . $_SESSION['e_surname'] . '</div>';
                                unset($_SESSION['e_surname']);
                            }
                            ?>
                        </li>
                        <li>
                            <input type="text" placeholder="Phone Number" name="phoneNumber">
                            <?php
                            if (isset($_SESSION['e_phoneNumber'])) {
                                echo '<div class="error">' . $_SESSION['e_phoneNumber'] . '</div>';
                                unset($_SESSION['e_phoneNumber']);
                            }
                            ?>
                        </li>

                        <li>
                            <input type="checkbox" name="terms" /> I accept <a href="terms_and_conditions.txt"> terms
                                and conditions </a> of platform<br />
                            <?php
                            if (isset($_SESSION['e_terms'])) {
                                echo '<div class="error">' . $_SESSION['terms'] . '</div>';
                                unset($_SESSION['terms']);
                            }
                            ?>
                        </li>
                        <input type="submit" value="Sign Up" class="button">
                    </ul>
                </form>
            </div>
        </div>
    </div>

    <!--Contact Us-->
    <div id="contact-us">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <em>Contact Us</em>
                        <div class="line-dec"></div>
                        <p>Do you have any doubts or a problem? We can be reached using the button below!</p>
                        <div class="pop-button">
                            <h4>Send us a message</h4>
                        </div>
                    </div>
                </div>
            </div>
            <!--Message Form-->
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="pop">
                        <span>✖</span>
                        <form id="contact" action="#" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset>
                                        <input name="name" type="text" class="form-control" id="name"
                                            placeholder="Your name..." required="required">
                                    </fieldset>
                                </div>
                                <div class="col-md-12">
                                    <fieldset>
                                        <input name="email" type="email" class="form-control" id="email"
                                            placeholder="Your email..." required="required">
                                    </fieldset>
                                </div>
                                <div class="col-md-12">
                                    <fieldset>
                                        <textarea name="message" rows="6" class="form-control" id="message"
                                            placeholder="Your message..." required="required"></textarea>
                                    </fieldset>
                                </div>
                                <div class="col-md-12">
                                    <fieldset>
                                        <button type="submit" id="form-submit" class="btn">Send Message</button>
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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