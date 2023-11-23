<?php
  	session_start();
  	if(isset($_SESSION['admin'])){
    	header('location:home.php');
  	}
?>
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8">
  	<!-- Tell the browser to be responsive to screen width -->
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="../plugins/iCheck/all.css">
    <link rel="stylesheet" href="../estilos/estilos.css">
    <link href="../dist/img/sevoto.png" rel="icon" type="image/png" />
    <script src="../dist/js/jquery-3.5.1.slim.min.js"></script>
    <script src="../dist/js/sweetalert2@11.js"></script>
    <title>SEVOTO</title>

  	<!-- Google Font -->
  	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>
<body background="../dist/img/New.jpg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="zoom-layer">
                    <div class="box">
                        <form name="loginForm" action="login.php" method="POST">
                            <img class="img-logo" src="../dist/img/sevoto.png" class="img-fluid mb-3" alt="Logo">
                            <div class="inputBox">
                                <div class="form-group">
                                    <label for="usuario" class="label"><b>Usuario</b></label>
                                    <input type="text" name="username"required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="label"><b>Contraseña</b></label>
                                    <input type="password" class="form-control" name="password"required autocomplete="off">
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
<?php include 'includes/scripts.php' ?>
</body>
</html>