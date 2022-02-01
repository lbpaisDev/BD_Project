<?php
include('../backEnd/credentialsCheck.php');

$cc=$_SESSION['cc'];

// verificar se o user tem equipa ou nao
$sql="SELECT user.username,user.name, player.position,player.teamname FROM user,player where user.cc=player.user_cc and user_cc=$cc";
$result1 = $conn->query($sql);
$row1=mysqli_fetch_assoc($result1);
// se tiver equipa
if(mysqli_num_rows($result1) > 0){
    header('Location: ../frontEnd/homeWTeam.php');
}
// se nao tiver equipa
else{
    header('Location: ../frontEnd/home.php');
}

?>