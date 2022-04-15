<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 15.04.22
 */

namespace Rissc\Printformer\Tests\Url;

use GuzzleHttp\Psr7\Uri;
use Illuminate\Config\Repository;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\LooseValidAt;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use PHPUnit\Framework\TestCase;
use Rissc\Printformer\Client\User\User;
use Rissc\Printformer\Url\DraftFiles;
use Rissc\Printformer\Url\TemplateFiles;
use Rissc\Printformer\Url\TokenBuilder;

class TemplateFilesTest extends TestCase
{
    use ParsesTokens;

    private const TEST_API_TOKEN = 'pqalymxnskwoiedjcnvbfhrutzg';
    private TemplateFiles $templateFiles;

    public function setUp(): void
    {
        parent::setUp();
        $config = new Repository([
            'base_uri' => 'https://printformer.test',
            'identifier' => 'test api identifier',
            'api_key' => self::TEST_API_TOKEN
        ]);
        $this->templateFiles = new TemplateFiles($config, new TokenBuilder($config));
    }

    public function dataProvider(): \Generator
    {
        yield 'variantExport' => ['variantExport', 'variant-export'];
        yield 'variantThumb' => ['variantThumb', 'variant-thumb'];
        yield 'photoThumb' => ['photoThumb', 'photo-thumb'];
        yield 'pagePreviewThumb' => ['pagePreviewThumb', 'page-preview-thumb'];
    }

    /** @dataProvider dataProvider */
    public function testUrlCreation(string $method, string $pathSegment): void
    {
        $configuration = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText(self::TEST_API_TOKEN)
        );

        $configuration->setValidationConstraints(
            new SignedWith(
                new Sha256(),
                InMemory::plainText(self::TEST_API_TOKEN)
            ),
            new LooseValidAt(SystemClock::fromUTC())
        );

        $url = new Uri((string)$this->templateFiles->$method('1qayxsw223'));

        static::assertEquals('https', $url->getScheme());
        static::assertEquals('printformer.test', $url->getHost());

        $path = sprintf('/api-ext/files/template/1qayxsw223/%s', $pathSegment);
        static::assertEquals($path, $url->getPath());

        parse_str($url->getQuery(), $query);
        static::assertArrayHasKey('jwt', $query);

        $token = $this->parseToken($configuration, $query['jwt']);
        static::assertFalse($token->headers()->has('jti'));
        $claims = $token->claims();
        static::assertEquals('test api identifier', $claims->get('client'));
        static::assertEquals($path, $claims->get('urlPath'));
    }
}
