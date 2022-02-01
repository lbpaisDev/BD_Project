<?php
session_start();

// initializing local variables
$username = "";
$email    = "";
$CC       = "";
$password = "";
$passwordRepeat = "";
$name     = "";
$surName  = "";
$phoneNumber = "";

//Establish connection
include('dbConnect.php');
$conn = OpenCon();

function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}


if ($conn->connect_errno != 0) {
    throw new Exception(mysqli_connect_errno());
}


//Server-side checks
if (isset($_POST['email'])) {
    //validation flag
    $flagEverythingOk = true;

    //check username
    $username = $_POST['userName'];
    //length of login
    if ((strlen($username) < 4) || (strlen($username) > 20)) {
        $flagEverythingOk = false;
        $_SESSION['e_login'] = "Login under 4 or over 20 characters!";
    }
    if (ctype_alnum($username) == false) {
        $flagEverythingOk = false;
        $_SESSION['e_login'] = "Login has to consist of only letters and numbers!";
    }

    //check email
    $email = $_POST['email'];
    $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
    if ((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email)) {
        $flagEverythingOk = false;
        $_SESSION['e_email'] = "Incorrect email address!";
    }

    //check CC
    $CC = $_POST['CC'];
    //length of CC
    if ((strlen($CC) != 7)) {
        $flagEverythingOk = false;
        $_SESSION['e_cc'] = "CC must be seven digits!";
    }
    if (is_numeric($CC) == false) {
        $flagEverythingOk = false;
        $_SESSION['e_cc'] = "CC has to consist of only numbers!";
    }

    //check password
    $password = $_POST['password'];
    $passwordRepeat = $_POST['passwordRepeat'];
    if ((strlen($password) < 4) || (strlen($password) > 20)) {
        $flagEverythingOk = false;
        $_SESSION['e_password'] = "Password under 4 or ovser 20 characters!";
    }
    if ($password != $passwordRepeat) {
        $flagEverythingOk = false;
        $_SESSION['e_pass'] = "Passwords are different!";
    }
    //$passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $passwordHash = $password;

    //check name
    $name = $_POST['name'];
    if ((strlen($name) < 1)) {
        $flagEverythingOk = false;
        $_SESSION['e_name'] = "Name field cannot be empty!";
    }

    //check surname
    $surName = $_POST['surName'];
    if ((strlen($surName) < 1)) {
        $flagEverythingOk = false;
        $_SESSION['e_surname'] = "Surname field cannot be empty!";
    }

    //check Phonenumber
    $phoneNumber = $_POST['phoneNumber'];
    //length of Phonenumber
    if ((strlen($phoneNumber) != 9)) {
        //$flagEverythingOk = false;
        $_SESSION['e_phonenumber'] = "Phone number must be nine digits!";
    }
    if (is_numeric($phoneNumber) == false) {
        //$flagEverythingOk = false;
        $_SESSION['e_phonenumber'] = "Phone number has to consist of only numbers!";
    }

    //check if terms accepted
    if (!isset($_POST['terms'])) {
        //$flagEverythingOk = false;
        $_SESSION['e_terms'] = "You have to accept terms and conditions!";
    }

    //check if email exists
    $query = "SELECT email FROM user WHERE email LIKE '$email'";
    $result = $conn->query($query);
    $count_emails = $result->num_rows;
    if ($count_emails > 0) {
        $flagEverythingOk = false;
        $_SESSION['e_email'] = "Account with this email already exists!";
    }

    //check if login taken 
    $query = "SELECT username FROM user WHERE username LIKE '$username'";
    $result = $conn->query($query);
    $count_logins = $result->num_rows;
    if ($count_logins > 0) {
        $flagEverythingOk = false;
        $_SESSION['e_login'] = "Login already exists. Pick another one!";
    }

    //If every field is ok
    if ($flagEverythingOk == true) {
        $CC_num = (int) $CC;
        $phoneNumber_num = (int) $phoneNumber;
        $query = "INSERT INTO user VALUES('$CC_num','$username','$password',CONCAT('$name ','$surName'),'$phoneNumber_num','$email',now(),0,0,0,1, DEFAULT)";

        if ($conn->query($query)) {
            $_SESSION['registration_success'] = true;
            $_SESSION['loggedin'] = true;
            $_SESSION['cc'] = $CC_num;
            header('Location: ../frontEnd/mainNav.php');
        } else {
            throw new Exception($conn->error);
        }
    }
}

if (isset($_POST['loginUser'])) {
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    $query = "SELECT * FROM user WHERE username LIKE '$login' AND password LIKE '$pass'";
    $result = $conn->query($query);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['loggedin'] = true;
        $_SESSION['cc'] = $row['cc'];
        header('Location: ../frontEnd/mainNav.php');
    }
}