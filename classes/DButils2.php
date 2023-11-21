<?php

class DButils2
{
    static function selectWhere($what, $from, $where){
        $query = 'SELECT '. $what .' FROM `' . $from . '` WHERE ' . $where;
        // echo $query;
        $sql = Sql::connect()->prepare($query);
        $sql->execute();
        return $sql->fetchAll();
    }
}