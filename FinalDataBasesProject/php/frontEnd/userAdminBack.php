<?php


$conn = OpenCon();


if (isset($_POST['delete'])) {
    $id = (int) $_POST['delete'];
    $conn->query("UPDATE forummessage SET isvisible=0 WHERE id=$id");
}