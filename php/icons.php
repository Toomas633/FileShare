<?php
$extension = pathinfo($file, PATHINFO_EXTENSION);
switch ($extension) {
    case "jpg":
    case "jpeg":
    case "png":
    case "gif":
    case "bmp":
    case "webp":
        echo "<img src='uploads/$file' class='file-preview'>";
        break;
    case "pdf":
        echo "<img src='icons/pdf-icon.png' class='file-preview'>";
        break;
    case "doc":
    case "docx":
        echo "<img src='icons/doc-icon.png' class='file-preview'>";
        break;
    case 'txt':
    case 'log':
        $txtFilePath = DIR_PATH . 'uploads/' . $file;
        $txtContent = file_get_contents($txtFilePath);
        $image = imagecreatetruecolor(120, 120);
        $white = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $white);
        $text = file_get_contents($txtFilePath);
        $black = imagecolorallocate($image, 0, 0, 0);
        $font = 'fonts/arial.ttf';
        $fontSize = 4;
        $lines = explode("\n", $text);
        $y = $fontSize + 10;
        foreach ($lines as $line) {
            imagettftext($image, $fontSize, 0, 10, $y, $black, $font, $line);
            $y += $fontSize + 10;
        }
        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        echo "<img src='data:image/png;base64," . base64_encode($imageData) . "' class='file-preview'>";
        break;
    case "zip":
    case "7z":
        echo "<img src='icons/zip-icon.png' class='file-preview'>";
        break;
    case "rar":
    case "tgz":
    case "gz":
    case "bz2":
        echo "<img src='icons/rar-icon.png' class='file-preview'>";
        break;
    case "mp4":
    case "webm":
    case "ogg":
    case "mkv":
        echo "<img src='icons/video-icon.png' class='file-preview'>";
        break;
    case "wav":
    case "mp3":
        echo "<img src='icons/audio-icon.png' class='file-preview'>";
        break;
    case "exe":
    case "com":
    case "sys":
    case "ovl":
    case "msi":
        echo "<img src='icons/exe.png' class='file-preview'>";
        break;
    case "dll":
        echo "<img src='icons/dll.png' class='file-preview'>";
        break;
    case "svg":
        $filepath = DIR_PATH . 'uploads/' . $file;
        $file_contents = file_get_contents($filepath);
        echo "<img src='data:image/svg+xml;base64," . base64_encode($file_contents) . "' class='file-preview'>";
        break;
    case "html":
    case "htm":
        echo "<img src='icons/web.png' class='file-preview'>";
        break;
    case "stl":
        echo "<img src='icons/stl.png' class='file-preview'>";
        break;
    case "blend":
        echo "<img src='icons/blender.png' class='file-preview'>";
        break;
    case "fbx":
    case "3ds":
    case "dae":
    case "obj":
    case "u3d":
    case "x3d":
        echo "<img src='icons/3d.png' class='file-preview'>";
        break;
    case "js":
        echo "<img src='icons/js.png' class='file-preview'>";
        break;
    case "java":
        echo "<img src='icons/java.png' class='file-preview'>";
        break;
    case "c":
    case "cpp":
    case "cs":
        echo "<img src='icons/c.png' class='file-preview'>";
        break;
    case "css":
        echo "<img src='icons/css.png' class='file-preview'>";
        break;
    case "php":
        echo "<img src='icons/code.svg' class='file-preview'>";
        break;
    case "py":
        echo "<img src='icons/python.png' class='file-preview'>";
        break;
    case "xlsx":
    case "csv":
        echo "<img src='icons/excel-icon.png' class='file-preview'>";
        break;
    case "pptx":
        echo "<img src='icons/powerpoint-icon.png' class='file-preview'>";
        break;
    default:
        echo "<img src='icons/file-icon.png' class='file-preview'>";
}
