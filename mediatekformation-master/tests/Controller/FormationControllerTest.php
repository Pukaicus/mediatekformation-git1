<?php
namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class FormationControllerTest extends WebTestCase
{

    public function testPageAccess()
    {
        $client = static::createClient();
        $client->request('GET', '/formations');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

public function testFiltreFormation()
    {
        $client = static::createClient();
        
        $container = static::getContainer();
        $em = $container->get('doctrine')->getManager();
        $formation = (new \App\Entity\Formation())
            ->setTitle("Cours Java")
            ->setPublishedAt(new \DateTime());
        $em->persist($formation);
        $em->flush();

        $crawler = $client->request('GET', '/formations');
        $form = $crawler->selectButton('filtrer')->form([
            'recherche' => 'Java'
        ]);
        $crawler = $client->submit($form);
        
        $this->assertSelectorTextContains('h5', 'Java');
    }
}