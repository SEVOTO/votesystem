<?php
	include 'includes/session.php';

	$sql = "DELETE FROM votes";
	if($conn->query($sql)){
		$_SESSION['success'] = "Votos realizado satisfactoriamente";
	}
	else{
		$_SESSION['error'] = "A ocurrido un error durante la restauracion";
	}

	header('location: votes.php');

?>