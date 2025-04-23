<?php
require_once __DIR__ . '/../../../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['paciente'])) {

    // Obtener el ID del paciente que es el mismo que el idHistorial
    $idPaciente = $_POST['idPaciente'];
   
    $sql = "INSERT INTO Historial ";

    //tabla 1 historial clinico
    if (isset($_POST['motivo'])) {
        $sql.= ",motivo = ".$_POST['motivo'];
    }
    if (isset($_POST['antec_podologicos'])) {
        $antec_podologicos = $_POST['antec_podologicos'];
    }
    if (isset($_POST['antec_quirurgicos'])) {
        $antec_quirurgicos = $_POST['antec_quirurgicos'];

    }
   
    if (isset($_POST['antecedentes'])) {
        $antecedentes = $_POST['antecedentes'];
    }
    if (isset($_POST['alergias'])) {
        $alergias = $_POST['alergias'];
    }
    if (isset($_POST['farmacologia'])) {
        $farmacologia = $_POST['farmacologia'];
    }
    if (isset($_POST['desarrolloPSi'])) {
        $desarrolloPSi = $_POST['desarrolloPSi'];
    }
    if (isset($_POST['observaciones'])) {
        $observaciones = $_POST['observaciones'];
        // tabla 2 inspeccion
    }
    if (isset($_POST['archivo'])) {
        $archivo = $_POST['archivo'];
    }
    if (isset($_POST['onicopatias'])) {
        $onicopatias = $_POST['onicopatias'];
    }
    if (isset($_POST['queratopatias'])) {
        $inspeccion = $_POST['queratopatias'];
    }
    if (isset($_POST['dermatopatias'])) {
        $alteraciones = $_POST['dermatopatias'];
    }
    if (isset($_POST['prominenciasOseas'])) {
        $alteraciones = $_POST['prominenciasOseas'];
    }
    if (isset($_POST['altDigitales'])) {
        $alteraciones = $_POST['altDigitales'];
    }
    if (isset($_POST['dx'])) {
        $dx = $_POST['dx'];
        // tabla 3 table-tratamiento
    }
    if (isset($_POST['tratamiento'])) {
        $tratamiento = $_POST['tratamiento'];
    }
    if (isset($_POST['receta'])) {
        $tratamientoTale = $_POST['receta'];
        //tabla 4 seguimiento
    }
    if (isset($_POST['fecha'])) {
        $seguimiento = $_POST['fecha'];
    }
    if (isset($_POST['seguimiento'])) {
        $observaciones = $_POST['seguimiento'];
    }

     //se obtendra el array de patologias seleccionadas
     if (isset($_POST['patologias'])) {
        $arrayPatologias = $_POST['patologias'];
    }

    

    


    //para validar la imagen--------------------------

    // Validar el tipo de archivo
    $tipoArchivo = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    $tiposPermitidos = ['jpg', 'jpeg', 'png', 'pdf'];

    if (!in_array($tipoArchivo, $tiposPermitidos)) {
        echo "Tipo de archivo no permitido.";
        exit;
    }

    //si no exite el directorio, lo crea
    $directorioDestino = "/Codigo/validaciones/historialClinico/historiales/";
    if (!is_dir($directorioDestino)) {
        if (!mkdir($directorioDestino, 0777, true)) {
            echo "Error al crear el directorio de destino.";
            exit;
        }
    }
    $nombreArchivo = $_FILES['archivo']['name'];
    $tamanoArchivo = $_FILES['archivo']['size'];
    $tipoArchivo = $_FILES['archivo']['type'];
    $rutaTemporal = $_FILES['archivo']['tmp_name'];
    $directorioRelativo = '/Codigo/validaciones/historialClinico/historiales/';
    $rutaDestino = $directorioDestino . basename($nombreArchivo);

    // Validar el tamaño del archivo 
    $tamanoMaximo = 2 * 1024 * 1024; // 2MB
    if ($archivo['size'] > $tamanoMaximo) {
        echo "El archivo es demasiado grande. El tamaño máximo permitido es de 2MB.";
        exit;
    }

    // Guardar el archivo en el servidor 
    if (!move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
        echo "Error al mover el archivo.";
        exit;
    }

    //para validar la imagen-------------------------



}
