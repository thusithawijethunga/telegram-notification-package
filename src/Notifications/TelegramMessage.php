<?php

namespace Promoxp\Telegram\Notifications; 

class TelegramMessage
{
    protected $variables;
   
    public function __construct($variables, $recipient)
    {
        $this->variables = $variables;
    }

    public function variables()
    {
        return $this->variables;
    }
   
}
