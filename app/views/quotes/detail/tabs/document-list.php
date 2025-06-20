<?php
$dir = "uploads/assets/$id/";
$files = array_diff(scandir($dir), array('.', '..')); // lista archivos ignorando '.' y '..'

if (count($files) === 0) {
    echo '<script>document.getElementById("noDocumentsMessage").classList.remove("hidden");</script>';
} else {
    foreach ($files as $file) {
        $filePath = $dir . $file;
        $fileType = mime_content_type($filePath);
        $fileSize = filesize($filePath); // en bytes
        $fileDate = date("d/m/Y H:i:s", filemtime($filePath));

        // Puedes convertir tamaño a KB o MB para mejor lectura:
        if ($fileSize < 1024) {
            $sizeFormatted = $fileSize . " B";
        } elseif ($fileSize < 1048576) {
            $sizeFormatted = round($fileSize / 1024, 2) . " KB";
        } else {
            $sizeFormatted = round($fileSize / 1048576, 2) . " MB";
        }

        echo "<tr>";
        echo "<td>{$file}</td>";
        echo "<td>{$fileType}</td>";
        echo "<td>{$sizeFormatted}</td>";
        echo "<td>{$fileDate}</td>";
        echo "<td>
                <a href='{$filePath}' target='_blank' class='text-blue-600 hover:underline'>Ver</a> | 
                <a href='delete.php?file={$file}' onclick='return confirm(\"¿Seguro que quieres eliminar este documento?\");' class='text-red-600 hover:underline'>Eliminar</a>
              </td>";
        echo "</tr>";
    }
}
?>