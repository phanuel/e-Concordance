 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BibleBookNotFoundException extends Exception {
    public function __construct($message = null, $code = 0) {
        parent::__construct($message, $code);
    }
}