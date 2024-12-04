<?php

function upload($imageName, $imageOldLocation)
{
    //recive image name & path
    $imageName  = $_FILES['image']['name'];
    $imageOldLocation  = $_FILES['image']['tmp_name'];

    //change image name & path
    $r = rand();
    $t = time();
    $newImageName  = "$r$t$imageName";
    $newPath  = "../assets/img/patients/$newImageName";

    //upload image
    move_uploaded_file($imageOldLocation, $newPath);
    return $newPath;
}


//check if user has role patient
function isDoctor()
{
    if (!isset($_SESSION['role'])) {
        if (!$_SESSION['role'] == "doctor") {
            header('Location: ../index.php');
        }
    }
}


//check if user alreadyLogin 
function alreadyLogin()
{
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] == "patient") {
            header('Location: patient-dashboard.php');
        }
    }
}


//check if user complete his profile or not
function profileComplete($doctordata)
{

    if (
        $doctordata['lastName'] == "" ||
        $doctordata['firstName'] == "" ||
        $doctordata['biography'] == "" ||
        $doctordata['mobile'] == "" ||
        $doctordata['pricing'] == "" ||
        $doctordata['country'] == ""
    ) {

        $_SESSION['profileCompleted'] = "Complete your profile";
    } else {
        unset($_SESSION['profileCompleted']);
    }
}
