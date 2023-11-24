<?php
	include 'includes/session.php';

	if(isset($_GET['return'])){
		$return = $_GET['return'];
		
	}
	else{
		$return = 'home.php';
	}

	if(isset($_POST['save'])){
		$curr_password = $_POST['curr_password'];
		$password = $_POST['password'];
		$photo = $_FILES['photo']['name'];
		if(password_verify($curr_password, $voter['password'])){
			if(!empty($photo)){
				move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$photo);
				$filename = $photo;	
			}
			else{
				$filename = $voter['photo'];
			}

			if($password == $voter['password']){
				$password = $voter['password'];
			}
			else{
				$password = password_hash($password, PASSWORD_DEFAULT);
			}

			$sql = "UPDATE voters SET password = '$password', photo = '$filename' WHERE id = '".$voter['id']."'";
			if($conn->query($sql)){
				$_SESSION['success'] = 'Perfil actualizado satisfactoriamente';
			}
			else{
				$_SESSION['error'] = $conn->error;
			}
			
		}
		else{
			$_SESSION['error'] = 'Contraseña incorrecta';
		}
	}
	else{
		$_SESSION['error'] = 'Rellene todos los datos primero';
	}

	header('location:'.$return);

?>