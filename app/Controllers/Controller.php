<?php

namespace app\Controllers;

use app\DAO\Connection;
use app\Models\Model;
use Helpers\JsonResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class Controller
{
	private $DAO;
	private $Model;

	public function __construct(Connection $DAO, Model $Model)
	{
		$this->DAO = $DAO;
		$this->Model = $Model;
	}

	public function show(Request $request, Response $response)
	{
		$data = $this->DAO->getAll();
		return JsonResponse::withJson($data, 200, $response);
	}

	public function find(Request $request, Response $response, array $args)
	{
		$find_id = $args['id'];
		$data = $this->DAO->getById($find_id);

		if($data === false){
			return JsonResponse::withJson([
				'message' => 'Nenhum registro encontrado!'
			], 404, $response);
		}

		return JsonResponse::withJson($data, 200, $response);
	}

	public function findBy(Request $request, Response $response)
	{
		$finders = $request->getQueryParams();
		$data = $this->DAO->getBySlug($finders);

		if($data === false){
			return JsonResponse::withJson([
				'message' => 'Nenhum registro encontrado!'
			], 404, $response);
		}

		return JsonResponse::withJson($data, 200, $response);
	}

	public function store(Request $request, Response $response)
	{
		$data = json_decode($request->getBody()->getContents(), true);

		try{
			$this->Model->fillEntity($data);
			$this->DAO->create($this->Model);
	
			return JsonResponse::withJson([
				'message' => "Salvo com sucesso!",
				'status' => 'success'
			], 201, $response);

		} catch (\Exception $ex) {
			return JsonResponse::withJson([
				'message' => $ex->getMessage(),
				'status' => 'error'
			], $ex->getCode(), $response);
		}
	}

	public function update(Request $request, Response $response, array $args)
	{
		$find_id = $args['id'];
		$data = $this->DAO->getById($find_id);

		$request = json_decode($request->getBody()->getContents(), true);

		try {

			if(!$data){
				throw new \Exception("Registro não encontrado", 404);
			}

			// alterar o updated_at para a data e hora atuais
			if(isset($data['updated_at'])){
				$data['updated_at'] = date('Y-m-d H:i:s');
			}

			// troca os dados atuais com os dados do request
			$merged = array_replace($data, $request);
			$this->Model->fillEntity(array_replace($data, $merged));

			$this->DAO->update($this->Model, $find_id);

			return JsonResponse::withJson([
				'message' => "Atualizado com sucesso!",
				'status' => 'success'
			], 200, $response);

		} catch (\Exception $ex) {
			return JsonResponse::withJson([
				'message' => $ex->getMessage(),
				'status' => 'error'
			], $ex->getCode(), $response);
		}
	}

	public function delete(Request $request, Response $response, array $args)
	{
		$delete_id = $args['id'];
		$data = $this->DAO->getById($delete_id);

		try {
			if(!$data){
				throw new \Exception("Registro não encontrado", 404);
			}

			$this->DAO->delete($delete_id);

			return JsonResponse::withJson([
				'message' => "Registro deletado com sucesso!",
				'status' => 'success'
			], 204, $response);

		} catch (\Exception $ex) {
			return JsonResponse::withJson([
				'message' => $ex->getMessage(),
				'status' => 'error'
			], $ex->getCode(), $response);
		}
	}

}