<?php if (isset($title)) { ?>

<header>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">

            <div class="navbar-header">

                <button type="button"
                        class="navbar-toggle collapsed"
                        data-toggle="collapse"
                        data-target="#menuPrincipal"
                        aria-expanded="false">

                    <span class="sr-only">Abrir menú</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>

                </button>

                <a class="navbar-brand" href="stock.php">
                    <span class="glyphicon glyphicon-leaf"></span>
                    EcoRoute AI
                </a>

            </div>

            <div class="collapse navbar-collapse" id="menuPrincipal">

                <ul class="nav navbar-nav">

                    <li class="<?php echo isset($active_productos) ? $active_productos : ''; ?>">
                        <a href="stock.php">
                            <span class="glyphicon glyphicon-list-alt"></span>
                            Artículos
                        </a>
                    </li>

                    <li class="<?php echo isset($active_categoria) ? $active_categoria : ''; ?>">
                        <a href="categorias.php">
                            <span class="glyphicon glyphicon-folder-open"></span>
                            Rubros
                        </a>
                    </li>

                    <li class="<?php echo isset($active_usuarios) ? $active_usuarios : ''; ?>">
                        <a href="usuarios.php">
                            <span class="glyphicon glyphicon-user"></span>
                            Empleados
                        </a>
                    </li>

                </ul>

                <ul class="nav navbar-nav navbar-right">

                    <li>
                        <a href="login.php?logout">
                            <span class="glyphicon glyphicon-log-out"></span>
                            Cerrar sesión
                        </a>
                    </li>

                </ul>

            </div>

        </div>
    </nav>
</header>

<?php } ?>