<?php
include 'inc/header.php';
session_start();

if (isset($_SESSION['role'])) {
	if ($_SESSION['role'] == "patient") {
		header('Location: patient/patient-dashboard.php');
	} elseif ($_SESSION['role'] == "doctor") {
		header('Location: doctor/doctor-dashboard.php');
	}
}
?>
<!-- Home Banner -->
<section class="section section-search" style="height: 80vh ;">
	<div class="container-fluid">
		<div class="banner-wrapper">
			<div class="banner-header text-center">
				<h1>Choose Doctor, Make an Appointment</h1>
				<p>Discover the best Doctors nearest to you.</p>
			</div>

			<!-- Search -->
			<div class="text-center login-link">
				<a href="patient/login.php" class="btn btn-success btn-lg px-5 mt-5">Patients</a>
				
				<a href="doctor/doctorlogin.php" class="btn btn-success btn-lg px-5 mt-5 ">Doctors</a>

			</div>
			<!-- /Search -->

		</div>
	</div>
</section>
<!-- /Home Banner -->


<?php
include 'inc/footer.php';
?>