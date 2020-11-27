<?php

namespace Vague\Hyy\Test;

use Vague\Hyy\HydratableInterface;
use Vague\Hyy\Hyydrator;

/**
 * Class HyydratorTest
 * @package Vague\Hyy\Test
 */
class HyydratorTest extends BaseTest
{
    /**
     * @param array $data
     * @param HydratableInterface $hydratable
     * @param array $configuration
     * @param array $expected
     * @dataProvider hydrateDataProvider
     */
    public function testHydrate(array $data, HydratableInterface $hydratable, array $configuration, array $expected)
    {
        $testObject = new Hyydrator();

        $result = $testObject->hydrate($data, $hydratable, $configuration);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function hydrateDataProvider(): array
    {
        return [
            [
                [
                    [
                        'id' => 1,
                        'name' => 'test',
                        'relation_id' => 1,
                        'relation_name' => 'aaa',
                    ],
                    [
                        'id' => 1,
                        'name' => 'test',
                        'relation_id' => 2,
                        'relation_name' => 'bbb',
                    ],
                ],
                new Data(),
                [
                    'relation' => Relation::class,
                ],
                [
                    'ba88c155ba898fc8b5099893036ef205' => (new Data())->setId(1)->setName('test')
                        ->setRelations([
                            'da8c84d77240a67982260c526ca537ff' => (new Relation())->setId(1)->setName('aaa'),
                            'eb086fd29624e3ba84441d7fe86b7980' => (new Relation())->setId(2)->setName('bbb'),
                        ]),
                ],
            ],
            [
                [
                    [
                        'id' => 1,
                        'name' => 'test',
                        'relation_id' => 1,
                        'relation_name' => 'aaa',
                        'test_id' => 2,
                        'test_name' => 'ccc'
                    ],
                    [
                        'id' => 1,
                        'name' => 'test',
                        'relation_id' => 2,
                        'relation_name' => 'bbb',
                    ],
                ],
                new Data(),
                [
                    'relation' => Relation::class,
                    'test' => Relation::class,
                ],
                [
                    'ba88c155ba898fc8b5099893036ef205' => (new Data())->setId(1)->setName('test')
                        ->setRelations([
                            'da8c84d77240a67982260c526ca537ff' => (new Relation())->setId(1)->setName('aaa'),
                            'eb086fd29624e3ba84441d7fe86b7980' => (new Relation())->setId(2)->setName('bbb'),
                        ])
                        ->setTests([
                            'f18837e7d4c8f146ff9e5e79ed59402d' => (new Relation())->setId(2)->setName('ccc'),
                        ]),
                ],
            ],
            [
                [
                    [
                        'id' => 1,
                        'name' => 'test',
                        'relation_id' => 1,
                        'relation_name' => 'aaa',
                        'test_id' => 2,
                        'test_name' => 'ccc'
                    ],
                    [
                        'id' => 1,
                        'name' => 'test',
                        'relation_id' => 2,
                        'relation_name' => 'bbb',
                    ],
                    [
                        'id' => 2,
                        'name' => 'qwerty',
                        'relation_id' => 1,
                        'relation_name' => 'aaa',
                        'test_id' => 2,
                        'test_name' => 'ccc'
                    ],
                    [
                        'id' => 2,
                        'name' => 'qwerty',
                        'relation_id' => 1,
                        'relation_name' => 'aaa',
                        'test_id' => 3,
                        'test_name' => 'ddd'
                    ],
                ],
                new Data(),
                [
                    'relation' => Relation::class,
                    'test' => Relation::class,
                ],
                [
                    'ba88c155ba898fc8b5099893036ef205' => (new Data())->setId(1)->setName('test')
                        ->setRelations([
                            'da8c84d77240a67982260c526ca537ff' => (new Relation())->setId(1)->setName('aaa'),
                            'eb086fd29624e3ba84441d7fe86b7980' => (new Relation())->setId(2)->setName('bbb'),
                        ])
                        ->setTests([
                            'f18837e7d4c8f146ff9e5e79ed59402d' => (new Relation())->setId(2)->setName('ccc'),
                        ]),
                    '11861fca003eac39d43d9671e4cf0905' => (new Data())->setId(2)->setName('qwerty')
                        ->setRelations([
                            'da8c84d77240a67982260c526ca537ff' => (new Relation())->setId(1)->setName('aaa'),
                        ])
                        ->setTests([
                            'f18837e7d4c8f146ff9e5e79ed59402d' => (new Relation())->setId(2)->setName('ccc'),
                            '79b6701e0246cbb9b1fa3aae9b9de670' => (new Relation())->setId(3)->setName('ddd'),
                        ]),
                ],
            ],
            [
                [
                    [
                        'id' => 1,
                        'name' => 'test',
                        'relation_id' => null,
                        'relation_name' => null,
                    ],
                ],
                new Data(),
                [
                    'relation' => Relation::class,
                ],
                [
                    'ba88c155ba898fc8b5099893036ef205' => (new Data())->setId(1)->setName('test'),
                ],
            ],
            [
                [
                    [
                        'id' => 1,
                        'name' => 'test',
                        'extra_data' => 'something',
                        'relation_id' => 1,
                        'relation_name' => 'aaa',
                    ],
                    [
                        'id' => 1,
                        'name' => 'test',
                        'extra_data' => 'something',
                        'relation_id' => 2,
                        'relation_name' => 'bbb',
                    ],
                ],
                new ExtraData(),
                [
                    'relation' => Relation::class,
                ],
                [
                    'a9d879233bb48af51548f6584cee918b' => (new ExtraData())->setExtraData('something')
                        ->setId(1)
                        ->setName('test')
                        ->setRelations([
                            'da8c84d77240a67982260c526ca537ff' => (new Relation())->setId(1)->setName('aaa'),
                            'eb086fd29624e3ba84441d7fe86b7980' => (new Relation())->setId(2)->setName('bbb'),
                        ]),
                ],
            ],
            [
                [
                    [
                        'id' => 12,
                        'relation_id' => 13,
                        'relation_name' => 'axa',
                    ],
                ],
                new SingleRelation(),
                [
                    'relation' => [
                        'type' => 1,
                        'class' => Relation::class,
                    ],
                ],
                [
                    'c20ad4d76fe97759aa27a0c99bff6710' => (new SingleRelation())->setId(12)
                        ->setRelation((new Relation())->setId(13)->setName('axa'))
                ]
            ],
            [
                [
                    [
                        'id' => 11,
                        'relation_id' => 14,
                        'relation_name' => 'axa',
                        'extra_id' => 8,
                        'extra_name' => 'asd',
                        'extra_extra_data' => ';df',
                    ],
                ],
                new SingleRelation(),
                [
                    'relation' => [
                        'type' => 1,
                        'class' => Relation::class,
                    ],
                    'extra' => ExtraData::class,
                ],
                [
                    '6512bd43d9caa6e02c990b0a82652dca' => (new SingleRelation())->setId(11)
                        ->setRelation((new Relation())->setId(14)->setName('axa'))
                        ->setExtras([
                            '5f1974e02161a805332685ebd811d13e' => (new ExtraData())->setExtraData(';df')->setId(8)->setName('asd'),
                        ])
                ]
            ],
        ];
    }
}

class Data implements HydratableInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array|Relation[]
     */
    private $relations = [];

    /**
     * @var array|Relation[]
     */
    private $tests = [];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Data
     */
    public function setId(int $id): Data
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Data
     */
    public function setName(string $name): Data
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return array|Relation[]
     */
    public function getRelations()
    {
        return $this->relations;
    }

    /**
     * @param array|Relation[] $relations
     * @return Data
     */
    public function setRelations($relations)
    {
        $this->relations = $relations;
        return $this;
    }

    /**
     * @return array|Relation[]
     */
    public function getTests()
    {
        return $this->tests;
    }

    /**
     * @param array|Relation[] $tests
     * @return Data
     */
    public function setTests($tests)
    {
        $this->tests = $tests;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [];
    }

    /**
     * @param array $rawData
     * @return HydratableInterface
     */
    public function fromArray(array $rawData): HydratableInterface
    {
        $this->id = $rawData['id'];
        $this->name = $rawData['name'];

        return $this;
    }
}

class Relation implements HydratableInterface
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Relation
     */
    public function setId(int $id): Relation
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Relation
     */
    public function setName(string $name): Relation
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [];
    }

    /**
     * @param array $rawData
     * @return HydratableInterface
     */
    public function fromArray(array $rawData): HydratableInterface
    {
        $this->id = $rawData['id'];
        $this->name = $rawData['name'];

        return $this;
    }
}

class SingleRelation implements HydratableInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Relation
     */
    private $relation;

    /**
     * @var array
     */
    private $extra = [];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return SingleRelation
     */
    public function setId(int $id): SingleRelation
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Relation
     */
    public function getRelation(): Relation
    {
        return $this->relation;
    }

    /**
     * @param Relation $relation
     * @return SingleRelation
     */
    public function setRelation(Relation $relation): SingleRelation
    {
        $this->relation = $relation;
        return $this;
    }

    /**
     * @return array
     */
    public function getExtras(): array
    {
        return $this->extra;
    }

    /**
     * @param array $extra
     * @return SingleRelation
     */
    public function setExtras(array $extra): SingleRelation
    {
        $this->extra = $extra;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [];
    }

    /**
     * @param array $rawData
     * @return HydratableInterface
     */
    public function fromArray(array $rawData): HydratableInterface
    {
        $this->id = $rawData['id'];

        return $this;
    }
}

class ExtraData extends Data
{
    /**
     * @var string
     */
    private $extraData;

    /**
     * @return string
     */
    public function getExtraData(): string
    {
        return $this->extraData;
    }

    /**
     * @param string $extraData
     * @return ExtraData
     */
    public function setExtraData(string $extraData): ExtraData
    {
        $this->extraData = $extraData;
        return $this;
    }

    /**
     * @param array $rawData
     * @return HydratableInterface
     */
    public function fromArray(array $rawData): HydratableInterface
    {
        parent::fromArray($rawData);
        $this->extraData = $rawData['extra_data'];

        return $this;
    }
}
