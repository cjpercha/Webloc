<nav class="navbar navbar-expand-md fixed-top">
    <div class="container-fluid">
        <?= anchor('Usuarios/inicio', '<img class="" width="80" height="80" src="'.base_url().'public/assets/imagen/logo-Red.png" class="img-fluid" alt="Perfil">', 'class="navbar-brand"')?>

        <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ">
                <li class="nav-item">
                    <?= anchor('Usuarios/inicio', 'Buscar', 'class="nav-link"') ?>
                </li>
                <li class="nav-item">
                    <?= anchor('Usuarios/inicio', 'Categorias', 'class="nav-link"') ?>
                </li>
                <?php if (isset($_SESSION['esAdmin']) && $_SESSION['esAdmin'] == "1") { ?>
                    <li class="nav-item"><?= anchor('Usuarios/inicio', 'Admin', 'class="nav-link"') ?></li>
                <?php } ?>
                <?php if (isset($_SESSION['idUsuario'])) { ?>
                    <li class="nav-item"><?= anchor('Usuarios/perfil/'.$_SESSION['idUsuario'], 'Perfil', 'class="nav-link"') ?></li>
                <?php } ?>
                <?php if (!isset($_SESSION['idUsuario'])) { ?>
                    <li class="nav-item d-md-none">
                        <?= anchor('Usuarios/Login', 'Iniciar sesión', 'class="nav-link"') ?>
                    </li>
                    <li class="nav-item d-md-none">
                        <?= anchor('Usuarios/registro', 'Registrarse', 'class="nav-link"') ?>
                    </li>
                <?php } else { ?>
                    <li class="nav-item d-md-none">
                        <?= anchor('Usuarios/configurar/'.$_SESSION['idUsuario'], 'Configurar perfil', 'class="nav-link"') ?>
                    </li>
                    <li class="nav-item d-md-none">
                        <?= anchor('Login/cerrarSesion', 'Cerrar sesión', 'class="nav-link"') ?>
                    </li>
                <?php } ?>
            </ul>
            <!-- Pantallas grandes -->
            <div class="navbar-nav ms-auto mb-2 mb-md-0">
                <?php if (!isset($_SESSION['idUsuario'])) { ?>
                    <span class="nav-item d-none d-md-inline m-1">
                        <?= anchor('Usuarios/Login', 'Iniciar sesión', 'class="btn btn-secondary text-light mr-2"') ?>
                    </span>
                    <span class="nav-item d-none d-md-inline m-1">
                        <?= anchor('Usuarios/registro', 'Registrarse', 'class="btn btn-secondary text-light"') ?>
                    </span>
                <?php } else { ?>
                    <span class="d-none d-md-inline">
                        <a class="nav-link dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="rounded-circle me-1" width="32" height="32" src='<?= base_url() ?>public/assets/imagen/perfil/<?= $_SESSION['imagen'] ?>?ts=<?= time() ?>' class="img-fluid" alt="Perfil">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="nav-item mt-1 ml-2">
                                <?= anchor('Usuarios/configurar/'.$_SESSION['idUsuario'], 'Configurar perfil', 'class="dropdown-link nav-link "') ?>
                            </li>
                            <li class="nav-item mt-2 ml-2">
                                <?= anchor('Login/cerrarSesion', 'Cerrar sesión', 'class="nav-link"') ?>
                            </li>
                        </ul>
                    </span>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>
