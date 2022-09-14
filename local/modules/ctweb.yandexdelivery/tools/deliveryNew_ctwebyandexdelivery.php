<?
use Bitrix\Main\Config\Option;

CModule::IncludeModule("sale");
IncludeModuleLangFile(__FILE__);

if (!class_exists('CDeliveryCtwebYandexDelivery')) {
    class CDeliveryCtwebYandexDelivery
    {
        protected static $module_id = 'ctweb.yandexdelivery';
        protected static $link_id = '';
        protected static $flag = true;

        public static function ShowComponent()
        {
            CModule::IncludeModule(self::$module_id);

            if(self::$flag === true) {
                self::$flag = false;
                self::$link_id = $GLOBALS['APPLICATION']->IncludeComponent("ctweb:yandexdelivery", "order", array(), false);
                self::$link_id .= "link";
            }
        }

        private static function getLink()
        {
            return "<a href='javascript:void(0);' id='".self::$link_id."'>" . GetMessage("SELECT_LINK_TEXT") . "</a>";
        }

        public static function Init()
        {
            CModule::IncludeModule(self::$module_id);

            if (class_exists('SaleOrderAjax') && strpos($GLOBALS["APPLICATION"]->GetCurPage(), 'bitrix/admin') === false || !ADMIN_SECTION) {
                self::ShowComponent();
            }

            return array(
                "SID" => self::$module_id,
                "NAME" => GetMessage('CWYD_DELIVERY_NAME'),
                "DESCRIPTION" => "",
                "DESCRIPTION_INNER" => GetMessage('DESCRIPTION_INNER'),
                "BASE_CURRENCY" => COption::GetOptionString("sale", "default_currency", "RUB"),
                "HANDLER" => __FILE__,
                "DBGETSETTINGS" => array("CDeliveryCtwebYandexDelivery", "GetSettings"),
                "DBSETSETTINGS" => array("CDeliveryCtwebYandexDelivery", "SetSettings"),
                "GETCONFIG" => array("CDeliveryCtwebYandexDelivery", "GetConfig"),

                "COMPABILITY" => array("CDeliveryCtwebYandexDelivery", "Compability"),
                "CALCULATOR" => array("CDeliveryCtwebYandexDelivery", "Calculate"),

                'PROFILES' => array(
                    'POINT' => array(
                        'TITLE' => GetMessage('YANDEXDELIVERY_POINT'),
                        'DESCRIPTION' => "",
                    )
                )
            );
        }

        public static function GetConfig()
        {
            $arConfig = array(
                "CONFIG" => array(
                    "default" => array(),
                )
            );
            return $arConfig;
        }

        public static function SetSettings($arSettings)
        {
            foreach ($arSettings as $key => $value) {
                if (strlen($value) > 0)
                    $arSettings[$key] = ($value);
                else
                    unset($arSettings[$key]);
            }

            return serialize($arSettings);
        }

        public static function GetSettings($strSettings)
        {
            $settings = unserialize($strSettings);
            if (empty($settings)) return;
            return $settings;
        }

        public static function Compability($arOrder, $arConfig)
        {
            $module_status = \CModule::IncludeModuleEx(self::$module_id);
            if ($module_status < 3 && $module_status > 0) {
                return array('POINT');
            }
            return false;
        }

        public static function Calculate($profile, $arConfig, $arOrder, $STEP, $TEMP = false)
        {
            $module_status = \CModule::IncludeModuleEx(self::$module_id);
            if ($module_status < 3 && $module_status > 0) {
                ?>
                <script>
                    let deliveryAddress = '';
                </script>
                <?
                if (isset($_SESSION['yandexdelivery_point'])) {
                    CModule::IncludeModule(self::$module_id);
                    $point = $_SESSION['yandexdelivery_point'];
                    $arPrice = \CCtwebYandexDelivery::calculatePrice(
                        $point['calculated']['regionID'],
                        $point['calculated']['storeID'],
                        $point['calculated']['distance']
                    );
                    ?>
                    <script>
                        deliveryAddress = '<?=$_SESSION['yandexdelivery_point']['calculated']['address']?>';
                    </script>
                    <?
                    if ($arPrice === false)
                        return array(
                            "RESULT" => "ERROR",
                            "TEXT" => GetMessage('ERROR_NO_POINT_TEXT') . ' ' . self::getLink()
                        );

                    if ($arPrice['PRICE_FREE'] > 0 && $arOrder['PRICE'] >= $arPrice['PRICE_FREE'])
                        $arPrice['SET_FREE'] = 'Y';

                    foreach (GetModuleEvents(self::$module_id, 'OnAfterYandexDeliveryCalculatePrice', true) as $arr) {
                        ExecuteModuleEventEx($arr, array(
                            &$arPrice,
                            $arOrder,
                            array(
                                'DISTANCE' => $point['calculated']['distance'],
                                'REGION_ID' => $point['calculated']['regionID'],
                                'STORE_ID' => $point['calculated']['storeID'],
                            )
                        ));
                    }
                    
                    //наценки и скидка по зонам за количество товара
                    foreach($arOrder['ITEMS'] as $orderItem){ 
//                         //применяем бесплатную доставку если есть
//                         $db_props = CIBlockElement::GetProperty(26, $orderItem['PRODUCT_ID'], array("sort" => "asc"), Array("CODE"=>"MULTIPAK"));
//                         if($ar_props = $db_props->Fetch())
//                             $multipak = IntVal($ar_props["VALUE"]);
//                         if(
//                         (($point['calculated']['regionID'] == 1 || $point['calculated']['regionID'] == 3) &&
//                         IntVal($orderItem['QUANTITY']) >= $multipak
//                         ) || 
//                         (($point['calculated']['regionID'] == 5) &&
//                         IntVal($orderItem['QUANTITY']) >= ($multipak * 2)
//                         ) || 
//                         (($point['calculated']['regionID'] == 7 || $point['calculated']['regionID'] == 8) &&
//                         IntVal($orderItem['QUANTITY']) >= ($multipak * 3)
//                         ) ||
//                         (($point['calculated']['regionID'] == 9 || $point['calculated']['regionID'] == 10) &&
//                         IntVal($orderItem['QUANTITY']) >= ($multipak * 4)
//                         )
//                         )
//                             $arPrice['SET_FREE'] = 'Y';
                            
                        $orderQuantity += $orderItem['QUANTITY'];
                    }

                    if(SITE_ID == 's1') {
                        //скидки по товарам и зонам
                        if (
                            (($point['calculated']['regionID'] == 3 || $point['calculated']['regionID'] == 5) &&
                                $orderQuantity > 8
                            ) ||
                            (($point['calculated']['regionID'] == 7 || $point['calculated']['regionID'] == 8) &&
                                $orderQuantity > 17
                            ) ||
                            ($point['calculated']['regionID'] == 9 &&
                                $orderQuantity > 26
                            ) ||
                            ($point['calculated']['regionID'] == 10 &&
                                $orderQuantity > 35
                            )
                        )
                            $arPrice['SET_FREE'] = 'Y';

                        if ($arPrice['SET_FREE'] === 'Y')
                            $arPrice['PRICE'] = 0;

                    }else{

                        if(SITE_ID == 's1'){
                            $torg = 9;
                            $brigadir = 10;
                        }elseif (SITE_ID == 's2'){
                            $torg = 14;
                            $brigadir = 15;
                        }elseif (SITE_ID == 's3'){
                            $torg = 16;
                            $brigadir = 17;
                        }elseif (SITE_ID == 's4'){
                            $torg = 19;
                            $brigadir = 20;
                        }elseif (SITE_ID == 's5'){
                            $torg = 21;
                            $brigadir = 22;
                        }elseif (SITE_ID == 's6'){
                            $torg = 23;
                            $brigadir = 24;
                        }else{
                            $torg = 9;
                            $brigadir = 10;
                        }

                        global $USER;

                        if(in_array($torg, $USER->GetUserGroupArray()) or in_array($brigadir, $USER->GetUserGroupArray())) {
                            if (
                                (($point['calculated']['regionID'] == 11 || $point['calculated']['regionID'] == 14) &&
                                    $orderQuantity > 17
                                ) ||
                                (($point['calculated']['regionID'] == 15 || $point['calculated']['regionID'] == 16) &&
                                    $orderQuantity > 17
                                ) ||
                                // ($point['calculated']['regionID'] == 9 &&
                                //     $orderQuantity > 17
                                // ) ||
                                ($point['calculated']['regionID'] == 17 &&
                                    $orderQuantity > 35
                                )
                            ) {
                                $arPrice['SET_FREE'] = 'Y';
                                if ($arPrice['SET_FREE'] === 'Y') {
                                    $arPrice['PRICE'] = 0;
                                }
                            }

                            if (
                                (($point['calculated']['regionID'] == 12 || $point['calculated']['regionID'] == 18) &&
                                    $orderQuantity > 17
                                ) ||
                                (($point['calculated']['regionID'] == 19 || $point['calculated']['regionID'] == 20) &&
                                    $orderQuantity > 17
                                ) ||
                                // ($point['calculated']['regionID'] == 9 &&
                                //     $orderQuantity > 17
                                // ) ||
                                ($point['calculated']['regionID'] == 21 &&
                                    $orderQuantity > 35
                                )
                            ) {
                                $arPrice['SET_FREE'] = 'Y';
                                if ($arPrice['SET_FREE'] === 'Y') {
                                    $arPrice['PRICE'] = 0;
                                }
                            }

                            //Ростов-на-Дону
                            if (
                                (($point['calculated']['regionID'] == 11) &&
                                    $orderQuantity > 8
                                ) ||
                                (($point['calculated']['regionID'] == 14 || $point['calculated']['regionID'] == 15) &&
                                    $orderQuantity > 17
                                ) ||
                                ($point['calculated']['regionID'] == 16 &&
                                    $orderQuantity > 26
                                ) ||
                                ($point['calculated']['regionID'] == 17 &&
                                    $orderQuantity > 35
                                )
                            ) {
                                $arPrice['SET_FREE'] = 'Y';

                                if ($arPrice['SET_FREE'] === 'Y') {
                                    $arPrice['PRICE'] = 0;
                                }
                            }

                            //Краснодар
                            if (
                                (($point['calculated']['regionID'] == 12) &&
                                    $orderQuantity > 8
                                ) ||
                                (($point['calculated']['regionID'] == 18 || $point['calculated']['regionID'] == 19) &&
                                    $orderQuantity > 17
                                ) ||
                                ($point['calculated']['regionID'] == 20 &&
                                    $orderQuantity > 26
                                ) ||
                                ($point['calculated']['regionID'] == 21 &&
                                    $orderQuantity > 35
                                )
                            ) {
                                $arPrice['SET_FREE'] = 'Y';

                                if ($arPrice['SET_FREE'] === 'Y') {
                                    $arPrice['PRICE'] = 0;
                                }
                            }
                            // Казань
                            if (
                                (($point['calculated']['regionID'] == 23) &&
                                    $orderQuantity > 8
                                ) ||
                                (($point['calculated']['regionID'] == 24 || $point['calculated']['regionID'] == 25) &&
                                    $orderQuantity > 17
                                ) ||
                                ($point['calculated']['regionID'] == 26 &&
                                    $orderQuantity > 26
                                ) ||
                                ($point['calculated']['regionID'] == 27 &&
                                    $orderQuantity > 35
                                )
                            ) {
                                $arPrice['SET_FREE'] = 'Y';
                                if ($arPrice['SET_FREE'] === 'Y') {
                                    $arPrice['PRICE'] = 0;
                                }
                            }

                            // Новосибирск
                            if (
                                (($point['calculated']['regionID'] == 28) &&
                                    $orderQuantity > 8
                                ) ||
                                (($point['calculated']['regionID'] == 29 || $point['calculated']['regionID'] == 30) &&
                                    $orderQuantity > 17
                                ) ||
                                ($point['calculated']['regionID'] == 31 &&
                                    $orderQuantity > 26
                                ) ||
                                ($point['calculated']['regionID'] == 32 &&
                                    $orderQuantity > 35
                                )
                            ) {
                                $arPrice['SET_FREE'] = 'Y';
                                if ($arPrice['SET_FREE'] === 'Y') {
                                    $arPrice['PRICE'] = 0;
                                }
                            }

                            // СПБ
                            if (
                                (($point['calculated']['regionID'] == 33) &&
                                    $orderQuantity > 8
                                ) ||
                                (($point['calculated']['regionID'] == 34 || $point['calculated']['regionID'] == 35) &&
                                    $orderQuantity > 17
                                ) ||
                                ($point['calculated']['regionID'] == 36 &&
                                    $orderQuantity > 26
                                ) ||
                                ($point['calculated']['regionID'] == 37 &&
                                    $orderQuantity > 35
                                )
                            ) {
                                $arPrice['SET_FREE'] = 'Y';
                                if ($arPrice['SET_FREE'] === 'Y') {
                                    $arPrice['PRICE'] = 0;
                                }
                            }
                        }
                    }

//                     if ($orderQuantity > 8 && $orderQuantity < 65 && $arPrice['PRICE'] != 0){
//                         if ($point['calculated']['regionID'] == 1 || $point['calculated']['regionID'] == 3)
//                             $arPrice['PRICE'] += 660;
//                         if ($point['calculated']['regionID'] == 5)
//                             $arPrice['PRICE'] += 840;
//                         if ($point['calculated']['regionID'] == 7)
//                             $arPrice['PRICE'] += 960;
//                         if ($point['calculated']['regionID'] == 8)
//                             $arPrice['PRICE'] += 1200;
//                         if ($point['calculated']['regionID'] == 9)
//                             $arPrice['PRICE'] += 1320;
//                         if ($point['calculated']['regionID'] == 10)
//                             $arPrice['PRICE'] += 2400;
//                     }else if ($orderQuantity > 64 && $arPrice['PRICE'] != 0){
//                         $orderQuantity = ceil(($orderQuantity - 64) / 32);
//                         $summ = 1980*$orderQuantity;
//                         $arPrice['PRICE'] += $summ;
//                     }
                    
                    $address = $point['calculated']['address'];

                    return array(
                        "RESULT" => "OK",
                        'VALUE' => $arPrice['PRICE'],
                        "TRANSIT" => $address . '<br>' . self::getLink()
                    );
                } else {
                    if(SITE_ID !== 'ru') {
                        return array(
                            "RESULT" => "ERROR",
                            "TEXT" => GetMessage('ERROR_NO_POINT_TEXT') . ' ' . self::getLink()
                        );
                    }
                }
            } else {
                $message = GetMessage('ERROR_DEMO_EXPIRED_TEXT');
                return array(
                    "RESULT" => "ERROR",
                    "TEXT" => $message
                );
            }
        }

        public static function OnOrderAdd($ID, $arFields, $orderFields, $isNew)
        {
            if ($isNew) {
                if (\CModule::IncludeModule('sale')) {

                    $allDeliverys = \Bitrix\Sale\Delivery\Services\Manager::getActiveList();
                    $arDelivery = array_keys(array_filter($allDeliverys, function ($profiles) {
                        if (strpos($profiles['CODE'], self::$module_id) !== false) {
                            return true;
                        }
                    }));

                    if (in_array($arFields['DELIVERY_ID'], $arDelivery)) {
                        $point = $_SESSION['yandexdelivery_point'];

                        if ($point) {
                            $obStore = \Ctweb\YandexDelivery\Store::getByID(intval($point['calculated']['storeID']));

                            $address_prop_code = Option::get(self::$module_id, 'FIELD_ADDRESS_PROP_CODE', 'ADDRESS');

//                             $val = "(" . GetMessage("CW_YD_DELIVERY_FROM") . ": [{$obStore->getName()}] {$obStore->getAddress()} " . GetMessage("CW_YD_DELIVERY_TO") . " {$_SESSION['yandexdelivery_point']['calculated']['address']}. GEO: [{$point['pointTo'][0]}, {$point['pointTo'][1]}])";
                            $val = $_SESSION['yandexdelivery_point']['calculated']['address'];

                            if ($arProp = \CSaleOrderProps::GetList(array(), array('PERSON_TYPE_ID' => $arFields['PERSON_TYPE_ID'], 'CODE' => $address_prop_code))->Fetch()) {
//                                 if (!empty($orderFields['ORDER_PROP'][intval($arProp['ID'])]))
//                                     $val = $orderFields['ORDER_PROP'][intval($arProp['ID'])] . " --- $val";
                                $res = self::AddOrderProperty($ID, $arProp['ID'], $val);
                            }

                            unset($_SESSION['yandexdelivery_point']);
                        }
                    }
                }
            }
        }

        function AddOrderProperty($order, $prop_id, $value)
        {
            if (!strlen($prop_id)) {
                return false;
            }
            if (\CModule::IncludeModule('sale')) {
                if ($arOrderProps = \CSaleOrderProps::GetByID($prop_id)) {
                    $db_vals = \CSaleOrderPropsValue::GetList(array(), array('ORDER_ID' => $order, 'ORDER_PROPS_ID' => $arOrderProps['ID']));
                    if ($arVals = $db_vals->Fetch()) {
                        return \CSaleOrderPropsValue::Update($arVals['ID'], array(
                            'NAME' => $arVals['NAME'],
                            'CODE' => $arVals['CODE'],
                            'ORDER_PROPS_ID' => $arVals['ORDER_PROPS_ID'],
                            'ORDER_ID' => $arVals['ORDER_ID'],
                            'VALUE' => $value,
                        ));
                    } else {
                        return \CSaleOrderPropsValue::Add(array(
                            'NAME' => $arOrderProps['NAME'],
                            'CODE' => $arOrderProps['CODE'],
                            'ORDER_PROPS_ID' => $arOrderProps['ID'],
                            'ORDER_ID' => $order,
                            'VALUE' => $value,
                        ));
                    }
                }
            }
        }
    }

    AddEventHandler("sale", "onSaleDeliveryHandlersBuildList", array('CDeliveryCtwebYandexDelivery', 'Init'));
    AddEventHandler("sale", "OnSaleComponentOrderJsData", array('CDeliveryCtwebYandexDelivery', 'ShowComponent'));
    AddEventHandler("sale", "OnOrderSave", array('CDeliveryCtwebYandexDelivery', 'OnOrderAdd'));
}
