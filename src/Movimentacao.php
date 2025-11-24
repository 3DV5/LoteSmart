<?php
class Movimentacao
{
    private $db;
    public function __construct(Database $db) { $this->db = $db; }

    public function create($data)
    {
        $this->db->query('INSERT INTO movimentacoes (lote_id, tipo, quantidade, data, user_id, observacao) VALUES (?, ?, ?, ?, ?, ?)', [$data['lote_id'], $data['tipo'], $data['quantidade'], $data['data'] ?? date('Y-m-d H:i:s'), $data['user_id'] ?? null, $data['observacao'] ?? null]);
        return $this->db->pdo()->lastInsertId();
    }

    public function byLote($lote_id)
    {
        $stmt = $this->db->query('SELECT m.*, u.name as usuario FROM movimentacoes m LEFT JOIN users u ON u.id = m.user_id WHERE m.lote_id = ? ORDER BY m.data DESC', [$lote_id]);
        return $stmt->fetchAll();
    }
}
