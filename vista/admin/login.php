<?php
	session_start();
	include 'includes/conn.php';
	


	if(isset($_POST['login'])){
		$username = $_POST['username'];
		$password = $_POST['password'];

		$sql = "SELECT * FROM admin WHERE username = '$username'";
		$query = $conn->query($sql);

		if($query->num_rows < 1){
			$_SESSION['error'] = 'No se puede encontrar el usuario';
		}
		else{
			$row = $query->fetch_assoc();
			if(password_verify($password, $row['password'])){
				$_SESSION['admin'] = $row['id'];
			}
			else{
				$_SESSION['error'] = 'Contraseña incorrecta';
			}
		}
		
	}
	else{
		$_SESSION['error'] = 'Ingrese los datos correctamente';
	}

	if(isset($_SESSION['voter'])){
    	header('location:../../index.php');
  	}

	header('location: index.php');

?>