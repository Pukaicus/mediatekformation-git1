<?php
namespace App\Controller;

use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Contrôleur de la page d'accueil et des pages informatives
 */
class AccueilController extends AbstractController {

    /**
     * Chemin vers le dossier des templates pages
     */
    private const PATH_TEMPLATE = "pages/";

    /**
     * @var FormationRepository
     */
    private $repository;

    /**
     * Constructeur
     * @param FormationRepository $repository
     */
    public function __construct(FormationRepository $repository) {
        $this->repository = $repository;
    }

    #[Route('/', name: 'accueil')]
    public function index(): Response {
        $formations = $this->repository->findAllLasted(2);
        return $this->render(self::PATH_TEMPLATE . "accueil.html.twig", [
            'formations' => $formations
        ]);
    }

    #[Route('/cgu', name: 'cgu')]
    public function cgu(): Response {
        return $this->render(self::PATH_TEMPLATE . "cgu.html.twig");
    }
}