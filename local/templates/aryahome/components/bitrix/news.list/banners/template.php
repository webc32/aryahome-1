<?
$this->setFrameMode(true);
$templateFolder = $this->GetFolder();
?>

<? foreach($arResult["ITEMS"] as $item): ?>
  <?
  if ($USER->IsAdmin()){
  // echo "<pre>";
  // print_r($item);
  // echo "</pre>";
  }
  ?>
  <a href="<?=$item["PROPERTIES"]["link"]["VALUE"]?>" class="position-relative d-block z-index-2 w-100">
    <?
      if ($item["PROPERTIES"]["timer"]["VALUE"] == 'да') {
    ?>
    <div class="timer-2 d-flex flex-wrap justify-content-center">
      <div class="title-time text-black text-uppercase mr-2 d-flex flex-column justify-content-center">
        Осталось:
      </div>
      <div class="timer-box">
        <div class="timer-new">
          <ul class="d-flex">
            <li class="days-<?=$item["ID"]?>">00</li>
            <li class="hours-<?=$item["ID"]?>">00</li>
            <li class="minutes-<?=$item["ID"]?>">00</li>
            <li class="seconds-<?=$item["ID"]?>">00</li>
          </ul>
        </div>
        <ul class="d-flex time-name">
          <li>дни</li>
          <li>часы</li>
          <li>минуты</li>
          <li>секунды</li>
        </ul>
      </div>
    </div>
    <?
      }
    ?>
  </a>
  <?
  $Y = PHPFormatDateTime($item["DATE_ACTIVE_TO"], "Y");
  $m = PHPFormatDateTime($item["DATE_ACTIVE_TO"], "m");
  $d = PHPFormatDateTime($item["DATE_ACTIVE_TO"], "d");
  $H = PHPFormatDateTime($item["DATE_ACTIVE_TO"], "H");
  $i = PHPFormatDateTime($item["DATE_ACTIVE_TO"], "i");
  $s = PHPFormatDateTime($item["DATE_ACTIVE_TO"], "s");
  $m = $m - 1;
  ?>
  <div class=" d-md-block d-none" date="<?=$Y.",".$m.",".$d.",".$H.",".$i.",".$s;?>">
    <a href="<?=$item["PROPERTIES"]["link"]["VALUE"]?>">
      <img class="w-100" src="<?=$item["DETAIL_PICTURE"]["SRC"]?>"> 
    </a> 
  </div>
  <div class="d-md-none d-block">
    <a href="<?=$item["PROPERTIES"]["link"]["VALUE"]?>">
      <img class="w-100" src="<?=$item["PREVIEW_PICTURE"]["SRC"]?>">
    </a>  
  </div>
  <?
    if ($item["PROPERTIES"]["timer"]["VALUE"] == 'да') {
  ?>
  <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
      // конечная дата, например 1 июля 2023
      const deadline = new Date(<?=$Y.",".$m.",".$d.",".$H.",".$i.",".$s;?>);
      // id таймера
      let timerId = null;
      // склонение числительных
      function declensionNum(num, words) {
        return words[(num % 100 > 4 && num % 100 < 20) ? 2 : [2, 0, 1, 1, 1, 2][(num % 10 < 5) ? num % 10 : 5]];
      }
      // вычисляем разницу дат и устанавливаем оставшееся времени в качестве содержимого элементов
      function countdownTimer() {
        const diff = deadline - new Date();
        if (diff <= 0) {
          clearInterval(timerId);
        }
        const days = diff > 0 ? Math.floor(diff / 1000 / 60 / 60 / 24) : 0;
        const hours = diff > 0 ? Math.floor(diff / 1000 / 60 / 60) % 24 : 0;
        const minutes = diff > 0 ? Math.floor(diff / 1000 / 60) % 60 : 0;
        const seconds = diff > 0 ? Math.floor(diff / 1000) % 60 : 0;
        $days.textContent = days < 10 ? '0' + days : days;
        $hours.textContent = hours < 10 ? '0' + hours : hours;
        $minutes.textContent = minutes < 10 ? '0' + minutes : minutes;
        $seconds.textContent = seconds < 10 ? '0' + seconds : seconds;
        $days.dataset.title = declensionNum(days, ['день', 'день', 'день']);
        $hours.dataset.title = declensionNum(hours, ['часы', 'часы', 'часы']);
        $minutes.dataset.title = declensionNum(minutes, ['минуты', 'минуты', 'минуты']);
        $seconds.dataset.title = declensionNum(seconds, ['секунды', 'секунды', 'секунды']);
      }
      // получаем элементы, содержащие компоненты даты
      const $days = document.querySelector('.days-<?=$item["ID"]?>');
      const $hours = document.querySelector('.hours-<?=$item["ID"]?>');
      const $minutes = document.querySelector('.minutes-<?=$item["ID"]?>');
      const $seconds = document.querySelector('.seconds-<?=$item["ID"]?>');
      // вызываем функцию countdownTimer
      countdownTimer();
      // вызываем функцию countdownTimer каждую секунду
      timerId = setInterval(countdownTimer, 1000);
    });
  </script>
  <?
    }
  ?>
<? endforeach; ?>