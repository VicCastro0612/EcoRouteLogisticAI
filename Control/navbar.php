<?php if (isset($title)) { ?>

<header class="main-header">

    <nav class="navbar navbar-default navbar-fixed-top">

        <div class="container-fluid">

            <!-- Logo -->
            <div class="navbar-header">

                <button type="button"
                        class="navbar-toggle collapsed"
                        data-toggle="collapse"
                        data-target="#navbarEcoRoute"
                        aria-expanded="false">

                    <span class="sr-only">Menú</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>

                </button>

                <a class="navbar-brand" href="stock.php">
                    <span class="glyphicon glyphicon-road"></span>
                    <strong>EcoRoute Logistic AI</strong>
                </a>

            </div>

            <!-- Menú -->
            <div class="collapse navbar-collapse" id="navbarEcoRoute">

                <ul class="nav navbar-nav">

                    <li class="<?php echo isset($active_productos) ? $active_productos : ''; ?>">
                        <a href="stock.php">
                            <span class="glyphicon glyphicon-th-large"></span>
                            Inventario
                        </a>
                    </li>

                    <li class="<?php echo isset($active_categoria) ? $active_categoria : ''; ?>">
                        <a href="categorias.php">
                            <span class="glyphicon glyphicon-bookmark"></span>
                            Categorías
                        </a>
                    </li>

                    <li class="<?php echo isset($active_usuarios) ? $active_usuarios : ''; ?>">
                        <a href="usuarios.php">
                            <span class="glyphicon glyphicon-user"></span>
                            Personal
                        </a>
                    </li>

                </ul>

                <ul class="nav navbar-nav navbar-right">

                    <li class="navbar-text">
                        <span class="glyphicon glyphicon-time"></span>
                        <?php echo date("d/m/Y"); ?>
                    </li>

                    <li>
                        <a href="login.php?logout">
                            <span class="glyphicon glyphicon-off"></span>
                            Salir
                        </a>
                    </li>

                </ul>

            </div>

        </div>

    </nav>

</header>

<?php } ?>