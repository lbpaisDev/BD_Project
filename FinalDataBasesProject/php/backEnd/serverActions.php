<?php


//Input check for all types of possible input
function inputCheck($input, $inputRepeat = "", $warning, $type = "")
{
    switch (gettype($input)) {

            //General string (could be username, email, etc)
        case "string":
            switch ($type) {

                    //Input conditions for username
                case "username":
                    if ((strlen($input) < 4) || (strlen($input) > 20)) {
                        $_SESSION[$warning] = "Input length must be over 4 and under 20 characters";
                        return false;
                    }
                    if (ctype_alnum($input) == false) {
                        $_SESSION[$warning] = "Input must consist of letters and numbers";
                        return  false;
                    }
                    break;

                    //Input conditions for password
                case "password":
                    if ((strlen($input) < 4) || (strlen($input) > 20)) {
                        $_SESSION[$input] = "Password must be over 4 and under 20 characters!";
                        return false;
                    }
                    if ($input != $inputRepeat) {
                        $_SESSION[$warning] = "Passwords are different!";
                        return false;
                    }
                    break;

                    //Check if email is valid
                case "email":
                    $email = $_POST['email'];
                    $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
                    if ((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email)) {
                        $_SESSION[$warning] = "Incorrect email address!";
                        return false;
                    }
                    break;

                    //Check if CC is valid
                case "CC":
                    function getNumberFromChar($letter)
                    {
                        switch ($letter) {
                            case '0':
                                return 0;
                            case '1':
                                return 1;
                            case '2':
                                return 2;
                            case '3':
                                return 3;
                            case '4':
                                return 4;
                            case '5':
                                return 5;
                            case '6':
                                return 6;
                            case '7':
                                return 7;
                            case '8':
                                return 8;
                            case '9':
                                return 9;
                            case 'A':
                                return 10;
                            case 'B':
                                return 11;
                            case 'C':
                                return 12;
                            case 'D':
                                return 13;
                            case 'E':
                                return 14;
                            case 'F':
                                return 15;
                            case 'G':
                                return 16;
                            case 'H':
                                return 17;
                            case 'I':
                                return 18;
                            case 'J':
                                return 19;
                            case 'K':
                                return 20;
                            case 'L':
                                return 21;
                            case 'M':
                                return 22;
                            case 'N':
                                return 23;
                            case 'O':
                                return 24;
                            case 'P':
                                return 25;
                            case 'Q':
                                return 26;
                            case 'R':
                                return 27;
                            case 'S':
                                return 28;
                            case 'T':
                                return 29;
                            case 'U':
                                return 30;
                            case 'V':
                                return 31;
                            case 'W':
                                return 32;
                            case 'X':
                                return 33;
                            case 'Y':
                                return 34;
                            case 'Z':
                                return 35;
                        }
                    }


                    $input = strtoupper($input);
                    $sum = 0;
                    $secondDigit = false;
                    if (strlen($input) != 12) {
                        $_SESSION[$warning] = "CC must be 12 digits";
                        return false;
                    }


                    for ($i = strlen($input) - 1; $i >= 0; --$i) {
                        $value = $this->getNumberFromChar($input[$i]);
                        if ($secondDigit) {
                            $value = $value * 2;
                            if ($value > 9)
                                $value = $value - 9;
                        }
                        $sum = $sum + $value;
                        $secondDigit = !$secondDigit;
                    }
                    return ($sum % 10) == 0;
                    break;

                    //Generally check if the input is empty
                case "generalInput":
                    if ((strlen($input) < 1)) {
                        $_SESSION[$warning] = "Name field cannot be empty!";
                        return false;
                    }
                    break;
            }
            break;

            //General integer (could be phone number, CC, etc)
        case "integer":
            switch ($type) {

                    //Input conditions for phonenumber
                case "phonenumber":
                    if ((strlen((string) $input) != 9)) {
                        $_SESSION[$warning] = "Phone number must be 9 digits";
                        return false;
                    }
                    if (!is_numeric($input)) {
                        $_SESSION[$warning] = "Phone number must consist of numbers only";
                        return false;
                    }
                    break;

                    //Generally check if the input is empty
                case "generalInput":
                    if ((strlen($input) < 1)) {
                        $_SESSION[$warning] = "Name field cannot be empty!";
                        return false;
                    }
                    break;
            }
            break;
            //Unexpected input type
        default:
            $_SESSION[$warning] = "Input type was not expected";
            return false;
    }
    return true;
}

//Check if user is logged in
function isLoggedIn()
{
    //Check if loggedin variable is defined and not null or if its false
    if ((isset($_SESSION['loggedin']) == false) || $_SESSION['loggedin'] == false) {
        //If so redirect user 
        header("Location: ../frontEnd/userNL.php");
        exit();
    }
}

//User logout
function logOut()
{
    //Continue sessions
    session_start();
    //Issue destroy command
    session_destroy();
    //Redirect to user not logged in
    header("Location: ../frontEnd/userNL.php");
}