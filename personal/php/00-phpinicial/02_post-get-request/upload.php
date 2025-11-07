<?php
const MAX_SIZE = 500000;                                     // constante que indica el tamaño máximo del archivo
const TARGET_DIR = "uploads/";                               // constante que indica el directorio donde se almacena el archivo
const ALLOWED_EXTENSIONS = array("jpg","png","jpeg","gif");  // constante que indica las extensiones permitidas para el archivo a subir

function recibirArchivo($userName="abc"){
	/** Comentarios:
	 * RECIBE:
	 *    Un nombre de usuario para concatenar como prefijo al nombre 
	 *    del archivo y así identificar su usuario y distinguirlo de otro nombre 
	 *    de archivo igual que pertencece a otro usuario.
	 * 	 eJ: <user>@<nombreArhivo>.png
	 * 
	 *   Almacena el archivo en el directorio $target_dir el archivo que 
	 *   se encuentra en la variable global $_FILES
	 *   $target_dir Es el nombre del directorio donde se almacena el archivo subido
	 * 
	 * RETORNA:
	 *    $result un diccionario (array asociativos) con tres claves:
	 *    $result=['filename'] -> contiene el nombre con el cual fue grabado 
	 *                         el archivo en el sistema.
	 *    $result=['message']  -> contiene un mensaje de la accion llevada 
	 *                            adelante.
	 *    $result=['uploadOk'] -> Contiene un valor booleano
	 *                            1 (verdadero)indica que la subida del archivo fue CORRECTA
	 *                            0 (falso) indica que la subida del archivo fue INCORRECTA.
   
	*/

	$target_dir = TARGET_DIR; 
	$target_file = $target_dir .$userName."@". basename($_FILES["fileToUpload"]["name"]);
	$nomArch= basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$result=null;
	$msj="";
	// Check if file name is empty
	if ($target_file==$target_dir .$userName."@") {
		$msj= ", file name empty.";
		$uploadOk = 0;
	}

	// Check if file already exists
	if (file_exists($target_file)) {
		$msj= ", file already exists.";
		$uploadOk = 0;
	}

	// Check file size
	if ($_FILES["fileToUpload"]["size"] > MAX_SIZE && $uploadOk ) {
		$msj= ", your file is too large.";
		$uploadOk = 0;
	}

	// Allow certain file formats
	
	if(!in_array($imageFileType, ALLOWED_EXTENSIONS) && $uploadOk ) {
		//$msj= ", only JPG, JPEG, PNG & GIF files are allowed.";
		$msj= ", only ".implode(",",ALLOWED_EXTENSIONS)." files are allowed.";
		$uploadOk = 0;
	}
	
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		$msj= "Sorry, your file was not uploaded".$msj;
		$uploadOk = 0;
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			   $msj= "The file ".$nomArch. " has been uploaded.";
			} else {
			   $msj= "Sorry, there was an error uploading your file.";
			   $uploadOk = 0;
			}
	}

	$result=['filename'=>$nomArch,'message'=>$msj,'uploadOk'=>$uploadOk];
	return $result;
}



?>