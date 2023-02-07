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
    <input type="reset" onclick="fileLoad()">
</form>   
<script>
    function sendMessage() {
  
  var formData = new FormData(document.forms.button);

  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    const respons = this.responseText;
    if (respons !== ""){
      div_message.style = "display:flex";
      message_message.innerHTML = respons;
      setTimeout(function() {
        div_message.style = "display:none";
      }, 2000);
    } else {
      // открывается отправленное сообщение
      setTimeout(openNewMesseg, 1000);смч
    }
  }
  document.getElementById("send_message").reset();
  xhttp.open("POST", "button.php", true);
  // xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhttp.send(formData);
}
</script> 
</body>
</html>
