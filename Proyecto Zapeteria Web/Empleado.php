<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página con pestaña de Empleado</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="Style.css">
</head>
<body>
  <?php
    include('conexion.php');

     // Función para obtener Empleado de la base de datos
     function obtenerEmpleado() {
      global $conexion;
      $query = "SELECT * FROM Empleado";
      $result = mysqli_query($conexion, $query);
      return $result;
    }

    // Función para insertar un Empleado en la base de datos
    function insertarEmpleado($nombre, $apellidoPaterno, $apellidoMaterno, $direccion , $salario ) {
      global $conexion;
      $nombre = mysqli_real_escape_string($conexion, $nombre);
      $query = "INSERT INTO Empleado (nombre, apellidoPaterno, apellidoMaterno, direccion, salario) VALUES ('$nombre', '$apellidoPaterno', '$apellidoMaterno', '$direccion', '$salario')";
      mysqli_query($conexion, $query);
    }

    // Función para actualizar un Empleado en la base de datos
    function actualizarEmpleado($idEmpleado, $nombre, $apellidoPaterno, $apellidoMaterno, $direccion, $salario) {
      global $conexion;
      $nombre = mysqli_real_escape_string($conexion, $nombre);
      $apellidoPaterno = mysqli_real_escape_string($conexion, $apellidoPaterno);
      $apellidoMaterno = mysqli_real_escape_string($conexion, $apellidoMaterno);
      $direccion = mysqli_real_escape_string($conexion, $direccion);
      $salario = mysqli_real_escape_string($conexion, $salario);

      // Actualizar el Empleado
      $queryUpdate = "UPDATE Empleado SET nombre = '$nombre', apellidoPaterno = '$apellidoPaterno', apellidoMaterno = '$apellidoMaterno', direccion = '$direccion' , salario = '$salario' WHERE idEmpleado = '$idEmpleado'";

      if (mysqli_query($conexion, $queryUpdate)) {
          echo "Empleado actualizado correctamente";
      } else {
          echo "Error al actualizar: " . mysqli_error($conexion);
      }
    }

    // Función para eliminar un Empleado de la base de datos
    function eliminarEmpleado($idEmpleado) {
      global $conexion;
      $id = mysqli_real_escape_string($conexion, $idEmpleado);
      $query = "DELETE FROM Empleado WHERE idEmpleado = $idEmpleado";
      mysqli_query($conexion, $query);
    }

    // Procesar el formulario de agregar o actualizar Empleado
    if (isset($_POST['submit'])) {
      $nombre = $_POST['nombre'];
      $apellidoPaterno = $_POST['apellidoPaterno'];
      $apellidoMaterno = $_POST['apellidoMaterno'];
      $direccion = $_POST['direccion'];
      $salario = $_POST['salario'];

      if ($_POST['submit'] == 'Agregar') {
        insertarEmpleado($nombre, $apellidoPaterno, $apellidoMaterno, $direccion , $salario);
      } elseif ($_POST['submit'] == 'Actualizar') {
        $id = $_POST['idEmpleado'];
        actualizarEmpleado($id, $nombre, $apellidoPaterno, $apellidoMaterno, $direccion, $salario);
    
      }
    }

    // Procesar la eliminación de un Empleado
    if (isset($_GET['delete'])) {
      $id = $_GET['delete'];
      eliminarEmpleado($id);
    }
  ?>

  <div class="container-fluid">
    <div class="row mt-5">
      <div class="col-md-6 d-flex justify-content-start">
        <a href="pagina.php" class="btn btn-success btn-sm btn-Pestañas">Pestañas</a>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-md-6">
        <!-- Formulario para agregar o actualizar Empleado -->
        <h2><?php echo isset($_GET['edit']) ? 'Actualizar Empleado' : 'Agregar Empleado'; ?></h2>
        <form method="POST">
          <?php if (isset($_GET['edit'])): ?>
            <?php
              $id = $_GET['edit'];
              $query = "SELECT * FROM Empleado WHERE idEmpleado = $id";
              $result = mysqli_query($conexion, $query);
              $Empleado = mysqli_fetch_assoc($result);
            ?>
            <input type="hidden" name="idEmpleado" value="<?php echo $Empleado['idEmpleado']; ?>">
          <?php endif; ?>
          <div class="mb-3">
            <label for="nombre">nombre </label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo isset($Empleado) ? $Empleado['nombre'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="apellidoPaterno">apellido Paterno </label>
            <input type="text" class="form-control" id="apellidoPaterno" name="apellidoPaterno" value="<?php echo isset($Empleado) ? $Empleado['apellidoPaterno'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="apellidoMaterno">apellidoMaterno</label>
            <input type="text" class="form-control" id="apellidoMaterno" name="apellidoMaterno" value="<?php echo isset($Empleado) ? $Empleado['apellidoMaterno'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="direccion">direccion</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo isset($Empleado) ? $Empleado['direccion'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="salario">salario</label>
            <input type="text" class="form-control" id="salario" name="salario" value="<?php echo isset($Empleado) ? $Empleado['salario'] : ''; ?>">
          </div>
          <button type="submit" class="btn btn-primary" name="submit" value="<?php echo isset($_GET['edit']) ? 'Actualizar' : 'Agregar'; ?>">
            <?php echo isset($_GET['edit']) ? 'Actualizar' : 'Agregar'; ?>
          </button>
        </form>
      </div>

      <div class="col-md-6 d-flex justify-content-end">
        <a href="Empleado.php" class="btn btn-success btn-sm btn-Agregar-btn">Agregar obtenerEmpleado</a>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-md-12">
        <h2>Lista de Empleado</h2>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>nombre</th>
              <th>apellidoPaterno</th>
              <th>apellidoMaterno</th>
              <th>direccion</th>
              <th>salario</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $Empleado = obtenerEmpleado();
              while ($row = mysqli_fetch_assoc($Empleado)):
            ?>
            <tr>
              <td><?php echo $row['nombre ']; ?></td>
              <td><?php echo $row['apellidoPaterno']; ?></td>
              <td><?php echo $row['apellidoMaterno']; ?></td>
              <td><?php echo $row['direcion']; ?></td>
              <td><?php echo $row['salario']; ?></td>
              <td>
                <a href="Empleado.php?edit=<?php echo $row['idEmpleado']; ?>" class="btn btn-primary">Editar</a>
                <a href="Empleado.php?delete=<?php echo $row['idEmpleado']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este Empleado  ?')">Eliminar</a>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

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