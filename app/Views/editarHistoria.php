<?php include_once 'include/header.php'; ?>

<div class="container pt-3 pb-3 d-flex justify-content-center">
	<div class="card" style="width: 24rem;">
		<div class="card-header">
			<span><h2>
			<?php
				switch($accion){
					case 'nuevo':
						echo 'Crear historia';
						break;
					case 'editar':
						echo 'Editar historia';
						break;
				}
			?>
			<h2></span>
		</div>
		<div class="card-body">
			<?php 
			echo form_open_multipart('Historias/actualizar');

			 // Esto creo que es mejor meterlo en el modelo
			$idHistoria = 0;
			if(isset($historia['idHistoria'])) $idHistoria = $historia['idHistoria'];
			$data = [
				'idHistoria'    => $idHistoria,
				'IdAutor'		=> $_SESSION['idUsuario']
			];
			echo form_hidden($data);

			$data = [
				'type'  => 'text',
				'name'  => 'titulo',
				'id'    => 'titulo',
			];
			if($accion == 'editar') {
				
				$data['value'] = $historia['titulo'];
			}
			echo form_label('Título', 'titulo', ['class' => 'mt-1']);
			echo form_input($data, '','class="form-control"');
			
			if(isset($validation)) {

				if($validation->hasError('titulo')) {
					?><div class="text-danger"><?php
						echo $validation->getError('titulo');
					?></div><?php
				}
				
			}
			echo '<br>';
			//------------
			echo form_label('Categorías', '', ['class' => 'mt-1']);
			echo '<br>';
			/*echo form_multiselect('categorias', $categorias); */
			
			$i = 0;
			$j = 1;
			echo '<div class="row">';
			foreach($categorias as $categoria){
				if($categoria != 'Sin categoria'){
					$data = [
						'name'    => 'categoria[]',//Tengo que llamarlo asi para que se guarden todas las categorias
						'id'      => 'categoria[]',
						'value'   => $j,
						//'checked' => true,
						//'style'   => 'margin:10px',
					];	
				
						
					echo '<div class="col">';
					echo form_checkbox($data);
					echo form_label($categoria, 'categoria[]', ['class' => 'm-1 mr-3']);
					echo '</div>';
					$i++;
					$j++;
					if($i >= 2) {
						echo '<div class="w-100"></div>';
						$i = 0;
					}
				}
			}
			echo '</div>';
			  
			if(isset($validation)) {

				if($validation->hasError('categoria')) {
					?><div class="text-danger"><?php
						echo $validation->getError('categoria');
					?></div><?php
				}
				
			}
		  // -----------------
			echo '<br>';
			$data = [
				'name'    => 'descripcion',
				'id'      => 'descripcion',
				'value'   => ''
			];
			if(isset($historia['descripcion'])) {
				
				$data['value'] = $historia['descripcion'];
			}
			echo form_label('Sinopsis', 'descripcion', ['class' => 'mt-2']);
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
			
			echo form_label('Portada (jpg, jpeg, png)', 'imagen', ['class' => 'mt-2']);
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
							// Aqui puedo meter un submit diferente

							$texto = "";
							if($accion == 'nuevo') {
								
								$texto = 'Crear historia';
								echo form_submit('accion', $texto, 'class="btn btn-pri"');
							} elseif($accion == 'editar') {
								
								$texto = 'Actualizar historia';
								echo form_submit('accion', $texto, 'class="btn btn-pri"');
							}

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