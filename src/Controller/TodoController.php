<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//c'est le prefixe de tout les routes de ce controller /todo
//le chemain /todo est un chemain commun de tout les routes
//#[Route('/todo')]
class TodoController extends AbstractController
{

    #[Route('/', name: 'app_todo')]
    public function index(Request $request): Response
    {
        //extrait la session à partir de l'objet "Request".Les sessions sont généralement utilisées pour stocker des données temporaires d'une requête à l'autre dans une application web. Dans ce cas, la session est stockée dans la variable "$session".
        //chercher la session
        $session = $request->getSession();
        // afficher notre tableau de todo
        // sinon je l'initialise puis l'afficher
        if (!$session->has('todos')) {
            $todos = [
                'achat' => 'acheter clé usb',
                'cours' => 'finaliser mon cours',
                'correction' => 'corriger mes examens',
            ];
            $session->set('todos', $todos);
            //flashBag
            $this->addFlash('info', "la liste des todos viens d'etre initialiser ");
        }

        // si je mon tableau de todo dans ma session je ne fait que l'afficher
        return $this->render('todo/index.html.twig');
    }
    //en ajoute la valeur par defaut sf6 a content ?test c'est une valeur par defaut
    #[Route('/add/{name?test}/{content?test}', name: 'app_todo.add',
    //defaults: ['name'=>'tech','content'=>'sf6']
        )]
    public function addTodo(Request $request, $name, $content): RedirectResponse
    {
        //cherche ma session
        $session = $request->getSession();
        //vérifier si j'ai mon tableau todo sur la session
        if ($session->has('todos')) {
            //si oui
            // vérifier si on a déja un todo avec le meme name
            $todos = $session->get('todos');
            if (isset($todos[$name])) {
                // si oui afficher une erreur
                $this->addFlash('error', "le todo $name existe deja dans la liste");
            } else {
                //si non on l'ajouter et on affiche un message de succés
                $todos[$name] = $content;
                $session->set('todos', $todos);
                $this->addFlash('success', 'le todo et ajouter avec succès');

            }

        } else {
            //si non
            //afficher une erreur et en va rediriger vers le controlleur index
            $this->addFlash('error', "la liste des todos n'est pas encore initialiser ");
        }
        return $this->redirectToRoute("app_todo");
    }
    #[Route('/update/{name}/{content}', name: 'app_todo.update')]
    public function updateTodo(Request $request, $name, $content): RedirectResponse
    {
        //cherche ma session
        $session = $request->getSession();
        //vérifier si j'ai mon tableau todo sur la session
        if ($session->has('todos')) {
            //si oui
            // vérifier si on a déja un todo avec le meme name
            $todos = $session->get('todos');
            if (!isset($todos[$name])) {
                // si oui afficher une erreur
                $this->addFlash('error', "le todo $name n'existe pas dans la liste");
            } else {
                //si non on le modifié et on affiche un message de succés
                $todos[$name] = $content;
                $session->set('todos', $todos);
                $this->addFlash('success', 'le todo et modifié avec succès');

            }

        } else {
            //si non
            //afficher une erreur et en va rediriger vers le controlleur index
            $this->addFlash('error', "la liste des todos n'est pas encore initialiser ");
        }
        return $this->redirectToRoute("app_todo");
    }
    #[Route('/delete/{name}', name: 'app_todo.delete')]
    public function deleteTodo(Request $request, $name): RedirectResponse
    {
        //cherche ma session
        $session = $request->getSession();
        //vérifier si j'ai mon tableau todo sur la session
        if ($session->has('todos')) {
            //si oui
            // vérifier si on a déja un todo avec le meme name
            $todos = $session->get('todos');
            if (!isset($todos[$name])) {
                // si oui afficher une erreur
                $this->addFlash('error', "le todo $name n'existe pas dans la liste");
            } else {
                //si non on supprimer et on affiche un message de succés
                unset($todos[$name]);
                $session->set('todos', $todos);
                $this->addFlash('success', 'le todo et supprimer avec succès');

            }

        } else {
            //si non
            //afficher une erreur et en va rediriger vers le controlleur index
            $this->addFlash('error', "la liste des todos n'est pas encore initialiser ");
        }
        return $this->redirectToRoute("app_todo");
    }
    //reset pour revenire a la liste initiale
    #[Route('/reset', name: 'app_todo.reset')]
    public function resetTodo(Request $request): RedirectResponse
    {
        //cherche ma session
        $session = $request->getSession();
        $session->remove('todos');
        return $this->redirectToRoute("app_todo");
    }

}


