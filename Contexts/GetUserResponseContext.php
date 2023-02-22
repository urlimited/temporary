<?php

namespace Fabros\OAuth\Contexts;

use Fabros\OAuth\Contexts\OAuthContext;

final class GetUserResponseContext extends OAuthContext
{
    public function __construct(
        public string $email,
        public string $id,
        public ?string $name = null,
        public ?string $avatar = null,
    )
    {
    }
}