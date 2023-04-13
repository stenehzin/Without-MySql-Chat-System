<?php

$messages_file = __DIR__.'/messages.json';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // Kullanıcıdan alınan veriler
  $username = htmlspecialchars($_POST['username']);
  $messageText = htmlspecialchars($_POST['messageText']);

// Şu anki tarih ve saat bilgisi
  date_default_timezone_set('Europe/Istanbul');
  $timestamp = date("Y-m-d H:i:s");

// İlgili fişleri saklamak için
$fileURL = '';

if(isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $uploads_dir = 'uploads';
    if (!is_dir($uploads_dir)) mkdir($uploads_dir, 0777);
    
    $tmp_name = $_FILES["file"]["tmp_name"];
        // FIXME: Burada daha güçlü bir dosya adı üretme işlemi ile güvenliği artırabilirsiniz.
    $name = basename($_FILES["file"]["name"]);
    if(move_uploaded_file($tmp_name, "$uploads_dir/$name")) {
        // Dosyanın URL'sini al
        $fileURL = "http://$_SERVER[HTTP_HOST]/$uploads_dir/$name";
  }
}

$messageData = [
      'username' => $username,
      'messageText' => $messageText,
          'timestamp' => $timestamp,
      'fileURL' => $fileURL
  ];

// Mevcut mesajları oku
  if (is_readable($messages_file)) {
$json_data = file_get_contents($messages_file);
    } else {
$json_data = "[]";
    }

$messages_array = json_decode($json_data, true);

array_push($messages_array, $messageData);

$new_json_data = json_encode($messages_array);
      
if(file_put_contents( __DIR__.'/messages.json', $new_json_data)){
	header('Location: ./index.php');
	exit;
} else{
	echo "Bir şeyler yanlış gitti ve mesajınız gönderilemedi. Lütfen tekrar deneyin.";
}
}

?>
