<?php

namespace Fabros\OAuth\Contracts;

use Fabros\OAuth\Contexts\GetUserResponseContext;
use Fabros\OAuth\Contexts\OAuthContext;
use Fabros\OAuth\Contexts\OAuthResponseContext;
use Fabros\OAuth\Contexts\RefreshTokenResponseContext;

interface OAuthContract
{
    public function verifyCode(string $code): OAuthResponseContext;

    public function refreshToken(string $refreshToken): RefreshTokenResponseContext;

    public function getUserInfo(string $accessToken): GetUserResponseContext;

    public function revokeToken(string $accessToken): void;

    public static function init(?OAuthContext $context = null): static;
}