<?php

declare(strict_types=1);

namespace Katalam\OpenImmo\Tests\Services;

use Illuminate\Support\Facades\Storage;
use Katalam\OpenImmo\Services\DtoGenerator;
use Katalam\OpenImmo\Services\TypeUtil;
use Nette\PhpGenerator\ClassType;
use ReflectionClass;

use function PHPUnit\Framework\assertFileExists;

trait GeneratorHelper
{
    private DtoGenerator $generator;

    public function prepareStorage(): void
    {
        Storage::fake('local');
    }

    public function getGenerator(): DtoGenerator
    {
        if (! isset($this->generator)) {
            $this->generator = new DtoGenerator;
        }

        return $this->generator;
    }

    public function prepareTranslations(): void {}

    public function getGeneratedClassFromFile(string $nameInXsd, string $docBlockComment = ''): ClassType
    {
        $className = TypeUtil::studly($nameInXsd);

        $fixtureFile = "./tests/fixtures/$className.xsd";

        $this->getGenerator()
            ->setTargetFolder(storage_path('app/Dtos/'))
            ->generate($fixtureFile);

        $classFileName = storage_path("app/Dtos/$className.php");

        assertFileExists($classFileName);

        /** @var ClassType $generatedClass */
        $generatedClass = ClassType::fromCode(file_get_contents($classFileName));

        if ($docBlockComment !== '') {
            expect($generatedClass->getComment())->toContain($docBlockComment);
        }

        expect($generatedClass->getComment())->toContain("@XmlRoot(\"$nameInXsd\")");

        return $generatedClass;
    }

    public function assertClassHasProperties(ClassType $class, array $properties): void
    {
        foreach ($properties as $property) {
            $this->assertClassHasProperty($class, ...$property);
        }

        expect($class->getProperties())->toHaveCount(count($properties));
    }

    public function assertClassHasProperty(ClassType $class, string $propertyName, string $type, bool $hasGetterAndSetter, array $docTags, ?string $xsdType = null): void
    {
        expect($class->hasProperty($propertyName))->toBeTrue("Class {$class->getName()} does not have property ".$propertyName);

        $property = $class->getProperty($propertyName);

        $propertyType = TypeUtil::getValidPhpType($xsdType ?? $type);

        expect($property->getType())->toBe($propertyType);

        $serializerType = TypeUtil::getTypeForSerializer($xsdType ?? $type);

        expect($property->getComment())->toContain("@Type(\"$serializerType\")");

        collect($docTags)
            ->each(function (mixed $tagValue, string $tagName) use ($property) {
                if (empty($tagValue)) {
                    expect($property->getComment())->toContain("@$tagName");
                } else {
                    expect($property->getComment())->toContain("@$tagName$tagValue");
                }
            });

        if ($hasGetterAndSetter) {
            expect($property->getVisibility())->toBe('protected')
                ->and($class->hasMethod('get'.ucfirst($propertyName)))->toBeTrue()
                ->and($class->hasMethod('set'.ucfirst($propertyName)))->toBeTrue();

            $phpType = TypeUtil::getValidPhpType($type);
            $getter = $class->getMethod('get'.ucfirst($propertyName));
            expect($getter->getVisibility())->toBe('public')
                ->and($getter->getReturnType())->toBe($phpType);

            $setter = $class->getMethod('set'.ucfirst($propertyName));
            expect($setter->getVisibility())->toBe('public')
                ->and($setter->getReturnType())->toBe('\\'.TypeUtil::OPENIMMO_NAMESPACE.$class->getName())
                ->and($setter->getParameters())->toHaveKey($propertyName)
                ->and($setter->getParameters()[$propertyName]->getType())->toBe($phpType);
        }
    }

    public function assertClassHasConstants(ClassType $class, array $constants): void
    {
        foreach ($constants as $constantName => $constantValue) {
            expect($class->getConstants())->toHaveKey($constantName)
                ->and($class->getConstants()[$constantName]->getValue())->toBe($constantValue);
        }

        expect($class->getConstants())->toHaveCount(count($constants));
    }

    public function getReflectionClassFromGeneratedClass(ClassType $class): ReflectionClass
    {
        $classFileName = storage_path("app/Dtos/{$class->getName()}.php");

        assertFileExists($classFileName);

        require_once $classFileName;

        return new ReflectionClass($class->getNamespace()->getName().'\\'.$class->getName());
    }
}
