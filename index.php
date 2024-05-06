<!DOCTYPE html>
<html lang="es">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Gestión de la recogida de regalos">
        <meta name="author" content="Amics del reis d'Alfara">

        <title>Recogida de regalos BETA</title>

        <!-- GLOBAL STYLES -->
        <link href="views/css/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic' rel="stylesheet" type="text/css">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel="stylesheet" type="text/css">
        <link href="views/icons/font-awesome/css/font-awesome.min.css" rel="stylesheet">

        <!-- PAGE LEVEL PLUGIN STYLES -->

        <!-- THEME STYLES -->
        <link href="views/css/style.css" rel="stylesheet">
        <link href="views/css/plugins.css" rel="stylesheet">

        <!-- THEME DEMO STYLES -->
        <link href="views/css/demo.css" rel="stylesheet">

        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->


    </head>

    <body>

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-banner text-center">
                        <h1><i class="fa fa-crown"></i> Recogida de regalos</h1>
                    </div>
                    <div class="portlet portlet-green">
                        <div class="portlet-heading login-heading">
                            <div class="portlet-title">
                                <h4><strong>Ingreso al sistema</strong>
                                </h4>
                            </div>                     
                            <div class="clearfix"></div>
                        </div>
                        <div class="portlet-body">

                            <form accept-charset="UTF-8" role="form" method="post">
                                <fieldset>

                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        <input class="form-control" placeholder="Nombre de usuario" name="usuarioIngreso" type="text" required>
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                        <input class="form-control" placeholder="Password" name="passwordIngreso" type="password" required>
                                    </div>                              
                                    <br>
                                    <input type="submit" class="btn btn-lg btn-green btn-block" value="Ingresar">

                                </fieldset>                          
                            </form>

                            <?php                                                                
                                require_once "controllers/login/login-controller.php";
                                require_once "models/login/login-model.php";

                                $ingreso = new LoginController();
                                $ingreso->ingresoUsuarioController();                                                                   

                                if (isset($_GET["action"])) {

                                    if ($_GET["action"] == "fail") {

                                        echo "<br><div class=\"alert alert-danger alert-dismissable\">
                                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                            <strong>Alerta:</strong> Contraseña y/o usuario incorrectos!
                                        </div>";
                                    }
                                }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- GLOBAL SCRIPTS -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="views/js/plugins/bootstrap/bootstrap.min.js"></script>
        <script src="views/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <!-- HISRC Retina Images -->
        <script src="views/js/plugins/hisrc/hisrc.js"></script>

        <!-- PAGE LEVEL PLUGIN SCRIPTS -->

        <!-- THEME SCRIPTS -->        
        <script src="views/js/flex.js"></script>

    </body>

</html>
