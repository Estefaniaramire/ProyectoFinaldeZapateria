<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recuperar Contraseña</title>
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
                  <img src="imagenes/logo.png" style="width: 185px;" alt="logo">
                  <h4 class="mt-1 mb-5 pb-1">Recuperar Contraseña</h4>
                </div>

                <?php
                  if (isset($_POST["email"])) {
                    $email = $_POST["email"];

                    if (empty($email)) {
                      // Mostrar mensaje de error si el campo de correo electrónico está vacío
                      echo '<p class="text-center text-danger">El campo de correo electrónico es obligatorio.</p>';
                    } else {
                      // Realizar la consulta a la base de datos para verificar si el correo electrónico existe
                      // Aquí debes reemplazar 'host', 'usuario', 'contraseña' y 'basedatos' con los valores de tu configuración de base de datos
                      $conn = new mysqli('localhost', 'root', '', 'LaboratorioClinico');
                      
                      // Verificar si hay errores en la conexión
                      if ($conn->connect_error) {
                        die("Error de conexión: " . $conn->connect_error);
                      }

                      // Consulta para verificar si el correo electrónico existe en la base de datos
                      $query = "SELECT * FROM usuario WHERE correoElectronico = '$email'";
                      $result = $conn->query($query);

                      // Verificar si se encontró algún registro con el correo electrónico especificado
                      if ($result->num_rows > 0) {
                        // Mostrar el formulario para elegir una nueva contraseña
                        echo '
                          <form method="POST" action="cambiarCon.php">
                            <input type="hidden" name="email" value="' . $email . '">
                            <div class="form-outline mb-4">
                              <label class="form-label" for="form2Example22">Nueva Contraseña</label>
                              <input type="password" name="newPassword" id="form2Example22" class="form-control" required />
                            </div>

                            <div class="form-outline mb-4">
                              <label class="form-label" for="form2Example23">Confirmar Contraseña</label>
                              <input type="password" name="confirmPassword" id="form2Example23" class="form-control" required />
                            </div>

                            <div class="text-center pt-1 mb-5 pb-1">
                              <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Guardar Contraseña</button>
                              <a class="text-muted" href="index.php">Volver al inicio de sesión</a>
                            </div>
                          </form>
                        ';
                      } else {
                        // Mostrar mensaje de error si el correo electrónico no existe en la base de datos
                        echo '<p class="text-center text-danger">El correo electrónico no está registrado en nuestro sistema.</p>';
                        echo '<div class="text-center pt-1 mb-5 pb-1">
                          <a class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" href="recuperarCon.php">Volver a intentar</a>
                          <a class="text-muted" href="index.php">Volver al inicio de sesión</a>
                        </div>';
                      }

                      // Cerrar la conexión a la base de datos
                      $conn->close();
                    }
                  } else {
                    // Mostrar el formulario inicial para ingresar el correo electrónico
                    echo '
                      <form method="POST" action="recuperarCon.php">
                        <div class="form-outline mb-4">
                          <label class="form-label" for="form2Example11">Correo electrónico</label>
                          <input type="email" name="email" id="form2Example11" class="form-control" placeholder="" required />
                        </div>

                        <div class="text-center pt-1 mb-5 pb-1">
                          <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Recuperar Contraseña</button>
                          <a class="text-muted" href="index.php">Volver al inicio de sesión</a>
                        </div>
                      </form>
                    ';
                  }
                ?>

              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center">
              <img src="imagenes/Portada.png" alt="Descripción de la imagen" style="width: 100%; max-height: 750px">
            </div>                      
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>