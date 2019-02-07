<?php
namespace App\Controller;
use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    /**
     * @Route("event/index")
     */
    public function indexAction()
    {
        $events = $this->getDoctrine()
            ->getRepository(Event::class)
            ->findBy(['name' => "Event 2"])
        ;

        return $this->render(
            'event/index.html.twig',
            [
                'events' => $events
            ]
        );
    }

    /**
     * @Route("event/add")
     */
    public function addAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $event = new Event();
        $event->setName("Event 2");
        $event->setDescription("Event culturel");
        $event->setNbPlace(10);
        $entityManager->persist($event);
        $entityManager->flush();

        return new Response(
            'Saved new event with ID:' . $event->getId()
        );
    }

    /**
     * @Route("event/{id}")
     */
    public function detailAction(Event $event){
        return $this->render(
            'event/detail.html.twig',
            ['event' => $event]
        );
    }
}