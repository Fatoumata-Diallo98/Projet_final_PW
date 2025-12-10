<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;

class TuteurController extends AbstractController{
    private $tuteurs = [ 
        [ 
        'id' => 1, 
        'nom' => 'Johnson', 'prenom' => 'Paul', 
        'entreprise' => 'Acme', 
        'email' => 'paul.johnson@acme.com', 
        'telephone' => '06 00 00 00 01', 
        'etudiants' => [ 
        ['nom' => 'Martin', 'prenom' => 'Léa', 'sujet' => 'Détection d’anomalies sur flux 
        bancaires'], 
        ['nom' => 'Durand', 'prenom' => 'Noah', 'sujet' => 'Dashboard risques crédit'] 
        ] 
        ], 
        [ 
        'id' => 2, 
        'nom' => 'Walberg', 'prenom' => 'Mark', 
        'entreprise' => 'Globex', 
        'email' => 'mark.walberg@globex.com', 
        'telephone' => '06 00 00 00 02', 
        'etudiants' => [] 
        ] 
    ];
    #[Route('/tuteur', name: 'tuteur_index')]
    public function index(Request $request): Response
    {
        $tuteurs = $this->tuteurs;
        $sort = $request->query->get('sort', null);
        $dir = $request->query->get('dir', 'asc');

        if ($sort === 'nom') {
            usort($tuteurs, function($a, $b) use ($dir) {
                return $dir === 'asc' ? strcmp($a['nom'], $b['nom']) : strcmp($b['nom'], $a['nom']);
            });
        }

        return $this->render('tuteur/index.html.twig', [
            'tuteurs' => $tuteurs,
            'currentSort' => $sort,
            'currentDir' => $dir,
            'queryParams' => $request->query->all(),
        ]);
    }

    #[Route('/tuteur/{id}', name: 'tuteur_index2')]
    public function show(int $id): Response
    {
        $tuteur = null;
        foreach ($this->tuteurs as $t) {
            if ($t['id'] === $id) {
                $tuteur = $t;
                break;
            }
        }

        if (!$tuteur) {
            throw $this->createNotFoundException('Tuteur non trouvé');
        }

        return $this->render('tuteur/index2.html.twig', [
            'tuteur' => $tuteur,
        ]);
    }

}

?>