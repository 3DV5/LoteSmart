<?php
class User
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function create($data)
    {
        $hash = password_hash($data['password'], PASSWORD_DEFAULT);
        try {
            $this->db->query('INSERT INTO users (name, email, password) VALUES (?, ?, ?)', [$data['name'], $data['email'], $hash]);
            $id = $this->db->pdo()->lastInsertId();
            // assign default role if provided
            if (!empty($data['role'])) {
                // find role id
                $stmt = $this->db->query('SELECT id FROM roles WHERE name = ? LIMIT 1', [$data['role']]);
                $r = $stmt->fetch();
                if ($r) {
                    $this->db->query('INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)', [$id, $r['id']]);
                }
            }
            return $id;
        } catch (Exception $e) {
            return false;
        }
    }

    public function findById($id)
    {
        $stmt = $this->db->query('SELECT id, name, email FROM users WHERE id = ?', [$id]);
        return $stmt->fetch();
    }
}
