<?php
namespace App\Controller;
use App\Entity\Event;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
            ->findAll()
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
    public function addAction(Request $request){
        $event = new Event();
        $form = $this->createFormBuilder($event)
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('nbPlace', IntegerType::class)
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('app_event_index');
        }

        return $this->render(
            'event/add.html.twig',
            ['myform' => $form->createView()]
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