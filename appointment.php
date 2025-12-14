<?php

$name = $_POST['name'];
$phone = $_POST['phone'];
$date = $_POST['date'];
$doctor = $_POST['doctor'];

$data = "Name: $name | Phone: $phone | Date: $date | Doctor: $doctor\n";

file_put_contents("appointments.txt", $data, FILE_APPEND);

echo "<h2>Appointment Booked Successfully!</h2>";
echo "<p>We will contact you soon.</p>";
?>
