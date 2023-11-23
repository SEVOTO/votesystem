<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
<script src="dist/js/sweetalert2@11.js"></script>
<script src="dist/js/captcha.js"></script>
<script>
	document.addEventListener('DOMContentLoaded', function () {
    showCaptchaAlert();
});
document.addEventListener('DOMContentLoaded', function () {
    disableCopyPaste();
});

function disableCopyPaste() {
    var body = document.getElementsByTagName('body')[0];
    body.oncopy = function (event) {
        event.preventDefault();
    };
    body.onpaste = function (event) {
        event.preventDefault();
    };
}
let captchaGenerated;

function generateCaptcha() {
    let chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let captcha = '';
    for (let i = 0; i < 6; i++) {
        captcha += chars[Math.floor(Math.random() * chars.length)];
    }
    captchaGenerated = captcha;
    return captcha;
}

function showCaptchaAlert() {
    generateCaptcha();
    Swal.fire({
        title: '<h1>Por favor, ingrese el captcha:</h1>',
        html: '<h3>Captcha generado:</h3> <strong style="font-size: 5em;background-color: #1a1a1a; padding: 1px; border-radius: 10px; color: white;">' + captchaGenerated + '</strong>',
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off',
            autocorrect: 'off',
            autofocus: 'on',
            required: 'required',
        },
        confirmButtonText: '<h4>Verificar</h4>',
        allowOutsideClick: () => false, // Previene que el usuario salga del cuadro pulsando fuera
        showLoaderOnConfirm: true,
        preConfirm: (inputCaptcha) => {
            if (inputCaptcha.toLowerCase() === captchaGenerated.toLowerCase()) {
                Swal.fire({
                    title: 'Correcto!',
                    icon: 'success',
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'El captcha ingresado es incorrecto.',
                    icon: 'error',
                });
                window.location.href = 'logout.php';
            }
        },
    });
}
</script>
<script>
        var timeoutID;
        var counter = 300; // 5 minutes in seconds
        var resetCounter = 150; // 3 minutes in seconds
        var timerReset = false;

        function startTimer() {
            timeoutID = window.setInterval(function() {
                counter--;
                var minutes = Math.floor(counter / 60);
                var seconds = counter % 60;

                if (minutes < 0 || seconds < 0) {
                    clearInterval(timeoutID);
                    logout();
                } else if (counter <= 30 && !timerReset) {
                    Swal.fire({
                        title: 'Sesión expirando',
                        text: 'Tiempo restante: ' + minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0'),
                        showConfirmButton: true,
                        confirmButtonText: 'Extender sesión'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            counter = resetCounter;
                            timerReset = true;
                        }
                    });
                    timerReset = true;
                }

                // Update time counter display
                document.getElementById('timer').textContent = minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0');
            }, 1000);
        }

        function logout() {
            Swal.fire({
                icon: 'error',
                title: 'Sesión cerrada',
                text: 'Su sesión ha expirado.'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "logout.php"; // Replace with your actual logout URL
                }
            });
        }

        startTimer();
</script>
<div class="wrapper">

	<?php include 'includes/navbar.php'; ?>
	 
	  <div class="content-wrapper">
	    <div class="container">

	      <!-- Main content -->
	      <section class="content">
	      	<?php
	      		$parse = parse_ini_file('admin/config.ini', FALSE, INI_SCANNER_RAW);
    			$title = $parse['election_title'];
	      	?>
	      	<h1 class="page-header text-center title"><b><?php echo strtoupper($title); ?></b></h1>
			<h1 class="page-header text-center title">Tiempo Restante:</h1>
			<h1 id="timer" class="page-header text-center title"></h1>

	        <div class="row">
	        	<div class="col-sm-10 col-sm-offset-1">
	        		<?php
				        if(isset($_SESSION['error'])){
				        	?>
				        	<div class="alert alert-danger alert-dismissible">
				        		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					        	<ul>
					        		<?php
					        			foreach($_SESSION['error'] as $error){
					        				echo "
					        					<li>".$error."</li>
					        				";
					        			}
					        		?>
					        	</ul>
		
					        </div>
				        	<?php
				         	unset($_SESSION['error']);

				        }
				        if(isset($_SESSION['success'])){
				          	echo "
				            	<div class='alert alert-success alert-dismissible'>
				              		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				              		<h4><i class='icon fa fa-check'></i> Success!</h4>
				              	".$_SESSION['success']."
				            	</div>
				          	";
				          	unset($_SESSION['success']);
				        }

				    ?>
 
				    <div class="alert alert-danger alert-dismissible" id="alert" style="display:none;">
		        		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			        	<span class="message"></span>
			        </div>

				    <?php
				    	$sql = "SELECT * FROM votes WHERE voters_id = '".$voter['id']."'";
				    	$vquery = $conn->query($sql);
				    	if($vquery->num_rows > 0){
				    		?>
				    		<div class="text-center">
					    		<h3>Ya usted participo en esta eleccion.</h3>
					    		<a href="#view" data-toggle="modal" class="btn btn-flat btn-primary btn-lg">Ver voto realizado</a>
					    	</div>
				    		<?php
				    	}
				    	else{
				    		?>
			    			<!-- Voting Ballot -->
						    <form method="POST" id="ballotForm" action="submit_ballot.php">
				        		<?php
				        			include 'includes/slugify.php';

				        			$candidate = '';
				        			$sql = "SELECT * FROM positions ORDER BY priority ASC";
									$query = $conn->query($sql);
									while($row = $query->fetch_assoc()){
										$sql = "SELECT * FROM candidates WHERE position_id='".$row['id']."'";
										$cquery = $conn->query($sql);
										while($crow = $cquery->fetch_assoc()){
											$slug = slugify($row['description']);
											$checked = '';
											if(isset($_SESSION['post'][$slug])){
												$value = $_SESSION['post'][$slug];

												if(is_array($value)){
													foreach($value as $val){
														if($val == $crow['id']){
															$checked = 'checked';
														}
													}
												}
												else{
													if($value == $crow['id']){
														$checked = 'checked';
													}
												}
											}
											$input = ($row['max_vote'] > 1) ? '<input type="checkbox" class="flat-red '.$slug.'" name="'.$slug."[]".'" value="'.$crow['id'].'" '.$checked.'>' : '<input type="radio" class="flat-red '.$slug.'" name="'.slugify($row['description']).'" value="'.$crow['id'].'" '.$checked.'>';
											$image = (!empty($crow['photo'])) ? 'images/'.$crow['photo'] : 'images/profile.jpg';
											$candidate .= '
												<li>
													'.$input.'<img src="'.$image.'" height="100px" width="100px" class="clist"><span class="cname clist">'.$crow['firstname'].' '.$crow['lastname'].'</span>
												</li>
											';
										}

										$instruct = ($row['max_vote'] > 1) ? 'Usted a seleccionado al candidato:  '.$row['max_vote'].' candidates' : 'Selecciona solo un candidato';

										echo '
											<div class="row">
												<div class="col-xs-12">
													<div class="box box-solid" id="'.$row['id'].'">
														<div class="box-header with-border">
															<h3 class="box-title"><b>'.$row['description'].'</b></h3>
														</div>
														<div class="box-body">
															<p>'.$instruct.'
																<span class="pull-right">
																	<button type="button" class="btn btn-success btn-sm btn-flat reset" data-desc="'.slugify($row['description']).'"><i class="fa fa-refresh"></i> Reiniciar</button>
																</span>
															</p>
															<div id="candidate_list">
																<ul>
																	'.$candidate.'
																</ul>
															</div>
														</div>
													</div>
												</div>
											</div>
										';

										$candidate = '';

									}	

				        		?>
				        		<div class="text-center">
					        		<button type="button" class="btn btn-success btn-flat" id="preview"><i class="fa fa-file-text"></i> Vista previa</button> 
					        		<button type="submit" class="btn btn-primary btn-flat" name="vote"><i class="fa fa-check-square-o"></i> Votar</button>
					        	
								</div>
				        	</form>

				        	<!-- End Voting Ballot -->
				    		<?php
				    	}

				    ?>

	        	</div>
	        </div>
	      </section>
	     
	    </div>
	  </div>
  
  	<?php include 'includes/footer.php'; ?>
  	<?php include 'includes/ballot_modal.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
	$('.content').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass: 'iradio_flat-green'
	});

	$(document).on('click', '.reset', function(e){
	    e.preventDefault();
	    var desc = $(this).data('desc');
	    $('.'+desc).iCheck('uncheck');
	});

	$(document).on('click', '.platform', function(e){
		e.preventDefault();
		$('#platform').modal('show');
		var platform = $(this).data('platform');
		var fullname = $(this).data('fullname');
		$('.candidate').html(fullname);
		$('#plat_view').html(platform);
	});

	$('#preview').click(function(e){
		e.preventDefault();
		var form = $('#ballotForm').serialize();
		if(form == ''){
			$('.message').html('Solo puedes votar por un candidato');
			$('#alert').show();
		}
		else{
			$.ajax({
				type: 'POST',
				url: 'preview.php',
				data: form,
				dataType: 'json',
				success: function(response){
					if(response.error){
						var errmsg = '';
						var messages = response.message;
						for (i in messages) {
							errmsg += messages[i]; 
						}
						$('.message').html(errmsg);
						$('#alert').show();
					}
					else{
						$('#preview_modal').modal('show');
						$('#preview_body').html(response.list);
					}
				}
			});
		}
		
	});

});
</script>
</body>
</html>