<?php

/**
 * Работа с платежной системой Сбербанка.
 */
class SberbankPay
{
    private $userName;  // логин для запросов
    private $password;  // токен для запросов
    private $url;       // rest url

    /**
     * SberbankPay constructor.
     *
     * @param int $id Идентификатор актуальной платежной системы.
     */
    public function __construct($id = 14)
    {
        $this->userName = \Bitrix\Sale\BusinessValue::get("SBERBANK_GATE_LOGIN", "PAYSYSTEM_$id");
        $this->password = \Bitrix\Sale\BusinessValue::get("SBERBANK_GATE_PASSWORD", "PAYSYSTEM_$id");
        $this->url = (\Bitrix\Sale\BusinessValue::get("SBERBANK_GATE_TEST_MODE", "PAYSYSTEM_$id") == 'Y' ? 'https://3dsec.sberbank.ru/payment/rest/' : 'https://securepayments.sberbank.ru/payment/rest/');
    }

    /**
     * Запрос к шлюзу.
     *
     * @param $path Метод шлюза.
     * @param $params Параметры запроса.
     * @return mixed
     */
    private function request(string $path = '', array $params = [])
    {
        $params['userName'] = $this->userName;
        $params['password'] = $this->password;

        $ch = curl_init($this->url . $path . http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);

        return json_decode($res, JSON_OBJECT_AS_ARRAY);
    }

    /**
     * Получение статуса заказа.
     *
     * @param string $sberOrderId Идентификатор заказа.
     * @return mixed
     */
    public function getOrderStatusExtended(string $sberOrderId)
    {
        return $this->request('getOrderStatusExtended.do?', ['orderId' => $sberOrderId]);
    }

    /**
     * Окончательное списание по заказу.
     *
     * @param string $orderId Идентификатор заказа.
     * @param int $amount Сумма к списанию.
     * @param array $cart Товары в заказе (для чека).
     * @return mixed
     */
    public function deposit(string $orderId, int $amount, array $cart)
    {
        $data = [
            'orderId' => $orderId,
            'amount'  => $amount,
            'depositItems' => json_encode(
                [
                    'items' => $cart,
                ],
                JSON_UNESCAPED_UNICODE
            )
        ];
        saleEvents::log(json_encode($data));
        return $this->request('deposit.do?', $data);
    }
}