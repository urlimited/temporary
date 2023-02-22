<?php

namespace Fabros\OAuth\Contracts;

use Fabros\OAuth\Contexts\OAuthContext;
use Psr\Http\Message\ResponseInterface;

interface OAuthContract
{
    public function verifyCode(string $code): ResponseInterface;

    public static function init(?OAuthContext $context = null): static;
}