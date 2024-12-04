<?php
include 'inc/header.php';
include 'inc/conn.php';
include 'inc/functions.php';

if (!isset($_SESSION)) {
	session_start();
}

//check if user has role doctor
isDoctor();

if (isset($_SESSION['id'])) {
	//get doctor id by SESSION 
	$doctorid = $_SESSION['id'];
	//get doctor all data
	$selectData = $conn->query("SELECT * FROM doctors WHERE id = '$doctorid'");
	$doctordata = $selectData->fetch_assoc();

	profileComplete($doctordata);
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
						<li class="breadcrumb-item active" aria-current="page">Appointments</li>
					</ol>
				</nav>
				<h2 class="breadcrumb-title">Appointments</h2>
			</div>
		</div>
	</div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
	<div class="container-fluid">

		<div class="row">
			<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">

				<!-- Profile Sidebar -->
				<div class="profile-sidebar">
					<div class="widget-profile pro-widget-content">
						<div class="profile-info-widget">
							<a href="#" class="booking-doc-img">
								<img src="<?= $doctordata['image']; ?>" alt="User Image">
							</a>
							<div class="profile-det-info">
								<h3>Dr. <?= $doctordata['userName']; ?></h3>

								<div class="patient-details">
									<h5 class="mb-0"><?= $doctordata['biography']; ?></h5>
								</div>
							</div>
						</div>
					</div>
					<div class="dashboard-widget">
						<nav class="dashboard-menu">
							<ul>
								<li>
									<a href="doctor-dashboard.php">
										<i class="fas fa-columns"></i>
										<span>Dashboard</span>
									</a>
								</li>
								<li>
									<a href="appointments.php">
										<i class="fas fa-calendar-check"></i>
										<span>Appointments</span>
									</a>
								</li>


								<li>
									<a href="doctor-profile-settings.php">
										<i class="fas fa-user-cog"></i>
										<span>Profile Settings</span>
									</a>
								</li>

								<li>
									<a href="../logout.php">
										<i class="fas fa-sign-out-alt"></i>
										<span>Logout</span>
									</a>
								</li>
							</ul>
						</nav>
					</div>
				</div>
				<!-- /Profile Sidebar -->

			</div>

			<div class="col-md-7 col-lg-8 col-xl-9">
				<h2 class="text-center my-3">Accepted Appoinments</h2>
				<div class="appointments">

					<?php

					$appointmentData = $conn->query("SELECT * FROM appointments WHERE doctorid = '$doctorid' and status = 'Confirm' ");

					foreach ($appointmentData as $appoint) {
						$patientid = $appoint['patientid'];
						$patientData = $conn->query("SELECT * FROM patients WHERE id = '$patientid'");
						$patientData = $patientData->fetch_assoc();
					?>

						<!-- Appointment List -->
						<div class="appointment-list">
							<div class="profile-info-widget">
								<a href="patient-profile.html" class="booking-doc-img">
									<img src="<?= $patientData['image'] ?>" alt="User Image">
								</a>
								<div class="profile-det-info">
									<h3><a href="patient-profile.html"><?= $patientData['fristName'] ?> <?= $patientData['lastName'] ?></a></h3>
									<div class="patient-details">
										<h5><i class="far fa-clock"></i> <?= $appoint['appointDate'] ?>, <?= $appoint['appointTime'] ?></h5>
										<h5><i class="fas fa-map-marker-alt"></i> <?= $patientData['state'] ?>, <?= $patientData['country'] ?></h5>
										<h5><i class="fas fa-envelope"></i> <?= $patientData['email'] ?></h5>
										<h5 class="mb-0"><i class="fas fa-phone"></i> <?= $patientData['mobile'] ?></h5>
									</div>
								</div>
							</div>

						</div>
						<!-- /Appointment List -->

					<?php } ?>



				</div>
			</div>
		</div>

	</div>

</div>
<!-- /Page Content -->


</div>
<!-- /Main Wrapper -->

<!-- Appointment Details Modal -->
<div class="modal fade custom-modal" id="appt_details">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Appointment Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<ul class="info-details">
					<li>
						<div class="details-header">
							<div class="row">
								<div class="col-md-6">
									<span class="title">#APT0001</span>
									<span class="text">21 Oct 2019 10:00 AM</span>
								</div>
								<div class="col-md-6">
									<div class="text-right">
										<button type="button" class="btn bg-success-light btn-sm" id="topup_status">Completed</button>
									</div>
								</div>
							</div>
						</div>
					</li>
					<li>
						<span class="title">Status:</span>
						<span class="text">Completed</span>
					</li>
					<li>
						<span class="title">Confirm Date:</span>
						<span class="text">29 Jun 2019</span>
					</li>
					<li>
						<span class="title">Paid Amount</span>
						<span class="text">$450</span>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- /Appointment Details Modal -->


<?php
include 'inc/footer.php';

?>