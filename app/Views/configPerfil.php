<?php include_once 'include/header.php'; ?>


<div class="container pt-3 pb-3 d-flex justify-content-center">
	<div class="card" style="width: 24rem;">
		<div class="card-header">
			<span><h2>Ajustes de perfil<h2></span>
		</div>
		<div class="card-body">
			<?php 

			echo form_open_multipart('Usuarios/actualizar');

			$data = [
				'idUsuario'    => $perfil['idUsuario'],
			];
			echo form_hidden($data);

			$data = [
				'type'  => 'text',
				'name'  => 'usuario',
				'id'    => 'usuario',
				'value'    => $perfil['usuario'],
			];
			echo form_label('Nombre de usuario', 'usuario', ['class' => 'mt-1']);
			echo form_input($data, '','class="form-control"');
			
			if(isset($validation)) {

				if($validation->hasError('usuario')) {
					?><div class="text-danger"><?php
						echo $validation->getError('usuario');
					?></div><?php
				}
				
			}
			?>
			<?php
			$data = [
				'type'  => 'email',
				'name'  => 'correo',
				'id'    => 'correo',
				'value'    => $perfil['correo'],
			];
			
			echo form_label('Correo electrónico:', 'correo', ['class' => 'mt-2']);
			echo form_input($data, '','class="form-control"');
			
			if(isset($validation)) {

				if($validation->hasError('correo')) {
					?><div class="text-danger"><?php
						echo $validation->getError('correo');
					?></div><?php
				}
				
			}
			?>
			<?php
			$data = [
				'type'  => 'text',
				'name'  => 'nombre',
				'id'    => 'nombre',
				'value'    => $perfil['nombre'],
			];
			
			echo form_label('Nombre:', 'nombre', ['class' => 'mt-2']);
			echo form_input($data, '','class="form-control"');
			
			if(isset($validation)) {

				if($validation->hasError('nombre')) {
					?><div class="text-danger"><?php
						echo $validation->getError('nombre');
					?></div><?php
				}
				
			}
			?>
			<?php
			$data = [
				'type'  => 'text',
				'name'  => 'apellidos',
				'id'    => 'apellidos',
				'value'    => $perfil['apellidos'],
			];
			
			echo form_label('Apellidos:', 'apellidos', ['class' => 'mt-2']);
			echo form_input($data, '','class="form-control"');
			
			if(isset($validation)) {

				if($validation->hasError('apellidos')) {
					?><div class="text-danger"><?php
						echo $validation->getError('apellidos');
					?></div><?php
				}
				
			}
			?>
			<?php
			$data = [
				'type'  => 'date',
				'name'  => 'fecha',
				'id'    => 'fecha',
				'value'    => $perfil['fecha'],
			];
			
			echo form_label('Fecha de nacimiento', 'fecha', ['class' => 'mt-2']);
			echo form_input($data, '','class="form-control"');
			
			if(isset($validation)) {

				if($validation->hasError('fecha')) {
					?><div class="text-danger"><?php
						echo $validation->getError('fecha');
					?></div><?php
				}
				
			}
			?>
			<?php
			$data = [
				'name'  => 'descripcion',
				'id'    => 'descripcion',
				'value'    => $perfil['descripcion'],
			];
			
			echo form_label('Descripcion', 'descripcion', ['class' => 'mt-2']);
			echo form_textarea($data, '','class="form-control"');
			
			if(isset($validation)) {

				if($validation->hasError('descripcion')) {
					?><div class="text-danger"><?php
						echo $validation->getError('descripcion');
					?></div><?php
				}
				
			}
			?>
			<?php // SUBIDA FICHERO
			$data = [
				'name'  => 'imagen',
				'id'    => 'imagen',
			];
			
			echo form_label('Imagen de perfil (jpg, jpeg, png)', 'imagen', ['class' => 'mt-2']);
			echo form_upload($data, '','class="form-control"');
			
			if(isset($validation)) {

				if($validation->hasError('imagen')) {
					?><div class="text-danger"><?php
						echo $validation->getError('imagen');
					?></div><?php
				}
				
			}
			?>
			<div class="mt-2 text-success">
				<?php 
					if(isset($conf1)) {
						echo $conf1;
					}
				?>
			</div>
			<div class="mt-2 text-danger">
				<?php 
					if(isset($error1)) {
						echo $error1;
					}
				?>
			</div>
			<div class="row mt-3">
					<div class="col p-1 d-flex justify-content-center align-items-center">
						<?php
							echo form_submit('actualizar', 'Confirmar ajustes', 'class="btn btn-pri"');
							echo form_close();
						?>
					</div>
			</div>
		</div>
	</div>

	<div class="card" style="width: 24rem;"> <!-- FORM CONTRASEÑA -->
		<div class="card-header">
			<span><h2>Cambiar contraseña<h2></span>
		</div>
		<div class="card-body">
			<?php 

			echo form_open('Usuarios/actualizarClave');

			$data = [
				'idUsuario'    => $perfil['idUsuario'],
			];
			echo form_hidden($data);

			$data = [
				'type'  => 'password',
				'name'  => 'claveAct',
				'id'    => 'claveAct',
			];
			
			echo form_label('Contraseña actual', 'claveAct', ['class' => 'mt-2']);
			echo form_input($data, '','class="form-control"');
			
			if(isset($validation)) {

				if($validation->hasError('claveAct')) {
					?><div class="text-danger"><?php
						echo $validation->getError('claveAct');
					?></div><?php
				}
				
			}

			$data = [
				'type'  => 'password',
				'name'  => 'clave',
				'id'    => 'clave',
			];
			
			echo form_label('Contraseña nueva', 'clave', ['class' => 'mt-2']);
			echo form_input($data, '','class="form-control"');
			
			if(isset($validation)) {

				if($validation->hasError('clave')) {
					?><div class="text-danger"><?php
						echo $validation->getError('clave');
					?></div><?php
				}
				
			}

			$data = [
				'type'  => 'password',
				'name'  => 'clave2',
				'id'    => 'clave2',
			];
			
			echo form_label('Confirmar contraseña nueva', 'clave2', ['class' => 'mt-2']);
			echo form_input($data, '','class="form-control"');
			
			if(isset($validation)) {

				if($validation->hasError('clave2')) {
					?><div class="text-danger"><?php
						echo $validation->getError('clave2');
					?></div><?php
				}
				
			}
			
			if(isset($validation)) {

				if($validation->hasError('fecha')) {
					?><div class="text-danger"><?php
						echo $validation->getError('fecha');
					?></div><?php
				}
				
			}
			?>
			<div class="mt-2 text-success">
				<?php 
					if(isset($conf2)) {
						echo $conf2;
					}
				?>
			</div>
			<div class="mt-2 text-danger">
				<?php 
					if(isset($error2)) {
						echo $error2;
					}
				?>
			</div>
			<div class="row mt-3">
					<div class="col p-1 d-flex justify-content-center align-items-center">
						<?php
							echo form_submit('actualizarClave', 'Actualizar contraseña', 'class="btn btn-pri"');
							echo form_close();
						?>
					</div>
			</div>
		</div>
	</div>
</div>
<?php include_once 'include/footer.php';?>
</body>
</html>