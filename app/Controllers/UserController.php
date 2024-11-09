<?php

namespace app\Controllers;

use app\DAO\UserDAO;
use app\Models\UserModel;
use Helpers\JsonResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController extends Controller
{
    private $userDAO;
    private $userModel;

    public function __construct()
    {
        $this->userDAO = new UserDAO();
        $this->userModel = new UserModel();
        parent::__construct($this->userDAO, $this->userModel);
    }

}