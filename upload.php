<?php
// RESPONSE FUNCTION
function index($ok = 1, $info = "")
{
    // THROW A 400 ERROR ON FAILURE
    if ($ok == 0) {
        http_response_code(400);
    }
    die(json_encode(["ok" => $ok, "info" => $info]));
}

// INVALID UPLOAD
if (empty($_FILES) || $_FILES['file']['error']) {
    index(0, "Failed to move uploaded file.");
}

// THE UPLOAD DESTINATION - CHANGE THIS TO YOUR OWN
$filePath = __DIR__ . DIRECTORY_SEPARATOR . "uploads";

if (!file_exists($filePath)) {
    if (!mkdir($filePath, 0777, true)) {
        index(0, "Failed to create $filePath");
    }
}

$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : $_FILES["file"]["name"];
$filePath = $filePath . DIRECTORY_SEPARATOR . $fileName;

// DEAL WITH CHUNKS
$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
$out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");

if ($out) {
    $in = @fopen($_FILES['file']['tmp_name'], "rb");

    if ($in) {
        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }
    } else {
        index(0, "Failed to open input stream");
    }

    @fclose($in);
    @fclose($out);
    @unlink($_FILES['file']['tmp_name']);

} else {
    index(0, "Failed to open output stream");
}

// CHECK IF FILE HAS BEEN UPLOADED
if (!$chunks || $chunk == $chunks - 1) {
    // Use move_uploaded_file to move the uploaded file to its final destination
    if (!move_uploaded_file("{$filePath}.part", $filePath)) {
        index(0, "Failed to move uploaded file to final destination");
    }
}

index(1, "Upload OK");
?>