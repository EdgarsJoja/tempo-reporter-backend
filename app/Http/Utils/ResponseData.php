<?php

namespace App\Http\Utils;

/**
 * Class ResponseData
 * @package App\Http\Utils
 */
class ResponseData implements ResponseDataInterface
{
    /**
     * Message types
     */
    private const MESSAGE_TYPE_SUCCESS = 'success';
    private const MESSAGE_TYPE_ERROR = 'error';
    private const MESSAGE_TYPE_INFO = 'info';

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var array
     */
    private $defaultData = [
        'error' => false,
        'messages' => [],
        'data' => []
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
        $this->addMessage(static::MESSAGE_TYPE_ERROR, $errorMessage);
    }

    /**
     * @inheritDoc
     */
    public function addSuccess($successMessage)
    {
        if (isset($this->data['error']) && !$this->data['error']) {
            $this->addMessage(static::MESSAGE_TYPE_SUCCESS, $successMessage);
        }
    }

    /**
     * @inheritDoc
     */
    public function addInfoMessage($infoMessage)
    {
        $this->addMessage(static::MESSAGE_TYPE_INFO, $infoMessage);
    }

    /**
     * @param $type
     * @param $message
     */
    protected function addMessage($type, $message): void
    {
        $this->data['messages'][] = [
            'type' => $type,
            'message' => $message
        ];
    }

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @inheritDoc
     */
    public function addData($key, $value): void
    {
        $this->data['data'][$key] = $value;
    }
}
