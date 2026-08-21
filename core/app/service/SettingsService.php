<?php
namespace App\Service;

/**
 * Cambio de contraseña propia (self-service), misma logica que changepasswd-view.php:
 * hash legacy sha1(md5()), requiere la contraseña actual para autorizar el cambio.
 */
class SettingsService {
	public function changePassword($userId, string $currentPassword, string $newPassword, string $confirmPassword): array {
		if ($currentPassword === '' || $newPassword === '' || $confirmPassword === '') {
			return ['success' => false, 'error' => 'No debes dejar espacios vacios.'];
		}

		if ($newPassword !== $confirmPassword) {
			return ['success' => false, 'error' => 'La nueva contraseña no coincide con la confirmación.'];
		}

		$user = \UserData::getById($userId);
		if (!$user || sha1(md5($currentPassword)) !== $user->password) {
			return ['success' => false, 'error' => 'La contraseña actual no es correcta.'];
		}

		$user->password = sha1(md5($newPassword));
		$user->update_passwd();

		return ['success' => true, 'error' => null];
	}
}
