<?php

class Service
{
    protected $post_data = null;
    protected $service_url;
    protected $base_url;

    public function __construct($config)
    {
        $this->service_url = $this->base_url = $config['url'];
    }

    public function connect($contentType = 'application/json')
    {
        $curl = curl_init();
        $headers = [
            "Content-Type: $contentType"
        ];
        if (isset($_SESSION['access_token'])) {
            //$headers[] = 'X-OT-ACCESS-TOKEN: ' . $_SESSION['access_token'];
            curl_setopt($curl, CURLOPT_USERPWD, $_SESSION['access_token'] . ":" . 'X');
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $this->service_url,
            CURLINFO_HEADER_OUT => true,
            CURLOPT_HTTPHEADER, $headers,
            CURLOPT_SSL_VERIFYPEER => 0
        ]);

        if ($this->post_data !== null) {
            curl_setopt_array($curl, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $contentType === 'application/json' ? json_encode($this->post_data) : http_build_query($this->post_data),
            ]);
        }

        $result = curl_exec($curl);

        if ($result === false) {
            throw new ExceptionHandler('cURL request failed', 412, false);
        }
        
        $this->post_data = NULL;
        
        return json_decode($result, true);
    }
}

?>