<?php
class Role
{
    private $db;
    public function __construct(Database $db) { $this->db = $db; }

    public function findByName($name)
    {
        $stmt = $this->db->query('SELECT * FROM roles WHERE name = ?', [$name]);
        return $stmt->fetch();
    }

    public function all()
    {
        $stmt = $this->db->query('SELECT * FROM roles ORDER BY name');
        return $stmt->fetchAll();
    }
}
