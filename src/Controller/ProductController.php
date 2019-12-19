<?php

namespace App\Controller;

use App\Entity\Feedback;
use App\Entity\Product;
use App\Form\FeedbackType;
use App\Repository\ProductRepository;
use App\Service\Pager;
use DateTimeImmutable;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private const PRODUCTS_PER_PAGE = 3;

    private ProductRepository $productRepository;
    private Pager $pager;

    public function __construct(ProductRepository $productRepository, Pager $pager)
    {
        $this->productRepository = $productRepository;
        $this->pager = $pager;
    }

    /**
     * @Route("/", name="index")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $pageNr = $request->query->get('page', 1);
        $products = $this->productRepository->findAll();
        $nrPages  = (int)ceil(count($products) / self::PRODUCTS_PER_PAGE);

        /** @var Product[] $products */
        $products = array_slice(
            $products,
            ($pageNr - 1) * self::PRODUCTS_PER_PAGE,
            self::PRODUCTS_PER_PAGE
        );

        return $this->render('index/index.html.twig', [
            'products' => $products,
            'pages'    => $this->pager->pages($pageNr, $nrPages),
        ]);
    }

    /**
     * @Route("/product/{product}", name="product")
     * @param Product $product
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function productAction(Product $product, Request $request): Response
    {
        $feedback = (new Feedback())->setTime(new DateTimeImmutable());
        $feedbackForm = $this->createForm(FeedbackType::class, $feedback);
        $feedbackForm->handleRequest($request);

        if ($feedbackForm->isSubmitted() && $feedbackForm->isValid()) {
            $objectManager = $this->getDoctrine()->getManager();
            $product->addFeedback($feedback);
            $objectManager->persist($product);
            $objectManager->flush();

            return $this->redirect($request->getRequestUri());
        }

        return $this->render(
            'index/product.html.twig',
            [
                'product'       => $product,
                'feedback_form' => $feedbackForm->createView(),
            ]
        );
    }
}
