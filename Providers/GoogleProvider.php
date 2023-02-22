<?php

namespace Fabros\OAuth\Providers;

use Fabros\OAuth\Contexts\GetUserResponseContext;
use Fabros\OAuth\Contexts\GoogleOAuthContext;
use Fabros\OAuth\Contexts\OAuthContext;
use Fabros\OAuth\Contexts\OAuthResponseContext;
use Fabros\OAuth\Contracts\OAuthContract;
use Fabros\OAuth\Exceptions\ContextNotFoundException;
use GuzzleHttp\Client;

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

    public function verifyCode(string $code): OAuthResponseContext
    {
        $response = json_decode(
            (new Client())
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
                            'scope' => 'openid https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',
                            'response_type' => 'code',
                            'access_type' => 'offline',
                        ]
                    ],
                )
                ->getBody()
                ->getContents(),
            true
        );

        $gResponseContext = new OAuthResponseContext(
            access_token: $response['access_token'],
            expires_in: $response['expires_in'],
            scope: $response['scope'],
            token_type: $response['token_type'],
            id_token: $response['id_token']
        );

        if (array_key_exists('refresh_token', $response)) {
            $gResponseContext->refresh_token = $response['refresh_token'];
        }

        return $gResponseContext;
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

    public function getUserInfo(string $accessToken): GetUserResponseContext
    {
        $response = json_decode(
            (new Client())
                ->get(
                    'https://www.googleapis.com/oauth2/v1/userinfo',
                    [
                        'headers' => [
                            'Content-Type' => 'application/x-www-form-urlencoded',
                        ],
                        'query' => [
                            'access_token' => $accessToken,
                            'alt' => 'json'
                        ]
                    ],
                )
                ->getBody()
                ->getContents(),
            true
        );

        $gResponseContext = new GetUserResponseContext(
            email: $response['email'],
            id: $response['id'],
        );

        if (array_key_exists('name', $response)) {
            $gResponseContext->name = $response['name'];
        }

        if (array_key_exists('avatar', $response)) {
            $gResponseContext->avatar = $response['avatar'];
        }

        return $gResponseContext;
    }
}