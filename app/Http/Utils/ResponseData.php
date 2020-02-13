<?php

namespace App\Http\Utils;

/**
 * Class ResponseData
 * @package App\Http\Utils
 */
class ResponseData implements ResponseDataInterface
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @var array
     */
    private $defaultData = [
        'error' => false,
        'messages' => []
    ];

    /**
     * @inheritDoc
     */
    public function initData($data = null)
    {
        $this->data = $data ?: $this->defaultData;
    }

    /**
     * @inheritDoc
     */
    public function addError($errorMessage)
    {
        $this->data['error'] = true;
        $this->data['messages'][] = $errorMessage;
    }

    /**
     * @inheritDoc
     */
    public function addSuccess($successMessage)
    {
        if (isset($this->data['error']) && !$this->data['error']) {
            $this->data['messages'][] = $successMessage;
        }
    }

    /**
     * @inheritDoc
     */
    public function addMessage($message)
    {
        $this->data['messages'] = $message;
    }

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        return $this->data;
    }
}
