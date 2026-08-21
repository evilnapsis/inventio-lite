<?php
namespace App\Service;

class UserService {
	public function getAllUsers(): array {
		return \UserData::getAll();
	}

	public function getUserById($id) {
		return \UserData::getById($id);
	}

	public function createUser(array $data): void {
		$user = new \UserData();
		$user->name = $data['name'] ?? '';
		$user->lastname = $data['lastname'] ?? '';
		$user->username = $data['username'] ?? '';
		$user->email = $data['email'] ?? '';
		$user->is_admin = !empty($data['is_admin']) ? 1 : 0;
		// Se mantiene el esquema legacy sha1(md5()) para no invalidar el login existente
		$user->password = sha1(md5($data['password'] ?? ''));
		$user->add();
	}

	public function updateUser($id, array $data): void {
		$user = \UserData::getById($id);
		if (!$user) return;

		$user->name = $data['name'] ?? $user->name;
		$user->lastname = $data['lastname'] ?? $user->lastname;
		$user->username = $data['username'] ?? $user->username;
		$user->email = $data['email'] ?? $user->email;
		$user->is_admin = !empty($data['is_admin']) ? 1 : 0;
		$user->is_active = !empty($data['is_active']) ? 1 : 0;
		$user->update();

		if (!empty($data['password'])) {
			$user->password = sha1(md5($data['password']));
			$user->update_passwd();
		}
	}

	// No permite que un usuario se elimine a si mismo (misma proteccion que deluser-view.php). Retorna false si se bloqueo.
	public function deleteUser($id, $currentUserId): bool {
		if ((string)$id === (string)$currentUserId) {
			return false;
		}
		\UserData::delById($id);
		return true;
	}
}
