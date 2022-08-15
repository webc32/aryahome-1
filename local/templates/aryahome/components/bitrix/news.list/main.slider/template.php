<?
$this->setFrameMode(true);
$templateFolder = $this->GetFolder();
?>
<script defer type="text/javascript" src="<?=$templateFolder?>/owl.js?ver=1.2"></script>
<div class="main-slider owl-carousel">
<? foreach($arResult["ITEMS"] as $item): ?>
    <?
        $link = !empty($item['DISPLAY_PROPERTIES']['LINK']['VALUE']) ? $item['DISPLAY_PROPERTIES']['LINK']['VALUE'] : $item['DETAIL_PAGE_URL'];
        if ( (!empty($item[PROPERTIES][VIDEO][VALUE])) ) {
            ?>
                <div>
                    <div class="d-md-block d-none position-relative w-100">
                        <a href="<?= $link;?>" class="d-block z-index-2 w-100 h-100">
                            <video width="100%" height="auto" poster="" loop autoplay muted playsinline>
                               <source src="https://aryahome.ru/<?=CFile::GetPath($item[PROPERTIES][VIDEO][VALUE])?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
                            </video>
                        </a>
                    </div>
                    <div class="d-md-none d-block position-relative w-100">
                        <a href="<?= $link;?>" class="d-block z-index-2 w-100 h-100">
                            <!-- <video autoplay loop muted playsinline controls="true" width='100%' height='100%' src='https://aryahome.ru/<?=CFile::GetPath($item[PROPERTIES][VIDEO_MOBILE][VALUE])?>' type='video/mp4'></video> -->
                            <img src="https://aryahome.ru/<?=CFile::GetPath($item[PROPERTIES][VIDEO_MOBILE][VALUE])?>" loading="lazy" class="w-100" alt="<?=$item['NAME']?>">
                        </a>
                        <div class="title font-weight-800 mt-4 mb-1">
                            <a href="<?= $link;?>" class="text-gold"><?=$item['NAME']?></a>
                        </div>
                        <div class="description font-weight-500">
                            <?=$item['PREVIEW_TEXT']?>
                        </div>
                    </div>
                </div>
            <?
        }elseif(!empty($item['DETAIL_PICTURE']['SRC'])){
            ?>
                <div>
                    <div class="d-md-block d-none position-relative w-100">
                        <a href="<?= $link;?>" class="d-block z-index-2 w-100 h-100">
                            <img src="<?=$item['DETAIL_PICTURE']['SRC']?>" loading="lazy" class="w-100" alt="<?=$item['NAME']?>">
                        </a>
                    </div>
                    <div class="d-md-none d-block position-relative w-100">
                        <a href="<?= $link;?>" class="d-block z-index-2 w-100 h-100">
                            <img src="<?=$item['PREVIEW_PICTURE']['SRC']?>" loading="lazy" class="w-100" alt="<?=$item['NAME']?>">
                        </a>
                        <div class="title font-weight-800 mt-4 mb-1">
                            <a href="<?= $link;?>" class="text-gold"><?=$item['NAME']?></a>
                        </div>
                        <div class="description font-weight-500">
                            <?=$item['PREVIEW_TEXT']?>
                        </div>
                    </div>
                   <!--  (CUser::GetID() == 1) && -->
                    <? if ( (strtotime(date('Y-m-d H:i:s')) >= strtotime('2021-11-11 00:00:00') && strtotime(date('Y-m-d H:i:s')) <= strtotime('2022-01-31 23:59:00')) && ($item['ID'] == '35681')): ?>
                      <a href="<?= $link;?>" class="d-block z-index-2 w-100 h-100">
                        <div class="timer">
                          <div class="timer__items">
                            <div class="timer__item timer__separate days text-white">00</div>
                            <div class="timer__item timer__separate hours text-white">00</div>
                            <div class="timer__item timer__separate minutes text-white">00</div>
                            <div class="timer__item seconds text-white">00</div>
                          </div>
                        </div>
                      </a>
                    <? endif; ?>
                </div>
        <?}?>
<? endforeach; ?>
</div>

<? if ((strtotime(date('Y-m-d H:i:s')) >= strtotime('2021-11-11 00:00:00') && strtotime(date('Y-m-d H:i:s')) <= strtotime('2022-01-31 23:59:00'))): ?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
          // конечная дата, например 1 июля 2021
          const deadline = new Date(2022, 0, 31, 23, 59);
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
            // $days.dataset.title = declensionNum(days, ['день', 'дня', 'дней']);
            $hours.dataset.title = declensionNum(hours, ['часы', 'часы', 'часы']);
            // $hours.dataset.title = declensionNum(hours, ['час', 'часа', 'часов']);
            $minutes.dataset.title = declensionNum(minutes, ['минуты', 'минуты', 'минуты']);
            // $minutes.dataset.title = declensionNum(minutes, ['минута', 'минуты', 'минут']);
            $seconds.dataset.title = declensionNum(seconds, ['секунды', 'секунды', 'секунды']);
            // $seconds.dataset.title = declensionNum(seconds, ['секунда', 'секунды', 'секунд']);
          }
          // получаем элементы, содержащие компоненты даты
          const $days = document.querySelector('.days');
          const $hours = document.querySelector('.hours');
          const $minutes = document.querySelector('.minutes');
          const $seconds = document.querySelector('.seconds');
          // вызываем функцию countdownTimer
          countdownTimer();
          // вызываем функцию countdownTimer каждую секунду
          timerId = setInterval(countdownTimer, 1000);
        });
    </script>
<? endif; ?>