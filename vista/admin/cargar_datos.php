<!DOCTYPE html>
<html>
<head>
    <title>Cargar Datos Masivos</title>
</head>
<body>
    <h1>Cargar Datos Masivos</h1>
    <form action="procesar_datos.php" method="POST" enctype="multipart/form-data">
        <label for="archivo">Archivo Excel:</label>
        <input type="file" name="archivo" required><br>

        <input type="submit" value="Cargar">
    </form>
</body>
</html>
