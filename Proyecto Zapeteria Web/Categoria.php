<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página con pestaña de Categoria</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="Style.css">
</head>
<body>
  <?php
    include('conexion.php');

     // Función para obtener todas las categorias de la base de datos
     function obtenerCategoria() {
      global $conexion;
      $query = "SELECT * FROM categoria";
      $result = mysqli_query($conexion, $query);
      return $result;
    }

    // Función para insertar un departamento en la base de datos
    function insertarCategoria($cantidadExistente, $nombreCategoria, $seccion, $descripcion) {
      global $conexion;
      $cantidadExistente = mysqli_real_escape_string($conexion, $cantidadExistente);
      $query = "INSERT INTO categoria (cantidadExistente, nombreCategoria, seccion, descripcion) VALUES ('$cantidadExistente', '$nombreCategoria', '$seccion', '$descripcion')";
      mysqli_query($conexion, $query);
    }

    // Función para actualizar una categoria en la base de datos
    function actualizarCategoria($idCategoria, $cantidadExistente, $nombreCategoria, $seccion, $descripcion) {
      global $conexion;
      $cantidadExistente = mysqli_real_escape_string($conexion, $cantidadExistente);
      $nombreCategoria = mysqli_real_escape_string($conexion, $nombreCategoria);
      $seccion = mysqli_real_escape_string($conexion, $seccion);
      $descripcion = mysqli_real_escape_string($conexion, $descripcion);
     

      // Actualizar la categoria
      $queryUpdate = "UPDATE categoria SET cantidadExistente = '$cantidadExistente', nombreCategoria = '$nombreCategoria', seccion = '$seccion', descripcion = '$descripcion' WHERE idCategoria = '$idCategoria'";

      if (mysqli_query($conexion, $queryUpdate)) {
          echo "Categoria actualizada correctamente";
      } else {
          echo "Error al actualizar: " . mysqli_error($conexion);
      }
    }

    // Función para eliminar una categoria de la base de datos
    function eliminarCategoria($idCategoria) {
      global $conexion;
      $id = mysqli_real_escape_string($conexion, $idCategoria);
      $query = "DELETE FROM Categoria WHERE idCategoria = $idCategoria";
      mysqli_query($conexion, $query);
    }

    // Procesar el formulario de agregar o actualizar Categoria
    if (isset($_POST['submit'])) {
      $cantidadExistente = $_POST['cantidadExistente'];
      $nombreCategoria = $_POST['nombreCategoria'];
      $seccion = $_POST['seccion'];
      $descripcion = $_POST['descripcion'];
     

      if ($_POST['submit'] == 'Agregar') {
        insertarCategoria($cantidadExistente, $nombreCategoria, $seccion, $descripcion);
      } elseif ($_POST['submit'] == 'Actualizar') {
        $id = $_POST['idCategoria'];
        actualizarCategoria($id, $cantidadExistente, $nombreCategoria, $seccion, $descripcion);
      }
    }

    // Procesar la eliminación de una Categoria
    if (isset($_GET['delete'])) {
      $id = $_GET['delete'];
      eliminarCategoria($id);
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
        <!-- Formulario para agregar o actualizar Categoria -->
        <h2><?php echo isset($_GET['edit']) ? 'Actualizar Categoria' : 'Agregar Categoria'; ?></h2>
        <form method="POST">
          <?php if (isset($_GET['edit'])): ?>
            <?php
              $id = $_GET['edit'];
              $query = "SELECT * FROM Categoria WHERE idCategoria = $id";
              $result = mysqli_query($conexion, $query);
              $Categoria = mysqli_fetch_assoc($result);
            ?>
            <input type="hidden" name="idCategoria" value="<?php echo $Categoria['idCategoria']; ?>">
          <?php endif; ?>
          <div class="mb-3">
            <label for="cantidadExistente">cantidad Existente</label>
            <input type="text" class="form-control" id="cantidadExistente" name="cantidadExistente" value="<?php echo isset($Categoria) ? $Categoria['cantidadExistente'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="nombreCategoria">nombre Categoria</label>
            <input type="text" class="form-control" id="nombreCategoria" name="nombreCategoria" value="<?php echo isset($Categoria) ? $Categoria['nombreCategoria'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="area">seccion</label>
            <input type="text" class="form-control" id="seccion" name="seccion" value="<?php echo isset($Categoria) ? $Categoria['seccion'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="descripcion">descripcion</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo isset($Categoria) ? $Categoria['descripcion'] : ''; ?>">
          </div>
          <button type="submit" class="btn btn-primary" name="submit" value="<?php echo isset($_GET['edit']) ? 'Actualizar' : 'Agregar'; ?>">
            <?php echo isset($_GET['edit']) ? 'Actualizar' : 'Agregar'; ?>
          </button>
        </form>
      </div>

      <div class="col-md-6 d-flex justify-content-end">
        <a href="Categoria.php" class="btn btn-success btn-sm btn-Agregar-btn">Agregar Categoria</a>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-md-12">
        <h2>Lista de Categoria</h2>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>cantidadExistente</th>
              <th>nombreCategoria</th>
              <th>seccion</th>
              <th>descripcion</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $Categoria = obtenerCategoria();
              while ($row = mysqli_fetch_assoc($Categoria)):
            ?>
            <tr>
              <td><?php echo $row['cantidadExistente']; ?></td>
              <td><?php echo $row['nombreCategoria']; ?></td>
              <td><?php echo $row['seccion']; ?></td>
              <td><?php echo $row['descripcion']; ?></td>
              <td>
                <a href="Categoria.php?edit=<?php echo $row['idCategoria']; ?>" class="btn btn-primary">Editar</a>
                <a href="Categoria.php?delete=<?php echo $row['idCategoria']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta Categoria?')">Eliminar</a>
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