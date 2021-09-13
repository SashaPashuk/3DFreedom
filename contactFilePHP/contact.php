<?php
if (isset ($_POST['name'])) {
  $to = "3dfreedomcorp@gmail.com";
  $from = "3d-freedom";
  $subject = "Заповнена контактна форма на сайті ".$_SERVER['HTTP_REFERER'];
  $message = "\nІм'я користувача: ".$_POST['name']."\nEmail користувача ".$_POST['email']."\nВиди пластика: ".$_POST['plastic-types']."\nЯкість друку: ".$_POST['quality']."\nКолір пластику: ".$_POST['color']."\nПовідомлення: ".$_POST['message']."\n\nАдреса сайту: https://3d-freedom.com/";
 
  $boundary = md5(date('r', time()));
  $filesize = '';
  $headers = "MIME-Version: 1.0\r\n";
  $headers .= "From: " . $from . "\r\n";
  $headers .= "Reply-To: " . $from . "\r\n";
  $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
  $message="
Content-Type: multipart/mixed; boundary=\"$boundary\"
 
--$boundary
Content-Type: text/plain; charset=\"utf-8\"
Content-Transfer-Encoding: 7bit
 
$message";
     if(is_uploaded_file($_FILES['fileFF']['tmp_name'])) {
         $attachment = chunk_split(base64_encode(file_get_contents($_FILES['fileFF']['tmp_name'])));
         $filename = $_FILES['fileFF']['name'];
         $filetype = $_FILES['fileFF']['type'];
         $filesize = $_FILES['fileFF']['size'];
         $message.="
 
--$boundary
Content-Type: \"$filetype\"; name=\"$filename\"
Content-Transfer-Encoding: base64
Content-Disposition: attachment; filename=\"$filename\"
 
$attachment";
     }
  $message.="
--$boundary--";
 
  if ($filesize < 10000000) { // проверка на общий размер всех файлов. Многие почтовые сервисы не принимают вложения больше 10 МБ
    mail($to, $subject, $message, $headers);
    echo $_POST['name'].', Ваше повідомлення відправлено, дякуємо!';
  } else {
    echo 'Вибачте, лист не відправлено. Розмір всіх файлів перевищує 10 МБ.';
  }
}
?>