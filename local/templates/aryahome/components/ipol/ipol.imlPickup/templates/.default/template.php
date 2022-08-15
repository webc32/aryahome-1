<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/js/'.CDeliveryIML::$MODULE_ID.'/jsloader.php');
	global $APPLICATION;
	if($arParams['NOMAPS']!='Y')
		$APPLICATION->AddHeadString('<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>');
	$APPLICATION->AddHeadString('<link href="/bitrix/js/'.CDeliveryIML::$MODULE_ID.'/jquery.jscrollpane.css" type="text/css"  rel="stylesheet" />');
?>
	<script>
		var IPOLIML_pvz = {
			city: '<?=$arResult['city']?>',

			postomatMode: '<?=($arParams['NO_POSTOMAT'] == 'Y') ? 'off' : 'on'?>', // later mae by moar

			pvzPrice: false,

			activePVZ: false,

			showPrice: <?=(COption::GetOptionString(CDeliveryIML::$MODULE_ID,'countType','T') == 'S')?'true':'false'?>,
			
			payer: '<?=$arParams['PAYER']?>',
			
			paysystem: '<?=$arParams['PAYSYSTEM']?>',

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

			// object with city pvz + coordinates 4 yandex
			cityPVZ: {},

			// scroll 4 detail information
			scrollDetail: false,

			init: function(){
				$('#IML_cityLabel').css({'position':'absolute'});
				$('#IML_citySel').css({'display':'block'});
				$('#IML_listOfCities').jScrollPane();
				$('#IML_cityLabel').css({'position':''});
				$('#IML_citySel').css({'display':''});
				IPOLIML_pvz.filter.init();
				IPOLIML_pvz.initCityPVZ();
				<?if($arParams['CNT_DELIV'] != 'Y'){?>IPOLIML_pvz.loadCityCost();
				<?}?>
				$(document).mouseup(function (e){
					var block = $("#IML_info");
					if (!block.is(e.target)
						&& block.has(e.target).length === 0) {
						block.removeClass('active');
						$('.IML_burger').removeClass('active');
					}
				});
				IPOLIML_pvz.Y_init();
			},

			chooseCity: function(city){
				$('#IML_citySel a').each(function(){
					$(this).css('display','');
					if($(this).attr('onclick').indexOf(city)!==-1)
						$('#IML_cityName').html($(this).text());
				});
				$('#IML_citySel').css('display','none');
				IPOLIML_pvz.city = city;
				IPOLIML_pvz.filter.init();
				IPOLIML_pvz.initCityPVZ();
				IPOLIML_pvz.Y_init();
				IPOLIML_pvz.loadCityCost();
				IPOLIML_pvz.resetCityName();
			},

			// loading puncts for chosen city
			initCityPVZ: function(mode){
				var city = IPOLIML_pvz.city.toUpperCase();
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
					}
				}
				// loading pvz-html
				IPOLIML_pvz.cityPVZHTML();

				IPOLIML_pvz.filter.check();
			},

			// loading pvz-list
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

			// checking open/close pvz
			checkOT: function(checker,index){
				if(
					typeof(checker.open)  === 'undefined' ||
					typeof(checker.close) === 'undefined'
				)
					return;
				if(IPOLIML_pvz.isLater(checker.open))
					delete(IPOLIML_pvz.cityPVZ[index].close);
			},
			// painting pvz if color given
			paintPVZ: function(ind){
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

			markChosenPVZ: function(id){
				IPOLIML_pvz.activePVZ = id;
				$('.iml_chosen').removeClass('iml_chosen');
				$("#PVZ_"+id).addClass('iml_chosen');
				IPOLIML_pvz.Y_selectPVZ(id);
			},

			baloonPrice: function(i){
				if(typeof(IPOLIML_pvz.PVZ[IPOLIML_pvz.city.toUpperCase()][i].price) !== 'undefined')
					$('#IML_iPrice').siblings('.iml_baloonDiv').html(IPOLIML_pvz.PVZ[IPOLIML_pvz.city.toUpperCase()][i].price);
				else{
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
						PERSON_TYPE_ID: IPOLIML_pvz.payer,
						PAY_SYSTEM_ID:  IPOLIML_pvz.paysystem
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
						)
							IPOLIML_pvz.baloonPrice(data.pvz);
					}
				});
			},

			// city list
			getCityName: function(){
				var text = $('#IML_citySearcher').val().toLowerCase();
				$('#IML_citySel').find('.IML_citySelect').each(function(){
					if(($(this).text().toLowerCase().indexOf(text)===-1))
						$(this).css('display','none');
					else
						$(this).css('display','');
				});
			},

			resetCityName: function(){
				$('#IML_citySearcher').val('');
				$('#IML_citySel').find('.IML_citySelect').css('display','');
			},

			showCitySel: function(){
				$('#IML_citySel').css('display','');
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
					var filer = $('#IML_filter');
					filer.css('display','');
					IPOLIML_pvz.pvzScroll.destroy();
					$('#IML_wrapper').height(500-filer.height());
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
			Y_map: false,// pointer 4 ymap

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
					// baloon content
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

							for(var j in IPOLIML_pvz.cityPVZ)//defining what pvz founded
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
				IPOLIML_pvz.Y_markedCities[IPOLIML_pvz.city.toUpperCase()]=IPOLIML_pvz.cityPVZ;
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
			
			Y_markedCities: {},
			
			loadCityCost: function(){
				$.ajax({
					url: '/bitrix/js/<?=CDeliveryIML::$MODULE_ID?>/ajax.php',
					type: 'POST',
					dataType: 'JSON',
					data: {
						action: 'countDelivery',
						cityTo: IPOLIML_pvz.city,
						PERSON_TYPE_ID: IPOLIML_pvz.payer,
						PAY_SYSTEM_ID:  IPOLIML_pvz.paysystem
					},
					success: function(data){
						IPOLIML_pvz.activePVZ = false;
						if(data.courier !== 'no'){
							$('#IML_cPrice').html(data.courier);
							$('#IML_cDate').html(data.date);
						}else{
							$('#IML_cPrice').html("");
							$('#IML_cDate').html("<?=GetMessage("IPOLIML_NO_DELIV")?>");
						}
						
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

			isLater: function(date){ // YYYY.MM.DD
				var chk = new Date();
				var OT  = new Date(date.substr(6),(date.substr(3,2))-1,date.substr(0,2));
				return (OT > chk);
			},

			// loading
			readySt: {
				ymaps: false,
				jqui: false
			},
			checkReady: function(wat){
				if(typeof(IPOLIML_pvz.readySt[wat]) !== 'undefined')
					IPOLIML_pvz.readySt[wat] = true;
				if(IPOLIML_pvz.readySt.ymaps && IPOLIML_pvz.readySt.jqui)
					IPOLIML_pvz.init();
			},

			jquiready: function(){IPOLIML_pvz.checkReady('jqui');},
			ympsready: function(){IPOLIML_pvz.checkReady('ymaps');},

			ymapsBindCntr: 0,
			ymapsBidner: function(){
				if(IPOLIML_pvz.ymapsBindCntr > 50){
					console.error('IML widjet error: no Y-maps');
					return;
				}
				if(typeof(ymaps) === 'undefined'){
					IPOLIML_pvz.ymapsBindCntr++;
					setTimeout(IPOLIML_pvz.ymapsBidner,100);
				}else
					ymaps.ready(IPOLIML_pvz.ympsready);
			}
		};
		IPOLIML_pvz.ymapsBidner();

		IPOL_JSloader.checkScript('',"/bitrix/js/<?=CDeliveryIML::$MODULE_ID?>/jquery.mousewheel.js");
		IPOL_JSloader.checkScript('$("body").jScrollPane',"/bitrix/js/<?=CDeliveryIML::$MODULE_ID?>/jquery.jscrollpane.js",IPOLIML_pvz.jquiready);
	</script>
	<div id='IML_pvz'>
		<div id='IML_title'>
			<div id='IML_cityPicker' <?=(count($arResult['Regions'])==1)?'style="visibility:hidden"':''?>>
				<div><?=GetMessage("IPOLIML_YOURCITY")?></div>
				<div>
					<div id='IML_cityLabel'>
						<a id='IML_cityName' href='javascript:void(0)' onmouseover='IPOLIML_pvz.showCitySel(); return false;'><?=$arResult['city']?></a>
						<div id='IML_citySel'>
							<input type='text' id='IML_citySearcher' placeholder='<?=GetMessage("IPOLIML_CITYSEARCH")?>' onkeyup='IPOLIML_pvz.getCityName()'/>
							<div id='IML_listOfCities'>
								<div>
									<?foreach($arResult['PVZ'] as $city => $noNeed){?>
										<a href='javascript:void(0)' <?=($city==CDeliveryIML::toUpper($arResult['city']))?"style='display:none'":''?> onclick='IPOLIML_pvz.chooseCity("<?=$city?>");return false;' class='IML_citySelect'><?=$arResult['Regions'][$city]?><br></a>
									<?}?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id='IML_logoPlace'></div>
			<div id='IML_separator'></div>
			<div class='IML_mark'>
				<strong><?=GetMessage("IPOLIML_COURIER")?></strong> <span id='IML_cPrice'><?=($arResult['DELIVERY']['courier'] != 'no')?$arResult['DELIVERY']['courier']:""?></span><br>
				<span id='IML_cDate' title='<?=GetMessage("IPOLIML_HINT")?>'><?=($arResult['DELIVERY']['courier'] != 'no')?$arResult['DELIVERY']['date']:GetMessage("IPOLIML_NO_DELIV")?></span>
			</div>
			<div class='IML_mark'>
				<strong><?=GetMessage("IPOLIML_PICKUP")?></strong> <span id='IML_pPrice'><?=($arResult['DELIVERY']['pickup'] != 'no')?$arResult['DELIVERY']['pickup']:""?></span><br>
				<span id='IML_pDate' title='<?=GetMessage("IPOLIML_HINT")?>'><?=($arResult['DELIVERY']['pickup'] != 'no')?$arResult['DELIVERY']['date']:GetMessage("IPOLIML_NO_DELIV")?></span>
			</div>
			<div style='float:none;clear:both'></div>
		</div>
		<div id='IML_map'></div>
		<div id='IML_info'>
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
		<div id='IML_head'>
			<div id='IML_logo'><a href='http://ipolh.com' target='_blank'></a></div>
		</div>
	</div>