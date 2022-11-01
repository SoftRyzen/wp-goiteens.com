<?php


class w4p_answer_codes
{
    public static $answer_codes = array(
        "1100" => array(
            "status" => "Ок",
            "text_status" => "Операция выполнена без ошибок"
        ),
        "1101" => array(
            "status" => "Declined To Card Issuer",
            "text_status" => "Отказ Банка эмитента проводить операцию"
        ),
        "1102" => array(
            "status" => "Bad CVV2",
            "text_status" => "Неверный CVV код"
        ),
        "1103" => array(
            "status" => "Expired card",
            "text_status" => "Карта просрочена или неверно указан срок действия"
        ),
        "1104" => array(
            "status" => "Insufficient Funds",
            "text_status" => "Недостаточно средств"
        ),
        "1105" => array(
            "status" => "Invalid Card",
            "text_status" => "Введен неверный номер карты, либо карта в недопустимом состоянии."
        ),
        "1106" => array(
            "status" => "Exceed Withdrawal Frequency",
            "text_status" => "Превышен лимит операций по карте - возможно карта не открыта для оплаты в интернет"
        ),
        "1108" => array(
            "status" => "Three Ds Fail",
            "text_status" => "Невозможно выполнить 3DS транзакцию, либо неверный код подтверждения 3DS"
        ),
        "1109" => array(
            "status" => "Format Error",
            "text_status" => "Ошибка на стороне мерчанта — неверно сформирована транзакция"
        ),
        "1110" => array(
            "status" => "invalid Currency",
            "text_status" => "Ошибка на стороне мерчанта- неверная валюта"
        ),
        "1112" => array(
            "status" => "Duplicate Order ID",
            "text_status" => "Дублирующий orderid"
        ),
        "1113" => array(
            "status" => "Invalid signature.",
            "text_status" => "Не правильная подпись мерчанта."
        ),
        "1114" => array(
            "status" => "Fraud",
            "text_status" => "Фродовая транзакция согласно антифрод фильтров"
        ),
        "1115" => array(
            "status" => "Parameter `{param_name}` is missing",
            "text_status" => "Один или несколько обязательных параметров не переданы"
        ),
        "1116" => array(
            "status" => "Token not found",
            "text_status" => "Попытка списания с карты клиента по токену неуспешна - используется неверное значение"
        ),
        "1117" => array(
            "status" => "API Not Allowed",
            "text_status" => "Данный API не разрешен к использованию для мерчанта"
        ),
        "1118" => array(
            "status" => "Merchant Restriction",
            "text_status" => "Превышен лимит Магазина или транзакции запрещены Магазину"
        ),
        "1120" => array(
            "status" => "Authentication unavailable",
            "text_status" => "3-D Secure авторизация недоступна"
        ),
        "1121" => array(
            "status" => "Account Not Found",
            "text_status" => "Аккаунт не найден"
        ),
        "1122" => array(
            "status" => "Gate Declined",
            "text_status" => "Отказ шлюза в выполнении операции"
        ),
        "1123" => array(
            "status" => "Refund Not Allowed",
            "text_status" => "Возврат не может быть выполнен"
        ),
        "1124" => array(
            "status" => "Cardholder session expired",
            "text_status" => "Сессия пользователя истекла"
        ),
        "1125" => array(
            "status" => "Cardholder canceled the request",
            "text_status" => "Транзакция отменена пользователем"
        ),
        "1126" => array(
            "status" => "Illegal Order State",
            "text_status" => "Попытка выполнения недопустимой операции для текущего состояния платежа"
        ),
        "1127" => array(
            "status" => "Order Not Found",
            "text_status" => "Транзакция не найдена"
        ),
        "1128" => array(
            "status" => "Refund Limit Excended",
            "text_status" => "Превышено допустимое число попыток произвести возврат (Refund)"
        ),
        "1129" => array(
            "status" => "ScriptError",
            "text_status" => "Ошибка сценария"
        ),
        "1130" => array(
            "status" => "Invalid Amount",
            "text_status" => "Неправильная сумма"
        ),
        "1131" => array(
            "status" => "Transaction in processing",
            "text_status" => "Заказ обрабатывается. Заказ все еще находится в процессе обработки платежным шлюзом"
        ),
        "1132" => array(
            "status" => "Transaction Is Delayed",
            "text_status" => "Клиент решил отложить оплату, ему на почту отправлена ссылка для завершения платежа"
        ),
        "1133" => array(
            "status" => "Invalid commission",
            "text_status" => "Неверная комиссия."
        ),
        "1134" => array(
            "status" => "Transaction is pending",
            "text_status" => "Транзакция на проверке Antifraud"
        ),
        "1135" => array(
            "status" => "Card limits failed",
            "text_status" => "Превышен лимит по карте"
        ),
        "1136" => array(
            "status" => "Merchant Balance Is Very Small",
            "text_status" => "Недостаточно средств на балансе мерчанта"
        ),
        "1137" => array(
            "status" => "Invalid Confirmation Amount",
            "text_status" => "Неправильная сумма подтверждения верификации карты"
        ),
        "1138" => array(
            "status" => "RefundInProcessing",
            "text_status" => "Запрос на возврат принят и будет проведен как только на балансе магазина будет достаточно денег для его проведения."
        ),
        "1139" => array(
            "status" => "External decline while credit",
            "text_status" => "Отказ в зачислении средств на карту получателя"
        ),
        "1140" => array(
            "status" => "Exceed Withdrawal Frequency While Credit",
            "text_status" => "Превышен лимит при зачислении средств на карту получателя."
        ),
        "1141" => array(
            "status" => "Partial void is not supported",
            "text_status" => "Частичная отмена холда не доступна"
        ),
        "1142" => array(
            "status" => "Refused a credit",
            "text_status" => "Отказано в кредите"
        ),
        "1143" => array(
            "status" => "Invalid phone number",
            "text_status" => "Неверный номер телефона"
        ),
        "1144" => array(
            "status" => "Transaction is awaiting delivery",
            "text_status" => "Ожидание решения о предоставлении кредита"
        ),
        "1145" => array(
            "status" => "Transaction is awaiting credit decision",
            "text_status" => "Карта заблокирована в Банке"
        ),
        "1146" => array(
            "status" => "Restricted card",
            "text_status" => "Клиент не найден"
        ),
        "1147" => array(
            "status" => "Client is not found",
            "text_status" => "Клиент найден, но не привязан к текущему мерчанту"
        ),
        "1148" => array(
            "status" => "Client is not linked",
            "text_status" => "Клиент временно заблокирован"
        ),
        "1149" => array(
            "status" => "Client is locked",
            "text_status" => "Ожидание 3d secure верификации"
        )
    );
    public $result_w4p_answer_codes = array(
        'request_status' => '',
        'code' => '',
        'status' => '',
        'text_status' => '',
        'module' => 'w4p_answer_codes',
        'message'=>''
    );

    public function __construct($code_id)
    {
        if ($this->checkArray($code_id)) {
            $this->result_w4p_answer_codes['code'] = $code_id;
            $this->result_w4p_answer_codes['status'] = substr(self::$answer_codes[$code_id]['status'], 0, 252);
            $this->result_w4p_answer_codes['text_status'] = substr(self::$answer_codes[$code_id]['text_status'], 0, 252);
            $this->result_w4p_answer_codes['request_status'] = 'ok';
        } else {
            $this->result_w4p_answer_codes['request_status'] = 'error';
            $this->result_w4p_answer_codes['message'] = 'answer code not found';
        }
    }

    private function checkArray($code_id)
    {
        if (isset(self::$answer_codes[$code_id]) && !empty(self::$answer_codes[$code_id]) && self::$answer_codes[$code_id] != '') {
            return true;
        } else {
            return false;
        }
    }
}