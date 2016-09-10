<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
include "config/config.php";
$secure = "OK";
include "config/helper.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>System Management Project Localhost</title>
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<!--Import materialize.css-->
	<link type="text/css" rel="stylesheet" href="assets/css/materialize.css"  media="screen,projection"/>
	<!-- Custom CSS -->
	<link type="text/css" rel="stylesheet" href="assets/css/custom.css">
	<script type="text/javascript" src="assets/js/jquery-2.1.1.min.js"></script>
	<!--Import jQuery before materialize.js-->
	<script type="text/javascript" src="assets/js/materialize.min.js"></script>
	<!--Import DataTables -->
	<script type="text/javascript" src="assets/js/dataTables/js/jquery.dataTables.js"></script>
	<link type="text/css" rel="stylesheet" href="assets/js/dataTables/css/jquery.dataTables.css">
</head>

<body>

<?php
if(!file_exists("config/config.php")){
	header("location:install/");
} else {
	/*$dir = 'install';
	if(file_exists($dir)){
		$it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
		$files = new RecursiveIteratorIterator($it,
		             RecursiveIteratorIterator::CHILD_FIRST);
		foreach($files as $file) {
		    if ($file->isDir()){
		        rmdir($file->getRealPath());
		    } else {
		        unlink($file->getRealPath());
		    }
		}
		rmdir($dir);
	}*/
}
if(isset($_SESSION['usr_manage'])){
	?>
	<nav class="navweb">
		<div class="container">
			<div class="nav-wrapper">
		    	<div class="titleweb"><a href="http://localhost/">System Management Project Localhost</a><span class="right panelusr">Hi, <?php echo $_SESSION['usr_manage']['nama'];?> || <a href="logout.php">Logout</a></span></div>
			</div>
		</div>
	</nav>
	<div class="container maincont">
		<?php include "views/manage.php";?>
	</div>
    <footer>
    	<div class="footcopy">
            <div class="container">
            © 2016 <a href="http://google.com/?q=Fadhil Nur Mahardi" target="_blank">System Management Project Localhost V 0.5</a>
            <a class="grey-text text-lighten-4 right" href="#!"></a>
            </div>
    	</div>
    </footer>
    <?php
} else {
	?>
	<div class="login col s12 m12 l12">
		<form action="" method="POST">
			<input type="hidden" name="do_login">
			<div class="row">
				<div class="col s12 m3 l3"></div>
				<div class="card col l6 m6 s12">
						<div class="card-title center-align">
							<h1>Login Page</h1>
							<?php
							if(isset($_POST['email']) && isset($_POST['password'])){
								if($_POST['email'] != "" && $_POST['password'] != ""){
									$user = $_POST['email'];
									$pass = md5($_POST['password']);
									$query = mysqli_query($manage,"SELECT * FROM user WHERE username='$user' AND password='$pass'");
									if(mysqli_num_rows($query) == 1){
										$dat = mysqli_fetch_array($query);
										$_SESSION['usr_manage']['nama'] = $dat['nama'];
										$_SESSION['usr_manage']['username'] = $dat['username'];
										?>
										<script type="text/javascript">
											$(document).ready(function(){
												Materialize.toast('Login Berhasil', 4000, 'toast-success');
											});
										</script>
										<meta http-equiv="refresh" content="3;http://localhost/manage/"><?php
									} else {
										?>
										<script type="text/javascript">
											$(document).ready(function(){
												Materialize.toast('Invalid Username and Password', 4000, 'toast-warning');
											});
										</script><?php	
									}
								} else {
									?>
									<script type="text/javascript">
										$(document).ready(function(){
											Materialize.toast('Username or Password is empty!!', 4000, 'toast-warning');
										});
									</script><?php
								}
							}
							?>
						</div>
						<div class="input-field col l12 m12 s12">
							<input id="user" class="validate" type="text" name="email">
							<label for="user"> Username </label>
						</div>
						<div class="input-field col l12 m12 s12">
							<input id="pass" class="validate" type="password" name="password">
							<label for="pass"> Password </label>
						</div>
			  			<div class="center-align">
			  				<button class="btn waves-effect waves-light" type="submit()" name="action">Submit
				    			<i class="material-icons right">send</i>
				  			</button>
			  			</div>
				</div>
				<div class="col s12 m3 l3"></div>
			</div>
		</form>
	</div>
	<?php
}
?>
<script type="text/javascript">
	$(document).ready(function() {
	    $('select').material_select();
	    $('.datepicker').pickadate({
	        selectMonths: true, // Creates a dropdown to control month
	        selectYears: 15, // Creates a dropdown of 15 years to control year
	        format: 'yyyy-mm-dd' 
	      });
	  });
</script>
</body>
</html>
