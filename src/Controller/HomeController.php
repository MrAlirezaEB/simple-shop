<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ProductRepository $productRepository): Response
    {
        // most viewed products
        $most_view_products = $productRepository->findBy(
            [],
            ['views' => 'DESC'],
            4
        );
        

        // recent added products
        $recent_products = $productRepository->findBy(
            [],
            ['createdAt' => 'DESC'],
            4
        );

        return $this->render('home/index.html.twig', [
            'title' => 'صفحه نخست',
            'most_view_products'=>$most_view_products,
            'recent_products'=>$recent_products
        ]);
    }

    #[Route('/products', name: 'products')]
    public function products(ProductRepository $productRepository): Response
    {
        // all products with pagination
        $products = $productRepository->getAllProducts(12);
        return $this->render('home/products.html.twig', [
            'title' => 'همه محصولات',
            'products'=>$products->getIterator(),
            'links'=>$products->links
        ]);
    }

    #[Route('/product/{product}/{name}', name: 'product.single')]
    public function single(int $product , ProductRepository $productRepository): Response
    {

        $product = $productRepository->find($product);

        return $this->render('home/single.html.twig', [
            'title' => $product->getTitle(),
            'product'=>$product,
        ]);
    }

    #[Route('/search', name: 'search' , methods:['POST'])]
    public function search(Request $request , ProductRepository $productRepository): Response
    {
        $products = $productRepository->search($request->request->get('q'));
        return $this->render('home/products.html.twig', [
            'title' => 'نتایج جستوجو : '.$request->query->get('q'),
            'products'=>$products->getIterator(),
            'links'=>$products->links
        ]);
    }

}
