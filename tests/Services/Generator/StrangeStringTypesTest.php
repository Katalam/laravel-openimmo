<?php

declare(strict_types=1);

use Katalam\OpenImmo\Facades\TranslationService;
use Katalam\OpenImmo\Tests\TestCase;

test('strange string types', function () {
    TranslationService::addFakeClass('StrangeStringTypes');
    TranslationService::addFakeProperty('telZentrale');
    TranslationService::addFakeProperty('anhanginhalt');

    /** @var TestCase $this */
    $generatedClass = $this->getGeneratedClassFromFile('strange_string_types');

    $this->assertClassHasProperties($generatedClass, [
        ['telZentrale', 'string', true, []],
        ['anhanginhalt', 'string', true, []],
    ]);
});
