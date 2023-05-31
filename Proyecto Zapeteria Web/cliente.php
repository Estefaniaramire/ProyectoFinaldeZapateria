<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pagina de Clientes</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="Style.css">
</head>
<body>
  <?php
    include('conexion.php');

     // Función para obtener todas los clientes  de la base de datos
     function obtenerCliente() {
      global $conexion;
      $query = "SELECT * FROM cliente";
      $result = mysqli_query($conexion, $query);
      return $result;
    }

    // Función para insertar un CLIENTE en la base de datos
    function insertarCliente($nombre, $apellidoPaterno, $apellidoMaterno, $direccion, $telefono, $correoElectronico ) {
      global $conexion;
      $nombre = mysqli_real_escape_string($conexion, $nombre);
      $query = "INSERT INTO cliente(nombre, apellidoPaterno, apellidoMaterno, direccion, telefono, correoElectronico) VALUES ('$nombre', '$apellidoPaterno', '$apellidoMaterno', '$direccion', '$telefono', '$correoElectronico')";
      mysqli_query($conexion, $query);
    }

    // Función para actualizar un cliente en la base de datos
    function actualizarCliente($idCliente, $nombre, $apellidoPaterno, $apellidoMaterno, $direccion, $telefono,  $correoElectronico  ) {
      global $conexion;
      $nombre = mysqli_real_escape_string($conexion, $nombre);
      $apellidoPaterno = mysqli_real_escape_string($conexion, $apellidoPaterno);
      $apellidoMaterno = mysqli_real_escape_string($conexion, $apellidoMaterno);
      $direccion = mysqli_real_escape_string($conexion, $direccion);
      $telefono = mysqli_real_escape_string($conexion, $telefono);
      $correoElectronico = mysqli_real_escape_string($conexion, $correoElectronico);
      // Actualizar el cliente
      $queryUpdate = "UPDATE cliente SET nombre = '$nombre', apellidoPaterno = '$apellidoPaterno', apellidoMaterno = '$apellidoMaterno', direccion = '$direccion', telefono = '$telefono' , correoElectronico = '$correoElectronico' WHERE idCliente = '$idCliente'";

      if (mysqli_query($conexion, $queryUpdate)) {
          echo "cliente actualizado correctamente";
      } else {
          echo "Error al actualizar el cliente: " . mysqli_error($conexion);
      }
    }

    // Función para eliminar un cliente de la base de datos
    function eliminarCliente($idCliente) {
      global $conexion;
      $id = mysqli_real_escape_string($conexion, $idCliente);
      $query = "DELETE FROM cliente WHERE idCliente = $idCliente";
      mysqli_query($conexion, $query);
    }

    // Procesar el formulario de agregar o actualizar cliente
    if (isset($_POST['submit'])) {
      $nombre = $_POST['nombre'];
      $apellidoPaterno = $_POST['apellidoPaterno'];
      $apellidoMaterno = $_POST['apellidoMaterno'];
      $direccion = $_POST['direccion'];
      $telefono = $_POST['telefono'];
      $correoElectronico = $_POST['correoElectronico'];

      if ($_POST['submit'] == 'Agregar') {
        insertarCliente($nombre, $apellidoPaterno, $apellidoMaterno, $direccion, $telefono , $correoElectronico);
      } elseif ($_POST['submit'] == 'Actualizar') {
        $id = $_POST['idCliente'];
        actualizarCliente($id, $nombre, $apellidoPaterno, $apellidoMaterno, $direccion, $telefono , $correoElectronico);
      }
    }

    // Procesar la eliminación de un cliente
    if (isset($_GET['delete'])) {
      $id = $_GET['delete'];
      eliminarCliente($id);
    }
  ?>

  <div class="container-fluid">
    <div class="row mt-5">
      <div class="col-md-6 d-flex justify-content-start">
        <a href="pagina.php" class="btn btn-success btn-sm btn-Pestañas">Menu de Pagina</a>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-md-6">
        <!-- Formulario para agregar o actualizar cliente -->
        <h2><?php echo isset($_GET['edit']) ? 'Actualizar cliente' : 'Agregar cliente'; ?></h2>
        <form method="POST">
          <?php if (isset($_GET['edit'])): ?>
            <?php
              $id = $_GET['edit'];
              $query = "SELECT * FROM cliente WHERE idCliente = $id";
              $result = mysqli_query($conexion, $query);
              $cliente = mysqli_fetch_assoc($result);
            ?>
            <input type="hidden" name="idCliente" value="<?php echo $cliente['idCliente']; ?>">
          <?php endif; ?>
          <div class="mb-3">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo isset($cliente) ? $cliente['nombre'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="apellidoPaterno">apellidoPaterno</label>
            <input type="text" class="form-control" id="apellidoPaterno" name="apellidoPaterno" value="<?php echo isset($apellidoPaterno) ? $apellidoPaterno['apellidoPaterno'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="apellidoMaterno">apellidoMaterno</label>
            <input type="text" class="form-control" id="apellidoMaterno" name="apellidoMaterno" value="<?php echo isset($apellidoMaterno) ? $apellidoMaterno['area'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="direccion">direccion</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo isset($direccion) ? $direccion['direccion'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="telefono">telefono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo isset($telefono) ? $telefono['telefono'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="correoElectronico">correoElectronico</label>
            <input type="text" class="form-control" id="correoElectronico" name="correoElectronico" value="<?php echo isset($correoElectronico) ? $correoElectronico['correoElectronico'] : ''; ?>">
          </div>
          <button type="submit" class="btn btn-primary" name="submit" value="<?php echo isset($_GET['edit']) ? 'Actualizar' : 'Agregar'; ?>">
            <?php echo isset($_GET['edit']) ? 'Actualizar' : 'Agregar'; ?>
          </button>
        </form>
      </div>

      <div class="col-md-6 d-flex justify-content-end">
        <a href="cliente.php" class="btn btn-success btn-sm btn-Agregar-btn">Agregar cliente</a>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-md-12">
        <h2>Lista de cliente</h2>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>apellido Paterno</th>
              <th>apellido Materno</th>
              <th>direccion</th>
              <th>telefono</th>
              <th>correoElectronico</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $cliente = obtenerCliente();
              while ($row = mysqli_fetch_assoc($cliente)):
            ?>
            <tr>
              <td><?php echo $row['nombre']; ?></td>
              <td><?php echo $row['apellidoPaterno']; ?></td>
              <td><?php echo $row['apellidoMaterno']; ?></td>
              <td><?php echo $row['direccion']; ?></td>
              <td><?php echo $row['telefono']; ?></td>
              <td><?php echo $row['correoElectronico']; ?></td>
              <td>
                <a href="cliente.php?edit=<?php echo $row['idCliente']; ?>" class="btn btn-primary">Editar</a>
                <a href="cliente.php?delete=<?php echo $row['idCliente']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este cliente?')">Eliminar</a>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>