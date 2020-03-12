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
     * Add info message to response
     *
     * @param $infoMessage
     * @return mixed
     */
    public function addInfoMessage($infoMessage);

    /**
     * Get all response data
     *
     * @return array
     */
    public function getData(): array;

    /**
     * @param $key
     * @param $value
     */
    public function addData($key, $value);
}

