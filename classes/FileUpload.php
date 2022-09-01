<?php 
        // Uniqueid() and file_exists can conflict as the validadeImage hasn't got the uniqueid() as well
    class FileUpload  
    {
        static $target_dir = "./uploads/";

        static function validadeImage($fileInputName, $debug= false){
            
            $target_file = self::$target_dir . basename($_FILES[$fileInputName]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image

            $check = getimagesize($_FILES[$fileInputName]["tmp_name"]);
            if($check !== false) {
                if($debug) echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                if($debug) echo "File is not an image.";
                $uploadOk = 0;
            }
            if($debug){
                echo "<pre>";
                print_r($_FILES);
                echo "</pre>";
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                if($debug) echo "Sorry, file already exists.";
                $uploadOk = 0;
            }
            
            // Check file size
            if (intval($_FILES[$fileInputName]["size"]) / 1024 > 1500) {
                if($debug) echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            
            // Allow certain file formats
            if($imageFileType != "jpg" && 
                $imageFileType != "png" && 
                $imageFileType != "jpeg" && 
                $imageFileType != "webp" && 
                $imageFileType != "gif" ) {
                    if($debug) echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            return $uploadOk;
        }

        static function uploadImage($fileInputName, $debug= true){
            $uniqueFileName = uniqid() . '.' . strtolower(pathinfo($_FILES[$fileInputName]["name"],PATHINFO_EXTENSION));
            $target_file = self::$target_dir . basename($uniqueFileName);
            // $target_file = self::$target_dir . basename($_FILES[$fileInputName]["name"]);

            if(self::validadeImage($fileInputName) == 0){
                if($debug)  echo "Sorry, your file was not uploaded.";
            } else {
                if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $target_file)) {
                    echo "The file ". htmlspecialchars( basename( $_FILES[$fileInputName]["name"])). " has been uploaded.";
                    return $uniqueFileName;
                } else {
                    if($debug) echo "Sorry, there was an error uploading your file.";
                    return false;
                }
            }
        }
        static function deleteFIle($file){
            @unlink(self::$target_dir . $file);
        }

    }
    

?>