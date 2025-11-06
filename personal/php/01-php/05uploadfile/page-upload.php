<?php 
function main(){
    // ----------------------------------------------
    // Manejo de los mensajes a través de la session. 
    $mensajes="";
    session_start();	
    if(isset($_SESSION['message'])){
        $tipoAlert="alert-success";					
        if(isset($_SESSION['error'])){
            $tipoAlert="alert-danger";
        }
        $el_mensaje=$_SESSION['message'];
        $mensajes=<<<ERR
            <div id="9999" class="alert alert-dismissible  {$tipoAlert} " role="alert style="margin-top:20px; ">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                {$el_mensaje}
            </div>
        ERR;
        unset($_SESSION['message']); // elimina el mensaje de la session un ves escrito el mensaje en html
        unset($_SESSION['error']);
    }
    // ----------------------------------------------

    $pagina=<<<PAG
    <!DOCTYPE html>
    <html lang="es">
    <head>
    <meta charset="utf-8">
    <title>PHP UPLOAD FILE</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>	
    <link rel="stylesheet" type="text/css" href="assets/css/custom.css">

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

    </head>
    <body>

    <div class="container">
        {$mensajes}          
            <form action="upload.php" method="post" enctype="multipart/form-data">        
                <div class="input-group mb-3">                
                    <input type="file" class="form-control" name="fileToUpload" id="inputGroupFile01"  placeholder="Seleccionar Archivo ...">
                </div>
                <div class="d-grid gap-2">               
                    <input type="submit" value="S U B I R" class="btn btn-primary" name="submit">
                </div>
            </form>
    </div>

    </body>
    </html>
    PAG;
    echo $pagina;
}
main();

?>