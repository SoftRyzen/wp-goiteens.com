<?php


class w4p_answer_statuses
{
    private static $transaction_status_array = array(
        'InProcessing' => array(
            'status_description' => 'В обработке',
            'status_long_description' => 'Заказ все еще находится в процессе обработки платежным шлюзом'
        ),
        'WaitingAuthComplete' => array(
            'status_description' => 'Успешный Hold',
            'status_long_description' => 'Заказ ожидает подтверждение списания средств (Settle)'
        ),
        'Approved' => array(
            'status_description' => 'Успешный платеж',
            'status_long_description' => 'Заказ успешно оплачен клиентом, средства списаны с карты'
        ),
        'Pending' => array(
            'status_description' => 'На проверке',
            'status_long_description' => 'На проверке Antifraud'
        ),
        'Expired' => array(
            'status_description' => 'Истек срок оплаты',
            'status_long_description' => 'Статус присваивается по истечению времени на оплату'
        ),
        'Voided' => array(
            'status_description' => 'Возврат',
            'status_long_description' => 'В случае операции возврата/разблокировки денег'
        ),
        'Refunded' => array(
            'status_description' => 'Возврат',
            'status_long_description' => 'В случае операции возврата/разблокировки денег'
        ),
        'Declined' => array(
            'status_description' => 'Отклонен',
            'status_long_description' => 'В случае невозможности провести операцию'
        ),
        'RefundInProcessing' => array(
            'status_description' => 'Возврат в обработке',
            'status_long_description' => 'В случае если недостаточно средств на балансе магазина'
        )
    );
    public $result_w4p_answer_statuses = array(
        'request_status' => '',
        'transaction_status' => '',
        'status_description' => '',
        'status_long_description' => '',
        'module' => 'w4p_answer_statuses',
        'message'=>''
    );

    public function __construct($transaction_status)
    {
        if ($this->checkArray($transaction_status)) {
            $this->result_w4p_answer_statuses['transaction_status'] = $transaction_status;
            $this->result_w4p_answer_statuses['status_description'] = substr(self::$transaction_status_array[$transaction_status]['status_description'], 0, 252);
            $this->result_w4p_answer_statuses['status_long_description'] = substr(self::$transaction_status_array[$transaction_status]['status_long_description'], 0, 252);
            $this->result_w4p_answer_statuses['request_status'] = 'ok';
        } else {
            $this->result_w4p_answer_statuses['request_status'] = 'error';
            $this->result_w4p_answer_statuses['message'] = 'transaction_status not found';
        }
    }

    private function checkArray($transaction_status)
    {
        if (isset(self::$transaction_status_array[$transaction_status]) && !empty(self::$transaction_status_array[$transaction_status]) && self::$transaction_status_array[$transaction_status] != '') {
            return true;
        } else {
            return false;
        }
    }

}