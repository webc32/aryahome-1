</section>
    <footer class="container-fluid bg-white position-relative mt-mb-5">
        <div class="row">
            <div class="social-section w-100">
                <div class="wide d-flex flex-wrap mx-auto text-gray py-3">
                    <div class="col-md-4 col-sm-12 d-flex align-items-center mb-4 mb-sm-0">
                        <div class="d-flex flex-wrap w-100 align-items-center justify-content-center">
                            <span class="my-md-2 mt-2 mb-3">Следите за новостями в:</span>
                            <div class="elements ml-md-5 col w-100 d-flex justify-content-center">
                                <a href="https://vk.com/aryahomeru" class="mx-md-auto"><img src="<?=SITE_TEMPLATE_PATH?>/img/footer/vk.svg" alt="Vkontakte aryahome"></a>
                                <a href="https://ok.ru/aryahomeco" class="mx-md-auto"><img src="<?=SITE_TEMPLATE_PATH?>/img/footer/o.svg" alt="Одноклассники aryahome"></a>
                                <a href="https://www.youtube.com/channel/UC334RLnI4ESr7NzZVUT7RTA/featured" class="mx-md-auto"><img src="<?=SITE_TEMPLATE_PATH?>/img/footer/y.svg" alt="Youtube aryahome"></a>
                                <!-- <a href="https://api.whatsapp.com/send?phone=79166207692" class="mx-md-auto"><img src="<?=SITE_TEMPLATE_PATH?>/img/footer/w.svg" alt="Whatsapp aryahome"></a>
                                <a href="viber://chat?number=+79166208650" class="mx-md-auto"><img src="<?=SITE_TEMPLATE_PATH?>/img/footer/vi.svg" alt="Viber aryahome"></a> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 d-flex align-items-center mb-4 mb-sm-0">
                        <div class="d-flex flex-wrap w-100 align-items-center justify-content-center">
                            <span class="my-md-2 mt-2 mb-3">Мы принимаем к оплате:</span>
                            <div class="elements ml-md-4 col w-100 d-flex justify-content-center justify-content-md-between">
                                <a href="" class="mx-1 mx-sm-0"><div class="pay-method mastercard"></div></a>
                                <a href="" class="mx-1 mx-sm-0"><div class="pay-method visa"></div></a>
                                <a href="" class="mx-1 mx-sm-0"><div class="pay-method mir"></div></a>
                                <a href="" class="mx-1 mx-sm-0"><div class="pay-method webmoney"></div></a>
                                <a href="" class="mx-1 mx-sm-0"><div class="pay-method yandex"></div></a>
                                <a href="" class="mx-1 mx-sm-0"><div class="pay-method gpay"></div></a>
                                <a href="" class="mx-1 mx-sm-0"><div class="pay-method apay"></div></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="service container-fluid">
                <div class="wide d-flex flex-wrap mx-auto">
                    <div class="col-12 col-md-3">
                        <div class="row">
                            <div class="w-100">
                                <h4 class="arrow-up d-inline-block font-weight-bold title-4 my-3 my-md-0">Клиентский сервис</h4>
                                <ul class="list-style-none mt-2 mt-md-4 mb-4 mb-md-0">
									<?$APPLICATION->IncludeComponent("bitrix:menu", "bottom_menu", Array(
										"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
										"CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
										"DELAY" => "N",	// Откладывать выполнение шаблона меню
										"MAX_LEVEL" => "1",	// Уровень вложенности меню
										"MENU_CACHE_GET_VARS" => array(	// Значимые переменные запроса
											0 => "",
										),
										"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
										"MENU_CACHE_TYPE" => "N",	// Тип кеширования
										"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
										"ROOT_MENU_TYPE" => "bottom_menu1",	// Тип меню для первого уровня
										"USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
										),
										false
									);?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="row">
                            <div class="w-100">
                                <h4 class="arrow-up d-inline-block font-weight-bold title-4 my-3 my-md-0">Для покупателей</h4>
                                <ul class="list-style-none mt-2 mt-md-4 mb-4 mb-md-0">
									<?$APPLICATION->IncludeComponent(
										"bitrix:menu",
										"bottom_menu",
										Array(
											"ALLOW_MULTI_SELECT" => "N",
											"CHILD_MENU_TYPE" => "left",
											"DELAY" => "N",
											"MAX_LEVEL" => "1",
											"MENU_CACHE_GET_VARS" => array(""),
											"MENU_CACHE_TIME" => "3600",
											"MENU_CACHE_TYPE" => "N",
											"MENU_CACHE_USE_GROUPS" => "Y",
											"ROOT_MENU_TYPE" => "bottom_menu2",
											"USE_EXT" => "N"
										)
									);?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="row">
                            <div class="w-100">
                                <h4 class="arrow-up d-inline-block font-weight-bold title-4 my-3 my-md-0">О Компании</h4>
                                <ul class="list-style-none mt-2 mt-md-4 mb-4 mb-md-0">
									<?$APPLICATION->IncludeComponent(
										"bitrix:menu",
										"bottom_menu",
										Array(
											"ALLOW_MULTI_SELECT" => "N",
											"CHILD_MENU_TYPE" => "left",
											"DELAY" => "N",
											"MAX_LEVEL" => "1",
											"MENU_CACHE_GET_VARS" => array(""),
											"MENU_CACHE_TIME" => "3600",
											"MENU_CACHE_TYPE" => "N",
											"MENU_CACHE_USE_GROUPS" => "Y",
											"ROOT_MENU_TYPE" => "bottom_menu3",
											"USE_EXT" => "N"
										)
									);?>
                                    <!--<li><a href="/about/aray-s-vami/" class="arya-with-us">Arya с Вами</a></li>-->
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="row">
                            <div class="w-100">
                                <h4 class="arrow-up d-inline-block font-weight-bold title-4 my-3 my-md-0">Контакты</h4>
                                <ul class="list-style-none mt-2 mt-md-4 mb-4 mb-md-0">
									<?$APPLICATION->IncludeComponent(
										"bitrix:menu",
										"bottom_menu",
										Array(
											"ALLOW_MULTI_SELECT" => "N",
											"CHILD_MENU_TYPE" => "left",
											"DELAY" => "N",
											"MAX_LEVEL" => "1",
											"MENU_CACHE_GET_VARS" => array(""),
											"MENU_CACHE_TIME" => "3600",
											"MENU_CACHE_TYPE" => "N",
											"MENU_CACHE_USE_GROUPS" => "Y",
											"ROOT_MENU_TYPE" => "bottom_menu4",
											"USE_EXT" => "N"
										)
									);?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright container-fluid">
                <div class="wide d-flex mx-auto py-4">
                    <div class="d-flex flex-wrap w-100 justify-content-md-between justify-content-center">
                        <!-- <span class="col-12 col-md-4 d-flex justify-content-center justify-content-md-start order-md-1">
							/* Часы работы ПН-ПТ с 09:00 до 22:00 */
                            <div id="cookie_notification" style="display: none;">
							        <p>Для улучшения работы сайта и его взаимодействия с пользователями мы используем файлы cookie. Продолжая работу с сайтом, Вы разрешаете использование cookie-файлов. Вы всегда можете отключить файлы cookie в настройках Вашего браузера.</p>
							        <button class="button cookie_accept">Принять</button>
							</div>
                        </span> -->
                        <span class="col-12 col-md-4 d-flex justify-content-center text-center order-2 order-md-1 mt-4 mt-sm-0">© «Все права защищены. AryaHome.ru, 2010—<?=date("Y")?></span>
                        <span class="col-12 col-md-4 d-flex justify-content-center justify-content-md-end order-md-1">Контакты: 
							<a href="tel:88002008280">
								<?$APPLICATION->IncludeFile(
                                    SITE_DIR."include/phone_footer.php",
                                    array(),
                                    array(
                                        "MODE" => "html"
                                    )
                                );?>
							</a>
						</span>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center align-center w-100">
                <div id="bx-composite-banner"></div>
            </div>
        </div>
        <div id="cookie_notification"> <!-- предупреждение об использовании cookie на сайте -->
            <div class="cookie_box d-flex">
                <p>Для улучшения работы сайта и его взаимодействия с пользователями мы используем файлы cookie. Продолжая работу с сайтом, Вы разрешаете использование cookie-файлов. Вы всегда можете отключить файлы cookie в настройках Вашего браузера.</p>
                <button class="button cookie_accept bg-active round text-uppercase text-white font-weight-500 py-3 px-4">Принять</button>
            </div>
        </div>
    </footer>
<!-- предупреждение об использовании cookie на сайте -->
        <style type="text/css">
            #cookie_notification{
                display: none;
                justify-content: space-between;
                align-items: flex-end;
                position: fixed;
                bottom: 15px;
                left: 50%;
                width: 900px;
                max-width: 90%;
                transform: translateX(-50%);
                padding: 24px;
                background-color: white;
                border-radius: 11px;
                box-shadow: 0 4px 25px rgb(0 0 0 / 20%);
                z-index: 1000;
            }
            #cookie_notification p{
                margin: 0;
            }
            .cookie_accept{
                border: 0;
                height: 100%;
            }
            @media (min-width: 576px){
                #cookie_notification.show{
                    display: flex;
                }
                .cookie_accept{
                    margin: 0 0 0 25px;
                }
            }
            @media (max-width: 575px){
                #cookie_notification {
                    bottom: 70px;
                }
                .cookie_box {
                    flex-wrap: wrap;
                }
                #cookie_notification.show{
                    display: block;
                    text-align: left;
                }
                .cookie_accept{
                    margin: 10px 0 0 0;
                }
            }
        </style>
    <a class="back_to_top bg-gold" title="Наверх">&uarr;</a>
    <style type="text/css">
        /* begin begin Back to Top button  */
        .back_to_top {
          position: fixed;
          bottom: 80px;
          right: 40px;
          z-index: 9999;
          width: 30px;
          height: 30px;
          text-align: center;
          line-height: 30px;
          background: #f5f5f5;
          color: #444;
          cursor: pointer;
          border-radius: 2px;
          display: none;}
        .back_to_top:hover {background: #e9ebec;}
        .back_to_top-show {display: block;}
        /* end begin Back to Top button  */
    </style>
    <script type="text/javascript">
        /* begin begin Back to Top button  */
        (function() {
          'use strict';

          function trackScroll() {
            var scrolled = window.pageYOffset;
            var coords = document.documentElement.clientHeight;

            if (scrolled > coords) {
              goTopBtn.classList.add('back_to_top-show');
            }
            if (scrolled < coords) {
              goTopBtn.classList.remove('back_to_top-show');
            }
          }

          function backToTop() {
            if (window.pageYOffset > 0) {
              window.scrollBy(0, -80);
              setTimeout(backToTop, 0);
            }
          }

          var goTopBtn = document.querySelector('.back_to_top');

          window.addEventListener('scroll', trackScroll);
          goTopBtn.addEventListener('click', backToTop);
        })();
        /* end begin Back to Top button  */
    </script>
    <div class="position-fixed d-md-none header-mobile container-fluid bg-white">
        <div class="row d-flex mx-auto align-items-center justify-content-between pt-3 pb-4">
            <a href="/"><img src="<?=SITE_TEMPLATE_PATH?>/img/header/logo-34.svg" alt="ARYA HOME - оптовая и розничная продажа текстиля для дома" title="Более 25 лет компания ARYA HOME занимается оптовой и розничной продажей текстиля для дома"></a>
            <a href="/personal/wishlist/" class="addtofavorite">
                <svg fill="#D0A550" width="25" height="22" viewBox="0 0 25 22" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.5564 2.13313C21.2882 0.757587 19.5479 0 17.6559 0C16.2417 0 14.9465 0.447113 13.8063 1.32882C13.231 1.77387 12.7096 2.31837 12.25 2.9539C11.7906 2.31856 11.269 1.77387 10.6935 1.32882C9.55349 0.447113 8.25832 0 6.84408 0C4.95208 0 3.21166 0.757587 1.94341 2.13313C0.690296 3.4926 0 5.34984 0 7.36297C0 9.43498 0.772167 11.3317 2.42996 13.3321C3.91299 15.1215 6.04444 16.938 8.51272 19.0414C9.35554 19.7597 10.3109 20.5739 11.3029 21.4412C11.5649 21.6708 11.9012 21.7971 12.25 21.7971C12.5986 21.7971 12.9351 21.6708 13.1968 21.4416C14.1887 20.5741 15.1446 19.7595 15.9878 19.0408C18.4557 16.9378 20.5872 15.1215 22.0702 13.3319C23.728 11.3317 24.5 9.43498 24.5 7.36279C24.5 5.34984 23.8097 3.4926 22.5564 2.13313Z"/>
                </svg>
            </a>
            <a href="" onclick="return false" class="menu-mobile-activate">
                <svg fill="#D0A550" stroke="#D0A550" width="29" height="29" viewBox="0 0 29 29" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip1)">
                    <rect x="3" y="6" width="24" height="2" rx="1" stroke-width="2"/>
                    <rect x="3" y="15" width="8" height="2" rx="1" stroke-width="2"/>
                    <rect x="3" y="24" width="4" height="2" rx="1" stroke-width="2"/>
                    <path d="M16.8532 21.6843C14.8942 18.918 15.5494 15.0874 18.3157 13.1288C21.082 11.1702 24.9126 11.825 26.8712 14.5918C28.8298 17.3581 28.175 21.1882 25.4082 23.1468C23.4337 24.5447 20.8232 24.6523 18.7407 23.4224L14.2156 27.9204C13.727 28.4347 12.9141 28.4553 12.3997 27.9667C11.8854 27.4786 11.8648 26.6657 12.3529 26.1513C12.3684 26.135 12.3834 26.12 12.3997 26.1045L16.8532 21.6843ZM21.8659 22.1036C24.052 22.1041 25.8243 20.3332 25.8257 18.1472C25.8261 15.9611 24.0552 14.1888 21.8688 14.1879C19.6855 14.187 17.9142 15.9551 17.91 18.1383C17.9062 20.3248 19.6762 22.0999 21.8631 22.1036C21.8641 22.1036 21.8645 22.1036 21.8659 22.1036Z" stroke-width="0.8"/>
                    </g>
                    <defs>
                    <clipPath id="clip1">
                    <rect width="29" height="29" fill="white"/>
                    </clipPath>
                    </defs>
                </svg>
            </a>
            <a href="/personal/cart/" class="addtobasket">
                <div class="position-absolute basket-quantity">
                    <div class="ellipse bg-red text-white text-center font-weight-bold"></div>
                </div>
                <svg fill="#D0A550" width="29" height="29" viewBox="0 0 29 29" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip2)">
                    <path d="M0 10.2457C0 9.67371 0.463705 9.21 1.03571 9.21H27.9643C28.5363 9.21 29 9.67371 29 10.2457V10.4051C29 10.9771 28.5363 11.4408 27.9643 11.4408H1.03571C0.463705 11.4408 0 10.9771 0 10.4051V10.2457Z"/>
                    <path d="M10.0372 2.51803C10.3232 2.02266 10.9567 1.85293 11.452 2.13893L11.8142 2.34802C12.3096 2.63402 12.4793 3.26745 12.1933 3.76283L8.24981 10.5931C7.9638 11.0885 7.33037 11.2582 6.83499 10.9722L6.47285 10.7631C5.97748 10.4771 5.80775 9.84371 6.09375 9.34833L10.0372 2.51803Z"/>
                    <path d="M19.4049 2.51803C19.1189 2.02266 18.4854 1.85293 17.9901 2.13893L17.6279 2.34802C17.1326 2.63402 16.9628 3.26745 17.2488 3.76283L21.1923 10.5931C21.4783 11.0885 22.1117 11.2582 22.6071 10.9722L22.9693 10.7631C23.4646 10.4771 23.6344 9.84371 23.3484 9.34833L19.4049 2.51803Z"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.55775 12.5561C2.88395 12.5561 2.38954 13.1894 2.55296 13.843L5.38126 25.1562C5.49653 25.6173 5.9108 25.9407 6.38605 25.9407H22.6149C23.0901 25.9407 23.5044 25.6173 23.6197 25.1562L26.448 13.843C26.6114 13.1894 26.117 12.5561 25.4432 12.5561H3.55775ZM9.95864 14.7869C9.38663 14.7869 8.92292 15.2506 8.92292 15.8226V21.5588C8.92292 22.1308 9.38663 22.5946 9.95864 22.5946H10.118C10.69 22.5946 11.1537 22.1308 11.1537 21.5588V15.8226C11.1537 15.2506 10.69 14.7869 10.118 14.7869H9.95864ZM13.3844 15.8226C13.3844 15.2506 13.8481 14.7869 14.4201 14.7869H14.5794C15.1514 14.7869 15.6152 15.2506 15.6152 15.8226V21.5588C15.6152 22.1308 15.1514 22.5946 14.5794 22.5946H14.4201C13.8481 22.5946 13.3844 22.1308 13.3844 21.5588V15.8226ZM18.8816 14.7869C18.3095 14.7869 17.8458 15.2506 17.8458 15.8226V21.5588C17.8458 22.1308 18.3095 22.5946 18.8816 22.5946H19.0409C19.6129 22.5946 20.0766 22.1308 20.0766 21.5588V15.8226C20.0766 15.2506 19.6129 14.7869 19.0409 14.7869H18.8816Z"/>
                    </g>
                    <defs>
                    <clipPath id="clip2">
                    <rect width="29" height="29" fill="white"/>
                    </clipPath>
                    </defs>
                </svg>
            </a>
        </div>
    </div>
    <div class="mega-menu overlay position-fixed w-100 js-overlay-close">
        <div class="popup position-absolute w-100 js-popup-campaign">
            <div class="bg-white text-black w-100">
                <div class="close text-right position-absolute">
                    <a href="#" onclick="closeModal(this);return false" class="d-flex justify-content-center align-items-center">
                        <svg fill="#D0A550" width="25" height="25" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                            <rect x="1.50391" width="21.9719" height="2.12631" rx="1.06316" transform="rotate(45 1.50391 0)"/>
                            <rect width="21.9719" height="2.12631" rx="1.06316" transform="matrix(-0.707107 0.707107 0.707107 0.707107 15.5391 0)"/>
                        </svg>
                    </a>
                </div>
                <div class="d-flex wide mx-auto py-5">
                    <div class="col-12 col-md-6">
                        <!--<span class="title font-weight-800">Каталог</span>-->
                        <div class="menu-list d-flex w-100 mt-3 pt-1">
                            <div class="lvl-1 col-6 col-md-5">

                                <!-- <div class="my-4 d-flex">
                                    <span class="d-flex align-items-center justify-content-center text-center menu-list-img">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="29" height="29" viewBox="0 0 512 512">
                                            <image id="Слой_1" data-name="Слой 1" x="8" y="8" width="496" height="496" xlink:href="data:img/png;base64,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"/>
                                        </svg>
                                    </span>
                                    <span class="ml-3">
                                        <a href="/den-vlyublennyih/" class="font-weight-bold d-block">
                                            День влюбленных
                                        </a>
                                    </span>
                                </div> -->

                            <?
                            $sections = [];
                            $arFilter = Array("IBLOCK_ID"=>3, "DEPTH_LEVEL"=>1,"ACTIVE"=>"Y");
                            $rsSectionsDL1 = CIBlockSection::GetList(array("LEFT_MARGIN"=>"ASC"), $arFilter, false, array("UF_*"), array(
                                "nPageSize" => 100,
                                "bShowAll" => true 
                            ));

                            while ($arSection = $rsSectionsDL1->Fetch())
                            {

                                if ($arSection[DEPTH_LEVEL] == 1) {

                                    $sections[] = $arSection[ID];

                                    ?>
                                        <div class="my-4 d-flex">
                                            <?if(empty($arSection[UF_IMAGE])) {?>
                                                <span class="d-flex align-items-center justify-content-center text-center menu-list-img"><?=$arSection[UF_SVG_ICON]?></span>
                                            <?} else {?>
                                                <?$arFile = CFile::GetFileArray($arSection[UF_IMAGE]);?>
                                                <span class="d-flex align-items-center justify-content-center text-center menu-list-img"><?echo '<img style="max-width:30px;max-height:30px" src="'.$arFile["SRC"].'" />';?></span>
                                            <?}?>

                                            <span class="ml-3">
                                                <a href="/catalog/<?=$arSection[CODE]?>/" class="font-weight-bold d-block" data-menu="<?=$arSection[ID]?>" <?if($arSection['ID'] == 256){?>style="color:#EB4E4E;"<?}?> >
                                                    <?=$arSection[NAME]?>
                                                </a>
                                            </span>
                                        </div>
                                    <?
                                }
                            }
                            ?>
                                <div class="my-4 d-flex">
                                    <span class="d-flex align-items-center justify-content-center text-center menu-list-img">
                                        <svg width="26" height="24" viewBox="0 0 29 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M26.011 9.608C24.5012 10.7175 22.3806 12.1915 21.4262 12.1915C21.236 12.1915 21.1746 12.1318 21.1316 12.0783C20.7419 11.5849 20.8462 9.85629 21.4477 6.94593C21.506 6.65678 21.3587 6.36763 21.0948 6.25449C20.8309 6.14134 20.524 6.23249 20.3644 6.47763C18.3022 9.62686 17.357 10.2869 16.9305 10.2869C16.3229 10.2869 15.706 8.49854 15.0923 4.96903C15.0432 4.68616 14.8099 4.48187 14.5368 4.46616V4.46301C14.5307 4.46301 14.5246 4.46301 14.5184 4.46301C14.5123 4.46301 14.5061 4.46301 14.5 4.46301V4.46616C14.2238 4.48187 13.9937 4.68616 13.9446 4.96903C13.3308 8.49854 12.714 10.2869 12.1064 10.2869C11.6767 10.2869 10.7346 9.62686 8.67238 6.47763C8.51281 6.23249 8.20593 6.1382 7.94201 6.25449C7.6781 6.36763 7.52773 6.65992 7.5891 6.94593C8.18752 9.85943 8.29492 11.588 7.90212 12.0783C7.85916 12.1349 7.79778 12.1915 7.60752 12.1915C6.65313 12.1915 4.5326 10.7175 3.02275 9.608C2.78032 9.43199 2.45503 9.46028 2.24635 9.674C2.03768 9.88458 2.01313 10.2209 2.18191 10.466C5.63429 14.9887 4.98678 20.1808 4.98678 20.1808C4.9745 20.2531 4.96836 20.3254 4.96836 20.404C4.96836 21.68 6.71143 22.1829 8.23048 22.4815C9.90297 22.8083 12.1064 22.9938 14.4509 23C14.4724 23 14.4969 23 14.5184 23C14.5399 23 14.5644 23 14.5859 23C16.9274 22.9938 19.1308 22.8115 20.8033 22.4815C22.3223 22.1829 24.0654 21.68 24.0654 20.404C24.0654 20.3254 24.0593 20.2531 24.047 20.1808C24.047 20.1808 23.3964 14.9887 26.8488 10.466C27.0206 10.2209 26.993 9.88458 26.7843 9.674C26.5787 9.46342 26.2504 9.43199 26.011 9.608ZM14.5829 21.24H14.5798C14.5583 21.24 14.5368 21.24 14.5153 21.24C14.4939 21.24 14.4755 21.24 14.4509 21.24H14.4478C10.7254 21.2274 8.2673 20.7843 7.18096 20.404C8.2673 20.0237 10.7285 19.5805 14.4478 19.568H14.457C14.4755 19.568 14.4969 19.568 14.5153 19.568C14.5338 19.568 14.5522 19.568 14.5737 19.568H14.5829C18.3053 19.5774 20.7634 20.0205 21.8497 20.404C20.7634 20.7843 18.3053 21.2274 14.5829 21.24Z" fill="#D0A550"/>
                                        <path d="M14.5154 3.71495C15.5171 3.71495 16.3291 2.88333 16.3291 1.85747C16.3291 0.83162 15.5171 0 14.5154 0C13.5138 0 12.7018 0.83162 12.7018 1.85747C12.7018 2.88333 13.5138 3.71495 14.5154 3.71495Z" fill="#D0A550"/>
                                        <path d="M6.85568 5.65423C7.69124 5.65423 8.36859 4.96051 8.36859 4.10477C8.36859 3.24902 7.69124 2.5553 6.85568 2.5553C6.02013 2.5553 5.34277 3.24902 5.34277 4.10477C5.34277 4.96051 6.02013 5.65423 6.85568 5.65423Z" fill="#D0A550"/>
                                        <path d="M22.0522 5.65423C22.8878 5.65423 23.5651 4.96051 23.5651 4.10477C23.5651 3.24902 22.8878 2.5553 22.0522 2.5553C21.2167 2.5553 20.5393 3.24902 20.5393 4.10477C20.5393 4.96051 21.2167 5.65423 22.0522 5.65423Z" fill="#D0A550"/>
                                        <path d="M1.01884 9.56079C1.58152 9.56079 2.03767 9.09362 2.03767 8.51733C2.03767 7.94105 1.58152 7.47388 1.01884 7.47388C0.456148 7.47388 0 7.94105 0 8.51733C0 9.09362 0.456148 9.56079 1.01884 9.56079Z" fill="#D0A550"/>
                                        <path d="M27.9812 9.56079C28.5439 9.56079 29 9.09362 29 8.51733C29 7.94105 28.5439 7.47388 27.9812 7.47388C27.4185 7.47388 26.9623 7.94105 26.9623 8.51733C26.9623 9.09362 27.4185 9.56079 27.9812 9.56079Z" fill="#D0A550"/>
                                    </svg>
                                    </span>
                                    <span class="ml-3">
                                        <a href="/finalnaja-cena/" class="font-weight-bold d-block">
                                            Финальная цена
                                        </a>
                                    </span>
                                </div>
                            </div>
                            <?
                            foreach ($sections as $key => $section) {
                                ?>
                                <div class="lvl-2 col-6 col-md-7 <?if($key == 0){?>d-block<?}?>" data-menu-lvl-2="<?=$section?>">
                                <?
                                $arFilter = Array("IBLOCK_ID"=>3, "SECTION_ID"=>$section,"ACTIVE"=>"Y");
                                $rsSectionsDL2 = CIBlockSection::GetList(array("LEFT_MARGIN"=>"ASC"), $arFilter, false, array("UF_*"), array(
                                    "nPageSize" => 200,
                                    "bShowAll" => true 
                                ));

                                while ($arSection = $rsSectionsDL2->Fetch())
                                {
                                    ?>
                                        <div class="w-100 pl-2 pl-md-5">
                                            <div class="my-4 d-flex">
                                                <span class="">
                                                    <a href="/catalog/<?=$arSection[CODE]?>/" class="d-block">
                                                        <?=$arSection[NAME]?>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    <?
                                }
                                ?>
                                </div>
                                <?
                            }
                            ?>
                        </div>
                    </div>
                    <div class="catalog col-6 d-none d-md-block pr-md-5">
                        <h3 class="font-weight-800 title-3">Рекомендуемые товары</h3>
                        <div class="section">
                            <div class="position-relative">
                                <?
                                $APPLICATION->IncludeComponent(
                                    "bitrix:catalog.section", 
                                    "recommended", 
                                    array(
                                        "COMPONENT_TEMPLATE" => "recommended",
                                        "IBLOCK_TYPE" => "catalog",
                                        "IBLOCK_ID" => "3",
                                        "SECTION_ID" => $_REQUEST["SECTION_ID"],
                                        "SECTION_CODE" => $_REQUEST["SECTION_CODE"],
                                        "SECTION_USER_FIELDS" => array(
                                            0 => "",
                                            1 => "",
                                        ),
                                        "FILTER_NAME" => "arrFilter",
                                        "INCLUDE_SUBSECTIONS" => "Y",
                                        "SHOW_ALL_WO_SECTION" => "Y",
                                        "CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":{\"1\":{\"CLASS_ID\":\"CondIBProp:3:24\",\"DATA\":{\"logic\":\"Equal\",\"value\":4}}}}",
                                        "HIDE_NOT_AVAILABLE" => "Y",
                                        "HIDE_NOT_AVAILABLE_OFFERS" => "Y",
                                        'ELEMENT_SORT_FIELD' => 'rand',
                                        'ELEMENT_SORT_ORDER' => '',
                                        'ELEMENT_SORT_FIELD2' => '',
                                        'ELEMENT_SORT_ORDER2' => '',
                                        "PAGE_ELEMENT_COUNT" => "8",
                                        "LINE_ELEMENT_COUNT" => "3",
                                        "OFFERS_LIMIT" => "5",
                                        "BACKGROUND_IMAGE" => "-",
                                        "TEMPLATE_THEME" => "blue",
                                        "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false}]",
                                        "ENLARGE_PRODUCT" => "STRICT",
                                        "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                                        "SHOW_SLIDER" => "Y",
                                        "SLIDER_INTERVAL" => "3000",
                                        "SLIDER_PROGRESS" => "N",
                                        "ADD_PICT_PROP" => "-",
                                        "LABEL_PROP" => array(
                                        ),
                                        "PRODUCT_SUBSCRIPTION" => "Y",
                                        "SHOW_DISCOUNT_PERCENT" => "Y",
                                        "SHOW_OLD_PRICE" => "Y",
                                        "SHOW_MAX_QUANTITY" => "N",
                                        "SHOW_CLOSE_POPUP" => "Y",
                                        "MESS_BTN_BUY" => "Купить",
                                        "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                                        "MESS_BTN_SUBSCRIBE" => "Подписаться",
                                        "MESS_BTN_DETAIL" => "Подробнее",
                                        "MESS_NOT_AVAILABLE" => "Нет в наличии",
                                        "RCM_TYPE" => "personal",
                                        "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                                        "SHOW_FROM_SECTION" => "N",
                                        "SECTION_URL" => "",
                                        "DETAIL_URL" => "",
                                        "SECTION_ID_VARIABLE" => "SECTION_ID",
                                        "SEF_MODE" => "N",
                                        "AJAX_MODE" => "N",
                                        "AJAX_OPTION_JUMP" => "N",
                                        "AJAX_OPTION_STYLE" => "Y",
                                        "AJAX_OPTION_HISTORY" => "N",
                                        "AJAX_OPTION_ADDITIONAL" => "",
                                        "CACHE_TYPE" => "A",
                                        "CACHE_TIME" => "36000000",
                                        "CACHE_GROUPS" => "Y",
                                        "SET_TITLE" => "N",
                                        "SET_BROWSER_TITLE" => "N",
                                        "BROWSER_TITLE" => "-",
                                        "SET_META_KEYWORDS" => "N",
                                        "META_KEYWORDS" => "-",
                                        "SET_META_DESCRIPTION" => "N",
                                        "META_DESCRIPTION" => "-",
                                        "SET_LAST_MODIFIED" => "N",
                                        "USE_MAIN_ELEMENT_SECTION" => "Y",
                                        "ADD_SECTIONS_CHAIN" => "N",
                                        "CACHE_FILTER" => "N",
                                        "ACTION_VARIABLE" => "action",
                                        "PRODUCT_ID_VARIABLE" => "id",
                                        "PRICE_CODE" => array(
                                            0 => "СПЕЦ ЦЕНЫ для ИНТЕРНЕТ МАГАЗИНА WMS",
                                            1 => "Онлайн Розница со скидкой для ИНТЕРНЕТ МАГАЗИНА WMS",
                                        ),
                                        "USE_PRICE_COUNT" => "N",
                                        "SHOW_PRICE_COUNT" => "1",
                                        "PRICE_VAT_INCLUDE" => "Y",
                                        "CONVERT_CURRENCY" => "N",
                                        "BASKET_URL" => "/personal/cart/",
                                        "USE_PRODUCT_QUANTITY" => "N",
                                        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                                        "ADD_PROPERTIES_TO_BASKET" => "Y",
                                        "PRODUCT_PROPS_VARIABLE" => "prop",
                                        "PARTIAL_PRODUCT_PROPERTIES" => "N",
                                        "ADD_TO_BASKET_ACTION" => "ADD",
                                        "DISPLAY_COMPARE" => "N",
                                        "USE_ENHANCED_ECOMMERCE" => "N",
                                        "PAGER_TEMPLATE" => ".default",
                                        "DISPLAY_TOP_PAGER" => "N",
                                        "DISPLAY_BOTTOM_PAGER" => "Y",
                                        "PAGER_TITLE" => "Товары",
                                        "PAGER_SHOW_ALWAYS" => "N",
                                        "PAGER_DESC_NUMBERING" => "N",
                                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                                        "PAGER_SHOW_ALL" => "Y",
                                        "PAGER_BASE_LINK_ENABLE" => "N",
                                        "LAZY_LOAD" => "N",
                                        "LOAD_ON_SCROLL" => "N",
                                        "SET_STATUS_404" => "Y",
                                        "SHOW_404" => "N",
                                        "MESSAGE_404" => "",
                                        "COMPATIBLE_MODE" => "Y",
                                        "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                                        "SEF_RULE" => "#SECTION_CODE#",
                                        "SECTION_CODE_PATH" => "",
                                        "DISCOUNT_PERCENT_POSITION" => "bottom-right",
                                        "COMPOSITE_FRAME_MODE" => "A",
                                        "COMPOSITE_FRAME_TYPE" => "AUTO"
                                    ),
                                    false,
                                    array(
                                        "ACTIVE_COMPONENT" => "Y"
                                    )
                                );
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="menu-mobile position-fixed w-100">
        <div class="block col-12 bg-white position-relative">
            <div class="header row w-100 bg-white position-fixed pb-4">
                <div class="d-flex fix-mobile-padding justify-content-between align-items-center w-100 pt-4">
                    <a href="/" class="d-md-none d-block px-3 px-md-0">
                        <span class="name title-3 active d-block font-weight-bold">Каталог</span>
                    </a>
                    <a href="/personal/" class="px-3 px-md-0">
                        <svg fill="#D0A550" width="22" height="24" viewBox="0 0 22 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.2426 1.75738C17.5857 4.10052 17.5857 7.89951 15.2426 10.2426C12.8995 12.5858 9.10048 12.5858 6.75735 10.2426C4.41422 7.89951 4.41422 4.10052 6.75735 1.75738C9.10048 -0.585795 12.8995 -0.585795 15.2426 1.75738Z"></path>
                            <path d="M20.6419 15.9184C14.9117 12.0272 7.0883 12.0272 1.3581 15.9184C0.507924 16.4952 0 17.4699 0 18.5264V24H22V18.5264C22 17.4699 21.492 16.4952 20.6419 15.9184Z"></path>
                        </svg>
                    </a>
                </div>
                <div class="w-100 fix-mobile-padding pt-3">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:search.title", 
                        ".default", 
                        array(
                            "CATEGORY_0" => array(
                                0 => "iblock_catalog",
                            ),
                            "CATEGORY_0_TITLE" => "",
                            "CHECK_DATES" => "Y",
                            "CONTAINER_ID" => "title-search-mobile",
                            "CONVERT_CURRENCY" => "N",
                            "INPUT_ID" => "title-search-input-mobile",
                            "NUM_CATEGORIES" => "1",
                            "ORDER" => "date",
                            "PAGE" => "/search/index.php",
                            "PREVIEW_TRUNCATE_LEN" => "",
                            "PRICE_CODE" => array(
                                0 => "BASE",
                            ),
                            "PRICE_VAT_INCLUDE" => "Y",
                            "SHOW_INPUT" => "Y",
                            "SHOW_OTHERS" => "N",
                            "SHOW_PREVIEW" => "Y",
                            "TEMPLATE_THEME" => "blue",
                            "TOP_COUNT" => "5",
                            "USE_LANGUAGE_GUESS" => "Y",
                            "COMPONENT_TEMPLATE" => ".default",
                            "CATEGORY_0_iblock_catalog" => array(
                                0 => "3",
                            ),
                            "PREVIEW_WIDTH" => "75",
                            "PREVIEW_HEIGHT" => "75"
                        ),
                        false
                    );?>
                </div>
            </div>
            <div class="menu w-100 menu position-relative">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:menu", 
                    "mobile.menu", 
                    array(
                        "ROOT_MENU_TYPE" => "left",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_TIME" => "36000000",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_THEME" => "site",
                        "CACHE_SELECTED_ITEMS" => "N",
                        "MENU_CACHE_GET_VARS" => array(
                        ),
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "left",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N",
                        "COMPONENT_TEMPLATE" => "mobile.menu",
                        "COMPOSITE_FRAME_MODE" => "Y",
                        "COMPOSITE_FRAME_TYPE" => "STATIC"
                    ),
                    false
                );?>
				<?
					global $USER;
					if ($USER->IsAdmin()) {
						$APPLICATION->IncludeComponent("bitrix:main.site.selector", "custom_site_selection", Array(
						"CACHE_TIME" => "3600",	// Время кеширования (сек.)
							"CACHE_TYPE" => "A",	// Тип кеширования
							"COMPOSITE_FRAME_MODE" => "A",	// Голосование шаблона компонента по умолчанию
							"COMPOSITE_FRAME_TYPE" => "AUTO",	// Содержимое компонента
							"SITE_LIST" => array(	// Список сайтов
								0 => "MG",
								1 => "s1",
							)
						),
						false
					);
					}
					?>
            </div>
        </div>
    </div>
    <div class="mobile-overlay position-fixed w-100"></div>
    <div class="quickview overlay align-center border-radius shadow black position-fixed w-100 js-overlay-close">
        <div class="popup position-absolute w-100 js-popup-campaign">
            <div class="catalog bg-white text-black w-100">
            </div>
        </div>
    </div>
    <div class="formtobasket pre-accept catalog overlay align-center border-radius shadow small position-fixed w-100 js-overlay-close">
        <div class="popup position-absolute w-100 js-popup-campaign">
            <div class="bg-white text-black">
                <div class="close ellipse bg-gray d-flex justify-content-center align-items-center position-absolute">
                    <a href="#" data-modal="close" onclick="return false">
                        <svg width="24" height="23" viewBox="0 0 24 23" xmlns="http://www.w3.org/2000/svg">
                            <rect x="7.19092" y="17.7292" width="2.26753" height="15.8727" rx="1.13377" transform="rotate(-135 7.19092 17.7292)" fill="white"/>
                            <rect width="2.26753" height="15.8727" rx="1.13377" transform="matrix(0.707107 -0.707107 -0.707107 -0.707107 16.8091 17.7292)" fill="white"/>
                        </svg>
                    </a>
                </div>
                <div class="element d-block mx-auto px-4 py-4">
                    <div class="product-title font-weight-bold text-uppercase"></div>
                    <div class="props flex-wrap mt-3" data-type="item:props">
                        <div class="color w-100" data-type="item:color"></div>
                        <div class="size w-100" data-type="item:size"></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="" onclick="Add2BasketByProductID(this);return false" class="addtobasket btn bg-active round text-uppercase text-white font-weight-500 d-flex align-items-center py-3 px-4">
                            <svg fill="white" width="25" height="21" viewBox="0 0 25 21" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 7.10838C0 6.61526 0.399746 6.21552 0.892857 6.21552H24.1071C24.6003 6.21552 25 6.61526 25 7.10838V7.24574C25 7.73885 24.6003 8.1386 24.1071 8.1386H0.892857C0.399745 8.1386 0 7.73885 0 7.24574V7.10838Z"/>
                                <path d="M8.65278 0.446578C8.89934 0.0195306 9.4454 -0.126786 9.87245 0.119769L10.1846 0.300014C10.6117 0.546569 10.758 1.09263 10.5114 1.51968L7.1119 7.40787C6.86535 7.83492 6.31928 7.98123 5.89224 7.73468L5.58004 7.55443C5.153 7.30788 5.00668 6.76182 5.25323 6.33477L8.65278 0.446578Z"/>
                                <path d="M16.7283 0.446578C16.4818 0.0195306 15.9357 -0.126786 15.5087 0.119769L15.1965 0.300014C14.7694 0.546569 14.6231 1.09263 14.8697 1.51968L18.2692 7.40787C18.5158 7.83492 19.0618 7.98123 19.4889 7.73468L19.8011 7.55443C20.2281 7.30788 20.3745 6.76182 20.1279 6.33477L16.7283 0.446578Z"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.06703 9.10011C2.48616 9.10011 2.05995 9.646 2.20083 10.2095L4.63902 19.9623C4.73839 20.3597 5.09551 20.6386 5.50522 20.6386H19.4956C19.9053 20.6386 20.2624 20.3597 20.3618 19.9623L22.8 10.2095C22.9409 9.646 22.5146 9.10011 21.9338 9.10011H3.06703ZM8.58503 11.0232C8.09192 11.0232 7.69217 11.4229 7.69217 11.916V16.8611C7.69217 17.3542 8.09192 17.7539 8.58503 17.7539H8.72239C9.2155 17.7539 9.61525 17.3542 9.61525 16.8611V11.916C9.61525 11.4229 9.2155 11.0232 8.72239 11.0232H8.58503ZM11.5383 11.916C11.5383 11.4229 11.938 11.0232 12.4311 11.0232H12.5685C13.0616 11.0232 13.4613 11.4229 13.4613 11.916V16.8611C13.4613 17.3542 13.0616 17.7539 12.5685 17.7539H12.4311C11.938 17.7539 11.5383 17.3542 11.5383 16.8611V11.916ZM16.2772 11.0232C15.7841 11.0232 15.3843 11.4229 15.3843 11.916V16.8611C15.3843 17.3542 15.7841 17.7539 16.2772 17.7539H16.4146C16.9077 17.7539 17.3074 17.3542 17.3074 16.8611V11.916C17.3074 11.4229 16.9077 11.0232 16.4146 11.0232H16.2772Z"/>
                            </svg>
                            <span class="d-block mx-3">В корзину</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="formtobasket accept overlay align-center border-radius shadow small position-fixed w-100 js-overlay-close">
        <div class="popup position-absolute w-100 js-popup-campaign">
            <div class="bg-white text-black w-100">
                <div class="d-block mx-auto px-4 py-4">
                    <div class="product-title font-weight-bold text-center text-uppercase"></div>
                    <div class="d-flex justify-content-center align-items-center mt-4">
                        <a href="" onclick="return false" data-modal="closeBuyProduct" class="btn border-gold round text-uppercase d-flex align-items-center text-gold text-center font-weight-500 px-5 py-3">
                            <span class="d-block px-3">Закрыть</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="formtofavorite overlay align-center border-radius shadow small position-fixed w-100 js-overlay-close">
        <div class="popup position-absolute w-100 js-popup-campaign">
            <div class="bg-white text-black w-100">
                <div class="d-block mx-auto px-4 py-4">
                    <div class="product-title font-weight-bold text-center text-uppercase"></div>
                    <div class="d-flex justify-content-center align-items-center mt-4">
                        <a href="" onclick="closeModal(this);return false" class="btn border-gold round text-uppercase d-flex align-items-center text-gold text-center font-weight-500 px-5 py-3">
                            <span class="d-block px-3">Закрыть</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="delivery overlay align-center border-radius shadow small position-fixed w-100 js-overlay-close">
        <div class="popup position-absolute w-100 js-popup-campaign">
            <div class="bg-white text-black w-100">
                <div class="d-block mx-auto px-4 py-4">
                    <div class="product-title font-weight-bold text-center text-uppercase">Заказ от 1000₽ - Доставка бесплатная!</div>
                    <div class="d-flex justify-content-center align-items-center mt-4">
                        <a href="" onclick="closeModal(this);return false" class="btn border-gold round text-uppercase d-flex align-items-center text-gold text-center font-weight-500 px-5 py-3">
                            <span class="d-block px-3">Закрыть</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="subscription overlay align-center border-radius shadow black position-fixed w-100 js-overlay-close">
        <div class="popup position-absolute js-popup-campaign subscription">
            <div class="bg-white">
                <div class="close ellipse bg-gray d-flex justify-content-center align-items-center position-absolute">
                    <a href="#" onclick="closeModal(this);return false">
                        <svg width="24" height="23" viewBox="0 0 24 23" xmlns="http://www.w3.org/2000/svg">
                            <rect x="7.19092" y="17.7292" width="2.26753" height="15.8727" rx="1.13377" transform="rotate(-135 7.19092 17.7292)" fill="white"/>
                            <rect width="2.26753" height="15.8727" rx="1.13377" transform="matrix(0.707107 -0.707107 -0.707107 -0.707107 16.8091 17.7292)" fill="white"/>
                        </svg>
                    </a>
                </div>
                <div class="d-block text-center mx-auto px-4 px-md-5 py-5">
                    <div class="position-absolute bg-lightpink"></div>
                    <div class="svg position-relative">
                        <img src="<?=SITE_TEMPLATE_PATH?>/img/popup/subscription.svg" alt="Регистрация на aryahome">
                    </div>
                    <div class="font-weight-800 text-red title white-space mt-4">Дополнительная скидка 5%</div>
                    <div class="mt-3">При регистрации у нас на сайте. Скидка действует на все товары, кроме <span class="text-red">спец цен</span></div>
                    <div class="d-flex justify-content-center align-items-center mt-4">
                        <a href="/auth/#registration" class="btn bg-active round text-uppercase text-white font-weight-500 d-flex align-items-center py-3 px-4">
                            <span class="d-block mx-3">Зарегистрироваться</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        // открыть по таймеру 
        $(window).on('load', function () { 
            setTimeout(function(){
                
                if (localStorage.getItem('delivery') != 'open') {
                    
                    // localStorage.setItem('delivery', 'open');
                    // $(".overlay.delivery").fadeIn();
                }
                
            }, 3000);;
        });
    </script>
    <?$personal = stripos($_SERVER['REQUEST_URI'], 'personal');?>
    <?if ($personal != 1) {?>
        <!-- Yandex.Metrika counter -->
            <script type="text/javascript" >
            (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
            (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

            ym(28747751, "init", {
                clickmap:true,
                trackLinks:true,
                accurateTrackBounce:true,
                webvisor:true,
                ecommerce:"dataLayer"
            });
            </script>
            <noscript><div><img src="https://mc.yandex.ru/watch/28747751" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->
    <?}else{?>
        <!-- Yandex.Metrika counter -->
        <script type="text/javascript" >
           (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
           m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
           (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

           ym(28747751, "init", {
                clickmap:true,
                trackLinks:true,
                accurateTrackBounce:true,
                ecommerce:"dataLayer"
           });
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/28747751" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->
    <?}?>
    <div class="test1231 <?=$personal?>"></div>
    <div itemscope="" itemtype="http://schema.org/Organization" class="d-none">
        <div itemprop="name">ООО «Мир Текстиля» </div>
        <div itemprop="description">Постельное белье, полотенца и весь домашний текстиль Aryahome. Широкий ассортимент, низкие цены, скидки, бесплатная доставка по Москве и России. </div>
        <div itemprop="address" itemscope="" itemtype="http://schema.org/PostalAddress">
            <div itemprop="postalCode">109518</div>
            <div itemprop="addressCountry">Россия</div>
            <div itemprop="addressRegion">Москва</div>
            <div itemprop="addressLocality">Москва</div>
            <div itemprop="streetAddress">1-й Грайвороновский проезд, дом 20, строение 20.</div>
        </div>
        <div>
            <span itemprop="telephone">+78002008280</span>, 
            <span itemprop="telephone">+74999552587</span>, 
            <span itemprop="telephone">+79166208650</span>, 
            <span itemprop="telephone">+79166207692</span>
        </div>
        <div><a itemprop="email" href="mailto:sale@aryahome.ru">sale@aryahome.ru</a></div>
        <div><a href="http://aryahome.ru" itemprop="url">aryahome.ru</a></div>
        <div>
            <div itemscope="" itemtype="http://schema.org/ImageObject" itemprop="logo">
                <img src="<?=SITE_TEMPLATE_PATH?>/img/header/logo-195.jpg" itemprop="contentUrl" alt="Арияхоум">
                <div>
                    <p itemprop="name">Арияхоум</p>
                    <p itemprop="caption">текстиль Aryahome</p>
                    <p itemprop="description">Постельное белье, полотенца и весь домашний текстиль Aryahome</p>
                    <meta itemprop="height" content="240px"><meta itemprop="width" content="52px">
                </div>
            </div>
        </div>
        <div>
            <span itemprop="taxID">7716924172</span>
        </div>
    </div>
    <?
    $GLOBALS["APPLICATION"]->MoveJSToBody('main');
    $APPLICATION->ShowBodyScripts();
    // Подключаем css в футере
    $APPLICATION->ShowCSS(true);
    ?>
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/lib/owl/owl.carousel.min.css?v=1.0">
    <script src="<?=SITE_TEMPLATE_PATH . '/lib/owl/owl.carousel.min.js'?>"></script>
    <script src="<?=SITE_TEMPLATE_PATH . '/js/scripts.min.js?v=1.3'?>"></script>
    <script src="<?=SITE_TEMPLATE_PATH . '/lib/readmore/readmore.min.js?v=1.2'?>"></script>
    <?
    // use Bitrix\Main\Page\Asset;
    // Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/lazyload.js");
    ?>
    
    <!-- предупреждение об использовании cookie на сайте -->
    <script type="text/javascript">
    $(document).ready(function() {

        function checkCookies(){
            let cookieDate = localStorage.getItem('cookieDate');
            let cookieNotification = document.getElementById('cookie_notification');
            let cookieBtn = cookieNotification.querySelector('.cookie_accept');

            // Если записи про кукисы нет или она просрочена на 1 год, то показываем информацию про кукисы
            if( !cookieDate || (+cookieDate + 31536000000) < Date.now() ){
                cookieNotification.classList.add('show');
            }

            // При клике на кнопку, в локальное хранилище записывается текущая дата в системе UNIX
            cookieBtn.addEventListener('click', function(){
                localStorage.setItem( 'cookieDate', Date.now() );
                cookieNotification.classList.remove('show');
            })
        }

        checkCookies();

    });
    </script>
	<script>
        (function(w, d, u, i, o, s, p) {
        if (d.getElementById(i)) { return; } w['MangoObject'] = o;
          w[o] = w[o] || function() { (w[o].q = w[o].q || []).push(arguments) }; w[o].u = u; w[o].t = 1 * new Date();
          s = d.createElement('script'); s.async = 1; s.id = i; s.src = u; s.charset = 'utf-8';
          p = d.getElementsByTagName('script')[0]; p.parentNode.insertBefore(s, p);
        }(window, document, '//widgets.mango-office.ru/widgets/mango.js', 'mango-js', 'mgo'));
        mgo({multichannel: {id: 12005}});
	</script>
</body>
</html>