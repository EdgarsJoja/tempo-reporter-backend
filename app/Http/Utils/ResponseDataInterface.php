<?php

namespace App\Http\Utils;

/**
 * Interface ResponseDataInterface
 * @package App\Http\Utils
 */
interface ResponseDataInterface
{
    /**
     * Initialise data
     *
     * @param $data
     * @return mixed
     */
    public function initData($data = null);

    /**
     * Add error to response
     *
     * @param $errorMessage
     * @return mixed
     */
    public function addError($errorMessage);

    /**
     * Add success to response
     *
     * @param $successMessage
     * @return mixed
     */
    public function addSuccess($successMessage);

    /**
     * Add message to response
     *
     * @param $message
     * @return mixed
     */
    public function addMessage($message);

    /**
     * Get all response data
     *
     * @return array
     */
    public function getData(): array;
}

