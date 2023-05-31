<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página con pestaña de Compra</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="Style.css">
</head>
<body>
  <?php
    include('conexion.php');

     // Función para obtener toda la Compra de la base de datos
     function obtenerCompra() {
      global $conexion;
      $query = "SELECT * FROM Compra";
      $result = mysqli_query($conexion, $query);
      return $result;
    }

    // Función para insertar una Compra en la base de datos
    function insertarCompra($totalCompra, $fechaCompra, $metodoPago, $descuento) {
      global $conexion;
      $totalCompra = mysqli_real_escape_string($conexion, $totalCompra);
      $query = "INSERT INTO Compra (totalCompra, fechaCompra, metodoPago, descuento) VALUES ('$totalCompra', '$fechaCompra', '$metodoPago', '$descuento')";
      mysqli_query($conexion, $query);
    }

    // Función para actualizar una Compra en la base de datos
    function actualizarCompra($idCompra, $totalCompra, $fechaCompra, $metodoPago, $descuento) {
      global $conexion;
      $totalCompra = mysqli_real_escape_string($conexion, $totalCompra);
      $fechaCompra = mysqli_real_escape_string($conexion, $fechaCompra);
      $metodoPago = mysqli_real_escape_string($conexion, $metodoPago);
      $descuento = mysqli_real_escape_string($conexion, $descuento);
     

      // Actualizar la Compra
      $queryUpdate = "UPDATE Compra SET totalCompra = '$totalCompra', fechaCompra = '$fechaCompra', metodoPago = '$metodoPago', descuento = '$descuento' WHERE idCompra = '$idCompra'";

      if (mysqli_query($conexion, $queryUpdate)) {
          echo "Compra actualizada correctamente";
      } else {
          echo "Error al actualizar: " . mysqli_error($conexion);
      }
    }

    // Función para eliminar una Compra de la base de datos
    function eliminarCompra($idCompra) {
      global $conexion;
      $id = mysqli_real_escape_string($conexion, $idCompra);
      $query = "DELETE FROM Compra WHERE idCompra = $idCompra";
      mysqli_query($conexion, $query);
    }

    // Procesar el formulario de agregar o actualizar Compra
    if (isset($_POST['submit'])) {
      $totalCompra = $_POST['totalCompra'];
      $fechaCompra = $_POST['fechaCompra'];
      $metodoPago = $_POST['metodoPago'];
      $descuento = $_POST['descuento'];
     

      if ($_POST['submit'] == 'Agregar') {
        insertarCompra($totalCompra, $fechaCompra, $metodoPago, $descuento);
      } elseif ($_POST['submit'] == 'Actualizar') {
        $id = $_POST['idCompra'];
        actualizarCompra($id, $totalCompra, $fechaCompra, $metodoPago, $descuento);
      }
    }

    // Procesar la eliminación de una Compra
    if (isset($_GET['delete'])) {
      $id = $_GET['delete'];
      eliminarCompra($id);
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
        <!-- Formulario para agregar o actualizar Compra -->
        <h2><?php echo isset($_GET['edit']) ? 'Actualizar Compra' : 'Agregar Compra'; ?></h2>
        <form method="POST">
          <?php if (isset($_GET['edit'])): ?>
            <?php
              $id = $_GET['edit'];
              $query = "SELECT * FROM Compra WHERE idCompra = $id";
              $result = mysqli_query($conexion, $query);
              $Compra = mysqli_fetch_assoc($result);
            ?>
            <input type="hidden" name="idCompra" value="<?php echo $Categoria['idCompra']; ?>">
          <?php endif; ?>
          <div class="mb-3">
            <label for="totalCompra">total Compra </label>
            <input type="text" class="form-control" id="totalCompra" name="totalCompra" value="<?php echo isset($Compra) ? $Compra['totalCompra'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="fechaCompra">fecha Compra </label>
            <input type="text" class="form-control" id="fechaCompra" name="fechaCompra" value="<?php echo isset($Compra) ? $Compra['fechaCompra'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="metodoPago">metodoPago</label>
            <input type="text" class="form-control" id="metodoPago" name="metodoPago" value="<?php echo isset($Compra) ? $Compra['metodoPago'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="descuento">descuento</label>
            <input type="text" class="form-control" id="descuento" name="descuento" value="<?php echo isset($Compra) ? $Compra['descuento'] : ''; ?>">
          </div>
          <button type="submit" class="btn btn-primary" name="submit" value="<?php echo isset($_GET['edit']) ? 'Actualizar' : 'Agregar'; ?>">
            <?php echo isset($_GET['edit']) ? 'Actualizar' : 'Agregar'; ?>
          </button>
        </form>
      </div>

      <div class="col-md-6 d-flex justify-content-end">
        <a href="Compra.php" class="btn btn-success btn-sm btn-Agregar-btn">Agregar Categoria</a>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-md-12">
        <h2>Lista de Compra</h2>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>totalCompra</th>
              <th>fechaCompra</th>
              <th>metodoPago</th>
              <th>descuento</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $Compra = obtenerCompra();
              while ($row = mysqli_fetch_assoc($Compra)):
            ?>
            <tr>
              <td><?php echo $row['totalCompra']; ?></td>
              <td><?php echo $row['fechaCompra']; ?></td>
              <td><?php echo $row['metodoPago']; ?></td>
              <td><?php echo $row['descuento']; ?></td>
              <td>
                <a href="Compra.php?edit=<?php echo $row['idCompra']; ?>" class="btn btn-primary">Editar</a>
                <a href="Compra.php?delete=<?php echo $row['idCompra']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta Compra  ?')">Eliminar</a>
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