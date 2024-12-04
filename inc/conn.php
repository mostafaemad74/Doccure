<?php

$conn = new mysqli('localhost', 'root', '', 'doccure');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
