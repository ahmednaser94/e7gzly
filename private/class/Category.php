<?php
require_once 'Database.php';
require_once 'Operations.php';

class Category extends Database implements Operations
{

    var $cat_id, $name;



    public function checkCategory()
    {
        $result = $this->RUNSearch('SELECT name FROM categories WHERE name =?', [$this->name]);

        return $result->rowCount() > 0 ? "This Category already exists" : false;
    }

    public function Add()
    {
        // check if this name already exists
        $check = $this->checkCategory();

        if (!$check)
            return $this->RunDML('INSERT INTO categories (name) VALUES (?)', [$this->name], "Category has been Added");
        else
            return $check;
    }

    public function Update()
    {
        return $this->RunDML("UPDATE categories SET name = ? WHERE id = ?", [$this->name, $this->cat_id], "Category Updated");
    }

    public function Delete()
    {
        return $this->RunDML('DELETE FROM categories WHERE id = ?', [$this->cat_id], "Category has been deleted");
    }


    public function Search()
    {
        $result = $this->pdo->query("SELECT * FROM categories ORDER BY name ASC");

        return $result->rowCount() > 0 ? $result->fetchAll() : false;
    }


    public function GetCategory()
    {

        $result = $this->RUNSearch("SELECT * FROM categories WHERE id = ?", [$this->cat_id]);

        return $result->rowCount() > 0 ? $result->fetch() : false;
    }


    public function setCatID($cat_id)
    {
        return $this->cat_id = $cat_id;
    }
    public function getCatID()
    {
        return $this->cat_id;
    }

    public function setName($name)
    {
        return $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}
