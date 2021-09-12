<?php

namespace LINEClient;

use LINE\LINEBot;
use LINE\LINEBot\Constant\MessageType;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder;

class LINEClient
{
    /**
     * @var LINEBot
     */
    private $client;

    /**
     * Set up line client
     */
    public function __construct(string $channelAccessToken, string $channelSecret)
    {
        $httpClient = new CurlHTTPClient($channelAccessToken);
        $this->client = new LINEBot($httpClient, ['channelSecret' => $channelSecret]);
    }

    /**
     * push message
     */
    private function push(string $line_id, MessageBuilder $messageBuilder)
    {
        $this->client->pushMessage($line_id, $messageBuilder);
    }

    /**
     * push text message
     */
    public function pushText(string $line_id, string $text, $extraTexts = null)
    {
        $textMessageBuilder = LINEMessageBuilder::text($text, $extraTexts);

        $this->push($line_id, $textMessageBuilder);
    }

    /**
     * push image with text message
     */
    public function pushImage(string $line_id, string $url, $text = null, $first = MessageType::IMAGE)
    {
        $url = LINEMessageBuilder::image($url);

        if (is_null($text)) {
            $this->push($line_id, $url);
            return;
        }

        $text = LINEMessageBuilder::text($text);

        if ($first === MessageType::IMAGE) {
            $this->push($line_id, LINEMessageBuilder::multi([$url, $text]));
            return;
        }

        $this->push($line_id, LINEMessageBuilder::multi([$text, $url]));
    }

   /**
    * reply message
    */
    private function reply(string $replyToken, MessageBuilder $messageBuilder)
    {
        $this->client->replyMessage($replyToken, $messageBuilder);
    }

    /**
     * reply text message
     */
    public function replyText(string $replyToken, string $text, $extraTexts = null)
    {
        $textMessageBuilder = LINEMessageBuilder::text($text, $extraTexts);

        $this->reply($replyToken, $textMessageBuilder);
    }

    /**
     * reply text message
     */
    public function replyImage(string $replyToken, string $url, $text = null, $first = MessageType::IMAGE)
    {
        $url = LINEMessageBuilder::image($url);

        if (is_null($text)) {
            $this->reply($replyToken, $url);
            return;
        }

        $text = LINEMessageBuilder::text($text);

        if ($first === MessageType::IMAGE) {
            $this->reply($replyToken, LINEMessageBuilder::multi([$url, $text]));
            return;
        }

        $this->reply($replyToken, LINEMessageBuilder::multi([$text, $url]));
    }
}
