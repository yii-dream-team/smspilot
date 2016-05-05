<?php
namespace yiidreamteam\smspilot;

use GuzzleHttp\Client;

/**
 * Class Api
 *
 * @package yiidreateam\smspilot
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 * @see http://www.smspilot.ru/download/SMSPilotRu-HTTP-v2.4.13.pdf
 */
class Api
{
    const API_URL = 'https://smspilot.ru/api2.php';
    const SANDBOX_KEY = 'XXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZXXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZ';

    public $sandbox = false;

    /** @var Client */
    protected $client = null;

    protected $defaultParams = [];

    /**
     * Api constructor.
     * @param $apiKey
     */
    public function __construct($apiKey)
    {
        $this->defaultParams = [
            'apikey' => $apiKey,
        ];
    }

    /**
     * Send sms
     *
     * @param $to
     * @param $text
     * @param null $sender
     * @param int $messageId
     * @return string
     * @throws \Exception
     */
    public function send($to, $text, $sender = null, $messageId = 0)
    {
        $params = [
            'id' => $messageId,
            'to' => $to,
            'text' => $text,
        ];

        if (!empty($sender)) {
            $params['from'] = $sender;
        }

        return $this->call('send', $params);
    }

    /**
     * Makes api call
     *
     * @param string $method
     * @param array $params
     * @return string
     * @throws \Exception
     */
    public function call($method, $params = [])
    {
        if (null === $this->client) {
            $this->client = new Client([
                'base_uri' => static::API_URL,
                'content-type' => 'application/json',
            ]);
        }

        $requestParams = array_merge($this->defaultParams, [
            $method => [$params],
        ]);

        if ($this->sandbox) {
            $requestParams['apikey'] = self::SANDBOX_KEY;
        }

        $response = $this->client->post(null, ['body' => json_encode($requestParams)]);
        if ($response->getStatusCode() != 200) {
            throw new \Exception('Api http error: ' . $response->getStatusCode(), $response->getStatusCode());
        }

        $result = json_decode($response->getBody(), true);
        if (isset($result['error'])) {
            throw new \BadMethodCallException('Api error: ' . $result['error']['description'],
                $result['error']['code']);
        }

        return $result;
    }
}
