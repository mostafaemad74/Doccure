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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$appointmentid = $_POST['appointmentid'];

	//get doctor data
	$doctorData = $conn->query("UPDATE appointments SET status ='Cancelled' WHERE id = $appointmentid ");
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

			<!-- Profile Sidebar -->
			<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
				<div class="profile-sidebar">
					<div class="widget-profile pro-widget-content">
						<div class="profile-info-widget">
							<a href="#" class="booking-doc-img">
								<img src="<?= $patientdata['image']; ?>" alt="User Image">
							</a>
							<div class="profile-det-info">
								<h3><?= $patientdata['fristName'] . " " . $patientdata['lastName'] ?></h3>
								<div class="patient-details">
									<h5><i class="fas fa-birthday-cake"></i><?= $patientdata['dateOfBirth'] ?></h5>
									<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> <?= $patientdata['city'] ?>,<?= $patientdata['country'] ?></h5>
								</div>
							</div>
						</div>
					</div>
					<div class="dashboard-widget">
						<nav class="dashboard-menu">
							<ul>
								<li>
									<a href="patient-dashboard.php">
										<i class="fas fa-columns"></i>
										<span>Dashboard</span>
									</a>
								</li>
								<li>
									<a href="doctors.php">
										<i class="fas fa-user-md"></i>
										<span>Doctors</span>
									</a>
								</li>
								<li>
									<a href="profile-settings.php">
										<i class="fas fa-user-cog"></i>
										<span>Profile Settings</span>
									</a>
								</li>
								<li>
									<a href="change-password.php">
										<i class="fas fa-lock"></i>
										<span>Change Password</span>
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
			</div>
			<!-- / Profile Sidebar -->

			<div class="col-md-7 col-lg-8 col-xl-9">
				<div class="card">
					<div class="card-body pt-0">

						<!-- Tab Menu -->
						<nav class="user-tabs mb-4">
							<ul class="nav nav-tabs nav-tabs-bottom nav-justified">
								<li class="nav-item">
									<a class="nav-link active" href="#pat_appointments" data-toggle="tab">Appointments</a>
								</li>

							</ul>
						</nav>
						<!-- /Tab Menu -->

						<!-- Tab Content -->
						<div class="tab-content pt-0">

							<!-- Appointment Tab -->
							<div id="pat_appointments" class="tab-pane fade show active">
								<div class="card card-table mb-0">
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-hover table-center mb-0">
												<thead>
													<tr>
														<th>Doctor</th>
														<th>Appt Date</th>
														<th>Booking Date</th>
														<th>Amount</th>
														<th>Status</th>
														<th></th>
													</tr>
												</thead>
												<tbody>
													<?php

													$appointmentData = $conn->query("SELECT * FROM appointments WHERE patientid = '$patientid'");

													foreach ($appointmentData as $appoint) {
														$doctorid = $appoint['doctorid'];
														$doctorData = $conn->query("SELECT * FROM doctors WHERE id = '$doctorid'");
														$doctorData = $doctorData->fetch_assoc();
													?>
														<tr>
															<td>
																<h2 class="table-avatar">
																	<a href="doctor-profile.php?doctorid=<?= $doctorData['id'] ?>" class="avatar avatar-sm mr-2">
																		<img class="avatar-img rounded-circle" src="<?= $doctorData['image'] ?>" alt="User Image">
																	</a>
																	<a href="doctor-profile.php?doctorId=<?= $doctorData['id'] ?>">Dr. <?= $doctorData['userName'] ?> <span>Dental</span></a>
																</h2>
															</td>
															<td><?= $appoint['appointDate'] ?> <span class="d-block text-info"><?= $appoint['appointTime'] ?></span></td>
															<td><?= $appoint['date'] ?></td>
															<td><?= $appoint['amount'] ?> EGP</td>

															<?php
															if ($appoint['status'] == 'Cancelled') { ?>
																<td><span class="badge badge-pill bg-danger-light"><?= $appoint['status'] ?></span></td>
															<?php } elseif ($appoint['status'] == 'Confirm') { ?>
																<td><span class="badge badge-pill bg-success-light"><?= $appoint['status'] ?></span></td>
															<?php } else { ?>
																<td><span class="badge badge-pill bg-warning-light"><?= $appoint['status'] ?></span></td>
															<?php
															}
															?>

															<td class="text-right">
																<form action="patient-dashboard.php" method="post">
																	<div class="table-action">

																		<input name="appointmentid" type="text" class="form-control" value="<?= $appoint['id'] ?>" hidden>
																		<button type="submit" class="btn btn-sm bg-danger-light submit-btn">
																			<i class="far fa-trash-alt"></i> Cancel
																		</button>
																	</div>
																</form>
															</td>
														</tr>
													<?php
													}
													?>



												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<!-- /Appointment Tab -->


						</div>
						<!-- Tab Content -->

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