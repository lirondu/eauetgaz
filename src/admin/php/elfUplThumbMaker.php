<?php 

if (!isset($_POST['op'])) {
    die();
}

error_reporting(0);

require_once '../phpThumb-1.7.13/phpthumb.class.php';


define('IMAGE_SIZE', 350);
define('IMAGES_BASE', "C:\Users\Liron\Documents\www\schwarz3\src\images\\");
//define('IMAGES_BASE', "/home7/lirondug/public_html/devsite1/images/");





if ($_POST['op'] == 'create-thumbnails') {
    $filesArray = explode(';', $_POST['files']);
    $success = true;
    $failedFiles = '';


    $m = [];
    $folder = '';
    $fileName = '';
    $fileExt = '';
    $winPathRgx = "/((?:\w:\\\\)(?:[\w-+=#$&]+\\\\)+)([\w-+=#$&]+\.\w+)/";
    $linuxPathRgx = "/((?:\/)(?:[\w-+=#$&]+\/)+)([\w-+=#$&]+\.\w+)/";


    foreach($filesArray as $file) {
        if (empty($file)) {
            continue;
        }

        $fileAbsPath = IMAGES_BASE.$file;
        $imgSize = getimagesize($fileAbsPath);
        $sizeParam = ($imgSize[0] >= $imgSize[1]) ? 'w' : 'h';

        if (preg_match($winPathRgx, $fileAbsPath, $m)) {
            $folder = $m[1];
            $fileName = $m[2];
        } else if (preg_match($linuxPathRgx, $fileAbsPath, $m)) {
            $folder = $m[1];
            $fileName = $m[2];
        } else {
            $success = false;
            $failedFiles .= $file.' - File name or path not understood, try to rename;';
            continue;
        }


        $thumbFolder = $folder.'/thumbs/';
        $output_filename = $thumbFolder.$fileName;


        if (!file_exists($thumbFolder)) {
            if (!mkdir($thumbFolder, 0777, true)) {
                $success = false;
                $failedFiles .= $file.' - Failed creating '.$thumbFolder.';';
                continue;
            }
        }

        $phpThumb = new phpThumb();

        $phpThumb->setSourceData(file_get_contents($fileAbsPath));
        $phpThumb->setParameter($sizeParam, IMAGE_SIZE);
        $phpThumb->setParameter('q', 100);

        if ($phpThumb->GenerateThumbnail()) {
            if (!$phpThumb->RenderToFile($output_filename)) {
                $success = false;
                $failedFiles .= $file.' - Rendering image error;';
            }
            $phpThumb->purgeTempFiles();
        } else {
            $success = false;
            $failedFiles .= $file.' - Generate thumb file error;';
        }
    }


    echo($success) ? '1' : $failedFiles;
    return;
}