<?php
include('includes/conn.php');
include('includes/header.php');

$search_text = $_POST['search_text'];

$sql = "SELECT * FROM voters WHERE voters_id LIKE '$search_text%'";
$result = $conn->query($sql);

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo '
                        <div class="form-group">
                            <label for="firstname" class="col-sm-3 control-label">Nombre</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="firstname" name="firstname" value="'.$row['firstname'].'" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lastname" class="col-sm-3 control-label">Apellido</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="lastname" name="lastname" value="'.$row['lastname'].'" readonly>
                            </div>
                        </div>
';
    }
} else {
    echo "<div class='item active'>";
    echo "<div class='container'><div class='carousel-caption'>";
    echo "<h1 style= 'font-size:70px; background-color: #000; border-radius: 10px;'>No se encontraron resultados</h1>";
    echo "</div></div>";
    echo "</div>";
}
?>
