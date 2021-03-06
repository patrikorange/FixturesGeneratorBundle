<?php

namespace MGDSoft\FixturesGeneratorBundle\Generator;

use MGDSoft\FixturesGeneratorBundle\Extractor\Bean\PropertyDetails;
use MGDSoft\FixturesGeneratorBundle\Guesser\Data;

class FixtureTest extends AbstractFixtureGenerator
{
    const prefixNewFixture = 'LoadTest';
    const suffixNewFixture = 'Fixture';

    /**
     * @param $properties
     * @param \ReflectionClass $entityReflection
     * @return mixed
     */
    public function getClassStringFixture(
        $properties,
        \ReflectionClass $entityReflection,
        $className,
        $nameSpaceFixture,
        $nameSpaceBaseForDependecies,
        $fixtureClassNameExtended = null
    ) {
        $this->properties       = $properties;
        $this->entityReflection = $entityReflection;
        $this->className = $className;
        $this->nameSpaceBaseForDependecies = $nameSpaceBaseForDependecies;
        $this->nameSpaceFixture = $nameSpaceFixture;
        $this->abstractClass = $fixtureClassNameExtended ?? $this->abstractClass;

        return $this->getClassStringFixtureCommon();
    }

}