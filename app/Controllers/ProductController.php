<?php

namespace app\Controllers;

use app\DAO\ProductDAO;
use Helpers\JsonResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProductController extends Controller
{
    private $productDAO;

    public function __construct()
    {
        $this->productDAO = new ProductDAO();
        parent::__construct($this->productDAO);
    }
    
}