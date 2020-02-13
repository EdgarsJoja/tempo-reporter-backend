<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

/**
 * Interface ApiControllerInterface
 * @package App\Http\Controllers
 */
interface ApiControllerInterface
{
    public function execute(): JsonResponse;
}
