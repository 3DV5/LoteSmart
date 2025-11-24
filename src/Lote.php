<?php
class Lote
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function create($data)
    {
        $this->db->query('INSERT INTO lotes (codigo, descricao, quantidade) VALUES (?, ?, ?)', [$data['codigo'], $data['descricao'], $data['quantidade']]);
        return $this->db->pdo()->lastInsertId();
    }

    public function all()
    {
        $stmt = $this->db->query('SELECT * FROM lotes ORDER BY id DESC');
        return $stmt->fetchAll();
    }

    public function findById($id)
    {
        $stmt = $this->db->query('SELECT * FROM lotes WHERE id = ?', [$id]);
        return $stmt->fetch();
    }

    public function update($id, $data)
    {
        $this->db->query('UPDATE lotes SET codigo = ?, descricao = ?, quantidade = ?, data_fabricacao = ?, data_validade = ?, fornecedor_id = ?, status = ? WHERE id = ?', [$data['codigo'], $data['descricao'], $data['quantidade'], $data['data_fabricacao'] ?: null, $data['data_validade'] ?: null, $data['fornecedor_id'] ?: null, $data['status'] ?: 'ativo', $id]);
        return true;
    }

    public function delete($id)
    {
        $this->db->query('DELETE FROM lotes WHERE id = ?', [$id]);
        return true;
    }

    public function existsByCodigo($codigo, $excludeId = null)
    {
        if ($excludeId) {
            $stmt = $this->db->query('SELECT id FROM lotes WHERE codigo = ? AND id != ? LIMIT 1', [$codigo, $excludeId]);
        } else {
            $stmt = $this->db->query('SELECT id FROM lotes WHERE codigo = ? LIMIT 1', [$codigo]);
        }
        return (bool)$stmt->fetch();
    }
}
