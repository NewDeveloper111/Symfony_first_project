<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Contracts\EventDispatcher\Event;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException as Unique;
use Symfony\Component\HttpFoundation\Session\Session;

#[AsController]
class ErrorController extends AbstractController
{
    public function show(Request $request, Session $session): Response {
	$exception = $request->attributes->get('exception');
	$patch = $request->getPathInfo();
	if ($exception instanceof Unique) {
	    $event = new Event();
	    $event->stopPropagation();
	    $data = $request->request->all('user') ?? [];
	    $session->set('usersdata', $data);
	    $login = $request->request->all('user')['login'] ?? null;
	    if ($login !== null) {
		$this->addFlash('unique_login', 'логин ' . $login . ' задействован');
	    }
	    return $this->redirect($patch);
	}
	return new Response('Неизвестная ошибка');//'Error'
    }
}