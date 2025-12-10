<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/index2')]
    public function index(): Response
    {
        return new Response(
            '<html><body> Votre première page</body></html>'
        );
    }

    #[Route('/bonjour/{nom}', defaults: ['nom' => 'Inconnu'], requirements: ['nom' => '[A-Za-z]+'])]
    public function indexbis($nom): Response
    {
       // $request= Request::createFromGlobals();
       //$nom=$request->query->get("nom", "Inconnu");
        return new Response(
            "<html><body> Bonjour ".$nom."</body></html>"
        );
    }
    //#[Route('/calcul/{chiffre}', name:'indexter', defaults: ['chiffre' => '0'], requirements: ['chiffre' => '^(?:[0-9]|[1-9][0-9])$'])]
    public function indexter($chiffre): Response
    {
        return new Response(
            "<html><body> 17".$chiffre."</body></html>"
        );
    }
}

?>