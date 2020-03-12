<?php

namespace App\User;

/**
 * Class ApiTokenGenerator
 * @package App\User
 */
class ApiTokenGenerator implements ApiTokenGeneratorInterface
{
    /**
     * @inheritDoc
     */
    public function generate(): string
    {
        return md5(time());
    }
}

