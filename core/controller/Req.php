<?php

/**
 * Clase Req
 *
 * Acceso estatico a datos de entrada ($_GET, $_POST) y validacion liviana
 * de formularios, para los controladores nuevos (App\Controller).
 * Se llama "Req" (no "Request") porque core/controller/Request.php ya
 * existe con una API distinta (magic __get sobre $_REQUEST) usada por
 * codigo legacy.
 */
class Req {
	public static function get(?string $key = null, $default = null) {
		if ($key === null) return $_GET;
		return $_GET[$key] ?? $default;
	}

	public static function post(?string $key = null, $default = null) {
		if ($key === null) return $_POST;
		return $_POST[$key] ?? $default;
	}

	public static function all(): array {
		return array_merge($_GET, $_POST);
	}

	public static function validate(array $rules): array {
		$errors = [];
		$data = self::all();

		foreach ($rules as $field => $ruleString) {
			$rulesList = explode('|', $ruleString);
			$value = trim($data[$field] ?? '');

			foreach ($rulesList as $rule) {
				if ($rule === 'required' && $value === '') {
					$errors[$field] = "El campo {$field} es obligatorio.";
				} elseif ($rule === 'email' && $value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
					$errors[$field] = "El campo {$field} debe ser un correo electronico valido.";
				} elseif (strpos($rule, 'min:') === 0) {
					$min = (int)substr($rule, 4);
					if (strlen($value) < $min) {
						$errors[$field] = "El campo {$field} debe tener al menos {$min} caracteres.";
					}
				}
			}
		}

		return $errors;
	}
}
