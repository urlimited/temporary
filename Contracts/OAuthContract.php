<?php

namespace Fabros\OAuth\Contracts;

use Fabros\OAuth\Contexts\GetUserResponseContext;
use Fabros\OAuth\Contexts\OAuthContext;
use Fabros\OAuth\Contexts\OAuthResponseContext;

interface OAuthContract
{
    public function verifyCode(string $code): OAuthResponseContext;

    public function getUserInfo(string $accessToken): GetUserResponseContext;

    public static function init(?OAuthContext $context = null): static;
}