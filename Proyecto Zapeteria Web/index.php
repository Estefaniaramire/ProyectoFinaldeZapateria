
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar sesión</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>

<section class="h-100 gradient-form" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="text-center">
                  <img src="https://thumbs.dreamstime.com/b/logotipo-para-una-zapater%C3%ADa-o-un-taller-en-estilo-del-vintage-113807464.jpg" style="width: 105px;" alt="logo">
                  <h4 class="mt-1 mb-5 pb-1">ZAPATERIA</h4>
                </div>

                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                  <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example11">Correo electrónico</label>
                    <input type="email" name="email" id="form2Example11" class="form-control" placeholder="" />
                  </div>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example22">Contraseña</label>
                    <input type="password" name="clave" id="form2Example22" class="form-control" />
                  </div>

                  <div class="text-center pt-1 mb-5 pb-1">
                    <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Iniciar sesión</button>
                    <a class="text-muted" href="recuperarCon.php">¿Olvidaste la contraseña?</a>
                  </div>

                  <div class="d-flex align-items-center justify-content-center pb-4">
                    <p class="mb-0 me-2">¿No tienes una cuenta?</p>
                    <a href="insertarDatos.php" class="btn btn-outline-danger">Crea una</a>

                  </div>

                </form>

               </div>
              </div>
              <div class="col-lg-6 d-flex align-items-center">
              <img src="https://th.bing.com/th/id/OIP.7rKReA_oA4tXTMEo8q_9lwHaE6?pid=ImgDet&rs=1" alt="Descripción de la imagen" style="width: 400%; max-height: 1000px">
            </div>                      
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
