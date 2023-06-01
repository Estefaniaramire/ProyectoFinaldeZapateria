<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pagina de Producto</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="Style.css">
</head>
<body>
  <?php
    include('conexion.php');

     // Función para obtener todas los Producto  de la base de datos
     function obtenerProducto() {
      global $conexion;
      $query = "SELECT * FROM Producto";
      $result = mysqli_query($conexion, $query);
      return $result;
    }

    // Función para insertar un Producto en la base de datos
    function insertarProducto($color, $talla, $precio, $cantidadExistente) {
      global $conexion;
      $color = mysqli_real_escape_string($conexion, $color);
      $query = "INSERT INTO Producto(color, talla, precio, cantidadExistente) VALUES ('$color', '$talla', '$precio', '$cantidadExistente')";
      mysqli_query($conexion, $query);
    }

    // Función para actualizar un Producto en la base de datos
    function actualizarProducto($idProducto, $color, $talla, $precio, $cantidadExistente ) {
      global $conexion;
      $color = mysqli_real_escape_string($conexion, $color);
      $talla = mysqli_real_escape_string($conexion, $talla);
      $precio = mysqli_real_escape_string($conexion, $precio);
      $cantidadExistente = mysqli_real_escape_string($conexion, $cantidadExistente);
     
      // Actualizar el Producto
      $queryUpdate = "UPDATE Producto SET color = '$color', talla = '$talla', precio = '$precio', cantidadExistente = '$cantidadExistente' WHERE idProducto = '$idProducto'";

      if (mysqli_query($conexion, $queryUpdate)) {
          echo "Producto actualizado correctamente";
      } else {
          echo "Error al actualizar el Producto: " . mysqli_error($conexion);
      }
    }

    // Función para eliminar un Producto de la base de datos
    function eliminarProducto($idProducto) {
      global $conexion;
      $id = mysqli_real_escape_string($conexion, $idProducto);
      $query = "DELETE FROM Producto WHERE idProducto = $idProducto";
      mysqli_query($conexion, $query);
    }

    // Procesar el formulario de agregar o actualizar Producto
    if (isset($_POST['submit'])) {
      $color = $_POST['color'];
      $talla = $_POST['talla'];
      $precio = $_POST['precio'];
      $cantidadExistente = $_POST['cantidadExistente'];

      if ($_POST['submit'] == 'Agregar') {
        insertarProducto($color, $talla, $precio, $cantidadExistente);
      } elseif ($_POST['submit'] == 'Actualizar') {
        $id = $_POST['idProducto'];
        actualizarProducto($id, $color, $talla, $precio, $cantidadExistente);
      }
    }

    // Procesar la eliminación de un Producto
    if (isset($_GET['delete'])) {
      $id = $_GET['delete'];
      eliminarProducto($id);
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
        <!-- Formulario para agregar o actualizar Producto -->
        <h2><?php echo isset($_GET['edit']) ? 'Actualizar V' : 'Agregar Producto'; ?></h2>
        <form method="POST">
          <?php if (isset($_GET['edit'])): ?>
            <?php
              $id = $_GET['edit'];
              $query = "SELECT * FROM Producto WHERE idProducto = $id";
              $result = mysqli_query($conexion, $query);
              $Producto = mysqli_fetch_assoc($result);
            ?>
            <input type="hidden" name="idProducto" value="<?php echo $Producto['idProducto']; ?>">
          <?php endif; ?>
          <div class="mb-3">
            <label for="color">color</label>
            <input type="text" class="form-control" id=" color" name="color" value="<?php echo isset($Producto) ? $Producto['color'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="talla">talla</label>
            <input type="text" class="form-control" id="talla" name="talla" value="<?php echo isset($Producto) ? $Producto['talla'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="precio">precio</label>
            <input type="text" class="form-control" id="precio" name="precio" value="<?php echo isset($Producto) ? $Producto['precio'] : ''; ?>">
          </div>
          <div class="mb-3">
            <label for="cantidadExistente">cantidadExistente</label>
            <input type="text" class="form-control" id="cantidadExistente" name="cantidadExistente" value="<?php echo isset($Producto) ? $Producto['cantidadExistente'] : ''; ?>">
          </div>
          <div class="mb-3">
           
          <button type="submit" class="btn btn-primary" name="submit" value="<?php echo isset($_GET['edit']) ? 'Actualizar' : 'Agregar'; ?>">
            <?php echo isset($_GET['edit']) ? 'Actualizar' : 'Agregar'; ?>
          </button>
        </form>
      </div>

      <div class="col-md-6 d-flex justify-content-end">
        <a href="Producto.php" class="btn btn-success btn-sm btn-Agregar-btn">Agregar Producto</a>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-md-12">
        <h2>Lista de Producto</h2>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>color</th>
              <th>talla </th>
              <th>precio </th>
              <th>cantidadExistente</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $Producto = obtenerProducto();
              while ($row = mysqli_fetch_assoc($Producto)):
            ?>
            <tr>
              <td><?php echo $row['color']; ?></td>
              <td><?php echo $row['talla']; ?></td>
              <td><?php echo $row['precio']; ?></td>
              <td><?php echo $row['cantidadExistente']; ?></td>
            
              <td>
                <a href="Producto.php?edit=<?php echo $row['idProducto']; ?>" class="btn btn-primary">Editar</a>
                <a href="Producto.php?delete=<?php echo $row['idProducto']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este Producto?')">Eliminar</a>
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