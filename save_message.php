<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $entry = "Name: $name\nPhone: $phone\nEmail: $email\nMessage: $message\n----------------------\n";

    file_put_contents("messages.txt", $entry, FILE_APPEND);

    // Redirect back with success flag
    header("Location: index.html?success=1");
    exit();
}
?>


