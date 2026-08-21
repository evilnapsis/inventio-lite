<?php
namespace App\Service;

/**
 * Servicio para consultar y actualizar parámetros de configuración del sistema.
 */
class ConfigurationService {
	public function getAll(): array {
		return \ConfigurationData::getAll();
	}

	public function updateAll(array $configs): void {
		foreach ($configs as $id => $val) {
			$cfg = \ConfigurationData::getById((int)$id);
			if ($cfg) {
				$cfg->val = $val;
				$cfg->update();
			}
		}
	}
}
