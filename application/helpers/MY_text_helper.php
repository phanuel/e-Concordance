<?php

function clean_query_text($input, $case_sensitive) {
    if ($case_sensitive == false) {
        $input = mb_strtolower($input, 'UTF-8');
    }

    $useless = Array(".", ",", "!", "?", ":", ";", "(", ")");
    $input_cleaned = str_replace($useless, '', $input); // removing all useless characters
    $separators = Array("-", "'");
    $input_cleaned = str_replace($separators, ' ', $input_cleaned); // replacing all separators by a space
    
    return $input_cleaned;
}

?>
