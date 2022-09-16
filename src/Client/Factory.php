<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 26.03.22
 */

namespace Rissc\Printformer\Client;

use Rissc\Printformer\Client\Derivative\DerivativeClient;
use Rissc\Printformer\Client\Draft\Draft;
use Rissc\Printformer\Client\Draft\DraftClient;
use Rissc\Printformer\Client\Feed\FeedClient;
use Rissc\Printformer\Client\File\FileClient;
use Rissc\Printformer\Client\MasterTemplate\MasterTemplateClient;
use Rissc\Printformer\Client\Processing\ProcessingClient;
use Rissc\Printformer\Client\Review\ReviewClient;
use Rissc\Printformer\Client\Tenant\TenantClient;
use Rissc\Printformer\Client\Theme\ThemeClient;
use Rissc\Printformer\Client\User\UserClient;
use Rissc\Printformer\Client\UserGroup\UserGroupClient;
use Rissc\Printformer\Client\VariableData\VariableDataClient;
use Rissc\Printformer\Client\Variant\VariantClient;
use Rissc\Printformer\Client\Workflow\WorkflowClient;

interface Factory
{
    public function user(): UserClient;

    public function userGroup(): UserGroupClient;

    public function masterTemplate(): MasterTemplateClient;

//TODO    public function availTemplates();
//TODO    public function catalogTemplates();
//TODO    public function pageTemplates();

    public function draft(): DraftClient;

    public function variableData(string|Draft $draft): VariableDataClient;

    public function workflow(): WorkflowClient;

    public function processing(): ProcessingClient;

    public function review(): ReviewClient;

    public function feed(): FeedClient;

//TODO    public function pagePlanner();

    public function tenant(): TenantClient;

    public function theme(): ThemeClient;

    public function file(): FileClient;

    public function derivative(Resource $owner): DerivativeClient;

//TODO    public function declaration();

    public function variant(): VariantClient;

}
