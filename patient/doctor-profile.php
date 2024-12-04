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

	$doctorId = $_GET['doctorId'];

	//get doctor data
	$doctorData = $conn->query("SELECT * FROM doctors WHERE id ='$doctorId' ");
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
						<li class="breadcrumb-item active" aria-current="page">Doctor Profile</li>
					</ol>
				</nav>
				<h2 class="breadcrumb-title">Doctor Profile</h2>
			</div>
		</div>
	</div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
	<div class="container">

		<!-- Doctor Widget -->
		<div class="card">
			<div class="card-body">
				<div class="doctor-widget">
					<div class="doc-info-left">
						<div class="doctor-img">
							<img src="<?= $doctorData['image'] ?>" class="img-fluid" alt="User Image">
						</div>
						<div class="doc-info-cont">
							<h4 class="doc-name">Dr. <?= $doctorData['userName'] ?></h4>
							<p class="doc-speciality">BDS, MDS - Oral & Maxillofacial Surgery</p>

							<div class="clinic-details">
								<p class="doc-location"><i class="fas fa-map-marker-alt"></i> <?= $doctorData['country'] ?></p>
								<p class="doc-location">
									<i class="far fa-money-bill-alt"></i> <?= $doctorData['pricing'] ?>
								</p>
							</div>

						</div>
					</div>
					<div class="doc-info-right">

						<div class="clinic-booking">
							<a class="apt-btn" href="booking.php?doctorId=<?= $doctorId ?>">Book Appointment</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Doctor Widget -->

		<!-- Doctor Details Tab -->
		<div class="card">
			<div class="card-body pt-0">

				<!-- Tab Menu -->
				<nav class="user-tabs mb-4">
					<ul class="nav nav-tabs nav-tabs-bottom nav-justified">
						<li class="nav-item">
							<a class="nav-link active" href="#doc_overview" data-toggle="tab">Overview</a>
						</li>

					</ul>
				</nav>
				<!-- /Tab Menu -->

				<!-- Tab Content -->
				<div class="tab-content pt-0">

					<!-- Overview Content -->
					<div role="tabpanel" id="doc_overview" class="tab-pane fade show active">
						<div class="row">
							<div class="col-md-12 col-lg-9">

								<!-- About Details -->
								<div class="widget about-widget">
									<h4 class="widget-title">About Me</h4>
									<p><?= $doctorData['biography'] ?></p>
								</div>
								<!-- /About Details -->



							</div>
						</div>
					</div>
					<!-- /Overview Content -->


				</div>
			</div>
		</div>
		<!-- /Doctor Details Tab -->

	</div>
</div>
<!-- /Page Content -->


</div>
<!-- /Main Wrapper -->

<!-- Voice Call Modal -->
<div class="modal fade call-modal" id="voice_call">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<!-- Outgoing Call -->
				<div class="call-box incoming-box">
					<div class="call-wrapper">
						<div class="call-inner">
							<div class="call-user">
								<img alt="User Image" src="assets/img/doctors/doctor-thumb-02.jpg" class="call-avatar">
								<h4>Dr. Darren Elder</h4>
								<span>Connecting...</span>
							</div>
							<div class="call-items">
								<a href="javascript:void(0);" class="btn call-item call-end" data-dismiss="modal" aria-label="Close"><i class="material-icons">call_end</i></a>
								<a href="voice-call.html" class="btn call-item call-start"><i class="material-icons">call</i></a>
							</div>
						</div>
					</div>
				</div>
				<!-- Outgoing Call -->

			</div>
		</div>
	</div>
</div>
<!-- /Voice Call Modal -->

<!-- Video Call Modal -->
<div class="modal fade call-modal" id="video_call">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body">

				<!-- Incoming Call -->
				<div class="call-box incoming-box">
					<div class="call-wrapper">
						<div class="call-inner">
							<div class="call-user">
								<img class="call-avatar" src="assets/img/doctors/doctor-thumb-02.jpg" alt="User Image">
								<h4>Dr. Darren Elder</h4>
								<span>Calling ...</span>
							</div>
							<div class="call-items">
								<a href="javascript:void(0);" class="btn call-item call-end" data-dismiss="modal" aria-label="Close"><i class="material-icons">call_end</i></a>
								<a href="video-call.html" class="btn call-item call-start"><i class="material-icons">videocam</i></a>
							</div>
						</div>
					</div>
				</div>
				<!-- /Incoming Call -->

			</div>
		</div>
	</div>
</div>
<!-- Video Call Modal -->

<?php
include 'inc/footer.php';
?>