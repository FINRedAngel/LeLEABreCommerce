<?php
namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaymentController extends AbstractController
{
    private EntityManagerInterface $em;
    private UrlGeneratorInterface $generator;

    public function __constructeur(EntityManagerInterface $em, UrlGeneratorInterface $generator){
        $this->em = $em;
        $this->$generator = $em;
    }

    #[Route('/order/create-session-stripe/{reference}', name: 'payment_stripe')]
    public function stripeCheckout($reference): RedirectResponse {

        $productStripe = [];

        $order = $this->em->getRepository(Order::class)->findOneBy(['reference' => $reference]);

        if(!$order){
            return $this->redirectToRoute('cart_index');
        }

        foreach($order->getRecapDetails()->getValues() as $product){
            $productData = $this->em->getRepository(Product::class)->findOneBy(['name' => $product->getProduct()]);
            $productStripe[]= [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product->getPrice(),
                    'product_data' => [
                        'name' => $product->getProduct()
                    ]
                ],
                'quantity' => $product->getQuantity()
            ];
        }

        $productStripe[] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $productData->getPrice(),
                'product_data' => [
                    'name' => $product->getProduct()
                ]
            ],
            'quantity' => 1,
        ];

        Stripe::setApiKey('pk_test_51NIGaWLgvBp685Nsz82XfKzSehgqiuXMvpnlwMbX2H38lHYg2mvQZk6Sg0846aKSUV9TTqiG7uwijIDI0Rh2udwA00JROoFszG');

        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'payment_method_types' => ['card'],
            'line_items' => [[
                $productStripe
            ]],
            'mode' => 'payment',
            'success_url' => $this->generator->generate(
                '/order/success/{reference}',
                ['reference' => $order->getReference()],
                UrlGeneratorInterface::ABSOLUTE_URL
            ),
            'cancel_url' => $this->generator->generate(
                '/order/error/{reference}',
                ['reference' => $order->getReference()],
                UrlGeneratorInterface::ABSOLUTE_URL
            )
        ]);

        $order->setStripeSessionId($checkout_session->id);

        $this->em->flush();

        return new RedirectResponse($checkout_session->url);
    }

    #[Route('/order/success/{reference}', name: 'payment_success')]
    public function StripeSuccess($reference, CartService $service)
    {
        return $this->render('order/success');
    }

    #[Route('/order/error/{reference}', name: 'payment_error')]
    public function StripeError($reference, CartService $service)
    {
        return $this->render('order/error');
    }
}