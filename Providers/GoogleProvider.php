<?php

namespace Fabros\OAuth\Providers;

use Fabros\OAuth\Contexts\GoogleOAuthContext;
use Fabros\OAuth\Contexts\OAuthContext;
use Fabros\OAuth\Contracts\OAuthContract;
use Fabros\OAuth\Exceptions\ContextNotFoundException;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

final class GoogleProvider implements OAuthContract
{
    static private ?GoogleProvider $instance = null;

    private function __construct(
        private string $clientId,
        private string $clientSecret,
        private string $redirectURI,
    )
    {
    }

    public function verifyCode(string $code): ResponseInterface
    {
        return (new Client())
            ->post(
                'https://oauth2.googleapis.com/token',
                [
                    'headers' => [
                        'Content-Type' => 'application/x-www-form-urlencoded',
                    ],
                    'form_params' => [
                        'code' => $code,
                        'client_id' => $this->clientId,
                        'client_secret' => $this->clientSecret,
                        'redirect_uri' => $this->redirectURI,
                        'grant_type' => 'authorization_code',
                    ]
                ],
            );
    }

    /**
     * @throws ContextNotFoundException
     */
    public static function init(OAuthContext|GoogleOAuthContext $context = null): static
    {
        if (is_null(self::$instance)) {
            if (is_null($context)) {
                throw new ContextNotFoundException();
            }

            self::$instance = new GoogleProvider(
                clientId: $context->clientId,
                clientSecret: $context->clientSecret,
                redirectURI: $context->redirectURI,
            );
        }

        return self::$instance;
    }
}