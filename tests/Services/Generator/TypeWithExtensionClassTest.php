<?php

declare(strict_types=1);

use Katalam\OpenImmo\Facades\TranslationService;
use Katalam\OpenImmo\Tests\TestCase;

test('generate type with extension class', function () {
    TranslationService::addFakeClass('TypeWithExtension');
    TranslationService::addFakeAttribute('foobar');

    /** @var TestCase $this */
    $generatedClass = $this->getGeneratedClassFromFile('type_with_extension');

    $this->assertClassHasProperties($generatedClass, [
        ['foobar', 'float', true, ['XmlAttribute' => '']],
        ['value', 'float', true, ['Inline' => '']],
    ]);
});