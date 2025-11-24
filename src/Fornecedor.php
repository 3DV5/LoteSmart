<?php
class Fornecedor
{
    private $db;
    public function __construct(Database $db) { $this->db = $db; }

    public function create($data)
    {
        $this->db->query('INSERT INTO fornecedores (nome, contato, telefone, email) VALUES (?, ?, ?, ?)', [$data['nome'], $data['contato'] ?? null, $data['telefone'] ?? null, $data['email'] ?? null]);
        return $this->db->pdo()->lastInsertId();
    }

    public function all()
    {
        $stmt = $this->db->query('SELECT * FROM fornecedores ORDER BY nome');
        return $stmt->fetchAll();
    }
}
