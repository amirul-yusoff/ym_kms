<?php

$name = $_FILES["file"]["name"];
$type = $_FILES["file"]["type"];
$size = $_FILES["file"]["size"];
$temp = $_FILES["file"]["tmp_name"];
$error = $_FILES["file"]["error"];
$logAll = true;

$original_id = $_POST['original_id'];
$original_filename = $_POST['original_filename'];
$original_hash = $_POST['original_hash'];
$original_extension = $_POST['original_extension'];
$original_mimetype = $_POST['original_mimetype'];
$original_size = $_POST['original_size'];
$original_upload_by = $_POST['original_upload_by'];
$carbon_now_data = $_POST['original_carbon_now_data'];
$document_type = $_POST['original_document_type'];
$tbl = $_POST['original_db_table'];
$folder = $_POST['original_folder_name'];
$id_field_name = $_POST['original_id_file_name'];

$DB_SERVER='172.16.0.24';
$DB_USER='root';
$DB_PASS='mgcaoKYwfnr4omRCUloQ';
$DB_DATABASE='subcon_kms';
$DB_PORT=3306;

$file_url = 'http://powercomputer.ds.jatitinggi.com/upload/project/subcon_kms/';
$module_name = ".$folder.";

if ($error > 0) {
    echo json_encode(array("Response" => array("responseCode" => -100, "responseMessage" => "File Error")));
    if ($logAll)
        write_log("failed at 0 - cause loop previously" . $error);
    die("Error uploading file! code $error.");
} else {
    if ($size > 100000000) {
        echo json_encode(array("Response" => array("responseCode" => 200, "responseMessage" => "File Size is too Big")));
        if ($logAll)
            write_log("Client Uploading file size that's too big - cause loop previously");
    } else {
        $imageCreateDate = date("Y-m-d-H-i-s");

        $file_url = "http://powercomputer.ds.jatitinggi.com/upload/project/kms/" . $module_name;
        $file_path = "/volume1/Photo/project/kms/" . $module_name;
        if (!file_exists($file_path)) {
            if (!mkdir($file_path, 0777, true)) {
                echo json_encode(array("Response" => array("responseCode" => -100, "responseMessage" => "Unable to create directory:" . $file_path)));
                write_log("failed at 2 directory error, this error should not happen");
                die();
            }
        } else {
            // Added new codes if somehow, the client is sending a picture that already existed, send back response 200 as well
            echo json_encode(array("Response" => array("responseCode" => 200, "responseMessage" => "File successfully uploaded.")));
            write_log("Client tried to reupload files that exist");
        }

        // Generate a unique hashed name for the file (without the file extension), limited to 25 characters
        $originalFileName = $name;
        $fileNameWithoutExtension = pathinfo($originalFileName, PATHINFO_FILENAME);
        $hashedFileName = substr(sha1($fileNameWithoutExtension), 0, 25);

        // Get the file extension
        $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);

        // Combine the hashed name and the file extension to create the final file name
        $hashedFileNameWithExtension = $hashedFileName . '.' . $fileExtension;

        // Debugging statement to check the content of $_FILES
        print_r($_FILES);
        
        $newFileName = $imageCreateDate . "_" . $hashedFileNameWithExtension;
        $moved = move_uploaded_file($temp, $file_path . "/" . $newFileName);

        if ($logAll) {
            write_log("This is where the file is permanently stored 2");
            write_log("Temp location " . $temp);
            write_log("File Name " . $name);
            write_log("Target location " . $file_path . "/" . $newFileName);
            write_log("Target location URL " . $file_url . "/" . $newFileName);
            $location = $file_url . "/" . $newFileName;
        }
        
        if ($moved) {
            if ($logAll)
                write_log("Successfully uploaded");
            echo json_encode(array("Response" => array("responseCode" => 200, "responseMessage" => "File successfully uploaded.")));

            write_log("DB Insert String ");

            $conn = new MySQLi($DB_SERVER,$DB_USER,$DB_PASS,$DB_DATABASE,$DB_PORT);
            if ($conn->connect_error) {
                echo json_encode(array("Response" => array("responseCode" => -100, "responseMessage" => "DB connection failed")));
                    write_log("DB Connection Failed 15-11-21".$conn->connect_error);
                    die();
            }
            else
            {
                write_log("DB Connection Succeeded 15-11-21, Parsing Image Parameters");
            }

            // Create an array with the required data for the database insertion
            $ids = array(
                'tbl' => $tbl,
                'original_id' => $original_id,
                'id_field_name' => $id_field_name,
                'original_filename' => $original_filename,
                'original_hash' => $original_hash,
                'original_extension' => $original_extension,
                'original_mimetype' => $original_mimetype,
                'original_size' => $original_size,
                'original_upload_by' => $original_upload_by,
                'original_carbon_now_data' => $carbon_now_data,
                'original_document_type' => $document_type,
            );

            // Logging the content of $ids
            write_log(print_r($ids, true));
            write_log($_POST);
            write_log($_POST['ids']);
            write_log($_POST['tbl']);
            write_log($_POST['id_field_name']);
            write_log($_POST['original_id']);
            write_log($_POST['original_filename']);
            write_log($_POST['original_hash']);
            write_log($_POST['original_extension']);
            write_log($_POST['original_mimetype']);
            write_log($_POST['original_size']);
            write_log($_POST['original_upload_by']);
            write_log($_POST['original_carbon_now_data']);
            write_log($_POST['original_document_type']);

            write_log("DB Insert String INSERT INTO ".$ids['tbl']."(".$ids['id_field_name'].",filename,extension,size,path,upload_by,created_at,updated_at,is_deleted,hash,file_type,document_type,url) VALUES (".
            "'".$ids['original_id']."',".
            "'".$ids['original_filename']."',".
            "'".$ids['original_extension']."',".
            "'".$ids['original_size']."',".
            "'' ,". // Empty path since it's not set in the code
            "'".$ids['original_upload_by']."',".
            "'".$ids['original_carbon_now_data']."',".
            "'".$ids['original_carbon_now_data']."',".
            "'0',".
            "'".$ids['original_hash']."',".
            "'".$ids['original_mimetype']."',".
            "'".$ids['original_document_type']."',".
            "'".$location."'".
            ")");
            $insertQuery = $conn->query("INSERT INTO ".$ids['tbl']."(".$ids['id_field_name'].",filename,extension,size,path,upload_by,created_at,updated_at,is_deleted,hash,file_type,document_type,url) VALUES (".
            "'".$ids['original_id']."',".
            "'".$ids['original_filename']."',".
            "'".$ids['original_extension']."',".
            "'".$ids['original_size']."',".
            "'' ,". // Empty path since it's not set in the code
            "'".$ids['original_upload_by']."',".
            "'".$ids['original_carbon_now_data']."',".
            "'".$ids['original_carbon_now_data']."',".
            "'0',".
            "'".$ids['original_hash']."',".
            "'".$ids['original_mimetype']."',".
            "'".$ids['original_document_type']."',".
            "'".$location."'".
            ")");


        } else {
            echo json_encode(array("Response" => array("responseCode" => 200, "responseMessage" => "File upload failed.")));
            if ($logAll)
                write_log("Failed at Step 4 - Move uploaded file failed: " . $_FILES["file"]["error"] . " - " . error_get_last()['message']);
        }
    }
}

function write_log($log_msg)
{
    $log_filename = 'log';

    if (!file_exists($log_filename)) {
        mkdir($log_filename, 0777, true);
    }
    $log_file_date = $log_filename . '/log_' . date('d-M-Y') . '.log';
    file_put_contents($log_file_date, date('Y-m-d h:i:sa') . ' ' . $log_msg . "\r\n", FILE_APPEND);
}
