<?php 
session_start();

if(!isset($_SESSION['REPORTES'])) 
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
                      <input type="password" name="passworreportes" id="passworreportes" class="form-control mt-1" placeholder="contraseña" required>
                      <span class="input-group-text mt-1 p-0"><i id="btn-changerep" class="px-3 fa fa-eye fa-eye-slash"></i></span> 
                    </div>              
                </div>

                    <div class="d-flex justify-content-center" style="width:100%;">
                      <button id="btn-loginreportes" class="btn boton mt-1 mx-1 px-1" type="button" style="width:100%">
                        ACCEDER
                      </button>
                    </div>
            </form>
        </div>'; 

      else 
      echo'<!--Selector de permisos-->
      <div class="d-flex aling-content-center justify-content-center my-0">
          <label class="fs-5 text-danger my-0"><b>TIPO DE PERMISO:</b></label>
          <select name="tipoPermisoR" id="tipoPermisoR" class="in icon-input my-0">
              <option value="" selected>---Tipo de permiso---</option>
              <option value="SalidaPersonal">Salida personal</option>
              <option value="Permuta2">Permuta</option>
              <option value="SalidaTrabajo">Salida de trabajo</option>
              <option value="ViajeTrabajo">Viaje de trabajo</option>
          </select>
      </div>
      <!--Fin selector de permisos-->

      <!--Radio para el filtro de datos semanal quincenal -->

          <div class="d-flex flex-wrap flex-xs-column flex-sm-row justify-content-xs-center justify-content-sm-center" style="width:100%">
            <div style="max-width:150px">
              <input class="radio" type="radio" name="filtroSQ" id="filtroSQ1" value="T" checked>
              <label class="form-check-label mx-1" for="filtroSQ1">TODOS</label>
            </div>
        
            <div style="max-width:150px">
              <input class="radio" type="radio" name="filtroSQ" id="filtroSQ2" value="S">
              <label class="form-check-label mx-1" for="filtroSQ2">SEMANAL</label>
            </div>
          
            <div style="max-width:150px">
              <input class="radio" type="radio" name="filtroSQ" id="filtroSQ3" value="Q">
              <label class="form-check-label mx-1" for="filtroSQ3">QUINCENAL</label>
            </div>
          </div>
  
          
      <!--Fin del radio para el filtro de datos semanal quincenal -->
      
      <!--Tabla de registro de permisos-->
      <div class="d-flex aling-content-center justify-content-center mt-0" style="width:100%">
          <table id="tableReportes" class="display responsive">
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
          </button> ';
?>
    <div class="d-grid gap-2 d-md-block my-0 py-0"> 
        <button class="btn boton volver px-2" type="submit" onclick="cargarContenido('menu', 'SOLICITUD DE PERMISOS')">
            <i class="fas fa-chevron-left fa-2x"></i>
        </button>
    </div>