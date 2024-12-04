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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


	$appointmentid = $_POST['appointmentid'];
	$action = $_POST['action'];

	if ($action == 'Cancel') {
		//update status
		$doctorData = $conn->query("UPDATE appointments SET status ='Cancelled' WHERE id = $appointmentid ");
	} elseif ($action == 'Accept') {
		$doctorData = $conn->query("UPDATE appointments SET status ='Confirm' WHERE id = $appointmentid ");
	}
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
						<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
					</ol>
				</nav>
				<h2 class="breadcrumb-title">Dashboard</h2>
				<p style="color:red;">
					<?php
					if (isset($_SESSION['profileCompleted'])) {
						echo $_SESSION['profileCompleted'];
					}
					?>
				</p>
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

				<div class="row">
					<div class="col-md-12">
						<div class="card dash-card">
							<div class="card-body">
								<div class="row">
									<div class="col-md-12 col-lg-6">
										<div class="dash-widget dct-border-rht">
											<div class="circle-bar circle-bar1">
												<div class="circle-graph1" data-percent="0">
													<img src="../assets/img/icon-01.png" class="img-fluid" alt="patient">
												</div>
											</div>
											<?php
											$totalpatients = $conn->query("SELECT COUNT(*) FROM appointments WHERE doctorid = '$doctorid'");
											$totalpatients = $totalpatients->fetch_all();

											$totalappoint = $conn->query("SELECT COUNT(*) FROM appointments WHERE doctorid = '$doctorid' and status = 'Confirm' ");
											$totalappoint = $totalappoint->fetch_all();


											?>

											<div class="dash-widget-info">
												<h6>Total Patient</h6>
												<h3><?php  print_r($totalpatients[0][0]); ?></h3>
												<p class="text-muted">Till Today</p>
											</div>
										</div>
									</div>



									<div class="col-md-12 col-lg-6">
										<div class="dash-widget">
											<div class="circle-bar circle-bar3">
												<div class="circle-graph3" data-percent="0">
													<img src="../assets/img/icon-03.png" class="img-fluid" alt="Patient">
												</div>
											</div>
											<div class="dash-widget-info">
												<h6>Appoinments</h6>
												<h3><?php  print_r($totalappoint[0][0]); ?></h3>
												<!-- <p class="text-muted">16, Apr 2023</p> -->
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<h4 class="mb-4">Patient Appoinment</h4>
						<div class="appointments">

							<?php

							$appointmentData = $conn->query("SELECT * FROM appointments WHERE doctorid = '$doctorid' and status = 'pending' ");

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
									<div class="appointment-action">

										<form action="doctor-dashboard.php" method="post">
											<div class="table-action">

												<input name="appointmentid" type="text" class="form-control" value="<?= $appoint['id'] ?>" hidden>
												<input name="action" type="text" class="form-control" value="Accept" hidden>
												<button type="submit" class="btn btn-sm bg-success-light">
													<i class="fas fa-check"></i> Accept
												</button>
											</div>
										</form>
										<form action="patient-dashboard.php" method="post">
											<div class="table-action">

												<input name="appointmentid" type="text" class="form-control" value="<?= $appoint['id'] ?>" hidden>
												<input name="action" type="text" class="form-control" value="Cancel" hidden>
												<button type="submit" class="btn btn-sm bg-danger-light submit-btn">
													<i class="far fa-trash-alt"></i> Cancel
												</button>
											</div>
										</form>
									</div>
								</div>
								<!-- /Appointment List -->
							<?php
							}
							?>

						</div>
					</div>
				</div>

			</div>
		</div>

	</div>

</div>
<!-- /Page Content -->



<?php
include 'inc/footer.php';
?>