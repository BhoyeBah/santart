<?php

namespace App\Controller\Admin;

use App\Repository\OrderRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FactureController extends AbstractController
{
    #[Route('/admin/order/{id}/facture', name: 'app_facture')]
    public function index($id, OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->find($id);

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $domPdf = new Dompdf($pdfOptions);

        $html = $this->renderView('backend/facture/facture.html.twig', [
            'order' => $order
        ]);

        $domPdf->loadHtml($html);
        $domPdf->render();
        $domPdf->stream('facture'.$order->getId().'.pdf', [
            'Attachment' => false,
        ]);
        return new Response('', 200, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
