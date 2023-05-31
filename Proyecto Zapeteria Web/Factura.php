<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página con pestaña de Factura</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="Style.css">
</head>
<body>
  <?php
    include('conexion.php');

     // Función para obtener todas las Factura de la base de datos
     function obtenerFactura() {
      global $conexion;
      $query = "SELECT * FROM Factura";
      $result = mysqli_query($conexion, $query);
      return $result;
    }

    // Función para insertar una Factura en la base de datos
    function insertarFactura($nombreFactura, $fechaFactura, $numeroFactura) {
      global $conexion;
      $nombreFactura = mysqli_real_escape_string($conexion, $nombreFactura);
      $query = "INSERT INTO Factura (nombreFactura, fechaFactura, numeroFactura) VALUES ('$nombreFactura', '$fechaFactura', '$numeroFactura')";
      mysqli_query($conexion, $query);
    }

    // Función para actualizar una Factura en la base de datos
    function actualizarFactura($idFactura, $nombreFactura, $fechaFactura, $numeroFactura) {
      global $conexion;
      $nombreFactura = mysqli_real_escape_string($conexion, $nombreFactura);
      $fechaFactura = mysqli_real_escape_string($conexion, $fechaFactura);
      $numeroFactura = mysqli_real_escape_string($conexion, $numeroFactura);
      
     

      // Actualizar la Factura
      $queryUpdate = "UPDATE Factura SET nombreFactura = '$nombreFactura', fechaFactura = '$fechaFactura', numeroFactura = '$numeroFactura' WHERE idFactura = '$idFactura'";

      if (mysqli_query($conexion, $queryUpdate)) {
          echo "Factura actualizada correctamente";
      } else {
          echo "Error al actualizar: " . mysqli_error($conexion);
      }
    }

    // Función para eliminar una Factura de la base de datos
    function eliminarFactura($idFactura) {
      global $conexion;
      $id = mysqli_real_escape_string($conexion, $idFactura);
      $query = "DELETE FROM Factura WHERE idFactura = $idFactura";
      mysqli_query($conexion, $query);
    }

    // Procesar el formulario de agregar o actualizar Factura
    if (isset($_POST['submit'])) {
      $nombreFactura = $_POST['nombreFactura'];
      $fechaFactura = $_POST['fechaFactura'];
      $numeroFactura = $_POST['numeroFactura'];
    
     

      if ($_POST['submit'] == 'Agregar') {
        insertarFactura($nombreFactura, $fechaFactura, $numeroFactura);
      } elseif ($_POST['submit'] == 'Actualizar') {
        $id = $_POST['idFactura'];
        actualizarFactura($id, $nombreFactura, $fechaFactura, $numeroFactura);
      }
    }

    // Procesar la eliminación de una Factura
    if (isset($_GET['delete'])) {
      $id = $_GET['delete'];
      eliminarFactura($id);
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
        <!-- Formulario para agregar o actualizar Factura -->
        <h2><?php echo isset($_GET['edit']) ? 'Actualizar Factura' : 'Agregar Factura'; ?></h2>
        <form method="POST">
          <?php if (isset($_GET['edit'])): ?>
            <?php
              $id = $_GET['edit'];
              $query = "SELECT * FROM Factura WHERE idFactura = $id";
              $result = mysqli_query($conexion, $query);
              $Factura = mysqli_fetch_assoc($result);
            ?>
            <input type="hidden" name="idFactura" value="<?php echo $Factura['idFactura']; ?>">
          <?php endif; ?>
          <div class="mb-3">
            <label for="nombreFactura">nombre Factura</label>
            <input type="text" class="form-control" id="nombreFactura" name="nombreFactura" value="<?php echo isset($Factura) ? $Factura['nombreFactura'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="fechaFactura">fecha Factura</label>
            <input type="text" class="form-control" id="fechaFactura" name="fechaFactura" value="<?php echo isset($Factura) ? $Factura['fechaFactura'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="area">numeroFactura</label>
            <input type="text" class="form-control" id="numeroFactura" name="numeroFactura" value="<?php echo isset($Factura) ? $Factura['numeroFactura'] : ''; ?>">
          </div>
          <button type="submit" class="btn btn-primary" name="submit" value="<?php echo isset($_GET['edit']) ? 'Actualizar' : 'Agregar'; ?>">
            <?php echo isset($_GET['edit']) ? 'Actualizar' : 'Agregar'; ?>
          </button>
        </form>
      </div>

      <div class="col-md-6 d-flex justify-content-end">
        <a href="Factura.php" class="btn btn-success btn-sm btn-Agregar-btn">Agregar Factura</a>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-md-12">
        <h2>Lista de Factura</h2>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>nombreFactura</th>
              <th>fechaFactura</th>
              <th>numeroFactura</th>
             
            </tr>
          </thead>
          <tbody>
            <?php
              $Factura = obtenerFactura();
              while ($row = mysqli_fetch_assoc($Factura)):
            ?>
            <tr>
              <td><?php echo $row['nombreFactura']; ?></td>
              <td><?php echo $row['fechaFactura']; ?></td>
              <td><?php echo $row['numeroFactura']; ?></td>
              
              <td>
                <a href="Factura.php?edit=<?php echo $row['idFactura']; ?>" class="btn btn-primary">Editar</a>
                <a href="Factura.php?delete=<?php echo $row['idFactura']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta Factura?')">Eliminar</a>
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