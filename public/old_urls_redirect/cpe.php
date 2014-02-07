<?php

    require_once("redirect.php");

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        
        switch ($page) {
            case "cpe":
                redirect301("songs/search/cantiques-pour-les-enfants");
                break;
            
            case "index-paroles":
                if (isset($_GET['lettre'])) {
                    redirect301("songs/index/cantiques-pour-les-enfants/".strtolower($_GET['lettre']));
                }else {
                    redirect301("songs/index/cantiques-pour-les-enfants");
                }
                
                break;
            
            case "cantique":
                if (isset($_GET['no'])) {
                    redirect301("songs/read/cantiques-pour-les-enfants/".$_GET['no']);
                }else {
                    redirect301("songs/read/cantiques-pour-les-enfants");
                }
                break;
        
            default:
                redirect301("songs/index/cantiques-pour-les-enfants");
                break;
        }
    }elseif (isset($_GET['partition'])) {
        redirect301("pdf/".$_GET['partition']);
    }else {
        redirect301("songs/index/cantiques-pour-les-enfants");
    }
    
?>
