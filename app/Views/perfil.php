<?php include_once 'include/header.php'; ?>

<div class="container  mt-5 pt-5 bg-white border border-gray p-3">
    <div class="row">
        <div class="col-12 col-sm-3 col-md-2">
            <img width="100%" height="auto" src='<?= base_url()?>public/assets/imagen/perfil/<?= $perfil['imagen']?>' class="img-fluid rounded-circle" style="max-width: 160px;" alt="Imagen de perfil">
        </div>
        <div class="col-12 col-sm-9 col-md-10 mt-3 mt-sm-0">
            <div class='p-2'>
                <span class="h5"><?= $perfil['usuario']?></span>
            </div>
            <div class='p-2'>
                <span class="h6"><?php if(isset($perfil['nombre'])) echo $perfil['nombre']?> <?php if(isset($perfil['apellidos'])) echo  $perfil['apellidos']?></span>
            </div>
            <div class='p-2'>
                <p><?php if(isset($perfil['descripcion'])) echo $perfil['descripcion']?></p>
            </div>
            <?php if(isset($_SESSION['idUsuario']) && $perfil['idUsuario'] == $_SESSION['idUsuario']) { // No es necesario meter dos if, con la comprobación primero de si existe ya funciona ?>
                <div class='p-2 d-flex justify-content-end'>
                    <?php
                    $texto = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                    <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                    </svg> 
                    Configuracion';
                    echo anchor('Usuarios/configurar/'.$_SESSION['idUsuario'], $texto, 'class="btn btn-secondary btn-sm p-2"');
                    ?>
                </div>
            <?php } ?>
        </div>
    </div>

	<div class="row">
        <div class="col-12 col-sm-4 col-md-3">
            
			<div class='p-2 text-end'>
				<span class="h5">Historias</span>
			</div>
        </div>
        <div class="col-12 col-sm-8 col-md-9 mt-3 mt-sm-0">
		<?php if(isset($_SESSION['idUsuario']) && $perfil['idUsuario'] == $_SESSION['idUsuario']) { // No es necesario meter dos if, con la comprobación primero de si existe ya funciona ?>
                <div class='p-2 d-flex justify-content-end'>
                    <?php
                    $texto = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journal-plus" viewBox="0 0 16 16">
					<path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5"/>
					<path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
					<path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
				  </svg>
                    Crear';
                    echo anchor('Historias/editar', $texto, 'class="btn btn-secondary btn-sm p-2"');
                    ?>
                </div>
            <?php } ?>
        </div>
    </div>
	<div class="row">
        <div class="col-12 col-sm-4 col-md-3">
            
			<div class='p-2 text-end'>
				<span class="h5">Historias</span>
			</div>
        </div>
        <div class="col-12 col-sm-8 col-md-9 mt-3 mt-sm-0">
            <div class='p-2'>
                <span class="h5"><?= $perfil['usuario']?></span>
            </div>
            <div class='p-2'>
                <span class="h6"><?php if(isset($perfil['nombre'])) echo $perfil['nombre']?> <?php if(isset($perfil['apellidos'])) echo  $perfil['apellidos']?></span>
            </div>
            <div class='p-2'>
                <p><?php if(isset($perfil['descripcion'])) echo $perfil['descripcion']?></p>
            </div>
            <?php if(isset($_SESSION['idUsuario'])) if($perfil['idUsuario'] == $_SESSION['idUsuario']) { // El primer if comprueba si hay session para que no salte error, es u if de una línea por lo que no hacen falta corchetes?>
                <div class='p-2 d-flex justify-content-end'>
                    <?php
                    $texto = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                    <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                    </svg> 
                    Configuracion';
                    echo anchor('Usuarios/configurar/'.$_SESSION['idUsuario'], $texto, 'class="btn btn-secondary btn-sm p-2"');
                    ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php include_once 'include/footer.php';?>
</body>
</html>
