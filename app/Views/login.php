<?php include_once 'include/header.php'; ?>


<div class="container pt-3 pb-3 d-flex justify-content-center">
	<div class="card" style="width: 24rem;">
		<div class="card-header">
			<span><h2>Inicio de sesión<h2></span>
		</div>
		<div class="card-body">
			<?php 
			echo form_open('Login/iniciarSesion');
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
			?>
			<div class="text-danger">
				<?php if(isset($error)) {
					echo $error;
						}
				?>
			</div>
			<!-- AÑADIR OLVIDO CONTRASEÑA AGUACATE-->
			<div class="row mt-3">
					<div class="col p-1 d-flex justify-content-center align-items-center">
						<?php
						echo form_submit('inicio', 'Iniciar sesión', 'class="btn btn-pri"');
						echo form_close();
						?>
					</div>
					<div class="col p-1 d-flex justify-content-center align-items-center">
						<?php
						echo anchor('Usuarios/registro', 'Crear una cuenta', 'class="btn btn-secun"');
						?>
					</div>
			</div>
	</div>        
</div>
<?php include_once 'include/footer.php';?>
</body>
</html>