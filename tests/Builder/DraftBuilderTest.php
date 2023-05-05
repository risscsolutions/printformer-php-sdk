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
use Rissc\Printformer\Builder\DraftBuilder;
use Rissc\Printformer\Client\Draft\Draft;
use Rissc\Printformer\Client\Draft\DraftClient;
use Rissc\Printformer\Client\Theme\Theme;

class DraftBuilderTest extends TestCase
{
    public function testMinimal(): void
    {
        $client = $this->createMock(DraftClient::class);
        $client
            ->expects(static::once())
            ->method('create')
            ->with([
                'intent' => 'customize',
                'user_identifier' => '123xyzab',
                'templateIdentifier' => 'poiuzt12',

                'apiDefaultValues' => [],
                'customAttributes' => [],

                'pagePlanner' => false,
                'remoteAcl' => false,
                'locked' => false,
                'disablePreflight' => false,
            ])
            ->willReturn(new Draft(
                '123xyzab',
                null,
                'poiuzt12',
                null,
                '1qayxsw23edcvfr45tgb',
                ['amount' => 0],
                -1,
                ['id' => null, 'version' => null],
                [],
                [],
                'init',
                'in-progress',
                []
            ));

        $builder = new DraftBuilder($client);

        $builder
            ->intent('customize')
            ->user('123xyzab')
            ->template('poiuzt12')
            ->create();
    }

    public function testFull(): void
    {
        $client = $this->createMock(DraftClient::class);
        $client
            ->expects(static::once())
            ->method('create')
            ->with([
                'intent' => 'customize',
                'user_identifier' => '123xyzab',
                'templateIdentifier' => 'poiuzt12',
                'userGroupIdentifier' => 'loikujzh',
                'feedIdentifier' => '98bv5rjf',
                'declarationIdentifier' => 'zsn83nbr7',
                'defaultGroupTemplate' => 'arhjtuk5',

                'variant' => 23,
                'availableVariants' => [23, 5],
                'version' => 23,
                'availableVariantVersions' => [23, 5],
                'availableCatalogTemplates' => ['vgzuhb89', '56rdzg78'],

                'unit' => 'mm',
                'theme' => 'aw3n4h8H',

                'apiDefaultValues' => ['a' => 'b'],
                'customAttributes' => ['pf-ca-c' => 'd'],

                'pageDimensions' => [
                    ['width' => 230, 'height' => 50],
                    ['width' => 200.0, 'height' => 100.0],
                    ['width' => 230, 'height' => 50],
                ],
                'bleedAdditions' => [
                    'top' => 10,
                    'left' => 15,
                    'bottom' => 20,
                    'right' => 25
                ],

                'pagePlanner' => true,
                'remoteAcl' => true,
                'locked' => true,
                'disablePreflight' => true,
                'spineWidth' => 10.0,
                'pageFillColor' => '#ff0000',
                'containerContentPreFilling' => [
                    [
                        'page' => 1,
                        'containerIdentifier' => 'bottom-left',
                        'catalogTemplateIdentifier' => 'vgzuhb89'
                    ],
                    [
                        'page' => 2,
                        'containerIdentifier' => 'top-right',
                        'catalogTemplateIdentifier' => '56rdzg78'
                    ]
                ],
            ])
            ->willReturn(new Draft(
                '123xyzab',
                'loikujzh',
                'poiuzt12',
                'arhjtuk5',
                '1qayxsw23edcvfr45tgb',
                ['amount' => 0],
                -1,
                ['id' => null, 'version' => null],
                ['a' => 'b'],
                ['pf-ca-c' => 'd'],
                'init',
                'in-progress',
                []
            ));

        $builder = new DraftBuilder($client);

        $builder
            ->intent('customize')
            ->user('123xyzab')
            ->template('poiuzt12')
            ->userGroup('loikujzh')
            ->defaultGroupTemplate('arhjtuk5')
            ->apiDefaultValues(['a' => 'b'])
            ->customAttributes(['pf-ca-c' => 'd'])
            ->pagePlanner(true)
            ->remoteAcl(true)
            ->locked(true)
            ->disablePreflight(true)
            ->unit('mm')
            ->feed('98bv5rjf')
            ->declaration('zsn83nbr7')
            ->theme(new Theme('aw3n4h8H', 'My First Theme'))
            ->pageDimensions([['width' => 230, 'height' => 50]])
            ->addPageDimension(2, 200, 100)
            ->addPageDimension(3, ['width' => 230, 'height' => 50])
            ->variant(23)
            ->availableVariants([23, 5])
            ->variantVersion(23)
            ->availableVariantVersions([23, 5])
            ->spineWidth(10)
            ->bleedAdditions(10, 15, 20, 25)
            ->pageFillColor('#ff0000')
            ->availableCatalogTemplates(['vgzuhb89', '56rdzg78'])
            ->containerContentPreFilling([[
                'page' => 1,
                'containerIdentifier' => 'bottom-left',
                'catalogTemplateIdentifier' => 'vgzuhb89'
            ]])
            ->addContainerContentPreFilling(2, 'top-right', '56rdzg78')
            ->create();
    }
}
