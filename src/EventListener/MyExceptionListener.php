<?php
namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException as Unique;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsEventListener(event: ExceptionEvent::class, method: 'onExceptionEvent')]
final class MyExceptionListener
{
    public function onExceptionEvent(ExceptionEvent $event): void
    {
//        $exception = $event->getThrowable();	
//	if ($exception instanceof Unique) {
//	    //$response->setContent($exception->getSQLState() . ': Имя занято');
//	    //dd($exception->getSQLState());
//	    $event->stopPropagation();
//	    //$event->getRequest()->create('/user/48/edit');
//	}
//	$event->stopPropagation();
	$exception = $event->getThrowable();
//	$message = sprintf(
//		'My Error says: %s with code: %s',
//		$exception->getMessage(),
//		$exception->getCode()
//	);
	$response = new Response();
	//$response->setContent($message);
	if ($exception instanceof Unique) {
	    //$response->setContent($exception->getMessage());
	    $entity = $exception->getQuery()->getSQL();
	    preg_match('/[a-z]+/',$entity, $matches);
	    $response->setContent($matches[0]);
            //dd($exception->getSQLState());
	    $event->setResponse($response);
	    //$event->getRequest()->create('/user/48/edit');
	}
    }
}