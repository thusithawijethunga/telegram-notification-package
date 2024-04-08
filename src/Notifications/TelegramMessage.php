<?php

namespace Promoxp\Telegram\Notifications;

class TelegramMessage
{
    protected $campaignName;
    protected $message;
    protected $fileUrl;
    protected $templateId;
    protected $variables;
    protected $appkey;

    public function __construct($campaignName, $message, $templateId, $variables, $appkey=null)
    {
        $this->campaignName = $campaignName;
        $this->message      = $message;
        $this->templateId   = $templateId;
        $this->variables    = $variables;
        $this->appkey       = $appkey;
    }

    public function appkey()
    {
        return $this->appkey;
    }

    public function campaignName()
    {
        return $this->campaignName;
    }

    public function message()
    {
        return $this->message;
    }

    public function fileUrl()
    {
        return $this->fileUrl;
    }

    public function templateId()
    {
        return $this->templateId;
    }

    public function variables()
    {
        return $this->variables;
    }
}
