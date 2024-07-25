<?php include_once "../login/verificar_sesion.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <style>
        #cliente {
            margin-top: 50px;
            border-radius: 20px;
            padding: 20px;
        }

        .custom-file-input {
            color: transparent;
            height: auto;
            cursor: pointer;
        }

        .custom-file-input::-webkit-file-upload-button {
            visibility: hidden;
        }

        .custom-file-input::before {
            content: 'Seleccionar archivo';
            display: inline-block;
            background: #679BD4;
            color: #fff;
            border: 1px solid #fe5000;
            border-radius: 5px;
            padding: 6px 10px;
            outline: none;
            white-space: nowrap;
            cursor: pointer;
        }

        .custom-file-input:hover::before {
            border-color: #679BD4;
        }

        .custom-file-input:active::before {
            background: #679BD4;
        }

        .custom-file-input:lang(es)::before {
            content: 'Subir archivo';
        }

        label.subir {
            font-weight: 500;
        }

        .input-group-text.text-success {
            color: #28a745; /* Color verde de éxito */
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-1 d-none d-sm-block">
                <a href="javascript:history.back()" class="btn-link i.fasbtn btn-link mt-2 ml-2"><i class="fas fa-arrow-left" style="color: red;"></i></a>
            </div>
            <div class="col-11">
                <div class="row justify-content-center">
                    <div class="col-md-9">
                        <form action="./crearcliente.php"   method="post" id="cliente" class="text-center border border-light p-3 shadow-lg rounded-lg" style="border-radius: 18px; margin-top: 18px;" enctype="multipart/form-data">

                            <p class="h2 mb-4">Ingrese cliente</p>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="Nit" class="form-label">Nit</label>
                                    <input type="number" class="form-control" id="Nit" name="id_cliente" placeholder="Nit">
                                </div>

                                <div class="col-md-6">
                                    <label for="Nombre" class="form-label">Razón Social</label>
                                    <input type="text" class="form-control" id="Nombre" name="nombre" placeholder="Razón Social">
                                </div>
                            </div>

                            <div class="row mb-4 justify-content-center">
                                <div class="col-md-6">
                                    <label for="Representante" class="form-label">Nombre Representante</label>
                                    <input type="text" class="form-control" id="Representante" name="representantelegal" placeholder="Nombre Representante">
                                </div>
                            </div>

                            <div class="row mb-4 justify-content-center">
                                <div class="col-md-6">
                                    <label for="correo" class="form-label">Correo</label>
                                    <input type="text" class="form-control" id="correo" name="correo" placeholder="correo">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="Teléfono" class="form-label">Teléfono</label>
                                    <input type="tel" class="form-control" id="Teléfono" name="telefono" placeholder="Teléfono">
                                </div>

                                <div class="col-md-6">
                                    <label for="Dirección" class="form-label">Dirección</label>
                                    <input type="text" class="form-control" id="Dirección" name="direccion" placeholder="Dirección">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label for="Camara" class="form-label subir">Cámara de comercio</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control custom-file-input" id="Camara" name="camara" aria-describedby="inputGroupFileAddon1" accept=".pdf">
                                        <label class="input-group-text" for="Camara" id="camaraLabel"><i class="fas fa-check-circle"></i></label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="rut" class="form-label subir">RUT</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control custom-file-input" id="rut" name="rut" aria-describedby="inputGroupFileAddon2" accept=".pdf">
                                        <label class="input-group-text" for="rut" id="rutLabel"><i class="fas fa-check-circle"></i></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="CC" class="form-label subir">CC Representante</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control custom-file-input" id="CC" name="cc" aria-describedby="inputGroupFileAddon3" accept=".pdf">
                                        <label class="input-group-text" for="CC" id="CCLabel"><i class="fas fa-check-circle"></i></label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label for="comercial" class="form-label subir">Certificación comercial</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control custom-file-input" id="comercial" name="comercial" aria-describedby="inputGroupFileAddon1" accept=".pdf">
                                        <label class="input-group-text" for="comercial" id="comercialLabel"><i class="fas fa-check-circle"></i></label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="bancaria" class="form-label subir">Certificación bancaria</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control custom-file-input" id="bancaria" name="bancaria" aria-describedby="inputGroupFileAddon2" accept=".pdf">
                                        <label class="input-group-text" for="bancaria" id="bancariaLabel"><i class="fas fa-check-circle"></i></label>
                                    </div>
                                </div>

                                <div class="col-md-4 file">
                                    <label for="Circular" class="form-label subir">Circular 170</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control custom-file-input" id="circular" name="circular" aria-describedby="inputGroupFileAddon3" accept=".pdf">
                                        <label class="input-group-text" for="Circular" id="circularLabel"><i class="fas fa-check-circle"></i></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label for="seguridad" class="form-label subir">Acuerdos de seguridad</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control custom-file-input" id="seguridad" name="seguridad" aria-describedby="inputGroupFileAddon4" accept=".pdf">
                                        <label class="input-group-text" for="seguridad" id="seguridadLabel"><i class="fas fa-check-circle"></i></label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="financieros" class="form-label subir">Estados financieros</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control custom-file-input" id="financieros" name="financieros" aria-describedby="inputGroupFileAddon5" accept=".pdf">
                                        <label class="input-group-text" for="financieros" id="financierosLabel"><i class="fas fa-check-circle"></i></label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="autorizacion" class="form-label subir">Autorización para el tratamiento de datos</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control custom-file-input" id="autorizacion" name="autorizacion" aria-describedby="inputGroupFileAddon6" accept=".pdf">
                                        <label class="input-group-text" for="autorizacion" id="autorizacionLabel"><i class="fas fa-check-circle"></i></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label for="visita" class="form-label subir">Visita</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control custom-file-input" id="visita" name="visita" aria-describedby="inputGroupFileAddon7" accept=".pdf">
                                        <label class="input-group-text" for="visita" id="visitaLabel"><i class="fas fa-check-circle"></i></label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="antecedentes" class="form-label subir">Antecedentes judiciales</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control custom-file-input" id="antecedentes" name="antecedentes" aria-describedby="inputGroupFileAddon8" accept=".pdf">
                                        <label class="input-group-text" for="antecedentes" id="antecedentesLabel"><i class="fas fa-check-circle"></i></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="fecha" class="form-label subir">Fecha de registro</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="fecha" name="fecha" aria-describedby="inputGroupFileAddon8">
                                        <label class="input-group-text" for="fecha" id="fechaLabel"><i class="fas fa-check-circle"></i></label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" onclick="validarFormulario()" class="boton_agregar btn btn-info btn-lg">Agregar</button>
                            <button type="button" onclick="limpiarFormulario()" class="boton_cancelar btn btn-secondary btn-lg">Cancelar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="./js/Agregarcliente.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>
</html>
