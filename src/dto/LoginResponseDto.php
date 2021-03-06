<?php

namespace SalesforceBulkApi\dto;

use BaseHelpers\hydrators\ConstructFromArrayOrJson;
use SalesforceBulkApi\exceptions\SFClientException;

class LoginResponseDto extends ConstructFromArrayOrJson
{
    /**
     * @var string
     */
    protected $serverUrl;

    /**
     * @var string
     */
    protected $sessionId;

    /**
     * @var string
     */
    protected $userId;

    /**
     * @var string
     */
    protected $instance;

    /**
     * LoginResponseDto constructor.
     *
     * @param null $params
     *
     * @throws SFClientException
     */
    public function __construct($params = null)
    {
        if (!$params instanceof \DOMDocument) {
            parent::__construct($params);
            return;
        }
        try {
            $this->serverUrl = $params->getElementsByTagName('serverUrl')[0]->nodeValue;
            $this->sessionId = $params->getElementsByTagName('sessionId')[0]->nodeValue;
            $this->userId    = $params->getElementsByTagName('userId')[0]->nodeValue;

            //  extract the instance portion of the URL.
            preg_match('/https:\/\/(.*)\.salesforce\.com/', $this->serverUrl, $matches);
            $this->instance  = $matches[1];
        } catch (\Exception $e) {
            throw new SFClientException('SF Api waiting behavior changed. Parse response error: ' . $e->getMessage());
        }
    }

    /**
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @return string
     */
    public function getInstance()
    {
        return $this->instance;
    }
}
