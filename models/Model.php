<?php

abstract class Model
{
    private static $_bdd;

    // Database connexion
    private static function setBdd(){
        self::$_bdd = new PDO('mysql:host=localhost;dbname=blog_mvc;charset=utf8', 'root', '');

        // We use the PDO's stable (constantes) to prevent errors.
        self::$_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    // DB default connexion
    protected function getBdd(){
        if (self::$_bdd == null) {
            self::setBdd();
            return self::$_bdd;
        }
    }

    // Creation of the method to get elements in DB.
    protected function getAll($table, $obj){
        $this->getBdd();
        $var = [];
        $req = self::$_bdd->prepare('SELECT * FROM '.$table.' ORDER BY id desc');
        $req->execute();

        // Creation of the variable that request the datas
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            // $var Contain data as an object.
            $var[] = new $obj($data);
        }

        return $var;
        $req->closeCursor();
    }

    protected function getOne($table, $obj, $id){
        $this->getBdd();
        $var = [];
        $req = self::$_bdd->prepare("SELECT id, title, content, DATE_FORMAT(date, '%d/%m/%Y à %Hh%imin%ss') AS date FROM " .$table. " WHERE id = ?");
        $req->execute(array($id));

        // Creation of the variable that request the datas
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            // $var Contain data as an object.
            $var[] = new $obj($data);
        }

        return $var;
        $req->closeCursor();
    }

    protected function createOne($table, $obj)
    {
        $this->getBdd();
        $req = self::$_bdd->prepare("INSERT INTO ".$table." (title, content, date) VALUES (?, ?, ?)");
        $req ->execute(array($_POST['title'], $_POST['content'], date("d.m.Y")));

        $req->closeCursor();
    }


}
?>