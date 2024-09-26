<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">GUIA DE IMPRESIÓN DE PERMISOS</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="row">
        <div class="col-12 my-2">
            <p class="text-center fw-bold mt-2">Para imprimir el permiso solo hay que presionar el icono de impresión, ubicado en la parte inferior derecha. </p>
            <div class="d-flex justify-content-center" style="width:100%">
                <img class="border border-dark" src="./img/imprimir.png" alt="ajuste de impresion google" style="max-width:100%; height:auto;">
            </div>  
        </div> 
        <div class="col-12 my-2">
            <p class="text-center fw-bold mt-2">Si algún dato obligatorio no ha sido llenado, se mostrará un texto en color rojo indicado que debe ser completado el campo.</p>
            <div class="d-flex justify-content-center" style="width:100%">
                <img class="border border-dark" src="./img/completar.png" alt="ajuste de impresion google" style="max-width:100%; height:auto;">
            </div>  
        </div> 
        <div class="col-12 my-2">
            <p class="text-center fw-bold mt-2">Una vez llenado correctamente el formulario, al presionar el botón de impresión, el permiso quedará registrado en el sistema y se abrirá un cuadro de impresión como el de la siguiente imagen</p>
            <div class="d-flex justify-content-center" style="width:100%">
                <img class="border border-dark" src="./img/cuadro_de_impresion.png" alt="cuadro de impresion" style="max-width:100%; height:auto;">
            </div>  
        </div> 
        <div class="col-12 my-2">
            <p class="text-center fw-bold mt-2">Si se quiere que el permiso sea a color, hay que seleccionar la opción de color y en la sección de más ajustas hay que habilitar la opción que dice gráficos de fondo</p>
            <div class="d-flex justify-content-center" style="width:100%">
                <img  class="border border-dark" src="./img/ajustes de impresion.png" alt="ajuste de impresion google" style="max-width:100%; height:auto;">
            </div>
        </div>
        <div class="col-12 my-2">
            <p class="text-center fw-bold mt-2">Una vez echas estas configuraciones el permiso lucirá de la siguiente manera</p>
            <div class="d-flex justify-content-center" style="width:100%">
                <img  class="border border-dark" src="./img/impresion_color.png" alt="ajuste de impresion google" style="max-width:100%; height:auto;">
            </div>
        </div>
        <div class="col-12 my-2">
            <p class="text-center fw-bold mt-2">Y por último solo hay que presionar el botón que dice imprimir.</p>
            <div class="d-flex justify-content-center" style="width:100%">
                <img  class="border border-dark" src="./img/imprimir_permiso.png" alt="ajuste de impresion google" style="max-width:100%; height:auto;">
            </div>
        </div>
        <div class="col-12 my-2">
            <p class="text-center fw-bold mt-2">Para navegar hacia una ventana anterior, hay que presionar el botón de color azul con una flecha apuntando hacia la izquierda.</p>
            <div class="d-flex justify-content-center" style="width:100%">
                <img  class="border border-dark" src="./img/atras.png" alt="ajuste de impresion google" style="max-width:100%; height:auto;">
            </div>

            <b>NOTA</b>
             <br>
            <p class="text-justify text-danger fw-bold mt-2">
            UNA VEZ QUE SE HA PRESIONADO SOBRE EL ICONO DE IMPRESIÓN Y SE HA ABIERTO EL CUADRO DE IMPRESIÓN, EL PERMISO QUEDA REGISTRADO EN EL SISTEMA, YA SEA QUE SE IMPRIMA O NO.
            </p>
        </div>

    </div>
      </div>
    </div>
  </div> 
</div>
<!--Fin del modal-->

<div class="container my-4">
<!--Menu-->
    <div class="row justify-content-center mx-0 px-0" style="width:100%;">

        <div class="col-xs-12 col-sm-6 col-lg-4 my-2 p-0">
            <div class="d-flex flex-wrap justify-content-center align-content-center px-0" style="height:100%;">
                <a class="m-0 p-0" onclick="cargarContenido('viaje_de_trabajo', 'SOLICITUD DE VIAJE DE TRABAJO')">
                    <div class="card text-center border border-2 border-secondary rounded" style="width: 18rem;">
                        <div class="card-body">
                            <img src="./img/viaje.png" alt="viaje.png" style="width: 100px; height:100px">
                            <h5 class="card-title">VIAJE DE TRABAJO</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-lg-4  my-2">
                <div class="d-flex flex-wrap justify-content-center align-content-center px-0" style="height:100%;">
                    <a onclick="cargarContenido('SALIDA_DE_TRABAJO', 'SOLICITUD DE SALIDA DE TRABAJO')">
                        <div class="card text-center justify-content-center" style="width: 18rem;">
                            <div class="card-body border border-2 border-secondary rounded">
                                <img src="./img/salidat.jfif" alt="" style="width: 100px; height:100px">
                                <h5 class="card-title">SALIDA DE TRABAJO</h5>
                            </div>
                        </div>
                    </a>  
                </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-lg-4 my-2">
            <div class="d-flex flex-wrap justify-content-center align-content-center px-0" style="height:100%;">
                <a onclick="cargarContenido('SALIDA_PERSONAL', 'SOLICITUD DE SALIDA PERSONAL')">
                    <div class="card text-center justify-content-center" style="width: 18rem;">
                        <div class="card-body border border-2 border-secondary rounded">
                            <img src="./img/salidap.png" alt="" style="width: 100px; height:100px">
                            <h5 class="card-title">SALIDA PERSONAL</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-lg-4 my-2">
            <div class="d-flex flex-wrap justify-content-center align-content-center px-0" style="height:100%;">
                <a onclick="cargarContenido('PERMUTA', 'SOLICITUD DE PERMUTA')">    
                    <div class="card text-center justify-content-center" style="width: 18rem;">
                        <div class="card-body border border-2 border-secondary rounded">
                            <img src="./img/permuta.png" alt="" style="width: 100px; height:100px">
                            <h5 class="card-title">PERMUTA</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-lg-4 my-2">
                <div class="d-flex flex-wrap justify-content-center align-content-center px-0" style="height:100%;">
                    <a onclick="cargarContenido('PERMISOS_GUARDADOS', 'REGISTRO DE PERMISOS')">
                        <div class="card text-center justify-content-center" style="width: 18rem;">
                            <div class="card-body border border-2 border-secondary rounded">
                                <img src="./img/lupa.png" alt="" style="width: 100px; height:100px">
                                <h5 class="card-title">VER PERMISOS</h5>
                            </div>
                        </div>
                    </a>
                </div>   
        </div>

        <div class="col-xs-12 col-sm-6 col-lg-4 my-2">
                <div class="d-flex flex-wrap justify-content-center align-content-center px-0" style="height:100%;">
                    <a onclick="cargarContenido('PANEL', 'EDITAR PERMISOS')">
                        <div class="card text-center justify-content-center" style="width: 18rem;">
                            <div class="card-body border border-2 border-secondary rounded">
                                <img src="./img/panel.png" alt="" style="width: 100px; height:100px">
                                <h5 class="card-title">EDITAR PERMISOS</h5>
                            </div>
                        </div>
                    </a>
                </div>   
        </div>
    </div>
 <!--Fin menu-->   

 <h3 class="mt-3">    
        <b>NOTA</b>
    </h3>
    <p  class="text-justify text-danger text-decoration-underline fw-bold fs-7 mb-0">
        ANTES DE IMPRIMIR, ASEGÚRATE DE DESACTIVAR LAS OPCIONES DE ENCABEZADO Y PIE DE PÁGINA.
    </p>
    <p class="text-justify text-danger text-decoration-underline fw-bold fs-7 mt-0">
        SI QUIERE QUE LA IMPRESIÓN SEA A COLOR ACTIVE LA OPCIÓN DE GRÁFICOS DE FONDO
    </p>
 </div>


         <!--Boton de impresion -->
         <div class="d-grid gap-2 d-md-block my-5">
                <button id="boton-imprimir" class="btn boton imprimir" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="fas fa-question fa-2x"></i>
                </button>
                <a class="btn boton volver px-2" href="http://mx-server08:8080/Intranet2/#sistemas">
                    <i class="fas fa-home fa-2x"></i>
                </a> 
            </div>
        <!-- Fin boton de impresion-->