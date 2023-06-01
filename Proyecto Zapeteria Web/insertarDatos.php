<?php
// Comprueba si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtén los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contrasena = $_POST['clave'];

    // Realiza la conexión a la base de datos
    $host = 'localhost';
    $usuario = 'root';
    $contrasena_db = '';
    $nombre_db = 'zapateria';

    $conexion = mysqli_connect($host, $usuario, $contrasena_db, $nombre_db);

    // Verifica si la conexión se ha establecido correctamente
    if (!$conexion) {
        die('Error al conectar a la base de datos: ' . mysqli_connect_error());
    }

    // Prepara la consulta SQL para insertar los datos en la tabla correspondiente
    $sql = "INSERT INTO usuario (nombre, email, clave) VALUES ('$nombre', '$email', '$contrasena')";

    // Ejecuta la consulta
    if (mysqli_query($conexion, $sql)) {
        // Redirige al usuario a index.php
        header("Location: index.php");
        exit;
    } else {
        echo "Error al insertar los datos: " . mysqli_error($conexion);
    }

    // Cierra la conexión a la base de datos
    mysqli_close($conexion);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar datos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>

<section class="h-100 gradient-form" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="text-center">
                  <h4 class="mt-1 mb-5 pb-1">Insertar datos</h4>
                </div>

                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                  <div class="form-outline mb-4">
                    <label class="form-label" for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required />
                  </div>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="email">Correo electrónico</label>
                    <input type="email" name="email" id="email" class="form-control" required />
                  </div>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="clave">Contraseña</label>
                    <input type="password" name="clave" id="clave" class="form-control" required />
                  </div>

                  <div class="text-center pt-1 mb-5 pb-1">
                    <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Guardar</button>
                  </div>

                </form>

              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center">
              <img src="https://thumbs.dreamstime.com/b/logotipo-para-una-zapater%C3%ADa-o-un-taller-en-estilo-del-vintage-113807464.jpg" alt="Descripción de la imagen" alt="Descripción de la imagen" style="width: 120%; max-height: 560px">
            </div>                      
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<div class="row mt-3">
  <div class="col-md-12">
    <a href="Excel.php" class="btn btn-primary">Excel</a>
  </div>
  <div class="row mt-3">
  <div class="col-md-13">
  <a href="Jason.php" class="btn btn-primary">Jason</a>
</div>
<div class="row mt-4">
  <div class="col-md-15">
  <a href="PDF.php" class="btn btn-primary">PDF</a>
</div>
<div class="row mt-5">
  <div class="col-md-18">
  <a href="XML.php" class="btn btn-primary">XML</a>
</div>

</body>
</html>
