<?php

include 'inc/conn.php';
include 'inc/functions.php';
session_start();

//check if user has role patient
isPatient();

//get patient id by SESSION 
if (isset($_SESSION['id'])) {
    $patientid = $_SESSION['id'];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // get data

    //recive image name & path
    $imageName  = $_FILES['image']['name'];
    $imageOldLocation  = $_FILES['image']['tmp_name'];

    if (empty($imageName)) {
        $_SESSION['uploaderror']='Upload Photo First*';
        header('Location: profile-settings.php');
    } else {
        $newpath = upload($imageName, $imageOldLocation);
        //update patient data
        $updateq = $conn->query("UPDATE patients SET image ='$newpath' WHERE id = '$patientid'");
        $_SESSION['profileUpdated']='Profile Updated Successfully';
        header('Location: profile-settings.php');
    }
}
