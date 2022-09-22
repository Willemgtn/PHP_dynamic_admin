<?php

namespace models;

class imoveisModel
{
    static $tableEmpreendimentos = 'tb_admin.empreendimentos';
    static $tableImoveis = 'tb_admin.imoveis';
    static $tableImoveisImagens = 'tb_admin.imoveis_imagens';

    static function getAllEmpreendimentos()
    {
        $tableEmpreendimentos = self::$tableEmpreendimentos;
        $tableImoveis = self::$tableImoveis;
        $tableImoveisImagens = self::$tableImoveisImagens;
        // -----------------
        $sql = \Sql::connect()->query("SELECT * FROM `$tableEmpreendimentos`")->fetchAll(\PDO::FETCH_ASSOC);
        // $sql= $sql
        return $sql;
    }
    static function getImoveisByEmpreendimento(?string $empreendimentoId)
    {
        $tableEmpreendimentos = self::$tableEmpreendimentos;
        $tableImoveis = self::$tableImoveis;
        $tableImoveisImagens = self::$tableImoveisImagens;
        $empreendimentoId = (int)$empreendimentoId;

        $sql = \Sql::connect()->query("SELECT * FROM `$tableImoveis` WHERE empreendimento_id = $empreendimentoId")->fetchAll(\PDO::FETCH_ASSOC);
        return $sql;
    }

    // Single imovel and possible multiple photos
    static function getImovelById(?string $imovelId)
    {
        $tableEmpreendimentos = self::$tableEmpreendimentos;
        $tableImoveis = self::$tableImoveis;
        $tableImoveisImagens = self::$tableImoveisImagens;
        $imovelId = (int)$imovelId;

        $sql = \Sql::connect()->query("SELECT * FROM `$tableImoveis` WHERE id = $imovelId")->fetch(\PDO::FETCH_ASSOC);
        return $sql;
    }
    static function getImovelImagens(?string $imovelId)
    {
        $tableEmpreendimentos = self::$tableEmpreendimentos;
        $tableImoveis = self::$tableImoveis;
        $tableImoveisImagens = self::$tableImoveisImagens;
        $imovelId = (int)$imovelId;

        // $sql = \Sql::connect()->query("SELECT * FROM `$tableImoveis` WHERE id = $imovelId")->fetch(\PDO::FETCH_ASSOC);
        $sql = self::getImovelById($imovelId);
        $sql['imagens'] = \Sql::connect()->query("SELECT * FROM `$tableImoveisImagens` WHERE imovel_id = $imovelId")->fetchAll(\PDO::FETCH_ASSOC);
        return $sql;
    }
}
