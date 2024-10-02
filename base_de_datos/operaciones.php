<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-Type: application/json');

//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;
//use PHPMailer\PHPMailer\Exception;
//require 'PHPMailer/src/PHPMailer.php';
//require 'PHPMailer/src/SMTP.php';
//require 'PHPMailer/src/Exception.php';
include('./conexion.php');

$opcion = $_POST['opcion'];

if($opcion=='1'){
    $numero_de_nomina =  isset($_POST['NN']) ? $_POST['NN'] : '';
    $sn = "select* from empleado where id_usuario = :numero_de_nomina and estatus='1'"; 
    $consulta = $conn->prepare($sn);
    $consulta->bindParam(':numero_de_nomina', $numero_de_nomina);
 
     if ($consulta->execute()) {
              if( $res = $consulta->fetch(PDO::FETCH_ASSOC))
               $respuesta = array('ok' => true,
                            'usuario' => $res['usuario'],
                            'area' => $res['area'],
                            'puesto'=> $res['puesto'],
                            'estatus'=> $res['estatus']
                           );  
         
               else  $respuesta = array('ok' => false);
       }

    else 
       $respuesta = array('ok'=> $stmt->errorInfo()[2]);
   
   echo json_encode($respuesta);
}

//Registrar viaje de trabajo
   else if($opcion=='2'){
         $NN =  isset($_POST['NN']) ? $_POST['NN'] : '';
         $NOMBRE =  isset($_POST['NOMBRE']) ? $_POST['NOMBRE'] : '';
         $DEPARTAMENTO =  isset($_POST['DEPARTAMENTO']) ? $_POST['DEPARTAMENTO'] : '';
         $CODIGO_SHOP = isset($_POST['CODIGO_SHOP']) ? $_POST['CODIGO_SHOP'] : '';
         $FECHA_SOLICITUD=  isset($_POST['FECHA_SOLICITUD']) ? $_POST['FECHA_SOLICITUD'] : '';
         $FECHA_PERMISOA=  isset($_POST['FECHA_PERMISOA']) ? $_POST['FECHA_PERMISOA'] : NULL;
         $FECHA_PERMISOB = isset($_POST['FECHA_PERMISOB']) ? $_POST['FECHA_PERMISOB'] : NULL;
         $HORA1 =  isset($_POST['HORA1']) ? $_POST['HORA1'] : NULL;
         $HORA2 =  isset($_POST['HORA2']) ? $_POST['HORA2'] : '';
         $CIUDAD =  isset($_POST['CIUDAD']) ? $_POST['CIUDAD'] : '';
         $LUGAR =  isset($_POST['LUGAR']) ? $_POST['LUGAR'] : '';
         $MOTIVO =  isset($_POST['MOTIVO']) ? $_POST['MOTIVO'] : '';
         $GASTOS =  isset($_POST['GASTOS']) ? $_POST['GASTOS'] : '';
         $CASETAS =  isset($_POST['CASETAS']) ? $_POST['CASETAS'] : '';
         $GASOLINA =  isset($_POST['GASOLINA']) ? $_POST['GASOLINA'] : '';
         $HOTEL =  isset($_POST['HOTEL']) ? $_POST['HOTEL'] : '';
         $COMIDAS =  isset($_POST['COMIDAS']) ? $_POST['COMIDAS'] : '';
         $TAXI =  isset($_POST['TAXI']) ? $_POST['TAXI'] : '';
         $OTROS =  isset($_POST['OTROS']) ? $_POST['OTROS'] : ''; 
         $TOTAL =  isset($_POST['TOTAL']) ? $_POST['TOTAL'] : '';
         $CANTDIAS =  isset($_POST['CANTDIAS']) ? $_POST['CANTDIAS'] : '';
  
         $sql = "INSERT INTO ViajeTrabajo (NN, NOMBRE, DEPARTAMENTO, CODIGO_SHOP, FECHA_SOLICITUD, FECHA_PERMISOA, FECHA_PERMISOB, HORA1, HORA2, CIUDAD, LUGAR, MOTIVO, GASTOS, CASETAS, GASOLINA, HOTEL, COMIDAS, TAXI, OTROS, TOTAL, CANTDIAS) 
         VALUES (:NN, :NOMBRE, :DEPARTAMENTO, :CODIGO_SHOP, :FECHA_SOLICITUD, :FECHA_PERMISOA, :FECHA_PERMISOB, :HORA1, :HORA2, :CIUDAD, :LUGAR, :MOTIVO, :GASTOS, :CASETAS, :GASOLINA, :HOTEL, :COMIDAS, :TAXI, :OTROS, :TOTAL, :CANTDIAS)";

         $stmt = $conn->prepare($sql);


         $stmt->bindParam(':NN',$NN);
         $stmt->bindParam(':NOMBRE',$NOMBRE);
         $stmt->bindParam(':DEPARTAMENTO',$DEPARTAMENTO);
         $stmt->bindParam(':CODIGO_SHOP',$CODIGO_SHOP);
         $stmt->bindParam(':FECHA_SOLICITUD',$FECHA_SOLICITUD);
         $stmt->bindParam(':FECHA_PERMISOA',$FECHA_PERMISOA);
         $stmt->bindParam(':FECHA_PERMISOB',$FECHA_PERMISOB);
         $stmt->bindParam(':HORA1',$HORA1);
         $stmt->bindParam(':HORA2',$HORA2);
         $stmt->bindParam(':CIUDAD',$CIUDAD);
         $stmt->bindParam(':LUGAR',$LUGAR);
         $stmt->bindParam(':MOTIVO',$MOTIVO);
         $stmt->bindParam(':GASTOS',$GASTOS);
         $stmt->bindParam(':CASETAS',$CASETAS);
         $stmt->bindParam(':GASOLINA',$GASOLINA);
         $stmt->bindParam(':HOTEL',$HOTEL);
         $stmt->bindParam(':COMIDAS',$COMIDAS);
         $stmt->bindParam(':TAXI',$TAXI);
         $stmt->bindParam(':OTROS',$OTROS);
         $stmt->bindParam(':TOTAL',$TOTAL);
         $stmt->bindParam(':CANTDIAS',$CANTDIAS);
         
         // Ejecuta la consulta
         if ($stmt->execute()) {
               $lastID = $conn->lastInsertId();
               $respuesta = array('OK' => "Se han capturado los datos",
                                  'ID' => $lastID
                                 );
         } else {
               $respuesta = array('error' => $stmt->errorInfo()[2]);
         }           
   

   echo json_encode($respuesta);
}

//Registro de Salida de trabajo
else if($opcion=='3'){
   $NN =  isset($_POST['NN']) ? $_POST['NN'] : '';
   $NOMBRE =  isset($_POST['NOMBRE']) ? $_POST['NOMBRE'] : '';
   $DEPARTAMENTO =  isset($_POST['DEPARTAMENTO']) ? $_POST['DEPARTAMENTO'] : '';
   $CODIGO_SHOP = isset($_POST['CODIGO_SHOP']) ? $_POST['CODIGO_SHOP'] : '';
   $FECHA_SOLICITUD=  isset($_POST['FECHA_SOLICITUD']) ? $_POST['FECHA_SOLICITUD'] : '';
   $FECHA_PERMISOA=  isset($_POST['FECHA_PERMISOA']) ? $_POST['FECHA_PERMISOA'] : NULL;
   $FECHA_PERMISOB = isset($_POST['FECHA_PERMISOB']) ? $_POST['FECHA_PERMISOB'] : NULL;
   $HORA1 =  isset($_POST['HORA1']) ? $_POST['HORA1'] : NULL;
   $HORA2 =  isset($_POST['HORA2']) ? $_POST['HORA2'] : '';
   $CIUDAD =  isset($_POST['CIUDAD']) ? $_POST['CIUDAD'] : '';
   $LUGAR =  isset($_POST['LUGAR']) ? $_POST['LUGAR'] : '';
   $MOTIVO =  isset($_POST['MOTIVO']) ? $_POST['MOTIVO'] : '';

   $sql = "INSERT INTO SalidaTrabajo (NN, NOMBRE, DEPARTAMENTO, CODIGO_SHOP, FECHA_SOLICITUD, FECHA_PERMISOA, FECHA_PERMISOB, HORA1, HORA2, CIUDAD, LUGAR, MOTIVO) 
   VALUES (:NN, :NOMBRE, :DEPARTAMENTO, :CODIGO_SHOP, :FECHA_SOLICITUD, :FECHA_PERMISOA, :FECHA_PERMISOB, :HORA1, :HORA2, :CIUDAD, :LUGAR, :MOTIVO)";

   $stmt = $conn->prepare($sql);


   $stmt->bindParam(':NN',$NN);
   $stmt->bindParam(':NOMBRE',$NOMBRE);
   $stmt->bindParam(':DEPARTAMENTO',$DEPARTAMENTO);
   $stmt->bindParam(':CODIGO_SHOP',$CODIGO_SHOP);
   $stmt->bindParam(':FECHA_SOLICITUD',$FECHA_SOLICITUD);
   $stmt->bindParam(':FECHA_PERMISOA',$FECHA_PERMISOA);
   $stmt->bindParam(':FECHA_PERMISOB',$FECHA_PERMISOB);
   $stmt->bindParam(':HORA1',$HORA1);
   $stmt->bindParam(':HORA2',$HORA2);
   $stmt->bindParam(':CIUDAD',$CIUDAD);
   $stmt->bindParam(':LUGAR',$LUGAR);
   $stmt->bindParam(':MOTIVO',$MOTIVO);
   
   // Ejecuta la consulta
   if ($stmt->execute()) {
         $lastID = $conn->lastInsertId();
         $respuesta = array('OK' => "Se han capturado los datos", 
                            'ID' => $lastID
                           );
   } else {
         $respuesta = array('error' => $stmt->errorInfo()[2]);
   }           


echo json_encode($respuesta);
}

//Registro de salida personal
else if($opcion=='4'){
   $NN =  isset($_POST['NN']) ? $_POST['NN'] : '';
   $NOMBRE =  isset($_POST['NOMBRE']) ? $_POST['NOMBRE'] : '';
   $DEPARTAMENTO =  isset($_POST['DEPARTAMENTO']) ? $_POST['DEPARTAMENTO'] : '';
   $CODIGO_SHOP = isset($_POST['CODIGO_SHOP']) ? $_POST['CODIGO_SHOP'] : '';
   $FECHA_SOLICITUD=  isset($_POST['FECHA_SOLICITUD']) ? $_POST['FECHA_SOLICITUD'] : '';
   $FECHA_PERMISOA=  isset($_POST['FECHA_PERMISOA']) ? $_POST['FECHA_PERMISOA'] : NULL;
   $FECHA_PERMISOB = isset($_POST['FECHA_PERMISOB']) ? $_POST['FECHA_PERMISOB'] : NULL;
   $HORA1 =  isset($_POST['HORA1']) ? $_POST['HORA1'] : NULL;
   $HORA2 =  isset($_POST['HORA2']) ? $_POST['HORA2'] : '';
   $MOTIVO =  isset($_POST['MOTIVO']) ? $_POST['MOTIVO'] : '';

   $sql = "INSERT INTO SalidaPersonal(NN, NOMBRE, DEPARTAMENTO, CODIGO_SHOP, FECHA_SOLICITUD, FECHA_PERMISOA, FECHA_PERMISOB, HORA1, HORA2, MOTIVO) 
   VALUES (:NN, :NOMBRE, :DEPARTAMENTO, :CODIGO_SHOP, :FECHA_SOLICITUD, :FECHA_PERMISOA, :FECHA_PERMISOB, :HORA1, :HORA2, :MOTIVO)";

   $stmt = $conn->prepare($sql);


   $stmt->bindParam(':NN',$NN);
   $stmt->bindParam(':NOMBRE',$NOMBRE);
   $stmt->bindParam(':DEPARTAMENTO',$DEPARTAMENTO);
   $stmt->bindParam(':CODIGO_SHOP',$CODIGO_SHOP);
   $stmt->bindParam(':FECHA_SOLICITUD',$FECHA_SOLICITUD);
   $stmt->bindParam(':FECHA_PERMISOA',$FECHA_PERMISOA);
   $stmt->bindParam(':FECHA_PERMISOB',$FECHA_PERMISOB);
   $stmt->bindParam(':HORA1',$HORA1);
   $stmt->bindParam(':HORA2',$HORA2);
   $stmt->bindParam(':MOTIVO',$MOTIVO);
   
   // Ejecuta la consulta
   if ($stmt->execute()) {
         $lastID = $conn->lastInsertId();
         $respuesta = array('OK' => "Se han capturado los datos",
                            'ID' => $lastID,
                           );
   } else {
         $respuesta = array('error' => $stmt->errorInfo()[2]);
   }           


echo json_encode($respuesta);
}

//Registro de permuta
else if($opcion=='5'){
      $NN =  isset($_POST['NN']) ? $_POST['NN'] : '';
      $NOMBRE =  isset($_POST['NOMBRE']) ? $_POST['NOMBRE'] : '';
      $DEPARTAMENTO =  isset($_POST['DEPARTAMENTO']) ? $_POST['DEPARTAMENTO'] : '';
      $CODIGO_SHOP = isset($_POST['CODIGO_SHOP']) ? $_POST['CODIGO_SHOP'] : '';
      $FECHA_SOLICITUD=  isset($_POST['FECHA_SOLICITUD']) ? $_POST['FECHA_SOLICITUD'] : '';
      $FECHA_PERMISOA=  isset($_POST['FECHA_PERMISOA']) ? $_POST['FECHA_PERMISOA'] : NULL;
      $FECHA_PERMISOB = isset($_POST['FECHA_PERMISOB']) ? $_POST['FECHA_PERMISOB'] : NULL;
      $HORA1 =  isset($_POST['HORA1']) ? $_POST['HORA1'] : NULL;
      $HORA2 =  isset($_POST['HORA2']) ? $_POST['HORA2'] : '';
      $MOTIVO =  isset($_POST['MOTIVO']) ? $_POST['MOTIVO'] : '';
      $FECHAPERMU1 =  isset($_POST['FECHAPERMU1']) ? $_POST['FECHAPERMU1'] : '';
      $HORARIOPERMU1 =  isset($_POST['HORARIOPERMU1']) ? $_POST['HORARIOPERMU1'] : '';
      $HORARIOPERMU2 =  isset($_POST['HORARIOPERMU2']) ? $_POST['HORARIOPERMU2'] : '';
      $HORARIOPERMU3 =  isset($_POST['HORARIOPERMU3']) ? $_POST['HORARIOPERMU3'] : NULL;
      $HORARIOPERMU4 =  isset($_POST['HORARIOPERMU4']) ? $_POST['HORARIOPERMU4'] : NULL;
      $HORARIOPERMU5 =  isset($_POST['HORARIOPERMU5']) ? $_POST['HORARIOPERMU5'] : NULL;
      $HORARIOPERMU6 =  isset($_POST['HORARIOPERMU6']) ? $_POST['HORARIOPERMU6'] : NULL;
      $HRSTRABAJADAS1 =  isset($_POST['HRSTRABAJADAS1']) ? $_POST['HRSTRABAJADAS1'] : '';
      $HRSTRABAJADAS2 =  isset($_POST['HRSTRABAJADAS2']) ? $_POST['HRSTRABAJADAS2'] : '0.0';
      $HRSTRABAJADAS3 =  isset($_POST['HRSTRABAJADAS3']) ? $_POST['HRSTRABAJADAS3'] : '0.0';
      $SOLICITADO =  isset($_POST['SOLICITADO']) ? $_POST['SOLICITADO'] : '';
      $TOTALHRSACUMU =  isset($_POST['TOTALHRSACUMU']) ? $_POST['TOTALHRSACUMU'] : '';
   
      $FECHA_SOLICITUD = (DateTime::createFromFormat('Y-m-d\TH:i', $FECHA_SOLICITUD))->format('Y-m-d H:i:s');
      
         if($_POST['FECHAPERMU2']== null || $_POST['FECHAPERMU2']=='' || empty($_POST['FECHAPERMU2']))
               $FECHAPERMU2 = NULL;
   
         else 
               $FECHAPERMU2 =  $_POST['FECHAPERMU2'];
   
         if($_POST['FECHAPERMU3']== null || $_POST['FECHAPERMU3']=='' || empty($_POST['FECHAPERMU3']))
               $FECHAPERMU3 = NULL;
   
         else 
               $FECHAPERMU3 =  $_POST['FECHAPERMU3'];
   
      $solapamiento1= "";
      $solapamiento2= "";
      $solapamiento3= "";

      $fecha_inicio_1=$FECHAPERMU1.' '.$HORARIOPERMU1;

      if($HORARIOPERMU1 <= $HORARIOPERMU2) 
            $fecha_fin_1= $FECHAPERMU1.' '.$HORARIOPERMU2;
      else    
            $fecha_fin_1= date('Y-m-d', strtotime($FECHAPERMU1 . '+1 day')).' '.$HORARIOPERMU2; 
   
        $verfp1="EXECUTE validarPermuta @NN= '".$NN."', @solapamiento = 0, @fecha_inicio='".$fecha_inicio_1."', @fecha_fin = '".$fecha_fin_1."'";
        $vp1 = $conn->prepare($verfp1);

        if ($vp1->execute())
            $solapamiento1 = $vp1->fetch();

        else  
            $solapamiento1 = $vp1->errorInfo()[2];   
   
         if ($FECHAPERMU2!= NULL){

            $fecha_inicio_2=$FECHAPERMU2.' '.$HORARIOPERMU3;

                  if($HORARIOPERMU3 <= $HORARIOPERMU4) 
                        $fecha_fin_2= $FECHAPERMU2.' '.$HORARIOPERMU4;
                  else    
                        $fecha_fin_2= date('Y-m-d', strtotime($FECHAPERMU2 . '+1 day')).' '.$HORARIOPERMU4; 

                       $verfp2="EXECUTE validarPermuta @NN= '".$NN."', @solapamiento = 0, @fecha_inicio='".$fecha_inicio_2."', @fecha_fin = '".$fecha_fin_2."'";
                       $vp2 = $conn->prepare($verfp2);
               
                       if ($vp2->execute())
                           $solapamiento2 = $vp2->fetch();
               
                       else  
                           $solapamiento2 = $vp2->errorInfo()[2];  
                     }
   
                     else $solapamiento2= array ('total_solapamientos' => 0);
   
         if ($FECHAPERMU3!= NULL)
               {  
                  $fecha_inicio_3=$FECHAPERMU3.' '.$HORARIOPERMU5;

                  if($HORARIOPERMU5 <= $HORARIOPERMU6) 
                        $fecha_fin_3= $FECHAPERMU3.' '.$HORARIOPERMU6;
                  else    
                        $fecha_fin_3= date('Y-m-d', strtotime($FECHAPERMU3 . '+1 day')).' '.$HORARIOPERMU6;

                  $verfp3="EXECUTE validarPermuta @NN= '".$NN."', @solapamiento = 0, @fecha_inicio='".$fecha_inicio_3."', @fecha_fin = '".$fecha_fin_3."'";
                  $vp3 = $conn->prepare($verfp3);
            
                  if ($vp3->execute())
                        $solapamiento3 = $vp3->fetch();
            
                  else  
                        $solapamiento3= $vp3->errorInfo()[2];  
               }
   
               else $solapamiento3= array ('total_solapamientos' => 0);
   
               if ($solapamiento1['total_solapamientos'] > 0 || $solapamiento2['total_solapamientos'] > 0 || $solapamiento3['total_solapamientos'] > 0)
                       echo json_encode("La hora seleccionada para alguna de las permutas ya ha sidio usada en algun otro permiso de permuta");
   
               else 
               {

                  try {
                        $dsn2= "sqlsrv:Server=mx-server04\beyonzmex;Database=security_db"; 
                        $usuario2= "sa";
                        $contraseña2 ="BYZ@en2o";
                        $conn_securitydb = new PDO($dsn2, $usuario2, $contraseña2);
                        $conn_securitydb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        
                        $num_filas=0;
                        $num_filas2=1;
                        $num_filas3=1;
                        
                        $verfasis = "select* from hep_transaction where pin ='".$NN."' and event_date ='".$FECHAPERMU1."'";
                        $va= $conn_securitydb->prepare($verfasis);
                        $va->execute();
                        $consulta= $va->fetchALL();
                        $num_filas = count($consulta);
                        
                        if($FECHAPERMU2!=null){
                              $verfasis = "select* from hep_transaction where pin ='".$NN."' and event_date ='".$FECHAPERMU2."'";
                              $va= $conn_securitydb->prepare($verfasis);
                              $va->execute();
                              $consulta= $va->fetchALL();
                              $num_filas2 = count($consulta);
                        }
                        
                        if($FECHAPERMU3!=null){
                              $verfasis = "SELECT* from hep_transaction where pin ='".$NN."' and event_date ='".$FECHAPERMU3."'";
                              $va= $conn_securitydb->prepare($verfasis);
                              $va->execute();
                              $consulta= $va->fetchALL();
                              $num_filas3 = count($consulta);
                        }
                        
                        if($num_filas<=0 || $num_filas2<=0 || $num_filas3<=0) 
                           $respuesta ="No cuenta con registro de asistencia en alguna de las fechas ingresadas para permutar";
         
                           
                           else 
                           {
                                 $sql = "INSERT INTO Permuta2(NN, NOMBRE, DEPARTAMENTO, CODIGO_SHOP, FECHA_SOLICITUD, FECHA_PERMISOA, FECHA_PERMISOB, HORA1, HORA2, MOTIVO,
                                 FECHAPERMU1, HORARIOPERMU1, HORARIOPERMU2, FECHAPERMU2, HORARIOPERMU3, HORARIOPERMU4, FECHAPERMU3, HORARIOPERMU5,
                                 HORARIOPERMU6, HRSTRABAJADAS1_TEMP, HRSTRABAJADAS2_TEMP, HRSTRABAJADAS3_TEMP, SOLICITADO, TOTALHRSACUMU_TEMP) 
                                 VALUES (:NN, :NOMBRE, :DEPARTAMENTO, :CODIGO_SHOP, :FECHA_SOLICITUD, :FECHA_PERMISOA, :FECHA_PERMISOB, :HORA1, :HORA2, :MOTIVO,
                                 :FECHAPERMU1, :HORARIOPERMU1, :HORARIOPERMU2, :FECHAPERMU2, :HORARIOPERMU3, :HORARIOPERMU4, :FECHAPERMU3, :HORARIOPERMU5,
                                 :HORARIOPERMU6, :HRSTRABAJADAS1, :HRSTRABAJADAS2, :HRSTRABAJADAS3, :SOLICITADO, :TOTALHRSACUMU)";
         
                                 $stmt = $conn->prepare($sql);
         
                                 $stmt->bindParam(':NN',$NN);
                                 $stmt->bindParam(':NOMBRE',$NOMBRE);
                                 $stmt->bindParam(':DEPARTAMENTO',$DEPARTAMENTO);
                                 $stmt->bindParam(':CODIGO_SHOP',$CODIGO_SHOP);
                                 $stmt->bindParam(':FECHA_SOLICITUD',$FECHA_SOLICITUD);
                                 $stmt->bindParam(':FECHA_PERMISOA',$FECHA_PERMISOA);
                                 $stmt->bindParam(':FECHA_PERMISOB',$FECHA_PERMISOB);
                                 $stmt->bindParam(':HORA1',$HORA1);
                                 $stmt->bindParam(':HORA2',$HORA2);
                                 $stmt->bindParam(':MOTIVO',$MOTIVO);
                                 $stmt->bindParam(':FECHAPERMU1',$FECHAPERMU1);
                                 $stmt->bindParam(':HORARIOPERMU1',$HORARIOPERMU1);
                                 $stmt->bindParam(':HORARIOPERMU2',$HORARIOPERMU2);
                                 $stmt->bindParam(':FECHAPERMU2',$FECHAPERMU2);
                                 $stmt->bindParam(':HORARIOPERMU3',$HORARIOPERMU3);
                                 $stmt->bindParam(':HORARIOPERMU4',$HORARIOPERMU4);
                                 $stmt->bindParam(':FECHAPERMU3',$FECHAPERMU3);
                                 $stmt->bindParam(':HORARIOPERMU5',$HORARIOPERMU5);
                                 $stmt->bindParam(':HORARIOPERMU6',$HORARIOPERMU6);
                                 $stmt->bindParam(':HRSTRABAJADAS1',$HRSTRABAJADAS1);
                                 $stmt->bindParam(':HRSTRABAJADAS2',$HRSTRABAJADAS2);
                                 $stmt->bindParam(':HRSTRABAJADAS3',$HRSTRABAJADAS3);
                                 $stmt->bindParam(':SOLICITADO',$SOLICITADO);
                                 $stmt->bindParam(':TOTALHRSACUMU',$TOTALHRSACUMU);
         
                                 // Ejecuta la consulta
                                 if ($stmt->execute()) {
                                          $lastID = $conn->lastInsertId();
                                          $respuesta = array('ok' => "Se han capturado los datos",
                                                             'ID' => $lastID
                                                            );
                                 }
                                      
                                 else 
                                       $respuesta = array('error' => $stmt->errorInfo()[2]);
                           }
                       
                  } 
                  
                  catch (PDOException $e) {
                        $respuesta="A ocurrido un error al conectarse a la base de datos";
                    }
               
                 echo json_encode($respuesta);
                     
               }
   
}   


//Obtener datos de SalidaPersonal 
else if($opcion=='6'){
      $sql= "SELECT* from SalidaPersonal";

        $stmt = $conn->prepare($sql);

        $datos = array();
            if($stmt->execute()){
                while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $res['HORA1'] = date('H:i', strtotime($res['HORA1']));
                        $res['HORA2'] = date('H:i', strtotime($res['HORA2']));
                        $boton = '<div class="d-flex flex-row">
                                          <button class="btn btn-danger my-0 mx-1 btn-eliminar" onclick=eliminarRegistro('.$res['ID'].') data-id="'.$res['ID'].'"><i class="fas fa-trash"></i></button> 
                                          <button class="btn btn-primary my-0 mx-1 btn-editar"  
                                                  onclick=editarRegistro(event) 
                                                  data-bs-toggle="modal" 
                                                  data-bs-target="#modalModificar"
                                                  data-id="'.$res['ID'].'"
                                                  data-NN="'.$res['NN'].'"
                                                  data-NOMBRE="'.$res['NOMBRE'].'"
                                                  data-DEPARTAMENTO="'.$res['DEPARTAMENTO'].'"
                                                  data-CODIGO_SHOP="'.$res['CODIGO_SHOP'].'" 
                                                  data-FECHA_SOLICITUD="'.$res['FECHA_SOLICITUD'].'" 
                                                  data-FECHA_PERMISOA="'.$res['FECHA_PERMISOA'].'" 
                                                  data-FECHA_PERMISOB="'.$res['FECHA_PERMISOB'].'" 
                                                  data-HORA1="'.$res['HORA1'].'" 
                                                  data-HORA2="'.$res['HORA2'].'" 
                                                  data-MOTIVO="'.$res['MOTIVO'].'"
                                                  >
                                                  <i class="fas fa-pen"></i></button>
                                          <button class="btn btn-success my-0 mx-1 btn-imprimir" onclick=imprimirRegistro('.$res['ID'].') data-id="'.$res['ID'].'"><i class="fas fa-print"></i></button>
                                    </div>';
                        $res['OPERACIONES']= $boton;

                        $datos[] = array(
                              "ID"=>$res['ID'],
                              "NN"=>$res['NN'],
                              "NOMBRE"=>$res['NOMBRE'],
                              "DEPARTAMENTO"=>$res['DEPARTAMENTO'],
                              "CODIGO_SHOP"=>$res['CODIGO_SHOP'],
                              "FECHA_SOLICITUD"=>$res['FECHA_SOLICITUD'],
                              "FECHA_INICIO"=>$res['FECHA_PERMISOA'],
                              "FECHA_FIN"=>$res['FECHA_PERMISOB'],
                              "DE"=>$res['HORA1'],
                              "A"=>$res['HORA2'],
                              "MOTIVO"=>$res['MOTIVO'],
                              "OPERACIONES" => $boton
                        );
                }
                echo json_encode($datos);
        }
}

//Obtener datos de Permuta
else if($opcion=='7'){
      $sql= "SELECT* from Permuta2";

        $stmt = $conn->prepare($sql);

        $datos = array();
            if($stmt->execute()){
                while($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  $res['HORA1'] = date('H:i', strtotime($res['HORA1']));
                  $res['HORA2'] = date('H:i', strtotime($res['HORA2']));
                  $res['HORARIOPERMU1'] = date('H:i', strtotime($res['HORARIOPERMU1']));
                  $res['HORARIOPERMU2'] = date('H:i', strtotime($res['HORARIOPERMU2']));
                  $res['HORARIOPERMU3'] = date('H:i', strtotime($res['HORARIOPERMU3']));
                  $res['HORARIOPERMU4'] = date('H:i', strtotime($res['HORARIOPERMU4']));
                  $res['HORARIOPERMU5'] = date('H:i', strtotime($res['HORARIOPERMU5']));
                  $res['HORARIOPERMU6'] = date('H:i', strtotime($res['HORARIOPERMU6']));
                  $boton = '<div class="d-flex flex-row">
                                    <button class="btn btn-danger my-0 mx-1 btn-eliminar" onclick=eliminarRegistro('.$res['ID'].') data-id="'.$res['ID'].'"><i class="fas fa-trash"></i></button>
                                    <button class="btn btn-primary my-0 mx-1 btn-editar"  
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalModificar" 
                                            onclick=editarRegistro(event) 
                                            data-id="'.$res['ID'].'"
                                            data-NN="'.$res['NN'].'"
                                            data-NOMBRE="'.$res['NOMBRE'].'"
                                            data-DEPARTAMENTO="'.$res['DEPARTAMENTO'].'"
                                            data-CODIGO_SHOP="'.$res['CODIGO_SHOP'].'" 
                                            data-FECHA_SOLICITUD="'.$res['FECHA_SOLICITUD'].'" 
                                            data-FECHA_PERMISOA="'.$res['FECHA_PERMISOA'].'" 
                                            data-FECHA_PERMISOB="'.$res['FECHA_PERMISOB'].'" 
                                            data-HORA1="'.$res['HORA1'].'" 
                                            data-HORA2="'.$res['HORA2'].'" 
                                            data-MOTIVO="'.$res['MOTIVO'].'"
                                            data-SOLICITADO="'.$res['SOLICITADO'].'"
                                            data-FECHAPERMU1="'.$res['FECHAPERMU1'].'"
                                            data-HORARIOPERMU1="'.$res['HORARIOPERMU1'].'"
                                            data-HORARIOPERMU2="'.$res['HORARIOPERMU2'].'"
                                            data-FECHAPERMU2="'.$res['FECHAPERMU2'].'"
                                            data-HORARIOPERMU3="'.$res['HORARIOPERMU3'].'"
                                            data-HORARIOPERMU4="'.$res['HORARIOPERMU4'].'"
                                            data-FECHAPERMU3="'.$res['FECHAPERMU3'].'"
                                            data-HORARIOPERMU5="'.$res['HORARIOPERMU5'].'"
                                            data-HORARIOPERMU6="'.$res['HORARIOPERMU6'].'"
                                            data-HRSTRABAJADAS1="'.$res['HRSTRABAJADAS1_TEMP'].'"
                                            data-HRSTRABAJADAS2="'.$res['HRSTRABAJADAS2_TEMP'].'"
                                            data-HRSTRABAJADAS3="'.$res['HRSTRABAJADAS3_TEMP'].'"
                                            data-TOTALHRSACUMU="'.$res['TOTALHRSACUMU_TEMP'].'"
                                            >
                                            <i class="fas fa-pen"></i>
                                    </button>
                                    <button class="btn btn-success my-0 mx-1 btn-imprimir" onclick=imprimirRegistro('.$res['ID'].') data-id="'.$res['ID'].'"><i class="fas fa-print"></i></button>
                            </div>';
                  $res['OPERACIONES']= $boton;  
                    $datos[] = array(
                        "id"=>$res['ID'],
                        "NN"=>$res['NN'],
                        "NOMBRE"=>$res['NOMBRE'],
                        "DEPARTAMENTO"=>$res['DEPARTAMENTO'],
                        "CODIGO_SHOP"=>$res['CODIGO_SHOP'], 
                        "FECHA_SOLICITUD"=>$res['FECHA_SOLICITUD'],
                        "FECHA_PERMISOA"=>$res['FECHA_PERMISOA'], 
                        "FECHA_PERMISOB"=>$res['FECHA_PERMISOB'], 
                        "HORA1"=>$res['HORA1'],
                        "HORA2"=>$res['HORA2'], 
                        "MOTIVO"=>$res['MOTIVO'],
                        "SOLICITADO"=>$res['SOLICITADO'],
                        "FECHAPERMU1"=>$res['FECHAPERMU1'],
                        "HORARIOPERMU1"=>$res['HORARIOPERMU1'],
                        "HORARIOPERMU2"=>$res['HORARIOPERMU2'],
                        "FECHAPERMU2"=>$res['FECHAPERMU2'],
                        "HORARIOPERMU3"=>$res['HORARIOPERMU3'],
                        "HORARIOPERMU4"=>$res['HORARIOPERMU4'],
                        "FECHAPERMU3"=>$res['FECHAPERMU3'],
                        "HORARIOPERMU5"=>$res['HORARIOPERMU5'],
                        "HORARIOPERMU6"=>$res['HORARIOPERMU6'],
                        "HRSTRABAJADAS1"=>$res['HRSTRABAJADAS1_TEMP'],
                        "HRSTRABAJADAS2"=>$res['HRSTRABAJADAS2_TEMP'],
                        "HRSTRABAJADAS3"=>$res['HRSTRABAJADAS3_TEMP'],
                        "TOTALHRSACUMU"=>$res['TOTALHRSACUMU_TEMP'],
                        "OPERACIONES" => $res['OPERACIONES']
                    );
                }                
                echo json_encode($datos);
        }
}

//Obtener datos de Salida de trabajo 
else if($opcion=='8'){
      $sql= "SELECT* from SalidaTrabajo";

        $stmt = $conn->prepare($sql);

        $datos = array();
            if($stmt->execute()){
                while($res = $stmt->fetch(PDO::FETCH_ASSOC)){ 
                  $res['HORA1'] = date('H:i', strtotime($res['HORA1']));
                  $res['HORA2'] = date('H:i', strtotime($res['HORA2']));
                  $boton = '<div class="d-flex flex-row">
                                    <button class="btn btn-danger my-0 mx-1 btn-eliminar" onclick=eliminarRegistro('.$res['ID'].') data-id="'.$res['ID'].'"><i class="fas fa-trash"></i></button>
                                    <button class="btn btn-primary my-0 mx-1 btn-editar"  
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalModificar" 
                                            onclick=editarRegistro(event) 
                                            data-id="'.$res['ID'].'"
                                            data-NN="'.$res['NN'].'"
                                            data-NOMBRE="'.$res['NOMBRE'].'"
                                            data-DEPARTAMENTO="'.$res['DEPARTAMENTO'].'"
                                            data-CODIGO_SHOP="'.$res['CODIGO_SHOP'].'" 
                                            data-FECHA_SOLICITUD="'.$res['FECHA_SOLICITUD'].'" 
                                            data-FECHA_PERMISOA="'.$res['FECHA_PERMISOA'].'" 
                                            data-FECHA_PERMISOB="'.$res['FECHA_PERMISOB'].'" 
                                            data-HORA1="'.$res['HORA1'].'" 
                                            data-HORA2="'.$res['HORA2'].'" 
                                            data-MOTIVO="'.$res['MOTIVO'].'"
                                            data-CIUDAD="'.$res['CIUDAD'].'"
                                            data-LUGAR="'.$res['LUGAR'].'"
                                            >
                                          <i class="fas fa-pen"></i>
                                    </button>
                                    <button class="btn btn-success my-0 mx-1 btn-imprimir" onclick=imprimirRegistro('.$res['ID'].') data-id="'.$res['ID'].'"><i class="fas fa-print"></i></button>
                              </div>';
                  $res['OPERACIONES']= $boton;  
                    $datos[] = $res;
                  }
                
                echo json_encode($datos);
        }
}

//Obtener datos de Viaje de trabajo
else if($opcion=='9'){
      $sql= "SELECT* from ViajeTrabajo";

        $stmt = $conn->prepare($sql);

        $datos = array(); 
            if($stmt->execute()){
                while($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  $res['HORA1'] = date('H:i', strtotime($res['HORA1']));
                  $res['HORA2'] = date('H:i', strtotime($res['HORA2']));
                     $boton = '<div class="d-flex flex-row">
                                    <button class="btn btn-danger my-0 mx-1 btn-eliminar" onclick=eliminarRegistro('.$res['ID'].') data-id="'.$res['ID'].'"><i class="fas fa-trash"></i></button>
                                    <button class="btn btn-primary my-0 mx-1 btn-editar" 
                                          data-bs-toggle="modal" 
                                          data-bs-target="#modalModificar" 
                                          onclick=editarRegistro(event)
                                          data-id="'.$res['ID'].'"
                                          data-NN="'.$res['NN'].'"
                                          data-NOMBRE="'.$res['NOMBRE'].'"
                                          data-DEPARTAMENTO="'.$res['DEPARTAMENTO'].'"
                                          data-CODIGO_SHOP="'.$res['CODIGO_SHOP'].'" 
                                          data-FECHA_SOLICITUD="'.$res['FECHA_SOLICITUD'].'" 
                                          data-FECHA_PERMISOA="'.$res['FECHA_PERMISOA'].'" 
                                          data-FECHA_PERMISOB="'.$res['FECHA_PERMISOB'].'" 
                                          data-HORA1="'.$res['HORA1'].'" 
                                          data-HORA2="'.$res['HORA2'].'" 
                                          data-MOTIVO="'.$res['MOTIVO'].'"
                                          data-CANTDIAS="'.$res['CANTDIAS'].'"
                                          data-CIUDAD="'.$res['CIUDAD'].'"
                                          data-LUGAR="'.$res['LUGAR'].'"
                                          data-GASTOS="'.$res['GASTOS'].'"
                                          data-CASETAS="'.$res['CASETAS'].'"
                                          data-GASOLINA="'.$res['GASOLINA'].'"
                                          data-HOTEL="'.$res['HOTEL'].'"
                                          data-COMIDAS="'.$res['COMIDAS'].'"
                                          data-TAXI="'.$res['TAXI'].'"
                                          data-OTROS="'.$res['OTROS'].'"
                                          data-TOTAL="'.$res['TOTAL'].'"
                                          >
                                          <i class="fas fa-pen"></i>
                                    </button>
                                    <button class="btn btn-success my-0 mx-1 btn-imprimir" onclick=imprimirRegistro('.$res['ID'].') data-id="'.$res['ID'].'"><i class="fas fa-print"></i></button>
                               </div>';

                  $datos[] = array(
                        "ID"=>$res['ID'],
                        "NN"=>$res['NN'],
                        "NOMBRE"=>$res['NOMBRE'],
                        "DEPARTAMENTO"=>$res['DEPARTAMENTO'],
                        "CODIGO_SHOP"=>$res['CODIGO_SHOP'],
                        "FECHA_SOLICITUD"=>$res['FECHA_SOLICITUD'],
                        "FECHA_INICIO"=>$res['FECHA_PERMISOA'],
                        "FECHA_FIN"=>$res['FECHA_PERMISOB'],
                        "DE"=>$res['HORA1'],
                        "A"=>$res['HORA2'],
                        "DIAS"=>$res['CANTDIAS'],
                        "CIUDAD"=>$res['CIUDAD'],
                        "LUGAR"=>$res['LUGAR'],
                        "MOTIVO"=>$res['MOTIVO'],
                        "GASTOS"=>$res['GASTOS'],
                        "CASETAS"=>$res['CASETAS'],
                        "GASOLINA"=>$res['GASOLINA'],
                        "HOTEL"=>$res['HOTEL'],
                        "COMIDAS"=>$res['COMIDAS'],
                        "TAXI"=>$res['TAXI'],
                        "OTROS"=>$res['OTROS'],
                        "TOTAL"=>$res['TOTAL'],
                        "OPERACIONES" => $boton
                  );

                  
                }

               
                
                echo json_encode($datos);
        }
}

//Eliminar registro
else if ($opcion=='10'){
  $id = $_POST['id'];
  $tipoPermiso = $_POST['tipoPermiso'];
  $sql="";

  if($tipoPermiso == '6') $sql="delete from SalidaPersonal where id = :id";
  else if($tipoPermiso == '7') $sql="delete from Permuta2 where id = :id";
  else if($tipoPermiso == '8') $sql="delete from SalidaTrabajo where id = :id";
  else if($tipoPermiso == '9') $sql="delete from ViajeTrabajo where id = :id";


      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':id',$id);
      // Ejecuta la consulta
      if ($stmt->execute()) {
            $respuesta = array('ok' => "Registro eliminado");
      } else {
            $respuesta = array('error' => $stmt->errorInfo()[2]);
      }   
  echo json_encode($respuesta);
}

//Actualizar registro
else if($opcion=='11'){
      $tipoPermiso = $_POST['tipoPermiso'];
      $ID = $_POST['ID'];   

      //SALIDA PERSONAL
      if($tipoPermiso=="6"){
                  $CODIGO_SHOP = isset($_POST['CODIGO_SHOP']) ? $_POST['CODIGO_SHOP'] : '';
                  $FECHA_SOLICITUD=  isset($_POST['FECHA_SOLICITUD']) ? $_POST['FECHA_SOLICITUD'] : '';
                  $FECHA_PERMISOA=  isset($_POST['FECHA_PERMISOA']) ? $_POST['FECHA_PERMISOA'] : NULL;
                  $FECHA_PERMISOB = isset($_POST['FECHA_PERMISOB']) ? $_POST['FECHA_PERMISOB'] : NULL;
                  $HORA1 =  isset($_POST['HORA1']) ? $_POST['HORA1'] : NULL;
                  $HORA2 =  isset($_POST['HORA2']) ? $_POST['HORA2'] : '';
                  $MOTIVO =  isset($_POST['MOTIVO']) ? $_POST['MOTIVO'] : '';
                  
                  $sql = "UPDATE SalidaPersonal set CODIGO_SHOP = :CODIGO_SHOP,
                                                    FECHA_SOLICITUD = :FECHA_SOLICITUD, 
                                                    FECHA_PERMISOA = :FECHA_PERMISOA, 
                                                    FECHA_PERMISOB = :FECHA_PERMISOB, 
                                                    HORA1 = :HORA1, 
                                                    HORA2 = :HORA2, 
                                                    MOTIVO = :MOTIVO 
                              where ID ='".$ID."'";
            
                  $stmt = $conn->prepare($sql);
                  $stmt->bindParam(':CODIGO_SHOP', $CODIGO_SHOP);
                  $stmt->bindParam(':FECHA_SOLICITUD', $FECHA_SOLICITUD);
                  $stmt->bindParam(':FECHA_PERMISOA', $FECHA_PERMISOA);
                  $stmt->bindParam(':FECHA_PERMISOB', $FECHA_PERMISOB);
                  $stmt->bindParam(':HORA1', $HORA1);
                  $stmt->bindParam(':HORA2', $HORA2);
                  $stmt->bindParam(':MOTIVO', $MOTIVO);
            
                        // Ejecuta la consulta
                        if (!$stmt->execute()) 
                        $result="Ha ocurrido un error al modificar";
            
                        else 
                              $result="Se ha actualizado la informacion del permiso";       
            echo json_encode($result);
      }

      //PERMUTA
      else if($tipoPermiso=="7"){
            $NN = isset($_POST['NN']) ? $_POST['NN'] : '';
            $CODIGO_SHOP = isset($_POST['CODIGO_SHOP']) ? $_POST['CODIGO_SHOP'] : '';
            $FECHA_SOLICITUD=  isset($_POST['FECHA_SOLICITUD']) ? $_POST['FECHA_SOLICITUD'] : '';
            $FECHA_PERMISOA=  isset($_POST['FECHA_PERMISOA']) ? $_POST['FECHA_PERMISOA'] : NULL;
            $FECHA_PERMISOB = isset($_POST['FECHA_PERMISOB']) ? $_POST['FECHA_PERMISOB'] : NULL;
            $HORA1 =  isset($_POST['HORA1']) ? $_POST['HORA1'] : NULL;
            $HORA2 =  isset($_POST['HORA2']) ? $_POST['HORA2'] : '';
            $MOTIVO =  isset($_POST['MOTIVO']) ? $_POST['MOTIVO'] : '';
            $FECHAPERMU1 =  isset($_POST['FECHAPERMU1']) ? $_POST['FECHAPERMU1'] : '';
            $HORARIOPERMU1 =  isset($_POST['HORARIOPERMU1']) ? $_POST['HORARIOPERMU1'] : '';
            $HORARIOPERMU2 =  isset($_POST['HORARIOPERMU2']) ? $_POST['HORARIOPERMU2'] : '';
            $HORARIOPERMU3 =  isset($_POST['HORARIOPERMU3']) ? $_POST['HORARIOPERMU3'] : NULL;
            $HORARIOPERMU4 =  isset($_POST['HORARIOPERMU4']) ? $_POST['HORARIOPERMU4'] : NULL;
            $HORARIOPERMU5 =  isset($_POST['HORARIOPERMU5']) ? $_POST['HORARIOPERMU5'] : NULL;
            $HORARIOPERMU6 =  isset($_POST['HORARIOPERMU6']) ? $_POST['HORARIOPERMU6'] : NULL;
            $HRSTRABAJADAS1 =  isset($_POST['HRSTRABAJADAS1']) ? $_POST['HRSTRABAJADAS1'] : '';
            $HRSTRABAJADAS2 =  isset($_POST['HRSTRABAJADAS2']) ? $_POST['HRSTRABAJADAS2'] : '0.0';
            $HRSTRABAJADAS3 =  isset($_POST['HRSTRABAJADAS3']) ? $_POST['HRSTRABAJADAS3'] : '0.0';
            $SOLICITADO =  isset($_POST['SOLICITADO']) ? $_POST['SOLICITADO'] : '';
            $TOTALHRSACUMU =  isset($_POST['TOTALHRSACUMU']) ? $_POST['TOTALHRSACUMU'] : '';

            if($_POST['FECHAPERMU2']== null || $_POST['FECHAPERMU2']=='' || empty($_POST['FECHAPERMU2']))
                  $FECHAPERMU2 = NULL;

            else
                  $FECHAPERMU2 =  $_POST['FECHAPERMU2'];

            if($_POST['FECHAPERMU3']== null || $_POST['FECHAPERMU3']=='' || empty($_POST['FECHAPERMU3']))
                  $FECHAPERMU3 = NULL;

            else
                  $FECHAPERMU3 =  $_POST['FECHAPERMU3'];

                  $dsn2= "sqlsrv:Server=mx-server04\beyonzmex;Database=security_db"; 
                  $usuario2= "sa";
                  $contraseña2 ="BYZ@en2o";
                  $conn_securitydb = new PDO($dsn2, $usuario2, $contraseña2);
                  $conn_securitydb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                  
                  $num_filas=0;
                  $num_filas2=1;
                  $num_filas3=1;
                  
                  $verfasis = "select* from hep_transaction where pin ='".$NN."' and event_date ='".$FECHAPERMU1."'";
                  $va= $conn_securitydb->prepare($verfasis);
                  $va->execute();
                  $consulta= $va->fetchALL();
                  $num_filas = count($consulta);
                  
                  if($FECHAPERMU2!=null){
                        $verfasis = "select* from hep_transaction where pin ='".$NN."' and event_date ='".$FECHAPERMU2."'";
                        $va= $conn_securitydb->prepare($verfasis);
                        $va->execute();
                        $consulta= $va->fetchALL();
                        $num_filas2 = count($consulta);
                  }
                  
                  if($FECHAPERMU3!=null){
                        $verfasis = "SELECT* from hep_transaction where pin ='".$NN."' and event_date ='".$FECHAPERMU3."'";
                        $va= $conn_securitydb->prepare($verfasis);
                        $va->execute();
                        $consulta= $va->fetchALL();
                        $num_filas3 = count($consulta);
                  }
                  
                  if($num_filas<=0 || $num_filas2<=0 || $num_filas3<=0) 
                     $respuesta ="No cuenta con registro de asistencia en alguna de las fechas ingresadas para permutar";

            else {
                  $sql = "UPDATE Permuta2 set CODIGO_SHOP = :CODIGO_SHOP,
                                           FECHA_PERMISOA = :FECHA_PERMISOA, 
                                           FECHA_PERMISOB = :FECHA_PERMISOB, 
                                           HORA1 = :HORA1, 
                                           HORA2 = :HORA2, 
                                           MOTIVO = :MOTIVO,
                                           FECHAPERMU1 = :FECHAPERMU1,
                                           HORARIOPERMU1 = :HORARIOPERMU1,
                                           HORARIOPERMU2 = :HORARIOPERMU2,
                                           FECHAPERMU2 = :FECHAPERMU2,
                                           HORARIOPERMU3 = :HORARIOPERMU3,
                                           HORARIOPERMU4 = :HORARIOPERMU4,
                                           FECHAPERMU3 = :FECHAPERMU3,
                                           HORARIOPERMU5 = :HORARIOPERMU5,
                                           HORARIOPERMU6 = :HORARIOPERMU6,
                                           HRSTRABAJADAS1_TEMP = :HRSTRABAJADAS1,
                                           HRSTRABAJADAS2_TEMP = :HRSTRABAJADAS2,
                                           HRSTRABAJADAS3_TEMP = :HRSTRABAJADAS3,
                                           SOLICITADO = :SOLICITADO,
                                           TOTALHRSACUMU_TEMP = :TOTALHRSACUMU           
                              where ID ='".$ID."'";
            
                  $stmt = $conn->prepare($sql);
                  $stmt->bindParam(':CODIGO_SHOP', $CODIGO_SHOP);
                  //$stmt->bindParam(':FECHA_SOLICITUD', $FECHA_SOLICITUD);
                  $stmt->bindParam(':FECHA_PERMISOA', $FECHA_PERMISOA);
                  $stmt->bindParam(':FECHA_PERMISOB', $FECHA_PERMISOB);
                  $stmt->bindParam(':HORA1', $HORA1);
                  $stmt->bindParam(':HORA2', $HORA2);
                  $stmt->bindParam(':MOTIVO', $MOTIVO);
                  $stmt->bindParam(':FECHAPERMU1', $FECHAPERMU1);
                  $stmt->bindParam(':HORARIOPERMU1', $HORARIOPERMU1);
                  $stmt->bindParam(':HORARIOPERMU2', $HORARIOPERMU2);
                  $stmt->bindParam(':FECHAPERMU2', $FECHAPERMU2);
                  $stmt->bindParam(':HORARIOPERMU3', $HORARIOPERMU3);
                  $stmt->bindParam(':HORARIOPERMU4', $HORARIOPERMU4);
                  $stmt->bindParam(':FECHAPERMU3', $FECHAPERMU3);
                  $stmt->bindParam(':HORARIOPERMU5', $HORARIOPERMU5);
                  $stmt->bindParam(':HORARIOPERMU6', $HORARIOPERMU6);
                  $stmt->bindParam(':HRSTRABAJADAS1', $HRSTRABAJADAS1);
                  $stmt->bindParam(':HRSTRABAJADAS2', $HRSTRABAJADAS2);
                  $stmt->bindParam(':HRSTRABAJADAS3', $HRSTRABAJADAS3);
                  $stmt->bindParam(':SOLICITADO', $SOLICITADO);
                  $stmt->bindParam(':TOTALHRSACUMU', $TOTALHRSACUMU);
            
                        // Ejecuta la consulta
                        if (!$stmt->execute()) 
                              $respuesta="Ha ocurrido un error al modificar";
            
                        else 
                              $respuesta="Se ha actualizado la informacion del permiso"; 
            }                     
            
            echo json_encode($respuesta);
      }

      //SALIDA DE TRABAJO
      else if($tipoPermiso=="8"){
            $CODIGO_SHOP = isset($_POST['CODIGO_SHOP']) ? $_POST['CODIGO_SHOP'] : '';
            $FECHA_SOLICITUD=  isset($_POST['FECHA_SOLICITUD']) ? $_POST['FECHA_SOLICITUD'] : '';
            $FECHA_PERMISOA=  isset($_POST['FECHA_PERMISOA']) ? $_POST['FECHA_PERMISOA'] : NULL;
            $FECHA_PERMISOB = isset($_POST['FECHA_PERMISOB']) ? $_POST['FECHA_PERMISOB'] : NULL;
            $HORA1 =  isset($_POST['HORA1']) ? $_POST['HORA1'] : NULL;
            $HORA2 =  isset($_POST['HORA2']) ? $_POST['HORA2'] : '';
            $CIUDAD =  isset($_POST['CIUDAD']) ? $_POST['CIUDAD'] : '';
            $LUGAR =  isset($_POST['LUGAR']) ? $_POST['LUGAR'] : '';
            $MOTIVO =  isset($_POST['MOTIVO']) ? $_POST['MOTIVO'] : '';
            $sql = "UPDATE SalidaTrabajo set CODIGO_SHOP = :CODIGO_SHOP,
                                           FECHA_SOLICITUD = :FECHA_SOLICITUD, 
                                           FECHA_PERMISOA = :FECHA_PERMISOA, 
                                           FECHA_PERMISOB = :FECHA_PERMISOB, 
                                           HORA1 = :HORA1, 
                                           HORA2 = :HORA2, 
                                           CIUDAD = :CIUDAD,
                                           LUGAR = :LUGAR,
                                           MOTIVO = :MOTIVO    
                              where ID ='".$ID."'";
            
                  $stmt = $conn->prepare($sql);
                  $stmt->bindParam(':CODIGO_SHOP', $CODIGO_SHOP);
                  $stmt->bindParam(':FECHA_SOLICITUD', $FECHA_SOLICITUD);
                  $stmt->bindParam(':FECHA_PERMISOA', $FECHA_PERMISOA);
                  $stmt->bindParam(':FECHA_PERMISOB', $FECHA_PERMISOB);
                  $stmt->bindParam(':HORA1', $HORA1);
                  $stmt->bindParam(':HORA2', $HORA2);
                  $stmt->bindParam(':CIUDAD', $CIUDAD);
                  $stmt->bindParam(':LUGAR', $LUGAR);
                  $stmt->bindParam(':MOTIVO', $MOTIVO);
            
                        // Ejecuta la consulta
                        if (!$stmt->execute()) 
                              $result="Ha ocurrido un error al modificar";
            
                        else 
                              $result="Se ha actualizado la informacion del permiso";

            echo json_encode($result);

      }

      //VIAJE DE TRABAJO
      else if($tipoPermiso=="9"){
            $CODIGO_SHOP = isset($_POST['CODIGO_SHOP']) ? $_POST['CODIGO_SHOP'] : '';
            $FECHA_SOLICITUD=  isset($_POST['FECHA_SOLICITUD']) ? $_POST['FECHA_SOLICITUD'] : '';
            $FECHA_PERMISOA=  isset($_POST['FECHA_PERMISOA']) ? $_POST['FECHA_PERMISOA'] : NULL;
            $FECHA_PERMISOB = isset($_POST['FECHA_PERMISOB']) ? $_POST['FECHA_PERMISOB'] : NULL;
            $HORA1 =  isset($_POST['HORA1']) ? $_POST['HORA1'] : NULL;
            $HORA2 =  isset($_POST['HORA2']) ? $_POST['HORA2'] : '';
            $CANTDIAS = isset($_POST['CANTDIAS']) ? $_POST['CANTDIAS'] : ''; 
            $CIUDAD =  isset($_POST['CIUDAD']) ? $_POST['CIUDAD'] : '';
            $LUGAR =  isset($_POST['LUGAR']) ? $_POST['LUGAR'] : '';
            $MOTIVO =  isset($_POST['MOTIVO']) ? $_POST['MOTIVO'] : '';
            $GASTOS =  isset($_POST['GASTOS']) ? $_POST['GASTOS'] : '';
            $CASETAS =  isset($_POST['CASETAS']) ? $_POST['CASETAS'] : '';
            $GASOLINA =  isset($_POST['GASOLINA']) ? $_POST['GASOLINA'] : '';
            $HOTEL =  isset($_POST['HOTEL']) ? $_POST['HOTEL'] : '';
            $COMIDAS =  isset($_POST['COMIDAS']) ? $_POST['COMIDAS'] : '';
            $TAXI =  isset($_POST['TAXI']) ? $_POST['TAXI'] : '';
            $OTROS =  isset($_POST['OTROS']) ? $_POST['OTROS'] : ''; 
            $TOTAL =  isset($_POST['TOTAL']) ? $_POST['TOTAL'] : '';
            $CANTDIAS =  isset($_POST['CANTDIAS']) ? $_POST['CANTDIAS'] : '';

            $sql = "UPDATE ViajeTrabajo set CODIGO_SHOP = :CODIGO_SHOP,
                                           FECHA_SOLICITUD = :FECHA_SOLICITUD, 
                                           FECHA_PERMISOA = :FECHA_PERMISOA, 
                                           FECHA_PERMISOB = :FECHA_PERMISOB, 
                                           HORA1 = :HORA1, 
                                           HORA2 = :HORA2, 
                                           CANTDIAS = :CANTDIAS,
                                           CIUDAD = :CIUDAD,
                                           LUGAR = :LUGAR,
                                           MOTIVO = :MOTIVO,
                                           GASTOS = :GASTOS,
                                           CASETAS = :CASETAS,
                                           GASOLINA = :GASOLINA,
                                           HOTEL = :HOTEL,
                                           COMIDAS = :COMIDAS,
                                           TAXI = :TAXI,
                                           OTROS = :OTROS,
                                           TOTAL = :TOTAL
                              where ID ='".$ID."'";
            
                  $stmt = $conn->prepare($sql);
                  $stmt->bindParam(':CODIGO_SHOP', $CODIGO_SHOP);
                  $stmt->bindParam(':FECHA_SOLICITUD', $FECHA_SOLICITUD);
                  $stmt->bindParam(':FECHA_PERMISOA', $FECHA_PERMISOA);
                  $stmt->bindParam(':FECHA_PERMISOB', $FECHA_PERMISOB);
                  $stmt->bindParam(':HORA1', $HORA1);
                  $stmt->bindParam(':HORA2', $HORA2);
                  $stmt->bindParam(':CANTDIAS', $CANTDIAS);
                  $stmt->bindParam(':CIUDAD', $CIUDAD);
                  $stmt->bindParam(':LUGAR', $LUGAR);
                  $stmt->bindParam(':MOTIVO', $MOTIVO);
                  $stmt->bindParam(':GASTOS', $GASTOS);
                  $stmt->bindParam(':CASETAS', $CASETAS);
                  $stmt->bindParam(':GASOLINA', $GASOLINA);
                  $stmt->bindParam(':HOTEL', $HOTEL);
                  $stmt->bindParam(':COMIDAS', $COMIDAS);
                  $stmt->bindParam(':TAXI', $TAXI);
                  $stmt->bindParam(':OTROS', $OTROS);
                  $stmt->bindParam(':TOTAL', $TOTAL);
                  $stmt->bindParam(':CANTDIAS', $CANTDIAS);

                        // Ejecuta la consulta
                        if (!$stmt->execute()) 
                        $result="Ha ocurrido un error al modificar";
            
                        else 
                              $result="Se ha actualizado la informacion del permiso";       

                   echo json_encode($result);
      }
}

//Datos para la tabla de reportes
else if($opcion=='12'){
      $tipoPermiso = $_POST['tipoPermiso'];
      $tipoPago = $_POST['pago']; //Tipo de pago, semanal o quincenal

      if($tipoPago == 'T')
            $sql='select* from '.$tipoPermiso;

      else 
        if ($tipoPago == 'S') 
             $sql="select p.*, e.nivel_organigrama from ".$tipoPermiso." as p inner join empleado as e on e.id_usuario= p.NN where nivel_organigrama='S' ";

     else 
        if ($tipoPago == 'Q')
             $sql="select p.*, e.nivel_organigrama from ".$tipoPermiso." as p inner join empleado as e on e.id_usuario= p.NN where nivel_organigrama='Q' ";

      
      $stmt = $conn->prepare($sql);
      $datos = array();
      $stmt->execute();
            while($res = $stmt->fetch(PDO::FETCH_ASSOC)){

                  if($tipoPermiso=="SalidaPersonal")
                        $datos[]= array(
                              "ID"=>$res['ID'],
                              "NN"=>$res['NN'],
                              "NOMBRE"=>$res['NOMBRE'],
                              "DEPARTAMENTO"=>$res['DEPARTAMENTO'],
                              "CODIGO-SHOP"=>$res['CODIGO_SHOP'],
                              "FECHA-SOLICITUD"=>$res['FECHA_SOLICITUD'],
                              "FECHA-DE-INICIO"=>$res['FECHA_PERMISOA'],
                              "FECHA-DE-FIN"=>$res['FECHA_PERMISOB'],
                              "HORA-INICIO"=>date('H:i', strtotime($res['HORA1'])),
                              "HORA-FIN"=>date('H:i', strtotime($res['HORA2'])),
                              "MOTIVO"=>$res['MOTIVO']
                        );
                  
                  else 
                    if($tipoPermiso=="SalidaTrabajo")
                        $datos[]= array(
                              "ID"=>$res['ID'],
                              "NN"=>$res['NN'],
                              "NOMBRE"=>$res['NOMBRE'],
                              "DEPARTAMENTO"=>$res['DEPARTAMENTO'],
                              "CODIGO-SHOP"=>$res['CODIGO_SHOP'],
                              "FECHA-SOLICITUD"=>$res['FECHA_SOLICITUD'],
                              "FECHA-DE-INICIO"=>$res['FECHA_PERMISOA'],
                              "FECHA-DE-FIN"=>$res['FECHA_PERMISOB'],
                              "HORA-INICIO"=>date('H:i', strtotime($res['HORA1'])),
                              "HORA-FIN"=>date('H:i', strtotime($res['HORA2'])),
                              "MOTIVO"=>$res['MOTIVO'],
                              "CIUDAD"=>$res['CIUDAD'],
                              "LUGAR"=>$res['LUGAR']
                        );
                  else 
                    if($tipoPermiso=="Permuta2")
                        $datos[]= array(
                                    "ID"=>$res['ID'],
                                    "NN"=>$res['NN'],
                                    "NOMBRE"=>$res['NOMBRE'],
                                    "DEPARTAMENTO"=>$res['DEPARTAMENTO'],
                                    "CODIGO-SHOP"=>$res['CODIGO_SHOP'],
                                    "FECHA-SOLICITUD"=>$res['FECHA_SOLICITUD'],
                                    "FECHA-DE-INICIO"=>$res['FECHA_PERMISOA'],
                                    "FECHA-DE-FIN"=>$res['FECHA_PERMISOB'],
                                    "HORA-INICIO"=>date('H:i', strtotime($res['HORA1'])),
                                    "HORA-FIN"=>date('H:i', strtotime($res['HORA2'])),
                                    "MOTIVO"=>$res['MOTIVO'],
                                    "SOLICITADO"=>$res['SOLICITADO'],
                                    "FECHA DE PERMUTA 1"=>$res['FECHAPERMU1'],
                                    "HORARIO DE INICIO PERMUTA 1"=>$res['HORARIOPERMU1'],
                                    "HORARIO DE FIN PERMUTA 1"=>$res['HORARIOPERMU2'],
                                    "HORAS TRABAJADAS PERMUTA 1"=>$res['HRSTRABAJADAS1_TEMP'],
                                    "FECHA DE PERMUTA 2"=>$res['FECHAPERMU2'],
                                    "HORA DE INICIO PERMUTA 2"=>$res['HORARIOPERMU3'],
                                    "HORA DE FIN PERMUTA 2"=>$res['HORARIOPERMU4'],
                                    "HORAS TRABAJADAS PERMUTA 2"=>$res['HRSTRABAJADAS2_TEMP'],
                                    "FECHA DE PERMUTA 3"=>$res['FECHAPERMU3'],
                                    "HORA DE INICIO PERMUTA 3"=>$res['HORARIOPERMU5'],
                                    "HORA DE FIN PERMUTA 3"=>$res['HORARIOPERMU6'],
                                    "HORAS TRABAJADAS PERMUTA 3"=>$res['HRSTRABAJADAS3_TEMP'],
                                    "TOTAL DE HORAS "=>$res['TOTALHRSACUMU_TEMP']
                              );
                  else 
                    if($tipoPermiso=="ViajeTrabajo")
                        $datos[]= array(
                              "ID"=>$res['ID'],
                              "NN"=>$res['NN'],
                              "NOMBRE"=>$res['NOMBRE'],
                              "DEPARTAMENTO"=>$res['DEPARTAMENTO'],
                              "CODIGO-SHOP"=>$res['CODIGO_SHOP'],
                              "FECHA-SOLICITUD"=>$res['FECHA_SOLICITUD'],
                              "FECHA-DE-INICIO"=>$res['FECHA_PERMISOA'],
                              "FECHA-DE-FIN"=>$res['FECHA_PERMISOB'],
                              "HORA-INICIO"=>date('H:i', strtotime($res['HORA1'])),
                              "HORA-FIN"=>date('H:i', strtotime($res['HORA2'])),
                              "DIAS"=>$res['CANTDIAS'],
                              "CIUDAD"=>$res['CIUDAD'],
                              "LUGAR"=>$res['LUGAR'],
                              "MOTIVO"=>$res['MOTIVO'],
                              "GASTOS"=>$res['GASTOS'],
                              "CASETAS"=>$res['CASETAS'],
                              "GASOLINA"=>$res['GASOLINA'],
                              "HOTEL"=>$res['HOTEL'],
                              "COMIDAS"=>$res['COMIDAS'],
                              "TAXI"=>$res['TAXI'],
                              "OTROS"=>$res['OTROS'],
                              "TOTAL"=>$res['TOTAL']
                        );
            }

      echo json_encode($datos);    
} 

//Calculo de las horas para permutar
else if($opcion=='13'){
      $FECHAPERMU1 = isset($_POST['FECHAPERMU1']) ? $_POST['FECHAPERMU1'] : '';
      $HRSTRABAJADAS1 =isset($_POST['HRSTRABAJADAS1']) ? $_POST['HRSTRABAJADAS1'] : '';
      
      // Dividir la cadena de fecha en día, mes y año
      list($dia, $mes, $ano) = explode('/', $FECHAPERMU1);
      // Formatear la fecha en el formato "Y-m-d"
      $FECHAPERMU1 = "$ano-$mes-$dia";

      $FECHAPERMU2 = isset($_POST['FECHAPERMU2']) ? $_POST['FECHAPERMU2'] : '';
      $HRSTRABAJADAS2 = isset($_POST['HRSTRABAJADAS2']) ? $_POST['HRSTRABAJADAS2'] : '';
      $FECHAPERMU3 = isset($_POST['FECHAPERMU3']) ? $_POST['FECHAPERMU3'] : '';
      $HRSTRABAJADAS3 = isset($_POST['HRSTRABAJADAS3']) ? $_POST['HRSTRABAJADAS3'] : '';
      $HORARIOPERMU1 =  isset($_POST['HORARIOPERMU1']) ? $_POST['HORARIOPERMU1'] : '';
      $HORARIOPERMU2 =  isset($_POST['HORARIOPERMU2']) ? $_POST['HORARIOPERMU2'] : '';
      $HORARIOPERMU3 =  isset($_POST['HORARIOPERMU3']) ? $_POST['HORARIOPERMU3'] : NULL;
      $HORARIOPERMU4 =  isset($_POST['HORARIOPERMU4']) ? $_POST['HORARIOPERMU4'] : NULL;
      $HORARIOPERMU5 =  isset($_POST['HORARIOPERMU5']) ? $_POST['HORARIOPERMU5'] : NULL;
      $HORARIOPERMU6 =  isset($_POST['HORARIOPERMU6']) ? $_POST['HORARIOPERMU6'] : NULL;
      $NN = $_POST['NN'];
   
      // Convertir las horas a minutos y sumar los minutos
      list($HRSTRABAJADAS1, $minutos) = explode(':', $HRSTRABAJADAS1);
      $HRSTRABAJADAS1 = ($HRSTRABAJADAS1 * 60) + $minutos;
      $horas = "select* from DiasFestivos where fecha =' ".$FECHAPERMU1."'";
      $h=$conn->prepare($horas);
      $h->execute();
      $ch= $h->fetchALL();
      $festivo = count($ch);
      $total=0;
      $exis=0;
            //Si no es día festivo
            if($festivo<=0){
                  $numero_dia = date('N', strtotime($FECHAPERMU1));                     
                  $turno = "select* from ST_NoTransporte where ID ='".$NN."'";
                  $tu=$conn->prepare($turno);
                  $tu->execute();
                  $ctu= $tu->fetch(PDO::FETCH_ASSOC);
                  
                  $tu->execute();
                  $c= $tu->fetchALL();
                  $exis = count($c);

                  if($exis<=0){
                        $tu=$conn->prepare("SELECT tipo_turno, turno from SolicitudTransporte where id ='".$NN."' and '".$FECHAPERMU1."' BETWEEN fecha_inicio and fecha_fin");
                        $tu->execute();
                        $ctu= $tu->fetch(PDO::FETCH_ASSOC);
                  }

        
                  //Consulta para extraer el turno y tipo turno de la tabla SolicitudTransporte
                  //Vacia == true NO vacia== false
                  if(!empty($ctu['turno']) && !empty($ctu['tipo_turno']))
                  {
                        if($ctu['turno']=="Mixto") {
                              if($numero_dia==1 || $numero_dia==2 || $numero_dia==5 || $numero_dia==6)   
                              $HRSTRABAJADAS1 = $HRSTRABAJADAS1 - 720;                                
                        }
   
                        else 
                        if ($ctu['tipo_turno']=="5 x 2" && $ctu['turno']=="Dia"){
                              if($numero_dia!=6 && $numero_dia!=7)
                              {
                                    if ( (strtotime($HORARIOPERMU1)>= strtotime('1970-01-01 08:00') && strtotime($HORARIOPERMU1) < strtotime('1970-01-01 18:00')) || (strtotime($HORARIOPERMU2)>= strtotime('1970-01-01 08:00') && strtotime($HORARIOPERMU2) < strtotime('1970-01-01 18:00')) ||
                                         (strtotime('1970-01-01 08:00')>= strtotime($HORARIOPERMU1) && strtotime('1970-01-01 08:00') <= strtotime($HORARIOPERMU2)) || (strtotime('1970-01-01 18:00')> strtotime($HORARIOPERMU1) && strtotime('1970-01-01 18:00') < strtotime($HORARIOPERMU2)) )
                                         $HRSTRABAJADAS1 = $HRSTRABAJADAS1 - 576;
                              }
                        }
   
                        else 
                        if ($ctu['tipo_turno']=="5 x 2" && $ctu['turno']=="Noche"){
                              if($numero_dia!=6 && $numero_dia!=7)
                              {
                                    $hora1 = (new DateTime($HORARIOPERMU1))->format('H:i');
                                    $hora2 = (new DateTime($HORARIOPERMU2))->format('H:i');

                                    if($hora1 < $hora2) {
                                          $HORARIOPERMU1=  ((new DateTime ($HORARIOPERMU1))->modify('+1 day'))->format('Y-m-d H:i'); 
                                          $HORARIOPERMU2= ((new DateTime ($HORARIOPERMU2))->modify('+1 day'))->format('Y-m-d H:i'); 

                                          if ( (strtotime($HORARIOPERMU1)>= strtotime('1970-01-01 23:00') && strtotime($HORARIOPERMU1) <= strtotime('1970-01-02 08:00')) 
                                                || (strtotime($HORARIOPERMU2)>= strtotime('1970-01-01 23:00') && strtotime($HORARIOPERMU2) <= strtotime('1970-01-02 08:00')) 
                                                || (strtotime('1970-01-01 23:00')>= strtotime($HORARIOPERMU1) && strtotime('1970-01-01 23:00') <= strtotime($HORARIOPERMU2)) 
                                                || (strtotime('1970-01-02 08:00')>= strtotime($HORARIOPERMU1) && strtotime('1970-01-02 08:00') <= strtotime($HORARIOPERMU2))
                                                || (strtotime($HORARIOPERMU1)< strtotime('1970-01-02 23:30') && strtotime($HORARIOPERMU2) >= strtotime('1970-01-02 23:30'))
                                             )
                                               $HRSTRABAJADAS1 = $HRSTRABAJADAS1 - 510; 
                                    }

                                    else

                                    if ( (strtotime($HORARIOPERMU1)>= strtotime('1970-01-01 23:00') && strtotime($HORARIOPERMU1) <= strtotime('1970-01-02 08:00')) || (strtotime($HORARIOPERMU2)>= strtotime('1970-01-01 23:00') && strtotime($HORARIOPERMU2) <= strtotime('1970-01-02 08:00')) ||
                                          (strtotime('1970-01-01 23:00')>= strtotime($HORARIOPERMU1) && strtotime('1970-01-01 23:00') <= strtotime($HORARIOPERMU2)) || (strtotime('1970-01-02 08:00')>= strtotime($HORARIOPERMU1) && strtotime('1970-01-02 08:00') <= strtotime($HORARIOPERMU2)) )
                                               $HRSTRABAJADAS1 = $HRSTRABAJADAS1 - 510; 
                              }
                        }
   
                        else 
                        if($ctu['tipo_turno']=="4 x 3"){
                              if($numero_dia==1 || $numero_dia==2 || $numero_dia==3 || $numero_dia==4)   
                              $HRSTRABAJADAS1 = $HRSTRABAJADAS1 - 720;  
                        }
   
                  } 
            }
            
            $total= $total + $HRSTRABAJADAS1;
            $horas = intval($HRSTRABAJADAS1 / 60);
            $minutos = abs($HRSTRABAJADAS1%60);
            $HRSTRABAJADAS1= ''.$horas.':'.$minutos.'';
   
   
      if(!empty($FECHAPERMU2) && $FECHAPERMU2!=null ){

            // Dividir la cadena de fecha en día, mes y año
            list($dia, $mes, $ano) = explode('/', $FECHAPERMU2);
            // Formatear la fecha en el formato "Y-m-d"
            $FECHAPERMU2 = "$ano-$mes-$dia";
            // Convertir las horas a minutos y sumar los minutos

            list($HRSTRABAJADAS2, $minutos) = explode(':', $HRSTRABAJADAS2);
            $HRSTRABAJADAS2 = ($HRSTRABAJADAS2 * 60) + $minutos;
            $horas = "select* from DiasFestivos where fecha ='".$FECHAPERMU2."'";
            $h=$conn->prepare($horas);
            $h->execute();
            $ch= $h->fetchALL();
            $festivo = count($ch);
      
            //Si no es día festivo
            if($festivo<=0){
                  $numero_dia = date('N', strtotime($FECHAPERMU2)); 

                  if($exis<=0){
                        $turno="SELECT tipo_turno, turno from SolicitudTransporte where id ='".$NN."' and '".$FECHAPERMU2."' BETWEEN fecha_inicio and fecha_fin";
                        $tu=$conn->prepare($turno);
                        $tu->execute();
                        $ctu= $tu->fetch(PDO::FETCH_ASSOC);
                  }
   
   
                  //Vacia == true NO vacia== false
                  if(!empty($ctu['turno']) && !empty($ctu['tipo_turno']))
                  {
                        if($ctu['turno']=="Mixto") {
                        if($numero_dia==1 || $numero_dia==2 || $numero_dia==5 || $numero_dia==6)   
                              $HRSTRABAJADAS2 = $HRSTRABAJADAS2 - 720;                                
                  }
   
                  else 
                        if ($ctu['tipo_turno']=="5 x 2" && $ctu['turno']=="Dia"){
                              if($numero_dia!=6 && $numero_dia!=7)
                              {
                                    if ( (strtotime($HORARIOPERMU3)>= strtotime('1970-01-01 08:00') && strtotime($HORARIOPERMU3) < strtotime('1970-01-01 18:00')) || (strtotime($HORARIOPERMU4)>= strtotime('1970-01-01 08:00') && strtotime($HORARIOPERMU4) < strtotime('1970-01-01 18:00')) ||
                                    (strtotime('1970-01-01 08:00')>= strtotime($HORARIOPERMU3) && strtotime('1970-01-01 08:00') <= strtotime($HORARIOPERMU4)) || (strtotime('1970-01-01 18:00')> strtotime($HORARIOPERMU3) && strtotime('1970-01-01 18:00') < strtotime($HORARIOPERMU4)) )
                                         $HRSTRABAJADAS2 = $HRSTRABAJADAS2 - 576;
                              }
                        }
   
                  else 
                  if ($ctu['tipo_turno']=="5 x 2" && $ctu['turno']=="Noche"){
                        if($numero_dia!=6 && $numero_dia!=7)
                        {
                              $hora1 = (new DateTime($HORARIOPERMU3))->format('H:i');
                              $hora2 = (new DateTime($HORARIOPERMU4))->format('H:i');

                              if($hora1 < $hora2) {
                                    $HORARIOPERMU3=  ((new DateTime ($HORARIOPERMU3))->modify('+1 day'))->format('Y-m-d H:i'); 
                                    $HORARIOPERMU4= ((new DateTime ($HORARIOPERMU4))->modify('+1 day'))->format('Y-m-d H:i'); 

                                    if ( (strtotime($HORARIOPERMU3)>= strtotime('1970-01-01 23:00') && strtotime($HORARIOPERMU3) <= strtotime('1970-01-02 08:00')) 
                                          || (strtotime($HORARIOPERMU4)>= strtotime('1970-01-01 23:00') && strtotime($HORARIOPERMU4) <= strtotime('1970-01-02 08:00')) 
                                          || (strtotime('1970-01-01 23:00')>= strtotime($HORARIOPERMU3) && strtotime('1970-01-01 23:00') <= strtotime($HORARIOPERMU4)) 
                                          || (strtotime('1970-01-02 08:00')>= strtotime($HORARIOPERMU3) && strtotime('1970-01-02 08:00') <= strtotime($HORARIOPERMU4))
                                          || (strtotime($HORARIOPERMU3)< strtotime('1970-01-02 23:30') && strtotime($HORARIOPERMU4) >= strtotime('1970-01-02 23:30'))
                                       )
                                         $HRSTRABAJADAS2 = $HRSTRABAJADAS2 - 510; 
                              }

                              else

                              if ( (strtotime($HORARIOPERMU3)>= strtotime('1970-01-01 23:00') && strtotime($HORARIOPERMU3) <= strtotime('1970-01-02 08:00')) || (strtotime($HORARIOPERMU4)>= strtotime('1970-01-01 23:00') && strtotime($HORARIOPERMU4) <= strtotime('1970-01-02 08:00')) ||
                                    (strtotime('1970-01-01 23:00')>= strtotime($HORARIOPERMU3) && strtotime('1970-01-01 23:00') <= strtotime($HORARIOPERMU4)) || (strtotime('1970-01-02 08:00')>= strtotime($HORARIOPERMU3) && strtotime('1970-01-02 08:00') <= strtotime($HORARIOPERMU4)) )
                                         $HRSTRABAJADAS2 = $HRSTRABAJADAS2 - 510; 
                        }
                  }
   
                  else 
                        if($ctu['tipo_turno']=="4 x 3"){
                              if($numero_dia==1 || $numero_dia==2 || $numero_dia==3 || $numero_dia==4)   
                              $HRSTRABAJADAS2 = $HRSTRABAJADAS2 - 720;  
                  }
   
                  } 
            }
   
            $total = $total + $HRSTRABAJADAS2;
            $horas = intval($HRSTRABAJADAS2 / 60);
            $minutos = abs($HRSTRABAJADAS2%60);
            $HRSTRABAJADAS2= ''.$horas.':'.$minutos.'';
      }
   
      else
            $HRSTRABAJADAS2 = '';
   
      if(!empty($FECHAPERMU3) && $FECHAPERMU3!=null ){

            // Dividir la cadena de fecha en día, mes y año
            list($dia, $mes, $ano) = explode('/', $FECHAPERMU3);
            // Formatear la fecha en el formato "Y-m-d"
            $FECHAPERMU3 = "$ano-$mes-$dia";
            
           // Convertir las horas a minutos y sumar los minutos
            list($HRSTRABAJADAS3, $minutos) = explode(':', $HRSTRABAJADAS3);
            $HRSTRABAJADAS3 = ($HRSTRABAJADAS3 * 60) + $minutos;
            $horas = "select* from DiasFestivos where fecha =' ".$FECHAPERMU3."'";
            $h=$conn->prepare($horas);
            $h->execute();
            $ch= $h->fetchALL();
            $festivo = count($ch);
            
                  //Si no es día festivo
                  if($festivo<=0){      
                        
                        $numero_dia = date('N', strtotime($FECHAPERMU3)); 

                        if($exis<=0){
                              $turno="SELECT tipo_turno, turno from SolicitudTransporte where id ='".$NN."' and '".$FECHAPERMU3."' BETWEEN fecha_inicio and fecha_fin";
                              $tu=$conn->prepare($turno);
                              $tu->execute();
                              $ctu= $tu->fetch(PDO::FETCH_ASSOC);
                        }
   
                        //Vacia == true NO vacia== false
                        if(!empty($ctu['turno']) && !empty($ctu['tipo_turno']))
                        {
                              if($ctu['turno']=="Mixto") {
                                    if($numero_dia==1 || $numero_dia==2 || $numero_dia==5 || $numero_dia==6)   
                                          $HRSTRABAJADAS3 = $HRSTRABAJADAS3 - 720;                                
                        }
   
                        else 
                              if ($ctu['tipo_turno']=="5 x 2" && $ctu['turno']=="Dia"){
                                    if($numero_dia!=6 && $numero_dia!=7)
                                    {
                                          if ( (strtotime($HORARIOPERMU5)>= strtotime('1970-01-01 08:00') && strtotime($HORARIOPERMU5) < strtotime('1970-01-01 18:00')) || (strtotime($HORARIOPERMU6)>= strtotime('1970-01-01 08:00') && strtotime($HORARIOPERMU6) < strtotime('1970-01-01 18:00')) ||
                                          (strtotime('1970-01-01 08:00')>= strtotime($HORARIOPERMU5) && strtotime('1970-01-01 08:00') <= strtotime($HORARIOPERMU6)) || (strtotime('1970-01-01 18:00')> strtotime($HORARIOPERMU5) && strtotime('1970-01-01 18:00') < strtotime($HORARIOPERMU6)) )
                                               $HRSTRABAJADAS3 = $HRSTRABAJADAS3 - 576;
                                    }

                        }
   
                        else 
                        if ($ctu['tipo_turno']=="5 x 2" && $ctu['turno']=="Noche"){
                              if($numero_dia!=6 && $numero_dia!=7)
                              {
                                    $hora1 = (new DateTime($HORARIOPERMU5))->format('H:i');
                                    $hora2 = (new DateTime($HORARIOPERMU6))->format('H:i');

                                    if($hora1 < $hora2) {
                                          $HORARIOPERMU5=  ((new DateTime ($HORARIOPERMU5))->modify('+1 day'))->format('Y-m-d H:i'); 
                                          $HORARIOPERMU6= ((new DateTime ($HORARIOPERMU6))->modify('+1 day'))->format('Y-m-d H:i'); 

                                          if ( (strtotime($HORARIOPERMU5)>= strtotime('1970-01-01 23:00') && strtotime($HORARIOPERMU5) <= strtotime('1970-01-02 08:00')) 
                                                || (strtotime($HORARIOPERMU6)>= strtotime('1970-01-01 23:00') && strtotime($HORARIOPERMU6) <= strtotime('1970-01-02 08:00')) 
                                                || (strtotime('1970-01-01 23:00')>= strtotime($HORARIOPERMU5) && strtotime('1970-01-01 23:00') <= strtotime($HORARIOPERMU6)) 
                                                || (strtotime('1970-01-02 08:00')>= strtotime($HORARIOPERMU5) && strtotime('1970-01-02 08:00') <= strtotime($HORARIOPERMU6))
                                                || (strtotime($HORARIOPERMU5)< strtotime('1970-01-02 23:30') && strtotime($HORARIOPERMU6) >= strtotime('1970-01-02 23:30'))
                                             )
                                               $HRSTRABAJADAS3 = $HRSTRABAJADAS3 - 510; 
                                    }

                                    else

                                    if ( (strtotime($HORARIOPERMU5)>= strtotime('1970-01-01 23:00') && strtotime($HORARIOPERMU5) <= strtotime('1970-01-02 08:00')) || (strtotime($HORARIOPERMU6)>= strtotime('1970-01-01 23:00') && strtotime($HORARIOPERMU6) <= strtotime('1970-01-02 08:00')) ||
                                          (strtotime('1970-01-01 23:00')>= strtotime($HORARIOPERMU5) && strtotime('1970-01-01 23:00') <= strtotime($HORARIOPERMU6)) || (strtotime('1970-01-02 08:00')>= strtotime($HORARIOPERMU5) && strtotime('1970-01-02 08:00') <= strtotime($HORARIOPERMU6)) )
                                               $HRSTRABAJADAS3 = $HRSTRABAJADAS3 - 510; 
                              }
                        }
   
                        else 
                              if($ctu['tipo_turno']=="4 x 3"){
                                    if($numero_dia==1 || $numero_dia==2 || $numero_dia==3 || $numero_dia==4)   
                                    $HRSTRABAJADAS3 = $HRSTRABAJADAS3 - 720;  
                              }
                        } 
                  }
   
                  $total= $total + $HRSTRABAJADAS3;
                  $horas = intval($HRSTRABAJADAS3 / 60);
                  $minutos = abs($HRSTRABAJADAS3%60);
                  $HRSTRABAJADAS3= ''.$horas.':'.$minutos.'';
      }
   
      else
            $HRSTRABAJADAS3= '';
   
       $horas = intval($total / 60);
       $minutos = abs($total%60);
       $total= ''.$horas.':'.$minutos.'';
   
   $respuesta = array('HRSTRABAJADAS1' => $HRSTRABAJADAS1,
   'HRSTRABAJADAS2' => $HRSTRABAJADAS2,
   'HRSTRABAJADAS3' => $HRSTRABAJADAS3,
   'HORARIOPERMU1' => strtotime($HORARIOPERMU1),
   'HORARIOPERMU2' => strtotime($HORARIOPERMU2),
   'htotal' => $total,
  );

echo json_encode($respuesta);
}
 /*Fin de la validacion de las horas para permutar*/

//Login para el panel
else if($opcion=='14'){
  $passwrod =  $_POST['password'];

  if ($passwrod =='Ma1Fr2Xs3Cv4') {
      session_start();
      $_SESSION['PANEL']= true;
      $respuesta= array('ok' => true);
  }

  else $respuesta= array('ok' => false);
            
  echo json_encode($respuesta);
}
//Fin del login para el panel

//Logina para la seccion de reportes
 else if($opcion=='15'){
      $passwrod =  $_POST['password'];
    
      if ($passwrod =='BM@2328Av#99') {
          session_start();
          $_SESSION['REPORTES']= true;
          $respuesta= array('ok' => true);
      }
    
      else $respuesta= array('ok' => false);
                
      echo json_encode($respuesta);
    }

    else if($opcion=='16'){      
      session_start();
      session_destroy();

      echo json_encode("Session cerrada");
}
//Fin  del logina para la seccion de reportes
    

/*
//Calculo de las horas para permutar
else if($opcion=='13'){
      $FECHAPERMU1 = isset($_POST['FECHAPERMU1']) ? $_POST['FECHAPERMU1'] : '';
      $HRSTRABAJADAS1 =isset($_POST['HRSTRABAJADAS1']) ? $_POST['HRSTRABAJADAS1'] : '';
      $FECHAPERMU2 = isset($_POST['FECHAPERMU2']) ? $_POST['FECHAPERMU2'] : '';
      $HRSTRABAJADAS2 = isset($_POST['HRSTRABAJADAS2']) ? $_POST['HRSTRABAJADAS2'] : '';
      $FECHAPERMU3 = isset($_POST['FECHAPERMU3']) ? $_POST['FECHAPERMU3'] : '';
      $HRSTRABAJADAS3 = isset($_POST['HRSTRABAJADAS3']) ? $_POST['HRSTRABAJADAS3'] : '';
      $NN = $_POST['NN'];
      $total=0; 
      
      list($HRSTRABAJADAS1, $minutos) = explode(':', $HRSTRABAJADAS1);
      $HRSTRABAJADAS1 = ($HRSTRABAJADAS1 * 60) + $minutos;   
            
      $total= $total + $HRSTRABAJADAS1;
      $horas = intval($HRSTRABAJADAS1 / 60);
      $minutos = abs($HRSTRABAJADAS1%60);
      $HRSTRABAJADAS1= ''.$horas.':'.$minutos.'';
   
   
      if(!empty($FECHAPERMU2) && $FECHAPERMU2!=null && $FECHAPERMU2!='' ){
            list($HRSTRABAJADAS2, $minutos) = explode(':', $HRSTRABAJADAS2);
            $HRSTRABAJADAS2 = ($HRSTRABAJADAS2 * 60) + $minutos;
      
            $total = $total + $HRSTRABAJADAS2;
            $horas = intval($HRSTRABAJADAS2 / 60);
            $minutos = abs($HRSTRABAJADAS2%60);
            $HRSTRABAJADAS2= ''.$horas.':'.$minutos.'';
      }
   
      else
            $HRSTRABAJADAS2 = '';
   
      if(!empty($FECHAPERMU3) && $FECHAPERMU3!=null ){

            list($HRSTRABAJADAS3, $minutos) = explode(':', $HRSTRABAJADAS3);
            $HRSTRABAJADAS3 = ($HRSTRABAJADAS3 * 60) + $minutos;
            
            $total= $total + $HRSTRABAJADAS3;
            $horas = intval($HRSTRABAJADAS3 / 60);
            $minutos = abs($HRSTRABAJADAS3%60);
            $HRSTRABAJADAS3= ''.$horas.':'.$minutos.'';
      }
   
      else
            $HRSTRABAJADAS3= '';
   
       $horas = intval($total / 60);
       $minutos = abs($total%60);
       $total= ''.$horas.':'.$minutos.'';
   
   $respuesta = array('HRSTRABAJADAS1' => $HRSTRABAJADAS1,
   'HRSTRABAJADAS2' => $HRSTRABAJADAS2,
   'HRSTRABAJADAS3' => $HRSTRABAJADAS3,
   'htotal' => $total,
  );

echo json_encode($respuesta);
}

verp3= "SELECT COUNT(*) AS total_solapamientos from (SELECT 
                              NN,
                              CAST(CONVERT(VARCHAR, FECHAPERMU1, 23) + ' ' + CONVERT(VARCHAR, HORARIOPERMU1, 8) AS DATETIME) AS fecha_y_hora_inicio_1,
                              CAST(CONVERT (VARCHAR,
                              CASE 
                                    WHEN HORARIOPERMU1 <= HORARIOPERMU2 
                                          THEN FECHAPERMU1  -- Caso 1: Hora de fin mayor que hora de inicio
                                          ELSE DATEADD(day, 1, FECHAPERMU1)  -- Caso 2: Hora de fin menor que hora de inicio
                              END) + ' '+ CONVERT(VARCHAR, HORARIOPERMU2, 8) AS DATETIME) AS Fecha_y_hora_Fin_1,
                              CAST(CONVERT(VARCHAR, FECHAPERMU2, 23) + ' ' + CONVERT(VARCHAR, HORARIOPERMU3, 8) AS DATETIME) AS fecha_y_hora_inicio_2,
                              CAST(CONVERT (VARCHAR,
                              CASE 
                                    WHEN HORARIOPERMU3 <= HORARIOPERMU4 THEN FECHAPERMU2  -- Caso 1: Hora de fin mayor que hora de inicio
                                    ELSE DATEADD(day, 1, FECHAPERMU2)  -- Caso 2: Hora de fin menor que hora de inicio
                              END) + ' '+ CONVERT(VARCHAR, HORARIOPERMU4, 8) AS DATETIME) AS Fecha_y_hora_Fin_2, 
                              CAST(CONVERT(VARCHAR, FECHAPERMU3, 23) + ' ' + CONVERT(VARCHAR, HORARIOPERMU5, 8) AS DATETIME) AS fecha_y_hora_inicio_3,
                              CAST(CONVERT (VARCHAR,
                              CASE 
                                    WHEN HORARIOPERMU5 <= HORARIOPERMU6 THEN FECHAPERMU3  -- Caso 1: Hora de fin mayor que hora de inicio
                                    ELSE DATEADD(day, 1, FECHAPERMU3)  -- Caso 2: Hora de fin menor que hora de inicio
                              END) + ' '+ CONVERT(VARCHAR, HORARIOPERMU6, 8) AS DATETIME) AS Fecha_y_hora_Fin_3,
                              FECHA_SOLICITUD
                        FROM Permuta2) as solapamientos 

                        where ( '".$fecha_inicio_2."' BETWEEN fecha_y_hora_inicio_1 AND Fecha_y_hora_Fin_1 
                              OR '".$fecha_fin_2."' BETWEEN fecha_y_hora_inicio_1 AND Fecha_y_hora_Fin_1
                              OR fecha_y_hora_inicio_1 BETWEEN '".$fecha_inicio_2."' AND '".$fecha_fin_2."'
                              OR Fecha_y_hora_Fin_1 BETWEEN '".$fecha_inicio_2."' AND '".$fecha_fin_2."'
                                    
                              OR '".$fecha_inicio_2."' BETWEEN fecha_y_hora_inicio_2 AND Fecha_y_hora_Fin_2 
                              OR '".$fecha_fin_2."' BETWEEN fecha_y_hora_inicio_2 AND Fecha_y_hora_Fin_2
                              OR fecha_y_hora_inicio_2 BETWEEN '".$fecha_inicio_2."' AND '".$fecha_fin_2."'
                              OR Fecha_y_hora_Fin_2 BETWEEN '".$fecha_inicio_2."' AND '".$fecha_fin_2."'

                              OR '".$fecha_inicio_2."' BETWEEN fecha_y_hora_inicio_3 AND Fecha_y_hora_Fin_3 
                              OR '".$fecha_fin_2."' BETWEEN fecha_y_hora_inicio_3 AND Fecha_y_hora_Fin_3
                              OR fecha_y_hora_inicio_3 BETWEEN '".$fecha_inicio_2."' AND '".$fecha_fin_2."'
                              OR Fecha_y_hora_Fin_3 BETWEEN '".$fecha_inicio_2."' AND '".$fecha_fin_2."'
                              ) and NN='".$NN."'";
*/

?>
