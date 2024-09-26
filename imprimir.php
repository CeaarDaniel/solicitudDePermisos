<?php 
include('./base_de_datos/conexion.php');
 $id = $_GET['id'];
 $tipoPermiso = $_GET['tipoPermiso'];
 $permiso="";
 if($tipoPermiso==6) $permiso="SalidaPersonal";
 if($tipoPermiso==7) $permiso="Permuta2";
 if($tipoPermiso==8) $permiso="SalidaTrabajo";
 if($tipoPermiso==9) $permiso="ViajeTrabajo";

 $sql="select* from ".$permiso." where ID= '".$id."'";
 $consulta = $conn->prepare($sql);
    
    if($consulta->execute()) {
        $row = $consulta->fetch(PDO::FETCH_ASSOC);

            // Combina las fechas y horas
        $fechaHoraInicio = new DateTime($row['FECHA_PERMISOA']. ' ' .$row['HORA1']);
        $fechaHoraFin = new DateTime($row['FECHA_PERMISOB']. ' ' .$row['HORA2']);

        // Calcula la diferencia en horas
        $diferencia = $fechaHoraFin->diff($fechaHoraInicio);
        $diferenciaHoras = ($diferencia->days * 24) + $diferencia->h + ($diferencia->i / 60);

      
        // Calcula el número de días
        if ($diferenciaHoras < 24) {
            $dias = round($diferenciaHoras, 1). " hr";
        } else {
            $dias = ceil($diferenciaHoras / 24); // O usa cualquier otra lógica para determinar los días
        }

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- bootstrap 5 css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- ICONOS --->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <!-- estilo css-->
    <link rel="stylesheet" href="estilos.css">
    <!--Libreria Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!--Data table -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
</head>
<body>

<?PHP
    //Salida personal
      if($tipoPermiso==6){    
          echo '<div id="formulario-a-imprimir">
                    <form>
                        <!--Cabezera del formato -->
                            <div class="row border border-dark mx-1">
                                <div class="col-3 px-0">
                                    <div class="d-flex flex-wrap justify-content-center align-content-center px-0" style="height:100%;">    
                                        <img id="imglogoimpr" src="./img/logo.png" style="max-width:100%; max-height:100%;">
                                    </div>
                                </div>
                                <div class="col-6 border-start border-dark">
                                    <div class="d-flex flex-wrap justify-content-center align-content-center px-0" style="height:100%;"> 
                                        <p class="p-0 m-0 text-center fw-bold">
                                            SOLICITUD Y AUTORIZACIÓN DE VIAJE DE TRABAJO/SALIDA/PERMUTA
                                        </p>
                                    </div> 
                                </div>
                                <div class="col border-start border-dark fw-bold">
                                    <div class="row">
                                        <div class="col-12 p-0 m-0 border-bottom border-dark"><p class="p-0 m-0 text-center"> Control</p></div>
                                        <div class="col-12 p-0 m-0 border-bottom border-dark"><p class="p-0 m-0 text-center">Revisión</p></div>
                                        <div class="col-12 p-0 m-0"><p class="p-0 m-0 text-center">Emisión</p></div>
                                    </div>
                                </div>
                                <div class="col border-start border-dark fw-bold">
                                    <div class="row">
                                        <div class="col-12 p-0 m-0 border-bottom border-dark"><p class="p-0 m-0 text-center">F-AF-009</p></div>
                                        <div class="col-12 p-0 m-0 border-bottom border-dark"><p class="p-0 m-0 text-center">4</p></div>
                                        <div class="col-12 p-0 m-0"><p class="p-0 m-0 text-center">01-SEP</p></div>
                                    </div>
                                </div>
                            </div>
                        <!--Fin de la cabezera -->

                        <!--Datos personales -->
                            <div class="row mx-1 mt-3 mb-0" style="font-size: 14px;">
                                <div class="col-9 my-0 pe-3">
                                    <div class="row mt-1 border border-secondary">
                                            <div class="col-6 p-0 m-0 fw-bold border-end border-secondary">Nombre:</div>
                                            <div class="col p-0 m-0 fw-bold border-end border-secondary">No. nómina:</div>
                                            <div class="col p-0 m-0 fw-bold">Departamento</div>
                                    </div>
                                    <div class="row my-2 border border-secondary">
                                            <div class="col-6 p-0 m-0 border-end border-secondary text-break">'.$row['NOMBRE'].'</div>
                                            <div class="col p-0 m-0 border-end border-secondary text-center text-break">'.$row['NN'].'</div>
                                            <div class="col p-0 m-0">'.$row['DEPARTAMENTO'].'</div>
                                    </div>
                                </div>
                                <div class="col-3 py-0 my-0 border border-dark">
                                    <div class="d-flex justify-content-center align-items-center px-0" style="height:100%; width:100%">
                                        <p class="text-center fw-bold mx-0 px-1 py-0">
                                            FIRMA DEL EMPLEADO:
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row mx-1 my-0" style="font-size: 14px;">
                                <div class="col-9 pe-3">
                                        <div class="row my-1 border border-secondary">
                                            <div class="col-6 fw-bold border-end border-secondary">Código SHOP</div>
                                            <div class="col-6 fw-bold">Fecha de solicitud</div>
                                        </div>
                                        <div class="row my-2 border border-secondary border-secondary">
                                            <div class="col-6 border-end border-secondary"><p class="py-0 my-0 text-break">'.$row['CODIGO_SHOP'].'</p></div>
                                            <div class="col-6"><p class="py-0 my-0 text-break">'.date("d/m/Y", strtotime($row['FECHA_SOLICITUD'])).'</p></div>
                                        </div>
                                        <div class="row my-2 border border-secondary border-secondary">
                                            <div class="col-6 fw-bold border-end border-secondary">Fecha de permiso</div>
                                            <div class="col-6 fw-bold">Horario</div>
                                        </div>
                                        <div class="row my-2 border border-secondary">
                                            <div class="col-1 fw-bold border-end border-secondary">Del:</div>
                                            <div class="col-2 border-end border-secondary">'.date("d/m/Y", strtotime($row['FECHA_PERMISOA'])).'</div>
                                            <div class="col-1 fw-bold border-end border-secondary">Al:</div>
                                            <div class="col-2 border-end border-secondary">'.date("d/m/Y", strtotime($row['FECHA_PERMISOB'])).'</div>
                                            <div class="col-1 fw-bold border-end border-secondary">De:</div>
                                            <div class="col-2 border-end border-secondary">'.date("H:i", strtotime($row['HORA1'])).'</div>
                                            <div class="col-1 fw-bold border-end border-secondary">A:</div>
                                            <div class="col-2">'.date("H:i", strtotime($row['HORA2'])).'</div>
                                        </div>
                                </div>
                                
                                <!--Firma del empelado -->
                                <div class="col-3 py-0 mt-1 mb-0" style="border: 1px dashed blue;">                                
                                </div>
                                <!--Fin de espacio de firma -->
                            </div>

                            <!--CANTIDAD DE DIAS DEL PERMISO -->
                                <div class="row my-1 mx-1 p-0">
                                    <div class="col-1 border-start border-top border-bottom border-secondary"> <b>Dias:</b></div>
                                    <div class="col-2 border border-secondary text-center">'.$dias.'</div>                                
                                </div>
                            <!--FIN DE CANTIDAD DE DIAS DEL PERMISO -->

                        <!--Fin datos personales -->

                        <!--Datos/tipo de permiso -->
                            <div class="row mx-1" style="font-size: 14px;">
                                <div class="col-12 mt-1 bg-primary fw-bold text-light">
                                    3. SALIDA PERSONAL
                                </div>
                            </div>

                            <div class="row mx-1 mt-2 p-0 border border-secondary" style="font-size: 14px;">
                                <div class="col-1 p-0 fw-bold border-end border-secondary">
                                    <p class="text-center p-0 m-0"> 
                                        Motivo:
                                    </p>
                                </div>
                                <div class="col-11 p-0">
                                    <p class="d-flex align-items-center text-break text-uppercase px-0 py-1 mx-0">
                                    '.$row['MOTIVO'].'
                                    </p>
                                </div>
                            </div>
                        <!--Fin Datos/tipo de permiso -->

                        <!--Autorizaciones -->
                            <div class="row mt-2 mx-1" style="font-size: 14px;">
                                <div class="col-12 mt-1 bg-primary fw-bold text-light">
                                    AUTORIZACIONES
                                </div>
                            </div>

                            <!--Espacio para las firmas -->
                            <div class="row mx-1 mt-2 p-0" style="font-size: 14px;">
                                <div class="col-3 p-0">
                                    <div class="text-center p-1 m-0 border border-dark h-100"> 
                                    </div>
                                    <p class="text-center"><b>DIRECTOR GENERAL</b></p>
                                </div>
                                <div class="col-3">
                                    <div class="text-center p-1 m-0 border border-dark h-100">
                                    </div>   
                                    <p class="text-center"><b>DIRECTOR DE ÁREA</b></p> 
                                </div>
                                <div class="col-3">
                                    <div class="text-center p-1 m-0 border border-dark h-100">
                                    </div>
                                    <p class="text-center"><b>JEFE DIRECTO</b></p>
                                </div>
                                <div class="col-3">
                                    <div class="text-center text-break p-1 m-0 border border-dark h-100">
                                    </div>
                                    <p class="text-center"><b>Vo.Bo RH</b></p>
                                </div>
                            </div>
                            <!--Fin espacio para las firmas-->
                        <!--Fin Autorizaciones -->

                        <div class="d-flex d-flex align-items-center mt-3 mx-5">
                                <img src="./img/flecha.png" alt="flecha" style="width:50px; height:50px;">
                                <p class="px-3 mx-0 mt-4 fw-bold border border-dark" style="background-color:#bbbbbb;">ÚNICAMENTE DE SUBDIRECTOR HACIA ARRIBA</p>
                        </div>
                        <p class="consecutivo">'.$id.'</p>
                        <input id="tipoPermiso" name="tipoPermiso" type="hidden" value="salidaPersonal">
                    </form>
                </div>';
      }

      //PERMUTA
      else if($tipoPermiso=="7"){
        echo '
            <div id="formulario-a-imprimir">
                <form>
                    <!--Cabezera del formato -->
                        <div class="row border border-dark mx-1">
                            <div class="col-3 px-0">
                                <div class="d-flex flex-wrap justify-content-center align-content-center px-0" style="height:100%;">    
                                    <img src="./img/logo.png" style="max-width:100%; max-height:100%;">
                                </div>
                            </div>
                            <div class="col-6 border-start border-dark">
                                <div class="d-flex flex-wrap justify-content-center align-content-center px-0" style="height:100%;"> 
                                    <p class="p-0 m-0 text-center fw-bold">
                                        SOLICITUD Y AUTORIZACIÓN DE VIAJE DE TRABAJO/SALIDA/PERMUTA
                                    </p>
                                </div> 
                            </div>
                            <div class="col border-start border-dark fw-bold">
                                <div class="row">
                                    <div class="col-12 p-0 m-0 border-bottom border-dark"><p class="p-0 m-0 text-center"> Control</p></div>
                                    <div class="col-12 p-0 m-0 border-bottom border-dark"><p class="p-0 m-0 text-center">Revisión</p></div>
                                    <div class="col-12 p-0 m-0"><p class="p-0 m-0 text-center">Emisión</p></div>
                                </div>
                            </div>
                            <div class="col border-start border-dark fw-bold">
                                <div class="row">
                                    <div class="col-12 p-0 m-0 border-bottom border-dark"><p class="p-0 m-0 text-center">F-AF-009</p></div>
                                    <div class="col-12 p-0 m-0 border-bottom border-dark"><p class="p-0 m-0 text-center">4</p></div>
                                    <div class="col-12 p-0 m-0"><p class="p-0 m-0 text-center">01-SEP</p></div>
                                </div>
                            </div>
                        </div>
                    <!--Fin de la cabezera -->

                    <!--Datos personales -->
                        <div class="row mx-1 mt-3 mb-0" style="font-size: 14px;">
                            <div class="col-9 my-0 pe-3">
                                <div class="row mt-1 border border-secondary">
                                        <div class="col-6 p-0 m-0 fw-bold border-end border-secondary">Nombre:</div>
                                        <div class="col p-0 m-0 fw-bold border-end border-secondary">No. nómina:</div>
                                        <div class="col p-0 m-0 fw-bold">Departamento</div>
                                </div>
                                <div class="row my-2 border border-secondary">
                                        <div class="col-6 p-0 m-0 border-end border-secondary text-break">'.$row['NOMBRE'].'</div>
                                        <div class="col p-0 m-0 border-end border-secondary text-break text-center">'.$row['NN'].'</div>
                                        <div class="col p-0 m-0">'.$row['DEPARTAMENTO'].'</div>
                                </div>
                            </div>
                            <div class="col-3 py-0 my-0 border border-dark">
                                <div class="d-flex justify-content-center align-items-center px-0" style="height:100%; width:100%">
                                    <p class="text-center fw-bold mx-0 px-1 py-0">
                                        FIRMA DEL EMPLEADO:
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row mx-1 my-0" style="font-size: 14px;">
                                <div class="col-9 pe-3">
                                    <div class="row my-1 border border-secondary">
                                        <div class="col-6 fw-bold border-end border-secondary">Código SHOP</div>
                                        <div class="col-6 fw-bold">Fecha de solicitud</div>
                                    </div>
                                    <div class="row my-2 border border-secondary border-secondary">
                                        <div class="col-6 border-end border-secondary"><p class="py-0 my-0 text-break">'.$row['CODIGO_SHOP'].'</p></div>
                                        <div class="col-6"><p class="py-0 my-0 text-break">'.date("d/m/Y", strtoTime($row['FECHA_SOLICITUD'])).'</p></div>
                                    </div>
                                    <div class="row my-2 border border-secondary border-secondary">
                                        <div class="col-6 fw-bold border-end border-secondary">Fecha de permiso</div>
                                        <div class="col-6 fw-bold">Horario</div>
                                    </div>
                                    <div class="row my-2 border border-secondary">
                                        <div class="col-1 fw-bold border-end border-secondary">Del:</div>
                                        <div class="col-2 border-end border-secondary">'.date("d/m/Y", strtotime($row['FECHA_PERMISOA'])).'</div>
                                        <div class="col-1 fw-bold border-end border-secondary">Al:</div>
                                        <div class="col-2 border-end border-secondary">'.date("d/m/Y", strtotime($row['FECHA_PERMISOB'])).'</div>
                                        <div class="col-1 fw-bold border-end border-secondary">De:</div>
                                        <div class="col-2 border-end border-secondary">'.date("H:i", strtotime($row['HORA1'])).'</div>
                                        <div class="col-1 fw-bold border-end border-secondary">A:</div>
                                        <div class="col-2">'.date("H:i", strtotime($row['HORA2'])).'</div>
                                    </div>
                                </div>

                            <!--Firma del empelado -->
                            <div class="col-3 py-0 mt-1 mb-0" style="border: 1px dashed blue;">                                
                            </div>
                            <!--Fin de espacio de firma -->
                        </div>

                        <!--CANTIDAD DE DIAS DEL PERMISO -->
                            <div class="row my-1 mx-1 p-0">
                                <div class="col-1 border-start border-top border-bottom border-secondary"> <b>Dias:</b></div>
                                <div class="col-2 border border-secondary text-center">'.$dias.'</div>                                
                            </div>
                        <!--FIN DE CANTIDAD DE DIAS DEL PERMISO -->

                            <div class="row mx-1 mt-2 p-0 border border-secondary" style="font-size: 14px;">
                                <div class="col-2 p-0 fw-bold border-end border-secondary">
                                    <p class="text-center p-0 m-0"> 
                                        Motivo:
                                    </p>
                                </div>
                                <div class="col-10 p-0">
                                    <p class="d-flex align-items-center text-break text-uppercase px-0 py-1 m-0">
                                        '.$row['MOTIVO'].'
                                    </p>
                                </div>
                            </div>

                            <div class="row mx-1 mt-2 p-0 border border-secondary" style="font-size: 14px;">
                                <div class="col-2 p-0 fw-bold border-end border-secondary">
                                    <p class="text-center  text-break p-0 m-0"> 
                                        Solicitado:
                                    </p>
                                </div>
                                <div class="col-10 p-0">
                                    <p class="d-flex align-items-center text-break p-0 m-0">
                                        '.$row['SOLICITADO'].'
                                    </p>
                                </div>
                            </div>
                    <!--Fin datos personales -->

                    <!--Datos/tipo de permiso -->
                        <div class="row mx-1 mt-2" style="font-size: 14px;">
                            <div class="col-12 mt-1 bg-primary fw-bold text-light">
                                4. PERMUTA
                            </div>
                        </div>

                        <p class="fw-bold p-0 mx-1 mt-2"  style="font-size: 14px;"> 
                            DÍAS TRABAJADOS
                        </p>
                            
                
                        <div class="row mx-1 mt-0 p-0" style="font-size: 14px;">

                        <div class="col-4 p-0 m-0">
                            <div class="row m-0 p-0">
                                <div class="col-6 p-0 border border-secondary"><p class="m-0 p-0 fw-bold">Día trabajado:</p></div>
                                <div class="col-6 p-0 border-top border-bottom border-end border-secondary"><p class="m-0 p-0">'; 
                                
                                if($row['FECHAPERMU1']!=null || $row['FECHAPERMU1']!='')
                                    echo date("d/m/Y", strtotime($row['FECHAPERMU1'])); 
                                else echo ''; 
                                
                                echo '</p></div>
                                <div class="col-2 p-0 mt-1 border-top border-bottom border-start border-secondary"><p class="m-0 p-0 fw-bold">De</p></div>
                                <div class="col-4 p-0 mt-1 border-top border-bottom border-start border-end border-secondary"><p class="m-0 p-0">'.date("H:i", strtotime($row['HORARIOPERMU1'])).'</p></div>
                                <div class="col-2 p-0 mt-1 border-top border-bottom border-end border-secondary"><p class="m-0 p-0 fw-bold">A</p></div>
                                <div class="col-4 p-0 mt-1 border-top border-bottom border-end border-secondary"><p class="m-0 p-0">'.date("H:i", strtotime($row['HORARIOPERMU2'])).'</p></div>
                                <div class="col-6 p-0 mt-1 border-top border-bottom border-start border-end border-secondary"><p class="m-0 p-0 fw-bold">Hrs. Trabajadas</p></div>
                                <div class="col-6 p-0 mt-1 border-top border-bottom border-end border-secondary"><p class="m-0 p-0">'.$row['HRSTRABAJADAS1_TEMP'].'</p></div>
                            </div>

                        </div>
                        <div class="col-4 ">
                            <div class="row m-0 p-0">
                                <div class="col-6 p-0 border border-secondary"><p class="m-0 p-0 fw-bold">Día trabajado:</p></div> 
                                <div class="col-6 p-0 border-top border-bottom border-end border-secondary"><p class="m-0 p-0">'; 
                                
                                
                                if($row['FECHAPERMU2']!=null || $row['FECHAPERMU2']!='')
                                        echo date("d/m/Y", strtotime($row['FECHAPERMU2'])); 
                                else echo ''; 

                                echo '</p></div>
                                <div class="col-2 p-0 mt-1 border-top border-bottom border-start border-secondary"><p class="m-0 p-0 fw-bold">De</p></div>
                                <div class="col-4 p-0 mt-1 border-top border-bottom border-start border-end border-secondary"><p class="m-0 p-0">'; 
                                if($row["HORARIOPERMU3"] != "" && $row["HORARIOPERMU3"] != null) 
                                     echo date("H:i", strtotime($row['HORARIOPERMU3'])); 
                                  else      echo ' ';
                                
                                echo'</p></div>
                                <div class="col-2 p-0 mt-1 border-top border-bottom border-end border-secondary"><p class="m-0 p-0 fw-bold">A</p></div>
                                <div class="col-4 p-0 mt-1 border-top border-bottom border-end border-secondary"><p class="m-0 p-0">'; 
                                
                                if($row["HORARIOPERMU4"] != "" && $row["HORARIOPERMU4"] != null) 
                                    echo date("H:i", strtotime($row['HORARIOPERMU4'])); 
                                else      echo ' ';

                                echo'</p></div>
                                <div class="col-6 p-0 mt-1 border-top border-bottom border-start bord er-end border-secondary"><p class="m-0 p-0 fw-bold">Hrs. Trabajadas</p></div>
                                <div class="col-6 p-0 mt-1 border-top border-bottom border-end border-secondary"><p class="m-0 p-0">'; 
                                
                                if ($row['HRSTRABAJADAS2_TEMP']==null || empty($row['HRSTRABAJADAS2_TEMP'])) echo '';
                                else echo $row['HRSTRABAJADAS2_TEMP'];
                                
                                echo '</p></div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row m-0 p-0">
                                <div class="col-6 p-0 border border-secondary"><p class="m-0 p-0 fw-bold">Día trabajado:</p></div>
                                <div class="col-6 p-0 border-top border-bottom border-end border-secondary"><p class="m-0 p-0">';
                                
                                if($row['FECHAPERMU3']!=null || $row['FECHAPERMU3']!='')
                                        echo date("d/m/Y", strtotime($row['FECHAPERMU3'])); 
                                else echo ''; 

                                echo '</p></div>
                                <div class="col-2 p-0 mt-1 border-top border-bottom border-start border-secondary"><p class="m-0 p-0 fw-bold">De</p></div>
                                <div class="col-4 p-0 mt-1 border-top border-bottom border-start border-end border-secondary"><p class="m-0 p-0">'; 

                                if($row["HORARIOPERMU5"] != "" && $row["HORARIOPERMU5"] != null) 
                                    echo date("H:i", strtotime($row['HORARIOPERMU5'])); 
                                 else echo ' ';
                                
                                echo '</p></div>
                                <div class="col-2 p-0 mt-1 border-top border-bottom border-end border-secondary"><p class="m-0 p-0 fw-bold">A</p></div>
                                <div class="col-4 p-0 mt-1 border-top border-bottom border-end border-secondary"><p class="m-0 p-0">'; 
                                
                                if($row["HORARIOPERMU6"] != "" && $row["HORARIOPERMU6"] != null) 
                                     echo date("H:i", strtotime($row['HORARIOPERMU6'])); 
                                 else echo ' ';
                                
                                echo'</p></div>
                                <div class="col-6 p-0 mt-1 border-top border-bottom border-start border-end border-secondary"><p class="m-0 p-0 fw-bold">Hrs. Trabajadas</p></div>
                                <div class="col-6 p-0 mt-1 border-top border-bottom border-end border-secondary"><p class="m-0 p-0">'.$row['HRSTRABAJADAS3_TEMP'].'</p></div>
                            </div>
                        </div>
                        </div>

                        <div class="row mx-1 mt-2 p-0" style="font-size: 14px;">
                            <div class="col-4 p-0 fw-bold border border-secondary">
                            </div>
                            <div class="col-4 p-0">
                            <div class="row px-4">
                                <div class="col-12 mx-0 p-0 border border-secondary">
                                    <p class="p-0 m-0 fw-bold">
                                    TOTAL HRS ACUMULADAS:
                                    </p>
                                </div>
                                <div class="col-12 mt-3 border border-secondary">
                                    <p class="m-0 p-0 text-danger">
                                        '.$row['TOTALHRSACUMU_TEMP'].'
                                    </p>
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="row mx-1 mt-2 p-0" style="font-size: 14px;">
                        <div class="col-4">
                            <p class="text-center fw-bold">
                                Vo. Bo. T.I
                            </p>
                        </div>
                        </div>
                    <!--Fin Datos/tipo de permiso -->

                    <!--Autorizaciones -->
                        <div class="row mt-2 mx-1" style="font-size: 14px;">
                            <div class="col-12 mt-1 bg-primary fw-bold text-light">
                                AUTORIZACIONES
                            </div>
                        </div>

                        <!--Espacio para las firmas -->
                        <div class="row mx-1 mt-2 p-0" style="font-size: 14px;">
                            <div class="col-3 p-0">
                                <div class="text-center p-1 m-0 border border-dark h-100"> 
                                </div>
                                <p class="text-center"><b>DIRECTOR GENERAL</b></p>
                            </div>
                            <div class="col-3">
                                <div class="text-center p-1 m-0 border border-dark h-100">
                                </div>   
                                <p class="text-center"><b>DIRECTOR DE ÁREA</b></p> 
                            </div>
                            <div class="col-3">
                                <div class="text-center p-1 m-0 border border-dark h-100">
                                </div>
                                <p class="text-center"><b>JEFE DIRECTO</b></p>
                            </div>
                            <div class="col-3">
                                <div class="text-center text-break p-1 m-0 border border-dark h-100">
                                </div>
                                <p class="text-center"><b>Vo.Bo RH</b></p>
                            </div>
                        </div>
                        <!--Fin espacio para las firmas-->
                    <!--Fin Autorizaciones -->

                    <div class="d-flex d-flex align-items-center mt-3 mx-5">
                            <img src="./img/flecha.png" alt="flecha" style="width:50px; height:50px;">
                            <p class="px-3 mx-0 mt-4 fw-bold border border-dark" style="background-color:#bbbbbb;">ÚNICAMENTE DE SUBDIRECTOR HACIA ARRIBA</p>
                    </div>
                    <p class="consecutivo">'.$id.'</p>
                </form>
            </div>';
      }

      //SALIDA DE TRABAJO
      else if($tipoPermiso=="8"){
        echo' <div id="formulario-a-imprimir">               
                    <form>
                        <!--Cabezera del formato -->
                            <div class="row border border-dark mx-1">
                                <div class="col-3 px-0">
                                    <div class="d-flex flex-wrap justify-content-center align-content-center px-0" style="height:100%;">    
                                        <img src="./img/logo.png" style="max-width:100%; max-height:100%;">
                                    </div>
                                </div>
                                <div class="col-6 border-start border-dark">
                                    <div class="d-flex flex-wrap justify-content-center align-content-center px-0" style="height:100%;"> 
                                        <p class="p-0 m-0 text-center fw-bold">
                                            SOLICITUD Y AUTORIZACIÓN DE VIAJE DE TRABAJO/SALIDA/PERMUTA
                                        </p>
                                    </div> 
                                </div>
                                <div class="col border-start border-dark fw-bold">
                                    <div class="row">
                                        <div class="col-12 p-0 m-0 border-bottom border-dark"><p class="p-0 m-0 text-center"> Control</p></div>
                                        <div class="col-12 p-0 m-0 border-bottom border-dark"><p class="p-0 m-0 text-center">Revisión</p></div>
                                        <div class="col-12 p-0 m-0"><p class="p-0 m-0 text-center">Emisión</p></div>
                                    </div>
                                </div>
                                <div class="col border-start border-dark fw-bold">
                                    <div class="row">
                                        <div class="col-12 p-0 m-0 border-bottom border-dark"><p class="p-0 m-0 text-center">F-AF-009</p></div>
                                        <div class="col-12 p-0 m-0 border-bottom border-dark"><p class="p-0 m-0 text-center">4</p></div>
                                        <div class="col-12 p-0 m-0"><p class="p-0 m-0 text-center">01-SEP</p></div>
                                    </div>
                                </div>
                            </div>
                        <!--Fin de la cabezera -->

                        <!--Datos personales -->
                            <div class="row mx-1 mt-3 mb-0" style="font-size: 14px;">
                                <div class="col-9 my-0 pe-3">
                                    <div class="row mt-1 border border-secondary">
                                            <div class="col-6 p-0 m-0 fw-bold border-end border-secondary">Nombre:</div>
                                            <div class="col p-0 m-0 fw-bold border-end border-secondary">No. nómina:</div>
                                            <div class="col p-0 m-0 fw-bold">Departamento</div>
                                    </div>
                                    <div class="row my-2 border border-secondary">
                                            <div class="col-6 p-0 m-0 border-end border-secondary text-break">'.$row['NOMBRE'].'</div>
                                            <div class="col p-0 m-0 border-end border-secondary text-break text-center">'.$row['NN'].'</div>
                                            <div class="col p-0 m-0">'.$row['DEPARTAMENTO'].'</div>
                                    </div>
                                </div>
                                <div class="col-3 py-0 my-0 border border-dark">
                                    <div class="d-flex justify-content-center align-items-center px-0" style="height:100%; width:100%">
                                        <p class="text-center fw-bold mx-0 px-1 py-0">
                                            FIRMA DEL EMPLEADO:
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row mx-1 my-0" style="font-size: 14px;">
                                <div class="col-9 pe-3">
                                        <div class="row my-1 border border-secondary">
                                            <div class="col-6 fw-bold border-end border-secondary">Código SHOP</div>
                                            <div class="col-6 fw-bold">Fecha de solicitud</div>
                                        </div>
                                        <div class="row my-2 border border-secondary border-secondary">
                                            <div class="col-6 border-end border-secondary"><p class="py-0 my-0 text-break">'.$row['CODIGO_SHOP'].'</p></div>
                                            <div class="col-6"><p class="py-0 my-0 text-break">'.date("d/m/Y", strtotime($row['FECHA_SOLICITUD'])).'</p></div>
                                        </div>
                                        <div class="row my-2 border border-secondary border-secondary">
                                            <div class="col-6 fw-bold border-end border-secondary">Fecha de permiso</div>
                                            <div class="col-6 fw-bold">Horario</div>
                                        </div>
                                        <div class="row my-2 border border-secondary">
                                            <div class="col-1 fw-bold border-end border-secondary">Del</div>
                                            <div class="col-2 border-end border-secondary">'.date("d/m/Y", strtotime($row['FECHA_PERMISOA'])).'</div>
                                            <div class="col-1 fw-bold border-end border-secondary">Al</div>
                                            <div class="col-2 border-end border-secondary">'.date("d/m/Y",strtotime($row['FECHA_PERMISOB'])).'</div>
                                            <div class="col-1 fw-bold border-end border-secondary">De</div>
                                            <div class="col-2 border-end border-secondary">'.date("H:i",strtotime($row['HORA1'])).'</div>
                                            <div class="col-1 fw-bold border-end border-secondary">A</div>
                                            <div class="col-2">'.date("H:i",strtotime($row['HORA2'])).'</div>
                                        </div>
                                </div>

                                <!--Firma del empelado -->
                                <div class="col-3 py-0 mt-1 mb-0" style="border: 1px dashed blue;">                                
                                </div>
                                <!--Fin de espacio de firma -->
                            </div>

                            <!--CANTIDAD DE DIAS DEL PERMISO -->
                                <div class="row my-1 mx-1 p-0">
                                    <div class="col-1 border-start border-top border-bottom border-secondary"> <b>Dias:</b></div>
                                    <div class="col-2 border border-secondary text-center">'.$dias.'</div>                                
                                </div>
                            <!--FIN DE CANTIDAD DE DIAS DEL PERMISO -->

                        <!--Fin datos personales -->

                        <!--Datos/tipo de permiso -->
                            <div class="row mx-1" style="font-size: 14px;">
                                <div class="col-12 mt-1 bg-primary fw-bold text-light">
                                    2. SALIDA DE TRABAJO
                                </div>
                            </div>

                            <div class="row mx-1 mt-2 p-0 border border-secondary" style="font-size: 14px;">
                                <div class="col-3 p-0 m-0 fw-bold border-end border-secondary">
                                    <p class="p-0 m-0">
                                            Lugar (empresa institucion)
                                    </p>
                                </div>
                                <div class="col-9 border-end border-secondary">
                                    <p class="p-0 m-0 text-break text-uppercase">
                                        '.$row['LUGAR'].'
                                    </p>    
                                </div>
                            </div>

                            <div class="row mx-1 mt-2 p-0 border border-secondary" style="font-size: 14px;">
                                <div class="col-1 p-0 border-end border-secondary">
                                    <p class="text-center p-0 fw-bold  p-0 m-0"> 
                                        Ciudad:
                                    </p>
                                </div>
                                <div class="col-11 border-end border-secondary">
                                    <p class=" p-0 m-0 text-uppercase">
                                        '.$row['CIUDAD'].'
                                    </p>    
                                </div>
                            </div>

                            <div class="row mx-1 mt-2 p-0 border border-secondary" style="font-size: 14px;">
                                <div class="col-1 p-0 fw-bold border-end border-secondary">
                                    <p class="text-center p-0 m-0"> 
                                        Motivo:
                                    </p>
                                </div>
                                <div class="col-11 p-0">
                                    <p class="d-flex align-items-center text-break px-0 py-1 mx-0 text-uppercase">
                                        '.$row['MOTIVO'].'
                                    </p>
                                </div>
                            </div>
                        <!--Fin Datos/tipo de permiso -->

                        <!--Autorizaciones -->
                            <div class="row mt-2 mx-1" style="font-size: 14px;">
                                <div class="col-12 mt-1 bg-primary fw-bold text-light">
                                    AUTORIZACIONES
                                </div>
                            </div>

                            <!--Espacio para las firmas -->
                            <div class="row mx-1 mt-2 p-0" style="font-size: 14px;">
                                <div class="col-3 p-0">
                                    <div class="text-center p-1 m-0 border border-dark h-100"> 
                                    </div>
                                    <p class="text-center"><b>DIRECTOR GENERAL</b></p>
                                </div>
                                <div class="col-3">
                                    <div class="text-center p-1 m-0 border border-dark h-100">
                                    </div>   
                                    <p class="text-center"><b>DIRECTOR DE ÁREA</b></p> 
                                </div>
                                <div class="col-3">
                                    <div class="text-center p-1 m-0 border border-dark h-100">
                                    </div>
                                    <p class="text-center"><b>JEFE DIRECTO</b></p>
                                </div>
                                <div class="col-3">
                                    <div class="text-center text-break p-1 m-0 border border-dark h-100">
                                    </div>
                                    <p class="text-center"><b>Vo.Bo RH</b></p>
                                </div>
                            </div>
                            <!--Fin espacio para las firmas-->
                        <!--Fin Autorizaciones -->
                
                        <div class="d-flex d-flex align-items-center mt-3 mx-5">
                                <img src="./img/flecha.png" alt="flecha" style="width:50px; height:50px;">
                                <p class="px-3 mx-0 mt-4 fw-bold border border-dark" style="background-color:#bbbbbb;">ÚNICAMENTE DE SUBDIRECTOR HACIA ARRIBA</p>
                        </div>
                        <p class="consecutivo">'.$id.'</p>
                    </form>
                </div>';
      }

      //VIAJE DE TRABAJO
      else if($tipoPermiso=="9"){
        echo '
            <div id="formulario-a-imprimir">
                <form>
                    <!--Cabezera del formato -->
                        <div class="row border border-dark mx-1">
                            <div class="col-3 px-0">
                                <div class="d-flex flex-wrap justify-content-center align-content-center px-0" style="height:100%;">    
                                    <img src="./img/logo.png" style="max-width:100%; max-height:100%;">
                                </div>
                            </div>
                            <div class="col-6 border-start border-dark">
                                <div class="d-flex flex-wrap justify-content-center align-content-center px-0" style="height:100%;"> 
                                    <p class="p-0 m-0 text-center fw-bold">
                                        SOLICITUD Y AUTORIZACIÓN DE VIAJE DE TRABAJO/SALIDA/PERMUTA
                                    </p>
                                </div> 
                            </div>
                            <div class="col border-start border-dark fw-bold">
                                <div class="row">
                                    <div class="col-12 p-0 m-0 border-bottom border-dark"><p class="p-0 m-0 text-center"> Control</p></div>
                                    <div class="col-12 p-0 m-0 border-bottom border-dark"><p class="p-0 m-0 text-center">Revisión</p></div>
                                    <div class="col-12 p-0 m-0"><p class="p-0 m-0 text-center">Emisión</p></div>
                                </div>
                            </div>
                            <div class="col border-start border-dark fw-bold">
                                <div class="row">
                                    <div class="col-12 p-0 m-0 border-bottom border-dark"><p class="p-0 m-0 text-center">F-AF-009</p></div>
                                    <div class="col-12 p-0 m-0 border-bottom border-dark"><p class="p-0 m-0 text-center">4</p></div>
                                    <div class="col-12 p-0 m-0"><p class="p-0 m-0 text-center">01-SEP</p></div>
                                </div>
                            </div>
                        </div>
                    <!--Fin de la cabezera -->

                    <!--Datos personales -->
                        <div class="row mx-1 mt-3 mb-0" style="font-size: 14px;">
                            <div class="col-9 my-0 pe-3">
                                <div class="row mt-1 border border-secondary">
                                        <div class="col-6 p-0 m-0 fw-bold border-end border-secondary">Nombre:</div>
                                        <div class="col p-0 m-0 fw-bold border-end border-secondary">No. nómina:</div>
                                        <div class="col p-0 m-0 fw-bold">Departamento</div>
                                </div>
                                <div class="row my-2 border border-secondary">
                                        <div class="col-6 p-0 m-0 border-end border-secondary text-break">'.$row['NOMBRE'].'</div>
                                        <div class="col p-0 m-0 border-end border-secondary text-center text-break">'.$row['NN'].'</div>
                                        <div class="col p-0 m-0">'.$row['DEPARTAMENTO'].'</div>
                                </div>
                            </div>
                            <div class="col-3 py-0 my-0 border border-dark">
                                <div class="d-flex justify-content-center align-items-center px-0" style="height:100%; width:100%">
                                    <p class="text-center fw-bold mx-0 px-1 py-0">
                                        FIRMA DEL EMPLEADO:
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row mx-1 my-0" style="font-size: 14px;">
                            <div class="col-9 pe-3">
                                    <div class="row my-1 border border-secondary">
                                        <div class="col-6 fw-bold border-end border-secondary">Código SHOP</div>
                                        <div class="col-6 fw-bold">Fecha de solicitud</div>
                                    </div>
                                    <div class="row my-2 border border-secondary border-secondary">
                                        <div class="col-6 border-end border-secondary"><p class="py-0 my-0 text-break">'.$row['CODIGO_SHOP'].'</p></div>
                                        <div class="col-6"><p class="py-0 my-0 text-break">'.date("d/m/Y", strtotime($row['FECHA_SOLICITUD'])).'</p></div>
                                    </div>
                                    <div class="row my-2 border border-secondary border-secondary">
                                        <div class="col-6 fw-bold border-end border-secondary">Fecha de permiso</div>
                                        <div class="col-6 fw-bold">Horario</div>
                                    </div>
                                    <div class="row my-2 border border-secondary">
                                        <div class="col-1 fw-bold border-end border-secondary">Del:</div>
                                        <div class="col-2 border-end border-secondary">'.date("d/m/Y", strtotime($row['FECHA_PERMISOA'])).'</div>
                                        <div class="col-1 fw-bold border-end border-secondary">Al:</div>
                                        <div class="col-2 border-end border-secondary">'.date("d/m/Y", strtotime($row['FECHA_PERMISOB'])).'</div>
                                        <div class="col-1 fw-bold border-end border-secondary">De:</div>
                                        <div class="col-2 border-end border-secondary">'.date("H:i", strtotime($row['HORA1'])).'</div>
                                        <div class="col-1 fw-bold border-end border-secondary">A:</div>
                                        <div class="col-2">'.date("H:i", strtotime($row['HORA2'])).'</div>
                                    </div>
                            </div>

                            <!--Firma del empelado -->
                            <div class="col-3 py-0 mt-1 mb-0" style="border: 1px dashed blue;">                                
                            </div>
                            <!--Fin de espacio de firma -->
                        </div>
                    <!--Fin datos personales -->

                    <!--Datos/tipo de permiso -->
                        <div class="row mx-1" style="font-size: 14px;">
                            <div class="col-12 mt-1 bg-primary fw-bold text-light">
                                1. VIAJE DE TRABAJO
                            </div>
                        </div>

                        <div class="row mx-1 mt-2 p-0 border border-secondary" style="font-size: 14px;">
                            <div class="col-2 p-0 fw-bold border-end border-secondary">
                                <p class="text-center p-0 m-0"> 
                                    Cantidad de días:
                                </p>
                            </div>
                            <div class="col-3 fw-bold border-end border-secondary">
                                <p class="text-center p-0 m-0">
                                    Ciudad:
                                </p>    
                            </div>
                            <div class="col-4 fw-bold border-end border-secondary">
                                <p class="text-center p-0 m-0">
                                    Lugar:
                                </p>
                            </div>
                            <div class="col-3 p-0 fw-bold">
                                <p class="text-center p-0 m-0">
                                    ¿Requier gastos de viaje?
                                </p>
                            </div>
                        </div>

                        <div class="row mx-1 mt-2 p-0 border border-secondary" style="font-size: 14px;">
                            <div class="col-2 p-0 border-end border-secondary">
                                <p class="text-center p-0 m-0 text-break text-uppercase"> 
                                    '.$row['CANTDIAS'].'
                                </p>
                            </div>
                            <div class="col-3 border-end border-secondary">
                                <p class="text-center p-0 m-0 text-break text-uppercase">
                                    '.$row['CIUDAD'].'
                                </p>    
                            </div>
                            <div class="col-4 border-end border-secondary">
                                <p class="text-center p-0 m-0 text-break text-uppercase">
                                    '.$row['LUGAR'].'
                                </p>
                            </div>
                            <div class="col-3 p-0">
                                <p class="text-center text-break text-uppercase p-0 m-0">
                                    '.$row['GASTOS'].'
                                </p>
                            </div>
                        </div>

                        <div class="row mx-1 mt-2 p-0 border border-secondary" style="font-size: 14px;">
                            <div class="col-1 p-0 fw-bold border-end border-secondary">
                                <p class="text-center p-0 m-0"> 
                                    Motivo:
                                </p>
                            </div>
                            <div class="col-11 p-0">
                                <p class="d-flex align-items-center text-break text-uppercase px-0 py-1 mx-0">
                                    '.$row['MOTIVO'].'
                                </p>
                            </div>
                        </div>
                    <!--Fin Datos/tipo de permiso -->

                    <!--Desgloce de gastos-->
                        <div class="row mx-1" style="font-size: 14px;">
                            <div class="col-12 mt-1 bg-primary fw-bold text-light">
                                DESGLOSE DE GASTOS:
                            </div>
                        </div>

                        <div class="row mx-1 mt-2 p-0 border border-secondary" style="font-size: 14px;">
                            <div class="col-2 p-0 fw-bold border-end border-secondary">
                                <p class="text-center p-0 m-0"> 
                                    Caseta:
                                </p>
                            </div>
                            <div class="col-2 fw-bold border-end border-secondary">
                                <p class="text-center p-0 m-0">
                                    Gasolina:
                                </p>    
                            </div>
                            <div class="col-2 fw-bold border-end border-secondary">
                                <p class="text-center p-0 m-0">
                                    Hotel:
                                </p>
                            </div>
                            <div class="col-2 p-0 fw-bold border-end border-secondary">
                                <p class="text-center p-0 m-0">
                                    Comidas:
                                </p>
                            </div>
                            <div class="col-2 p-0 fw-bold border-end border-secondary">
                                <p class="text-center p-0 m-0">
                                    Taxi:
                                </p>
                            </div>
                            <div class="col-2 p-0 fw-bold">
                                <p class="text-center p-0 m-0">
                                    Otros
                                </p>
                            </div>
                        </div>

                        <div class="row mx-1 mt-2 p-0 border border-secondary" style="font-size: 14px;">
                            <div class="col-2 p-0 border-end border-secondary">
                                <p class="text-center p-0 m-0"> 
                                    '.$row['CASETAS'].'
                                </p>
                            </div>
                            <div class="col-2 border-end border-secondary">
                                <p class="text-center p-0 m-0">
                                    '.$row['GASOLINA'].'
                                </p>    
                            </div>
                            <div class="col-2 border-end border-secondary">
                                <p class="text-center p-0 m-0">
                                    '.$row['HOTEL'].'
                                </p>
                            </div>
                            <div class="col-2 p-0 border-end border-secondary">
                                <p class="text-center text-break p-0 m-0">
                                    '.$row['COMIDAS'].'
                                </p>
                            </div>
                            <div class="col-2 p-0 border-end border-secondary">
                                <p class="text-center text-break p-0 m-0">
                                    '.$row['TAXI'].'
                                </p>
                            </div>
                            <div class="col-2 p-0">
                                <p class="text-center text-break p-0 m-0">
                                    '.$row['OTROS'].'
                                </p>
                            </div>
                        </div>

                        <div class="row mx-1 mt-2 p-0" style="font-size: 14px;">
                            <div class="col-1 p-0 fw-bold border border-secondary">
                                <p class="text-center p-0 m-0"> 
                                    TOTAL:
                                </p>
                            </div>
                            <div class="col-5 p-0 border-end border-top border-bottom border-secondary ">
                                <p class="text-center text-break p-0 m-0">
                                    '.$row['TOTAL'].'
                                </p>
                            </div>
                        </div>
                    <!--Fin Desgloce de gastos-->

                    <!--Autorizaciones -->
                        <div class="row mt-2 mx-1" style="font-size: 14px;">
                            <div class="col-12 mt-1 bg-primary fw-bold text-light">
                                AUTORIZACIONES
                            </div>
                        </div>

                        <!--Espacio para las firmas -->
                        <div class="row mx-1 mt-2 p-0" style="font-size: 14px;">
                            <div class="col-3 p-0">
                                <div class="text-center p-1 m-0 border border-dark h-100"> 
                                </div>
                                <p class="text-center"><b>DIRECTOR GENERAL</b></p>
                            </div>
                            <div class="col-3">
                                <div class="text-center p-1 m-0 border border-dark h-100">
                                </div>   
                                <p class="text-center"><b>DIRECTOR DE ÁREA</b></p> 
                            </div>
                            <div class="col-3">
                                <div class="text-center p-1 m-0 border border-dark h-100">
                                </div>
                                <p class="text-center"><b>JEFE DIRECTO</b></p>
                            </div>
                            <div class="col-3">
                                <div class="text-center text-break p-1 m-0 border border-dark h-100">
                                </div>
                                <p class="text-center"><b>Vo.Bo RH</b></p>
                            </div>
                        </div>
                        <!--Fin espacio para las firmas-->
                    <!--Fin Autorizaciones -->

                    <div class="d-flex d-flex align-items-center mt-3 mx-5">
                            <img src="./img/flecha.png" alt="flecha" style="width:50px; height:50px;">
                            <p class="px-3 mx-0 mt-4 fw-bold border border-dark" style="background-color:#bbbbbb;">ÚNICAMENTE DE SUBDIRECTOR HACIA ARRIBA</p>
                    </div>
                    <p class="consecutivo">'.$id.'</p>
                </form>
            </div>';
      }
    

    ?>

    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
   
    <!-- custom js -->
    <script>

        window.addEventListener("load", function (event) {
           window.print();
        });

        window.onafterprint = function() {
           window.close();
        };
    </script>
</body>
</html>