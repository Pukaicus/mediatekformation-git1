<?php
namespace App\tests\Entity;

use App\Entity\Formation;
use PHPUnit\Framework\TestCase;

class FormationTest extends TestCase
{
    public function testGetPublishedAtString()
    {
        $formation = new Formation();
        $date = new \DateTime("2023-01-10");
        $formation->setPublishedAt($date);

        $this->assertEquals("10/01/2023", $formation->getPublishedAtString());
    }
}