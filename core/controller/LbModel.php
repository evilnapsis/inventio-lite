<?php

/**
 * Clase LbModel
 *
 * Mini-ORM (Active Record) sobre PDO con prepared statements, portado de LegoBox.
 * Los modelos nuevos que la extiendan quedan libres de concatenacion de SQL.
 */
abstract class LbModel {
	public static $tablename = "";
	public static $primaryKey = "id";

	protected static function getDb(): \PDO {
		return Database::getPdo();
	}

	public static function find($id) {
		$db = static::getDb();
		$table = static::$tablename;
		$pk = static::$primaryKey;

		$stmt = $db->prepare("SELECT * FROM {$table} WHERE {$pk} = :id LIMIT 1");
		$stmt->execute(['id' => $id]);
		$stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
		return $stmt->fetch() ?: null;
	}

	public static function all(): array {
		$db = static::getDb();
		$table = static::$tablename;

		$stmt = $db->query("SELECT * FROM {$table}");
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
	}

	public static function where(string $column, $value): array {
		$db = static::getDb();
		$table = static::$tablename;

		$stmt = $db->prepare("SELECT * FROM {$table} WHERE {$column} = :val");
		$stmt->execute(['val' => $value]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, static::class);
	}

	public static function whereOne(string $column, $value) {
		$results = static::where($column, $value);
		return $results[0] ?? null;
	}

	public function save(): bool {
		$pk = static::$primaryKey;
		if (isset($this->$pk) && !empty($this->$pk)) {
			return $this->updateRecord();
		} else {
			return $this->insertRecord();
		}
	}

	protected function getDatabaseFields(): array {
		$vars = get_object_vars($this);
		unset($vars[static::$primaryKey]);

		$cleanVars = [];
		foreach ($vars as $key => $value) {
			if ($key === 'created_at' && ($value === 'NOW()' || empty($value))) {
				$value = date('Y-m-d H:i:s');
			}
			if ($value === null || is_scalar($value)) {
				$cleanVars[$key] = $value;
			}
		}
		return $cleanVars;
	}

	private function insertRecord(): bool {
		$db = static::getDb();
		$table = static::$tablename;

		$vars = $this->getDatabaseFields();
		$fields = array_keys($vars);
		if (empty($fields)) return false;

		$columns = implode(', ', $fields);
		$placeholders = ':' . implode(', :', $fields);

		$stmt = $db->prepare("INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})");
		$success = $stmt->execute($vars);

		if ($success) {
			$pk = static::$primaryKey;
			$this->$pk = $db->lastInsertId();
		}
		return $success;
	}

	private function updateRecord(): bool {
		$db = static::getDb();
		$table = static::$tablename;
		$pk = static::$primaryKey;

		$idValue = $this->$pk;
		$vars = $this->getDatabaseFields();

		$sets = [];
		foreach ($vars as $key => $val) {
			$sets[] = "{$key} = :{$key}";
		}
		$setString = implode(', ', $sets);

		$stmt = $db->prepare("UPDATE {$table} SET {$setString} WHERE {$pk} = :_pk_id");
		$vars['_pk_id'] = $idValue;

		return $stmt->execute($vars);
	}

	public function delete(): bool {
		$pk = static::$primaryKey;
		if (!isset($this->$pk)) return false;

		$db = static::getDb();
		$table = static::$tablename;
		$stmt = $db->prepare("DELETE FROM {$table} WHERE {$pk} = :id");
		return $stmt->execute(['id' => $this->$pk]);
	}
}
