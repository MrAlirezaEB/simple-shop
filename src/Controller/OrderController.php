<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Address;
use App\Form\AddressType;
use App\Entity\ShoppingList;
use App\Repository\AddressRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
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
#[Route('/order' , name:'order.')]
class OrderController extends AbstractController
{
    #[Route('/shopping', name: 'shoppinglists')]
    public function index(): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        return $this->render('order/index.html.twig', [
            'title' => 'لیست خرید',
            'shoppings' => $this->getUser()->getPendingShoppingLists(),
            'addresses'=>$this->getUser()->getAddresses(),
            'totalPrice'=> Order::calculatePrice($this->getUser()->getPendingShoppingLists()),
            'addressForm'=>$form->createView()
        ]);
    }


    #[Route('/add-to-cart/{product}', name: 'addToCart')]
    public function addToCart(int $product , ProductRepository $productRepository , EntityManagerInterface $entityManager): Response
    {
        $product = $productRepository->find($product);
        $user = $this->getUser();
        // add to cart (making new shopping list)
        $shopping = new ShoppingList();
        $shopping->setProduct($product);
        $shopping->setUser($user);

        $entityManager->persist($shopping);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }

    #[Route('/final', name: 'final' , methods:['POST'])]
    public function final(Request $request , AddressRepository $addressRepository): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $address = $addressRepository->find($request->request->get('address_id'));
        $order = new Order();
        $order->setAddress($address);
        $order->setUser($this->getUser());
        $order->setPrice(Order::calculatePrice($this->getUser()->getPendingShoppingLists()));
        $entityManager->persist($order);
        $entityManager->flush();
        // set all pending shopping list to this order
        $shoppings = $this->getUser()->getPendingShoppingLists();
        foreach ($shoppings as $item) {
            $item->setOrdr($order);
            $entityManager->persist($item);
            $entityManager->flush();
        }
        return $this->redirectToRoute('user.dashboard');
    }

    #[Route('/address/select/{address}', name: 'select.address')]
    public function selectAddress(int $address , AddressRepository $addressRepository): Response
    {
        // find existing address
        if(!($address = $addressRepository->find($address)))
        {
            return $this->redirectToRoute('user.addresses');
        }

        $entityManager = $this->getDoctrine()->getManager();
    
        // set other addresses to not default
        foreach ($this->getUser()->getAddresses() as $item) {
            $item->setDef(false);
            $entityManager->persist($item);
            $entityManager->flush();
        }
        // set this address to defalut
        $address->setDef(true);
        $entityManager->persist($address);
        $entityManager->flush();
        return $this->redirectToRoute('order.shoppinglists');

    }
}
