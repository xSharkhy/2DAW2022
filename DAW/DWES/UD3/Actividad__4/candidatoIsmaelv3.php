<?php

if (!empty($_POST)) { // El script solo se ejecutará si se ha enviado el formulario

	// Recorremos el array $_POST. Eliminamos espacios en blanco al principio y al final
	// Si el campo está vacío, se marca como error
	foreach ($_POST as $key => $value) {
		$_POST[$key] = trim($value);
		if (empty($_POST[$key])) $error[$key] = true;
	}

	// Recorremos el array $_FILES. Si el campo está vacío, se marca como error
	foreach ($_FILES as $key => $value)
		if (empty($_FILES[$key]['name'])) $error[$key] = true;

	// Si la variable $error está inicializada, muestra un error y acaba la ejecución
	if (isset($error)) echo '<div class="error">Hay campos vacíos en el formulario</div>';
	// Si no hay registro de error, valida todo el formulario con expresiones regulares
	// Si el contenido del formulario no concuerda con la regexp, se imprimirá un error bajo el campo.
	else {
		preg_match('/\w{4,16}/', $_POST['usuario']) ? true : $error['usuario'] = 'El nombre de usuario debe tener entre 4 y 16 caracteres' . '<br>';
		preg_match('/^[a-zA-Z\'\-]{3,}$/', $_POST['nombre']) ? true : $error['nombre'] = 'El nombre debe tener almenos 3 caracteres' . '<br>';
		preg_match('/^[a-zA-Z\'\-\s]{3,}$/', $_POST['apellidos']) ? true : $error['apellidos'] = 'El apellido debe tener almenos 3 letras.' . '<br>';
		preg_match('/^[0-9]{7,8}[A-Z]$/', $_POST['dni']) ? true : $error['dni'] = 'El DNI debe tener 7 u 8 números y una letra mayúscula' . '<br>';
		preg_match('/^[a-zA-Z0-9\'\-\s]{0,50}$/', $_POST['direccion']) ? true : $error['direccion'] = 'La dirección debe tener menos de 50 caracteres' . '<br>';
		preg_match('/^.+@.+\..+$/', $_POST['mail']) ? true : $error['mail'] = 'El email no es válido' . '<br>';
		preg_match('/^(0[1-9]|[12][0-9]|3[01])(\-|\.|\/)(0[1-9]|1[012])(\-|\.|\/)(19[0-9]{2}|20[01][0-9]|202[12])$/', $_POST['fecha']) ? true : $error['fecha'] = 'La fecha debe tener el formato DD/MM/YYYY' . '<br>';

		// Se comprueba si hay errores al subir los archivos
		foreach ($_FILES as $key => $value)
			if ($_FILES[$key]['error'] != UPLOAD_ERR_OK) {
				$error[$key] = 'Error: ';
				switch ($_FILES[$key]['error']) {
					case UPLOAD_ERR_INI_SIZE:
					case UPLOAD_ERR_FORM_SIZE:
						$error[$key] .= 'El tamaño del archivo excede el permitido por el cliente';
						break;
					case UPLOAD_ERR_PARTIAL:
						$error[$key] .= 'El envío del archivo ha sido suspendido durante la transferencia';
						break;
					case UPLOAD_ERR_NO_FILE:
						$error[$key] .= 'No se ha podido encontrar el archivo';
						break;
					default:
						$error[$key] .= 'Error indeterminado';
				}
			}

		// Si no hay error de subida, se comprueba si los archivos son del tipo esperado.
		if (!isset($error)) {
			$_FILES['foto']['type'] == 'image/png' ? true : $error['foto'] = 'El archivo no es una imagen PNG' . '<br>';
			$_FILES['pdf']['type'] == 'application/pdf' ? true : $error['pdf'] = 'El archivo no es un PDF' . '<br>';

			foreach ($_FILES as $key => $value) {
				if (!isset($error[$key]) && is_uploaded_file($_FILES[$key]['tmp_name'])) {
					// Se asigna un nombre al archivo para comprobar que no exista en el servidor
					// pdf:  curriculo-dni-nombre-apellido1.pdf
					// foto: dni.png
					if (explode('/', $_FILES[$key]['type'])[1] == 'pdf')
						$nombre = './' . 'curriculo-' . $_POST['dni'] . '-' . $_POST['nombre'] . '-' . explode(' ', $_POST['apellidos'])[0] . '.' . explode('/', $_FILES[$key]['type'])[1];
					else
						$nombre = './' . $_POST['dni'] . '.' . explode('/', $_FILES[$key]['type'])[1];
					// Si existe, se le añade timestamp al nombre
					if (is_file($nombre))
						$nombre = './' . time() . '-' . substr($nombre, 2);
					// Se mueve el archivo del directorio temporal al directorio definitivo
					if (!move_uploaded_file($_FILES[$key]['tmp_name'], $nombre))
						$error[$key] = 'Error al mover el archivo a su destino';
				} else
					$error[$key] = 'Error al subir el archivo. ' . $error[$key];
			}
		}
	}
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<form action="#" method="POST" class="flex__container" enctype="multipart/form-data">
		<div class="flex__item">
			<label for="usuario">Usuario</label>
			<input type="text" name="usuario" id="usuario" placeholder="Usuario" <?= isset($error) ? (isset($_POST['usuario']) ? 'value="' . $_POST['usuario'] . '"' : '') : '' ?>><br>
		</div>
		<div class="error flex__item">
			<?= isset($error['usuario']) ? (is_bool($error['usuario']) ? '' : $error['usuario']) : '' ?>
		</div>
		<div class="flex__item">
			<label for="nombre">Nombre</label>
			<input type="text" name="nombre" id="nombre" placeholder="Nombre" <?= isset($error) ? (isset($_POST['nombre']) ? 'value="' . $_POST['nombre'] . '"' : '') : '' ?>><br>
		</div>
		<div class="error flex__item">
			<?= isset($error['nombre']) ? (is_bool($error['nombre']) ? '' : $error['nombre']) : '' ?>
		</div>
		<div class="flex__item">
			<label for="apellidos">Apellidos</label>
			<input type="text" name="apellidos" id="apellidos" placeholder="Apellidos" <?= isset($error) ? (isset($_POST['apellidos']) ? 'value="' . $_POST['apellidos'] . '"' : '') : '' ?>><br>
		</div>
		<div class="error flex__item">
			<?= isset($error['apellidos']) ? (is_bool($error['apellidos']) ? '' : $error['apellidos']) : '' ?>
		</div>
		<div class="flex__item">
			<label for="dni">DNI</label>
			<input type="text" name="dni" id="dni" placeholder="DNI" <?= isset($error) ? (isset($_POST['dni']) ? 'value="' . $_POST['dni'] . '"' : '') : '' ?>><br>
		</div>
		<div class="error flex__item">
			<?= isset($error['dni']) ? (is_bool($error['dni']) ? '' : $error['dni']) : '' ?>
		</div>
		<div class="flex__item">
			<label for="direccion">Dirección</label>
			<input type="text" name="direccion" id="direccion" placeholder="Direccion" <?= isset($error) ? (isset($_POST['direccion']) ? 'value="' . $_POST['direccion'] . '"' : '') : '' ?>><br>
		</div>
		<div class="error flex__item">
			<?= isset($error['direccion']) ? (is_bool($error['direccion']) ? '' : $error['direccion']) : '' ?>
		</div>
		<div class="flex__item">
			<label for="mail">Correo electrónico</label>
			<input type="text" name="mail" id="mail" placeholder="email" <?= isset($error) ? (isset($_POST['mail']) ? 'value="' . $_POST['mail'] . '"' : '') : '' ?>><br>
		</div>
		<div class="error flex__item">
			<?= isset($error['mail']) ? (is_bool($error['mail']) ? '' : $error['mail']) : '' ?>
		</div>
		<div class="flex__item">
			<label for="fecha">Fecha</label>
			<input type="text" name="fecha" id="fecha" placeholder="Fecha" <?= isset($error) ? (isset($_POST['fecha']) ? 'value="' . $_POST['fecha'] . '"' : '') : '' ?>><br>
		</div>
		<div class="error flex__item">
			<?= isset($error['fecha']) ? (is_bool($error['fecha']) ? '' : $error['fecha']) : '' ?>
		</div>
		<div class="flex__item">
			<div>
				<label for="foto">Foto DNI (.png)</label>
				<input type="file" name="foto" id="foto"><br>
			</div>
			<div>
				<label for="pdf">Currículum (.pdf)</label>
				<input type="file" name="pdf" id="pdf"><br>
			</div>
		</div>
		<div class="error flex__item">
			<?= isset($error['foto']) ? (is_bool($error['foto']) ? '' : $error['foto']) : '' ?>

			<?= isset($error['pdf']) ? (is_bool($error['pdf']) ? '' : $error['pdf']) : '' ?>
		</div>
		<input class="button" type="submit" value="Enviar">
	</form>
</body>

</html>