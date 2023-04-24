<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 18.04.22
 */

namespace Rissc\Printformer\Tests\Builder;

use PHPUnit\Framework\TestCase;
use Rissc\Printformer\Builder\FeedBuilder;
use Rissc\Printformer\Client\Feed\Config;
use Rissc\Printformer\Client\Feed\Feed;
use Rissc\Printformer\Client\Feed\FeedClient;
use Rissc\Printformer\Client\File\File;

class FeedBuilderTest extends TestCase
{
    public function testURL(): void
    {
        $client = $this->createMock(FeedClient::class);
        $client
            ->expects(static::once())
            ->method('create')
            ->with([
                'name' => 'My test Feed',
                'mappingIdentifier' => 'iuzg34ft',
                'mediaProvider' => 'systemMedia',
                'type' => 'url',
                'shouldReplicate' => false,
                'config' => [
                    'separator' => ',',
                    'parseHTML' => true,
                    'offset' => 0,
                    'identifierAttribute' => 'nr',
                    'polling' => [
                        'enabled' => false,
                    ]
                ],
                'url' => 'https://my-test.feed/file.csv'
            ])
            ->willReturn(new Feed(
                'poiuzt12',
                'url',
                'My test Feed',
                'iuzg34ft',
                'systemMedia',
                Config::fromArray([
                    'separator' => ',',
                    'parseHTML' => true,
                    'offset' => 0,
                    'identifierAttribute' => 'nr',
                    'polling' => [
                        'enabled' => false,
                        'interval' => '0 1 * * *',
                        'dropBeforeImport' => false,
                    ]
                ])
            ));

        $builder = new FeedBuilder($client);

        $builder
            ->name('My test Feed')
            ->mappingIdentifier('iuzg34ft')
            ->mediaProvider('systemMedia')
            ->url('https://my-test.feed/file.csv')
            ->shouldReplicate(false)
            ->config([
                'separator' => ',',
                'parseHTML' => true,
                'offset' => 0,
                'identifierAttribute' => 'nr',
                'polling' => [
                    'enabled' => false
                ]
            ])
            ->create();
    }

    public function testFile(): void
    {
        $client = $this->createMock(FeedClient::class);
        $client
            ->expects(static::once())
            ->method('create')
            ->with([
                'name' => 'My test Feed',
                'mappingIdentifier' => 'iuzg34ft',
                'mediaProvider' => 'systemMedia',
                'type' => 'local',
                'shouldReplicate' => false,
                'config' => [
                    'separator' => ',',
                    'parseHTML' => true,
                    'offset' => 0,
                    'identifierAttribute' => 'nr',
                    'polling' => [
                        'enabled' => false,
                    ]
                ],
                'file' => 'uhzg5603'
            ])
            ->willReturn(new Feed(
                'poiuzt12',
                'local',
                'My test Feed',
                'iuzg34ft',
                'systemMedia',
                Config::fromArray([
                    'separator' => ',',
                    'parseHTML' => true,
                    'offset' => 0,
                    'identifierAttribute' => 'nr',
                    'polling' => [
                        'enabled' => false,
                        'interval' => 0,
                        'dropBeforeImport' => false,
                    ]
                ])
            ));

        $builder = new FeedBuilder($client);

        $builder
            ->name('My test Feed')
            ->mappingIdentifier('iuzg34ft')
            ->mediaProvider('systemMedia')
            ->file(new File('uhzg5603'))
            ->shouldReplicate(false)
            ->config([
                'separator' => ',',
                'parseHTML' => true,
                'offset' => 0,
                'identifierAttribute' => 'nr',
                'polling' => [
                    'enabled' => false
                ]
            ])
            ->create();
    }

    public function testFTP(): void
    {
        $client = $this->createMock(FeedClient::class);
        $client
            ->expects(static::once())
            ->method('create')
            ->with([
                'name' => 'My test Feed',
                'mappingIdentifier' => 'iuzg34ft',
                'mediaProvider' => 'systemMedia',
                'type' => 'ftp',
                'shouldReplicate' => false,
                'config' => [
                    'separator' => ',',
                    'parseHTML' => true,
                    'offset' => 0,
                    'identifierAttribute' => 'nr',
                    'polling' => [
                        'enabled' => false,
                    ]
                ],
                'ftp' => [
                    'host' => 'my-ftp.com',
                    'username' => 'root',
                    'password' => 'omg-so-secure',
                    'path' => '/var/www/uploads',
                    'port' => 1234,
                    'passive' => true
                ]
            ])
            ->willReturn(new Feed(
                'poiuzt12',
                'ftp',
                'My test Feed',
                'iuzg34ft',
                'systemMedia',
                Config::fromArray([
                    'separator' => ',',
                    'parseHTML' => true,
                    'offset' => 0,
                    'identifierAttribute' => 'nr',
                    'polling' => [
                        'enabled' => false,
                        'interval' => '0 1 * * *',
                        'dropBeforeImport' => false,
                    ],
                    'connection' => [
                        'host' => 'my-ftp.com',
                        'username' => 'root',
                        'password' => 'omg-so-secure',
                        'path' => '/var/www/uploads',
                        'port' => 1234,
                        'passive' => true
                    ]
                ])
            ));

        $builder = new FeedBuilder($client);

        $builder
            ->name('My test Feed')
            ->mappingIdentifier('iuzg34ft')
            ->mediaProvider('systemMedia')
            ->ftp([
                'host' => 'my-ftp.com',
                'username' => 'root',
                'password' => 'omg-so-secure',
                'path' => '/var/www/uploads',
                'port' => 1234,
                'passive' => true
            ])
            ->shouldReplicate(false)
            ->config([
                'separator' => ',',
                'parseHTML' => true,
                'offset' => 0,
                'identifierAttribute' => 'nr',
                'polling' => [
                    'enabled' => false
                ]
            ])
            ->create();
    }

    public function testSFTP(): void
    {
        $client = $this->createMock(FeedClient::class);
        $client
            ->expects(static::once())
            ->method('create')
            ->with([
                'name' => 'My test Feed',
                'mappingIdentifier' => 'iuzg34ft',
                'mediaProvider' => 'systemMedia',
                'type' => 'sftp',
                'shouldReplicate' => false,
                'config' => [
                    'separator' => ',',
                    'parseHTML' => true,
                    'offset' => 0,
                    'identifierAttribute' => 'nr',
                    'polling' => [
                        'enabled' => false,
                    ]
                ],
                'sftp' => [
                    'host' => 'my-ftp.com',
                    'username' => 'root',
                    'password' => 'omg-so-secure',
                    'path' => '/var/www/uploads',
                    'port' => 1234,
                    'passive' => true
                ]
            ])
            ->willReturn(new Feed(
                'poiuzt12',
                'sftp',
                'My test Feed',
                'iuzg34ft',
                'systemMedia',
                Config::fromArray([
                    'separator' => ',',
                    'parseHTML' => true,
                    'offset' => 0,
                    'identifierAttribute' => 'nr',
                    'polling' => [
                        'enabled' => false,
                        'interval' => 0,
                        'dropBeforeImport' => false,
                    ],
                    'connection' => [
                        'host' => 'my-ftp.com',
                        'username' => 'root',
                        'password' => 'omg-so-secure',
                        'path' => '/var/www/uploads',
                        'port' => 1234,
                        'passive' => true
                    ]
                ])
            ));

        $builder = new FeedBuilder($client);

        $builder
            ->name('My test Feed')
            ->mappingIdentifier('iuzg34ft')
            ->mediaProvider('systemMedia')
            ->sftp([
                'host' => 'my-ftp.com',
                'username' => 'root',
                'password' => 'omg-so-secure',
                'path' => '/var/www/uploads',
                'port' => 1234,
                'passive' => true
            ])
            ->shouldReplicate(false)
            ->config([
                'separator' => ',',
                'parseHTML' => true,
                'offset' => 0,
                'identifierAttribute' => 'nr',
                'polling' => [
                    'enabled' => false
                ]
            ])
            ->create();
    }
}
