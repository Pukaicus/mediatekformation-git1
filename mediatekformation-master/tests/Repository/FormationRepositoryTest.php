<?php
namespace App\tests\Repository;

use App\Entity\Formation;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FormationRepositoryTest extends KernelTestCase
{
    /**
     * Récupère le repository de Formation
     */
    private function getRepository(): FormationRepository
    {
        self::bootKernel();
        return self::getContainer()->get(FormationRepository::class);
    }

    /**
     * Teste le nombre de formations en base
     */
    public function testNbFormations()
    {
        $repository = $this->getRepository();
        $nbFormations = $repository->count([]);
        $this->assertGreaterThanOrEqual(0, $nbFormations); 
    }

    /**
     * Teste la recherche par titre
     */
    public function testFindByContainValue()
    {
        $repository = $this->getRepository();
        $formation = (new Formation())
            ->setTitle("Formation Test")
            ->setPublishedAt(new \DateTime());
        
        $entityManager = self::getContainer()->get('doctrine')->getManager();
        $entityManager->persist($formation);
        $entityManager->flush();

        $formations = $repository->findByContainValue('title', 'Test');
        $nbRetours = count($formations);
        $this->assertGreaterThanOrEqual(1, $nbRetours);
        $this->assertEquals("Formation Test", $formations[0]->getTitle());
    }
}