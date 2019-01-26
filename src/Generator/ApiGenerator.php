<?php

namespace Ujamii\OpenImmo\Generator;

use GoetasWebservices\XML\XSDReader\Schema\Attribute\Attribute;
use GoetasWebservices\XML\XSDReader\Schema\Element\ElementItem;
use GoetasWebservices\XML\XSDReader\Schema\Element\ElementRef;
use GoetasWebservices\XML\XSDReader\Schema\Inheritance\Restriction;
use GoetasWebservices\XML\XSDReader\Schema\Type\ComplexType;
use GoetasWebservices\XML\XSDReader\Schema\Type\ComplexTypeSimpleContent;
use GoetasWebservices\XML\XSDReader\Schema\Type\SimpleType;
use GoetasWebservices\XML\XSDReader\Schema\Type\Type;
use GoetasWebservices\XML\XSDReader\SchemaReader;
use gossi\codegen\generator\CodeFileGenerator;
use gossi\codegen\model\PhpClass;
use gossi\codegen\model\PhpMethod;
use gossi\codegen\model\PhpParameter;
use gossi\codegen\model\PhpProperty;
use gossi\docblock\tags\TagFactory;

/**
 * Class ApiGenerator
 * @package Ujamii\OpenImmo\Generator
 */
class ApiGenerator
{

    //TODO: make this configurable
    const TARGET_FOLDER = './src/API/';

    /**
     * @var array
     */
    protected $generatorConfig = [
        'generateScalarTypeHints' => true,
        'generateReturnTypeHints' => true
    ];

    /**
     * ApiGenerator constructor.
     *
     * @param string $xsdFile file path
     *
     * @param bool $wipeTargetFolder
     *
     * @throws \GoetasWebservices\XML\XSDReader\Exception\IOException
     */
    public function __construct($xsdFile, $wipeTargetFolder = true)
    {
        if ($wipeTargetFolder) {
            $this->wipeTargetFolder();
        }

        $reader = new SchemaReader();
        $schema = $reader->readFile($xsdFile);

        foreach ($schema->getElements() as $element) {
            if ( ! ($element->getType() instanceof SimpleType)) {
                $this->parseElementDef($element);
            }
        }
    }

    /**
     * @param ElementItem $element
     */
    protected function parseElementDef(ElementItem $element)
    {
        $className = $this->camelize($element->getName());

        $class = new PhpClass();
        $class
            ->setQualifiedName('Ujamii\\OpenImmo\\API\\' . $className)
            ->setUseStatements(['JMS\Serializer\Annotation\XmlRoot'])
            ->setDescription('Class ' . $className)
            ->getDocblock()
                ->appendTag(TagFactory::create('package', 'Ujamii\OpenImmo\API'))
                ->appendTag(TagFactory::create('XmlRoot("' . $element->getName() . '")'))
        ;
        if ($element->getType() instanceof ComplexTypeSimpleContent) {
            // TODO: extension of class (konktakt)
        } else {
            foreach ($element->getType()->getElements() as $property) {
                $this->parseProperty($property, $class);
            }
            /* @var $attributeFromXsd Attribute */
            foreach ($element->getType()->getAttributes() as $attributeFromXsd) {
                $this->parseAttribute($attributeFromXsd, $class);
            }
            if (count($element->getType()->getAttributes()) > 0) {
                $class->addUseStatement('JMS\Serializer\Annotation\XmlAttribute');
            }
        }

        $this->createPhpFile($class);
    }

    /**
     * @param ElementItem $property
     * @param PhpClass $class
     */
    protected function parseProperty(ElementItem $property, PhpClass $class)
    {
        $propertyName  = $this->camelize($property->getName(), true);
        $classProperty = PhpProperty::create($propertyName)->setVisibility(PhpProperty::VISIBILITY_PROTECTED);
        if ($property instanceof ElementRef) {
            if ($property->getReferencedElement()->getType() instanceof SimpleType) {
                $propertyType = $this->extractPhpType($property->getReferencedElement()->getType());
            } else {
                $propertyType = $this->camelize($property->getReferencedElement()->getName());
            }
        } else {
            $propertyType = $this->extractPhpType($property->getType());;
        }
        // take min/max into account, as this may be an array instead
        if ($property->getMax() == -1) {
            $propertyType .= '[]';
        }

        $classProperty->setType($this->getValidType($propertyType, $classProperty, $class));

        if ($property->getType()->getRestriction()) {
            if (empty($propertyType) && !empty($property->getType()->getRestriction()->getBase())) {
                $propertyType = $this->getValidType($property->getType()->getRestriction()->getBase()->getName(), $classProperty, $class);
                $classProperty->setType($propertyType);
            }
            $this->parseRestriction(
                $property->getType()->getRestriction(),
                $property->getName(),
                $class,
                $classProperty
            );
        }

        $class->setProperty($classProperty);

        $this->generateGetterAndSetter($classProperty, $class);
    }

    /**
     * @param Attribute $attribute
     * @param PhpClass $class
     */
    protected function parseAttribute(Attribute $attribute, PhpClass $class)
    {
        $propertyName  = $this->camelize(strtolower($attribute->getName()), true);
        $classProperty = PhpProperty::create($propertyName)->setVisibility(PhpProperty::VISIBILITY_PROTECTED);
        $type = $this->extractPhpType($attribute->getType());

        $classProperty->setType($this->getValidType($type, $classProperty, $class));
        $classProperty->getDocblock()->appendTag(TagFactory::create('XmlAttribute'));

        if ($attribute->getUse() != '') {
            $classProperty->setDescription($attribute->getUse());
        }

        $this->parseRestriction(
            $attribute->getType()->getRestriction(),
            $attribute->getName(),
            $class,
            $classProperty
        );

        $class->setProperty($classProperty);

        $this->generateGetterAndSetter($classProperty, $class);
    }

    /**
     * @param Restriction $restriction
     * @param string $nameInXsd
     * @param PhpClass $class
     * @param PhpProperty $classProperty
     */
    protected function parseRestriction(Restriction $restriction, string $nameInXsd, PhpClass $class, PhpProperty $classProperty)
    {
        if (count($restriction->getChecks()) > 0) {
            foreach ($restriction->getChecks() as $type => $options) {
                switch ($type) {

                    case 'enumeration':
                        $constantPrefix = strtoupper($nameInXsd . '_');
                        foreach ($options as $possibleValue) {
                            $constantName = strtoupper($constantPrefix . str_replace('-', '_', $possibleValue['value']));
                            $class->setConstant($constantName, $possibleValue['value']);
                        }
                        $classProperty->getDocblock()->appendTag(TagFactory::create('see', $constantPrefix . '* constants'));
                        break;

                    case 'whiteSpace':
                        // do nothing
                        break;

                    case 'minLength':
                        //TODO
                        break;

                    case 'minInclusive':
                        //TODO
                        break;

                    case 'maxInclusive':
                        //TODO
                        break;

                    case 'fractionDigits':
                        //TODO
                        break;

                    default:
                        throw new \InvalidArgumentException(vsprintf('Type "%s" is not handled in %s->parseAttribute', [$type, __CLASS__]));
                        break;

                }
            }
        }
    }

    /**
     * @param Type $typeFromXsd
     *
     * @return string|null
     */
    protected function extractPhpType(Type $typeFromXsd)
    {
        if ($typeFromXsd->getName() != '') {
            $type = $typeFromXsd->getName();
        } else {
            if ($typeFromXsd instanceof ComplexType) {
                //TODO: whatever structure UserDefinedExtend->feld really is...
                $type = 'string';
            } else {
                if ($typeFromXsd->getRestriction()->getBase() != '') {
                    $type = $typeFromXsd->getRestriction()->getBase()->getName();
                }
            }

        }

        return $type;
    }

    /**
     * @param string $propertyType
     * @param PhpProperty $classProperty
     * @param PhpClass $class
     *
     * @return string
     */
    protected function getValidType(string $propertyType, PhpProperty $classProperty, PhpClass $class)
    {
        switch ($propertyType) {

            case 'decimal':
                $propertyType = 'float';
                break;

            case 'positiveInteger':
                $propertyType = 'int';
                break;

            case 'dateTime':
                $propertyType = '\DateTime';
                $classProperty->getDocblock()->appendTag(TagFactory::create('Type("DateTime<\'Y-m-d\TH:i:s\'>")'));
                $class->addUseStatement('JMS\Serializer\Annotation\Type');
                break;

            case 'date':
                $propertyType = '\DateTime';
                $classProperty->getDocblock()->appendTag(TagFactory::create('Type("DateTime<\'Y-m-d\'>")'));
                $class->addUseStatement('JMS\Serializer\Annotation\Type');
                break;
        }

        return $propertyType;
    }

    /**
     * @param PhpProperty $property
     * @param PhpClass $class
     * @param bool $fluentApi
     */
    protected function generateGetterAndSetter(PhpProperty $property, PhpClass $class, $fluentApi = true)
    {
        $this->generateSetter($property, $class, $fluentApi);
        $this->generateGetter($property, $class);
    }

    /**
     * @param $input
     * @param bool $lcFirst
     * @param array $separators
     *
     * @return mixed|string
     */
    protected function camelize($input, $lcFirst = false, $separators = ['-', '_'])
    {
        $camel = str_replace($separators, '', ucwords($input, implode('', $separators)));
        if ($lcFirst) {
            $camel = lcfirst($camel);
        }

        return $camel;
    }

    /**
     * Removes all files in the target folder.
     */
    protected function wipeTargetFolder()
    {
        array_map('unlink', glob(self::TARGET_FOLDER . '/*.php'));
    }

    /**
     * @return array
     */
    public function getGeneratorConfig(): array
    {
        return $this->generatorConfig;
    }

    /**
     * @param array $generatorConfig
     */
    public function setGeneratorConfig(array $generatorConfig): void
    {
        $this->generatorConfig = $generatorConfig;
    }

    /**
     * @param PhpProperty $property
     * @param PhpClass $class
     */
    protected function generateGetter(PhpProperty $property, PhpClass $class): void
    {
        $returnsArray = substr($property->getType(), -2) == '[]';
        $getter     = PhpMethod::create('get' . ucfirst($property->getName()));
        $getterCode = 'return $this->' . $property->getName() . ';';
        $getter->setBody($getterCode);
        $getter->setType($returnsArray ? 'array' : $property->getType());
        if ($returnsArray) {
            $getter->setDescription('Returns array of ' . str_replace('[]', '', $property->getType()));
        }
        $class->setMethod($getter);
    }

    /**
     * @param PhpProperty $property
     * @param PhpClass $class
     * @param $fluentApi
     */
    protected function generateSetter(PhpProperty $property, PhpClass $class, $fluentApi): void
    {
        $setter = PhpMethod::create('set' . ucfirst($property->getName()));
        $setter->addParameter(PhpParameter::create($property->getName())
                                          ->setType(substr($property->getType(), -2) == '[]' ? 'array' : $property->getType())
                                          ->setDescription('Setter for ' . $property->getName())
        );
        $setterCode = '$this->' . $property->getName() . ' = $' . $property->getName() . ';';
        if ($fluentApi) {
            $setterCode .= PHP_EOL . 'return $this;';
            $setter->getDocblock()->appendTag(TagFactory::create('return', $class->getName()));
        }
        $setter->setBody($setterCode);
        $class->setMethod($setter);
    }

    /**
     * @param PhpClass $class
     *
     * @return bool|int
     */
    protected function createPhpFile(PhpClass $class)
    {
        $generator = new CodeFileGenerator($this->getGeneratorConfig());
        $code      = $generator->generate($class);
        return file_put_contents(self::TARGET_FOLDER . $class->getName() . '.php', $code);
    }

}