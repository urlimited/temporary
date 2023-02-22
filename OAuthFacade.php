<?php

namespace Fabros\OAuth;

use Fabros\OAuth\Contexts\GetUserResponseContext;
use Fabros\OAuth\Contexts\OAuthContext;
use Fabros\OAuth\Contexts\OAuthResponseContext;
use Fabros\OAuth\Contracts\OAuthContract;
use Fabros\OAuth\Exceptions\ProviderNotFoundException;
use Fabros\OAuth\Providers\GoogleProvider;

final class OAuthFacade
{
    private static ?OAuthContract $authProvider = null;

    public const GOOGLE_AUTH_PROVIDER = GoogleProvider::class;

    private function __construct(){}

    /**
     * @throws ProviderNotFoundException
     */
    public static function verifyCode(string $code): OAuthResponseContext
    {
        if (is_null(self::$authProvider)) {
            throw new ProviderNotFoundException();
        }

        return self::$authProvider->verifyCode($code);
    }

    /**
     * @throws ProviderNotFoundException
     */
    public static function getUserInfo(string $accessToken): GetUserResponseContext
    {
        if (is_null(self::$authProvider)) {
            throw new ProviderNotFoundException();
        }

        return self::$authProvider->getUserInfo($accessToken);
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