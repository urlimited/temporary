<?php

namespace Fabros\OAuth\Contexts;

use Fabros\OAuth\Contexts\OAuthContext;

final class GoogleOAuthContext extends OAuthContext
{
    public function __construct(
        public string $clientId,
        public string $clientSecret,
        public string $redirectURI,
    )
    {
    }
}