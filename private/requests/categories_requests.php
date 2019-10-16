<?php
require_once "../private/class/Category.php";
require_once 'filter.php';

session_start();

$cat = new Category();

switch ($_GET['do']) { 

    case 'get_categories':{
    $data = $cat->Search();

    }
    break;

    case 'get_category':{
        $cat->setCatID(trim($_POST['cat_id']));
        $data = $cat->GetCategory();

    }
    break;

    case 'category_update':{
        $cat->setName(trim($_POST['name']));
        
        if(isset($_POST['cat_id']))
            $cat->setCatID(trim($_POST['cat_id']));

        if($_POST['form-btn'] == 'update')
            $data = $cat->Update();
        else if($_POST['form-btn'] == 'delete')
            $data = $cat->Delete();
        else if($_POST['form-btn'] == 'add')
            $data = $cat->Add();

    }
    break;
    
    // cases categories add update delete

}
