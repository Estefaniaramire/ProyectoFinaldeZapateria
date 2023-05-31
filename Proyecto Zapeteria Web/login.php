<?php
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
      // Las credenciales son válidas, crear una sesión y redirigir al usuario a Menu.html
      $_SESSION["email"] = $email;
      header("Location: Menu.html");
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
