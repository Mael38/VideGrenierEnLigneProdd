<?php

namespace App\Utility;

class Upload {


    public static function uploadFile($file, $fileName)
    {
        // Vérifier si le fichier a été correctement uploadé
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            throw new \Exception("Aucun fichier n'a été uploadé");
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception("Erreur lors de l'upload du fichier: " . $file['error']);
        }

        $currentDirectory = getcwd();
        
        // En mode test, utiliser un répertoire spécifique
        if (defined('PHPUNIT_RUNNING')) {
            $uploadDirectory = "/storage/";
        } else {
            $uploadDirectory = "/storage/";
        }

        $fileExtensionsAllowed = ['jpeg', 'jpg', 'png'];

        $fileSize = $file['size'];
        $fileTmpName = $file['tmp_name'];

        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $pictureName = basename($fileName . '.'. $fileExtension);

        $uploadPath = $currentDirectory . $uploadDirectory . $pictureName;

        // Créer le répertoire s'il n'existe pas
        $uploadDir = dirname($uploadPath);
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (!in_array($fileExtension, $fileExtensionsAllowed)) {
            throw new \Exception("This file extension is not allowed. Please upload a JPEG or PNG file");
        }

        if ($fileSize > 4000000) {
            throw new \Exception("File exceeds maximum size (4MB)");
        }

        // En mode test, utiliser copy() au lieu de move_uploaded_file()
        if (defined('PHPUNIT_RUNNING')) {
            $didUpload = copy($fileTmpName, $uploadPath);
        } else {
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
        }

        if ($didUpload) {
            return $pictureName;
        } else {
            throw new \Exception("An error occurred. Please contact the administrator.");
        }
    }
}
