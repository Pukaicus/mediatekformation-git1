<?php
namespace App\Controller\Admin;

use App\Entity\Formation; // LIGNE INDISPENSABLE MANQUANTE
use App\Form\FormationType; // LIGNE INDISPENSABLE MANQUANTE
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Contrôleur pour la gestion des formations en mode admin
 */
class AdminFormationsController extends AbstractController {

    private const BASE_PATH = "admin/";
    private const TEMPLATE_FORMATIONS = "admin.formations.html.twig";

    private $formationRepository;
    private $categorieRepository;

    public function __construct(FormationRepository $formationRepository, CategorieRepository $categorieRepository) {
        $this->formationRepository = $formationRepository;
        $this->categorieRepository = $categorieRepository;
    }

    #[Route('/admin/formations', name: 'admin.formations')]
    public function index(): Response {
        $formations = $this->formationRepository->findAll();
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::BASE_PATH . self::TEMPLATE_FORMATIONS, [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }

    #[Route('/admin/formations/suppr/{id}', name: 'admin.formation.suppr')]
    public function suppr(int $id): Response {
        $formation = $this->formationRepository->find($id);
        $this->formationRepository->remove($formation);
        return $this->redirectToRoute('admin.formations');
    }

    #[Route('/admin/formations/tri/{champ}/{ordre}/{table}', name: 'admin.formations.sort')]
    public function sort($champ, $ordre, $table=""): Response {
        $formations = $this->formationRepository->findAllOrderBy($champ, $ordre, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::BASE_PATH . self::TEMPLATE_FORMATIONS, [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }
    #[Route('/admin/formation/ajout', name: 'admin.formation.ajout')]
    public function ajout(Request $request): Response {
        $formation = new Formation();
        $formFormation = $this->createForm(FormationType::class, $formation);

        $formFormation->handleRequest($request);
        if($formFormation->isSubmitted() && $formFormation->isValid()){
            $this->formationRepository->add($formation);
            return $this->redirectToRoute('admin.formations');
        }

        return $this->render("admin/admin.formation.ajout.html.twig", [
            'formation' => $formation,
            'form' => $formFormation->createView()
        ]);
    }

    #[Route('/admin/formation/edit/{id}', name: 'admin.formation.edit')]
    public function edit(Formation $formation, Request $request): Response {
        $formFormation = $this->createForm(FormationType::class, $formation);

        $formFormation->handleRequest($request);
        if($formFormation->isSubmitted() && $formFormation->isValid()){
            $this->formationRepository->add($formation);
            return $this->redirectToRoute('admin.formations');
        }

        return $this->render("admin/admin.formation.ajout.html.twig", [
            'formation' => $formation,
            'form' => $formFormation->createView()
        ]);
    }
}