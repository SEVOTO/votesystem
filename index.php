<?php
  	session_start();
  	if(isset($_SESSION['admin'])){
    	header('location: vista/admin/home.php');
  	}

    if(isset($_SESSION['voter'])){
      header('location: vista/home.php');
    }
?>
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8">
  	<!-- Tell the browser to be responsive to screen width -->
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="vista/plugins/iCheck/all.css">
    <link rel="stylesheet" href="vista/estilos/estilos.css">
    <link href="vista/dist/img/sevoto.png" rel="icon" type="image/png" />
      	<!-- Font Awesome -->
  	<link rel="stylesheet" href="vista/bower_components/font-awesome/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>SEVOTO</title>

  	<!-- Google Font -->
  	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

<!-- PHPRECOGNITIONx -->


</head>
<body background="vista/dist/img/New.jpg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="zoom-layer">
                    <div class="box">
                        <form name="loginForm" action="vista/login.php" method="POST">
                            <img class="img-logo" src="vista/dist/img/sevoto.png" class="img-fluid mb-3" alt="Logo">
                            <div class="inputBox">
                                <div class="form-group">
                                    <label for="usuario" class="label"><b>Cedula</b></label>
                                    <input type="number" name="voter"required autocomplete="off">
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="password" class="label"><b>Contraseña</b></label>
                                    <input type="password" class="form-control" name="password" required autocomplete="off">
                                </div>
                                <input type="submit" name="login" placeholder="Iniciar Sesión">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
		<?php if (isset($_SESSION['error'])): ?>
      Swal.fire({
        icon: 'error',
        title: 'error',
        text: '<?php echo $_SESSION['error']; ?>'
      });
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    </script>
<?php include 'vista/includes/scripts.php' ?>
</body>
</html>