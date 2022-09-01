<?php
class UsersMod
{
    static $pageTable = 'tb_admin.users';

    static $nameRole = [
        '0' => 'Normal',
        '1' => 'Moderator',
        '2' => 'Administrator'
    ];
    static function updateUser($name, $pass, $uploadedImage, $user)
    {
        $pageTable = self::$pageTable;
        $sql = Sql::connect()->prepare("UPDATE `$pageTable` SET name = ?, password = ?, avatar = ? WHERE user = ?");
        if ($sql->execute(array($name, $pass, $uploadedImage, $user))) {
            Painel::htmlPopUp('ok', 'Updated Successfully');
            return true;
        } else {
            Painel::htmlPopUp('error', 'Something went wrong ');
            return false;
        }
    }
    static function updateUsers(array $setProperties)
    {
        $pageTable = self::$pageTable;
        $currentAvatar = '';
        // Lookup id, verify that role is less then the current user
        $sql = Sql::connect()->prepare("SELECT id, avatar, role FROM `$pageTable` WHERE id = $setProperties[id]");
        $sql->execute();
        // $sql->debugDumpParams();

        if ($sql->rowCount() == 0) {
            // user does not exist
            Painel::htmlPopUp('error', 'The user does not exist yet, try adding first.');
            return false;
        } else if ($sql->rowCount() == 1) {
            // verify if role is less than current user
            $sql = $sql->fetch();
            $currentAvatar = $sql['avatar'];
            self::verifyPermission($sql['role']);
        } else if ($sql->rowCount() > 1) {
            // Internal Error
            Painel::htmlPopUp('error', 'Internal Erro, multiple users. ');
            return false;
        }
        if ($currentAvatar && $setProperties['avatar'] == '') {
            $setProperties['avatar'] = $currentAvatar;
        }
        $sql = Sql::connect()->prepare("UPDATE `$pageTable` SET user = :user, password = :password, name = :name, avatar = :avatar, role = :role WHERE id = :id");

        // echo "<pre>";
        // $sql->debugDumpParams();
        // print_r($setProperties);
        // echo "</pre>";
        // print_r($setProperties);


        if ($sql->execute($setProperties)) {
            Painel::htmlPopUp('ok', 'Updated Successfully');
            return true;
        } else {
            Painel::htmlPopUp('error', 'Something went wrong ');
            return false;
        }
    }
    static function addUser($user, $name, $pass, $uploadedImage, $role)
    {
        $pageTable = self::$pageTable;

        if ($role < $_SESSION['role']) {
            $sql = Sql::connect()->prepare("INSERT INTO `$pageTable` VALUES (?,?,?,?,?,?)");
            if ($sql->execute(array(null, $user, $pass, $name, $uploadedImage, $role))) {
                Painel::htmlPopUp('ok', 'User created Successfully');
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
        $pageTable = self::$pageTable;

        $sql = Sql::connect()->prepare("SELECT id FROM `$pageTable` WHERE user = ?");
        $sql->execute(array($username));
        if ($sql->rowCount() != 0) {
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
}
