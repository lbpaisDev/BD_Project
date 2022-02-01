<!-- BackEnd PhP-->
<?php

    require_once 'connect.php';
    $db = OpenCon();
    $cc='';
    if (!empty($_GET['cc'])){
        $cc = $_GET['cc'];
    }
    if (empty($_GET['cc'])){
        throw new Exception("ID is Blank");
    }

        $sql = "SELECT name FROM user  where cc ='".$cc."'";
        $resp = $db->query($sql);
        $row=mysqli_fetch_assoc($resp);
        $name = $row['name'];

    ?>

<!DOCTYPE html>
<html>

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
    <link rel="stylesheet" href="css/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap/bootstrap-theme.css">
    <link rel="stylesheet" href="css/userNLStyle.css">

    <!--Scripts-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/userNL.js"></script>

</head>


<!--Body-->

<body>
<br><br><br>
<h2 class="text-center">Adicionar Saldo</h2>
<h2 class="text-center">ao user</h2>
<h2 class="text-center"><?php echo $name?></h2>
<br><br>
<form method="post" id = "data" >
    <input type="number"name = "saldo" class="form-control"  step=".1" value="0" style="width: 4%; margin: 0 auto; text-align: center;"/>
    <br>
    <button name = "adiciona" class="button" style="position:relative; left:51%; top: 12px;"><b>Adicionar</b>
    </button> <button name = "back"class="button" style="position:relative; left:43%; top: -29px;"><b>Voltar</b></button>
</form>
</body>
</html>

<?php
    if(isset($_POST['adiciona'])){
        $data = $_POST['saldo'];
        $sql = "UPDATE player SET balance = balance + '".$data."' where user_cc = '".$cc."'";
        $resp = $db->query($sql);
        header("Location: capitan_gestao.php");
    }
if(isset($_POST['back'])){
    header("Location: capitan_gestao.php");
}
?>