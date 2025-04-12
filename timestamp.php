<?php

$nextWeek = time() + (7 * 24 * 60 * 60);// 7 дней; 24 часа; 60 минут; 60 секунд
echo 'Сейчас:           '. date('Y-m-d') ."<BR>\n";
echo 'Следующая неделя: '. date('Y-m-d', $nextWeek) ."<BR>\n";

// или с помощью strtotime():
echo '<hr>';
echo 'Следующая неделя: '. date('Y-m-d', strtotime('+1 week')) ."<BR>\n";
echo 'Сейчас:           '. date('Y-m-d H:i:s.u') ."<BR>\n";
echo 'Сейчас:           '. date('YmdHisu') ."<BR><BR>\n";

echo '<hr>';
$t = microtime(true);
$micro = sprintf("%06d", ($t - floor($t)) * 1000000);
$d = new DateTime(date('Y-m-d H:i:s.' . $micro, $t));
echo 'Сейчас:           '. $d->format("Y-m-d H:i:s.u") ."<BR>\n";
echo 'Сейчас:           '. $d->format("YmdHisu") ."<BR>\n";

?>