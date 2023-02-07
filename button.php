<?php
  $files = $_FILES["file"]["name"];
  $files_tmp = $_FILES["file"]["tmp_name"];
  $files_error = $_FILES["file"]["error"];
  $files_size = $_FILES["file"]["size"];
//   print_r($files);
// exit();
  $dir = $_SERVER[ 'DOCUMENT_ROOT']."/uploads/";

  if (!file_exists($dir)) {
    echo $dir;
    mkdir($dir, 0777, true);
    $target_dir = $dir;
  } elseif (file_exists($dir)) {
    $target_dir = $dir;
  }
  $target_file = $target_dir . basename($files);
  $uploadOk = 1;

  $FileType =  strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if file already exists
  if (file_exists($target_file)) {
    echo "Данный файл уже загружен!";
    $uploadOk = 0;
  }
  
  
  // Check file size
  if ($files_size > 200000000) {
    $uploadOk = 0;
    echo "Размер файла должен быть не более 20мб (можно установить своё значение, или убрать ограничение";
  }
  
  // Allow certain file formats
  if($FileType != "xlsx") {
    $uploadOk = 0;
    echo "Расширение файла должно быть xlsx";
  }
  
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    
  // if everything is ok, try to upload file
  } else {
    $moved = move_uploaded_file($files_tmp, $target_file);
    if( $moved ) {
      $file_output = str_replace($_SERVER[ 'DOCUMENT_ROOT']."/uploads/", '', $target_file);

        $mysql = new mysqli('localhost', 'u1870963_default', '93HgEE7or1RrVHow', 'u1870963_default');
        $result = $mysql->query("SHOW TABLES FROM u1870963_default LIKE 'uploads'");
            $user = $result->fetch_assoc();
            if (empty($user)) {
                $sql = "CREATE TABLE `uploads` (
                    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    file VARCHAR(255) NOT NULL
                    )";
            if ($mysql->query($sql) === TRUE) {
                } else {
                // echo "Error creating table: " . $mysql->error;
                exit();
                }
            }  
        $mysql->close();
        $file = filter_var(trim($files), FILTER_SANITIZE_STRING); 

        $mysql = new mysqli('localhost', 'u1870963_default', '93HgEE7or1RrVHow', 'u1870963_default');
        $result = $mysql->query("SELECT * FROM `uploads` WHERE `file` = '$file'");
        $user = $result->fetch_assoc(); // Конвертируем в массив
        if (empty($user)) {
            $mysql->close();
            $mysql = new mysqli('localhost', 'u1870963_default', '93HgEE7or1RrVHow', 'u1870963_default');
            $sql = "INSERT INTO `uploads` (file) VALUES ('$file')";
        if($mysql->query($sql) === TRUE){
            // echo "Файл успешно добавлен!";
            $mysql->close();
        } else{
            echo "Ошибка: " . $mysql->error;
            $mysql->close();
            exit();
        } 
      }


      echo "Файл успешно загружен!";
      // echo $files;
    } else {
      echo " Файл не загружен ошибка #".$files_error;
    //   echo "Not";
    }
  }


?>
