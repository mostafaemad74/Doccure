<?php
include 'inc/header.php';
include 'inc/conn.php';
include 'inc/functions.php';

if (!isset($_SESSION)) {
	session_start();
}

//check if user has role patient
isPatient();

//get patient id by SESSION 
if (isset($_SESSION['id'])) {
	$patientid = $_SESSION['id'];
	//get patient all data
	$selectData = $conn->query("SELECT * FROM patients WHERE patients.id = '$patientid'");
	$patientdata = $selectData->fetch_assoc();
	profileComplete($patientdata);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// get data
	$oldPass = $_POST['oldPass'];
	$newPass = $_POST['newPass'];
	$confirmPass = $_POST['confirmPass'];
	if (
		$oldPass == "" ||
		$newPass == "" ||
		$confirmPass == ""
	) {
		$_SESSION['passwordUpdate'] = "All Data Is Required";
	} else {

		$oldHash = md5($oldPass);

		if ($oldHash == $patientdata['password']) {
			if ($newPass == $confirmPass) {
				$newHash = md5($newPass);
				//update patient data
				$updateq = $conn->query("UPDATE patients SET password ='$newHash'  WHERE id = '$patientid'");
				$_SESSION['passwordUpdate'] = 'Password Updated Successfully';
			} else {
				$_SESSION['passwordUpdate'] = "Password doesn't Match";
			}
		} else {
			$_SESSION['passwordUpdate'] = "Wrong Password Try Again Click";
		}
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
						<li class="breadcrumb-item active" aria-current="page">Change Password</li>
					</ol>
				</nav>
				<h2 class="breadcrumb-title">Change Password</h2>
				<p style="color:red;">
					<?php
					if (isset($_SESSION['profileCompleted'])) {
						echo $_SESSION['profileCompleted'];
					}
					?>
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
								<img src="<?php
											if (!isset($patientdata['image'])) {
												echo "../assets/img/patients/patient.jpg";
											} else {
												echo $patientdata['image'];
											}
											?>" alt="User Image">
							</a>
							<div class="profile-det-info">
								<h3><?= $patientdata['fristName'] . " " . $patientdata['lastName'] ?></h3>
								<div class="patient-details">
									<h5><i class="fas fa-birthday-cake"></i><?= $patientdata['dateOfBirth'] ?></h5>
									<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i><?= $patientdata['city'] ?>,<?= $patientdata['country'] ?></h5>
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

				<!-- /Profile Sidebar -->

			</div>

			<div class="col-md-7 col-lg-8 col-xl-9">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-12 col-lg-6">
								<p style="color:red; align-items: center;">
									<?php
									if (isset($_SESSION['passwordUpdate'])) {
										echo $_SESSION['passwordUpdate'];
									}
									?>
									<!-- Change Password Form -->
								<form action="change-password.php" method="post">
									<div class="form-group">
										<label>Old Password</label>
										<input required type="password" name="oldPass" class="form-control">
									</div>
									<div class="form-group">
										<label>New Password</label>
										<input required type="password" name="newPass" class="form-control">
									</div>
									<div class="form-group">
										<label>Confirm Password</label>
										<input required type="password" name="confirmPass" class="form-control">
									</div>
									<div class="submit-section">
										<button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
									</div>
								</form>
								<!-- /Change Password Form -->

							</div>
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
unset($_SESSION['passwordUpdate']);
?>