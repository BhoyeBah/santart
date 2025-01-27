<?php

namespace App\Service;

use App\Repository\OrderRepository;

class NumberGenerator
{
    private OrderRepository $orderRepository;
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function genererNumero()
    {
        $endOrder = $this->orderRepository->findOneBy([], ['id' => 'DESC']);
        $endOrder = $endOrder ? (int) substr($endOrder->getNumero(), 1) : 0;
        return sprintf('#%04d', $endOrder + 1);
    }
}

?>