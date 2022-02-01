<?php


$conn = OpenCon();


if (isset($_POST['delete'])) {
    $id = (int) $_POST['delete'];
    $conn->query("UPDATE user SET isvisible=0 WHERE cc=$id");
}

if (isset($_POST['removeMan'])) {
    $id = (int) $_POST['removeMan'];
    $conn->query("UPDATE user SET ismanager=0 WHERE cc=$id");
}
if (isset($_POST['allowMan'])) {
    $id = (int) $_POST['allowMan'];
    $conn->query("UPDATE user SET ismanager=1 WHERE cc=$id");
}

if (isset($_POST['removeCap'])) {
    $id = (int) $_POST['removeCap'];
    $conn->query("UPDATE user SET iscaptain=0 WHERE cc=$id");
}