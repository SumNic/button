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
<p id="demo"></p> 
<p id="list"></p> 
<script>
  // console.log(window.location.pathname);
    function fileLoad() {
      
      var formData = new FormData(document.forms.button);
      

      const xhttp = new XMLHttpRequest();
      xhttp.onload = function() {
        const respons = this.responseText;
        
          demo.innerHTML = respons;
          fileList();
        }
      xhttp.open("POST", "button.php", true);
      xhttp.send(formData);
    }
    function fileList() {
  
      var x = 5;
      var list = document.getElementById('list');
      

      const xhttp = new XMLHttpRequest();
      xhttp.onload = function() {
        const respons = this.responseText;
        list.innerHTML = respons;
        }
      xhttp.open("POST", "list.php", true);
      xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhttp.send('x=' + x);
    }

    fileList();
</script> 
</body>
</html>
