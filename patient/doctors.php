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
?>

<!-- Breadcrumb -->
<div class="breadcrumb-bar">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-md-12 col-12">
				<nav aria-label="breadcrumb" class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="../index.php">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">Doctors</li>
					</ol>
				</nav>
				<h2 class="breadcrumb-title">Doctors</h2>
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
			<div class="col-md-7 col-lg-8 col-xl-9">
				<div class="row row-grid">
					<?php 
					$doctorsData= $conn->query("SELECT * FROM doctors");
					foreach($doctorsData as $doctor) {
					?>
					<div class="col-md-6 col-lg-4 col-xl-3">
						<div class="profile-widget">
							<div class="doc-img">
								<a href="doctor-profile.php">
									<img class="img-fluid" alt="User Image" src="<?= $doctor['image'] ?>">
								</a>
								<a href="javascript:void(0)" class="fav-btn">
									<i class="far fa-bookmark"></i>
								</a>
							</div>
							<div class="pro-content">
								<h3 class="title">
									<a href="doctor-profile.php"><?= $doctor['userName'] ?></a>
									<i class="fas fa-check-circle verified"></i>
								</h3>
								<p class="speciality"><?= $doctor['biography'] ?></p>

								<ul class="available-info">
									<li>
										<i class="fas fa-map-marker-alt"></i> <?= $doctor['country'] ?> , Egypt
									</li>

									<li>
										<i class="far fa-money-bill-alt"></i>  <?= $doctor['pricing'] ?> <i class="fas fa-info-circle" data-toggle="tooltip" title="EGP"></i>
									</li>
								</ul>
								<div class="row row-sm">
									<div class="col-6">
										<a href="doctor-profile.php?doctorId=<?= $doctor['id'] ?>" class="btn view-btn">View Profile</a>
									</div>
									<div class="col-6">
										<a href="booking.php?doctorId=<?= $doctor['id'] ?>" class="btn book-btn">Book Now</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php 
					}
					?>





				</div>
			</div>
		</div>
	</div>

</div>
<!-- /Page Content -->


<?php
include 'inc/footer.php';
?>