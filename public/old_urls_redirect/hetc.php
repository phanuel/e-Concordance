<?php

    require_once("redirect.php");

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        
        switch ($page) {
            case "hetc":
                redirect301("songs/search/hymnes-et-cantiques");
                break;
            
            case "index-paroles":
                if (isset($_GET['lettre'])) {
                    redirect301("songs/index/hymnes-et-cantiques/".strtolower($_GET['lettre']));
                }else {
                    redirect301("songs/index/hymnes-et-cantiques");
                }
                break;
            
            case "index-melodies":
                if (isset($_GET['lettre'])) {
                    redirect301("songs/index_melodies/hymnes-et-cantiques/".strtolower($_GET['lettre']));
                }else {
                    redirect301("songs/index_melodies/hymnes-et-cantiques");
                }
                break;
            
            case "index-metres":
                if (isset($_GET['chiffres'])) {
                    redirect301("songs/index_meters/hymnes-et-cantiques/".$_GET['chiffres']);
                }else {
                    redirect301("songs/index_meters/hymnes-et-cantiques");
                }
                break;
            
            case "cantique":
                if (isset($_GET['no'])) {
                    redirect301("songs/read/hymnes-et-cantiques/".$_GET['no']);
                }else {
                    redirect301("songs/read/hymnes-et-cantiques");
                }
                break;
        
            default:
                redirect301("songs/index/hymnes-et-cantiques");
                break;
        }
    }elseif (isset($_GET['partition'])) {
        redirect301("pdf/".$_GET['partition']);
    }else {
        redirect301("songs/index/hymnes-et-cantiques");
    }
    
?>
