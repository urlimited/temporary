<?php

namespace Fabros\OAuth;

use Fabros\OAuth\Contexts\OAuthContext;
use Fabros\OAuth\Contracts\OAuthContract;
use Fabros\OAuth\Exceptions\ProviderNotFoundException;
use Fabros\OAuth\Providers\GoogleProvider;
use Psr\Http\Message\ResponseInterface;

final class OAuthFacade
{
    private static ?OAuthContract $authProvider = null;

    public const GOOGLE_AUTH_PROVIDER = GoogleProvider::class;

    private function __construct(){}

    /**
     * @throws ProviderNotFoundException
     */
    public static function verifyCode(string $code): ResponseInterface
    {
        if (is_null(self::$authProvider)) {
            throw new ProviderNotFoundException();
        }

        return self::$authProvider->verifyCode($code);
    }

    /**
     * @throws ProviderNotFoundException
     */
    public static function setProvider(string $providerClassName, OAuthContext $context): void
    {
        if (!in_array($providerClassName, [self::GOOGLE_AUTH_PROVIDER])) {
            throw new ProviderNotFoundException();
        }

        self::$authProvider = call_user_func_array(
            "$providerClassName::init",
            [
                'context' => $context
            ]
        );
    }
}