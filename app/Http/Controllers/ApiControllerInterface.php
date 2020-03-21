<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

/**
 * Interface ApiControllerInterface
 * @package App\Http\Controllers
 */
interface ApiControllerInterface
{
    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse;
}
