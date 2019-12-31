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
        $this->pager             = $pager;
    }

    /**
     * @Route("/", name="index")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request): Response
    {
        $pageNr = $request->query->get('page', 1);

        return $this->render('index/index.html.twig', [
            'products' => $this->products($pageNr),
            'pages'    => $this->pager->pages($pageNr, $this->nrPages()),
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

    /**
     * @Route("/page/{pageNr}", name="page", methods={"POST"})
     * @param int $pageNr
     * @return Response
     */
    public function pageAction(int $pageNr): Response
    {
        return $this->render('products.html.twig', ['products' => $this->products($pageNr)]);
    }

    /**
     * @Route("/pages/{pageNr}", name="pages", methods={"POST"})
     * @param int $pageNr
     * @return Response
     */
    public function pageButtonsAction(int $pageNr): Response
    {
        return $this->render(
            'pages/pages.html.twig',
            ['pages' => $this->pager->pages($pageNr, $this->nrPages())]
        );
    }

    /**
     * @param int $pageNr
     * @return Product[]
     */
    private function products(int $pageNr): array
    {
        return $this
            ->productRepository
            ->createQueryBuilder('product')
            ->setMaxResults(self::PRODUCTS_PER_PAGE)
            ->setFirstResult(($pageNr - 1) * self::PRODUCTS_PER_PAGE)
            ->getQuery()
            ->execute();
    }

    private function nrPages(): int
    {
        return (int)ceil($this->productRepository->count([]) / self::PRODUCTS_PER_PAGE);
    }
}
