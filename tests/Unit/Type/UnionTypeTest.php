<?php

declare(strict_types = 1);

namespace Graphpinator\Tests\Unit\Type;

final class UnionTypeTest extends \PHPUnit\Framework\TestCase
{
    public static function createTestUnion() : \Graphpinator\Type\UnionType
    {
        return new class extends \Graphpinator\Type\UnionType {
            protected const NAME = 'Foo';

            public function __construct()
            {
                parent::__construct(
                    new \Graphpinator\Type\TypeSet([
                        UnionTypeTest::getTestTypeXyz(),
                        UnionTypeTest::getTestTypeZzz(),
                    ]),
                );
            }

            public function createResolvedValue($rawValue) : \Graphpinator\Value\TypeIntermediateValue
            {
                return new \Graphpinator\Value\TypeIntermediateValue(UnionTypeTest::getTestTypeXyz(), 123);
            }
        };
    }

    public static function getTestTypeAbc() : \Graphpinator\Type\Type
    {
        return new class extends \Graphpinator\Type\Type {
            protected const NAME = 'Abc';

            public function validateNonNullValue($rawValue) : bool
            {
                return true;
            }

            protected function getFieldDefinition() : \Graphpinator\Field\ResolvableFieldSet
            {
                return new \Graphpinator\Field\ResolvableFieldSet();
            }
        };
    }

    public static function getTestTypeXyz() : \Graphpinator\Type\Type
    {
        return new class extends \Graphpinator\Type\Type {
            protected const NAME = 'Xyz';

            public function validateNonNullValue($rawValue) : bool
            {
                return true;
            }

            protected function getFieldDefinition() : \Graphpinator\Field\ResolvableFieldSet
            {
                return new \Graphpinator\Field\ResolvableFieldSet();
            }
        };
    }

    public static function getTestTypeZzz() : \Graphpinator\Type\Type
    {
        return new class extends \Graphpinator\Type\Type {
            protected const NAME = 'Zzz';

            public function validateNonNullValue($rawValue) : bool
            {
                return true;
            }

            protected function getFieldDefinition() : \Graphpinator\Field\ResolvableFieldSet
            {
                return new \Graphpinator\Field\ResolvableFieldSet();
            }
        };
    }

    public function testSimple() : void
    {
        $union = self::createTestUnion();

        self::assertArrayHasKey('Xyz', $union->getTypes());
        self::assertSame('Xyz', $union->getTypes()->offsetGet('Xyz')->getName());
        self::assertArrayHasKey('Zzz', $union->getTypes());
        self::assertSame('Zzz', $union->getTypes()->offsetGet('Zzz')->getName());

        self::assertTrue($union->isInstanceOf($union));
        self::assertTrue($union->isInstanceOf(new \Graphpinator\Type\NotNullType($union)));
        self::assertFalse($union->isInstanceOf(self::getTestTypeZzz()));
        self::assertFalse($union->isInstanceOf(new \Graphpinator\Type\NotNullType(self::getTestTypeZzz())));
        self::assertTrue($union->isImplementedBy(self::getTestTypeXyz()));
        self::assertTrue($union->isImplementedBy(new \Graphpinator\Type\NotNullType(self::getTestTypeXyz())));
        self::assertTrue($union->isImplementedBy(self::getTestTypeZzz()));
        self::assertTrue($union->isImplementedBy(new \Graphpinator\Type\NotNullType(self::getTestTypeZzz())));
        self::assertFalse($union->isImplementedBy(self::getTestTypeAbc()));
        self::assertFalse($union->isImplementedBy(new \Graphpinator\Type\NotNullType(self::getTestTypeAbc())));
    }
}
