<?php

function clean_query_text($input, $case_sensitive) {
    $input = trim($input); // removing spaces arround input string
    $input = preg_replace('/\s+/', ' ', $input); // replacing multiple consecutive spaces by single spaces
        
    if ($case_sensitive == false) {
        $input = mb_strtolower($input, 'UTF-8');
    }

    $useless = Array(".", ",", "!", "?", ":", ";", "(", ")");
    $input_cleaned = str_replace($useless, '', $input); // removing all useless characters
    
    return $input_cleaned;
}

function remove_accents($string) {
    // replacing all accented characters by the normal corresponding character
    $unwanted_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
        'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
        'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
        'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y');
    
    return strtr($string, $unwanted_array);
}

function accents_insensitive_pattern($string) {
    $string = remove_accents($string); // remove accents from input string

    // replacing all potentially accented characters with a pattern for regular expressions
    $string = str_replace("a", "[aáàâä]", $string);
    $string = str_replace("A", "[AÁÀÂÄ]", $string);
    $string = str_replace("e", "[eéèêë]", $string);
    $string = str_replace("E", "[EÉÈÊË]", $string);
    $string = str_replace("i", "[iíìîï]", $string);
    $string = str_replace("I", "[IÍÌÎÏ]", $string);
    $string = str_replace("o", "[oóòôö]", $string);
    $string = str_replace("O", "[OÓÒÔÖ]", $string);
    $string = str_replace("u", "[uúùûü]", $string);
    $string = str_replace("U", "[UÚÙÛÜ]", $string);
    $string = str_replace("c", "[cç]", $string);
    $string = str_replace("C", "[CÇ]", $string);
    
    return $string;
}

?>
