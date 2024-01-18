<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {	//print_r($_POST);
	$access_denied = false;
	if ($this->isGranted('ROLE_ADMIN')) {
	    return $this->redirectToRoute('app_article_index');
	} else if ($this->isGranted('ROLE_USER')) {
	    $access_denied = 'Недействительные аутентификационные данные.';
	}
	// получить ошибку входа, если она есть
        $error = $authenticationUtils->getLastAuthenticationError();

        // последнее имя пользователя, введенное пользователем
        $lastUsername = $authenticationUtils->getLastUsername();
	return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
	    'error' => $error,
	    'access_denied' => $access_denied
        ]);
    }
    
    #[Route('/logout', name: 'app_logout')]
    public function logout(): Response
    {
        
    }
}
