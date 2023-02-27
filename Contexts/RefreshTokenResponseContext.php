<?php

namespace Fabros\OAuth\Contexts;

use Fabros\OAuth\Contexts\OAuthContext;

final class RefreshTokenResponseContext extends OAuthContext
{
    public function __construct(
        public string $access_token,
        public int $expires_in,
        public string $scope,
        public string $token_type,
    )
    {
    }
}