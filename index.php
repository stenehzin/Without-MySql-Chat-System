html
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Mesajlaşma Uygulaması</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<style>
.chat-box {
  height: 500px;
  overflow-y: scroll;
}
.message-form {
  position: fixed;
  bottom: 20px;
}
</style>

</head>
<body>

<div class="container mt-5">
<h3 class="text-center">Mesajlaşma Uygulaması</h3><hr>

<!-- Mesaj kutusu div'i -->
<div id="chat-box" class="chat-box border p-3 mb-5"></div>

<form id='messageForm' method='post' action='./send_message.php' enctype='multipart/form-data'>
    <!-- Kullanıcı adını girmek için alan -->
  	<input type='text' name='username' placeholder='Kullanıcı Adınız...' required />
  	
  	<!-- Gönderilecek mesajın metin alanı -->
  	<textarea name='messageText' placeholder='Mesajınızı girin...' required></textarea>
  	
  	<!-- Dosya göndermek için gerekli input alanı -->
  	<input type='file' name='file' id='file'>
  	
  	<!-- Mesaj gönder düğmesi -->
    <button type="submit" class="btn btn-primary">Gönder</button>
</form>

</div><!-- container -->

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

 </body>
 </html>

<script>
window.addEventListener('DOMContentLoaded', () => {
const messagesElemet=document.getElementById("chat-box");
fetch('./messages.json')
.then(response=>response.json())
.then(data=>{
  data.forEach(item=>{
  
let messageElem=document.createElement("div");
messageElem.className="received-message p-2 my-2 rounded";

let messageContent=`
  <strong>${item.username}:</strong> ${item.messageText}<br>
  <small class="text-muted">${item.timestamp}</small>
`;
    //Eğer varsa dosya URL'sini ekle
if(item.fileURL) {
messageContent+=`
<br><a href='${item.fileURL}' target='_blank'>Gönderilen Dosya</a>`;
}

messageElem.innerHTML=messageContent;
messagesElemet.appendChild(messageElem);

// Mesaj kutusunu aşağı kaydır(scrollda)
messagesElement.scrollTop = messagesElement.scrollHeight;
});
  
})
.catch(error=>{
  console.error("Hata: ",error);
});

});

</script>
