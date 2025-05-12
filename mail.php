<?php

//mail("E-mail получателя", "Загаловок", "Текст письма \n 1-ая строчка \n 2-ая строчка \n 3-ая строчка"); 

    $to      = 'dvpt@narod.ru';
    $subject = 'the subject';    
    $message = 'hello';    
    $headers = 'From:'. "\r\n" ."Reply-To:"."\r\n" .'X-Mailer: PHP/'.phpversion();    
    mail($to, $subject, $message, $headers);

$b = mail("dvpt@mail.ru", "Загаловок", "Текст письма \n 1-ая строчка \n 2-ая строчка \n 3-ая строчка"); 
echo "b = $b <br>";

$to      = 'dvpt@yandex.ru';
$subject = 'Sending an HTML email using mail() in PHP';
$message = '<html><body><p><b>This paragraph is bold.</b></p><p><i>This text is italic.</i></p></body></html>';
$headers = implode("\r\n", [
    "From: John Conde <webmaster@familytree.ru>",
    "Reply-To: webmaster@example.com",
    "X-Mailer: PHP/" . PHP_VERSION,
    "MIME-Version: 1.0",
    "Content-Type: text/html; charset=UTF-8"
]);
$result = mail($to, $subject, $message, $headers);
echo "result = $result <br>";


?>