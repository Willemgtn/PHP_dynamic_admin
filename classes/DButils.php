<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
class DButils
{
    static $nameRole = [
        '0' => 'Normal',
        '1' => 'Moderator',
        '2' => 'Administrator'
    ];
    static function updateUser($name, $pass, $uploadedImage, $user)
    {
        $sql = Sql::connect()->prepare('UPDATE `tb_admin.users` SET name = ?, password = ?, avatar = ? WHERE user = ?');
        if ($sql->execute(array($name, $pass, $uploadedImage, $user))) {
            Painel::htmlPopUp('success', 'Updated Successfully');
            return true;
        } else {
            Painel::htmlPopUp('error', 'Something went wrong ');
            return false;
        }
    }
    static function addUser($user, $name, $pass, $uploadedImage, $role)
    {
        if ($role < $_SESSION['role']) {
            $sql = Sql::connect()->prepare('INSERT INTO `tb_admin.users` VALUES (?,?,?,?,?,?)');
            if ($sql->execute(array(null, $user, $pass, $name, $uploadedImage, $role))) {
                Painel::htmlPopUp('success', 'User created Successfully');
                return true;
            } else {
                Painel::htmlPopUp('error', 'Something went wrong ');
                return false;
            }
        } else {
            Painel::htmlPopUp('error', 'Injection prevented, incident will be reported!');
        }
    }
    static function userExists($username)
    {
        $sql = Sql::connect()->prepare('SELECT id FROM `tb_admin.users` WHERE user = ?');
        $sql->execute(array($username));
        if ($sql->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }
    static function nameRole($role)
    {
        $arr = [
            '0' => 'Normal',
            '1' => 'Moderator',
            '2' => 'Administrator'
        ];
        return $arr[$role];
    }
    static function verifyPermission($permission)
    {
        if ($_SESSION['role'] < $permission) {

            Painel::htmlPopUp('error', 'Permission Denied. ');
            die();
            return false;
        }
    }

    static function flexInsert($tableName, $arr)
    {
        $ok = true;
        $query = "INSERT INTO `$tableName` VALUES (null";
        foreach ($arr as $key => $value) {
            if ($key == 'acao' || $key == 'submit')
                continue;
            if ($value == '') {
                $ok = false;
                break;
            }
            $query .= ",?";
            $params[] = $value;
        }
        $query .= ")";
        if ($ok == true) {
            $sql = Sql::connect()->prepare($query);
            if (!$sql->execute($params)) {
                $sql->debugDumpParams();
            }
        }

        return $ok;
    }
    static function flexSelectAll($tableName, $orderBy = false)
    {
        // $orderPreFix = is_bool($orderDesc) ? " ORDER BY id DESC" : "";
        $orderBy = strlen($orderBy) > 0 ? " ORDER BY " . $orderBy : "";
        // echo $orderBy;
        // if($start == null && $end == null){
        $sql = Sql::connect()->prepare("SELECT * FROM `$tableName`$orderBy");
        // } else {
        // $sql = Sql::connect() -> prepare ("SELECT * FROM `$tableName`$orderBy LIMIT $start, $end");
        // }

        $sql->execute();
        // $sql = $sql -> fetchAll();
        return $sql->fetchAll();
    }
    static function flexUpdate($tableName, $PropertiesArray)
    {
        $ok = true;
        // $query = 'UPDATE `$tableName` SET autor = ?, conteudo = ? WHERE id = ?';
        $query = "UPDATE `$tableName` SET";
        foreach ($PropertiesArray as $key => $value) {
            if ($key == 'submit')
                continue;
            if ($value == '') {
                $ok = false;
                break;
            }
            $keyparams[] = " $key = ?";
            $params[] = $value;
        }
        // echo "<br>imploding: ".implode(',', $keyparams);
        // echo "<br>imploding: ".implode(',', $params);
        $query .= implode(',', array_slice($keyparams, 0, -1));
        $query .= " WHERE " . end($keyparams);
        // echo "<br> $query <br>";
        // print_r($keyparams);
        // print_r($params);
        if ($ok == true) {
            $sql = Sql::connect()->prepare($query);
            if (!$sql->execute($params)) {
                $sql->debugDumpParams();
            }
        }
        return $ok;
    }
    static function deleteWhereId($tableName, $id)
    {
        $sql = Sql::connect()->prepare("DELETE FROM `$tableName` WHERE `$tableName`.`id` = ? ");
        if ($sql->execute(array($id))) {
            return true;
        } else {
            return false;
        }
    }
    static function select($tableName, $arr, $query, $orderBy = false)
    {
        $orderBy = strlen($orderBy) > 0 ? " ORDER BY " . $orderBy : "";
        // echo $orderBy;
        $sql = Sql::connect()->prepare("SELECT * FROM `$tableName` $query $orderBy");
        // $sql -> debugDumpParams();
        if ($sql->execute($arr)) {
            // $sql -> debugDumpParams();

            return $sql->fetch();
        } else {
            return false;
        }
    }
    static function orderItem($tableName, $orderType, $idItem)
    {
        // $infoItemAtual = DButils::select($tableName, array($idItem), 'id=?');
        $infoItemAtual = DButils::select($tableName, array($idItem), 'WHERE id=?');
        //  echo "<hr>";
        //  print_r($infoItemAtual);
        $order_id = $infoItemAtual['order_id'];
        //  echo "selected order_id: $order_id;<hr>";

        if ($orderType == 'down') {

            $itemBefore = Sql::connect()->prepare("SELECT * FROM `$tableName` WHERE order_id < $order_id ORDER BY order_id DESC  LIMIT 1");
            $itemBefore->execute();
            if ($itemBefore->rowCount() == 0) {
                // echo "didn't find ";
                return;
            }
            // echo '<hr>';
            $itemBefore = $itemBefore->fetch();
            // print_r($itemBefore);
            DButils::flexUpdate(
                $tableName,
                array('order_id' => $infoItemAtual['order_id'], 'id' => $itemBefore['id'])
            );
            DButils::flexUpdate(
                $tableName,
                array('order_id' => $itemBefore['order_id'], 'id' => $infoItemAtual['id'])
            );
        } else if ($orderType == 'up') {
            $itemBefore = Sql::connect()->prepare("SELECT * FROM `$tableName` WHERE order_id > $order_id ORDER BY order_id ASC  LIMIT 1");
            $itemBefore->execute();
            if ($itemBefore->rowCount() == 0) {
                // echo "didn't find ";
                return;
            }
            $itemBefore = $itemBefore->fetch();
            // print_r($itemBefore);
            DButils::flexUpdate(
                $tableName,
                array('order_id' => $infoItemAtual['order_id'], 'id' => $itemBefore['id'])
            );
            DButils::flexUpdate(
                $tableName,
                array('order_id' => $itemBefore['order_id'], 'id' => $infoItemAtual['id'])
            );
        }
    }
    // static function superSQL(string $from, $where, $groupBy, $having,string|array $select, $orderBy, $limit){
    //     $query = "FROM $from ";

    //     $sql = Sql::connect() -> prepare($query);

    // }
}
