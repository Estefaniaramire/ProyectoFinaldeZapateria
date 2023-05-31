<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pagina de Marca</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="Style.css">
</head>
<body>
  <?php
    include('conexion.php');

     // Función para obtener todas las Marca  de la base de datos
     function obtenerMarca() {
      global $conexion;
      $query = "SELECT * FROM Marca";
      $result = mysqli_query($conexion, $query);
      return $result;
    }

    // Función para insertar un Marca en la base de datos
    function insertarMarca($nombreMarca, $paisOrigen, $distribuidorMarca, $representanteMarca ) {
      global $conexion;
      $nombreMarca = mysqli_real_escape_string($conexion, $nombreMarca);
      $query = "INSERT INTO Marca(nombreMarca, paisOrigen, distribuidorMarca, representanteMarca) VALUES ('$nombreMarca', '$paisOrigen', '$distribuidorMarca', '$representanteMarca')";
      mysqli_query($conexion, $query);
    }

    // Función para actualizar un Marca en la base de datos
    function actualizarMarca($idMarca, $nombreMarca, $paisOrigen, $distribuidorMarca, $representanteMarca ) {
      global $conexion;
      $nombreMarca = mysqli_real_escape_string($conexion, $nombreMarca);
      $paisOrigen = mysqli_real_escape_string($conexion, $paisOrigen);
      $distribuidorMarca = mysqli_real_escape_string($conexion, $distribuidorMarca);
      $representanteMarca = mysqli_real_escape_string($conexion, $representanteMarca);
      // Actualizar el Marca
      $queryUpdate = "UPDATE Marca SET nombreMarca = '$nombreMarca', paisOrigen = '$paisOrigen', distribuidorMarca = '$distribuidorMarca', representanteMarca = '$representanteMarca' WHERE idMarca = '$idMarca'";

      if (mysqli_query($conexion, $queryUpdate)) {
          echo "Marca actualizada correctamente";
      } else {
          echo "Error al actualizar la Marca: " . mysqli_error($conexion);
      }
    }

    // Función para eliminar un Marca de la base de datos
    function eliminarMarca($idMarca) {
      global $conexion;
      $id = mysqli_real_escape_string($conexion, $idMarca);
      $query = "DELETE FROM Marca WHERE idMarca = $idMarca";
      mysqli_query($conexion, $query);
    }

    // Procesar el formulario de agregar o actualizar Marca
    if (isset($_POST['submit'])) {
      $nombreMarca = $_POST['nombreMarca'];
      $paisOrigen = $_POST['paisOrigen'];
      $distribuidorMarca = $_POST['distribuidorMarca'];
      $representanteMarca = $_POST['representanteMarca'];

      if ($_POST['submit'] == 'Agregar') {
        insertarMarca($nombreMarca, $paisOrigen, $distribuidorMarca, $representanteMarca);
      } elseif ($_POST['submit'] == 'Actualizar') {
        $id = $_POST['idMarca'];
        actualizarMarca($id, $nombreMarca, $paisOrigen, $distribuidorMarca, $representanteMarca);
      }
    }

    // Procesar la eliminación de un Marca
    if (isset($_GET['delete'])) {
      $id = $_GET['delete'];
      eliminarMarca($id);
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
        <!-- Formulario para agregar o actualizar Marca -->
        <h2><?php echo isset($_GET['edit']) ? 'Actualizar Marca' : 'Agregar Marca'; ?></h2>
        <form method="POST">
          <?php if (isset($_GET['edit'])): ?>
            <?php
              $id = $_GET['edit'];
              $query = "SELECT * FROM Marca WHERE idMarca = $id";
              $result = mysqli_query($conexion, $query);
              $Marca = mysqli_fetch_assoc($result);
            ?>
            <input type="hidden" name="idMarca" value="<?php echo $Marca['idMarca']; ?>">
          <?php endif; ?>
          <div class="mb-3">
            <label for="nombre">nombreMarca</label>
            <input type="text" class="form-control" id="nombreMarca" name="nombreMarca" value="<?php echo isset($Marca) ? $Marca['nombreMarca'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="paisOrigen">paisOrigen</label>
            <input type="text" class="form-control" id="paisOrigen" name="paisOrigen" value="<?php echo isset($Marca) ? $Marca['paisOrigen'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="distribuidorMarca">distribuidorMarca</label>
            <input type="text" class="form-control" id="distribuidorMarca" name="distribuidorMarca" value="<?php echo isset($Marca) ? $Marca['distribuidorMarca'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="representanteMarca">representanteMarca</label>
            <input type="text" class="form-control" id="representanteMarca" name="representanteMarca" value="<?php echo isset($Marca) ? $Marca['representanteMarca'] : ''; ?>">
          </div>
        
          <button type="submit" class="btn btn-primary" name="submit" value="<?php echo isset($_GET['edit']) ? 'Actualizar' : 'Agregar'; ?>">
            <?php echo isset($_GET['edit']) ? 'Actualizar' : 'Agregar'; ?>
          </button>
        </form>
      </div>

      <div class="col-md-6 d-flex justify-content-end">
        <a href="Marca.php" class="btn btn-success btn-sm btn-Agregar-btn">Agregar Marca</a>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-md-12">
        <h2>Lista de Marca</h2>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>NombreMarca</th>
              <th> paisOrigen</th>
              <th>distribuidorMarca</th>
              <th>representanteMarca</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $Marca = obtenerMarca();
              while ($row = mysqli_fetch_assoc($Marca)):
            ?>
            <tr>
              <td><?php echo $row['nombreMarca']; ?></td>
              <td><?php echo $row['paisOrigen']; ?></td>
              <td><?php echo $row['distribuidorMarca']; ?></td>
              <td><?php echo $row['representanteMarca']; ?></td>
              <td>
                <a href="Marca.php?edit=<?php echo $row['idMarca']; ?>" class="btn btn-primary">Editar</a>
                <a href="Marca.php?delete=<?php echo $row['idMarca']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta Marca?')">Eliminar</a>
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