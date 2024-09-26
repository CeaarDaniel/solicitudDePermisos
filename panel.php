<?php 
session_start();
date_default_timezone_set('Etc/GMT+6');



if(!isset($_SESSION['PANEL'])) 
  echo '<div class="d-flex aling-content-center justify-content-center">
            <form 
              id="login" 
              class="my-5 p-5 border rounded"
              style="background-color:#D8DCDC; max-width:400px;">


                <div class="d-flex flex-column justify-content-center">
                  <h6 class="p-2 text-center" style="max-width:300px"><b>INGRESE LA CONTRASEÑA PARA PODER ACCEDER</b></h6>
                </div>
                        

                <div class="form-group p-1" style="width:100%">
                    <div class="input-group">
                      <input type="password" name="passwordpanel" id="passwordpanel" class="form-control mt-1" placeholder="contraseña" required>
                      <span class="input-group-text mt-1 p-0"><i id="btn-change" class="px-3 fa fa-eye fa-eye-slash"></i></span> 
                    </div>              
                </div>

                    <div class="d-flex justify-content-center" style="width:100%;">
                      <button id="btn-loginpanel" class="btn boton mt-1 mx-1 px-1" type="button" style="width:100%">
                        ACCEDER
                      </button>
                    </div>
            </form>
        </div>'; 

      else 
      echo'<!-- Modal -->
          <div class="modal fade" id="modalModificar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel"><b>MODIFICAR PERMISO</b></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="modalModificarBody" class="modal-body">
                </div>
              </div>
            </div>
          </div>
          <!--Fin del modal-->
          
          <!--Selector de permisos-->
          <div class="d-flex aling-content-center justify-content-center my-0">
              <label class="fs-5 text-danger"><b>TIPO DE PERMISO:</b></label>
              <select name="tipoPermiso" id="tipoPermiso" class="in icon-input">
                  <option value="" selected>---Tipo de permiso---</option>
                  <option value="6">Salida personal</option>
                  <option value="7">Permuta</option>
                  <option value="8">Salida de trabajo</option>
                  <option value="9">Viaje de trabajo</option>
              </select>
          </div>
          <!--Fin selector de permisos-->
          
          <!--Tabla de registro de permisos-->
          <div class="d-flex aling-content-center justify-content-center mt-0" style="width:100%">
              <table id="myTable" class="display responsive">
                  <thead>
                      <tr id="columnas" name="columnas">
                      </tr>
                  </thead>
                  <tbody>
                  </tbody>
              </table>
          </div>
          <!--Fin tabla de reigistro de permisos-->
          <button id="btn-cerrar" name="btn-cerrar" class="btn btn-danger imprimir">
            <b class="fs-4 px-2"> X </b>
          </button> 
          ';
?>

          <div class="d-grid gap-2 d-md-block my-0 py-0"> 
              <button class="btn boton volver px-2" type="submit" onclick="cargarContenido('menu', 'SOLICITUD DE PERMISOS')">
                  <i class="fas fa-chevron-left fa-2x"></i>
              </button>
          </div>