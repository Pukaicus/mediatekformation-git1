<?php
namespace App\Controller\Admin;

use App\Entity\Playlist;
use App\Form\PlaylistType;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Contrôleur gérant les playlists côté administration
 */
class AdminPlaylistsController extends AbstractController
{
    private $playlistRepository;

    public function __construct(PlaylistRepository $playlistRepository)
    {
        $this->playlistRepository = $playlistRepository;
    }

    #[Route('/admin/playlists', name: 'admin.playlists')]
    public function index(): Response
    {
        $playlists = $this->playlistRepository->findAllOrderByName('ASC');
        return $this->render("admin/admin.playlists.html.twig", [
            'playlists' => $playlists
        ]);
    }

    /**
     * Méthode de tri pour corriger l'erreur RouteNotFoundException
     */
    #[Route('/admin/playlists/tri/{champ}/{ordre}', name: 'admin.playlists.sort')]
    public function sort($champ, $ordre): Response
    {
        switch($champ){
            case "name":
                $playlists = $this->playlistRepository->findAllOrderByName($ordre);
                break;
            case "nbformations":
                $playlists = $this->playlistRepository->findAllOrderByNbFormations($ordre);
                break;
            default:
                $playlists = $this->playlistRepository->findAllOrderByName('ASC');
                break;
        }
        return $this->render("admin/admin.playlists.html.twig", [
            'playlists' => $playlists
        ]);
    }

    /**
     * Supprime une playlist via son ID
     * @param int $id
     * @return Response
     */
    #[Route('/admin/playlist/suppr/{id}', name: 'admin.playlist.suppr')]
    public function suppr(Playlist $playlist): Response
    {
        // Vérification : la Tâche 2 interdit la suppression si des formations sont rattachées
        if (count($playlist->getFormations()) > 0) {
            $this->addFlash('danger', 'Suppression impossible : des formations sont rattachées à cette playlist.');
        } else {
            $this->playlistRepository->remove($playlist);
            $this->addFlash('success', 'Playlist supprimée avec succès.');
        }
        return $this->redirectToRoute('admin.playlists');
    }

    #[Route('/admin/playlist/ajout', name: 'admin.playlist.ajout')]
    #[Route('/admin/playlist/edit/{id}', name: 'admin.playlist.edit')]
    public function edit(Playlist $playlist = null, Request $request): Response
    {
        if (!$playlist) {
            $playlist = new Playlist();
        }

        $formPlaylist = $this->createForm(PlaylistType::class, $playlist);
        $formPlaylist->handleRequest($request);

        if ($formPlaylist->isSubmitted() && $formPlaylist->isValid()) {
            $this->playlistRepository->add($playlist);
            return $this->redirectToRoute('admin.playlists');
        }

        return $this->render("admin/admin.playlist.ajout.html.twig", [
            'playlist' => $playlist,
            'form' => $formPlaylist->createView()
        ]);
    }
}