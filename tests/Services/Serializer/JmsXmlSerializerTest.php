<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Innobrain\OpenImmo\Dtos\Apartment;
use Innobrain\OpenImmo\Dtos\ContactPerson;
use Innobrain\OpenImmo\Dtos\Distances;
use Innobrain\OpenImmo\Dtos\Evaluation;
use Innobrain\OpenImmo\Dtos\ExternalCommission;
use Innobrain\OpenImmo\Dtos\Field;
use Innobrain\OpenImmo\Dtos\Infrastructure;
use Innobrain\OpenImmo\Dtos\MarketingType;
use Innobrain\OpenImmo\Dtos\OpenImmo;
use Innobrain\OpenImmo\Dtos\PropertyCategory;
use Innobrain\OpenImmo\Dtos\PropertyType;
use Innobrain\OpenImmo\Dtos\Provider;
use Innobrain\OpenImmo\Dtos\RealEstate;
use Innobrain\OpenImmo\Dtos\SportDistances;
use Innobrain\OpenImmo\Dtos\Transfer;
use Innobrain\OpenImmo\Dtos\TypeOfUse;
use Innobrain\OpenImmo\Dtos\View;
use Innobrain\OpenImmo\Facades\OpenImmoService;

use function PHPUnit\Framework\assertXmlStringEqualsXmlString;

test('wrote real estate xml', function () {
    $xml = File::get(base_path('../tests/fixtures/RealEstate.xml'));

    $object = new RealEstate;
    $object->setContactPerson((new ContactPerson)->setSalutation('Herr'));

    $generatedXml = OpenImmoService::serializeObjectIntoXml($object);

    // as soon as https://github.com/schmittjoh/serializer/pull/883 is merged, the <name/> can be removed
    assertXmlStringEqualsXmlString($xml, $generatedXml);
});

test('write transfer xml', function () {
    $xml = File::get(base_path('../tests/fixtures/Transfer.xml'));

    $object = (new Transfer)
        ->setType(Transfer::TYPE_ONLINE)
        ->setScope(Transfer::SCOPE_FULL)
        ->setMode(Transfer::MODE_NEW)
        ->setVersion('1.2.7')
        ->setSenderSoftware('OIGEN')
        ->setSenderVersion('0.9')
        ->setTechnicalEmail('')
        ->setTimestamp(new DateTime('2014-06-01T10:00:00'))
        ->setRegionId('ABCD143');

    $generatedXml = OpenImmoService::serializeObjectIntoXml($object);

    assertXmlStringEqualsXmlString($xml, $generatedXml);
});

test('write transfer xml real world', function () {
    $xml = File::get(base_path('../tests/fixtures/TransferRealWorld.xml'));

    $object = (new Transfer)
        ->setType(Transfer::TYPE_OFFLINE)
        ->setScope(Transfer::SCOPE_PARTIAL)
        ->setMode(Transfer::MODE_CHANGE)
        ->setVersion('1.2.7')
        ->setSenderSoftware('OOF')
        ->setSenderVersion('$Rev: 85202 $')
        ->setTechnicalEmail('xxx@xxx.de')
        ->setTimestamp(new DateTime('2019-09-30T12:42:27.000+00:00'));

    $generatedXml = OpenImmoService::serializeObjectIntoXml($object);

    assertXmlStringEqualsXmlString($xml, $generatedXml);
});

test('write type of use xml', function () {
    $xml = File::get(base_path('../tests/fixtures/TypeOfUse.xml'));

    $object = (new TypeOfUse)
        ->setLiving(true)
        ->setCommercial(false)
        ->setFacility(false)
        ->setWaz(false);

    $generatedXml = OpenImmoService::serializeObjectIntoXml($object);

    assertXmlStringEqualsXmlString($xml, $generatedXml);
});

test('write distance to sport xml', function () {
    $xml = File::get(base_path('../tests/fixtures/DistanceToSport.xml'));

    $object = (new SportDistances(SportDistances::DISTANCE_TO_SPORT_LAKE, 15));

    $generatedXml = OpenImmoService::serializeObjectIntoXml($object);

    assertXmlStringEqualsXmlString($xml, $generatedXml);
});

test('write infrastructure xml', function () {
    $xml = File::get(base_path('../tests/fixtures/Infrastructure.xml'));

    $object = (new Infrastructure)
        ->setSupply(false)
        ->setView((new View)->setView(View::VIEW_MOUNTAINS))
        ->setSportDistances([
            new SportDistances(SportDistances::DISTANCE_TO_SPORT_LAKE, 15),
        ])
        ->setDistances([
            new Distances(Distances::DISTANCE_TO_MAIN_SCHOOL, 22.0),
        ]);

    $generatedXml = OpenImmoService::serializeObjectIntoXml($object);

    assertXmlStringEqualsXmlString($xml, $generatedXml);
});

test('write provider xml', function () {
    $xml = File::get(base_path('../tests/fixtures/Provider.xml'));

    $object = (new OpenImmo)
        ->setProvider([
            (new Provider)
                ->setCompany('MusterMannFrau Immobilien')
                ->setLicenseIdentifier('ABCD13'),
        ]);

    // as soon as https://github.com/schmittjoh/serializer/pull/883 is merged, the <openimmo_anid/> can be removed
    $generatedXml = OpenImmoService::serializeObjectIntoXml($object);

    assertXmlStringEqualsXmlString($xml, $generatedXml);
});

test('write object category xml', function () {
    $xml = File::get(base_path('../tests/fixtures/PropertyCategory.xml'));

    $object = (new PropertyCategory)
        ->setTypeOfUse((new TypeOfUse)->setLiving(true)->setCommercial(false))
        ->setMarketingType((new MarketingType)->setPurchase(false)->setRentLease(true))
        ->setPropertyType(
            (new PropertyType)->setApartment([
                (new Apartment)->setApartmentType(Apartment::APARTMENT_TYPE_MAISONETTE),
            ])->setPropertyTypeAdditional(['Dachgeschoss']),
        );

    $generatedXml = OpenImmoService::serializeObjectIntoXml($object);

    assertXmlStringEqualsXmlString($xml, $generatedXml);
});

test('write complex type mixed xml', function () {
    $xml = File::get(base_path('../tests/fixtures/ComplexTypeMixed.xml'));

    $object = (new ExternalCommission(false, 'k.A.'));

    $generatedXml = OpenImmoService::serializeObjectIntoXml($object);

    assertXmlStringEqualsXmlString($xml, $generatedXml);
});

test('write complex type xml', function () {
    $xml = File::get(base_path('../tests/fixtures/ComplexType.xml'));

    $object = (new Evaluation)
        ->setField([
            new Field('abc', '100', ['int'], ['kauf']),
        ]);

    $generatedXml = OpenImmoService::serializeObjectIntoXml($object);

    assertXmlStringEqualsXmlString($xml, $generatedXml);
});
