<?php
namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Contrôleur gérant les catégories côté administration
 */
class AdminCategoriesController extends AbstractController
{
    private $categorieRepository;

    public function __construct(CategorieRepository $categorieRepository)
    {
        $this->categorieRepository = $categorieRepository;
    }

    /**
     * Affiche la liste des catégories et gère l'ajout d'une nouvelle catégorie
     * @return Response
     */
    #[Route('/admin/categories', name: 'admin.categories')]
    public function index(Request $request): Response
    {
        $categories = $this->categorieRepository->findAll();
        
        // Gestion de l'ajout direct
        $nomCategorie = $request->get("nom");
        if($nomCategorie !== null && trim($nomCategorie) !== ""){
            // Vérification de l'unicité
            if(!$this->categorieRepository->findOneBy(['name' => $nomCategorie])){
                $categorie = new Categorie();
                $categorie->setName($nomCategorie);
                $this->categorieRepository->add($categorie);
                return $this->redirectToRoute('admin.categories');
            } else {
                $this->addFlash('danger', 'Cette catégorie existe déjà.');
            }
        }

        return $this->render("admin/admin.categories.html.twig", [
            'categories' => $categories
        ]);
    }

    /**
     * Supprime une catégorie via son ID
     * @param int $id
     * @return Response
     */
    #[Route('/admin/categorie/suppr/{id}', name: 'admin.categorie.suppr')]
    public function suppr(Categorie $categorie): Response
    {
        if (count($categorie->getFormations()) > 0) {
            $this->addFlash('danger', 'Suppression impossible : la catégorie est rattachée à des formations.');
        } else {
            $this->categorieRepository->remove($categorie);
            $this->addFlash('success', 'Catégorie supprimée avec succès.');
        }
        return $this->redirectToRoute('admin.categories');
    }
}