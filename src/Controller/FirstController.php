<?php

namespace App\Controller;

use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;


class FirstController extends AbstractController
{
    /*
     //pour spécifier l'ordre de route
    #[Route('/order/{maVar}', name: 'app_test.order.route')]
    public  function testOrderRoute($maVar){
        return new Response("
        <html><body>$maVar</body></html>");
    }
     */

    //le name c'est l'identifient de la route en doit pas avoir des meme nom du route
    #[Route('/first', name: 'app_first')]
    public function index(): Response
    {
        //die('je suis la requete /first');
        //chercher au niveau de données vos users
        return $this->render('first/index.html.twig', [
            'name' => 'ERRAHMOUNI',
            'firstname' => 'ZAINEB'
        ]);
    }
    //{name} pour lancer une variable
    #[Route('/sayHello/{name}/{firstname}', name: 'app_say.hello')]
    public function sayHello(SymfonyRequest $request ,$name, $firstname): Response
    {
        //dd($request);
        return $this->render('first/hello.html.twig',[
            'nom'=> $name,
            'prenom'=>$firstname
        ]);
    }
    //la route de symfony requirement nous mermetre de ajouter des contraintes
    #[Route(
        //<\d+> pour spésifir la valeur d'entier apartire de 1 >
        'multi/{entier1<\d+>}/{entier2<\d+>}',
    name: 'app_multiplication',
    //requirements: ['entier1'=>'\d+', 'entier2'=>'\d+']
        )]
    public function  multiplication($entier1, $entier2){

        $resultat = $entier1 * $entier2;
        return new Response("<h1>$resultat</h1>");

    }
}
