<?php
require_once 'conexion.php';
// Verificar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario y limpiarlos
    $nombre = limpiarEntrada($_POST["nombre"]);
    $apellido = limpiarEntrada($_POST["apellido"]);
    $email = limpiarEntrada($_POST["email<?php
session_start();

if (isset($_POST["email"]) && isset($_POST["clave"])) {
  $email = $_POST["email"];
  $password = $_POST["clave"];

  // Realizar la conexión a la base de datos
  $conn = new mysqli('localhost', 'root', '', 'zapateria');

  // Verificar si hay errores en la conexión
  if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
  }

  // Consultar la base de datos para verificar las credenciales
  $query = "SELECT * FROM usuario WHERE email = '$email'";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $storedEmail = $row["email"];
    $storedPassword = $row["clave"];

    // Verificar el correo electrónico y la contraseña
    if ($email === $storedEmail && $password === $storedPassword) {
      // Las credenciales son válidas, crear una sesión y redirigir al usuario a menu.php
      $_SESSION["email"] = $email;
      header("Location: menu.html");
      exit;
    } else {
      echo '<p class="text-center text-danger">Correo electrónico o contraseña incorrectos.</p>';
    }
  } else {
    echo '<p class="text-center text-danger">Correo electrónico o contraseña incorrectos.</p>';
  }

  // Cerrar la conexión a la base de datos
  $conn->close();
}
?>
"]);
    $clave = limpiarEntrada($_POST["clave"]);

    // Validar los datos (puedes agregar más validaciones según tus necesidades)
    if (empty($nombre) || empty($apellido) || empty($email) || empty($clave) ) {
        mostrarError("Todos los campos son obligatorios.");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        mostrarError("Correo electrónico no válido.");
    } else {

        // Verificar si el correo electrónico ya existe en la base de datos
        $consulta = "SELECT correoElectronico FROM usuario WHERE correoElectronico = ?";
        $stmt = $conexion->prepare($consulta);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            mostrarError("El correo electrónico ya está registrado.");
        } else {
            // Crear la consulta SQL para insertar los datos en la tabla usando una consulta preparada
            $sql = "INSERT INTO usuario (nombre, aPaterno, aMaterno, correoElectronico, clave) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);

            $hashedClave = password_hash($clave, PASSWORD_DEFAULT);

            // Pasar las variables por referencia en bind_param
            $stmt->bind_param("sssss", $nombre, $apellido, $email, $hashedClave);

            if ($stmt->execute()) {
                header("Location: index.php"); // Redirigir al usuario a index.php
                exit(); // Finalizar el script después de la redirección
            } else {
                mostrarError("Error al insertar los datos: " . $stmt->error);
            }
        }

        // Cerrar la conexión a la base de datos
        $stmt->close();
        $conexion->close();
    }
}

// Función para limpiar los datos ingresados
function limpiarEntrada($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Función para mostrar un mensaje de error
function mostrarError($mensaje)
{
    echo "<div class='alert alert-danger'>$mensaje</div>";
}

// Función para mostrar un mensaje de éxito
function mostrarExito($mensaje)
{
    echo "<div class='alert alert-success'>$mensaje</div>";
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
                                        <h4 class="mt-1 mb-5 pb-1">Ingresar datos</h4>
                                    </div>
                                    <form method="POST" action="">
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example11">Nombre(s)</label>
                                            <input type="text" name="nombre" id="form2Example11" class="form-control" placeholder="" required />
                                        </div>
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example11">Primer apellido</label>
                                            <input type="text" name="aPaterno" id="form2Example11" class="form-control" placeholder="" required />
                                        </div>
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example11">Segundo apellido</label>
                                            <input type="text" name="aMaterno" id="form2Example11" class="form-control" placeholder="" required />
                                        </div>
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example11">correo electrónico</label>
                                            <input type="email" name="correo" id="form2Example11" class="form-control" placeholder="" required />
                                        </div>
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example11">Contraseña</label>
                                            <input type="password" name="clave" id="form2Example11" class="form-control" placeholder="" required />
                                        </div>
                                        <div class="text-center pt-1 mb-5 pb-1">
                                            <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Registrarse</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6">
                            <img src="imagenes/Portada.png" alt="Descripción de la imagen" style="width: 100%; max-height: 770px">
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