<?php

namespace Fabros\OAuth\Contexts;

use Fabros\OAuth\Contexts\OAuthContext;

final class OAuthResponseContext extends OAuthContext
{
    public function __construct(
        public string $access_token,
        public int $expires_in,
        public string $scope,
        public string $token_type,
        public string $id_token,
        public ?string $refresh_token = null,
    )
    {
    }
}