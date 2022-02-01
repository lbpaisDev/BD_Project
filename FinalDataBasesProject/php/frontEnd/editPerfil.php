<!-- BackEnd PhP-->
<?php 

include('../backEnd/credentialsCheck.php');

// session_start();

$sql = "SELECT username,name, email, contact, password FROM `user` where cc=$_SESSION[cc]";
$result = mysqli_query($conn, $sql);
$user=mysqli_fetch_assoc($result);

// Dar Save
if(isset($_POST['enome'])){
    // echo "Username=".$_POST['eusername'];
    $flagEverythingOk = true;
    $nome=$_POST["enome"];
    // $apelido=$_POST["eapelido"];
    $email=$_POST["eemail"];
    $contacto=$_POST["econtacto"];
    $pass=$_POST["epass"];
    $repass=$_POST["erepass"];

    //verificacoes username
    // if ((strlen($nome) < 4) || (strlen($nome) > 20)) {
    //     $flagEverythingOk = false;
    //     $_SESSION['e_login'] = "Login under 4 or over 20 characters!";
    //     echo "<script> alert('Login under 4 or over 20 characters!'); </script>";
    // }
    // else if (ctype_alnum($nome) == false) {
    //     $flagEverythingOk = false;
    //     $_SESSION['e_login'] = "Login has to consist of only letters and numbers!";
    //     echo "<script> alert('Login has to consist of only letters and numbers!'); </script>";
    // }
    
    //verificacoes nome
    if ((strlen($nome) < 1)) {
        $flagEverythingOk = false;
        $_SESSION['e_name'] = "Name field cannot be empty!";
        echo "<script> alert('Name field cannot be empty!'); </script>";
    }

    //verificacoes apelido
    // if ((strlen($apelido) < 1)) {
    //     $flagEverythingOk = false;
    //     $_SESSION['e_surname'] = "Surname field cannot be empty!";
    //     echo "<script> alert('Surname field cannot be empty!'); </script>";
    // }

    //verificacoes contacto
    if ((strlen($contacto) != 9)) {
        $flagEverythingOk = false;
        $_SESSION['e_phonenumber'] = "Phone number must be nine digits!";
        echo "<script> alert('Phone number must be nine digits!'); </script>";
    }
    if (is_numeric($contacto) == false) {
        $flagEverythingOk = false;
        $_SESSION['e_phonenumber'] = "Phone number has to consist of only numbers!";
        echo "<script> alert('Phone number has to consist of only numbers!'); </script>";
    }

    //verificacoes email
    $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
    if ((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email)) {
        $flagEverythingOk = false;
        $_SESSION['e_email'] = "Incorrect email address!";
        echo "<script> alert('Incorrect email address!'); </script>";
    }
    $query2 = "SELECT email FROM user WHERE email LIKE '$email'";
    $result = $conn->query($query2);
    $count_emails = $result->num_rows;
    if ($count_emails > 1) {
        $flagEverythingOk = false;
        $_SESSION['e_email'] = "Account with this email already exists!";
        echo "<script> alert('Account with this email already exists!'); </script>";
    }

    //verificacoes password
    if ((strlen($pass) < 4) || (strlen($pass) > 20)) {
        $flagEverythingOk = false;
        $_SESSION['e_password'] = "Password under 4 or over 20 characters!";
        echo "<script> alert('Password under 4 or over 20 characters!'); </script>";
    }
    if ($pass != $repass) {
        $flagEverythingOk = false;
        $_SESSION['e_pass'] = "Passwords are different!";
        echo "<script> alert('Passwords are different!'); </script>";
    }

    // submit para DataBase
    if($flagEverythingOk==true){
        // $query = "UPDATE user set first_name='$nome',last_name='$apelido', contact='$contacto',email='$email',password='$pass' where cc=$_SESSION[cc]";
        $query = "UPDATE user set name='$nome', contact='$contacto',email='$email',password='$pass' where cc=$_SESSION[cc]";
        if ($conn->query($query)) {
            $_SESSION['registration_success'] = true;
            $_SESSION['loggedin'] = true;
            header('Location: ../frontEnd/home.php');
        } else {
            throw new Exception($conn->error);
        }
    }
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
                            <a href="./jogadores.php" data-id="reglog"><b>Jogadores</b></a>
                        </li>
                        <li>
                            <!-- <a href="#" class="scroll-link" data-id="contact-us"><b>Perfil</b></a> -->
                            <a href="#" data-id="contact-us"><b>Perfil</b></a>
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
    <div class="parallax-content baner-content" id="home" style="position:relative; bottom:100px;">
        <div class="container">

            <div class="col-lg-4">
                <!-- <div class="row"> 
                    <div class="text-content">
                        
                        <img src="../../css/img/user.png" alt="User Photo" height="200" width="200">
                        
                    </div>
                    <br>
                    <div class="text-content" style="margin-left: 38%">
                        <button class="button"> Alterar Foto </button>
                    </div>
                </div> -->
            </div>

            <div class="col-lg-5">
                <div class="text-content">
                    <h2>
                        <em>Editar Perfil</em>
                    </h2>
                    <br>
                    <form action="editPerfil.php" method="post">
                    Nome: <input name="enome" type="text" <?php echo "value=".$user["name"]?>> <br>
                    Email: <input name="eemail" type="email" <?php echo "value=".$user["email"]?>> <br>
                    Contacto: <input name="econtacto" type="text" <?php echo "value=".$user["contact"]?>> <br>
                    Password: <input name="epass" type="password" <?php echo "value=".$user["password"]?>> <br>
                    Confirmar Password: <input name="erepass" type="password" <?php echo "value=".$user["password"]?>> <br>
                    <input class="button" type="submit" value ="Salvar">
                    </form>
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