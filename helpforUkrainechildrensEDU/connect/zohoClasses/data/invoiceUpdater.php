<?php


class invoiceUpdater
{
    public function updateInvoice($invoice_id, $payment_url, $order_id, $zoho)
    {
        if (empty($order_id)) {
            return array(
                'request_status' => 'error',
                'module' => 'insert url to crm',
                'message' => 'order_id empty!'
            );
        }
        if (empty($invoice_id)) {
            return array(
                'request_status' => 'error',
                'module' => 'insert url to crm',
                'message' => 'invoice_id empty!'
            );
        }

        $request = [
            'Payment_url_w4p' => stripcslashes($payment_url),
            'orderReference_w4p' => strtolower($order_id)
        ];

        $invoice = ($zoho->updateRecord('Invoices', $invoice_id, $request, '', 'approval, workflow, blueprint'));
    }
}