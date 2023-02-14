<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form name="button" id="button">
    <input type="file" name="file">
    <input type="reset" value="Загрузить" onclick="fileLoad()">
</form>  
<div id="demo"></div> 
<p id="list"></p> 
<script>
  // console.log(window.location.pathname);
    function fileLoad() {
      
      const formData = new FormData(document.forms.button);
      var demo = document.getElementById('demo');
      

      const xhttp = new XMLHttpRequest();
      xhttp.onload = function() {
        const respons = this.responseText;
        if (respons === ''){
          alert('Файл не загружен. Проверте шаблон JSON таблицы');
        }
          alert(respons);
          // demo.innerHTML = respons;
        }
      xhttp.open("POST", "button.php", true);
      xhttp.send(formData);
    }
    // function fileList() {
  
    //   const formData = new FormData(document.forms.button);
    //   var list = document.getElementById('list');
      

    //   const xhttp = new XMLHttpRequest();
    //   xhttp.onload = function() {
    //     const respons = this.responseText;
    //     list.innerHTML = respons;
    //     }
    //   xhttp.open("POST", "list.php", true);
    //   xhttp.send(formData);
    // }

    // fileList();
</script> 
</body>
</html>
