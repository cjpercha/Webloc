<?php include_once 'include/header.php'; ?>


<div class="container pt-3 pb-3 d-flex justify-content-center">
	<div class="card" style="width: 24rem;">
		<div class="card-header">
			<span><h2>Regístrate<h2></span>
		</div>
		<div class="card-body">
			<?php 

			echo form_open('Login/registro');
			$data = [
				'type'  => 'text',
				'name'  => 'usuario',
				'id'    => 'usuario',
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
			
			$data = [
				'type'  => 'password',
				'name'  => 'clave',
				'id'    => 'clave',
			];
			
			echo form_label('Contraseña', 'clave', ['class' => 'mt-2']);
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
			
			echo form_label('Confirmar contraseña', 'clave2', ['class' => 'mt-2']);
			echo form_input($data, '','class="form-control"');
			
			if(isset($validation)) {

				if($validation->hasError('clave2')) {
					?><div class="text-danger"><?php
						echo $validation->getError('clave2');
					?></div><?php
				}
				
			}

			$data = [
				'type'  => 'date',
				'name'  => 'fecha',
				'id'    => 'fecha',
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
			<div class="mt-2 text-danger">
				<?php 
					if(isset($error)) {
						echo $error;
					}
				?>
			</div>
			<div class="row mt-3">
					<div class="col p-1 d-flex justify-content-center align-items-center">
						<?php
							echo form_submit('registro', 'Registrarme', 'class="btn btn-pri"');
							echo form_close();
						?>
					</div>
					<div class="col p-1 d-flex justify-content-center align-items-center">
						<?php
						echo anchor('Usuarios/login', 'Ya tengo cuenta', 'class="btn btn-secun"');
						?>
					</div>
			</div>
		</div>
	</div>        
</div>
<?php include_once 'include/footer.php';?>
</body>
</html>