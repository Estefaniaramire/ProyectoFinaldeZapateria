<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pagina de Venta</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="Style.css">
</head>
<body>
  <?php
    include('conexion.php');

     // Función para obtener todas las Venta  de la base de datos
     function obtenerVenta() {
      global $conexion;
      $query = "SELECT * FROM Venta";
      $result = mysqli_query($conexion, $query);
      return $result;
    }

    // Función para insertar un Venta en la base de datos
    function insertarVenta($empleadoVenta, $fechaVenta, $metodoPago, $cantidadTotal ) {
      global $conexion;
      $empleadoVenta = mysqli_real_escape_string($conexion, $empleadoVenta);
      $query = "INSERT INTO Venta(empleadoVenta, fechaVenta, metodoPago, cantidadTotal) VALUES ('$empleadoVenta', '$fechaVenta', '$metodoPago', '$cantidadTotal')";
      mysqli_query($conexion, $query);
    }

    // Función para actualizar un Venta en la base de datos
    function actualizarVenta($idVenta, $empleadoVenta, $fechaVenta, $metodoPago, $cantidadTotal ) {
      global $conexion;
      $empleadoVenta = mysqli_real_escape_string($conexion, $empleadoVenta);
      $fechaVenta = mysqli_real_escape_string($conexion, $fechaVenta);
      $metodoPago = mysqli_real_escape_string($conexion, $metodoPago);
      $cantidadTotal = mysqli_real_escape_string($conexion, $cantidadTotal);
      // Actualizar el Venta
      $queryUpdate = "UPDATE Venta SET empleadoVenta = '$empleadoVenta', fechaVenta = '$fechaVenta', metodoPago = '$metodoPago', cantidadTotal = '$cantidadTotal' WHERE idVenta = '$idVenta'";

      if (mysqli_query($conexion, $queryUpdate)) {
          echo "Venta actualizada correctamente";
      } else {
          echo "Error al actualizar la Venta: " . mysqli_error($conexion);
      }
    }

    // Función para eliminar un Venta de la base de datos
    function eliminarVenta($idVenta) {
      global $conexion;
      $id = mysqli_real_escape_string($conexion, $idVenta);
      $query = "DELETE FROM Venta WHERE idVenta = $idVenta";
      mysqli_query($conexion, $query);
    }

    // Procesar el formulario de agregar o actualizar Venta
    if (isset($_POST['submit'])) {
      $nombreMarca = $_POST['empleadoVenta'];
      $paisOrigen = $_POST['fechaVenta'];
      $distribuidorMarca = $_POST['metodoPago'];
      $representanteMarca = $_POST['cantidadTotal'];

      if ($_POST['submit'] == 'Agregar') {
        insertarVenta($empleadoVenta, $fechaVenta, $metodoPago, $cantidadTotal);
      } elseif ($_POST['submit'] == 'Actualizar') {
        $id = $_POST['idVenta'];
        actualizarVenta($id, $empleadoVenta, $fechaVenta, $metodoPago, $cantidadTotal);
      }
    }

    // Procesar la eliminación de un Venta
    if (isset($_GET['delete'])) {
      $id = $_GET['delete'];
      eliminarVenta($id);
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
        <!-- Formulario para agregar o actualizar Venta -->
        <h2><?php echo isset($_GET['edit']) ? 'Actualizar Venta' : 'Agregar Venta'; ?></h2>
        <form method="POST">
          <?php if (isset($_GET['edit'])): ?>
            <?php
              $id = $_GET['edit'];
              $query = "SELECT * FROM idVenta WHERE idVenta = $id";
              $result = mysqli_query($conexion, $query);
              $Venta = mysqli_fetch_assoc($result);
            ?>
            <input type="hidden" name="idVenta" value="<?php echo $Venta['idVenta']; ?>">
          <?php endif; ?>
          <div class="mb-3">
            <label for="empleadoVenta">empleadoVenta</label>
            <input type="text" class="form-control" id="empleadoVenta" name="empleadoVenta" value="<?php echo isset($Venta) ? $Venta['empleadoVenta'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="fechaVenta">fechaVenta</label>
            <input type="text" class="form-control" id="fechaVenta" name="fechaVenta" value="<?php echo isset($Venta) ? $Venta['fechaVenta'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="metodoPago">metodoPago</label>
            <input type="text" class="form-control" id="metodoPago" name="metodoPago" value="<?php echo isset($Venta) ? $Venta['metodoPago'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="cantidadTotal">cantidadTotal</label>
            <input type="text" class="form-control" id="cantidadTotal" name="cantidadTotal" value="<?php echo isset($Venta) ? $Venta['cantidadTotal'] : ''; ?>">
          </div>
        
          <button type="submit" class="btn btn-primary" name="submit" value="<?php echo isset($_GET['edit']) ? 'Actualizar' : 'Agregar'; ?>">
            <?php echo isset($_GET['edit']) ? 'Actualizar' : 'Agregar'; ?>
          </button>
        </form>
      </div>

      <div class="col-md-6 d-flex justify-content-end">
        <a href="Venta.php" class="btn btn-success btn-sm btn-Agregar-btn">Agregar Venta</a>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-md-12">
        <h2>Lista de Venta</h2>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>empleadoVenta</th>
              <th> fechaVenta</th>
              <th>metodoPago</th>
              <th>cantidadTotal</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $Venta = obtenerVenta();
              while ($row = mysqli_fetch_assoc($Venta)):
            ?>
            <tr>
              <td><?php echo $row['empleadoVenta']; ?></td>
              <td><?php echo $row['fechaVenta']; ?></td>
              <td><?php echo $row['metodoPago']; ?></td>
              <td><?php echo $row['cantidadTotal']; ?></td>
              <td>
                <a href="Venta.php?edit=<?php echo $row['idVenta']; ?>" class="btn btn-primary">Editar</a>
                <a href="Venta.php?delete=<?php echo $row['idVenta']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta Venta?')">Eliminar</a>
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