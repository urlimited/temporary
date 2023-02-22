<?php

namespace Fabros\OAuth\Tests\Unit;

require_once "./vendor/autoload.php";

use Fabros\OAuth\OAuthFacade;
use Fabros\OAuth\Contexts\GoogleOAuthContext;
use PHPUnit\Framework\TestCase;

class CodeVerifyTest extends TestCase
{
    public function testVerifyCodeSuccessfully()
    {
        OAuthFacade::setProvider(
            OAuthFacade::GOOGLE_AUTH_PROVIDER,
            new GoogleOAuthContext(
                clientId: '665583380747-m645q3fif6mqlh5vq1dc0fif23h762qn.apps.googleusercontent.com',
                clientSecret: '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',
                redirectURI: 'http://localhost:8000/callback'
            )
        );
        OAuthFacade::verifyCode('4%2F0AWtgzh4BtfQr9-7mRQUxLB27c4VIJR5ulcLs-d9qCWiikbgtjqZxE_WU93eerRSTeoJ9FQ');
    }
}
