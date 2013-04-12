<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>.::Control de Correspondencia::.</title>
        <meta name="description" content="">
        <meta name="author" content="">

        <link href="/css/bootstrap.css" rel="stylesheet">
        <link href="/css/bootstrap-responsive.css" rel="stylesheet">
        
        <style type="text/css">
        /* GLOBAL STYLES
        -------------------------------------------------- */
        /* Padding below the footer and lighter body text */

        body {
            padding-bottom: 40px;
            color: #5a5a5a;
        }



        /* CUSTOMIZE THE NAVBAR
        -------------------------------------------------- */

        /* Special class on .container surrounding .navbar, used for positioning it into place. */
        .navbar-wrapper {
            top: 0;
            left: 0;
            right: 0;
            z-index: 10;
            margin-top: 20px;
        }
        .navbar-wrapper .navbar {

        }

        /* Remove border and change up box shadow for more contrast */
        .navbar .navbar-inner {
            border: 0;
            -webkit-box-shadow: 0 2px 10px rgba(0,0,0,.25);
            -moz-box-shadow: 0 2px 10px rgba(0,0,0,.25);
            box-shadow: 0 2px 10px rgba(0,0,0,.25);
        }

        /* Downsize the brand/project name a bit */
        .navbar .brand {
            padding: 14px 20px 16px; /* Increase vertical padding to match navbar links */
            font-size: 16px;
            font-weight: bold;
            text-shadow: 0 -1px 0 rgba(0,0,0,.5);
        }

        /* Navbar links: increase padding for taller navbar */
        .navbar .nav > li > a {
            padding: 15px 20px;
        }

        /* Offset the responsive button for proper vertical alignment */
        .navbar .btn-navbar {
            margin-top: 10px;
        }

        /* RESPONSIVE CSS
        -------------------------------------------------- */

        @media (max-width: 979px) {
            .container.navbar-wrapper {
                margin-bottom: 0;
                width: auto;
            }
            .navbar-inner {
                border-radius: 0;
                margin: -20px 0;
            }
        }

        @media (max-width: 767px) {
            .navbar-inner {
                margin: -20px;
            }
        }
        </style>
    </head>
    <body>
        <!-- NAVBAR
        ================================================== -->
        <div class="navbar-wrapper">
            <!-- Wrap the .navbar in .container to center it within the absolutely positioned parent. -->
            <div class="container">
                <div class="navbar navbar-inverse">
                    <div class="navbar-inner">
                        <!-- Responsive Navbar Part 1: Button for triggering responsive navbar (not covered in tutorial). Include responsive CSS to utilize. -->
                        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        </button>
                        <a class="brand" href="#">CORR!</a>
                        <!-- Responsive Navbar Part 2: Place all navbar contents you want collapsed withing .navbar-collapse.collapse. -->
                        <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li class="active"><a href="/">Principal</a></li>
                            <li><a href="javascript: void(null);" onclick="cargar('recibir.php');">Recibir</a></li>
                            <li><a href="#contact">Actualizar</a></li>
                            <!-- Read about Bootstrap dropdowns at http://twitter.github.com/bootstrap/javascript.html#dropdowns -->
                            <li class="dropdown">
                            <a href="javascript: void(null);" class="dropdown-toggle" data-toggle="dropdown">Administraci&oacute;n <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li class="nav-header">Nav header</li>
                                <li><a href="#">Separated link</a></li>
                                <li><a href="#">One more separated link</a></li>
                            </ul>
                            </li>
                        </ul>
                        </div><!--/.nav-collapse -->
                    </div><!-- /.navbar-inner -->
                </div><!-- /.navbar -->
            </div> <!-- /.container -->
        </div><!-- /.navbar-wrapper -->
        
        <div class="container" id="principal">
            <h1>Sistema de Control de Correspondencia</h1>
            <p>Controle efectivamente la correspondencia que recibe y envia.</p>
            
            <hr>
            
            <footer>
                <p>&copy; CSJ - Sala de lo Civil - <?php echo date("Y"); ?></p>
            </footer>
        </div>
        <script src="/js/jquery-1.9.1.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/funcionesGenerales.js"></script>
    </body>
</html>