<?php date_default_timezone_set('Etc/GMT+6');?>

<!-- Modal -->
<div class="modal fade" id="modalPermuta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">GUIA DE IMPRESIÓN DE PERMISOS</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="row">

        <div class="col-12 my-2">
            <p class="text-center fw-bold mt-2">Si algún dato obligatorio no ha sido llenado, se mostrará un texto en color rojo indicado que debe ser completado el campo.</p>
            <div class="d-flex justify-content-center" style="width:100%">
                <img class="border border-dark" src="./img/completarpermuta.png" alt="ajuste de impresion google" style="max-width:100%; height:auto;">
            </div>  
        </div> 

        <div>
            <p class="text-justify fw-bold mt-2">
                Si la hora de finalización del permiso es menor a la hora de inicio, en la fecha de fin hay que colocar una fecha mayor a la fecha de inicio. <br>
                Por ejemplo, si el permiso será de las 11 de la noche a las 8 de la mañana y la fecha de inicio es el día 10 del mes, la fecha de fin deberá de ser el día 11.
            </p>
            <div class="d-flex justify-content-center" style="width:100%">
                <img  class="border border-dark" src="./img/rangohorariopermuta.png" alt="ajuste de impresion google" style="max-width:100%; height:auto;">
            </div>
        </div>

        <div>
            <p class="text-justify fw-bold mt-2">
                En el registro de una permuta, hay que ingresar el horario completo en el que se trabajó, para que se haga el cálculo de las horas acumuladas
            </p>
            <div class="d-flex justify-content-center" style="width:100%">
                <img  class="border border-dark" src="./img/horariopermuta.png" alt="ajuste de impresion google" style="max-width:100%; height:auto;">
            </div>
        </div>

        <div class="col-12 my-2">
            <p class="text-center fw-bold mt-2">Para imprimir el permiso solo hay que presionar el icono de impresión, ubicado en la parte inferior derecha. </p>
            <div class="d-flex justify-content-center" style="width:100%">
                <img class="border border-dark" src="./img/imprimir.png" alt="ajuste de impresion google" style="max-width:100%; height:auto;">
            </div>  
        </div> 

        <div class="col-12 my-2">
            <p class="text-justify text-danger fw-bold mt-2">
                 UNA VEZ QUE SE HA PRESIONADO SOBRE EL ICONO DE IMPRESIÓN Y SE HA ABIERTO EL CUADRO DE IMPRESIÓN, EL PERMISO QUEDA REGISTRADO EN EL SISTEMA, YA SEA QUE SE IMPRIMA O NO. <br>
                 SI EL PERMISO NO SE VA A IMPRIMIR EN ESE MOMENTO ES RECOMENDABLE GUÁRDALO COMO PDF PARA SU POSTERIOR IMPRESIÓN, YA QUE DE INTENTAR REGISTRAR UN NUEVO PERMISO CON EL MISMO RANGO DE FECHAS EL SISTEMA ARROJARA UNA ALERTA 
           </p>
           <div class="d-flex justify-content-center" style="width:100%">
                <img class="border border-dark" src="./img/permutaimpresa.png" alt="ajuste de impresion google" style="max-width:100%; height:auto;">
            </div>  
           
        </div>

    </div>
      </div>
    </div>
  </div> 
</div>
<!--Fin del modal-->

<!--Solicitud de permuta-->
        <div class="d-flex aling-content-center justify-content-center" id="formulario" name="formulario">
            <!--Formulario de llenado-->
                <form id="formulario-llenado" class="form-control px-5 border border-secondary border-2 rounded" style="max-width:90%;">
                        <p class="px-3 text-center fs-5">
                            <b> DATOS GENERALES</b>
                        </p>

                        <div class="row m-0 px-0">
                            <div class="col-12 col-md-6 my-2 px-0">
                                <div class="d-flex flex-column flex-wrap">
                                    <label class="input-group fw-bold px-1" for="NN" style="max-width:240px;">NÚMERO DE NÓMINA</label>  
                                    <input class="in icon-input" id="NN" name="NN" type="number" style="width:70%;"  min=2 placeholder="&#xf2b9; Escriba su número de nómina" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 my-2 px-0">
                                <div class="d-flex flex-column flex-wrap">
                                    <label class="input-group fw-bold px-1" for="NN" style="max-width:240px;">NOMBRE</label>  
                                    <input class="in icon-input" id="NOMBRE" name="NOMBRE" type="text" placeholder="&#xf02d; Nombre" style="max-width:70%;" readonly>
                                </div> 
                            </div>
                            <div class="col-12 col-md-6 my-2 px-0">
                                <div class="d-flex flex-column flex-wrap">
                                    <label class="input-group fw-bold" for="NN" style="max-width:240px;">DEPARTAMENTO</label>  
                                    <input class="in icon-input" id="DEPARTAMENTO" name="DEPARTAMENTO" type="text" placeholder="&#xf029; Departamento" style="width:70%;" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 my-2 px-0">
                                <div class="d-flex flex-column flex-wrap">
                                    <label class="input-group fw-bold" style="max-width:240px;">CÓDIGO SHOP</label>
                                    <select class="in icon-input" name="CODIGO_SHOP" id="CODIGO_SHOP" style="width:70%;" required>
                                        <option value="" selected="selected">&#xf02a; ---Código shop---</option>
                                        <option value="1110 JMEX PLUNGER (APZ y AVO)">1110 JMEX PLUNGER (APZ y AVO)</option>
                                        <option value="1111 APZ sleeve">1111 APZ sleeve</option>
                                        <option value="1112 AVO Cover">1112 AVO Cover</option>
                                        <option value="1113 AXO PISTON">1113 AXO PISTON</option>
                                        <option value="1120 STABILINK Manual">1120 STABILINK Manual</option>
                                        <option value="1121 STABILINK Automatica">1121 STABILINK Automatica</option>
                                        <option value="1122 STABILINK Automatica FORD">1122 STABILINK Automatica FORD</option>
                                        <option value="1130 CARRIER">1130 CARRIER</option>
                                        <option value="1131 HUB TWO WAY">1131 HUB TWO WAY</option>
                                        <option value="1140 CAP-BRG">1140 CAP-BRG</option>
                                        <option value="1150 B R K T">1150 B R K T</option>
                                        <option value="1160 COVER HUB">1160 COVER HUB </option>
                                        <option value="1160 PUM HUB">1160 PUM HUB</option>
                                        <option value="1160 VALEO">1160 VALEO</option>
                                        <option value="1170 HOUSING">1170 HOUSING</option>
                                        <option value="1170 NSK WARNER">1170 NSK WARNER</option>
                                        <option value="1180 HAL/AAM">1180 HAL/AAM</option>
                                        <option value="1180 OUTLET WATER">1180 OUTLET WATER</option>
                                        <option value="1190 Grupo Administracion">1190 Grupo Administracion</option>
                                        <option value="1210 MOLDES MX">1210 MOLDES MX</option>
                                        <option value="1220 MOLDES JP">1220 MOLDES JP</option>
                                        <option value="5210 Grupo de Administracion">5210 Grupo de Administracion</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row m-0 px-0">
                            <div class="col-12 my-2 px-0">
                                <div class="d-flex flex-column flex-wrap"> 
                                    <label class="input-group fw-bold" style="max-width:240px;">FECHA DE REGISTRO</label>
                                    <input id="FECHA_SOLICITUD" name="FECHA_SOLICITUD" class="in" type="datetime-local" style="max-width:360px;" value="<?php echo date("Y-m-d H:i")?>" readonly>
                                </div>
                            </div>
                                <div class="col-12 my-2 px-0">
                                    <div class="d-flex flex-column flex-wrap"> 
                                        <label class="input-group fw-bold" style="max-width:240px;">FECHA DEL PERMISO</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-5 col-xl-3 my-2">
                                    <label class="input-group fw-bold" style="max-width:240px;">DEL</label>
                                    <input id="FECHA_PERMISOA" name="FECHA_PERMISOA" class="in" type="date" min="<?php echo date('Y-m-d', strtotime('-3 months')); ?>" max="<?php echo date('Y-m-d', strtotime('+ 1 year')); ?>" style="max-width:auto;" required/>
                                </div>
                                <div class="col-12 col-md-5 col-xl-3 my-2">
                                    <label class="input-group fw-bold" style="max-width:240px;">AL</label>
                                    <input id="FECHA_PERMISOB" name="FECHA_PERMISOB" class="in" type="date" min="<?php echo date('Y-m-d', strtotime('-3 months')); ?>" max="<?php echo date('Y-m-d', strtotime('+ 1 year')); ?>" style="max-width:auto;" required/>
                                </div>
                                <div class="col-12 col-md-5 col-xl-3 my-2">
                                    <label class="input-group fw-bold" style="max-width:240px;">DE</label>
                                    <input id="HORA1" name="HORA1" class="in" type="time" style="max-width:auto;" required/>
                                </div>
                                <div class="col-12 col-md-5 col-xl-3 my-2" style="max-width:240px;">
                                    <label class="input-group fw-bold">A</label>
                                    <input id="HORA2" name="HORA2" class="in" type="time" style="max-width:auto;" required/>
                                </div>

                                <div>
                                <p class="text-danger fw-bold">
                                    *Si la hora de finalización del permiso es menor a la hora de inicio, en la fecha de fin hay que colocar una fecha mayor a la fecha de inicio.
                                </p>
                                </div>
                        </div>

                        <div class="row mx-0">
                            <div class="col-12 col-md-8 my-2">
                                <label class="input-group fw-bold" style="max-width:300px;">MOTIVO</label>
                                <textarea id="MOTIVO" name="MOTIVO" class="in icon-input text-uppercase" rows="4" maxlength=500 placeholder="&#xf022; Motivo del permiso" style="width:100%" required></textarea>
                            </div>
                        </div>

                        <p class="px-3 text-center fs-5"><b>PERMUTA</b></p>

                        <div class="row mx-0">
                            <div class="col-12 col-md-5 col-xl-3 my-2">
                                <label class="input-group fw-bold" style="max-width:240px;">DÍA TRABAJADO</label>
                                <input id="FECHAPERMU1" name="FECHAPERMU1" class="in" type="date" min="<?php echo date('Y-m-d', strtotime('-3 months')); ?>"  style="max-width:auto;" required/>
                            </div>
                            <div class="col-12 col-md-5 col-xl-3 my-2">
                                <label class="input-group fw-bold" style="max-width:240px;">DE</label>
                                <input id="HORARIOPERMU1" name="HORARIOPERMU1" class="in" type="time" style="max-width:auto;" required/>
                            </div>
                            <div class="col-12 col-md-5 col-xl-3 my-2">
                                <label class="input-group fw-bold" style="max-width:240px;">A</label>
                                <input id="HORARIOPERMU2" name="HORARIOPERMU2" class="in" type="time" style="max-width:auto;" required/>
                            </div>
                        </div>

                        <hr>
                        
                        <div class="row mx-0">
                            <div class="col-12 col-md-5 col-xl-3 my-2">
                                <label class="input-group fw-bold" style="max-width:240px;">DÍA TRABAJADO</label>
                                <input id="FECHAPERMU2" name="FECHAPERMU2" class="in" type="date" min="<?php echo date('Y-m-d', strtotime('-3 months')); ?>"  style="max-width:auto;"/>
                            </div>
                            <div class="col-12 col-md-5 col-xl-3 my-2">
                                <label class="input-group fw-bold" style="max-width:240px;">DE</label>
                                <input id="HORARIOPERMU3" name="HORARIOPERMU3" class="in" type="time" style="max-width:auto;" disabled/>
                            </div>
                            <div class="col-12 col-md-5 col-xl-3 my-2">
                                <label class="input-group fw-bold" style="max-width:240px;">A</label>
                                <input id="HORARIOPERMU4" name="HORARIOPERMU4" class="in" type="time" style="max-width:auto;" disabled/>
                            </div>
                        </div>

                        <hr>
                        
                        <div class="row mx-0">
                            <div class="col-12 col-md-5 col-xl-3 my-2">
                                <label class="input-group fw-bold" style="max-width:240px;">DÍA TRABAJADO</label>
                                <input id="FECHAPERMU3" name="FECHAPERMU3" class="in" type="date" min="<?php echo date('Y-m-d', strtotime('-3 months')); ?>"  style="max-width:auto;"/>
                            </div>
                            <div class="col-12 col-md-5 col-xl-3 my-2">
                                <label class="input-group fw-bold" style="max-width:240px;">DE</label>
                                <input id="HORARIOPERMU5" name="HORARIOPERMU5" class="in" type="time" style="max-width:auto;" disabled/>
                            </div>
                            <div class="col-12 col-md-5 col-xl-3 my-2">
                                <label class="input-group fw-bold" style="max-width:240px;">A</label>
                                <input id="HORARIOPERMU6" name="HORARIOPERMU6" class="in" type="time" style="max-width:auto;" disabled/>
                            </div>

                            <div>
                                <p class="text-danger fw-bold">
                                    *Hay que ingresar el horario completo en el que se trabajó, para que se haga el cálculo de las horas acumuladas
                                </p>
                            </div>
                        </div>
                        <input id="tipoPermiso" name="tipoPermiso" type="hidden" value="permuta">
                </form>
            <!--Formulario de llenado-->
        </div>

        <!--Boton de impresion -->
            <div class="d-grid gap-2 d-md-block my-5">
                <button id="boton-imprimir" class="btn boton imprimir">
                    <i class="fas fa-print fa-2x"></i>
                </button>
                <button class="btn boton volver px-2" type="submit" onclick="cargarContenido('menu', 'SOLICITUD DE PERMISOS')">
                    <i class="fas fa-chevron-left fa-2x"></i>
                </button> 
            </div>
        <!-- Fin boton de impresion-->

        <!-- Formullario a imprimir -->
            <div id="formulario-a-imprimir">
            </div>
        <!--Fin formulario a imprimir-->

<!--Fin solicitud de permuta-->

    <!--Precargado de las imagenes de la hoja de impresion-->
        <div style="opacity:0">
            <img src='./img/logo.png' style="max-width:100%; max-height:100%;">
            <img src="./img/flecha.png" alt="flecha" style="width:50px; height:50px;">
        </div>
    <!--Fin precargado de imagenes-->    