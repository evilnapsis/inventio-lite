<?php
namespace App\Service;

/**
 * Sirve tanto a Clientes (kind=1) como a Proveedores (kind=2), ya que
 * ambos modulos comparten la tabla `person` y solo difieren en el kind.
 */
class PersonService {
	public function getAllClients(): array {
		return \PersonData::getClients();
	}

	public function getAllProviders(): array {
		return \PersonData::getProviders();
	}

	public function getPersonById($id) {
		return \PersonData::getById($id);
	}

	public function createPerson(array $data, int $kind): void {
		$person = new \PersonData();
		$person->name = $data['name'] ?? '';
		$person->lastname = $data['lastname'] ?? '';
		$person->address1 = $data['address1'] ?? '';
		$person->email1 = $data['email1'] ?? '';
		$person->phone1 = $data['phone1'] ?? '';
		$person->add($kind);
	}

	public function updatePerson($id, array $data): void {
		$person = \PersonData::getById($id);
		if (!$person) return;

		$person->name = $data['name'] ?? $person->name;
		$person->lastname = $data['lastname'] ?? $person->lastname;
		$person->address1 = $data['address1'] ?? $person->address1;
		$person->email1 = $data['email1'] ?? $person->email1;
		$person->phone1 = $data['phone1'] ?? $person->phone1;
		$person->update();
	}

	public function deletePerson($id): void {
		\PersonData::delById($id);
	}
}
