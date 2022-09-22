<?php

namespace models;

class imoveisModel
{
    static $tableEmpreendimentos = 'tb_admin.empreendimentos';
    static $tableImoveis = 'tb_admin.imoveis';
    static $tableImoveisImagens = 'tb_admin.imoveis_imagens';

    static function getEmpreendimentos()
    {
        $tableEmpreendimentos = self::$tableEmpreendimentos;
        $tableImoveis = self::$tableImoveis;
        $tableImoveisImagens = self::$tableImoveisImagens;
        // -----------------
        $sql = \Sql::connect()->query("SELECT * FROM `$tableEmpreendimentos`")->fetchAll(\PDO::FETCH_ASSOC);
        // $sql= $sql
        return $sql;
    }
    static function getImoveisById(?string $imovelId)
    {
        $tableEmpreendimentos = self::$tableEmpreendimentos;
        $tableImoveis = self::$tableImoveis;
        $tableImoveisImagens = self::$tableImoveisImagens;

        $sql = \Sql::connect()->query("SELECT * FROM `$tableImoveis` WHERE id = $imovelId")->fetch(\PDO::FETCH_ASSOC);
        return $sql;
    }
    static function getImoveisImagens(?string $imovelId)
    {
        $tableEmpreendimentos = self::$tableEmpreendimentos;
        $tableImoveis = self::$tableImoveis;
        $tableImoveisImagens = self::$tableImoveisImagens;
        $imovelId = (int)$imovelId;

        // $sql = \Sql::connect()->query("SELECT * FROM `$tableImoveis` WHERE id = $imovelId")->fetch(\PDO::FETCH_ASSOC);
        $sql = self::getImoveisById($imovelId);
        $sql['imagens'] = \Sql::connect()->query("SELECT * FROM `$tableImoveisImagens` WHERE imovel_id = $imovelId")->fetchAll(\PDO::FETCH_ASSOC);
        return $sql;
    }
}
