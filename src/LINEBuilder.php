<?php

namespace LINEClient;

use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;

class LINEMessageBuilder
{
    /**
     * make text message
     */
    public static function text(string $text, $extraTexts = null): MessageBuilder
    {
        return new TextMessageBuilder($text, $extraTexts);
    }

    /**
     * make image message
     */
    public static function image(string $url): MessageBuilder
    {
        return new ImageMessageBuilder($url, $url);
    }

    /**
     * make Multi Message Builder
     */
    public static function multi(array $builders): MessageBuilder
    {
        $multi_builder = new MultiMessageBuilder();

        foreach ($builders as $builder) {
            if (is_null($builder)) {
                continue;
            }
            $multi_builder->add($builder);
        }

        return $multi_builder;
    }
}
