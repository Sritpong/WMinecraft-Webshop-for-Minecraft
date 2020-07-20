<?php
    namespace WMinecraft;
    class WalletAPI
    {
        public function Request($method = 'GET', $url, $header = false, $data = false)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_USERAGENT, 'okhttp/3.8.0');
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            if ($header) curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            if ($data) curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            return curl_exec($ch);
        }

        public function FetchActivities($token, $start, $end, $limit = 25)
        {
            $url = "https://mobile-api-gateway.truemoney.com/mobile-api-gateway/user-profile-composite/v1/users/transactions/history?start_date={$start}&end_date={$end}&limit={$limit}";
            $header = array("Host: mobile-api-gateway.truemoney.com", "Authorization: {$token}");
            return @json_decode($this->Request('GET', $url, $header, false), true)['data']['activities'];
        }

        public function FetchTxDetail($token, $id)
        {
            $url = "https://mobile-api-gateway.truemoney.com/mobile-api-gateway/user-profile-composite/v1/users/transactions/history/detail/{$id}";
            $header = array("Host: mobile-api-gateway.truemoney.com", "Authorization: {$token}");
            return @json_decode($this->Request('GET', $url, $header, false), true);
        }

        public function CashcardTopup($token, $cashcard) {
            $time = time();
            $url = "https://mobile-api-gateway.truemoney.com/mobile-api-gateway/api/v1/topup/mobile/{$time}/{$token}/cashcard/{$cashcard}";
            $header = array("Host: mobile-api-gateway.truemoney.com");
            return @json_decode($this->Request('POST', $url, $header, true), true);
        }
    }
?>