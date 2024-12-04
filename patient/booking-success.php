<?php
include 'inc/header.php';
include 'inc/conn.php';
include 'inc/functions.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$appointDate = $_POST['appointDate'];
	$appointTime = $_POST['appointTime'];
	$doctorid = $_POST['doctorid'];
	$patientid = $_POST['patientid'];

	//get doctor data
	$doctorData = $conn->query("SELECT * FROM doctors WHERE id ='$doctorid' ");
	$doctorData = $doctorData->fetch_assoc();
	$doctorPricing = $doctorData['pricing'];
	$status = 'pending';

	$insertq = $conn->query("INSERT INTO appointments (patientid, doctorid, appointDate, appointTime, status, amount, date) VALUES ('$patientid','$doctorid','$appointDate','$appointTime','$status','$doctorPricing', now()) ");
	if ($insertq === TRUE) {
		
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {

	header('Location: doctors.php');
}

?>
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-md-12 col-12">
				<nav aria-label="breadcrumb" class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="../index.php">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">Booking</li>
					</ol>
				</nav>
				<h2 class="breadcrumb-title">Booking</h2>
			</div>
		</div>
	</div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content success-page-cont">
	<div class="container-fluid">

		<div class="row justify-content-center">
			<div class="col-lg-6">

				<!-- Success Card -->
				<div class="card success-card">
					<div class="card-body">
						<div class="success-cont">
							<i class="fas fa-check"></i>
							<h3>Appointment booked Successfully!</h3>
							<p>Appointment booked with <strong> Dr. <?= $doctorData['userName'] ?> </strong><br> on <strong><?= $appointDate ?> </strong> Time <strong> <?= $appointTime ?></strong></p>
							<a href="doctors.php" class="btn btn-primary view-inv-btn">Go To Doctors</a>
						</div>
					</div>
				</div>
				<!-- /Success Card -->

			</div>
		</div>

	</div>
</div>
<!-- /Page Content -->


<?php
include 'inc/footer.php';
?>