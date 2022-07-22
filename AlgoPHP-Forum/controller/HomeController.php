<?php

namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;

class HomeController extends AbstractController implements ControllerInterface {

    public function index(){
        
        $categoryManager = new CategoryManager; // instanciation de la class CategoryManager qui ce trouve dans model/manager
        return [

            "view" => VIEW_DIR."home.php",
            "data" => ["categories" => $categoryManager -> findAllInTopicsByCategories()]
        ];
    }
}

    
