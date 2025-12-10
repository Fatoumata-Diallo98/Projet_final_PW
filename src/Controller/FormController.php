<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;

class FormController extends AbstractController
{
    #[Route('/hellotheworld/{prenom}')]
    public function hello(Environment $twig, $prenom='sophie'): Response{
       $html=$twig->render('hello.html.twig', ['prenom' => $prenom]);
        return new Response($html);

    }
    #[Route('/tuteurs')]
    public function list() : Response{
        $tuteurs = ['tuteurs'=>[ ['nom'=>'Johnson', 'prenom'=>'Paul'], ['nom'=>'Walberg', 'prenom'=>'Mark'] ]];
        return $this->render('tuteurs.html.twig', $tuteurs);
    }
    #[Route('/search_tuteur')]
    public function verify(Request $request) : Response{
        $result = null;
        $tuteurs = [['nom' => 'Johnson', 'prenom' => 'Paul'],['nom'=>'Walberg', 'prenom'=>'Mark']];
        if($request->isMethod('POST')){
            $name = $request->request->get('tuteur');
            foreach ($tuteurs as $tuteur) {
                if (str_contains(strtolower($tuteur['nom']), strtolower($name)) || str_contains(strtolower($tuteur['prenom']), strtolower($name))) {
                    $result[] = $tuteur;
                    
                }
            }
        }

        $html = $this->render('search_tuteur.html.twig', ['result'=> $result]);
        return new Reponse($html);
    }
}

?>