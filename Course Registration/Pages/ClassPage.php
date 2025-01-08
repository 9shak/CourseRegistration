<?php
class Semester {
    private $code;
    private $term;
    private $year;
    
    private $messages;
    
    public function __construct($code, $term, $year)
    {
        $this->code = $code;
        $this->term = $term;
        $this->year = $year;
        
        $this->messages = array();
    }
    
    public function getUserId() {
        return $this->code;
    }

    public function getName() {
        return $this->term;
    }

    public function getPhone() {
        return $this->year;
    }
}
?>