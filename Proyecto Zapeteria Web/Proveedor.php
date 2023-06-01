<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pagina de Proveedor</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="Style.css">
</head>
<body>
  <?php
    include('conexion.php');

     // Función para obtener todas los Proveedor  de la base de datos
     function obtenerProveedor() {
      global $conexion;
      $query = "SELECT * FROM Proveedor";
      $result = mysqli_query($conexion, $query);
      return $result;
    }

    // Función para insertar un Proveedor en la base de datos
    function insertarProveedor($nombre, $telefono, $correoElectronico, $numeroCuentaBanco) {
      global $conexion;
      $color = mysqli_real_escape_string($conexion, $color);
      $query = "INSERT INTO Proveedor(color, nombre, telefono, correoElectronico,numeroCuentaBanco ) VALUES ('$nombre', '$telefono', '$correoElectronico', '$numeroCuentaBanco')";
      mysqli_query($conexion, $query);
    }

    // Función para actualizar un Proveedor en la base de datos
    function actualizarProveedor($idProveedor, $nombre, $telefono, $correoElectronico, $numeroCuentaBanco ) {
      global $conexion;
      $nombre = mysqli_real_escape_string($conexion, $nombre);
      $telefono = mysqli_real_escape_string($conexion, $telefono);
      $coreoElectronico = mysqli_real_escape_string($conexion, $correoElectronico);
      $numeroCuentaBanco = mysqli_real_escape_string($conexion, $numeroCuentaBanco);
     
      // Actualizar el Proveedor
      $queryUpdate = "UPDATE Proveedor SET nombre = '$nombre', telefono = '$telefono', correoElectronico = '$correoElectronico', numeroCuentaBanco = '$numeroCuentaBanco' WHERE idProveedor = '$idProveedor";

      if (mysqli_query($conexion, $queryUpdate)) {
          echo "Proveedor actualizado correctamente";
      } else {
          echo "Error al actualizar el Proveedor: " . mysqli_error($conexion);
      }
    }

    // Función para eliminar un Proveedor de la base de datos
    function eliminarProveedor($idProveedor) {
      global $conexion;
      $id = mysqli_real_escape_string($conexion, $idProveedor);
      $query = "DELETE FROM Proveedor WHERE idProveedor = $idProveedor";
      mysqli_query($conexion, $query);
    }

    // Procesar el formulario de agregar o actualizar Proveedor
    if (isset($_POST['submit'])) {
      $nombre = $_POST['nombre'];
      $telefono = $_POST['telefono'];
      $correoElectronico = $_POST['correoElectronico'];
      $numeroCuentaBanco = $_POST['numeroCuentaBanco'];

      if ($_POST['submit'] == 'Agregar') {
        insertarProveedor($nombre, $telefono, $correoElectronico, $numeroCuentaBanco);
      } elseif ($_POST['submit'] == 'Actualizar') {
        $id = $_POST['idProveedor'];
        actualizarProducto($id, $color, $talla, $correoElectronico, $numeroCuentaBanco);
      }
    }

    // Procesar la eliminación de un Proveedor
    if (isset($_GET['delete'])) {
      $id = $_GET['delete'];
      eliminarProveedor($id);
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
        <!-- Formulario para agregar o actualizar Proveedor -->
        <h2><?php echo isset($_GET['edit']) ? 'Actualizar V' : 'Agregar Producto'; ?></h2>
        <form method="POST">
          <?php if (isset($_GET['edit'])): ?>
            <?php
              $id = $_GET['edit'];
              $query = "SELECT * FROM Proveedor WHERE idProveedor = $id";
              $result = mysqli_query($conexion, $query);
              $Proveedor = mysqli_fetch_assoc($result);
            ?>
            <input type="hidden" name="idProveedor" value="<?php echo $Proveedor['idProveedor']; ?>">
          <?php endif; ?>
          <div class="mb-3">
            <label for="nombre">nombre</label>
            <input type="text" class="form-control" id=" nombre" name="nombre" value="<?php echo isset($Proveedor) ? $Proveedor['nombre'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="telefono">telefono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo isset($Proveedor) ? $Proveedor['telefono'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="correoElectronico">correoElectronico</label>
            <input type="text" class="form-control" id="correoElectronico" name="correoElectronico" value="<?php echo isset($Proveedor) ? $Proveedor['correoElectronico'] : ''; ?>">
          </div>
          <div class="mb-3">
          <label for="numeroCuentaBanco">numeroCuentaBanco</label>
            <input type="text" class="form-control" id="numeroCuentaBanco" name="numeroCuentaBanco" value="<?php echo isset($Proveedor) ? $Proveedor['numeroCuentaBanco'] : ''; ?>">
          </div>
          <button type="submit" class="btn btn-primary" name="submit" value="<?php echo isset($_GET['edit']) ? 'Actualizar' : 'Agregar'; ?>">
            <?php echo isset($_GET['edit']) ? 'Actualizar' : 'Agregar'; ?>
          </button>
        </form>
      </div>

      <div class="col-md-6 d-flex justify-content-end">
        <a href="Proveedor.php" class="btn btn-success btn-sm btn-Agregar-btn">Agregar Proveedor</a>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-md-12">
        <h2>Lista de Proveedor</h2>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>nombre</th>
              <th>telefono </th>
              <th>correoElectronico </th>
              <th>numeroCuentaBanco</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $Proveedor = obtenerProveedor();
              while ($row = mysqli_fetch_assoc($Proveedor)):
            ?>
            <tr>
              <td><?php echo $row['nombre']; ?></td>
              <td><?php echo $row['telefono']; ?></td>
              <td><?php echo $row['correoElectronico']; ?></td>
              <td><?php echo $row['numeroCuentaBanco']; ?></td>
            
              <td>
                <a href="Proveedor.php?edit=<?php echo $row['idProveedor']; ?>" class="btn btn-primary">Editar</a>
                <a href="Proveedor.php?delete=<?php echo $row['idProveedor']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este Proveedor?')">Eliminar</a>
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