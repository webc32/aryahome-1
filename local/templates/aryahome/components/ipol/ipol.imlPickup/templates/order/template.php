<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/js/'.CDeliveryIML::$MODULE_ID.'/jsloader.php');
global $APPLICATION;
$pathToYmaps = 'https://api-maps.yandex.ru/2.1/?lang=ru_RU';
if($arParams['NOMAPS']!='Y')
    $APPLICATION->AddHeadString('<script src="'.$pathToYmaps.'" type="text/javascript"></script>');
$APPLICATION->AddHeadString('<link href="/bitrix/js/'.CDeliveryIML::$MODULE_ID.'/jquery.jscrollpane.css" type="text/css"  rel="stylesheet" />');

$exist = COption::GetOptionString(CDeliveryIML::$MODULE_ID,'pvzID',false);
$profId = CDeliveryIML::getDeliveryId('pickup','_');

if($exist)
    $profObj = array($exist => array(
        'tag' => false,
        'price' => false,
        'self' => true,
        'link' => array_pop($profId)
    ));
else{
    $profObj = array();
    foreach($profId as $id){
        $profObj[$id] = array(
            'tag' => false,
            'price' => false,
            'self' => false
        );
    }
}
?>
<script id='IPOLIML_script'>
    var IPOLIML_pvz = {
        // html of 'choose PVZ'-btn.
        button: '<a href="javascript:void(0);" class="IML_selectPVZ" onclick="IPOLIML_pvz.selectPVZ(\'#id#\'); return false;"><?=GetMessage("IPOLIML_FRNT_CHOOSEPICKUP")?></a>',

        // if opened
        isActive: false,

        // which delivery is currently used
        curDelivery : '<?=CDeliveryIML::$selDeliv?>',

        // which profile is currently used
        curProfile: false,

        deliveries: <?=CUtil::PhpToJSObject($profObj)?>,

        // name of the city
        city: '<?=CDeliveryIML::$city?>'.replace('<?=GetMessage("IPOLIML_LETTER_YO")?>','<?=GetMessage("IPOLIML_LETTER_E")?>'),

        // PVZ in baloon
        activePVZ: false,

        payer: <?=($arParams['PAYER']) ? $arParams['PAYER'] : 'false'?>,

        paysystem: <?=($arParams['PAYSYSTEM']) ? $arParams['PAYSYSTEM'] : 'false'?>,

        // inputs, where PVZ-addres is loading
        pvzInputs: [<?=substr($arResult['propAddr'],0,-1)?>],

        // payment type
        pay: 'nal',

        postomatMode: '<?=($arParams['NO_POSTOMAT'] == 'Y') ? 'off' : 'on'?>', // later mae by moar

        showPrice: <?=(COption::GetOptionString(CDeliveryIML::$MODULE_ID,'countType','T') == 'S')?'true':'false'?>,

        pickFirst: function(where){
            if(typeof(where) !== 'object')
                return false;
            for(var i in where)
                return i;
        },

        makeHTMLId: function(id){
            return 'ID_DELIVERY_' + ((id === 'iml_pickup') ?  id : 'ID_'+id);
        },

        checkCheckedDel: function(delId,delivery){
            for(var i in delivery)
                if(delivery[i].CHECKED === 'Y'){
                    if(delivery[i].ID == delId)
                        return true;
                    else
                        return false;
                }
            return false;
        },

        guessCheckedDel: function(delId){
            return ('ID_DELIVERY_ID_'+delId == $('[name="DELIVERY_ID"]:checked').attr('ID'));
        },

        oldTemplate: false,

        //jq-object of element, where we put pvz-button
        pvzLabel: '',

        pvzPrice: false,

        PVZ: {
            <?foreach($arResult['PVZ'] as $city => $deliveryPoints){?>
            '<?=$city?>':{
                <?foreach($deliveryPoints as $dpId => $descr){
                if(
                (!$descr['maxW'] || CDeliveryIML::$orderWeight <= $descr['maxW']*1000) &&
                (!$descr['maxP'] || CDeliveryIML::$orderPrice  <= $descr['maxP'])
                ){
                ?>
                '<?=$dpId?>':{
                    'address' : '<?=$descr['ADDRESS']?>',
                    'way'     : '<?=$descr['WAY']?>',
                    'path'    : '<?=$descr['PATH']?>',
                    'time'    : '<?=$descr['TIME']?>',
                    'color'   : '<?=$descr['COLOR']?>',
                    'coords'  : <?=($descr['COORDS'])?"[{$descr['COORDS']['Latitude']},{$descr['COORDS']['Longitude']}]":"false"?>,
                    'phone'   : '<?=$descr['PHONE']?>',
                    'paynal'  : <?=($descr['CASH']) ? 'true' : 'false'?>, // just 4 sure
                    'paycard' : <?=($descr['CARD']) ? 'true' : 'false'?>,
                    'fitting' : <?=($descr['FITTING']) ? 'true' : 'false'?>,
                    'type'	  : '<?=$descr['TYPE']?>',
                    <?=($descr['OPEN'])?"'open':'{$descr['OPEN']}',":''?>
                    <?=($descr['CLOSE'])?"'close':'{$descr['CLOSE']}',":''?>
                },
                <?}}?>
            },
            <?}?>
        },

        // object of city PVZ + coordinates 4 yandex
        cityPVZ: {},

        // currently chosen PVZ
        curPVZ: false,

        // scroll of detail information
        scrollDetail: false,

        init: function(){
            if(!IPOLIML_pvz.pickFirst(IPOLIML_pvz.deliveries)){
                console.log('IML vidjet error: no delivery for PVZ');
                return false;
            }

            IPOLIML_pvz.oldTemplate = $('#ORDER_FORM').length;

            // ==== subscribe for form-reloading
            if(typeof BX !== 'undefined' && BX.addCustomEvent)
                BX.addCustomEvent('onAjaxSuccess', IPOLIML_pvz.onLoad);

            // old js-core
            if (window.jsAjaxUtil) // rewriting ajax-final function
            {
                jsAjaxUtil._CloseLocalWaitWindow = jsAjaxUtil.CloseLocalWaitWindow;
                jsAjaxUtil.CloseLocalWaitWindow = function (TID, cont)
                {
                    jsAjaxUtil._CloseLocalWaitWindow(TID, cont);
                    IPOLIML_pvz.onLoad();
                }
            }
            // == END
			
			 $(document).on("click",'.IML_burger', function(){
				$('#IML_info').toggleClass('active');
			});
			$(document).mouseup(function (e){ // отслеживаем событие клика по веб-документу
				var block = $("#IML_info"); // определяем элемент, к которому будем применять условия (можем указывать ID, класс либо любой другой идентификатор элемента)
				if (!block.is(e.target) // проверка условия если клик был не по нашему блоку
					&& block.has(e.target).length === 0) { // проверка условия если клик не по его дочерним элементам
					block.removeClass('active'); // если условия выполняются - скрываем наш элемент
				}
			});

            IPOLIML_pvz.onLoad();

            //html of the mask
            $('body').append("<div id='IML_mask'></div>");
        },

        getPrices: function(){
            $.ajax({
                url: '/bitrix/js/<?=CDeliveryIML::$MODULE_ID?>/ajax.php',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    action: 'countDelivery',
                    cityTo: IPOLIML_pvz.city,
                    weight: '<?=CDeliveryIML::$orderWeight?>',
                    price : '<?=CDeliveryIML::$orderPrice?>',
                    gabs  : <?=CUtil::PhpToJSObject(CDeliveryIML::$orderGabs)?>,
                    CURPROF: IPOLIML_pvz.curProfile,
                    pvz: IPOLIML_pvz.pvzId,
                    pay: IPOLIML_pvz.pay,
                    // count restricts
                    DELIVERY   : IPOLIML_pvz.curDelivery,
                    PERSON_TYPE_ID : IPOLIML_pvz.payer,
                    PAY_SYSTEM_ID  : IPOLIML_pvz.paysystem
                },
                success: function(data){
                    if(data.pickup !== 'no'){
                        $('#IML_pPrice').html(data.pickup);
                        $('#IML_pDate').html(data.date);
                    }else{
                        $('#IML_pPrice').html("");
                        $('#IML_pDate').html("<?=GetMessage("IPOLIML_NO_DELIV")?>");
                    }
                }
            });
        },

        onLoad: function(ajaxAns){
            // place for button choose pvz
            var tag = false;

            var newTemplateAjax = (typeof(ajaxAns) !== 'undefined' && ajaxAns !== null && typeof(ajaxAns.iml) === 'object');
            IPOLIML_pvz.activePVZ = false;

            var imlChecker = false;
            var newCity    = false;
            if(newTemplateAjax){
                newCity           = ajaxAns.iml.city;
                IPOLIML_pvz.pay   = ajaxAns.iml.checkPS;
                imlChecker        = ajaxAns.iml.dostav;  // profile
                IPOLIML_pvz.payer = ajaxAns.iml.payer;
                IPOLIML_pvz.paysystem  = ajaxAns.iml.paysystem;
            }else{
                if($('#iml_city').length>0)
                    newCity = $('#iml_city').val();
                if($('#iml_checkPS').length>0)
                    IPOLIML_pvz.pay = $('#iml_checkPS').val();
                if($('#iml_payer').length>0){
                    IPOLIML_pvz.payer = $('#iml_payer').val();
                }
                if($('#iml_paysystem').length>0){
                    IPOLIML_pvz.paysystem = $('#iml_paysystem').val();
                }
                if($('#iml_dostav').length>0){
                    imlChecker = $('#iml_dostav').val();
                    imlChecker = (imlChecker === 'iml:pickup') ? 'iml_pickup' : imlChecker;
                }
            }

            if(newCity){
                newCity = newCity.replace('<?=GetMessage("IPOLIML_LETTER_YO")?>','<?=GetMessage("IPOLIML_LETTER_E")?>');
                if(IPOLIML_pvz.city !== newCity){
                    IPOLIML_pvz.pvzId = false;
                    IPOLIML_pvz.city  = newCity;
                }
            }

            if(imlChecker){
                IPOLIML_pvz.curDelivery = imlChecker;
            }

            var initPrices = false;

            for(var i in IPOLIML_pvz.deliveries){
                tag = false;
                if(IPOLIML_pvz.deliveries[i].self)
                    tag = $('#'+i);
                else{
                    if(IPOLIML_pvz.oldTemplate){
                        var parentNd=$('#'+IPOLIML_pvz.makeHTMLId(i));
                        if(parentNd.closest('td', '#ORDER_FORM').length>0)
                            tag = parentNd.closest('td', '#ORDER_FORM').siblings('td:last');
                        else
                            tag = parentNd.siblings('label').find('.bx_result_price');
                    }
                    else{
                        if(
                            (arguments.length > 0 && typeof(ajaxAns.order) !== 'undefined' && IPOLIML_pvz.checkCheckedDel(i,ajaxAns.order.DELIVERY))
                            ||
                            (arguments.length === 0 && IPOLIML_pvz.guessCheckedDel(i))
                        ){
                            if(!$('#IPOLIML_injectHere').length)
                                $('#bx-soa-delivery').find('.bx-soa-pp-company-desc').after('<div id="IPOLIML_injectHere"></div>');
                            if($('#IPOLIML_injectHere').length === 0){
                                $('#bx-soa-delivery .bx-soa-section-title-container').on('click',function(){IPOLIML_pvz.onLoad();});
                                IPOLIML_pvz.newTemplateLoader.listner();
                            }else
                                tag = $('#IPOLIML_injectHere');
                        }
                    }
                }
                if(tag.length>0 && !tag.find('.IML_selectPVZ').length){
                    IPOLIML_pvz.deliveries[i].price = (tag.html()) ? tag.html() : false;
                    IPOLIML_pvz.deliveries[i].tag = tag;
                    initPrices = true;
                    IPOLIML_pvz.labelPzv(i);
                }
            }

            if(!IPOLIML_pvz.city)
                IPOLIML_pvz.loadProfile();

            if(typeof(IPOLIML_pvz.deliveries[imlChecker]) !== 'undefined' && IPOLIML_pvz.pvzId)
                IPOLIML_pvz.choozePVZ(IPOLIML_pvz.pvzId,true);

            IPOLIML_pvz.curPVZ=false;

            // counting only for loading info for widjet
            if(initPrices){
                IPOLIML_pvz.getPrices();
            }

            IPOLIML_pvz.filter.init();
        },

        newTemplateLoader: {
            timer   : false,
            listner : function (){
                if(IPOLIML_pvz.newTemplateLoader.timer){
                    clearTimeout(IPOLIML_pvz.newTemplateLoader.timer);
                    IPOLIML_pvz.newTemplateLoader.timer = false;
                    IPOLIML_pvz.onLoad();
                }else{
                    IPOLIML_pvz.newTemplateLoader.timer = setTimeout(IPOLIML_pvz.newTemplateLoader.listner, 1000);
                }
            }
        },

        labelPzv: function(i){
            if(typeof(IPOLIML_pvz.deliveries[i]) === 'undefined')
                return false;
            var tmpHTML = "<div class='iml_pvzLair'>"+IPOLIML_pvz.button.replace('#id#',i) + "<br>";
            if(IPOLIML_pvz.pvzId && typeof(IPOLIML_pvz.PVZ[IPOLIML_pvz.city.toUpperCase()][IPOLIML_pvz.pvzId]) !== 'undefined')
                tmpHTML += "<span class='iml_pvzAddr'>" + IPOLIML_pvz.PVZ[IPOLIML_pvz.city.toUpperCase()][IPOLIML_pvz.pvzId].address+"</span><br>";
            if(IPOLIML_pvz.deliveries[i].price)
                tmpHTML += IPOLIML_pvz.deliveries[i].price;
            tmpHTML += "</div>";

            IPOLIML_pvz.deliveries[i].tag.html(tmpHTML);
            if(!IPOLIML_pvz.oldTemplate)
                $('.iml_pvzLair .IML_selectPVZ').addClass('btn bg-active d-inline-block border-none round text-white py-3 px-2 px-md-4 mt-3');
        },

        // loading PVZ for bitrix profile
        loadProfile:function(){
            var chznPnkt=false;
            for(var i in IPOLIML_pvz.pvzInputs){
                chznPnkt = $('#ORDER_PROP_'+IPOLIML_pvz.pvzInputs[i]);
                if(chznPnkt.length>0)
                    break;
            }
            if(!chznPnkt || chznPnkt.length===0) return;

            var seltdPVZ = chznPnkt.val();
            if(seltdPVZ.indexOf('#L')===-1) return;

            seltdPVZ=parseInt(seltdPVZ.substr(seltdPVZ.indexOf('#L')+2));

            if(seltdPVZ<=0 || typeof IPOLIML_pvz.PVZ[IPOLIML_pvz.city.toUpperCase()] === 'undefined' || typeof IPOLIML_pvz.PVZ[IPOLIML_pvz.city.toUpperCase()][seltdPVZ] === 'undefined')
                return false;

            // we choose PVZ
            IPOLIML_pvz.pvzAdress=IPOLIML_pvz.city+", "+IPOLIML_pvz.PVZ[IPOLIML_pvz.city.toUpperCase()][seltdPVZ]['address']+" #L"+seltdPVZ;
            IPOLIML_pvz.pvzId = seltdPVZ;

            // Labeling info about PVZ
            for(var i in IPOLIML_pvz.deliveries)
                if(IPOLIML_pvz.deliveries[i].tag)
                    IPOLIML_pvz.labelPzv(i);
        },

        // loading PVZ for current city
        initCityPVZ: function(mode){
            var city = IPOLIML_pvz.city.toUpperCase();
            var cnt = [];
            IPOLIML_pvz.cityPVZ = {};

            if(typeof(mode) === 'undefined'){
                mode = IPOLIML_pvz.filter.mode;
            }

            for(var i in IPOLIML_pvz.PVZ[city]){
                if(
                    mode === 'all' ||
                    (mode === 'pvz'  && IPOLIML_pvz.PVZ[city][i].type !== 'POSTOMAT') ||
                    (mode === 'postamat' && IPOLIML_pvz.PVZ[city][i].type === 'POSTOMAT')
                ){
                    IPOLIML_pvz.cityPVZ[i] = IPOLIML_pvz.PVZ[city][i];
                    if(typeof(IPOLIML_pvz.cityPVZ[i].price) !== 'undefined'){
                        IPOLIML_pvz.cityPVZ[i].price = false;
                    }
                    cnt.push(i);
                }
            }
            // loading html for pvz-list
            IPOLIML_pvz.cityPVZHTML();
            <?if(COption::GetOptionString(CDeliveryIML::$MODULE_ID,'autoSelOne','') == 'Y'){?>
            if(cnt.length === 1)
                $('#IML_closer').attr('onclick','IPOLIML_pvz.choozePVZ("'+cnt.pop()+'");');
            else
                $('#IML_closer').attr('onclick','IPOLIML_pvz.close();');
            <?}?>

            IPOLIML_pvz.filter.check();
        },

        // filling pvz-html list
        cityPVZHTML: function(){
            IPOLIML_pvz.pvzScroll.destroy();
            var html = '';
            for(var i in IPOLIML_pvz.cityPVZ){
                var Wt = '';
                IPOLIML_pvz.checkOT(IPOLIML_pvz.cityPVZ[i],i);
                if(typeof(IPOLIML_pvz.cityPVZ[i].open) !== 'undefined' && IPOLIML_pvz.isLater(IPOLIML_pvz.cityPVZ[i].open))
                    Wt = "<br><span class='IPOLIML_DATEOC'><?=GetMessage("IPOLIML_NO_OT")?>&nbsp;"+IPOLIML_pvz.cityPVZ[i].open+"</span>";
                if(typeof(IPOLIML_pvz.cityPVZ[i].close) !== 'undefined')
                    Wt = "<br><span class='IPOLIML_DATEOC'><?=GetMessage("IPOLIML_NO_CT")?>&nbsp;"+IPOLIML_pvz.cityPVZ[i].close+"</span>";
                html+='<p id="PVZ_'+i+'" onclick="IPOLIML_pvz.markChosenPVZ(\''+i+'\')" onmouseover="IPOLIML_pvz.Y_blinkPVZ(\''+i+'\',true)" onmouseout="IPOLIML_pvz.Y_blinkPVZ(\''+i+'\')">'+IPOLIML_pvz.paintPVZ(i)+Wt+'</p>';
            }
            $('#IML_wrapper').html(html);
            IPOLIML_pvz.pvzScroll.init();
        },

        pvzScroll: {
            link: false,
            init: function(){
                IPOLIML_pvz.pvzScroll.link = $('#IML_wrapper').jScrollPane();
            },
            destroy:function(){
                if(IPOLIML_pvz.pvzScroll.link && typeof(IPOLIML_pvz.pvzScroll.link.data('jsp'))!=='undefined')
                    IPOLIML_pvz.pvzScroll.link.data('jsp').destroy();
            }
        },

        // dont show closing for still closed
        checkOT: function(checker,index){
            if(
                typeof(checker.open)  === 'undefined' ||
                typeof(checker.close) === 'undefined'
            )
                return;
            if(IPOLIML_pvz.isLater(checker.open))
                delete(IPOLIML_pvz.cityPVZ[index].close);
        },

        paintPVZ: function(ind){ // painting pvz, if color is given
            var addr = '';
            if(IPOLIML_pvz.cityPVZ[ind].color && IPOLIML_pvz.cityPVZ[ind].address.indexOf(',')!==false)
                addr="<span style='color:"+IPOLIML_pvz.cityPVZ[ind].color+"'>"+IPOLIML_pvz.cityPVZ[ind].address.substr(0,IPOLIML_pvz.cityPVZ[ind].address.indexOf(','))+"</span><br>"+IPOLIML_pvz.cityPVZ[ind].address.substr(IPOLIML_pvz.cityPVZ[ind].address.indexOf(',')+1).trim();
            else
                addr=IPOLIML_pvz.cityPVZ[ind].address;
            return addr;
        },

        detailPVZ: function(id){
            if(IPOLIML_pvz.scrollDetail && typeof(IPOLIML_pvz.scrollDetail.data('jsp'))!=='undefined')
                IPOLIML_pvz.scrollDetail.data('jsp').destroy();
            var addrStr = IPOLIML_pvz.cityPVZ[id].address;
            if(IPOLIML_pvz.cityPVZ[id].time)
                addrStr += '<br>'+IPOLIML_pvz.cityPVZ[id].time;
            var detailHtml = '<p><strong><?=GetMessage('IPOLIML_FRNT_ADDRESS')?></strong><br>'+addrStr+'</p>';

            var paySystems = '';
            if(IPOLIML_pvz.cityPVZ[id].paynal){
                paySystems += '<?=GetMessage("IPOLIML_FRNT_NAL")?><br>';
            }
            if(IPOLIML_pvz.cityPVZ[id].paycard){
                paySystems += '<?=GetMessage("IPOLIML_FRNT_CARD")?><br>';
            }
            if(!paySystems){
                paySystems = '<?=GetMessage("IPOLIML_FRNT_NOPAY")?><br>';
            }
            detailHtml += '<p><strong><?=GetMessage('IPOLIML_FRNT_PAYSYSTEMS')?></strong><br>'+paySystems+'</p>';

            detailHtml += '<p><strong><?=GetMessage('IPOLIML_FRNT_FITTING')?></strong>&nbsp;'+(IPOLIML_pvz.cityPVZ[id].fitting ? '<?=GetMessage('IPOLIML_FRNT_HAVE')?>' : '<?=GetMessage('IPOLIML_FRNT_NO')?>')+'</p>';

            if(IPOLIML_pvz.cityPVZ[id].way)
                detailHtml += '<p><strong><?=GetMessage('IPOLIML_FRNT_HOWTOGET')?></strong><br>'+IPOLIML_pvz.cityPVZ[id].way.replace(/\|/g,'<br>')+'</p>';
            if(IPOLIML_pvz.cityPVZ[id].path)
                detailHtml += '<p><img src="'+IPOLIML_pvz.cityPVZ[id].path+'"></p>';
            $('#IML_fullInfo').html(detailHtml);
            IPOLIML_pvz.scrollDetail=$('#IML_detail').jScrollPane({autoReinitialise: true});
            $('#IML_info').children('div').animate({'marginLeft':'-300px'},500);
        },

        backFromDetail: function(){
            if(IPOLIML_pvz.scrollDetail && typeof(IPOLIML_pvz.scrollDetail.data('jsp'))!=='undefined')
                IPOLIML_pvz.scrollDetail.data('jsp').destroy();
            $('#IML_info').children('div').animate({'marginLeft':'0px'},500);
        },

        //so we choose pvz
        pvzAdress: '',
        pvzId: false,
        choozePVZ: function(pvzId,isAjax){// click on choose pvz
            IPOLIML_pvz.curPVZ = pvzId;

            if(typeof IPOLIML_pvz.PVZ[IPOLIML_pvz.city.toUpperCase()] === 'undefined' || typeof IPOLIML_pvz.PVZ[IPOLIML_pvz.city.toUpperCase()][pvzId] === 'undefined')
                return;

            IPOLIML_pvz.pvzAdress=IPOLIML_pvz.PVZ[IPOLIML_pvz.city.toUpperCase()][pvzId]['address']+" #L"+pvzId;
            if(IPOLIML_pvz.pvzAdress.indexOf(IPOLIML_pvz.city+", ") === -1)
                IPOLIML_pvz.pvzAdress = IPOLIML_pvz.city+", "+IPOLIML_pvz.pvzAdress;

            IPOLIML_pvz.pvzId = pvzId;

            var chznPnkt = false;
            if(typeof(KladrJsObj) !== 'undefined')KladrJsObj.FuckKladr();

            for(var i in IPOLIML_pvz.pvzInputs){
                chznPnkt = $('#ORDER_PROP_'+IPOLIML_pvz.pvzInputs[i]);
                if(chznPnkt.length<=0)
                    chznPnkt = $('[name="ORDER_PROP_'+IPOLIML_pvz.pvzInputs[i]+'"]');
                if(chznPnkt.length>0){
                    chznPnkt.val(IPOLIML_pvz.pvzAdress);
                    chznPnkt.css('background-color', '#eee').attr('readonly','readonly');
                    break;
                }
            }

            // reloading form with new delivery prices
            if(typeof isAjax === 'undefined'){
                var htmlId = IPOLIML_pvz.makeHTMLId(IPOLIML_pvz.curProfile);
                if(typeof IPOLIML_DeliveryChangeEvent === 'function')
                    IPOLIML_DeliveryChangeEvent(htmlId);
                else{
                    if(IPOLIML_pvz.oldTemplate){
                        var deliveryTag = $('#'+htmlId);
                        if(typeof $.prop === 'undefined') // <3 jquery
                            deliveryTag.attr('checked', 'Y');
                        else
                            deliveryTag.prop('checked', 'Y');
                        deliveryTag.click();
                    }else
                        BX.Sale.OrderAjaxComponent.sendRequest();
                }

                IPOLIML_pvz.close();
            }
        },

        // displayment
        close: function(){
            IPOLIML_pvz.backFromDetail();
            IPOLIML_pvz.pvzScroll.destroy();
            $('#IML_pvz').css('display','none');
            $('#IML_mask').css('display','none');
            IPOLIML_pvz.isActive = false;
        },

        selectPVZ: function(id){
            if(!IPOLIML_pvz.isActive){
                $('#IML_button').css('display','');
                if(IPOLIML_pvz.Y_map)
                    IPOLIML_pvz.Y_clearPVZ();

                if(arguments.length === 1 && typeof(IPOLIML_pvz.deliveries[id] !== 'undefined'))
                    IPOLIML_pvz.curProfile = (IPOLIML_pvz.deliveries[id].self) ? IPOLIML_pvz.deliveries[id].link : id;
                else{
                    var first = IPOLIML_pvz.pickFirst(IPOLIML_pvz.deliveries);
                    if(IPOLIML_pvz.deliveries[first].self)
                        IPOLIML_pvz.curProfile = IPOLIML_pvz.deliveries[first].link;
                    else
                        IPOLIML_pvz.curProfile = IPOLIML_pvz.pickFirst(IPOLIML_pvz.deliveries);
                }

                IPOLIML_pvz.isActive = true;

                var hndlr = $('#IML_pvz');

                var left = ($(window).width()>hndlr.width()) ? (($(window).width()-hndlr.width())/2) : 0;

                hndlr.css({
                    'display'   : 'block',
                    'left'      : left
                });
                hndlr.css({
                    'top'       : ($(window).height()-hndlr.height())/2+$(document).scrollTop()
                });

                $('#IML_mask').css('display','block');

                IPOLIML_pvz.initCityPVZ();

                IPOLIML_pvz.Y_init();
            }
        },

        markChosenPVZ: function(id){
            IPOLIML_pvz.activePVZ = id;
            $('.iml_chosen').removeClass('iml_chosen');
            $("#PVZ_"+id).addClass('iml_chosen');
            IPOLIML_pvz.Y_selectPVZ(id);
        },

        baloonPrice: function(i){
            var button = $('#IML_button');
            button.css('display','none');
            if(typeof(IPOLIML_pvz.cityPVZ[i].price) !== 'undefined' && IPOLIML_pvz.cityPVZ[i].price!== false){
                $('#IML_iPrice').siblings('.iml_baloonDiv').html(IPOLIML_pvz.cityPVZ[i].price);
                if(
                    IPOLIML_pvz.cityPVZ[i].price !== '<?=GetMessage("IPOLIML_NO_DELIV")?>' &&
                    IPOLIML_pvz.cityPVZ[i].price !== '<?=GetMessage("IPOLIML_NO_PAY")?>'
                ){
                    button.css('display','');
                }
            }else{
                $('#IML_iPrice').siblings('.iml_baloonDiv').html('<img src="/bitrix/images/<?=CDeliveryIML::$MODULE_ID?>/widjet/ajax.gif">');
                IPOLIML_pvz.getPVZPrice(i);
            }
        },

        getPVZPrice: function(i){
            $.ajax({
                url: '/bitrix/js/<?=CDeliveryIML::$MODULE_ID?>/ajax.php',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    action: 'cntPVZ',
                    cityTo: IPOLIML_pvz.city,
                    pvz: i,
                    weight: '<?=CDeliveryIML::$orderWeight?>',
                    price : '<?=CDeliveryIML::$orderPrice?>',
                    gabs  : <?=CUtil::PhpToJSObject(CDeliveryIML::$orderGabs)?>,
                    // count restricts
                    DELIVERY   : IPOLIML_pvz.curDelivery,
                    PERSON_TYPE_ID : IPOLIML_pvz.payer,
                    PAY_SYSTEM_ID  : IPOLIML_pvz.paysystem
                },
                success: function(data){
                    var pay = data.price;
                    if(data.price === 'no'){
                        if(
                            typeof(IPOLIML_pvz.cityPVZ[data.pvz].paynal)  !== 'undefined' &&
                            typeof(IPOLIML_pvz.cityPVZ[data.pvz].paycard) !== 'undefined' &&
                            !IPOLIML_pvz.cityPVZ[data.pvz].paynal &&
                            !IPOLIML_pvz.cityPVZ[data.pvz].paycard &&
                            IPOLIML_pvz.pay === 'nal'
                        ){
                            pay = '<?=GetMessage("IPOLIML_NO_PAY")?>';
                        } else {
                            pay = '<?=GetMessage("IPOLIML_NO_DELIV")?>';
                        }
                    }

                    IPOLIML_pvz.cityPVZ[data.pvz].price = pay;
                    if(
                        IPOLIML_pvz.city === data.city &&
                        IPOLIML_pvz.activePVZ === data.pvz
                    ){
                        IPOLIML_pvz.baloonPrice(data.pvz);
                    }
                }
            });
        },

        filter: {
            mode: false,

            init: function(){
                if(IPOLIML_pvz.postomatMode === 'off'){
                    IPOLIML_pvz.filter.mode = 'pvz';
                } else {
                    IPOLIML_pvz.filter.mode = 'all';
                }

                $('.IML_filterType[ifilter="'+IPOLIML_pvz.filter.mode+'"]').addClass('active');
            },

            check: function(){
                var hasPVZ      = false;
                var hasPOSTOMAT = false;
                var city = IPOLIML_pvz.city.toUpperCase();


                for(var i in IPOLIML_pvz.PVZ[city]){
                    if(IPOLIML_pvz.PVZ[city][i].type === 'POSTOMAT'){
                        hasPOSTOMAT = true;
                    }
                    if(IPOLIML_pvz.PVZ[city][i].type === 'PVZ'){
                        hasPVZ = true;
                    }

                    if(hasPVZ && hasPOSTOMAT){
                        break;
                    }
                }

                if(!hasPVZ || !hasPOSTOMAT || IPOLIML_pvz.postomatMode === 'off'){
                    IPOLIML_pvz.filter.turnOff();
                } else {
                    IPOLIML_pvz.filter.turnOn();
                }
            },

            select: function(mode){
                if(typeof(mode) === 'undefined'){
                    mode = (IPOLIML_pvz.filter.mode) ? IPOLIML_pvz.filter.mode : 'all';
                }

                $('.IML_filterType.active').removeClass('active');

                IPOLIML_pvz.filter.mode = mode;

                $('.IML_filterType[ifilter="'+mode+'"]').addClass('active');

                IPOLIML_pvz.initCityPVZ(mode);
                IPOLIML_pvz.Y_init();
            },

            turnOn: function(){
                var filter = $('#IML_filter');
                filter.css('display','');
                IPOLIML_pvz.pvzScroll.destroy();
                $('#IML_wrapper').height(500-filter.height());
                IPOLIML_pvz.pvzScroll.init();
            },

            turnOff: function(){
                $('#IML_filter').css('display','none');
                IPOLIML_pvz.pvzScroll.destroy();
                $('#IML_wrapper').height(500);
                IPOLIML_pvz.pvzScroll.init();
            }
        },

        //Y-maps
        Y_map: false,//pointer to y-map

        Y_init: function(){
            IPOLIML_pvz.Y_readyToBlink = false;
            if(typeof IPOLIML_pvz.city === 'undefined')
                IPOLIML_pvz.city = '<?=GetMessage('IPOLIML_FRNT_MOSCOW')?>';

            var pvzCoords = IPOLIML_pvz.Y_getPVZCenters();
            if(pvzCoords){
                IPOLIML_pvz.Y_initCityMap(pvzCoords);
            } else {
                ymaps.geocode('<?=GetMessage('IPOLIML_RUSSIA')?>, '+IPOLIML_pvz.city , {
                    results: 1
                }).then(function (res) {

                    var firstGeoObject = res.geoObjects.get(0);
                    IPOLIML_pvz.Y_initCityMap(firstGeoObject.geometry.getCoordinates());
                });
            }
        },

        Y_initCityMap : function(coords){
            if(!IPOLIML_pvz.Y_map){
                IPOLIML_pvz.Y_map = new ymaps.Map("IML_map",{
                    zoom:10,
                    controls: ['zoomControl'],
                    center: coords
                });
                <?if($arParams['NOMAPS']=='Y'){?>
                IPOLIML_pvz.Y_map.controls.add('zoomControl');
                IPOLIML_pvz.Y_map.behaviors.enable(['scrollZoom']);
                /*IPOLIML_pvz.Y_map.controls.add(
                 new ymaps.control.SearchControl({
                 options: {provider: 'yandex#search'}
                 })
                 );*/
                <?}?>
            }
            else{
                IPOLIML_pvz.Y_map.setCenter(coords);
                IPOLIML_pvz.Y_map.setZoom(10);
            }
            IPOLIML_pvz.Y_clearPVZ();
            IPOLIML_pvz.Y_markPVZ();
            IPOLIML_pvz.Y_readyToBlink = true;
        },


        Y_getPVZCenters : function(){
            var ret = [0,0,0];
            for(var i in IPOLIML_pvz.cityPVZ){
                if(
                    typeof(IPOLIML_pvz.cityPVZ[i].coords) === 'object' &&
                    typeof(IPOLIML_pvz.cityPVZ[i].coords[0]) !== 'undefined' &&
                    typeof(IPOLIML_pvz.cityPVZ[i].coords[1]) !== 'undefined' &&
                    IPOLIML_pvz.cityPVZ[i].coords[0] && IPOLIML_pvz.cityPVZ[i].coords[1]
                ){
                    ret[0] += IPOLIML_pvz.cityPVZ[i].coords[0];
                    ret[1] += IPOLIML_pvz.cityPVZ[i].coords[1];
                    ret[2] ++;
                }
            }

            if(ret[2]){
                ret[0] /= ret[2];
                ret[1] /= ret[2];
                ret.pop();
                return ret;
            } else {
                return false;
            }
        },

        Y_markPVZ: function(){
            for(var i in IPOLIML_pvz.cityPVZ){
                // content of the baloon
                var baloonHTML  = "<div id='IML_baloon'>";
                baloonHTML += "<div><div id='IML_iPlace' class='iml_icon'></div><div class='iml_baloonDiv'>";
                if(IPOLIML_pvz.cityPVZ[i].address.indexOf(',')!==-1){
                    if(IPOLIML_pvz.cityPVZ[i].color)
                        baloonHTML +=  "<span style='color:"+IPOLIML_pvz.cityPVZ[i].color+"'>"+IPOLIML_pvz.cityPVZ[i].address.substr(0,IPOLIML_pvz.cityPVZ[i].address.indexOf(','))+"</span>";
                    else
                        baloonHTML +=  IPOLIML_pvz.cityPVZ[i].address.substr(0,IPOLIML_pvz.cityPVZ[i].address.indexOf(','));
                    baloonHTML += "<br>"+IPOLIML_pvz.cityPVZ[i].address.substr(IPOLIML_pvz.cityPVZ[i].address.indexOf(',')+1).trim();
                }
                else
                    baloonHTML += IPOLIML_pvz.cityPVZ[i].address;
                baloonHTML += "</div><div style='clear:both'></div></div>";

                if(IPOLIML_pvz.cityPVZ[i].phone)
                    baloonHTML += "<div><div id='IML_iTelephone' class='iml_icon'></div><div class='iml_baloonDiv'>"+IPOLIML_pvz.cityPVZ[i].phone+"</div><div style='clear:both'></div></div>";
                if(IPOLIML_pvz.cityPVZ[i].time)
                    baloonHTML += "<div><div id='IML_iTime' class='iml_icon'></div><div class='iml_baloonDiv'>"+IPOLIML_pvz.cityPVZ[i].time+"</div><div style='clear:both'></div></div>";
                if(IPOLIML_pvz.showPrice)
                    baloonHTML += "<div><div id='IML_iPrice' class='iml_icon'></div><div class='iml_baloonDiv'>"+"</div><div style='clear:both'></div></div>";

                baloonHTML += "<div><div class='iml_icon'></div><div class='iml_baloonDiv'><a href='javascript:void(0)' onclick='IPOLIML_pvz.detailPVZ(\""+i+"\")'><?=GetMessage('IPOLIML_FRNT_DETAIL')?></a>";

                if(IPOLIML_pvz.cityPVZ[i].paycard || IPOLIML_pvz.cityPVZ[i].paynal || IPOLIML_pvz.cityPVZ[i].fitting){
                    if(IPOLIML_pvz.cityPVZ[i].paynal){
                        baloonHTML += "<div class='iml_icon IML_iNal iml_detailIcon' title='<?=GetMessage('IPOLIML_FRNT_HAVENAL')?>'></div>";
                    }
                    if(IPOLIML_pvz.cityPVZ[i].paycard){
                        baloonHTML += "<div class='iml_icon IML_iCard iml_detailIcon' title='<?=GetMessage('IPOLIML_FRNT_HAVECARD')?>'></div>";
                    }
                    if(IPOLIML_pvz.cityPVZ[i].fitting){
                        baloonHTML += "<div class='iml_icon IML_iFitting iml_detailIcon' title='<?=GetMessage('IPOLIML_FRNT_HAVEFITTING')?>'></div>";
                    }
                }

                baloonHTML += "</div><div style='clear:both'></div></div>";
                baloonHTML += "<div><a id='IML_button' href='javascript:void(0)' onclick='IPOLIML_pvz.choozePVZ(\""+i+"\")'></a></div>";

                baloonHTML += "</div>";
                var baloonContent = {balloonContent: baloonHTML};
                var baloonParams = {
                    iconLayout: 'default#image',
                    iconImageHref: '/bitrix/images/<?=CDeliveryIML::$MODULE_ID?>/widjet/imlNActive.png',
                    iconImageSize: [40, 43],
                    iconImageOffset: [-10, -31]
                };

                if(IPOLIML_pvz.cityPVZ[i].coords){
                    IPOLIML_pvz.cityPVZ[i].placeMark = new ymaps.Placemark(IPOLIML_pvz.cityPVZ[i].coords,baloonContent,baloonParams);
                    IPOLIML_pvz.Y_map.geoObjects.add(IPOLIML_pvz.cityPVZ[i].placeMark);
                    IPOLIML_pvz.cityPVZ[i].placeMark.link = i;
                    IPOLIML_pvz.cityPVZ[i].placeMark.events.add('balloonopen',function(metka){
                        IPOLIML_pvz.markChosenPVZ(metka.get('target').link);
                        if(IPOLIML_pvz.showPrice)
                            IPOLIML_pvz.baloonPrice(metka.get('target').link);
                    });
                }else{
                    IPOLIML_pvz.cityPVZ[i]['reaparams'] = {
                        'baloonContent' : baloonContent,
                        'baloonParams'  : baloonParams
                    };
                    ymaps.geocode(IPOLIML_pvz.city+", "+IPOLIML_pvz.cityPVZ[i].address , {
                        results: 1
                    }).then(function (res) {
                        var firstGeoObject = res.geoObjects.get(0);

                        for(var j in IPOLIML_pvz.cityPVZ)//which pvz we found
                            if(IPOLIML_pvz.city+", "+IPOLIML_pvz.cityPVZ[j].address == res.metaData.geocoder.request)
                                break;
                        IPOLIML_pvz.cityPVZ[j].coords = firstGeoObject.geometry.getCoordinates();
                        IPOLIML_pvz.cityPVZ[j].placeMark = new ymaps.Placemark(firstGeoObject.geometry.getCoordinates(),IPOLIML_pvz.cityPVZ[j].reaparams.baloonContent,IPOLIML_pvz.cityPVZ[j].reaparams.baloonParams);
                        IPOLIML_pvz.Y_map.geoObjects.add(IPOLIML_pvz.cityPVZ[j].placeMark);
                        IPOLIML_pvz.cityPVZ[i].placeMark.link = j;
                        IPOLIML_pvz.cityPVZ[j].placeMark.events.add('balloonopen',function(metka){
                            IPOLIML_pvz.markChosenPVZ(metka.get('target').link);
                            if(IPOLIML_pvz.showPrice)
                                IPOLIML_pvz.baloonPrice(metka.get('target').link);
                        });

                        IPOLIML_pvz.cityPVZ[j]['reaparams'] = false;
                    });
                }
            }
        },

        Y_selectPVZ: function(wat){
            IPOLIML_pvz.cityPVZ[wat].placeMark.balloon.open();
            IPOLIML_pvz.Y_map.setCenter(IPOLIML_pvz.cityPVZ[wat].coords);
        },

        Y_readyToBlink: false,
        Y_blinkPVZ: function(wat,ifOn){
            if(IPOLIML_pvz.Y_readyToBlink){
                if(typeof(ifOn)!=='undefined' && ifOn)
                    IPOLIML_pvz.cityPVZ[wat].placeMark.options.set({iconImageHref:"/bitrix/images/<?=CDeliveryIML::$MODULE_ID?>/widjet/imlActive.png"});
                else
                    IPOLIML_pvz.cityPVZ[wat].placeMark.options.set({iconImageHref:"/bitrix/images/<?=CDeliveryIML::$MODULE_ID?>/widjet/imlNActive.png"});
            }
        },

        Y_clearPVZ: function(){
            if(typeof(IPOLIML_pvz.Y_map.geoObjects.removeAll) !== 'undefined' && false)
                IPOLIML_pvz.Y_map.geoObjects.removeAll();
            else{
                do{
                    IPOLIML_pvz.Y_map.geoObjects.each(function(e){
                        IPOLIML_pvz.Y_map.geoObjects.remove(e);
                    });
                }while(IPOLIML_pvz.Y_map.geoObjects.getBounds());
            }
        },

        isLater: function(date){ // YYYY.MM.DD need to check, if it opened
            var chk = new Date();
            var OT  = new Date(date.substr(6),(date.substr(3,2))-1,date.substr(0,2));
            return (OT > chk);
        },

        // loading
        readySt: {
            ymaps: false,
            jqui: false
        },
        inited: false,
        checkReady: function(wat){
            if(typeof(IPOLIML_pvz.readySt[wat]) !== 'undefined')
                IPOLIML_pvz.readySt[wat] = true;
            if(IPOLIML_pvz.readySt.ymaps && (IPOLIML_pvz.readySt.jqui || typeof($) !== 'undefined') && !IPOLIML_pvz.inited){
                IPOLIML_pvz.inited = true;
                var pvzLink = $('#IML_pvz');
                var tmpHTML = pvzLink.html();
                pvzLink.html('');
                pvzLink.attr('id','IML_notInUse');
                $('body').append("<div id='IML_pvz'>"+tmpHTML+"</div>");
                IPOLIML_pvz.init();
            }
        },

        jquiready: function(){IPOLIML_pvz.checkReady('jqui');},
        ympsready: function(){IPOLIML_pvz.checkReady('ymaps');},

        ymapsBindCntr: 0,
        ymapsBindFinal : false,
        ymapsBlockLoad : false,
        ymapsBidner: function(){
            if(IPOLIML_pvz.ymapsBlockLoad){
                return;
            }
            if(IPOLIML_pvz.ymapsBindCntr > 50){
                if(IPOLIML_pvz.ymapsBindFinal){
                    console.error('IML widjet error: no Y-maps');
                    return;
                } else {
                    IPOLIML_pvz.ymapsBindFinal = true;
                    IPOLIML_pvz.ymapsBlockLoad = true;
                    IPOL_JSloader.checkScript('','<?=$pathToYmaps?>',IPOLIML_pvz.ymapsForseCheck);
                    IPOL_JSloader.recall();
                    return;
                }
            }

            if(typeof(ymaps) === 'undefined'){
                IPOLIML_pvz.ymapsBindCntr++;
                setTimeout(IPOLIML_pvz.ymapsBidner,100);
            }else
                ymaps.ready(IPOLIML_pvz.ympsready);
        },
        ymapsForseCheck: function(){
            IPOLIML_pvz.ymapsBindCntr  = 0;
            IPOLIML_pvz.ymapsBlockLoad = false;
            IPOLIML_pvz.ymapsBidner();
        }
    };
    IPOLIML_pvz.ymapsBidner();

    IPOL_JSloader.checkScript('',"/bitrix/js/<?=CDeliveryIML::$MODULE_ID?>/jquery.mousewheel.js");
    IPOL_JSloader.checkScript('$("body").jScrollPane',"/bitrix/js/<?=CDeliveryIML::$MODULE_ID?>/jquery.jscrollpane.js",IPOLIML_pvz.jquiready);
</script>
<div id='IML_pvz'>
    <div id='IML_head'>
        <div id='IML_logo'><a href='http://ipolh.com' target='_blank'></a></div>
        <div id='IML_logoPlace'></div>
        <div id='IML_separator'></div>
        <div class='IML_mark'>
            <strong><?=GetMessage("IPOLIML_PICKUP")?></strong> <span id='IML_pPrice'></span><br>
            <span id='IML_pDate' title='<?=GetMessage("IPOLIML_HINT")?>'></span>
        </div>
        <div id='IML_closer' onclick='IPOLIML_pvz.close()'></div>
    </div>
    <div id='IML_map'></div>
    <div id='IML_info'>
		<div class="IML_burger"></div>
        <div id='IML_filter'>
            <div class='IML_filterType' ifilter='pvz' onclick='IPOLIML_pvz.filter.select("pvz")'><?=GetMessage('IPOLIML_WDJ_PVZ')?></div>
            <div class='IML_filterType' ifilter='postamat' onclick='IPOLIML_pvz.filter.select("postamat")'><?=GetMessage('IPOLIML_WDJ_POSTOMAT')?></div>
            <div class='IML_filterType' ifilter='all' onclick='IPOLIML_pvz.filter.select("all")'><?=GetMessage('IPOLIML_WDJ_BOTH')?></div>
            <div style='clear:both'></div>
        </div>
        <div>
            <div id='IML_wrapper'></div>
            <div id='IML_detail'>
                <div id='IML_back' onclick='IPOLIML_pvz.backFromDetail()'><?=GetMessage("IPOLIML_FRNT_BACK")?></div>
                <div id='IML_fullInfo'></div>
            </div>
        </div>
    </div>
</div>