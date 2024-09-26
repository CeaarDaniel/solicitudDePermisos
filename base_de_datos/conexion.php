<?php 
 $dsn= "sqlsrv:Server=mx-server04\beyonzmex;Database=BEYONZ"; 
 //date_default_timezone_set('Etc/GMT+6'); //Establece la zona horaria por defecto, se mueve 6 horas tomando como referecia el meridiano, esto seria lo equivalente a la zona horaria de mexico sin cambio de horario
 $usuario= "sa";
 $contraseña ="BYZ@en2o";

 try {
    $conn = new PDO($dsn, $usuario, $contraseña);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar a SQL Server: " . $e->getMessage());
}
?>