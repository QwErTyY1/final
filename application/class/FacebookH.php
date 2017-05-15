<?php


use Facebook\Facebook;



class FacebookH extends Facebook
{

    private $app_id;
    private $api_version;
    private $app_secret;
    private $access_token;
    private $auth = false;
    private $ch;

    public function __construct($app_id, $app_secret, $api_version)
    {
        $this->app_id = $app_id;
        $this->app_secret = $app_secret;
        $this->api_version = $api_version;

        $config = ['app_id' => $this->app_id,
                    'app_secret' => $this->app_secret,
                    'default_graph_version' => $this->api_version,
                    'cookie'=>false
            ];

        parent::__construct($config);
    }

    public function setApiVersion($version)
    {
        $this->api_version = $version;
    }

    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
    }


    public function getAccessToken($code, $callback_url = 'https://home.dev/final/home/callback')
    {


        $parameters = array(
            'client_id' => $this->app_id,
            'client_secret' => $this->app_secret,
            'code' => $code,
            'redirect_uri' => $callback_url
        );
        $rs = json_decode($this->request(
            $this->createUrl(self::ACCESS_TOKEN_URL, $parameters)), true);

            $this->auth = true;
            $this->access_token = $rs['access_token'];
            return $rs;
        }






}