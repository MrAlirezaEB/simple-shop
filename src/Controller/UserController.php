<?php

namespace App\Controller;

use App\Service\Sms;
use App\Entity\Address;
use App\Form\AddressType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
  * Require ROLE_ADMIN for *every* controller method in this class.
  *
  * @IsGranted("ROLE_USER")
  */
#[Route('/profile' , name:'user.')]
class UserController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function index(): Response
    {
        $order_count = [
            'pending'=> $this->getUser()->getOrders()->count()
        ];
        return $this->render('user/index.html.twig', [
            'title' => 'داشبورد',
            'order_count'=>$order_count,
            'orders'=> $this->getUser()->getOrders()
        ]);
    }

    #[Route('/orders', name: 'orders')]
    public function orders(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/addresses', name: 'addresses')]
    public function addresses(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/info', name: 'info')]
    public function info(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/address/new', name: 'address.new' , methods:['POST'])]
    public function newAddress(Request $request): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        // submit new address
        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());
            $address->setPostalCode($form->get('postalcode')->getData());
            $address->setState($form->get('state')->getData());
            $address->setCity($form->get('city')->getData());
            $address->setAddress($form->get('address')->getData());
            // before submit address as default we should set other user addresses to not default
            $entityManager = $this->getDoctrine()->getManager();
            foreach ($this->getUser()->getAddresses() as $item) {
                $item->setDef(false);
                $entityManager->persist($item);
                $entityManager->flush();
            }
            $address->setDef(true);
            // now we can store new address
            $entityManager->persist($address);
            $entityManager->flush();

            return $this->redirectToRoute('order.shoppinglists');
        }
        return $this->redirectToRoute('user.addresses');
    }

    #[Route('/address/edit', name: 'address.edit' , methods:['POST'])]
    public function editAddress(Request $request , AddressRepository $addressRepository): Response
    {
        // find existing address
        if(!($address = $addressRepository->find($request->request->get('address_id'))))
        {
            return $this->redirectToRoute('user.addresses');
        }
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        // submit new address
        if ($form->isSubmitted() && $form->isValid()) {
            $address->setPostalCode($form->get('postalcode')->getData());
            $address->setState($form->get('state')->getData());
            $address->setCity($form->get('city')->getData());
            $address->setAddress($form->get('address')->getData());
            
            // before submit address as default we should set other user addresses to not default
            $entityManager = $this->getDoctrine()->getManager();
            foreach ($this->getUser()->getAddresses() as $item) {
                $item->setDef(false);
                $entityManager->persist($item);
                $entityManager->flush();
            }
            // now we can store new address
            $address->setDef(true);
            $entityManager->persist($address);
            $entityManager->flush();
            return $this->redirectToRoute('order.shoppinglists');
        }
        return $this->redirectToRoute('user.addresses');
    }

}
