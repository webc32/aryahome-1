<?php

$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_ACTION_ORDERCANCELLATIONNOTIFY_NOTIFICATION_TITLE'] = 'Уведомление об отмене заказа покупателем';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_ACTION_ORDERCANCELLATIONNOTIFY_NOTIFICATION_TEMPLATE_SUBJECT'] = '#SERVER_NAME#: запрос отмены заказа покупателем N#ORDER_ID#';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_ACTION_ORDERCANCELLATIONNOTIFY_NOTIFICATION_TEMPLATE_BODY_EMAIL'] = '
<p>Информационное сообщение сайта #SITE_NAME#</p>
<p>Покупатель создал заявку на отмену заказа #ORDER_ID# от #ORDER_DATE#.</p>
<p>Принять или отклонить запрос, вы можете в разделе "<a href="https://#SERVER_NAME##DOCUMENTS_URL#">Документы</a>".</p>
';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_ACTION_ORDERCANCELLATIONNOTIFY_NOTIFICATION_TEMPLATE_BODY_SMS'] = 'Покупатель создал заявку на отмену заказа #ORDER_ID# от #ORDER_DATE#.';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_ACTION_ORDERCANCELLATIONNOTIFY_NOTIFICATION_VARIABLE_INTERNAL_ID'] = 'Ид заказа';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_ACTION_ORDERCANCELLATIONNOTIFY_NOTIFICATION_VARIABLE_ORDER_ID'] = 'Код заказа';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_ACTION_ORDERCANCELLATIONNOTIFY_NOTIFICATION_VARIABLE_ORDER_DATE'] = 'Дата заказа';
$MESS['YANDEX_MARKET_TRADING_SERVICE_MARKETPLACEDBS_ACTION_ORDERCANCELLATIONNOTIFY_NOTIFICATION_VARIABLE_EXTERNAL_ID'] = 'Номер на маркетплейсе';
