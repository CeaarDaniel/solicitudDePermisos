//Funcion para cargar las etiquetas y id's al cambiar de pagina
function cargarEtiquetas() {
    var botonImprimir = document.getElementById('boton-imprimir');
    var numero_de_nomina = document.getElementById("NN");
    var GASTOS = document.getElementById("GASTOS");
    var tabla = document.getElementById("myTable");
    var tableReportes = document.getElementById("tableReportes");
    var cargarTabla = document.getElementById("tipoPermiso");
    var btnchange = document.getElementById("btn-change");
    var btnloginpanel = document.getElementById("btn-loginpanel"); 
    var btnloginreportes = document.getElementById("btn-loginreportes");
    var btnchangerep = document.getElementById("btn-changerep");
    var btncerrar = document.getElementById("btn-cerrar");
    var modaPermu = document.getElementById('modalPermuta');
    var tipoPermisoR = document.getElementById("tipoPermisoR"); 
    var filtroSQ = document.getElementsByName("filtroSQ");

    if (botonImprimir) botonImprimir.addEventListener('click', imprimirPermiso);
    if (numero_de_nomina) numero_de_nomina.addEventListener("change", obtenerNombre);
    if (cargarTabla) cargarTabla.addEventListener("change", actualizarTabla); 
    if (tipoPermisoR) tipoPermisoR.addEventListener("change", actualizarReportes); 
    if (filtroSQ) 
         filtroSQ.forEach(function(radio) { // Iterar sobre los elementos de radio y agregar el evento change
                radio.addEventListener('change', function() {
                    actualizarReportes();
                    // Obtener el valor del radio seleccionado var valorSeleccionado = this.value;
                });
            });
    
    if (btnchange) btnchange.addEventListener("click", changeType); 
    if (btnchangerep) btnchangerep.addEventListener("click", changeTyperep); 
    if (btnloginpanel) btnloginpanel.addEventListener("click", loginPanel);
    if (btnloginreportes) btnloginreportes.addEventListener("click", loginRegistros);
    if (btncerrar) btncerrar.addEventListener("click", cerrarSession);
    if(modaPermu) {
        var myModal = new bootstrap.Modal(modaPermu);
        myModal.show();
    }

    //Envento change del select de gastos para Habilitar/deshabilitar los campos de gastos
    if (GASTOS) GASTOS.addEventListener("change", function () {
        if (GASTOS.value == "SI") var disabled = false;
        else if (GASTOS.value == "NO") disabled = true;
        var gasto = document.querySelectorAll('.gastos');
        gasto.forEach(function (campo) {
            campo.disabled = disabled;
            if (disabled) campo.value = "";
        });
    });

    //Ajustar el tamaño del dataTable
    if (tabla) { 
        $('#myTable').DataTable()
        window.addEventListener('resize', actualizarTabla);
        window.addEventListener("orientationchange", actualizarTabla, false)
    }

    if (tableReportes) { 
        $('#tableReportes').DataTable()
        window.addEventListener('resize', actualizarReportes);
        window.addEventListener("orientationchange", actualizarReportes, false)
    }
}

//Funcon para navegar entre ventanas
function cargarContenido(pagina, titulo) {
    var contenido = document.getElementById("contenido"); //Etiqueta padre sobre la que se carga el contenido
    var animacion = document.querySelector("#contenido");
    var titulop = document.getElementById("titulo");
    var xhttp = new XMLHttpRequest();
    animacion.classList.toggle("ocultar-mostrar"); //agrega la opacidad en 0 al cambiar de pagina
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            window.scroll(0, 0);
            // Esperar un breve tiempo antes de cambiar el contenido para visualizar la transicion
            setTimeout(
                function () {
                    contenido.innerHTML = this.responseText;
                    titulop.innerHTML = titulo;
                    cargarEtiquetas();
                    validarPermuta();
                    animacion.classList.toggle("ocultar-mostrar"); //cambia la opacidad en 1  al cambiar de pagina
                }.bind(this),
                400,
            );
        }
    }
    xhttp.open("POST", pagina + ".php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

//Funcion para imprimir permisos
function imprimirPermiso() {
    var llenado = document.getElementById("formulario");
    var fmllenado = document.getElementById("formulario-llenado");
    var fmrimprimir = document.getElementById("formulario-a-imprimir");
    var isValid = fmllenado.reportValidity();
    validarLlenado();

    if (isValid) {
        var fi = document.getElementById("FECHA_PERMISOA").value; //inicio de permiso
        var ff = document.getElementById("FECHA_PERMISOB").value; //fin del permiso
        var hi = document.getElementById("HORA1").value; //inicio de permiso
        var hf = document.getElementById("HORA2").value; //fin del permiso

        if (document.getElementById("NOMBRE").value == "" || document.getElementById("DEPARTAMENTO").value == "")
            alert("Ingrese un número de nómina válido")

        else
            if (fi > ff)
                alert("La fecha de inicio no puede ser mayor a la fecha de fin")

            else
                if (fi == ff && hi > hf)
                    alert("La hora de inicio no puede ser mayor a la hora de fin")

                else {
                    var formData = new FormData(fmllenado);
                    var fechaArray = formData.get('FECHA_SOLICITUD').split('-');
                    var fechaSolicitud = fechaArray[2] + '/' + fechaArray[1] + '/' + fechaArray[0];

                    var DEL = formData.get('FECHA_PERMISOA').split('-');
                    var DEL = DEL[2] + '/' + DEL[1] + '/' + DEL[0];

                    var AL = formData.get('FECHA_PERMISOB').split('-');
                    var AL = AL[2] + '/' + AL[1] + '/' + AL[0];

                    //Calcular la cantidad de días del permiso
                    var fechai = new Date(formData.get('FECHA_PERMISOA'));
                    var fechaf = new Date(formData.get('FECHA_PERMISOB'));
                    var dias = fechaf.getTime() - fechai.getTime();

                    var dias = (dias / (1000 * 60 * 60 * 24)) + 1;
                    var diasP = ((fechaf.getTime() - fechai.getTime()) / (1000 * 60 * 60 * 24)) + 1;

                    // Diferencia en horas            
                        var diferencia = ((new Date(ff + 'T' + hf)) - (new Date(fi + 'T' + hi))) / (1000 * 60 * 60);
                        console.log('Diferencia en horas: ' + diferencia);

                        if(diferencia < 24) diasP=diferencia.toFixed(1)+" hr";
                        console.log('Diferencia en dias: ' + diasP);

                    formData.set('CANTDIAS', dias)
                    var SOLICITADO = "";

                    if (formData.get("tipoPermiso") == 'viajeTrabajo') {
                        formData.get('CASETAS') == "" || formData.get('CASETAS') == null ? formData.set('CASETAS', 0) : "";
                        formData.get('GASOLINA') == "" || formData.get('GASOLINA') == null ? formData.set('GASOLINA', 0) : "";
                        formData.get('HOTEL') == "" || formData.get('HOTEL') == null ? formData.set('HOTEL', 0) : "";
                        formData.get('COMIDAS') == "" || formData.get('COMIDAS') == null ? formData.set('COMIDAS', 0) : "";
                        formData.get('TAXI') == "" || formData.get('TAXI') == null ? formData.set('TAXI', 0) : "";
                        formData.get('OTROS') == "" || formData.get('OTROS') == null ? formData.set('OTROS', 0) : "";

                        var total = parseInt(formData.get('CASETAS')) + parseInt(formData.get('GASOLINA')) + parseInt(formData.get('HOTEL')) + parseInt(formData.get('COMIDAS')) + parseInt(formData.get('TAXI')) + parseInt(formData.get('OTROS'));
                   
                        formData.append("opcion", "2");
                        formData.set("TOTAL", total);

                        fetch("./base_de_datos/operaciones.php", {
                            method: "POST",
                            body: formData
                        })
                            .then((response) => response.text())
                            .then((data) => {
                                var respuesta = JSON.parse(data);
                                var texto=`<form>
                                <!--Cabezera del formato -->
                                    <div class="row border border-dark mx-1">
                                        <div class="col-3 px-0">
                                            <div class="d-flex flex-wrap justify-content-center align-content-center px-0" style="height:100%;">    
                                                <img src='./img/logo.png' style="max-width:100%; max-height:100%;">
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
                                                    <div class="col-6 p-0 m-0 border-end border-secondary text-break">${formData.get('NOMBRE')}</div>
                                                    <div class="col p-0 m-0 border-end border-secondary text-center text-break">${formData.get('NN')}</div>
                                                    <div class="col p-0 m-0">${formData.get('DEPARTAMENTO')}</div>
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
                                                    <div class="col-6 border-end border-secondary"><p class="py-0 my-0 text-break">${formData.get('CODIGO_SHOP')}</p></div>
                                                    <div class="col-6"><p class="py-0 my-0 text-break">${fechaSolicitud}</p></div>
                                                </div>
                                                <div class="row my-2 border border-secondary border-secondary">
                                                    <div class="col-6 fw-bold border-end border-secondary">Fecha de permiso</div>
                                                    <div class="col-6 fw-bold">Horario</div>
                                                </div>
                                                <div class="row my-2 border border-secondary">
                                                    <div class="col-1 fw-bold border-end border-secondary">Del:</div>
                                                    <div class="col-2 border-end border-secondary">${DEL}</div>
                                                    <div class="col-1 fw-bold border-end border-secondary">Al:</div>
                                                    <div class="col-2 border-end border-secondary">${AL}</div>
                                                    <div class="col-1 fw-bold border-end border-secondary">De:</div>
                                                    <div class="col-2 border-end border-secondary">${formData.get('HORA1')}</div>
                                                    <div class="col-1 fw-bold border-end border-secondary">A:</div>
                                                    <div class="col-2">${formData.get('HORA2')}</div>
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
                                                ${dias}
                                            </p>
                                        </div>
                                        <div class="col-3 border-end border-secondary">
                                            <p class="text-center p-0 m-0 text-break text-uppercase">
                                            ${formData.get('CIUDAD')}
                                            </p>    
                                        </div>
                                        <div class="col-4 border-end border-secondary">
                                            <p class="text-center p-0 m-0 text-break text-uppercase">
                                                    ${formData.get('LUGAR')}
                                            </p>
                                        </div>
                                        <div class="col-3 p-0">
                                            <p class="text-center text-break text-uppercase p-0 m-0">
                                                ${formData.get('GASTOS')}
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
                                            ${formData.get('MOTIVO')}
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
                                                ${formData.get('CASETAS')}
                                            </p>
                                        </div>
                                        <div class="col-2 border-end border-secondary">
                                            <p class="text-center p-0 m-0">
                                                ${formData.get('GASOLINA')}
                                            </p>    
                                        </div>
                                        <div class="col-2 border-end border-secondary">
                                            <p class="text-center p-0 m-0">
                                                ${formData.get('HOTEL')}
                                            </p>
                                        </div>
                                        <div class="col-2 p-0 border-end border-secondary">
                                            <p class="text-center text-break p-0 m-0">
                                                ${formData.get('COMIDAS')}
                                            </p>
                                        </div>
                                        <div class="col-2 p-0 border-end border-secondary">
                                            <p class="text-center text-break p-0 m-0">
                                                ${formData.get('TAXI')}
                                            </p>
                                        </div>
                                        <div class="col-2 p-0">
                                            <p class="text-center text-break p-0 m-0">
                                                ${formData.get('OTROS')}
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
                                                ${total}
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
                                <p class="consecutivo">${respuesta.ID}</p>
                                
                                        </form>`;
                                var formulario = document.createElement('form');
                                formulario.method = 'POST';
                                formulario.action = "imprimirSolicitud.php";
                                var campo = document.createElement('input');
                                campo.type = 'hidden';
                                campo.name = "fmrimprimir";
                                campo.id = "fmrimprimir";
                                campo.value = texto;
                                formulario.appendChild(campo);
                                document.body.appendChild(formulario);
                                formulario.submit();
                                document.body.removeChild(formulario);
                                console.log(data)
                                cargarContenido("MENU", "SOLICITUD DE PERMISOS")
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    }

                    else if (formData.get("tipoPermiso") == "salidaTrabajo") {
                        formData.append("opcion", "3");

                        fetch("./base_de_datos/operaciones.php", {
                            method: "POST",
                            body: formData
                        })
                            .then((response) => response.text())
                            .then((data) => {
                                var respuesta = JSON.parse(data);
                                var texto = `<form>
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
                                                                    <div class="col-6 p-0 m-0 border-end border-secondary text-break">${formData.get("NOMBRE")}</div>
                                                                    <div class="col p-0 m-0 border-end border-secondary text-break text-center">${formData.get("NN")}</div>
                                                                    <div class="col p-0 m-0">${formData.get("DEPARTAMENTO")}</div>
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
                                                                    <div class="col-6 border-end border-secondary"><p class="py-0 my-0 text-break">${formData.get("CODIGO_SHOP")}</p></div>
                                                                    <div class="col-6"><p class="py-0 my-0 text-break">${fechaSolicitud}</p></div>
                                                                </div>
                                                                <div class="row my-2 border border-secondary border-secondary">
                                                                    <div class="col-6 fw-bold border-end border-secondary">Fecha de permiso</div>
                                                                    <div class="col-6 fw-bold">Horario</div>
                                                                </div>
                                                                <div class="row my-2 border border-secondary">
                                                                    <div class="col-1 fw-bold border-end border-secondary">Del</div>
                                                                    <div class="col-2 border-end border-secondary">${DEL}</div>
                                                                    <div class="col-1 fw-bold border-end border-secondary">Al</div>
                                                                    <div class="col-2 border-end border-secondary">${AL}</div>
                                                                    <div class="col-1 fw-bold border-end border-secondary">De</div>
                                                                    <div class="col-2 border-end border-secondary">${formData.get("HORA1")}</div>
                                                                    <div class="col-1 fw-bold border-end border-secondary">A</div>
                                                                    <div class="col-2">${formData.get("HORA2")}</div>
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
                                                            <div class="col-2 border border-secondary text-center">${diasP}</div>                                
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
                                                                ${formData.get("LUGAR")}
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
                                                            ${formData.get("CIUDAD")}
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
                                                                ${formData.get("MOTIVO")}
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
                                                <p class="consecutivo">${respuesta.ID}</p>
                                            </form>`;
                                var formulario = document.createElement('form');
                                formulario.method = 'POST';
                                formulario.action = "imprimirSolicitud.php";
                                var campo = document.createElement('input');
                                campo.type = 'hidden';
                                campo.name = "fmrimprimir";
                                campo.id = "fmrimprimir";
                                campo.value = texto;
                                formulario.appendChild(campo);
                                document.body.appendChild(formulario);
                                formulario.submit();
                                document.body.removeChild(formulario);
                                console.log(data)
                                cargarContenido("MENU", "SOLICITUD DE PERMISOS")
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    }

                    else if (formData.get("tipoPermiso") == "salidaPersonal") {

                        formData.append("opcion", "4");
                        fetch("./base_de_datos/operaciones.php", {
                            method: "POST",
                            body: formData
                        })
                            .then((response) => response.text())
                            .then((data) => {
                                 var respuesta = JSON.parse(data);
                                var texto = `<form>
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
                                                                    <div class="col-6 p-0 m-0 border-end border-secondary text-break">${formData.get("NOMBRE")}</div>
                                                                    <div class="col p-0 m-0 border-end border-secondary text-center text-break">${formData.get("NN")}</div>
                                                                    <div class="col p-0 m-0">${formData.get("DEPARTAMENTO")}</div>
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
                                                                    <div class="col-6 border-end border-secondary"><p class="py-0 my-0 text-break">${formData.get("CODIGO_SHOP")}</p></div>
                                                                    <div class="col-6"><p class="py-0 my-0 text-break">${fechaSolicitud}</p></div>
                                                                </div>
                                                                <div class="row my-2 border border-secondary border-secondary">
                                                                    <div class="col-6 fw-bold border-end border-secondary">Fecha de permiso</div>
                                                                    <div class="col-6 fw-bold">Horario</div>
                                                                </div>
                                                                <div class="row my-2 border border-secondary">
                                                                    <div class="col-1 fw-bold border-end border-secondary">Del:</div>
                                                                    <div class="col-2 border-end border-secondary">${DEL}</div>
                                                                    <div class="col-1 fw-bold border-end border-secondary">Al:</div>
                                                                    <div class="col-2 border-end border-secondary">${AL}</div>
                                                                    <div class="col-1 fw-bold border-end border-secondary">De:</div>
                                                                    <div class="col-2 border-end border-secondary">${formData.get("HORA1")}</div>
                                                                    <div class="col-1 fw-bold border-end border-secondary">A:</div>
                                                                    <div class="col-2">${formData.get("HORA2")}</div>
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
                                                            <div class="col-2 border border-secondary text-center">${diasP}</div>                                
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
                                                                ${formData.get("MOTIVO")}
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
                                                <p class="consecutivo">${respuesta.ID}</p>
                                                
                                                <input id="tipoPermiso" name="tipoPermiso" type="hidden" value="salidaPersonal">
                                            </form>`;
                                var formulario = document.createElement('form');
                                formulario.method = 'POST';
                                formulario.action = "imprimirSolicitud.php";
                                var campo = document.createElement('input');
                                campo.type = 'hidden';
                                campo.name = "fmrimprimir";
                                campo.id = "fmrimprimir";
                                campo.value = texto;
                                formulario.appendChild(campo);
                                document.body.appendChild(formulario);
                               
                                formulario.submit();
                                document.body.removeChild(formulario);
                                console.log(data)
                                cargarContenido("MENU", "SOLICITUD DE PERMISOS")
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    }

                    else if (formData.get("tipoPermiso") == "permuta") {

                        //if (formData.get("HORARIOPERMU1") > formData.get("HORARIOPERMU2") || formData.get("HORARIOPERMU3") > formData.get("HORARIOPERMU4") || formData.get("HORARIOPERMU5") > formData.get("HORARIOPERMU6"))
                            //alert("La hora de inicio de la permuta no puede ser mayor que la hora de fin de la permuta")

                        //else {
                            if (formData.get("FECHA_SOLICITUD") > formData.get("FECHA_PERMISOA"))
                                SOLICITADO = "DESPUES"

                            else if (formData.get("FECHA_SOLICITUD") < formData.get("FECHA_PERMISOA"))
                                SOLICITADO = "ANTES"

                            else if (formData.get("FECHA_SOLICITUD") == formData.get("FECHA_PERMISOA")) {
                                var fechaHoraActual = new Date();
                                var horaActual = fechaHoraActual.getHours();
                                var minutosActuales = fechaHoraActual.getMinutes();

                                // Formateo de la hora y los minutos para asegurar que tengan dos dígitos
                                var horaFormateada = horaActual.toString().padStart(2, '0');
                                var minutosFormateados = minutosActuales.toString().padStart(2, '0');
                                var horaActualf = horaFormateada + ":" + minutosFormateados;

                                if (formData.get("HORA1") >= horaActualf) SOLICITADO = "ANTES";
                                else if (formData.get("HORA1") < horaActualf) SOLICITADO = "DESPUES"
                            }

                            formData.append("SOLICITADO", SOLICITADO)
                            var FECHAPERMU1 = formData.get('FECHAPERMU1').split('-');
                            FECHAPERMU1 = FECHAPERMU1[2] + '/' + FECHAPERMU1[1] + '/' + FECHAPERMU1[0];
                            var inicio = new Date('1970-01-01T' + formData.get("HORARIOPERMU1") + 'Z');
                            var HORARIOPERMU1 = '1970-01-01 '+formData.get("HORARIOPERMU1");

                            if (formData.get("HORARIOPERMU1") > formData.get("HORARIOPERMU2")) {
                                var fin = new Date('1970-01-02T' + formData.get("HORARIOPERMU2") + 'Z');
                                var HORARIOPERMU2 = '1970-01-02 '+ formData.get("HORARIOPERMU2");    
                            }

                            else {
                                var fin = new Date('1970-01-01T' + formData.get("HORARIOPERMU2") + 'Z');
                                var HORARIOPERMU2 = '1970-01-01 '+ formData.get("HORARIOPERMU2");
                            }

                            // Restar las horas
                            var diferencia = fin.getTime() - inicio.getTime();

                            // Convertir la diferencia a horas y minutos
                            var horas = Math.floor(diferencia / (1000 * 60 * 60));
                            var minutos = Math.floor((diferencia % (1000 * 60 * 60)) / (1000 * 60));

                            // Formatear la diferencia como hora:minuto
                            var HRSTRABAJADAS1 = horas.toString().padStart(2, '0') + ':' + minutos.toString().padStart(2, '0');

                            if (formData.get("FECHAPERMU2") != "" && formData.get("FECHAPERMU2") != null) {
                                var FECHAPERMU2 = formData.get('FECHAPERMU2').split('-');
                                FECHAPERMU2 = FECHAPERMU2[2] + '/' + FECHAPERMU2[1] + '/' + FECHAPERMU2[0];

                                var inicio = new Date('1970-01-01T' + formData.get("HORARIOPERMU3") + 'Z');
                                var HORARIOPERMU3 = '1970-01-01 '+formData.get("HORARIOPERMU3");

                                if (formData.get("HORARIOPERMU3") > formData.get("HORARIOPERMU4")){
                                    var fin = new Date('1970-01-02T' + formData.get("HORARIOPERMU4") + 'Z');
                                    var HORARIOPERMU4 = '1970-01-02 '+formData.get("HORARIOPERMU4");
                                }

                                else {
                                    // Convertir las horas en objetos Date
                                    var fin = new Date('1970-01-01T' + formData.get("HORARIOPERMU4") + 'Z');
                                    var HORARIOPERMU4 = '1970-01-01 '+formData.get("HORARIOPERMU4");
                                }

                                // Restar las horas
                                var diferencia = fin.getTime() - inicio.getTime();

                                // Convertir la diferencia a horas y minutos
                                var horas = Math.floor(diferencia / (1000 * 60 * 60));
                                var minutos = Math.floor((diferencia % (1000 * 60 * 60)) / (1000 * 60));

                                // Formatear la diferencia como hora:minuto
                                var HRSTRABAJADAS2 = horas.toString().padStart(2, '0') + ':' + minutos.toString().padStart(2, '0');
                            }

                            else {
                                FECHAPERMU2 = ""
                                HRSTRABAJADAS2 = "";
                            }

                            if (formData.get("FECHAPERMU3") != "" && formData.get("FECHAPERMU3") != null) {
                                var FECHAPERMU3 = formData.get('FECHAPERMU3').split('-');
                                FECHAPERMU3 = FECHAPERMU3[2] + '/' + FECHAPERMU3[1] + '/' + FECHAPERMU3[0];
                                //FECHAPERMU3 = NULL;

                                // Convertir las horas en objetos Date
                                var inicio = new Date('1970-01-01T' + formData.get("HORARIOPERMU5") + 'Z');
                                var HORARIOPERMU5 = '1970-01-01 '+formData.get("HORARIOPERMU5");

                                if (formData.get("HORARIOPERMU5") > formData.get("HORARIOPERMU6")){
                                    // Convertir las horas en objetos Date
                                    var fin = new Date('1970-01-02T' + formData.get("HORARIOPERMU6") + 'Z');
                                    var HORARIOPERMU6 = '1970-01-02 '+formData.get("HORARIOPERMU6");
                               }

                               else {
                                       // Convertir las horas en objetos Date
                                       var fin = new Date('1970-01-01T' + formData.get("HORARIOPERMU6") + 'Z');
                                       var HORARIOPERMU6 = '1970-01-01 '+formData.get("HORARIOPERMU6");
                               }

                                // Restar las horas
                                var diferencia = fin.getTime() - inicio.getTime();

                                // Convertir la diferencia a horas y minutos
                                var horas = Math.floor(diferencia / (1000 * 60 * 60));
                                var minutos = Math.floor((diferencia % (1000 * 60 * 60)) / (1000 * 60));

                                // Formatear la diferencia como hora:minuto
                                var HRSTRABAJADAS3 = horas.toString().padStart(2, '0') + ':' + minutos.toString().padStart(2, '0');
                            }

                            else {
                                FECHAPERMU3 = ""
                                HRSTRABAJADAS3 = ""
                            }

                            var requestOptions = {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                body: 'opcion=13&HRSTRABAJADAS1='+HRSTRABAJADAS1+
                                      '&HRSTRABAJADAS2='+HRSTRABAJADAS2+
                                      '&HRSTRABAJADAS3='+HRSTRABAJADAS3+
                                      '&FECHAPERMU1='+FECHAPERMU1+
                                      '&FECHAPERMU2='+FECHAPERMU2+
                                      '&FECHAPERMU3='+FECHAPERMU3+
                                      '&HORARIOPERMU1='+HORARIOPERMU1+
                                      '&HORARIOPERMU2='+HORARIOPERMU2+
                                      '&HORARIOPERMU3='+HORARIOPERMU3+
                                      '&HORARIOPERMU4='+HORARIOPERMU4+
                                      '&HORARIOPERMU5='+HORARIOPERMU5+
                                      '&HORARIOPERMU6='+HORARIOPERMU6+
                                      '&NN='+document.getElementById("NN").value
                            };

                            fetch("./base_de_datos/operaciones.php", requestOptions)
                                .then((response) => response.json())
                                .then((data) => {
                                    formData.append("TOTALHRSACUMU", data.htotal)
                                    formData.append("HRSTRABAJADAS1", data.HRSTRABAJADAS1)
                                    formData.append("HRSTRABAJADAS2", data.HRSTRABAJADAS2)
                                    formData.append("HRSTRABAJADAS3", data.HRSTRABAJADAS3)
                                    HRSTRABAJADAS1 = data.HRSTRABAJADAS1.toString();
                                    HRSTRABAJADAS2 = data.HRSTRABAJADAS2.toString();
                                    HRSTRABAJADAS3 = data.HRSTRABAJADAS3.toString(); 
                                    total = data.htotal.toString();

                                    formData.append("opcion", "5");
        
                                    fetch("./base_de_datos/operaciones.php", {
                                        method: "POST",
                                        body: formData
                                    })
                                        .then((response) => response.json())
                                        .then((data) => {
                                            if(data.ok){
                                                //data= JSON.stringify(data);
                                                var texto = `<form>
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
                                                                                    <div class="col-6 p-0 m-0 border-end border-secondary text-break">${formData.get("NOMBRE")}</div>
                                                                                    <div class="col p-0 m-0 border-end border-secondary text-break text-center">${formData.get("NN")}</div>
                                                                                    <div class="col p-0 m-0">${formData.get("DEPARTAMENTO")}</div>
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
                                                                                    <div class="col-6 border-end border-secondary"><p class="py-0 my-0 text-break">${formData.get("CODIGO_SHOP")}</p></div>
                                                                                    <div class="col-6"><p class="py-0 my-0 text-break">${fechaSolicitud}</p></div>
                                                                                </div>
                                                                                <div class="row my-2 border border-secondary border-secondary">
                                                                                    <div class="col-6 fw-bold border-end border-secondary">Fecha de permiso</div>
                                                                                    <div class="col-6 fw-bold">Horario</div>
                                                                                </div>
                                                                                <div class="row my-2 border border-secondary">
                                                                                    <div class="col-1 fw-bold border-end border-secondary">Del:</div>
                                                                                    <div class="col-2 border-end border-secondary">${DEL}</div>
                                                                                    <div class="col-1 fw-bold border-end border-secondary">Al:</div>
                                                                                    <div class="col-2 border-end border-secondary">${AL}</div>
                                                                                    <div class="col-1 fw-bold border-end border-secondary">De:</div>
                                                                                    <div class="col-2 border-end border-secondary">${formData.get("HORA1")}</div>
                                                                                    <div class="col-1 fw-bold border-end border-secondary">A:</div>
                                                                                    <div class="col-2">${formData.get("HORA2")}</div>
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
                                                                                <div class="col-2 border border-secondary text-center">${diasP}</div>                                
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
                                                                                    ${formData.get("MOTIVO")}
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
                                                                                    ${SOLICITADO}
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
                                                                            <div class="col-6 p-0 border-top border-bottom border-end border-secondary"><p class="m-0 p-0">${FECHAPERMU1}</p></div>
                                                                            <div class="col-2 p-0 mt-1 border-top border-bottom border-start border-secondary"><p class="m-0 p-0 fw-bold">De</p></div>
                                                                            <div class="col-4 p-0 mt-1 border-top border-bottom border-start border-end border-secondary"><p class="m-0 p-0">${formData.get("HORARIOPERMU1")}</p></div>
                                                                            <div class="col-2 p-0 mt-1 border-top border-bottom border-end border-secondary"><p class="m-0 p-0 fw-bold">A</p></div>
                                                                            <div class="col-4 p-0 mt-1 border-top border-bottom border-end border-secondary"><p class="m-0 p-0">${formData.get("HORARIOPERMU2")}</p></div>
                                                                            <div class="col-6 p-0 mt-1 border-top border-bottom border-start border-end border-secondary"><p class="m-0 p-0 fw-bold">Hrs. Trabajadas</p></div>
                                                                            <div class="col-6 p-0 mt-1 border-top border-bottom border-end border-secondary"><p class="m-0 p-0">${HRSTRABAJADAS1}</p></div>
                                                                        </div>
                                            
                                                                    </div>
                                                                    <div class="col-4 ">
                                                                        <div class="row m-0 p-0">
                                                                            <div class="col-6 p-0 border border-secondary"><p class="m-0 p-0 fw-bold">Día trabajado:</p></div> 
                                                                            <div class="col-6 p-0 border-top border-bottom border-end border-secondary"><p class="m-0 p-0">${FECHAPERMU2}</p></div>
                                                                            <div class="col-2 p-0 mt-1 border-top border-bottom border-start border-secondary"><p class="m-0 p-0 fw-bold">De</p></div>
                                                                            <div class="col-4 p-0 mt-1 border-top border-bottom border-start border-end border-secondary"><p class="m-0 p-0">${(formData.get("HORARIOPERMU3") != "" && formData.get("HORARIOPERMU3") != null) ? formData.get("HORARIOPERMU3") : " "}</p></div>
                                                                            <div class="col-2 p-0 mt-1 border-top border-bottom border-end border-secondary"><p class="m-0 p-0 fw-bold">A</p></div>
                                                                            <div class="col-4 p-0 mt-1 border-top border-bottom border-end border-secondary"><p class="m-0 p-0">${(formData.get("HORARIOPERMU4") != "" && formData.get("HORARIOPERMU4") != null) ? formData.get("HORARIOPERMU4") : " "}</p></div>
                                                                            <div class="col-6 p-0 mt-1 border-top border-bottom border-start bord er-end border-secondary"><p class="m-0 p-0 fw-bold">Hrs. Trabajadas</p></div>
                                                                            <div class="col-6 p-0 mt-1 border-top border-bottom border-end border-secondary"><p class="m-0 p-0">${HRSTRABAJADAS2}</p></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="row m-0 p-0">
                                                                            <div class="col-6 p-0 border border-secondary"><p class="m-0 p-0 fw-bold">Día trabajado:</p></div>
                                                                            <div class="col-6 p-0 border-top border-bottom border-end border-secondary"><p class="m-0 p-0">${FECHAPERMU3}</p></div>
                                                                            <div class="col-2 p-0 mt-1 border-top border-bottom border-start border-secondary"><p class="m-0 p-0 fw-bold">De</p></div>
                                                                            <div class="col-4 p-0 mt-1 border-top border-bottom border-start border-end border-secondary"><p class="m-0 p-0">${(formData.get("HORARIOPERMU5") != "" && formData.get("HORARIOPERMU5") != null) ? formData.get("HORARIOPERMU5") : " "}</p></div>
                                                                            <div class="col-2 p-0 mt-1 border-top border-bottom border-end border-secondary"><p class="m-0 p-0 fw-bold">A</p></div>
                                                                            <div class="col-4 p-0 mt-1 border-top border-bottom border-end border-secondary"><p class="m-0 p-0">${(formData.get("HORARIOPERMU6") != "" && formData.get("HORARIOPERMU6") != null) ? formData.get("HORARIOPERMU6") : " "}</p></div>
                                                                            <div class="col-6 p-0 mt-1 border-top border-bottom border-start border-end border-secondary"><p class="m-0 p-0 fw-bold">Hrs. Trabajadas</p></div>
                                                                            <div class="col-6 p-0 mt-1 border-top border-bottom border-end border-secondary"><p class="m-0 p-0">${HRSTRABAJADAS3}</p></div>
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
                                                                                    ${total}
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
                                                                <p class="consecutivo">${data.ID}</p>
                                                            </form>`
                                        
                                                var formulario = document.createElement('form');
                                                formulario.method = 'POST';
                                                formulario.action = "imprimirSolicitud.php";
                                                var campo = document.createElement('input');
                                                campo.type = 'hidden';
                                                campo.name = "fmrimprimir";
                                                campo.id = "fmrimprimir";
                                                campo.value = texto;
                                                formulario.appendChild(campo);
                                                document.body.appendChild(formulario);
                                                formulario.submit();
                                                document.body.removeChild(formulario);
                                                console.log(data);
                                                cargarContenido("MENU", "SOLICITUD DE PERMISOS")
                                           }
                                           else alert("Error: "+data);
                                        })
                                        .catch((error) => {
                                            console.log(error);
                                        });
                                })
                                .catch((error) => {
                                    console.log(error);
                                });
                        //}
                    }
                }
    }



}
//Fin funcion imprimir

//Funcion para obtener datos del empleado
function obtenerNombre() {
    var numero_de_nomina = document.getElementById("NN").value;
    console.log(numero_de_nomina)
    var opcion = 1;
    var requestOptions = {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'NN=' + parseInt(numero_de_nomina) + '&opcion=' + opcion
    };

    fetch('./base_de_datos/operaciones.php', requestOptions)
        .then(response => response.text())
        .then((data) => {
                //console.log(data);
                response = JSON.parse(data);
                //console.log(response);

            if (response.ok == true) {
                document.getElementById("NOMBRE").value = response.usuario;
                document.getElementById("DEPARTAMENTO").value = response.area;
            }
            else {
                document.getElementById("NOMBRE").value = "";
                document.getElementById("DEPARTAMENTO").value = "";
            }
        }).catch(error => {
            console.log('Error:', error);
        });
}
//Fin funcion obtener nombre

//Funcion para validar el llenado de los campos el formulario
function validarLlenado() {
    //Validar los input vacios
    var input = document.querySelectorAll('input');
    // Agregar la clase invalid a todos los campos
    input.forEach(function (campo) {
        if (campo.checkValidity()) {
            campo.classList.remove('invalido');
            // Buscar el elemento hermano anterior (el div que contiene el mensaje de error) y eliminarlo si existe
            var mensajeError = campo.previousElementSibling;
            if (mensajeError && mensajeError.classList.contains('invalido')) {
                mensajeError.remove();
            }
        }


        else
            if (!campo.classList.contains('invalido')) { //Evaluar si existe la clase invalido para evitar volver a agregar el elemento
                campo.classList.add('invalido');
                var mensajeError = document.createElement('div');
                mensajeError.innerHTML = "<p class='text-danger m-0 p-0'><b> *Complete este campo</b></p>";
                mensajeError.classList.add('invalido');
                campo.insertAdjacentElement("beforebegin", mensajeError)
            }
    });

    //Validar los select
    var input = document.querySelectorAll('select');
    // Agregar la clase invalid a todos los campos
    input.forEach(function (campo) {
        if (campo.checkValidity()) {
            campo.classList.remove('invalido');
            // Buscar el elemento hermano anterior (el div que contiene el mensaje de error) y eliminarlo si existe
            var mensajeError = campo.previousElementSibling;
            if (mensajeError && mensajeError.classList.contains('invalido')) {
                mensajeError.remove();
            }
        }


        else
            if (!campo.classList.contains('invalido')) { //Evaluar si existe la clase invalido para evitar volver a agregar el elemento
                campo.classList.add('invalido');
                var mensajeError = document.createElement('div');
                mensajeError.innerHTML = "<p class='text-danger m-0 p-0'><b> *Complete este campo</b></p>";
                mensajeError.classList.add('invalido');
                campo.insertAdjacentElement("beforebegin", mensajeError)
            }
    });

    //Validar los textarea
    var input = document.querySelectorAll('textarea');
    // Agregar la clase invalid a todos los campos
    input.forEach(function (campo) {
        if (campo.checkValidity()) {
            campo.classList.remove('invalido');
            // Buscar el elemento hermano anterior (el div que contiene el mensaje de error) y eliminarlo si existe
            var mensajeError = campo.previousElementSibling;
            if (mensajeError && mensajeError.classList.contains('invalido')) {
                mensajeError.remove();
            }
        }


        else
            if (!campo.classList.contains('invalido')) { //Evaluar si existe la clase invalido para evitar volver a agregar el elemento
                campo.classList.add('invalido');
                var mensajeError = document.createElement('div');
                mensajeError.innerHTML = "<p class='text-danger m-0 p-0'><b> *Complete este campo</b></p>";
                mensajeError.classList.add('invalido');
                campo.insertAdjacentElement("beforebegin", mensajeError)
            }
    });
}
//Fin funcion para validar el llenado de los campos del formulario

//Validacion de permuta
function validarPermuta() {
    var permuta2 = document.getElementById("FECHAPERMU2");
    var permuta3 = document.getElementById("FECHAPERMU3");
    hp3 = document.getElementById("HORARIOPERMU3");
    hp4 = document.getElementById("HORARIOPERMU4");
    hp5 = document.getElementById("HORARIOPERMU5");
    hp6 = document.getElementById("HORARIOPERMU6");

    if (permuta2) permuta2.addEventListener("change", function () {
        if (permuta2.value != "" && permuta2.value != null) {
            hp3.required = true;
            hp3.disabled = false;
            hp4.required = true;
            hp4.disabled = false;
        }
        else {
            hp3.required = false;
            hp3.disabled = true;
            hp3.value = "";
            hp4.required = false;
            hp4.disabled = true;
            hp4.value = "";
        }
    });

    if (permuta3) permuta3.addEventListener("change", function () {
        if (permuta3.value != "" && permuta3.value != null) {
            hp5.required = true;
            hp5.disabled = false;
            hp6.required = true;
            hp6.disabled = false;
        }
        else {
            hp5.required = false;
            hp5.disabled = true;
            hp5.value = "";
            hp6.required = false;
            hp6.disabled = true;
            hp6.value = "";
        }
    });
}
//Fin validacion de permita

/*Funcion para actualizar tabla de reportes en la seccion de el panel o editar permisos*/
function actualizarTabla() {
    var ancho = window.innerWidth;
    var columnasTabla = document.getElementById("columnas");
    var requestOptions = {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'opcion=' + document.getElementById("tipoPermiso").value
    };

    fetch('./base_de_datos/operaciones.php', requestOptions)
        .then(response => response.text())
        .then((data) => {

            //Resetear el dataTable
            $('#myTable').DataTable().clear();  //Limpiar las columnas
            $('#myTable').DataTable().destroy(); //Restaurar la tablas


            // Crear la configuración de las columnas para DataTables
            var response = JSON.parse(data);
            var columnas = Object.keys(response[0]);
            var columnasConfig = columnas.map(function (columna) { return { "data": columna }; });

            //Restear las columnas de la tabla
            while (columnasTabla.firstChild)
                columnasTabla.removeChild(columnasTabla.firstChild);

            //Agregar las nuevas columnas a la tabla
            columnas.forEach(columna => {
                const fila = document.createElement("th");
                fila.textContent = columna;
                columnasTabla.appendChild(fila);
            });

            //Crear el dataTable con las nuevas configuraciones
            $('#myTable').DataTable({
                responsive: true,
                scrollX: (ancho - 50),
                scrollY: 370,
                scrollCollapse: true,
                columns: columnasConfig,
                data: response,
            });

            //$('#myTable').DataTable().column(2).search("OROZCO DE MONTANARO PATRICIA").draw();

        }).catch(error => {
            console.log('Error:', error);

            while (columnasTabla.firstChild)
                columnasTabla.removeChild(columnasTabla.firstChild);
                $('#myTable').DataTable().clear();
                $('#myTable').DataTable().destroy();
                $('#myTable').DataTable();
        });
}
/*Fin actualizar tabla de reportes */

//Funcion para eliminar un registro
function eliminarRegistro(id) {
    var tipoPermiso = document.getElementById("tipoPermiso").value;
    var resultado = confirm("¿Esta seguro que desea eliminar este registro?");
    var elimi=false;
    if (resultado) {
        var formDataEliminar = new FormData();
        formDataEliminar.append("opcion", "10");
        formDataEliminar.append("id", id);
        formDataEliminar.append("tipoPermiso", tipoPermiso)

        fetch("./base_de_datos/operaciones.php", {
            method: "POST",
            body: formDataEliminar,
        })
            .then((response) => response.json())
            .then((data) => {
                alert(data.ok);
                if(data.ok) elimi=true;
            })
            .catch((error) => {
                console.log(error);
            });


           
            var table = new DataTable('#myTable');
            $('#myTable tbody').on('click', 'button', function () {
                table.row($(this).parents('tr')).remove().draw();
            });
        
    }
}
//Fin de la funcion para eliminar un registro

//Formulario para editar permisos
function editarRegistro(event) {
    var modalBody = document.getElementById("modalModificarBody");
    var tipoPermiso = document.getElementById("tipoPermiso").value;
    const boton = event.target.closest("button"); // Accede al atributo data-id del botón que disparó el evento
    var dataId = boton.getAttribute('data-id');
    var dataNN = boton.getAttribute('data-NN');
    var dataNOMBRE = boton.getAttribute('data-NOMBRE');
    var dataDEPARTAMENTO = boton.getAttribute('data-DEPARTAMENTO');
    var dataCODIGO_SHOP = boton.getAttribute('data-CODIGO_SHOP');
    var dataFECHA_SOLICITUD = boton.getAttribute('data-FECHA_SOLICITUD');
    var dataFECHA_PERMISOA = boton.getAttribute('data-FECHA_PERMISOA');
    var dataFECHA_PERMISOB = boton.getAttribute('data-FECHA_PERMISOB');
    var dataHORA1 = boton.getAttribute('data-HORA1');
    var dataHORA2 = boton.getAttribute('data-HORA2');
    var dataMOTIVO = boton.getAttribute('data-MOTIVO');

    //SALIDA PERSONAL
    if (tipoPermiso == '6'){ 
                             modalBody.innerHTML = `<div class="d-flex aling-content-center justify-content-center" id="formulario" name="formulario">
                                                        <form id="formulario-llenado" class="form-control px-5 border border-secondary border-2 rounded" style="max-width:90%;">
                                                                <p class="p-3 text-center fs-5">
                                                                    <b> DATOS GENERALES</b>
                                                                </p>

                                                                <div class="row m-0 px-0">
                                                                    <div class="col-12 col-md-6 my-2 px-0">
                                                                        <div class="d-flex flex-column flex-wrap">
                                                                            <label class="input-group fw-bold px-1" for="NN" style="max-width:240px;">NÚMERO DE NÓMINA</label>  
                                                                            <input class="in icon-input" id="NN" name="NN" type="number" style="width:70%;" min=2 value="${dataNN}" placeholder="&#xf2b9; Escriba su número de nómina" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-md-6 my-2 px-0">
                                                                        <div class="d-flex flex-column flex-wrap">
                                                                            <label class="input-group fw-bold px-1" for="NN" style="max-width:240px;">NOMBRE</label>  
                                                                            <input class="in icon-input" id="NOMBRE" name="NOMBRE" type="text" placeholder="&#xf02d; Nombre" value="${dataNOMBRE}" style="max-width:70%;" readonly>
                                                                        </div> 
                                                                    </div>
                                                                    <div class="col-12 col-md-6 my-2 px-0">
                                                                        <div class="d-flex flex-column flex-wrap">
                                                                            <label class="input-group fw-bold" for="NN" style="max-width:240px;">DEPARTAMENTO</label>  
                                                                            <input class="in icon-input" id="DEPARTAMENTO" name="DEPARTAMENTO" type="text" placeholder="&#xf029; Departamento" value="${dataDEPARTAMENTO}" style="width:70%;" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-md-6 my-2 px-0">
                                                                        <div class="d-flex flex-column flex-wrap">
                                                                            <label class="input-group fw-bold" style="max-width:240px;">CÓDIGO SHOP</label>
                                                                            <select class="in icon-input" name="CODIGO_SHOP" id="CODIGO_SHOP" style="width:70%;" required>
                                                                                <option value="1110 JMEX PLUNGER (APZ y AVO)" ${dataCODIGO_SHOP == "1110 JMEX PLUNGER (APZ y AVO)" ? 'selected' : ' '}>1110 JMEX PLUNGER (APZ y AVO)</option>
                                                                                <option value="1111 APZ sleeve" ${dataCODIGO_SHOP == "1111 APZ sleeve" ? 'selected' : ' '}>1111 APZ sleeve</option>
                                                                                <option value="1112 AVO Cover" ${dataCODIGO_SHOP == "1112 AVO Cover" ? 'selected' : ' '}>1112 AVO Cover</option>
                                                                                <option value="1113 AXO PISTON" ${dataCODIGO_SHOP == "1113 AXO PISTON" ? 'selected' : ' '}>1113 AXO PISTON</option>
                                                                                <option value="1120 STABILINK Manual" ${dataCODIGO_SHOP == "1120 STABILINK Manual" ? 'selected' : ' '}>1120 STABILINK Manual</option>
                                                                                <option value="1121 STABILINK Automatica" ${dataCODIGO_SHOP == "1121 STABILINK Automatica" ? 'selected' : ' '}>1121 STABILINK Automatica</option>
                                                                                <option value="1122 STABILINK Automatica FORD" ${dataCODIGO_SHOP == "1122 STABILINK Automatica FORD" ? 'selected' : ' '}>1122 STABILINK Automatica FORD</option>
                                                                                <option value="1130 CARRIER" ${dataCODIGO_SHOP == "1130 CARRIER" ? 'selected' : ' '}>1130 CARRIER</option>
                                                                                <option value="1131 HUB TWO WAY" ${dataCODIGO_SHOP == "1131 HUB TWO WAY" ? 'selected' : ' '}>1131 HUB TWO WAY</option>
                                                                                <option value="1140 CAP-BRG" ${dataCODIGO_SHOP == "1140 CAP-BRG" ? 'selected' : ' '}>1140 CAP-BRG</option>
                                                                                <option value="1150 B R K T" ${dataCODIGO_SHOP == "1150 B R K T" ? 'selected' : ' '}>1150 B R K T</option>
                                                                                <option value="1160 COVER HUB" ${dataCODIGO_SHOP == "1160 COVER HUB" ? 'selected' : ' '}>1160 COVER HUB</option>
                                                                                <option value="1160 PUM HUB" ${dataCODIGO_SHOP == "1160 PUM HUB" ? 'selected' : ' '}>1160 PUM HUB</option>
                                                                                <option value="1160 VALEO" ${dataCODIGO_SHOP == "1160 VALEO" ? 'selected' : ' '}>1160 VALEO</option>
                                                                                <option value="1170 HOUSING" ${dataCODIGO_SHOP == "1170 HOUSING" ? 'selected' : ' '}>1170 HOUSING</option>
                                                                                <option value="1170 NSK WARNER" ${dataCODIGO_SHOP == "1170 NSK WARNER" ? 'selected' : ' '}>1170 NSK WARNER</option>
                                                                                <option value="1180 HAL/AAM" ${dataCODIGO_SHOP == "1180 HAL/AAM" ? 'selected' : ' '}>1180 HAL/AAM</option>
                                                                                <option value="1180 OUTLET WATER" ${dataCODIGO_SHOP == "1180 OUTLET WATER" ? 'selected' : ' '}>1180 OUTLET WATER</option>
                                                                                <option value="1190 Grupo Administracion" ${dataCODIGO_SHOP == "1190 Grupo Administracion" ? 'selected' : ' '}>1190 Grupo Administracion</option>
                                                                                <option value="1210 MOLDES MX" ${dataCODIGO_SHOP == "1210 MOLDES MX" ? 'selected' : ' '}>1210 MOLDES MX</option>
                                                                                <option value="1220 MOLDES JP" ${dataCODIGO_SHOP == "1220 MOLDES JP" ? 'selected' : ' '}>1220 MOLDES JP</option>
                                                                                <option value="5210 Grupo de Administracion" ${dataCODIGO_SHOP == "5210 Grupo de Administracion" ? 'selected' : ' '}>5210 Grupo de Administracion</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row m-0 px-0">
                                                                    <div class="col-12 my-2 px-0">
                                                                        <div class="d-flex flex-column flex-wrap"> 
                                                                            <label class="input-group fw-bold" style="max-width:240px;">FECHA DE SOLICITUD</label>
                                                                            <input id="FECHA_SOLICITUD" name="FECHA_SOLICITUD" class="in" type="date" style="max-width:360px;" value="${dataFECHA_SOLICITUD}" required>
                                                                        </div>
                                                                    </div>
                                                                        <div class="col-12 col-md-5 col-xl-3 my-2">
                                                                            <label class="input-group fw-bold" style="max-width:240px;">DEL</label>
                                                                            <input id="FECHA_PERMISOA" name="FECHA_PERMISOA" class="in" type="date" value="${dataFECHA_PERMISOA}"style="max-width:auto;" required/>
                                                                        </div>
                                                                        <div class="col-12 col-md-5 col-xl-3 my-2">
                                                                            <label class="input-group fw-bold" style="max-width:240px;">AL</label>
                                                                            <input id="FECHA_PERMISOB" name="FECHA_PERMISOB" class="in" type="date" value="${dataFECHA_PERMISOB}" style="max-width:auto;" required/>
                                                                        </div>
                                                                        <div class="col-12 col-md-5 col-xl-3 my-2">
                                                                            <label class="input-group fw-bold" style="max-width:240px;">DE</label>
                                                                            <input id="HORA1" name="HORA1" class="in" type="time" style="max-width:auto;" value="${dataHORA1}" required/>
                                                                        </div>
                                                                        <div class="col-12 col-md-5 col-xl-3 my-2" style="max-width:240px;">
                                                                            <label class="input-group fw-bold">A</label>
                                                                            <input id="HORA2" name="HORA2" class="in" type="time" style="max-width:auto;" value="${dataHORA2}" required/>
                                                                        </div>
                                                                </div>

                                                                <p class="p-3 text-center fs-5"><b> SALIDA PERSONAL</b></p>

                                                                <div class="row mx-0">
                                                                    <div class="col-12 col-md-8 my-2">
                                                                        <label class="input-group fw-bold" style="max-width:300px;">MOTIVO</label>
                                                                        <textarea id="MOTIVO" name="MOTIVO" class="in icon-input text-uppercase" rows="4" maxlength=500 placeholder="&#xf022; Motivo del permiso" style="width:100%" required>${dataMOTIVO}</textarea>
                                                                    </div>
                                                                </div>
                                                                <input id="ID" name="ID" value="${dataId}" type="hidden">
                                                        </form>
                                                </div>
                                                <div class="d-flex justify-content-center mt-5 my-1">
                                                        <button id="btnactualizar" class="btn boton" type="submit">
                                                            ACTUALIZAR INFORMACION
                                                        </button>   
                                                </div>`;
    }

    //PERMUTA
    else if (tipoPermiso == '7') {
        var dataSOLICITADO = boton.getAttribute('data-SOLICITADO');
        var dataFECHAPERMU1 = boton.getAttribute('data-FECHAPERMU1');
        var dataHORARIOPERMU1 = boton.getAttribute('data-HORARIOPERMU1');
        var dataHORARIOPERMU2 = boton.getAttribute('data-HORARIOPERMU2');
        var dataFECHAPERMU2 = boton.getAttribute('data-FECHAPERMU2');
        var dataHORARIOPERMU3 = boton.getAttribute('data-HORARIOPERMU3');
        var dataHORARIOPERMU4 = boton.getAttribute('data-HORARIOPERMU4');
        var dataFECHAPERMU3 = boton.getAttribute('data-FECHAPERMU3');
        var dataHORARIOPERMU5 = boton.getAttribute('data-HORARIOPERMU5');
        var dataHORARIOPERMU6 = boton.getAttribute('data-HORARIOPERMU6');
        var dataHRSTRABAJADAS1 = boton.getAttribute('data-HRSTRABAJADAS1');
        var dataHRSTRABAJADAS2 = boton.getAttribute('data-HRSTRABAJADAS2');
        var dataHRSTRABAJADAS3 = boton.getAttribute('data-HRSTRABAJADAS3');
        var dataTOTALHRSACUMU = boton.getAttribute('data-TOTALHRSACUMU');

        modalBody.innerHTML = `<div class="d-flex aling-content-center justify-content-center" id="formulario" name="formulario">
                                                        <!--Formulario de llenado-->
                                                            <form id="formulario-llenado" class="form-control px-5 border border-secondary border-2 rounded" style="max-width:90%;">
                                                                    <p class="px-3 text-center fs-5">
                                                                        <b> DATOS GENERALES</b>
                                                                    </p>

                                                                    <div class="row m-0 px-0">
                                                                        <div class="col-12 col-md-6 my-2 px-0">
                                                                            <div class="d-flex flex-column flex-wrap">
                                                                                <label class="input-group fw-bold px-1" for="NN" style="max-width:240px;">NÚMERO DE NÓMINA</label>  
                                                                                <input class="in icon-input" id="NN" name="NN" type="number" style="width:70%;" min=2 value="${dataNN}" placeholder="&#xf2b9; Escriba su número de nómina" readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 col-md-6 my-2 px-0">
                                                                            <div class="d-flex flex-column flex-wrap">
                                                                                <label class="input-group fw-bold px-1" for="NN" style="max-width:240px;">NOMBRE</label>  
                                                                                <input class="in icon-input" id="NOMBRE" name="NOMBRE" type="text" value="${dataNOMBRE}" placeholder="&#xf02d; Nombre" style="max-width:70%;" readonly>
                                                                            </div> 
                                                                        </div>
                                                                        <div class="col-12 col-md-6 my-2 px-0">
                                                                            <div class="d-flex flex-column flex-wrap">
                                                                                <label class="input-group fw-bold" for="NN" style="max-width:240px;">DEPARTAMENTO</label>  
                                                                                <input class="in icon-input" id="DEPARTAMENTO" name="DEPARTAMENTO" type="text" value="${dataDEPARTAMENTO}" placeholder="&#xf029; Departamento" style="width:70%;" readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 col-md-6 my-2 px-0">
                                                                            <div class="d-flex flex-column flex-wrap">
                                                                                <label class="input-group fw-bold" style="max-width:240px;">CÓDIGO SHOP</label>
                                                                                <select class="in icon-input" name="CODIGO_SHOP" id="CODIGO_SHOP" style="width:70%;" required>
                                                                                    <option value="1110 JMEX PLUNGER (APZ y AVO)" ${dataCODIGO_SHOP == "1110 JMEX PLUNGER (APZ y AVO)" ? 'selected' : ' '}>1110 JMEX PLUNGER (APZ y AVO)</option>
                                                                                    <option value="1111 APZ sleeve" ${dataCODIGO_SHOP == "1111 APZ sleeve" ? 'selected' : ' '}>1111 APZ sleeve</option>
                                                                                    <option value="1112 AVO Cover" ${dataCODIGO_SHOP == "1112 AVO Cover" ? 'selected' : ' '}>1112 AVO Cover</option>
                                                                                    <option value="1113 AXO PISTON" ${dataCODIGO_SHOP == "1113 AXO PISTON" ? 'selected' : ' '}>1113 AXO PISTON</option>
                                                                                    <option value="1120 STABILINK Manual" ${dataCODIGO_SHOP == "1120 STABILINK Manual" ? 'selected' : ' '}>1120 STABILINK Manual</option>
                                                                                    <option value="1121 STABILINK Automatica" ${dataCODIGO_SHOP == "1121 STABILINK Automatica" ? 'selected' : ' '}>1121 STABILINK Automatica</option>
                                                                                    <option value="1122 STABILINK Automatica FORD" ${dataCODIGO_SHOP == "1122 STABILINK Automatica FORD" ? 'selected' : ' '}>1122 STABILINK Automatica FORD</option>
                                                                                    <option value="1130 CARRIER" ${dataCODIGO_SHOP == "1130 CARRIER" ? 'selected' : ' '}>1130 CARRIER</option>
                                                                                    <option value="1131 HUB TWO WAY" ${dataCODIGO_SHOP == "1131 HUB TWO WAY" ? 'selected' : ' '}>1131 HUB TWO WAY</option>
                                                                                    <option value="1140 CAP-BRG" ${dataCODIGO_SHOP == "1140 CAP-BRG" ? 'selected' : ' '}>1140 CAP-BRG</option>
                                                                                    <option value="1150 B R K T" ${dataCODIGO_SHOP == "1150 B R K T" ? 'selected' : ' '}>1150 B R K T</option>
                                                                                    <option value="1160 COVER HUB" ${dataCODIGO_SHOP == "1160 COVER HUB" ? 'selected' : ' '}>1160 COVER HUB</option>
                                                                                    <option value="1160 PUM HUB" ${dataCODIGO_SHOP == "1160 PUM HUB" ? 'selected' : ' '}>1160 PUM HUB</option>
                                                                                    <option value="1160 VALEO" ${dataCODIGO_SHOP == "1160 VALEO" ? 'selected' : ' '}>1160 VALEO</option>
                                                                                    <option value="1170 HOUSING" ${dataCODIGO_SHOP == "1170 HOUSING" ? 'selected' : ' '}>1170 HOUSING</option>
                                                                                    <option value="1170 NSK WARNER" ${dataCODIGO_SHOP == "1170 NSK WARNER" ? 'selected' : ' '}>1170 NSK WARNER</option>
                                                                                    <option value="1180 HAL/AAM" ${dataCODIGO_SHOP == "1180 HAL/AAM" ? 'selected' : ' '}>1180 HAL/AAM</option>
                                                                                    <option value="1180 OUTLET WATER" ${dataCODIGO_SHOP == "1180 OUTLET WATER" ? 'selected' : ' '}>1180 OUTLET WATER</option>
                                                                                    <option value="1190 Grupo Administracion" ${dataCODIGO_SHOP == "1190 Grupo Administracion" ? 'selected' : ' '}>1190 Grupo Administracion</option>
                                                                                    <option value="1210 MOLDES MX" ${dataCODIGO_SHOP == "1210 MOLDES MX" ? 'selected' : ' '}>1210 MOLDES MX</option>
                                                                                    <option value="1220 MOLDES JP" ${dataCODIGO_SHOP == "1220 MOLDES JP" ? 'selected' : ' '}>1220 MOLDES JP</option>
                                                                                    <option value="5210 Grupo de Administracion" ${dataCODIGO_SHOP == "5210 Grupo de Administracion" ? 'selected' : ' '}>5210 Grupo de Administracion</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row m-0 px-0">
                                                                        <div class="col-12 my-2 px-0">
                                                                            <div class="d-flex flex-column flex-wrap"> 
                                                                                <label class="input-group fw-bold" style="max-width:240px;">FECHA DE REGISTRO</label>
                                                                                <input id="FECHA_SOLICITUD" name="FECHA_SOLICITUD" class="in" type="date" style="max-width:360px;" value="${dataFECHA_SOLICITUD}" readonly>
                                                                            </div>
                                                                        </div>
                                                                            <div class="col-12 col-md-5 col-xl-3 my-2">
                                                                                <label class="input-group fw-bold" style="max-width:240px;">DEL</label>
                                                                                <input id="FECHA_PERMISOA" name="FECHA_PERMISOA" class="in" type="date" value="${dataFECHA_PERMISOA}" style="max-width:auto;" required/>
                                                                            </div>
                                                                            <div class="col-12 col-md-5 col-xl-3 my-2">
                                                                                <label class="input-group fw-bold" style="max-width:240px;">AL</label>
                                                                                <input id="FECHA_PERMISOB" name="FECHA_PERMISOB" class="in" type="date" value="${dataFECHA_PERMISOB}" style="max-width:auto;" required/>
                                                                            </div>
                                                                            <div class="col-12 col-md-5 col-xl-3 my-2">
                                                                                <label class="input-group fw-bold" style="max-width:240px;">DE</label>
                                                                                <input id="HORA1" name="HORA1" class="in" type="time" style="max-width:auto;" value="${dataHORA1}"required/>
                                                                            </div>
                                                                            <div class="col-12 col-md-5 col-xl-3 my-2" style="max-width:240px;">
                                                                                <label class="input-group fw-bold">A</label>
                                                                                <input id="HORA2" name="HORA2" class="in" type="time" style="max-width:auto;" value="${dataHORA2}" required/>
                                                                            </div>
                                                                            <div class="col-12 col-md-5 col-xl-3 my-2" style="max-width:240px;">
                                                                                <label class="input-group fw-bold">SOLICITADO</label>
                                                                                <input id="SOLICITADO" name="SOLICITADO" class="in" type="text" style="max-width:auto;" value="${dataSOLICITADO}" readonly/>
                                                                            </div>
                                                                    </div>

                                                                    <div class="row mx-0">
                                                                        <div class="col-12 col-md-8 my-2">
                                                                            <label class="input-group fw-bold" style="max-width:300px;">MOTIVO</label>
                                                                            <textarea id="MOTIVO" name="MOTIVO" class="in icon-input text-uppercase" rows="4" maxlength=500 placeholder="&#xf022; Motivo del permiso" style="width:100%" required>${dataMOTIVO}</textarea>
                                                                        </div>
                                                                    </div>

                                                                    <p class="px-3 text-center fs-5"><b>PERMUTA</b></p>

                                                                    <div class="row mx-0">
                                                                        <div class="col-12 col-md-5 col-xl-3 my-2">
                                                                            <label class="input-group fw-bold" style="max-width:240px;">DÍA TRABAJADO</label>
                                                                            <input id="FECHAPERMU1" name="FECHAPERMU1" class="in" type="date" value="${dataFECHAPERMU1}" min="<?php echo date('Y-m-d', strtotime('-3 months')); ?>"  style="max-width:auto;" required/>
                                                                        </div>
                                                                        <div class="col-12 col-md-5 col-xl-3 my-2">
                                                                            <label class="input-group fw-bold" style="max-width:240px;">DE</label>
                                                                            <input id="HORARIOPERMU1" name="HORARIOPERMU1" class="in" type="time" value="${dataHORARIOPERMU1}" style="max-width:auto;" required/>
                                                                        </div>
                                                                        <div class="col-12 col-md-5 col-xl-3 my-2">
                                                                            <label class="input-group fw-bold" style="max-width:240px;">A</label>
                                                                            <input id="HORARIOPERMU2" name="HORARIOPERMU2" class="in" type="time" value="${dataHORARIOPERMU2}" style="max-width:auto;" required/>
                                                                        </div>
                                                                        <div class="col-12 my-2">
                                                                            <label class="input-group fw-bold" style="max-width:240px;">HORAS TRABAJADAS</label>
                                                                            <input id="HRSTRABAJADAS1" name="HRSTRABAJADAS1" placeholder="&#xf017; HRS. Trabajadas" class="in" type="text" value="${dataHRSTRABAJADAS1}" style="max-width:auto;" readonly/>
                                                                        </div>
                                                                    </div>

                                                                    <hr>
                                                                    
                                                                    <div class="row mx-0">
                                                                        <div class="col-12 col-md-5 col-xl-3 my-2">
                                                                            <label class="input-group fw-bold" style="max-width:240px;">DÍA TRABAJADO</label>
                                                                            <input id="FECHAPERMU2" name="FECHAPERMU2" class="in" type="date" value="${dataFECHAPERMU2}" min="<?php echo date('Y-m-d', strtotime('-3 months')); ?>"  style="max-width:auto;"/>
                                                                        </div>
                                                                        <div class="col-12 col-md-5 col-xl-3 my-2">
                                                                            <label class="input-group fw-bold" style="max-width:240px;">DE</label>
                                                                            <input id="HORARIOPERMU3" name="HORARIOPERMU3" class="in" type="time" value="${dataHORARIOPERMU3}" style="max-width:auto;" ${(dataFECHAPERMU2=="") ? "disabled"  : " "}/>
                                                                        </div>
                                                                        <div class="col-12 col-md-5 col-xl-3 my-2">
                                                                            <label class="input-group fw-bold" style="max-width:240px;">A</label>
                                                                            <input id="HORARIOPERMU4" name="HORARIOPERMU4" class="in" type="time" value="${dataHORARIOPERMU4}" style="max-width:auto;" ${(dataFECHAPERMU2=="") ? "disabled"  : " "}/>
                                                                        </div>
                                                                        <div class="col-12 my-2">
                                                                            <label class="input-group fw-bold" style="max-width:240px;">HORAS TRABAJADAS</label>
                                                                            <input id="HRSTRABAJADAS2" name="HRSTRABAJADAS2" placeholder="&#xf017; HRS. Trabajadas" class="in" type="text" value="${(dataFECHAPERMU2=="") ? ""  : dataHRSTRABAJADAS2}" style="max-width:auto;" readonly/>
                                                                        </div>
                                                                    </div>

                                                                    <hr>
                                                                    
                                                                    <div class="row mx-0">
                                                                        <div class="col-12 col-md-5 col-xl-3 my-2">
                                                                            <label class="input-group fw-bold" style="max-width:240px;">DÍA TRABAJADO</label>
                                                                            <input id="FECHAPERMU3" name="FECHAPERMU3" class="in" type="date" value="${dataFECHAPERMU3}" min="<?php echo date('Y-m-d', strtotime('-3 months')); ?>"  style="max-width:auto;"/>
                                                                        </div>
                                                                        <div class="col-12 col-md-5 col-xl-3 my-2">
                                                                            <label class="input-group fw-bold" style="max-width:240px;">DE</label>
                                                                            <input id="HORARIOPERMU5" name="HORARIOPERMU5" class="in" type="time" value="${dataHORARIOPERMU5}" style="max-width:auto;" ${(dataFECHAPERMU3=="") ? "disabled"  : " "}/>
                                                                        </div>
                                                                        <div class="col-12 col-md-5 col-xl-3 my-2">
                                                                            <label class="input-group fw-bold" style="max-width:240px;">A</label>
                                                                            <input id="HORARIOPERMU6" name="HORARIOPERMU6" class="in" type="time" value="${dataHORARIOPERMU6}" style="max-width:auto;" ${(dataFECHAPERMU3=="") ? "disabled"  : " "}/>
                                                                        </div>
                                                                        <div class="col-12 my-2">
                                                                            <label class="input-group fw-bold" style="max-width:240px;">HORAS TRABAJADAS</label>
                                                                            <input id="HRSTRABAJADAS3" name="HRSTRABAJADAS3" placeholder="&#xf017; HRS. Trabajadas" class="in" type="text" value="${(dataFECHAPERMU3=="") ? ""  : dataHRSTRABAJADAS3}" style="max-width:auto;" readonly/>
                                                                        </div>
                                                                    </div>

                                                                    <hr>
                                                                    <p class="px-3 text-center fs-5"><b>TOTAL DE HORAS ACUMULADAS</b></p>
                                                                    <div class="row mx-0">
                                                                        <div class="col-12 my-2">
                                                                            <label class="input-group fw-bold" style="max-width:240px;">HORAS ACUMULADAS</label>
                                                                            <input id="TOTALHRSACUMU" name="TOTALHRSACUMU" placeholder="&#xf017; HRS. Trabajadas" class="in" type="text" value="${dataTOTALHRSACUMU}" style="max-width:auto;" readonly/>
                                                                        </div>
                                                                    </div>
                                                                    <input id="ID" name="ID" value="${dataId}" type="hidden">
                                                            </form>
                                                        <!--Formulario de llenado-->                                                        
                                                    </div>
                                                    <div class="d-flex justify-content-center mt-5 my-1">
                                                            <button id="btnactualizar" class="btn boton" type="submit">
                                                                ACTUALIZAR INFORMACION
                                                            </button>   
                                                    </div>`;

                                                    validarPermuta();
    }

    //SALIDA DE TRABAJO
    else if (tipoPermiso == '8'){ 
        var dataCIUDAD = boton.getAttribute('data-CIUDAD');
        var dataLUGAR = boton.getAttribute('data-LUGAR');
        modalBody.innerHTML = `<div class="d-flex aling-content-center justify-content-center" id="formulario" name="formulario">
                                                        <form id="formulario-llenado" class="form-control px-5 border border-secondary border-2 rounded" style="max-width:90%;">
                                                            <p class="p-3 text-center fs-5">
                                                                <b> DATOS GENERALES</b>
                                                            </p>

                                                            <div class="row m-0 px-0">
                                                                <div class="col-12 col-md-6 my-2 px-0">
                                                                    <div class="d-flex flex-column flex-wrap">
                                                                        <label class="input-group fw-bold px-1" for="NN" style="max-width:240px;">NÚMERO DE NÓMINA</label>  
                                                                        <input class="in icon-input" id="NN" name="NN" type="number" style="width:70%;"  min=2 placeholder="&#xf2b9; Escriba su número de nómina" value="${dataNN}" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6 my-2 px-0">
                                                                    <div class="d-flex flex-column flex-wrap">
                                                                        <label class="input-group fw-bold px-1" for="NN" style="max-width:240px;">NOMBRE</label>  
                                                                        <input class="in icon-input" id="NOMBRE" name="NOMBRE" type="text" placeholder="&#xf02d; Nombre" value="${dataNOMBRE}" style="max-width:70%;" readonly>
                                                                    </div> 
                                                                </div>
                                                                <div class="col-12 col-md-6 my-2 px-0">
                                                                    <div class="d-flex flex-column flex-wrap">
                                                                        <label class="input-group fw-bold" for="NN" style="max-width:240px;">DEPARTAMENTO</label>  
                                                                        <input class="in icon-input" id="DEPARTAMENTO" name="DEPARTAMENTO" type="text" placeholder="&#xf029; Departamento" value="${dataDEPARTAMENTO}" style="width:70%;" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6 my-2 px-0">
                                                                    <div class="d-flex flex-column flex-wrap">
                                                                        <label class="input-group fw-bold" style="max-width:240px;">CÓDIGO SHOP</label>
                                                                            <select class="in icon-input" name="CODIGO_SHOP" id="CODIGO_SHOP" style="width:70%;" required>
                                                                                <option value="1110 JMEX PLUNGER (APZ y AVO)" ${dataCODIGO_SHOP == "1110 JMEX PLUNGER (APZ y AVO)" ? 'selected' : ' '}>1110 JMEX PLUNGER (APZ y AVO)</option>
                                                                                <option value="1111 APZ sleeve" ${dataCODIGO_SHOP == "1111 APZ sleeve" ? 'selected' : ' '}>1111 APZ sleeve</option>
                                                                                <option value="1112 AVO Cover" ${dataCODIGO_SHOP == "1112 AVO Cover" ? 'selected' : ' '}>1112 AVO Cover</option>
                                                                                <option value="1113 AXO PISTON" ${dataCODIGO_SHOP == "1113 AXO PISTON" ? 'selected' : ' '}>1113 AXO PISTON</option>
                                                                                <option value="1120 STABILINK Manual" ${dataCODIGO_SHOP == "1120 STABILINK Manual" ? 'selected' : ' '}>1120 STABILINK Manual</option>
                                                                                <option value="1121 STABILINK Automatica" ${dataCODIGO_SHOP == "1121 STABILINK Automatica" ? 'selected' : ' '}>1121 STABILINK Automatica</option>
                                                                                <option value="1122 STABILINK Automatica FORD" ${dataCODIGO_SHOP == "1122 STABILINK Automatica FORD" ? 'selected' : ' '}>1122 STABILINK Automatica FORD</option>
                                                                                <option value="1130 CARRIER" ${dataCODIGO_SHOP == "1130 CARRIER" ? 'selected' : ' '}>1130 CARRIER</option>
                                                                                <option value="1131 HUB TWO WAY" ${dataCODIGO_SHOP == "1131 HUB TWO WAY" ? 'selected' : ' '}>1131 HUB TWO WAY</option>
                                                                                <option value="1140 CAP-BRG" ${dataCODIGO_SHOP == "1140 CAP-BRG" ? 'selected' : ' '}>1140 CAP-BRG</option>
                                                                                <option value="1150 B R K T" ${dataCODIGO_SHOP == "1150 B R K T" ? 'selected' : ' '}>1150 B R K T</option>
                                                                                <option value="1160 COVER HUB" ${dataCODIGO_SHOP == "1160 COVER HUB" ? 'selected' : ' '}>1160 COVER HUB</option>
                                                                                <option value="1160 PUM HUB" ${dataCODIGO_SHOP == "1160 PUM HUB" ? 'selected' : ' '}>1160 PUM HUB</option>
                                                                                <option value="1160 VALEO" ${dataCODIGO_SHOP == "1160 VALEO" ? 'selected' : ' '}>1160 VALEO</option>
                                                                                <option value="1170 HOUSING" ${dataCODIGO_SHOP == "1170 HOUSING" ? 'selected' : ' '}>1170 HOUSING</option>
                                                                                <option value="1170 NSK WARNER" ${dataCODIGO_SHOP == "1170 NSK WARNER" ? 'selected' : ' '}>1170 NSK WARNER</option>
                                                                                <option value="1180 HAL/AAM" ${dataCODIGO_SHOP == "1180 HAL/AAM" ? 'selected' : ' '}>1180 HAL/AAM</option>
                                                                                <option value="1180 OUTLET WATER" ${dataCODIGO_SHOP == "1180 OUTLET WATER" ? 'selected' : ' '}>1180 OUTLET WATER</option>
                                                                                <option value="1190 Grupo Administracion" ${dataCODIGO_SHOP == "1190 Grupo Administracion" ? 'selected' : ' '}>1190 Grupo Administracion</option>
                                                                                <option value="1210 MOLDES MX" ${dataCODIGO_SHOP == "1210 MOLDES MX" ? 'selected' : ' '}>1210 MOLDES MX</option>
                                                                                <option value="1220 MOLDES JP" ${dataCODIGO_SHOP == "1220 MOLDES JP" ? 'selected' : ' '}>1220 MOLDES JP</option>
                                                                                <option value="5210 Grupo de Administracion" ${dataCODIGO_SHOP == "5210 Grupo de Administracion" ? 'selected' : ' '}>5210 Grupo de Administracion</option>
                                                                            </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row m-0 px-0">
                                                                <div class="col-12 my-2 px-0">
                                                                    <div class="d-flex flex-column flex-wrap"> 
                                                                        <label class="input-group fw-bold" style="max-width:240px;">FECHA DE SOLICITUD</label>
                                                                        <input id="FECHA_SOLICITUD" name="FECHA_SOLICITUD" class="in" type="date" style="max-width:360px;" value="${dataFECHA_SOLICITUD}" required>
                                                                    </div>
                                                                </div>
                                                                    <div class="col-12 col-md-5 col-xl-3 my-2">
                                                                        <label class="input-group fw-bold" style="max-width:240px;">DEL</label>
                                                                        <input id="FECHA_PERMISOA" name="FECHA_PERMISOA" class="in" type="date" value="${dataFECHA_PERMISOA}" style="max-width:auto;" required/>
                                                                    </div>
                                                                    <div class="col-12 col-md-5 col-xl-3 my-2">
                                                                        <label class="input-group fw-bold" style="max-width:240px;">AL</label>
                                                                        <input id="FECHA_PERMISOB" name="FECHA_PERMISOB" class="in" type="date" value="${dataFECHA_PERMISOB}" style="max-width:auto;" required/>
                                                                    </div>
                                                                    <div class="col-12 col-md-5 col-xl-3 my-2">
                                                                        <label class="input-group fw-bold" style="max-width:240px;">DE</label>
                                                                        <input id="HORA1" name="HORA1" class="in" type="time" value="${dataHORA1}" style="max-width:auto;" required/>
                                                                    </div>
                                                                    <div class="col-12 col-md-5 col-xl-3 my-2" style="max-width:240px;">
                                                                        <label class="input-group fw-bold">A</label>
                                                                        <input id="HORA2" name="HORA2" class="in" type="time" value="${dataHORA2}" style="max-width:auto;" required/>
                                                                    </div>
                                                            </div>

                                                            <p class="p-3 text-center fs-5"><b> SALIDA DE TRABAJO</b></p>

                                                            <div class="row mx-0">
                                                                <div class="col-12 col-md-4 my-2">
                                                                    <label class="input-group fw-bold" style="max-width:280px;">CIUDAD</label>
                                                                    <input id="CIUDAD" name="CIUDAD" class="in icon-input text-uppercase" type="text" maxlength=200 VALUE="${dataCIUDAD}" placeholder="&#xf072; Ciudad" style="max-width:100%" required>
                                                                </div>
                                                                <div class="col-12 col-md-5 my-2">
                                                                    <label class="input-group fw-bold px-0" style="max-width:310px">LUGAR (EMPRESA O INSTITUCIÓN)</label>
                                                                    <input id="LUGAR" name="LUGAR" class="in icon-input text-uppercase" type="text" value="${dataLUGAR}" maxlength=200 placeholder="&#xf19c; Lugar" style="max-width:100%" required>
                                                                </div>
                                                                <div class="col-12 col-md-8 my-2">
                                                                    <label class="input-group fw-bold" style="max-width:300px;">MOTIVO</label>
                                                                    <textarea id="MOTIVO" name="MOTIVO" class="in icon-input text-uppercase" rows="4" maxlength=500 placeholder="&#xf022; Motivo del permiso" style="width:100%" required>${dataMOTIVO}</textarea>
                                                                </div>
                                                            </div>

                                                            <input id="ID" name="ID" value="${dataId}" type="hidden">
                                                        </form>
                                                    </div>
                                                    <div class="d-flex justify-content-center mt-5 my-1">
                                                            <button id="btnactualizar" class="btn boton" type="submit">
                                                                ACTUALIZAR INFORMACION
                                                            </button>   
                                                    </div> `;
    }

    //VIAJE DE TRABAJO                   
    else if (tipoPermiso == '9') {
        var dataCIUDAD = boton.getAttribute('data-CIUDAD');
        var dataLUGAR = boton.getAttribute('data-LUGAR');
        var dataCANTDIAS = boton.getAttribute('data-CANTDIAS');
        var dataTOTAL= boton.getAttribute('data-TOTAL');
        var dataGASTOS = boton.getAttribute('data-GASTOS');
        var dataCASETAS= boton.getAttribute('data-CASETAS');
        var dataGASOLINA= boton.getAttribute('data-GASOLINA');
        var dataHOTEL= boton.getAttribute('data-HOTEL');
        var dataCOMIDAS= boton.getAttribute('data-COMIDAS');
        var dataTAXI= boton.getAttribute('data-TAXI');
        var dataOTROS = boton.getAttribute('data-OTROS');
        var dataTOTAL= boton.getAttribute('data-TOTAL'); 

        modalBody.innerHTML = `<div class="d-flex aling-content-center justify-content-center" id="formulario" name="formulario">
                                                        <!--Formulario de llenado-->
                                                            <form id="formulario-llenado" class="form-control px-5 border border-secondary border-2 rounded" style="max-width:90%;">
                                                                    <p class="p-3 text-center fs-5">
                                                                        <b> DATOS GENERALES</b>
                                                                    </p>

                                                                    <div class="row m-0 px-0">
                                                                        <div class="col-12 col-md-6 my-2 px-0">
                                                                            <div class="d-flex flex-column flex-wrap">
                                                                                <label class="input-group fw-bold px-1" for="NN" style="max-width:240px;">NÚMERO DE NÓMINA</label>  
                                                                                <input class="in icon-input" id="NN" name="NN" type="number" value="${dataNN}" style="width:70%;" min=2 placeholder="&#xf2b9; Escriba su número de nómina" readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 col-md-6 my-2 px-0">
                                                                            <div class="d-flex flex-column flex-wrap">
                                                                                <label class="input-group fw-bold px-1" for="NN" style="max-width:240px;">NOMBRE</label>  
                                                                                <input class="in icon-input" id="NOMBRE" name="NOMBRE" type="text" value="${dataNOMBRE}" placeholder="&#xf02d; Nombre" style="max-width:70%;" readonly>
                                                                            </div> 
                                                                        </div>
                                                                        <div class="col-12 col-md-6 my-2 px-0">
                                                                            <div class="d-flex flex-column flex-wrap">
                                                                                <label class="input-group fw-bold" for="NN" style="max-width:240px;">DEPARTAMENTO</label>  
                                                                                <input class="in icon-input" id="DEPARTAMENTO" name="DEPARTAMENTO" type="text" value="${dataDEPARTAMENTO}" placeholder="&#xf029; Departamento" style="width:70%;" readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 col-md-6 my-2 px-0">
                                                                            <div class="d-flex flex-column flex-wrap">
                                                                                <label class="input-group fw-bold" style="max-width:240px;">CÓDIGO SHOP</label>
                                                                                <select class="in icon-input" name="CODIGO_SHOP" id="CODIGO_SHOP" style="width:70%;" required>
                                                                                    <option value="1110 JMEX PLUNGER (APZ y AVO)" ${dataCODIGO_SHOP == "1110 JMEX PLUNGER (APZ y AVO)" ? 'selected' : ' '}>1110 JMEX PLUNGER (APZ y AVO)</option>
                                                                                    <option value="1111 APZ sleeve" ${dataCODIGO_SHOP == "1111 APZ sleeve" ? 'selected' : ' '}>1111 APZ sleeve</option>
                                                                                    <option value="1112 AVO Cover" ${dataCODIGO_SHOP == "1112 AVO Cover" ? 'selected' : ' '}>1112 AVO Cover</option>
                                                                                    <option value="1113 AXO PISTON" ${dataCODIGO_SHOP == "1113 AXO PISTON" ? 'selected' : ' '}>1113 AXO PISTON</option>
                                                                                    <option value="1120 STABILINK Manual" ${dataCODIGO_SHOP == "1120 STABILINK Manual" ? 'selected' : ' '}>1120 STABILINK Manual</option>
                                                                                    <option value="1121 STABILINK Automatica" ${dataCODIGO_SHOP == "1121 STABILINK Automatica" ? 'selected' : ' '}>1121 STABILINK Automatica</option>
                                                                                    <option value="1122 STABILINK Automatica FORD" ${dataCODIGO_SHOP == "1122 STABILINK Automatica FORD" ? 'selected' : ' '}>1122 STABILINK Automatica FORD</option>
                                                                                    <option value="1130 CARRIER" ${dataCODIGO_SHOP == "1130 CARRIER" ? 'selected' : ' '}>1130 CARRIER</option>
                                                                                    <option value="1131 HUB TWO WAY" ${dataCODIGO_SHOP == "1131 HUB TWO WAY" ? 'selected' : ' '}>1131 HUB TWO WAY</option>
                                                                                    <option value="1140 CAP-BRG" ${dataCODIGO_SHOP == "1140 CAP-BRG" ? 'selected' : ' '}>1140 CAP-BRG</option>
                                                                                    <option value="1150 B R K T" ${dataCODIGO_SHOP == "1150 B R K T" ? 'selected' : ' '}>1150 B R K T</option>
                                                                                    <option value="1160 COVER HUB" ${dataCODIGO_SHOP == "1160 COVER HUB" ? 'selected' : ' '}>1160 COVER HUB</option>
                                                                                    <option value="1160 PUM HUB" ${dataCODIGO_SHOP == "1160 PUM HUB" ? 'selected' : ' '}>1160 PUM HUB</option>
                                                                                    <option value="1160 VALEO" ${dataCODIGO_SHOP == "1160 VALEO" ? 'selected' : ' '}>1160 VALEO</option>
                                                                                    <option value="1170 HOUSING" ${dataCODIGO_SHOP == "1170 HOUSING" ? 'selected' : ' '}>1170 HOUSING</option>
                                                                                    <option value="1170 NSK WARNER" ${dataCODIGO_SHOP == "1170 NSK WARNER" ? 'selected' : ' '}>1170 NSK WARNER</option>
                                                                                    <option value="1180 HAL/AAM" ${dataCODIGO_SHOP == "1180 HAL/AAM" ? 'selected' : ' '}>1180 HAL/AAM</option>
                                                                                    <option value="1180 OUTLET WATER" ${dataCODIGO_SHOP == "1180 OUTLET WATER" ? 'selected' : ' '}>1180 OUTLET WATER</option>
                                                                                    <option value="1190 Grupo Administracion" ${dataCODIGO_SHOP == "1190 Grupo Administracion" ? 'selected' : ' '}>1190 Grupo Administracion</option>
                                                                                    <option value="1210 MOLDES MX" ${dataCODIGO_SHOP == "1210 MOLDES MX" ? 'selected' : ' '}>1210 MOLDES MX</option>
                                                                                    <option value="1220 MOLDES JP" ${dataCODIGO_SHOP == "1220 MOLDES JP" ? 'selected' : ' '}>1220 MOLDES JP</option>
                                                                                    <option value="5210 Grupo de Administracion" ${dataCODIGO_SHOP == "5210 Grupo de Administracion" ? 'selected' : ' '}>5210 Grupo de Administracion</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row m-0 px-0">
                                                                        <div class="col-12 my-2 px-0">
                                                                            <div class="d-flex flex-column flex-wrap"> 
                                                                                <label class="input-group fw-bold" style="max-width:240px;">FECHA DE SOLICITUD</label>
                                                                                <input id="FECHA_SOLICITUD" name="FECHA_SOLICITUD" class="in" type="date" style="max-width:360px;" value="${dataFECHA_SOLICITUD}" required>
                                                                            </div>
                                                                        </div>
                                                                            <div class="col-12 col-md-5 col-xl-3 my-2">
                                                                                <label class="input-group fw-bold" style="max-width:240px;">DEL</label>
                                                                                <input id="FECHA_PERMISOA" name="FECHA_PERMISOA" class="in" type="date" value="${dataFECHA_PERMISOA}" style="max-width:auto;" required/>
                                                                            </div>
                                                                            <div class="col-12 col-md-5 col-xl-3 my-2">
                                                                                <label class="input-group fw-bold" style="max-width:240px;">AL</label>
                                                                                <input id="FECHA_PERMISOB" name="FECHA_PERMISOB" class="in" type="date" value="${dataFECHA_PERMISOB}" style="max-width:auto;" required/>
                                                                            </div>
                                                                            <div class="col-12 col-md-5 col-xl-3 my-2">
                                                                                <label class="input-group fw-bold" style="max-width:240px;">DE</label>
                                                                                <input id="HORA1" name="HORA1" class="in" type="time" value="${dataHORA1}" style="max-width:auto;" required/>
                                                                            </div>
                                                                            <div class="col-12 col-md-5 col-xl-3 my-2" style="max-width:240px;">
                                                                                <label class="input-group fw-bold">A</label>
                                                                                <input id="HORA2" name="HORA2" class="in" type="time" value="${dataHORA2}" style="max-width:auto;" required/>
                                                                            </div>
                                                                    </div>

                                                                    <p class="p-3 text-center fs-5"><b> VIAJE DE TRABAJO</b></p>
                                                                    
                                                                    <div class="row mx-0">
                                                                        <div class="col-12 col-md-4 my-2">
                                                                            <label class="input-group fw-bold" style="max-width:280px;">DIAS</label>
                                                                            <input id="CANTDIAS" name="CANTDIAS" class="in icon-input" type="number" value="${dataCANTDIAS}" min=1 placeholder="&#xf185; Días del permiso" style="max-width:100%" readonly>
                                                                        </div>
                                                                        <div class="col-12 col-md-4 my-2">
                                                                            <label class="input-group fw-bold" style="max-width:280px;">CIUDAD</label>
                                                                            <input id="CIUDAD" name="CIUDAD" class="in icon-input text-uppercase" type="text" value="${dataCIUDAD}" maxlength=200 placeholder="&#xf072; Ciudad" style="max-width:100%" required>
                                                                        </div>
                                                                        <div class="col-12 col-md-5 my-2">
                                                                            <label class="input-group fw-bold px-0" style="max-width:310px">LUGAR (EMPRESA O INSTITUCIÓN)</label>
                                                                            <input id="LUGAR" name="LUGAR" class="in icon-input text-uppercase" type="text" value="${dataLUGAR}" maxlength=200 placeholder="&#xf19c; Lugar" style="max-width:100%" required>
                                                                        </div>
                                                                        <div class="col-12 col-md-8 my-2">
                                                                            <label class="input-group fw-bold" style="max-width:300px;">MOTIVO</label>
                                                                            <textarea id="MOTIVO" name="MOTIVO" class="in icon-input text-uppercase" rows="4" maxlength=500 placeholder="&#xf022; Motivo del permiso" style="width:100%" required>${dataMOTIVO}</textarea>
                                                                        </div>
                                                                        <div class="col-12 col-md-6 my-2">
                                                                            <label class="input-group fw-bold">REQUIER GASTO DE VIAJE</label>
                                                                            <select class="in" name="GASTOS" id="GASTOS" style="width:150px" required>
                                                                                <option class="text-center" value="" selected>---GASTOS---</option>
                                                                                <option value="NO" ${dataGASTOS == "NO" ? 'selected' : ' '}>NO</option>
                                                                                <option value="SI" ${dataGASTOS == "SI" ? 'selected' : ' '}>SI</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <p class="p-3 text-center fs-5"><b> DESGLOCE DE GASTOS</b></p>
                                                                    <div class="row mx-0">
                                                                        <div class="col my-1">
                                                                            <label class="input-group fw-bold">CASETAS</label>
                                                                            <input id="CASETAS" name="CASETAS" class="in icon-input gastos" placeholder="&#xf187;" type="number" value="${dataCASETAS}" min=0 max=1000000 ${dataGASTOS == "NO" ? 'disabled' : ' '}>
                                                                        </div>
                                                                        <div class="col my-1">
                                                                            <label class="input-group fw-bold">GASOLINA</label>
                                                                            <input id="GASOLINA" name="GASOLINA" class="in icon-input gastos" placeholder="&#xf06d;" type="number" value="${dataGASOLINA}" min=0 max=1000000 ${dataGASTOS == "NO" ? 'disabled' : ' '}>
                                                                        </div>
                                                                        <div class="col my-1">
                                                                            <label class="input-group fw-bold">HOTEL</label>
                                                                            <input id="HOTEL" name="HOTEL" class="in icon-input gastos" placeholder="&#xf1ad;" type="number" value="${dataHOTEL}" min=0 max=1000000 ${dataGASTOS == "NO" ? 'disabled' : ' '}>
                                                                        </div>
                                                                        <div class="col my-1">
                                                                            <label class="input-group fw-bold">COMIDAS</label>
                                                                            <input id="COMIDAS" name="COMIDAS" class="in icon-input gastos" placeholder="&#xf1fd;" type="number" value="${dataCOMIDAS}" min=0 max=1000000 ${dataGASTOS == "NO" ? 'disabled' : ' '}>
                                                                        </div>
                                                                        <div class="col my-1">
                                                                            <label class="input-group fw-bold">TAXIS</label>
                                                                            <input id="TAXI" name="TAXI" class="in icon-input gastos" placeholder="&#xf1ba;" type="number" value="${dataTAXI}" min=0 max=1000000 ${dataGASTOS == "NO" ? 'disabled' : ' '}>
                                                                        </div>
                                                                        <div class="col my-1">
                                                                            <label class="input-group fw-bold">OTROS</label>
                                                                            <input id="OTROS" name="OTROS" class="in icon-input gastos" placeholder="&#xf02b;" type="number" value="${dataOTROS}" min=0 max=1000000 ${dataGASTOS == "NO" ? 'disabled' : ' '}>
                                                                        </div>
                                                                    </div>
                                                                    <div class="my-3 px-2">
                                                                        <label class="input-group fw-bold">TOTAL</label>
                                                                        <input id="TOTAL" name="TOTAL" class="in icon-input" placeholder="&#xf0d6;" type="number" value="${dataTOTAL}" readonly>
                                                                    </div>
                                                                    
                                                                    <input id="ID" name="ID" value="${dataId}" type="hidden">
                                                            </form>
                                                        <!--Formulario de llenado-->
                                                    </div>
                                                    <div class="d-flex justify-content-center mt-5 my-1">
                                                            <button id="btnactualizar" class="btn boton" type="submit">
                                                                ACTUALIZAR INFORMACION
                                                            </button>   
                                                    </div>
                                                    `;
        if (GASTOS) GASTOS.addEventListener("change", function () {
            if (GASTOS.value == "SI") var disabled = false;
            else if (GASTOS.value == "NO") disabled = true;
            var gasto = document.querySelectorAll('.gastos');
            gasto.forEach(function (campo) {
                campo.disabled = disabled;
                if (disabled) campo.value = "";
            });
        });
    }

    var btnactualizar = document.getElementById("btnactualizar");
    btnactualizar.addEventListener("click", actualizarRegistro)
    var numero_de_nomina = document.getElementById("NN");
    if (numero_de_nomina) numero_de_nomina.addEventListener("change", obtenerNombre);
}
/*Fin del formulario para editar permisos*/

//VENTANA EMERGENTE PARA REIMPRIMIR UN PERMISO EN LA TABLA DEL PANEL
function imprimirRegistro(id) {
    var opcionesVentana = `width=${window.innerWidth},height=${window.innerHeight},top=0,left=0,resizable=yes,scrollbars=yes`;
    var tipoPermiso= document.getElementById("tipoPermiso").value;
    window.open("./imprimir.php?id="+id+"&tipoPermiso="+tipoPermiso, "imprimir", opcionesVentana);
}

//Funcion para actualizar los datos del formulario de actualizar datos de permiso
function actualizarRegistro() {
    var tipoPermiso = document.getElementById("tipoPermiso").value;
    var fmllenado = document.getElementById("formulario-llenado");
    var isValid = fmllenado.reportValidity();
    validarLlenado();

    if (isValid) {
        var fi = document.getElementById("FECHA_PERMISOA").value; //inicio de permiso
        var ff = document.getElementById("FECHA_PERMISOB").value; //fin del permiso
        var hi = document.getElementById("HORA1").value; //inicio de permiso
        var hf = document.getElementById("HORA2").value; //fin del permiso


        if (document.getElementById("NOMBRE").value == "" || document.getElementById("DEPARTAMENTO").value == "")
            alert("Ingrese un número de nómina válido")

        else
            if (fi > ff)
                alert("La fecha de inicio no puede ser mayor a la fecha de fin")

            else
                if (fi == ff && hi > hf)
                    alert("La hora de inicio no puede ser mayor a la hora de fin")


                else {
                    var formData = new FormData(fmllenado);
                    var fechaArray = formData.get('FECHA_SOLICITUD').split('-');
                    var fechaSolicitud = fechaArray[2] + '/' + fechaArray[1] + '/' + fechaArray[0];

                    var DEL = formData.get('FECHA_PERMISOA').split('-');
                    var DEL = DEL[2] + '/' + DEL[1] + '/' + DEL[0];

                    var AL = formData.get('FECHA_PERMISOB').split('-');
                    var AL = AL[2] + '/' + AL[1] + '/' + AL[0];


                    //Calcular la cantidad de días del permiso
                    var fechai = new Date(formData.get('FECHA_PERMISOA'));
                    var fechaf = new Date(formData.get('FECHA_PERMISOB'));
                    var dias = fechaf.getTime() - fechai.getTime();
                    var dias = (dias / (1000 * 60 * 60 * 24)) + 1;

                    formData.set('CANTDIAS', dias)
                    formData.append("tipoPermiso",tipoPermiso);
                    formData.append("opcion",11);

                    //Salida personal
                    if(tipoPermiso=="6"){ 
                        fetch("./base_de_datos/operaciones.php", {
                            method: "POST",
                            body: formData,
                          })
                            .then((response) => response.text())
                            .then((data) => {
                                alert(data);
                            })
                            .catch((error) => {
                              console.log(error);
                            });
                    }

                    else  //Permuta
                    if (tipoPermiso == "7") {
                        var SOLICITADO = "";

                        //if (formData.get("HORARIOPERMU1") > formData.get("HORARIOPERMU2") || formData.get("HORARIOPERMU3") > formData.get("HORARIOPERMU4") || formData.get("HORARIOPERMU5") > formData.get("HORARIOPERMU6"))
                            //alert("La hora de inicio de la permuta no puede ser mayor que la hora de fin de la permuta")
                        
                        //else {
                            if (formData.get("FECHA_SOLICITUD") > formData.get("FECHA_PERMISOA"))
                                SOLICITADO = "DESPUES"
                        
                            else if (formData.get("FECHA_SOLICITUD") < formData.get("FECHA_PERMISOA"))
                                SOLICITADO = "ANTES"
                        
                            else if (formData.get("FECHA_SOLICITUD") == formData.get("FECHA_PERMISOA")) {
                                var fechaHoraActual = new Date();
                                var horaActual = fechaHoraActual.getHours();
                                var minutosActuales = fechaHoraActual.getMinutes();
                        
                                // Formateo de la hora y los minutos para asegurar que tengan dos dígitos
                                var horaFormateada = horaActual.toString().padStart(2, '0');
                                var minutosFormateados = minutosActuales.toString().padStart(2, '0');
                                var horaActualf = horaFormateada + ":" + minutosFormateados;
                        
                                if (formData.get("HORA1") >= horaActualf) SOLICITADO = "ANTES";
                                else if (formData.get("HORA1") < horaActualf) SOLICITADO = "DESPUES"
                            }
                        
                            var FECHAPERMU1 = formData.get('FECHAPERMU1').split('-');
                            FECHAPERMU1 = FECHAPERMU1[2] + '/' + FECHAPERMU1[1] + '/' + FECHAPERMU1[0];
                            var inicio = new Date('1970-01-01T' + formData.get("HORARIOPERMU1"));
                            var HORARIOPERMU1 = '1970-01-01 '+formData.get("HORARIOPERMU1");
                            
                            if (formData.get("HORARIOPERMU1") > formData.get("HORARIOPERMU2")) {
                                var fin = new Date('1970-01-02T' + formData.get("HORARIOPERMU2")); 
                                var HORARIOPERMU2 = '1970-01-02 '+ formData.get("HORARIOPERMU2");   
                            }

                            else {
                                var fin = new Date('1970-01-01T' + formData.get("HORARIOPERMU2") );
                                var HORARIOPERMU2 = '1970-01-01 '+ formData.get("HORARIOPERMU2");
                        }
                            // Restar las horas
                            var diferencia = fin.getTime() - inicio.getTime();
                        
                            // Convertir la diferencia a horas y minutos
                            var horas = Math.floor(diferencia / (1000 * 60 * 60));
                            var minutos = Math.floor((diferencia % (1000 * 60 * 60)) / (1000 * 60));
                        
                            // Formatear la diferencia como hora:minuto
                            var HRSTRABAJADAS1 = horas.toString().padStart(2, '0') + ':' + minutos.toString().padStart(2, '0');
                        
                            if (formData.get("FECHAPERMU2") != "" && formData.get("FECHAPERMU2") != null) {
                                var FECHAPERMU2 = formData.get('FECHAPERMU2').split('-');
                                FECHAPERMU2 = FECHAPERMU2[2] + '/' + FECHAPERMU2[1] + '/' + FECHAPERMU2[0];
                        
                                  // Convertir las horas en objetos Date
                                  var inicio = new Date('1970-01-01 ' + formData.get("HORARIOPERMU3"));
                                  var HORARIOPERMU3 = '1970-01-01 '+formData.get("HORARIOPERMU3");

                                if (formData.get("HORARIOPERMU3") > formData.get("HORARIOPERMU4")){
                                    var fin = new Date('1970-01-02 ' + formData.get("HORARIOPERMU4"));
                                    var HORARIOPERMU4 = '1970-01-02 '+formData.get("HORARIOPERMU4");
                                }

                                else {
                                    // Convertir las horas en objetos Date
                                    var fin = new Date('1970-01-01 ' + formData.get("HORARIOPERMU4"));
                                    var HORARIOPERMU4 = '1970-01-01 '+formData.get("HORARIOPERMU4");
                                }
                        
                                // Restar las horas
                                var diferencia = fin.getTime() - inicio.getTime();
                        
                                // Convertir la diferencia a horas y minutos
                                var horas = Math.floor(diferencia / (1000 * 60 * 60));
                                var minutos = Math.floor((diferencia % (1000 * 60 * 60)) / (1000 * 60));
                        
                                // Formatear la diferencia como hora:minuto
                                var HRSTRABAJADAS2 = horas.toString().padStart(2, '0') + ':' + minutos.toString().padStart(2, '0');
                            }
                        
                            else {
                                FECHAPERMU2 = ""
                                HRSTRABAJADAS2 = "";
                            }
                        
                            if (formData.get("FECHAPERMU3") != "" && formData.get("FECHAPERMU3") != null) {
                                var FECHAPERMU3 = formData.get('FECHAPERMU3').split('-');
                                FECHAPERMU3 = FECHAPERMU3[2] + '/' + FECHAPERMU3[1] + '/' + FECHAPERMU3[0];
                                
                                // Convertir las horas en objetos Date
                                var inicio = new Date('1970-01-01T' + formData.get("HORARIOPERMU5") + 'Z');
                                var HORARIOPERMU5 = '1970-01-01 '+formData.get("HORARIOPERMU5");
 
                                if (formData.get("HORARIOPERMU5") > formData.get("HORARIOPERMU6")) {
                                    var fin = new Date('1970-01-02T' + formData.get("HORARIOPERMU6") + 'Z');
                                    var HORARIOPERMU6 = '1970-01-02 '+formData.get("HORARIOPERMU6");
                                }

                               else {
                                       // Convertir las horas en objetos Date
                                       var fin = new Date('1970-01-01T' + formData.get("HORARIOPERMU6") + 'Z');
                                       var HORARIOPERMU6 = '1970-01-01 '+formData.get("HORARIOPERMU6");
                               }
                                // Restar las horas
                                var diferencia = fin.getTime() - inicio.getTime();
                        
                                // Convertir la diferencia a horas y minutos
                                var horas = Math.floor(diferencia / (1000 * 60 * 60));
                                var minutos = Math.floor((diferencia % (1000 * 60 * 60)) / (1000 * 60));
                        
                                // Formatear la diferencia como hora:minuto
                                var HRSTRABAJADAS3 = horas.toString().padStart(2, '0') + ':' + minutos.toString().padStart(2, '0');
                            }
                        
                            else {
                                FECHAPERMU3 = ""
                                HRSTRABAJADAS3 = ""
                            }
                        
                            var requestOptions = {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                body: 'opcion=13&HRSTRABAJADAS1='+HRSTRABAJADAS1+
                                      '&HRSTRABAJADAS2='+HRSTRABAJADAS2+
                                      '&HRSTRABAJADAS3='+HRSTRABAJADAS3+
                                      '&FECHAPERMU1='+FECHAPERMU1+
                                      '&FECHAPERMU2='+FECHAPERMU2+
                                      '&FECHAPERMU3='+FECHAPERMU3+
                                      '&HORARIOPERMU1='+HORARIOPERMU1+
                                      '&HORARIOPERMU2='+HORARIOPERMU2+
                                      '&HORARIOPERMU3='+HORARIOPERMU3+
                                      '&HORARIOPERMU4='+HORARIOPERMU4+
                                      '&HORARIOPERMU5='+HORARIOPERMU5+
                                      '&HORARIOPERMU6='+HORARIOPERMU6+
                                      '&NN='+document.getElementById("NN").value
                            };

                            //console.log(HORARIOPERMU1);
                            //console.log(HORARIOPERMU2);
                            //console.log(HRSTRABAJADAS1)
                            //console.log(HORARIOPERMU3);
                            //console.log(HORARIOPERMU4);
                            //console.log(HRSTRABAJADAS2)
                            //console.log(HORARIOPERMU5);
                            //console.log(HORARIOPERMU6);
                            //console.log(HRSTRABAJADAS3)
                            //console.log(HRSTRABAJADAS3)
                        
                            fetch("./base_de_datos/operaciones.php", requestOptions)
                                .then((response) => response.json())
                                .then((data) => {
                                    formData.set("SOLICITADO", SOLICITADO)
                                    formData.set("TOTALHRSACUMU", data.htotal)
                                    formData.set("HRSTRABAJADAS1", data.HRSTRABAJADAS1)
                                    formData.set("HRSTRABAJADAS2", data.HRSTRABAJADAS2)
                                    formData.set("HRSTRABAJADAS3", data.HRSTRABAJADAS3)
                                    
                                    document.getElementById("SOLICITADO").value= SOLICITADO;
                                    document.getElementById("HRSTRABAJADAS1").value= data.HRSTRABAJADAS1.toString();
                                    document.getElementById("HRSTRABAJADAS2").value= data.HRSTRABAJADAS2.toString();
                                    document.getElementById("HRSTRABAJADAS3").value= data.HRSTRABAJADAS3.toString(); 
                                    document.getElementById("TOTALHRSACUMU").value= data.htotal.toString();
                                    console.log(data);
                        
                                    fetch("./base_de_datos/operaciones.php", {
                                        method: "POST",
                                        body: formData
                                    })
                                        .then((response) => response.text())
                                        .then((data) => {
                                                alert(data);
                                        })
                                        .catch((error) => {
                                            console.log(error);
                                        });
                                })
                                .catch((error) => {
                                    console.log(error);
                                });
                        //}
                    }

                    else //Salida de trabajo
                    if(tipoPermiso=="8"){
                        fetch("./base_de_datos/operaciones.php", {
                            method: "POST",
                            body: formData,
                          })
                            .then((response) => response.text())
                            .then((data) => {
                                alert(data);
                    
                                var table = $('#myTable').DataTable();

                                var data = table.rows(0).data();
                                console.log(data[0].name())

                                for (var i = 0; i < data.length; i++) {
                                    if (data[i][0] == document.getElementById("ID").value) 
                                        var indiceFila = i;

                                    else  var indiceFila = -1;

                                    console.log(data[i].name())
                                }

                                console.log(indiceFila)
                            })
                            .catch((error) => {
                              console.log(error);
                            });
                    }

                    else //Viaje de trabajo
                        if(tipoPermiso=="9"){
                            var CANTDIAS = document.getElementById("CANTDIAS");
                            var TOTAL = document.getElementById("TOTAL");

                            //Calcular la cantidad de días del permiso
                            var fechai = new Date(formData.get('FECHA_PERMISOA'));
                            var fechaf = new Date(formData.get('FECHA_PERMISOB'));
                            var dias = fechaf.getTime() - fechai.getTime();
                            var dias = (dias / (1000 * 60 * 60 * 24)) + 1;

                            formData.get('CASETAS') == "" || formData.get('CASETAS') == null ? formData.set('CASETAS', 0) : "";
                            formData.get('GASOLINA') == "" || formData.get('GASOLINA') == null ? formData.set('GASOLINA', 0) : "";
                            formData.get('HOTEL') == "" || formData.get('HOTEL') == null ? formData.set('HOTEL', 0) : "";
                            formData.get('COMIDAS') == "" || formData.get('COMIDAS') == null ? formData.set('COMIDAS', 0) : "";
                            formData.get('TAXI') == "" || formData.get('TAXI') == null ? formData.set('TAXI', 0) : "";
                            formData.get('OTROS') == "" || formData.get('OTROS') == null ? formData.set('OTROS', 0) : "";

                            var total = parseInt(formData.get('CASETAS')) + parseInt(formData.get('GASOLINA')) + parseInt(formData.get('HOTEL')) + parseInt(formData.get('COMIDAS')) + parseInt(formData.get('TAXI')) + parseInt(formData.get('OTROS'));
                            TOTAL.value= total;
                            CANTDIAS.value=dias;

                            formData.set("TOTAL",total);
                            formData.set("CANTDIAS",dias);

                            fetch("./base_de_datos/operaciones.php", {
                                method: "POST",
                                body: formData,
                              })
                                .then((response) => response.text())
                                .then((data) => {
                                    alert(data);
                                })
                                .catch((error) => {
                                  console.log(error);
                                });
                        }
                }
    }
}

/*Funcion para actualizar tabla de reportes en la seccion de ver reportes o registro de permisos*/
function actualizarReportes() {
    var ancho = window.innerWidth;
    var columnasTabla = document.getElementById("columnas");
    var requestOptions = {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'opcion=12&tipoPermiso=' + document.getElementById("tipoPermisoR").value + '&pago=' +  document.querySelector('input[name="filtroSQ"]:checked').value 
    };

    //console.log(document.querySelector('input[name="filtroSQ"]:checked').value); obtener el value del radio con jquery

    fetch('./base_de_datos/operaciones.php', requestOptions)
        .then(response => response.text())
            .then((data) => {
                
                //Resetear el dataTable
                $('#tableReportes').DataTable().clear();  //Limpiar las columnas
                $('#tableReportes').DataTable().destroy(); //Restaurar la tablas
                

                // Crear la configuración de las columnas para DataTables
                var response = JSON.parse(data);
                var columnas = Object.keys(response[0]);
                var columnasConfig = columnas.map(function (columna) { return { "data": columna }; });

                //Restear las columnas de la tabla
                while (columnasTabla.firstChild) 
                    columnasTabla.removeChild(columnasTabla.firstChild);

                $('#tableReportes thead tr:nth-child(2)').remove(); //Se elimina la fila clonada (2)
                        

                //Agregar las nuevas columnas a la tabla
                columnas.forEach(columna => {
                    const fila = document.createElement("th");
                    fila.textContent = columna;
                    columnasTabla.appendChild(fila);
                });

                                //Creamos una fila en el head de la tabla y lo clonamos para cada columna
                                $('#tableReportes thead tr').clone().appendTo('#tableReportes thead');
                                $('#tableReportes thead tr:eq(1) th').each(function (i) {
                                    var title = $(this).text(); //es el nombre de la columna
                                    $(this).html( '<input class="p-0 m-0" type="text" style="width:100%" placeholder="'+title+'" />' );                      
                                    $( 'input', this ).on( 'keyup change', function () {
                                        if ( $('#tableReportes').DataTable().column(i).search() !== this.value)
                                            $('#tableReportes').DataTable().column(i).search( this.value).draw();
                                    });
                                });

                //Crear el dataTable con las nuevas configuraciones
                $('#tableReportes').DataTable({
                    responsive: true,
                    scrollX: (ancho-50),
                    scrollY: 500,
                    scrollCollapse: true,
                    columns: columnasConfig,
                    data: response,
                    fixedHeader: true,
                });   


            }).catch(error => {
                console.log('Error:', error);

                while (columnasTabla.firstChild) 
                    columnasTabla.removeChild(columnasTabla.firstChild);

                $('#tableReportes thead tr:eq(1) th').remove();
                $('#tableReportes').DataTable().clear();
                $('#tableReportes').DataTable().destroy();
                $('#tableReportes').DataTable();
        });
    }
/*Fin actualizar tabla de reportes */


 function changeType(){
   password = document.getElementById("passwordpanel");
   var btnchange = document.getElementById("btn-change");
   
   if (password.type === "password") 
       password.type = "text";

    else 
       password.type = "password";
   
   btnchange.classList.toggle("fa-eye-slash")
 } 

 function changeTyperep(){
    password = document.getElementById("passworreportes");
    var btnchange = document.getElementById("btn-changerep");
    
    if (password.type === "password") 
        password.type = "text";
 
     else 
        password.type = "password";
    
    btnchange.classList.toggle("fa-eye-slash")
  } 

 function loginPanel(){
   
   var pass =  document.getElementById("passwordpanel").value;
   var formData = new FormData();
   formData.append('password',pass);
   formData.append('opcion',14);

   fetch("./base_de_datos/operaciones.php", {
    method: "POST",
    body: formData
    }).then((response) => response.json()).
        then((data) => {
                if(data.ok) cargarContenido("panel", "EDITAR PERMISOS")
                
                    else alert("Contraseña incorrecta");

            console.log(data)
        })
        .catch((error) => {
            console.log(error);
        });
    
    }
 
 function loginRegistros(){
    var pass =  document.getElementById("passworreportes").value;
    var formData = new FormData();
    formData.append('password',pass);
    formData.append('opcion',15);
 
    fetch("./base_de_datos/operaciones.php", {
     method: "POST",
     body: formData
     }).then((response) => response.json()).
         then((data) => {
                 if(data.ok) cargarContenido("PERMISOS_GUARDADOS", "REGISTRO DE PERMISOS")
                 
                     else alert("Contraseña incorrecta");
 
             console.log(data)
         })
         .catch((error) => {
             console.log(error);
         });
}

function cerrarSession(){
    var formData = new FormData();
    formData.append('opcion',16);
 
    fetch("./base_de_datos/operaciones.php", {
     method: "POST",
     body: formData
     }).then((response) => response.json()).
         then((data) => {
            cargarContenido("menu", "SOLICITUD DE PERMISOS")
         })
         .catch((error) => {
             console.log(error);
         });
}
 

/*
window.onbeforeprint = function() {
    console.log('El usuario ha hecho clic en el botón de imprimir');
};
table.rows.add(response).draw()
*/