<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$voters_id = $_POST['voters_id'];
		$annio = $_POST['annio'];
		$seccion = $_POST['seccion'];
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$filename = $_FILES['photo']['name'];
		if(!empty($filename)){
			move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$filename);	
		}

		$sql = "INSERT INTO voters (voters_id, password, firstname, lastname, annio, seccion, photo) VALUES ('$voters_id', '$password', '$firstname', '$lastname', '$annio', '$seccion', '$filename')";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Votante agregado satisfactoriamente';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}

	}
	else{
		$_SESSION['error'] = 'Selecciona todos los datos primero';
	}

	header('location: voters.php');
?>