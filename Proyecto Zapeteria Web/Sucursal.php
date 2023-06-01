<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pagina de Sucursal</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="Style.css">
</head>
<body>
  <?php
    include('conexion.php');

     // Función para obtener todas las Sucursal  de la base de datos
     function obtenerSucursal() {
      global $conexion;
      $query = "SELECT * FROM Sucursal";
      $result = mysqli_query($conexion, $query);
      return $result;
    }

    // Función para insertar un Sucursal en la base de datos
    function insertarSucursal($telefono, $direccion, $horarioAtencion, $gerenteSucursal ) {
      global $conexion;
      $telefono = mysqli_real_escape_string($conexion, $telefono);
      $query = "INSERT INTO Sucursal(telefono, direccion, horarioAtencion, gerenteSucursal) VALUES ('$telefono', '$direccion', '$horarioAtencion', '$gerenteSucursal')";
      mysqli_query($conexion, $query);
    }

    // Función para actualizar un Sucursal en la base de datos
    function actualizarSucursal($idSucursal, $telefono, $direccion, $horarioAtencion, $gerenteSucursal ) {
      global $conexion;
      $telefono = mysqli_real_escape_string($conexion, $telefono);
      $direccion = mysqli_real_escape_string($conexion, $direccion);
      $horarioAtencion = mysqli_real_escape_string($conexion, $horarioAtencion);
      $gerenteSucursal = mysqli_real_escape_string($conexion, $gerenteSucursal);
      // Actualizar el Sucursal
      $queryUpdate = "UPDATE Sucursal SET telefono = '$telefono', direccion = '$direccion', horarioAtencion = '$horarioAtencion', gerenteSucursal = '$gerenteSucursal' WHERE idSucursal = '$idSucursal'";

      if (mysqli_query($conexion, $queryUpdate)) {
          echo "Sucursal actualizada correctamente";
      } else {
          echo "Error al actualizar la Sucursal: " . mysqli_error($conexion);
      }
    }

    // Función para eliminar un Sucursal de la base de datos
    function eliminarMarca($idSucursal) {
      global $conexion;
      $id = mysqli_real_escape_string($conexion, $idSucursal);
      $query = "DELETE FROM Sucursal WHERE idSucursal = $idSucursal";
      mysqli_query($conexion, $query);
    }

    // Procesar el formulario de agregar o actualizar Sucursal
    if (isset($_POST['submit'])) {
      $telefono = $_POST['telefono'];
      $direccion = $_POST['direccion'];
      $horarioAtencion = $_POST['horarioAtencion'];
      $gerenteSucursal = $_POST['gerenteSucursal'];

      if ($_POST['submit'] == 'Agregar') {
        insertarSucursal($telefono, $direccion, $horarioAtencion, $gerenteSucursal);
      } elseif ($_POST['submit'] == 'Actualizar') {
        $id = $_POST['idSucursal'];
        actualizarSucursal($id, $telefono, $direccion, $horarioAtencion, $gerenteSucursal);
      }
    }

    // Procesar la eliminación de una Sucursal
    if (isset($_GET['delete'])) {
      $id = $_GET['delete'];
      eliminarSucursal($id);
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
        <!-- Formulario para agregar o actualizar Sucursal -->
        <h2><?php echo isset($_GET['edit']) ? 'Actualizar Sucursal' : 'Agregar Sucursal'; ?></h2>
        <form method="POST">
          <?php if (isset($_GET['edit'])): ?>
            <?php
              $id = $_GET['edit'];
              $query = "SELECT * FROM Sucursal WHERE idSucursal = $id";
              $result = mysqli_query($conexion, $query);
              $Sucursal = mysqli_fetch_assoc($result);
            ?>
            <input type="hidden" name="idSucursal" value="<?php echo $Sucursal['idSucursal']; ?>">
          <?php endif; ?>
          <div class="mb-3">
            <label for="nombre">telefono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo isset($Sucursal) ? $Sucursal['telefono'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="paisOrigen">direccion</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo isset($Sucursal) ? $Sucursal['direccion'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="horarioAtencion">horarioAtencion</label>
            <input type="text" class="form-control" id="horarioAtencion" name="horarioAtencion" value="<?php echo isset($Sucursal) ? $Sucursal['horarioAtencion'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="gerenteSucursal">gerenteSucursal</label>
            <input type="text" class="form-control" id="gerenteSucursal" name="gerenteSucursal" value="<?php echo isset($Sucursal) ? $Sucursal['gerenteSucursal'] : ''; ?>">
          </div>
        
          <button type="submit" class="btn btn-primary" name="submit" value="<?php echo isset($_GET['edit']) ? 'Actualizar' : 'Agregar'; ?>">
            <?php echo isset($_GET['edit']) ? 'Actualizar' : 'Agregar'; ?>
          </button>
        </form>
      </div>

      <div class="col-md-6 d-flex justify-content-end">
        <a href="Sucursal.php" class="btn btn-success btn-sm btn-Agregar-btn">Agregar Sucursal</a>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-md-12">
        <h2>Lista de Sucursal</h2>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>telefono</th>
              <th> direccion</th>
              <th>horarioAtencion</th>
              <th>gerenteSucursal</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $Sucursal = obtenerSucursal();
              while ($row = mysqli_fetch_assoc($Sucursal)):
            ?>
            <tr>
              <td><?php echo $row['telefono']; ?></td>
              <td><?php echo $row['direccion']; ?></td>
              <td><?php echo $row['horarioAtencion']; ?></td>
              <td><?php echo $row['gerenteSucursal']; ?></td>
              <td>
                <a href="Marca.php?edit=<?php echo $row['idSucursal']; ?>" class="btn btn-primary">Editar</a>
                <a href="Marca.php?delete=<?php echo $row['idSucursal']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta Sucursal?')">Eliminar</a>
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