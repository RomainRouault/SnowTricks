<?php

namespace App\Domain\DataFixtures;

use Orbitale\Component\DoctrineTools\AbstractFixture;

class FixturesTest extends AbstractFixture
{

    public function getEntityClass(): String {
        return 'App\Domain\Entity\Trick';
    }

    public function getObjects() {
        return [
            ['id' => 1, 'title' => 'First post', 'description' => 'Lorem ipsum'],
            ['id' => 2, 'title' => 'Second post', 'description' => 'muspi meroL'],
        ];
    }

}