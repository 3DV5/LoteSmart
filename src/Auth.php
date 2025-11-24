<?php
class Auth
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function login($email, $password)
    {
        $stmt = $this->db->query('SELECT * FROM users WHERE email = ?', [$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            return true;
        }
        return false;
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
    }

    public function isLogged()
    {
        return !empty($_SESSION['user_id']);
    }

    public function user()
    {
        if (!$this->isLogged()) return null;
        $stmt = $this->db->query('SELECT id, name, email FROM users WHERE id = ?', [$_SESSION['user_id']]);
        return $stmt->fetch();
    }

    public function roles()
    {
        if (!$this->isLogged()) return [];
        $stmt = $this->db->query('SELECT r.name FROM roles r JOIN user_roles ur ON ur.role_id = r.id WHERE ur.user_id = ?', [$_SESSION['user_id']]);
        return array_column($stmt->fetchAll(), 'name');
    }

    public function hasRole($role)
    {
        $roles = $this->roles();
        return in_array($role, $roles, true);
    }

    public function requireRole($role)
    {
        $this->requireLogin();
        if (!$this->hasRole($role)) {
            http_response_code(403);
            echo 'Acesso negado';
            exit;
        }
    }

    public function requireLogin()
    {
        if (!$this->isLogged()) {
            header('Location: ?r=login');
            exit;
        }
    }
}
