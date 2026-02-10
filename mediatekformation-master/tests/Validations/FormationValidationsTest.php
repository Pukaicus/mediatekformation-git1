<?php
namespace App\tests\Validations;

use App\Entity\Formation;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use DateTime;

class FormationValidationsTest extends KernelTestCase
{
    public function getFormation(): Formation {
        return (new Formation())
            ->setTitle("Formation Test")
            ->setPublishedAt(new DateTime());
    }

    public function testDateFormation() {
        self::bootKernel();
        $validator = self::getContainer()->get('validator');
        
        $demain = (new DateTime())->modify('+1 day');
        $formation = $this->getFormation()->setPublishedAt($demain);
        $errors = $validator->validate($formation);
        $this->assertCount(1, $errors, "Une date future devrait générer une erreur");
    }
}