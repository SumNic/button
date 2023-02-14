<?php

  $files = $_FILES["file"]["name"];
  $files_tmp = $_FILES["file"]["tmp_name"];
  $files_error = $_FILES["file"]["error"];
  $files_size = $_FILES["file"]["size"];

  $dir = "/var/lib/mysql-files/";

  if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
    $target_dir = $dir;
  } elseif (file_exists($dir)) {
    $target_dir = $dir;
  }
  $target_file = $target_dir . basename($files);
  $uploadOk = 1;

  $FileType =  strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
   
  // Check if file already exists
  // if (file_exists($target_file)) {
  //   echo "Данный файл уже загружен!";
  //   $uploadOk = 0;
  // }
  
  
  // Check file size
//   if ($files_size > 200000000) {
//     $uploadOk = 0;
//     echo "Размер файла должен быть не более 20мб (можно установить своё значение, или убрать ограничение";
//   }
  
  // Allow certain file formats
  if($FileType != "csv") {
    $uploadOk = 0;
    echo "Расширение файла должно быть CSV";
    // echo '<script>alert("Расширение файла должно быть csv");</script>';
  }
  
  
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    exit();
    
  // if everything is ok, try to upload file
  } else {
    
    $moved = move_uploaded_file($files_tmp, $target_file);
    if( $moved ) {
      goto lis;
    } else {
      echo " Файл не загружен ошибка #".$files_error;
      exit();
    }
  }


lis:  
  
  $File = $files;
  $sFile = '/var/lib/mysql-files/'.$File;  
  $ourData = file_get_contents("tables_layout.json");  
  $object = json_decode($ourData);
  $strint_table = '';
  $strint_kay = '';
  $strint_kay_out_id = '';
  $strint_load_str = '(';
  $strint_set = '';
  
  $col = "A";
  foreach($object as $name=>$sign){
    // количество пропускаемых строчек
    if ($name == 'ignor'){
      $ignor = $sign;
    } else {
      // названия колонок в таблице без id и обозначение колонок в файле CSV 
      if ($name == 'id'){
        $strint_kay_out_id = $strint_kay_out_id.'';
        $strint_load_str = $strint_load_str.'';
      } else {
        $strint_kay_out_id = $strint_kay_out_id.$name.',';
        $strint_load_str = $strint_load_str.'@'.$name.',';
      }
      // значения SET
      if (strpos($name, 'date') !== false){
        $strint_set = $strint_set.$name."=STR_TO_DATE(@'".$name."', '%d.%m.%Y %H:%i:%s'), ";
      } else if (strpos($name, 'number') !== false){
        $strint_set = $strint_set.$name.'= NULLIF(@'.$name.', 0), ';
      } else if (strpos($name, 'text') !== false){
        $strint_set = $strint_set.$name.'= NULLIF(@'.$name.', "null"), ';
      }
      $strint_kay = $strint_kay.$name.',';
      $strint_table = $strint_table.$name.' '.$sign.',';
      $col++;
    }
    
  }
  $col = chr(ord($col)-2);
  $strint_kay_out_id = rtrim($strint_kay_out_id, ',');
  $strint_kay = rtrim($strint_kay, ',');
  $strint_table = rtrim($strint_table, ',');
  $strint_load_str = substr_replace($strint_load_str, ')', -1, strlen($strint_load_str));
  $strint_set = rtrim($strint_set, ', ');
  
  $mysql = new mysqli('localhost', 'u1870963_default', '93HgEE7or1RrVHow', 'button');
          $result = $mysql->query("SHOW TABLES FROM button LIKE '$File'");
              $user = $result->fetch_assoc();
              if (empty($user)) {
                $sql = "CREATE TABLE `$File` ($strint_table)";
                if ($mysql->query($sql) === TRUE) {
                    $mysql->close();
                      $mysql = new mysqli('localhost', 'u1870963_default', '93HgEE7or1RrVHow', 'button');
                      $sql = "LOAD DATA INFILE '$sFile' 
                              INTO TABLE `$File` 
                              FIELDS TERMINATED BY ';'
                              LINES TERMINATED BY '\n'  
                              IGNORE $ignor LINES
                              $strint_load_str
                              SET $strint_set";
                                if ($mysql->query($sql) === TRUE) {
                                  echo 'Файл '.$File.' загружен успешно';
                                } else {
                                  echo "Файл не загружен. Ошибка: " . $mysql->error;
                                }
                    } else {
                      echo "Файл не загружен. Ошибка: " . $mysql->error;
                    exit();
                    }
              } else {
                $sql = "DROP TABLE `$File`";
                if ($mysql->query($sql) === TRUE) {
                  $mysql->close();
                      $mysql = new mysqli('localhost', 'u1870963_default', '93HgEE7or1RrVHow', 'button');
                  $sql = "CREATE TABLE `$File` ($strint_table)";
                  if ($mysql->query($sql) === TRUE) {
                    
                      $mysql = new mysqli('localhost', 'u1870963_default', '93HgEE7or1RrVHow', 'button');
                      $sql = "LOAD DATA INFILE '$sFile' 
                      INTO TABLE `$File` 
                      FIELDS TERMINATED BY ';'
                      LINES TERMINATED BY '\n' 
                      IGNORE $ignor LINES 
                      $strint_load_str
                      SET $strint_set";
                      echo $sql;
                    if ($mysql->query($sql) === TRUE) {
                      echo 'Файл '.$File.' загружен успешно';
                    } else {
                      echo "Файл не загружен. Ошибка: " . $mysql->error;
                    }
                  } else {
                    echo "Файл не загружен. Ошибка: " . $mysql->error;
                    exit();
                  }
                }
              }
          $mysql->close();

  // $mysql = new mysqli('localhost', 'u1870963_default', '93HgEE7or1RrVHow', 'button');
  // $result = $mysql->query("SELECT * FROM `$File`");
  //   while($user = $result->fetch_array(MYSQLI_ASSOC)){
  //     echo $user['date'].'<br>';
  //   }

  





