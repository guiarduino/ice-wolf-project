<?php

namespace Helpers;

class Validate
{
	public static function validate(array $validations, array $args)
	{
		foreach ($validations as $key => $value)
		{
			// Testa se variavel pode ser vazia
			if(isset($value['nullable']) && $value['nullable'] === false){
				self::nullableTest($args, $key);
			} else if($value['nullable'] === true && !isset($args[$key])){
				continue;
			}

			// Teste de tipagem
			if (isset($value['type'])){
				self::typeTest($args[$key], $value['type'], $key);
			}

			// Teste de tamanho de string
			if(is_string($args[$key]) && isset($value['size'])){
				self::sizeTest($args[$key], $value['size'], $key);
			}
		}
	}

	public static function nullableTest(array $params, string $key): bool
	{
		if(!isset($params[$key]) || $params[$key] === null){
			throw new \InvalidArgumentException("Parametro '{$key}' é obrigatório.", 400);
		}
		
		return true;
	}

	public static function typeTest($param, string $type, string $key)
	{
		switch ($type) {
			case 'string':
				if(!is_string($param)){
					throw new \InvalidArgumentException("Parametro '{$key}' deve ser uma string", 400);
				}
				break;
			case 'int':
				if(!is_int($param)){
					throw new \InvalidArgumentException("Parametro '{$key}' deve ser um numero inteiro", 400);
				}
				break;
			case 'number':
				if(!is_numeric($param)){
					throw new \InvalidArgumentException("Parametro '{$key}' deve ser um numero", 400);
				}
				break;
			default:
				# code...
				break;
		}

	}
	
	public static function sizeTest(string $param, int $size, string $key)
	{
		if(strlen($param) > $size){
			throw new \InvalidArgumentException("Parametro '{$key}' deve ter no maximo {$size} caracteres", 400);
		}
	}

}