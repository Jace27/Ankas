<?php
namespace App;

class Functions {

    public static function UserHaveRight($rightName){
        session_start();
        if (isset($_SESSION['AuthedUser'])){
            foreach ($_SESSION['AuthedUser']['rights'] as $right){
                if ($right->name == $rightName){
                    return true;
                }
            }
        }
        return false;
    }

}
