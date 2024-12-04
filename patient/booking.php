<?php
include 'inc/header.php';
include 'inc/conn.php';
include 'inc/functions.php';

if (!isset($_SESSION)) {
	session_start();
}

//check if user has role patient
isPatient();

if (isset($_SESSION['id'])) {
	//get patient id by SESSION 
	$patientid = $_SESSION['id'];
	//get patient all data
	$selectData = $conn->query("SELECT * FROM patients WHERE id = '$patientid'");
	$patientdata = $selectData->fetch_assoc();

	profileComplete($patientdata);
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	$doctorid = $_GET['doctorId'];

	//get doctor data
	$doctorData = $conn->query("SELECT * FROM doctors WHERE id ='$doctorid' ");
	$doctorData = $doctorData->fetch_assoc();
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
<div class="content">
	<div class="container">

		<div class="row">
			<div class="col-12">

				<div class="card">
					<div class="card-body">
						<div class="booking-doc-info">
							<a href="doctor-profile.php" class="booking-doc-img">
								<img src="<?= $doctorData['image'] ?>" alt="User Image">
							</a>
							<div class="booking-info">
								<h4><a href="doctor-profile.php">Dr. <?= $doctorData['userName'] ?></a></h4>

								<p class="text-muted mb-3"><i class="fas fa-map-marker-alt"></i> <?= $doctorData['country'] ?></p>
								<p class="doc-location">
									<i class="far fa-money-bill-alt"></i> <?= $doctorData['pricing'] ?>
								</p>
							</div>
						</div>
					</div>
				</div>
				<form action="booking-success.php" method="post">

					<div class="row">
						<div class="col-md-6">
							<div class="card">
								<div class="card-body">
									<h3>Choose your Appointment Date</h3>
									<input name="appointDate" type="date" class="form-control" required>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card">
								<div class="card-body">
									<h3>Choose your Appointment Time</h3>
									<input name="appointTime" type="time" class="form-control" required>
								</div>
								<input name="patientid" type="text" class="form-control" value="<?= $patientid ?>" hidden>
								<input name="doctorid" type="text" class="form-control" value="<?= $doctorid ?>" hidden>
							</div>
						</div>
					</div>



					<!-- Schedule Widget -->

					<!-- /Schedule Widget -->

					<!-- Submit Section -->
					<div class="submit-section proceed-btn text-right">
						<button type="submit" class="btn btn-primary submit-btn">Make Appointment</button>
					</div>
					<!-- /Submit Section -->
				</form>
			</div>
		</div>
	</div>

</div>
<!-- /Page Content -->



<?php
include 'inc/footer.php';
?>