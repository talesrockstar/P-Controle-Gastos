<?php

namespace Model;

use PDO;
use PDOException;

class Despesa
{
    private $db;
    private $table = 'despesas';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function criarDespesa(int $usuarioId, string $descricao, float $valor, string $categoria, string $data): bool
    {
        try {
            $sql = "INSERT INTO {$this->table} (usuario_id, descricao, valor, categoria, data_despesa, data_criacao) 
                    VALUES (?, ?, ?, ?, ?, NOW())";
            $stmt = $this->db->prepare($sql);
            
            return $stmt->execute([$usuarioId, $descricao, $valor, $categoria, $data]);
            
        } catch (PDOException $e) {
            error_log("Erro ao criar despesa: " . $e->getMessage());
            return false;
        }
    }
    
    public function listarDespesasUsuario(int $usuarioId, int $limite = 50, int $offset = 0): array
    {
        try {
            $limite = (int)$limite;
            $offset = (int)$offset;

            $sql = "SELECT id, descricao, valor, categoria, data_despesa, data_criacao 
                    FROM {$this->table} 
                    WHERE usuario_id = ? 
                    ORDER BY data_despesa DESC, data_criacao DESC 
                    LIMIT $limite OFFSET $offset";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$usuarioId]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erro ao listar despesas: " . $e->getMessage());
            return [];
        }
    }

    public function buscarDespesa(int $id, int $usuarioId)
    {
        try {
            $sql = "SELECT id, descricao, valor, categoria, data_despesa, data_criacao 
                    FROM {$this->table} 
                    WHERE id = ? AND usuario_id = ?";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id, $usuarioId]);
            
            return $stmt->fetch();
            
        } catch (PDOException $e) {
            error_log("Erro ao buscar despesa: " . $e->getMessage());
            return false;
        }
    }

    public function atualizarDespesa(int $id, int $usuarioId, string $descricao, float $valor, string $categoria, string $data): bool
    {
        try {
            $sql = "UPDATE {$this->table} 
                    SET descricao = ?, valor = ?, categoria = ?, data_despesa = ? 
                    WHERE id = ? AND usuario_id = ?";
            
            $stmt = $this->db->prepare($sql);
            
            return $stmt->execute([$descricao, $valor, $categoria, $data, $id, $usuarioId]);
            
        } catch (PDOException $e) {
            error_log("Erro ao atualizar despesa: " . $e->getMessage());
            return false;
        }
    }

    public function excluirDespesa(int $id, int $usuarioId): bool
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = ? AND usuario_id = ?";
            $stmt = $this->db->prepare($sql);
            
            return $stmt->execute([$id, $usuarioId]);
            
        } catch (PDOException $e) {
            error_log("Erro ao excluir despesa: " . $e->getMessage());
            return false;
        }
    }

    public function calcularTotalPeriodo(int $usuarioId, string $dataInicio, string $dataFim): float
    {
        try {
            $sql = "SELECT SUM(valor) as total 
                    FROM {$this->table} 
                    WHERE usuario_id = ? AND data_despesa BETWEEN ? AND ?";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$usuarioId, $dataInicio, $dataFim]);
            
            $resultado = $stmt->fetch();
            return $resultado['total'] ?? 0.0;
            
        } catch (PDOException $e) {
            error_log("Erro ao calcular total: " . $e->getMessage());
            return 0.0;
        }
    }

    public function listarPorCategoria(int $usuarioId, string $dataInicio, string $dataFim): array
    {
        try {
            $sql = "SELECT categoria, SUM(valor) as total, COUNT(*) as quantidade 
                    FROM {$this->table} 
                    WHERE usuario_id = ? AND data_despesa BETWEEN ? AND ? 
                    GROUP BY categoria 
                    ORDER BY total DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$usuarioId, $dataInicio, $dataFim]);
            
            return $stmt->fetchAll();
            
        } catch (PDOException $e) {
            error_log("Erro ao listar por categoria: " . $e->getMessage());
            return [];
        }
    }
}

?>

