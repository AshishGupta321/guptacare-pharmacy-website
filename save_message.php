<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $entry = "------------------------------\n";
    $entry .= "Name: $name\n";
    $entry .= "Phone: $phone\n";
    $entry .= "Email: $email\n";
    $entry .= "Message: $message\n";
    $entry .= "Time: " . date("Y-m-d H:i:s") . "\n";
    $entry .= "------------------------------\n\n";

    file_put_contents("messages.txt", $entry, FILE_APPEND);

    header("Location: index.html#contact");
    exit();
}
?>
