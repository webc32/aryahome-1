<?
$this->setFrameMode(true);
$templateFolder = $this->GetFolder();
?>

<? if(empty($arParams['PARENT_SECTION'])): ?>
    <div class="map mx-auto w-100 position-relative mt-4 d-none d-md-block">
        <div class="position-absolute"><img src="<?=$templateFolder?>/images/map.png"></div>
        <!-- <a style="left: 178px;top: 488px;" class="name size left position-absolute d-inline" title="Иваново" region="IVA" href="/karta-magazinov/ivanovo/">Иваново</a> -->
        <a style="left: 120px;top: 390px;" class="name size left position-absolute d-inline" title="Ростов-на-Дону" region="ROS" href="/karta-magazinov/magaziny-v-rostove-na-donu/">Ростов-на-Дону</a>
        <!-- <a style="left: 130px;top: 255px;" class="name size left position-absolute d-inline" title="Ростов" region="ROS" href="/karta-magazinov/rostov2/">Ростов</a> -->
        <!-- <a style="left: 187px; top: 154px;" class="name size left position-absolute d-inline" title="Мурманск" region="MU" href="#">Мурманск</a> -->
        <a style="left: 40px;top: 200px;" class="name size-2 right font-weight-bold position-absolute d-inline" title="Санкт-Петербург" region="SPE" href="/karta-magazinov/magaziny-v-sankt-peterburge/">Санкт-Петербург</a>
        <!-- <a style="left: 96px; top: 223px;" class="name size left position-absolute d-inline" title="Великий Новгород" region="NGR" href="#">Великий Новгород</a> -->
        <a style="left: 85px;top: 285px;" class="name size-1 right font-weight-bold position-absolute d-inline" title="Москва" region="MOW" href="/karta-magazinov/magaziny-v-moskve/">Москва</a>
        <a style="left: 170px;top: 272px;" class="name size left position-absolute d-inline" title="Зеленоград" region="MOW" href="/karta-magazinov/magaziny-v-zelenograde/">Зеленоград</a>
        <!-- <a style="left: 167px;top: 458px;" class="name size left position-absolute d-inline" title="Ярославль" region="MOW" href="/karta-magazinov/yaroslavl/">Ярославль</a> -->
        <!-- <a style="left: 201px; top: 262px;" class="name size left position-absolute d-inline" title="Сыктывкар" region="KO" href="#">Сыктывкар</a> -->
        <!-- <a style="left: 214px; top: 499px;" class="name size left position-absolute d-inline" title="Нижний Новгород" region="NIZ" href="/karta-magazinov/nijniynovgorod/">Нижний Новгород</a> -->
        <a style="left: 180px;top: 320px;" class="name size left position-absolute d-inline" title="Рязань" region="RYA" href="/karta-magazinov/magaziny-v-ryazani/">Рязань</a>
        <!-- <a style="left: 237px;top: 549px;" class="name size left position-absolute d-inline" title="Казань" region="TA" href="/karta-magazinov/kazan/">Казань</a> -->
        <!-- <a style="left: 160px;top: 494px;" class="name size left position-absolute d-inline" title="Ковров" region="TA" href="/karta-magazinov/kovrov/">Ковров</a> -->
        <!-- <a style="left: 189px;top: 471px;" class="name size left position-absolute d-inline" title="Кострома" region="TA" href="/karta-magazinov/kostroma/">Кострома</a> -->
        <!-- <a style="left: 206px;top: 578px;" class="name size left position-absolute d-inline" title="Самара" region="SAM" href="/karta-magazinov/samara/">Самара</a> -->
        <a style="left: 195px;top: 405px;" class="name size left position-absolute d-inline" title="Саратов" region="SAM" href="/karta-magazinov/magaziny-v-saratove/">Саратов</a>
        <!-- <a style="left: 84px; top: 350px;" class="name size left position-absolute d-inline" title="Волгоград" region="VGG" href="#">Волгоград</a> -->
        <a style="left: 80px;top: 420px;" class="name size left position-absolute d-inline" title="Краснодар" region="KDA" href="/karta-magazinov/magaziny-v-krasnodare/">Краснодар</a>
        <!-- <a style="left: 27px;top: 618px;" class="name size left position-absolute d-inline" title="Новоросийск" region="KDA" href="/karta-magazinov/novorosisk/">Новоросcийск</a> -->
        <a style="left: 100px;top: 465px;" class="name size left position-absolute d-inline" title="Нальчик" region="KDA" href="/karta-magazinov/magaziny-v-nalchike/">Нальчик</a>
        <!-- <a style="left: 115px;top: 480px;" class="name size left position-absolute d-inline" title="Владикавказ" region="KDA" href="/karta-magazinov/magazin-vo-vladikavkaze/">Владикавказ</a> -->
        <!-- <a style="left: 100px; top: 379px;" class="name size left position-absolute d-inline" title="Махачкала" region="MDA" href="/karta-magazinov/mahachkala/">Махачкала</a> -->
        <a style="left: 360px;top: 380px;" class="name size left position-absolute d-inline" title="Тюмень" region="TYU" href="/karta-magazinov/magaziny-v-tyumeni/">Тюмень</a>
        <!-- <a style="left: 269px;top: 613px;" class="name size left position-absolute d-inline" title="Уфа" region="BA" href="/karta-magazinov/ufa/">Уфа</a> -->
        <a style="left: 255px;top: 430px;" class="name size left position-absolute d-inline" title="Оренбург" region="BA" href="/karta-magazinov/magaziny-v-orenburge/">Оренбург</a>
        <!-- <a style="left: 470px;top: 370px;" class="name size left position-absolute d-inline" title="Сургут" region="KHM" href="/karta-magazinov/magaziny-v-surgute/">Сургут</a> -->
        <!-- <a style="left: 310px;top: 360px;" class="name size left position-absolute d-inline" title="Екатеринбург" region="SVE" href="/karta-magazinov/magaziny-v-ekaterinburge/">Екатеринбург</a> -->
        <!-- <a style="left: 315px;top: 591px;" class="name size left position-absolute d-inline" title="Челябинск" region="CHE" href="/karta-magazinov/chelyabinsk/">Челябинск</a> -->
        <!-- <a style="left: 242px; top: 363px;" class="name size left position-absolute d-inline" title="Курган" region="KGN" href="#">Курган</a> -->
        <!-- <a style="left: 533px;top: 614px;" class="name size left position-absolute d-inline" title="Новосибирск" region="NVS" href="/karta-magazinov/novosibirsk/">Новосибирск</a> -->
        <!-- <a style="left: 550px;top: 625px;" class="name size left position-absolute d-inline" title="Новокузнецк" region="NVS" href="/karta-magazinov/novokuznetsk/">Новокузнецк</a> -->
        <!-- <a style="left: 965px;top: 615px;" class="name size left position-absolute d-inline" title="Владивосток" region="NVS" href="/karta-magazinov/magaziny-v-vladivostoke/">Владивосток</a> -->
        <a style="left: 975px;top: 555px;" class="name size left position-absolute d-inline" title="Хабаровск" region="KHA" href="/karta-magazinov/magaziny-v-khabarovske/">Хабаровск</a>
        <a style="left: 790px;top: 540px;" class="name size right position-absolute d-inline" title="Благовещенск" region="KHA" href="/karta-magazinov/magaziny-v-blagoveshchenske/">Благовещенск</a>
        <!-- <a style="left: 737px;top: 644px;" class="name size left position-absolute d-inline" title="Иркутск" region="IRK" href="/karta-magazinov/ircutsk/">Иркутск</a> -->
        <!-- <a style="left: 697px; top: 142px;" class="name size left position-absolute d-inline" title="Магадан" region="MAG" href="#">Магадан</a> -->
        <!-- <a style="left: 775px; top: 204px;" class="name size left position-absolute d-inline" title="Петропавловск-Камчатский" region="KAM" href="#">Петропавловск-Камчатский</a> -->
        <!-- <a style="left: 758px; top: 336px;" class="name size left position-absolute d-inline" title="Южно-Сахалинск" region="SAK" href="#">Южно-Сахалинск</a> -->
        <!-- <a style="left: 93px; top: 396px;" class="name size left position-absolute d-inline" title="Астрахань" region="AST" href="#">Астрахань</a> -->
        <!-- <a style="left: 81px; top: 303px;" class="name size left position-absolute d-inline" title="Липецк" region="LIP" href="#">Липецк</a> -->
        <!-- <a style="left: 110px; top: 320px;" class="name size left position-absolute d-inline" title="Пенза" region="PNZ" href="#">Пенза</a> -->
        <!-- <a style="left: 135px;top: 175px;" class="name size right position-absolute d-inline" title="Петрозаводск" region="KR" href="/karta-magazinov/magaziny-v-petrozavodske">Петрозаводск</a> -->
        <!-- <a style="left: 270px;top: 200px;" class="name size left position-absolute d-inline" title="Архангельск" region="KR" href="/karta-magazinov/magaziny-v-arkhangelske">Архангельск</a> -->
        <!-- <a style="left: 70px;top: 185px;" class="name size left position-absolute d-inline" title="Калининград" region="KA" href="/karta-magazinov/magaziny-v-kaliningrade">Калининград</a> -->
        <!-- <a style="left: 270px;top: 185px;" class="name size left position-absolute d-inline" title="Северодвинск" region="SE" href="/karta-magazinov/magaziny-v-severodvinske">Северодвинск</a> -->
        <!-- <a style="left: 195px; top: 372px;" class="name size left position-absolute d-inline" title="Магнитогорск" region="CHE" href="#">Магнитогорск</a> -->
    </div>
<? endif; ?>

<div class="region mt-4 mt-md-5 w-100">
    <div class="title-5 font-weight-bold">Поиск магазинов</div>
    <div class="d-flex flex-wrap w-100">
        <div class="d-flex w-100 col-12 col-md-6 py-md-4">
            <div class="type active w-100 row flex-wrap align-items-center py-2 mb-md-4" data-tab="1">
                <div class="position-relative">
                        <span class="ellipse">
                            <svg fill="#E1E1E1" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="11.5" fill="white" stroke="#E1E1E1"/>
                                <circle cx="12" cy="12" r="5"/>
                            </svg>
                        </span>
                    <input id="ID_PAY_SYSTEM_ID_2" name="PAY_SYSTEM_ID" type="checkbox" class="d-none" value="2">
                </div>
                <div class="title-5 low font-weight-500 col pl-3 pl-md-4 pt-1">Россия</div>
                <div class="w-100 pl-5 d-md-block d-none">
                    <div class="text-gray">
                           <span class="d-block">
                                Магазины в городах России
                            </span>
                    </div>
                </div>
            </div>
            <div class="type w-100 row flex-wrap align-items-center py-2 mb-md-4" data-tab="2">
                <div class="position-relative">
                        <span class="ellipse">
                            <svg fill="#E1E1E1" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="11.5" fill="white" stroke="#E1E1E1"/>
                                <circle cx="12" cy="12" r="5"/>
                            </svg>
                        </span>
                    <input id="ID_PAY_SYSTEM_ID_2" name="PAY_SYSTEM_ID" type="checkbox" class="d-none" value="2">
                </div>
                <div class="title-5 low font-weight-500 col pl-3 pl-md-4 pt-1">Московская область</div>
                <div class="w-100 pl-5 d-md-block d-none">
                    <div class="text-gray">
                           <span class="d-block">
                                Города входящие в Московскую область
                            </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="select col-12 col-md-6 py-md-2">
            <div class="row d-block mx-md-2">
                <div class="name mx-3">Выбрать город</div>
                <div>
                    <select class="active border-gray px-4 w-100" data-tab="1" onchange="ajaxLoadShops(this.value,$('select.active option:selected').text());">
                        <?
                        $arFilterFirst = Array(
                            "IBLOCK_ID"=>2,
                            "ID" => '151',
                            "ACTIVE" => 'Y'
                        );
                        $rsSectionsFirst = CIBlockSection::GetList(array("LEFT_MARGIN"=>"ASC"), $arFilterFirst, false, array("*"), array(
                            "nPageSize" => 1,
                            "bShowAll" => true
                        ));

                        while ($arSectionFirst = $rsSectionsFirst->Fetch())
                        {

                            echo "<option value='https://".SITE_SERVER_NAME.$APPLICATION->GetCurPage(false).$arSectionFirst[CODE]."/'>".$arSectionFirst[NAME]."</option>";

                        }
                        $arFilter = Array(
                            "IBLOCK_ID"=>2,
                            "!ID" => '151',
                            "ACTIVE" => 'Y'
                        );
                        $rsSections = CIBlockSection::GetList(array("LEFT_MARGIN"=>"ASC"), $arFilter, false, array("*"), array(
                            "nPageSize" => 100,
                            "bShowAll" => true
                        ));

                        while ($arSection = $rsSections->Fetch())
                        {

                            echo "<option value='https://".SITE_SERVER_NAME.$APPLICATION->GetCurPage(false).$arSection[CODE]."/'>".$arSection[NAME]."</option>";

                        }
                        ?>
                    </select>
                    <select class="border-gray px-4 w-100" data-tab="2" onchange="ajaxLoadShops(this.value,$('select.active option:selected').text());">
                        <!-- <option></option> -->
                        <?
                        $arFilterFirst = Array(
                            "IBLOCK_ID"=>2,
                            "ID" => '3',
                            "ACTIVE" => 'Y'
                        );
                        $rsSectionsFirst = CIBlockSection::GetList(array("LEFT_MARGIN"=>"ASC"), $arFilterFirst, false, array("*"), array(
                            "nPageSize" => 1,
                            "bShowAll" => true
                        ));

                        while ($arSectionFirst = $rsSectionsFirst->Fetch())
                        {

                            echo "<option value='https://".SITE_SERVER_NAME.$APPLICATION->GetCurPage(false).$arSectionFirst[CODE]."/'>".$arSectionFirst[NAME]."</option>";

                        }
                        $arFilter = Array(
                            "IBLOCK_ID"=>2,
                            "ID" => array(8,142,144,146,148,149,152,160,169),
                            "ACTIVE" => 'Y'
                        );
                        $rsSections = CIBlockSection::GetList(array("LEFT_MARGIN"=>"ASC"), $arFilter, false, array("*"), array(
                            "nPageSize" => 100,
                            "bShowAll" => true
                        ));

                        while ($arSection = $rsSections->Fetch())
                        {

                            echo "<option value='https://".SITE_SERVER_NAME.$APPLICATION->GetCurPage(false).$arSection[CODE]."/'>".$arSection[NAME]."</option>";

                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="shops mt-5 w-100">
    <div class="d-flex flex-wrap w-100">
        <div class="col-12 col-md-9">
            <div class="row"><h2 class="title font-weight-800">Магазины в городе <span>
            	<?if ($APPLICATION->GetCurPage(false) == "/karta-magazinov/") {
                    echo "Москва";
                }else{
                    $APPLICATION->ShowTitle(false);
                }?>
            	</span></h2></div>
        </div>
        <div class="col-12 col-md-3 mt-3 mt-md-0">
            <div class="row justify-content-center">
                <div class="view active d-flex align-items-center mx-3 mb-2" data-tab="1">
                    <svg fill="#A5ACAF" width="22" height="19" viewBox="0 0 22 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="6.04883" width="15.5456" height="3.45457" rx="1"/>
                        <rect x="6.04883" y="7.77344" width="15.5456" height="3.45457" rx="1"/>
                        <rect x="6.04883" y="15.5449" width="15.5456" height="3.45457" rx="1"/>
                        <rect width="3.45457" height="3.45457" rx="1"/>
                        <rect y="7.77344" width="3.45457" height="3.45457" rx="1"/>
                        <rect y="15.5449" width="3.45457" height="3.45457" rx="1" />
                    </svg>
                    <span class="font-weight-500 ml-3">
                        <a href="" onclick="return false">Списком</a>
                    </span>
                </div>
                <div class="view d-flex align-items-center mx-3 mb-2" data-tab="2">
                    <svg fill="#A5ACAF" width="31" height="26" viewBox="0 0 31 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M27.4285 17.9079H26.2151C26.2472 17.7357 26.3195 17.5281 26.4672 17.2992C26.9219 16.5946 27.0191 15.9724 27.1048 15.4233C27.1589 15.0774 27.21 14.7506 27.3489 14.3736C27.472 14.0396 27.7087 13.7683 27.9511 13.5616L28.79 15.6293L30.4473 14.9569L27.4482 7.54102L26.7196 7.68845C26.6365 7.70527 24.6684 8.12689 23.4379 10.4056C22.5397 12.0689 20.5175 13.3603 18.0573 13.8778L17.567 12.0788L16.6925 12.3347C15.2483 12.7574 14.4087 13.1382 13.1164 13.9018C13.1094 13.9109 13.1022 13.9204 13.0953 13.9295L9.69824 18.4911H6.90999C6.90999 18.4911 5.34774 16.3616 4.45513 15.1734C3.95755 15.3631 3.52019 15.6389 3.13911 16.0027C2.17501 16.9232 1.78254 18.4462 2.09256 19.8396L0 21.2312L2.47418 25.7058H3.67436L4.60167 24.6622C5.53757 23.609 6.88233 23.005 8.29118 23.005C9.47962 23.005 10.6304 23.4359 11.5316 24.2181C12.5573 25.1084 13.5545 25.5972 14.4924 25.7014C15.5693 25.8211 16.2187 25.5576 17.088 25.2788C17.7469 25.0675 18.2503 24.8505 19.1138 24.9625C19.4787 25.0098 19.8108 25.0324 20.1151 25.0324C21.8218 25.0323 22.6398 24.3206 23.2843 23.263C23.507 22.8977 23.818 22.6876 24.1141 22.5943C24.8897 22.3499 25.6024 23.2594 25.6024 23.2594L27.2922 22.4289C27.5928 23.2563 27.7456 24.1218 27.7456 25.0052H29.5341C29.5341 23.8116 29.3094 22.6445 28.8662 21.5362L27.4285 17.9079Z"/>
                        <path d="M7.82491 16.7019H8.80057L11.6824 12.8433C12.8989 11.2517 14.5649 9.07207 14.5649 6.25216C14.5649 2.8047 11.7602 0 8.31277 0C4.86531 0 2.06055 2.8047 2.06055 6.25216C2.06055 9.07207 3.72653 11.2517 4.94305 12.8433L7.82491 16.7019ZM5.3357 6.25216C5.3357 4.61062 6.67122 3.2751 8.31277 3.2751C9.95431 3.2751 11.2898 4.61062 11.2898 6.25216C11.2898 7.8937 9.95431 9.22922 8.31277 9.22922C6.67122 9.22922 5.3357 7.89376 5.3357 6.25216Z"/>
                        <path d="M9.41031 6.70872C9.66169 6.10222 9.37382 5.40674 8.76732 5.15533C8.16082 4.90393 7.46536 5.19179 7.21397 5.7983C6.96258 6.40481 7.25046 7.10029 7.85696 7.35169C8.46346 7.6031 9.15892 7.31523 9.41031 6.70872Z"/>
                    </svg>
                    <span class="view font-weight-500 ml-3">
                        <a href="" onclick="return false">На карте</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="list active flex-wrap justify-content-between w-100 mt-4" data-tab="1">
        <? foreach($arResult["ITEMS"] as $item){?>
            <div class="shop d-md-flex d-block col-12 col-md-6 mb-4 mb-md-5">
                <div class="text-center d-md-block d-none"><a href="<?=$item[DETAIL_PAGE_URL]?>"><img src="<?=$item[PREVIEW_PICTURE][SRC]?>"></a></div>
                <div class="text-center d-block d-md-none"><a href="<?=$item[DETAIL_PAGE_URL]?>"><img src="<?=$item[PREVIEW_PICTURE][SRC]?>" class="w-100"></a></div>
                <div class="ml-md-4">
                    <div class="name font-weight-bold mb-1 mt-3 mt-md-0"><a href="<?=$item[DETAIL_PAGE_URL]?>"><?=$item[NAME]?></a></div>
                    <div class="description">
                        <div class="d-flex align-items-md-center mb-1">
                            <div>
                                <svg fill="#D0A550" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip5)">
                                        <path d="M18.11 5.45868C17.3702 3.06796 15.4253 1.12255 13.0346 0.382666C10.5043 -0.401143 7.8121 0.0344844 5.75718 1.54862C3.71739 3.05229 2.49976 5.46106 2.49976 7.99188C2.49976 9.7378 3.05207 11.3965 4.09662 12.7884L10.5002 21L16.9037 12.7878C18.467 10.7035 18.9069 8.03216 18.11 5.45868ZM10.5002 12.2998C8.12505 12.2998 6.19227 10.367 6.19227 7.99184C6.19227 5.61671 8.12505 3.68393 10.5002 3.68393C12.8753 3.68393 14.8081 5.61671 14.8081 7.99184C14.8081 10.367 12.8753 12.2998 10.5002 12.2998Z"/>
                                        <path d="M10.5021 4.92383C8.80551 4.92383 7.42505 6.29609 7.42505 7.9927C7.42505 9.68931 8.80551 11.0698 10.5021 11.0698C12.1987 11.0698 13.5792 9.68931 13.5792 7.9927C13.5792 6.29609 12.1987 4.92383 10.5021 4.92383Z"/>
                                    </g>
                                    <defs>
                                        <clipPath id="clip5">
                                            <rect width="21" height="21" fill="white"/>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            <?php if (!empty($item[PROPERTIES][Address_old][VALUE])): ?>
                                <span class="ml-3"><?=$item[PROPERTIES][Address_old][VALUE]?></span>
                            <?php endif ?>
                        </div>
                        <div class="d-flex align-items-md-center mb-1">
                            <div>
                                <svg fill="#D0A550" width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip6)">
                                        <path d="M7.03973 9.9607C5.41711 8.33808 5.05073 6.71546 4.96807 6.06536C4.94498 5.8856 5.00683 5.70533 5.13543 5.57763L6.44854 4.26512C6.6417 4.07208 6.67598 3.77123 6.53119 3.53968L4.44049 0.293271C4.28031 0.0368779 3.95143 -0.0556567 3.68106 0.0795981L0.324728 1.66031C0.10609 1.76796 -0.0225095 2.00026 0.00231439 2.2427C0.178176 3.91339 0.906538 8.02036 4.94257 12.0567C8.97861 16.093 13.085 16.8211 14.7566 16.9969C14.999 17.0218 15.2313 16.8932 15.339 16.6745L16.9197 13.3182C17.0544 13.0484 16.9625 12.7204 16.7072 12.5599L13.4607 10.4698C13.2293 10.3249 12.9285 10.3589 12.7353 10.5519L11.4228 11.865C11.2951 11.9936 11.1148 12.0555 10.9351 12.0324C10.285 11.9497 8.66235 11.5833 7.03973 9.9607Z"/>
                                        <path d="M13.4835 9.08681C13.1598 9.08681 12.8973 8.82436 12.8973 8.50061C12.8946 6.0736 10.9278 4.1068 8.50076 4.10405C8.177 4.10405 7.91455 3.8416 7.91455 3.51785C7.91455 3.19409 8.177 2.93164 8.50076 2.93164C11.575 2.93503 14.0663 5.42636 14.0697 8.50061C14.0697 8.82436 13.8073 9.08681 13.4835 9.08681Z"/>
                                        <path d="M16.4145 9.08621C16.0908 9.08621 15.8283 8.82375 15.8283 8.5C15.8238 4.45496 12.5458 1.17694 8.50076 1.17241C8.177 1.17241 7.91455 0.90996 7.91455 0.586207C7.91455 0.262454 8.177 0 8.50076 0C13.193 0.00516913 16.9956 3.80772 17.0008 8.5C17.0008 8.65547 16.939 8.80458 16.8291 8.91451C16.7191 9.02445 16.57 9.08621 16.4145 9.08621Z"/>
                                    </g>
                                    <defs>
                                        <clipPath id="clip6">
                                            <rect width="17" height="17" fill="white"/>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            <?php if (!empty($item[PROPERTIES][Phone_old][VALUE])): ?>

                                <span class="ml-3"><?=$item[PROPERTIES][Phone_old][VALUE]?></span>
                            <?php endif ?>
                        </div>
                        <div class="d-flex align-items-md-baseline mb-1">
                            <div>
                                <svg fill="#D0A550" width="20" height="15" viewBox="0 0 20 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip7)">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 13.3172H0.892026L5.87112 0.230469L9.52469 7.40842L13.2432 0.230469L18.6098 13.3172H19.5258V14.2305H13.0921V13.3172H14.019L12.3374 8.76656L9.52469 13.8748L6.90596 8.76656L5.22452 13.3172H6.14677V14.2305H0V13.3172Z"/>
                                    </g>
                                    <defs>
                                        <clipPath id="clip7">
                                            <rect width="19.5258" height="14" fill="white" transform="translate(0 0.230469)"/>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            <?php if (!empty($item[PROPERTIES][Metro_old][VALUE])): ?>
                                <span class="ml-3"><?=$item[PROPERTIES][Metro_old][VALUE]?></span>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="more mt-2">
                        <a href="<?=$item[DETAIL_PAGE_URL]?>" class="btn border-gold d-md-inline-block d-flex align-items-center text-gold text-center justify-content-center font-weight-500 px-2">
                            <span class="d-block px-3">Подробнее</span>
                        </a>
                    </div>
                </div>
            </div>
        <?}?>
        <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
            <?=$arResult["NAV_STRING"]?>
        <?endif;?>
    </div>
    <div class="list w-100 mt-4" data-tab="2">
        <div class="w-100" id="map"></div>
        <script type="text/javascript" src="https://api-maps.yandex.ru/2.1/?apikey=e7e71e58-6db4-4afa-8669-c0299f02bbd1&lang=ru_RU&load=package.full"></script>
        <!--<script defer src="<?=$templateFolder?>/ymap.js"></script>-->

        <?
        $mapCenter = '55.76, 37.64';
        foreach ($arResult["ITEMS"] as $item) {
            if (!empty($item['PROPERTIES']['Coordinates']['VALUE'])) {
                $mapCenter = $item['PROPERTIES']['Coordinates']['VALUE'];
                break;
            }
        }
        ?>

        <script>
            $(document).ready(function() {
                ymaps.ready(init);
                var myMap;

                function init() {
                    myMap = new ymaps.Map("map", {
                        center: [<?= $mapCenter; ?>],
                        zoom: 9,
                    });

                    let myPlacemark;

                    <? foreach($arResult["ITEMS"] as $item): ?>
                    <? if(!empty($item['PROPERTIES']['Coordinates']['VALUE'])): ?>
                    myPlacemark = new ymaps.Placemark([<?= $item['PROPERTIES']['Coordinates']['VALUE']; ?>], {
                        hintContent: '<?= $item['NAME']; ?>',
                        balloonContent: '<b><?= $item['NAME']; ?></b><br>Адрес: <?= $item['PROPERTIES']['Address_old']['VALUE']; ?><br>Телефон: <?= $item['PROPERTIES']['Phone_old']['VALUE']; ?>'
                    }, {
                        iconLayout: 'default#image',
                        //iconImageClipRect: [[34,0], [62, 46]],
                        iconImageHref: '/local/templates/aryahome/img/map/map.svg',
                        //iconImageSize: [26, 46],
                        //iconImageOffset: [-26, -46]
                    });
                    myMap.geoObjects.add(myPlacemark);
                    <? endif; ?>
                    <? endforeach; ?>
                }
            });
        </script>

        <script>
            //map
            $(document).ready(function() {
                $('.catalog .region .type .title-5').on('click', function() {
                    $(this).parents('.region').first().find('.type').removeClass('active');
                    $(this).parents('.type').addClass('active');
                    regionActive(this);
                });
                $('.catalog .shops .view').on('click', function() {
                    $(this).parents('.shops').first().find('.view').removeClass('active');
                    $(this).addClass('active');
                    console.log(1);
                    viewMapActive(this);
                });
            });
            function regionActive(elem){
                var active = $(elem).parents('.region').find('.type.active').attr('data-tab');
                $('.catalog .region .select').find('select').removeClass('active');
                $('.catalog .region .select').find('select[data-tab="'+active+'"]').addClass('active');
            }
            function viewMapActive(elem){
                var active = $(elem).parents('.shops').find('.view.active').attr('data-tab');
                $('.catalog .shops').find('.list').removeClass('active');
                $('.catalog .shops').find('.list[data-tab="'+active+'"]').addClass('active');
            }
            function ajaxLoadShops(url,town){
                var targetContainer = $('.content .shops .list[data-tab="1"]');          //  Контейнер, в котором хранятся элементы
                //var mapContainer = $('.content .shops .list[data-tab="2"]');
                if (url !== undefined) {
                    $.ajax({
                        type: 'GET',
                        url: url,
                        dataType: 'html',
                        success: function(data){
                            $('.catalog .shops h2').find('span').html(town);
                            var elements = $(data).find('.shops .list[data-tab="1"] .shop'),    //  Ищем элементы
                                //map = $(data).find('.shops .list[data-tab="2"] #map'),
                                pagination = $(data).find('.load-product');//  Ищем навигацию
                                targetContainer.html(elements);   //  Добавляем посты
                                targetContainer.append(pagination); //  добавляем навигацию следом
                                //mapContainer.html(map);
                        }
                    })
                }
            }
        </script>

    </div>
</div>
