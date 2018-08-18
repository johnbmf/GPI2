<!DOCTYPE html>
<?php
  require_once("proc/db_conn.php");
  session_start();
  if ($_SESSION['user'] == '' || (time() - $_SESSION['LAST_ACTIVITY'] > 6000)){
    $_SESSION = array();

    if (ini_get("session.use_cookies")){
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000,
          $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }

    session_destroy();
    header("Location: index.php");
    exit;
  }

  $_SESSION['LAST_ACTIVITY'] = time();

  $conexion = db_conn();
  $sql = "SELECT * FROM inventario";
  $resultado = $conexion->query($sql);
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-clearmin.min.css">
        <link rel="stylesheet" type="text/css" href="assets/css/roboto.css">
        <link rel="stylesheet" type="text/css" href="assets/css/material-design.css">
        <link rel="stylesheet" type="text/css" href="assets/css/small-n-flat.css">
        <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
        <title>GPI - Solicitudes</title>
    </head>
    <body class="cm-no-transition cm-1-navbar">
        <div id="cm-menu">
            <nav class="cm-navbar cm-navbar-primary">
                <div class="cm-flex"><a href="main.php" class="cm-logo"></a></div>
                <div class="btn btn-primary md-menu-white" data-toggle="cm-menu"></div>
            </nav>
            <div id="cm-menu-content">
                <div id="cm-menu-items-wrapper">
                    <div id="cm-menu-scroller">
                        <ul class="cm-menu-items">
                            <li><a href="main.php" class="sf-house">Pagina Principal</a></li>
                            <li><a href="add_item.php" class="sf-sign-add">Añadir Item</a></li>
                            <li><a href="ver_item.php" class="sf-brick">Ver Items</a></li>
                            <li><a href="ver_solicitudes.php" class="sf-monitor">Solicitudes</a></li>
                            <li class="active"><a href="gen_solicitud.php" class="sf-file-excel">Generar Solicitud</a></li>
                            <li class=><a href="r_solicitud.php" class="sf-monitor">Responder Solicitud</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <header id="cm-header">
            <nav class="cm-navbar cm-navbar-primary">
                <div class="btn btn-primary md-menu-white hidden-md hidden-lg" data-toggle="cm-menu"></div>
                <div class="cm-flex">
                    <h1>Generar Solicitud</h1>
                </div>
                <div class="dropdown pull-right">
                    <button class="btn btn-primary md-notifications-white" data-toggle="dropdown"> <span class="label label-danger">NUM</span> </button>
                    <div class="popover cm-popover bottom">
                        <div class="arrow"></div>
                        <div class="popover-content">
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <h4 class="list-group-item-heading text-overflow">
                                        <i class="fa fa-fw fa-envelope"></i> Ejemplo Notificacion 1
                                    </h4>
                                    <p class="list-group-item-text text-overflow">Breve Descripción</p>
                                </a>
                                <a href="#" class="list-group-item">
                                    <h4 class="list-group-item-heading">
                                        <i class="fa fa-fw fa-envelope"></i> Ejemplo Notificacion 2
                                    </h4>
                                    <p class="list-group-item-text">Breve Descripción</p>
                                </a>
                                <a href="#" class="list-group-item">
                                    <h4 class="list-group-item-heading">
                                        <i class="fa fa-fw fa-warning"></i> Ejemplo Notificacion 3
                                    </h4>
                                    <p class="list-group-item-text">Breve Descripción</p>
                                </a>
                            </div>
                            <div style="padding:10px"><a class="btn btn-success btn-block" href="#">Mostrar más</a></div>
                        </div>
                    </div>
                </div>
                <div class="dropdown pull-right">
                    <button class="btn btn-primary md-account-circle-white" data-toggle="dropdown"></button>
                    <ul class="dropdown-menu">
                        <li class="disabled text-center">
                            <a style="cursor:default;"><strong><?php echo $_SESSION["user"];?></strong></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Perfil</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-cog"></i> Ajustes</a>
                        </li>
                        <li>
                            <a href="proc/logout.php"><i class="fa fa-fw fa-sign-out"></i> Cerrar Sesión</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div id="global">
            <div class="container-fluid cm-container-white" style="min-height:80vh;">
             <!--

             -->
            <?php
            if (isset($_GET["s"])){
              if ($_GET["s"] == 1){
                echo "<div class='row'>
                        <div class='col-xs-12'>
                          <div class='alert alert-success'> Se ha generado la solicitud con éxito </div>
                        </div>
                      </div>";
              }

              else{
                echo "<div class='row'>
                        <div class='col-xs-12'>
                          <div class='alert alert-danger'> Se ha producido un error al generar la solicitud. Intentelo nuevamente. </div>
                        </div>
                      </div>";
              }
            }
            ?>
            <form method="POST" action="proc/generar_solicitud.php" target="_blank">
              <h3>Datos de la solicitud</h3>
              <br>
              <div class="row">

                <div class="col-xs-2">
                  <div class="form-gruop">
                    <label>ID de la solicitud</label>
                    <div class="input-group">
                      <div class="input-group-addon"><i></i></div>
                      <input type="number" name="sol_id" class="form-control" placeholder="Ej: 35768" required>
                    </div>
                  </div>
                </div>


                <div class="col-xs-2">
                  <div class="form-gruop">
                    <label>Fecha Limite</label>
                    <div class="input-group">
                      <div class="input-group-addon"><i></i></div>
                      <input type="date" name="fecha_lim" class="form-control" placeholder="limite" required>
                    </div>
                  </div>
                </div>
            </div>
            <hr/>
            <h3>Recursos a solicitar</h3>
            <br>
            <div class="row">

                <div class="col-xs-3">
                  <div class="form-group">
                    <label>Item</label>
                    <div class="input-group">
                      <div class="input-group-addon"><i></i></div>
                      <select name="item_detalle_1" class="form-control" required>
                        <option value="" disabled selected value>-- Seleccione un ítem --</option>
                        <?php
                          while ($row = $resultado->fetch_assoc()){
                            echo "<option value='" . $row["item_id"] . " " . $row["nombre"] . "'>(ID: " . $row["item_id"] . ")" . $row["nombre"] . "</option>";
                          }
                          $resultado->data_seek(0);
                        ?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-xs-3">
                  <div class="form-group">
                    <label>Cantidad</label>
                    <div class="input-group">
                      <div class="input-group-addon"><i></i></div>
                      <input type="number" name="item_stock_1" class="form-control" placeholder="Ej: 10" min="1" required>
                    </div>
                  </div>
                </div>
          </div>

          <div class="row">

              <div class="col-xs-3">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon"><i></i></div>
                    <select name="item_detalle_2" class="form-control">
                      <option value="" disabled selected value>-- Seleccione un ítem --</option>
                      <?php
                        while ($row = $resultado->fetch_assoc()){
                          echo "<option value='" . $row["item_id"] . " " . $row["nombre"] . "'>(ID: " . $row["item_id"] . ")" . $row["nombre"] . "</option>";
                        }
                        $resultado->data_seek(0);
                      ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-xs-3">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon"><i></i></div>
                    <input type="number" name="item_stock_2" class="form-control" placeholder="Ej: 10" min="1">
                  </div>
                </div>
              </div>
        </div>

        <div class="row">

            <div class="col-xs-3">
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-addon"><i></i></div>
                  <select name="item_detalle_3" class="form-control" >
                    <option value="" disabled selected value>-- Seleccione un ítem --</option>
                    <?php
                      while ($row = $resultado->fetch_assoc()){
                        echo "<option value='" . $row["item_id"] . " " . $row["nombre"] . "'>(ID: " . $row["item_id"] . ")" . $row["nombre"] . "</option>";
                      }
                      $resultado->data_seek(0);
                    ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="col-xs-3">
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-addon"><i></i></div>
                  <input type="number" name="item_stock_3" class="form-control" placeholder="Ej: 10" min="1">
                </div>
              </div>
            </div>
      </div>

      <div class="row">

          <div class="col-xs-3">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-addon"><i></i></div>
                <select name="item_detalle_4" class="form-control">
                  <option value="" disabled selected value>-- Seleccione un ítem --</option>
                  <?php
                    while ($row = $resultado->fetch_assoc()){
                      echo "<option value='" . $row["item_id"] . " " . $row["nombre"] . "'>(ID: " . $row["item_id"] . ")" . $row["nombre"] . "</option>";
                    }
                    $resultado->data_seek(0);
                  ?>
                </select>
              </div>
            </div>
          </div>

          <div class="col-xs-3">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-addon"><i></i></div>
                <input type="number" name="item_stock_4" class="form-control" placeholder="Ej: 10" min="1">
              </div>
            </div>
          </div>
    </div>

    <div class="row">

        <div class="col-xs-3">
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon"><i></i></div>
              <select name="item_detalle_5" class="form-control">
                <option value="" disabled selected value>-- Seleccione un ítem --</option>
                <?php
                  while ($row = $resultado->fetch_assoc()){
                    echo "<option value='" . $row["item_id"] . " " . $row["nombre"] . "'>(ID: " . $row["item_id"] . ")" . $row["nombre"] . "</option>";
                  }
                  $resultado->data_seek(0);
                ?>
              </select>
            </div>
          </div>
        </div>

        <div class="col-xs-3">
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon"><i></i></div>
              <input type="number" name="item_stock_5" class="form-control" placeholder="Ej: 10" min="1">
            </div>
          </div>
        </div>
  </div>

  <hr>
  <h3>Comentario adicional</h3>
  <br>
        <div class="row">
                <div class="col-xs-12">
                  <div class="form-gruop">
                    <div class="input-group">
                      <div class="input-group-addon"><i></i></div>
                      <textarea rows="8" name="comentario" class="form-control" placeholder="Comentario"></textarea>
                    </div>
                  </div>
                </div>


              </div>

              <div class="row">
                <div class="col-xs-offset-11 col-xs-1">
                    <button type="submit" class="btn btn-block btn-gpi">Solicitar</button>
                </div>
              </div>

            </form>

            <!--
            END FORM
            -->
            <footer class="cm-footer"><span class="pull-left">Conectado como: <?php echo $_SESSION["user"];?></span><span class="pull-right">&copy; PAOMEDIA SARL</span><span class="pull-right">&copy; JIP -</span></footer>
        </div>
        <script src="assets/js/lib/jquery-2.1.3.min.js"></script>
        <script src="assets/js/jquery.mousewheel.min.js"></script>
        <script src="assets/js/jquery.cookie.min.js"></script>
        <script src="assets/js/fastclick.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/clearmin.min.js"></script>
        <script src="assets/js/demo/home.js"></script>
    </body>
</html>
