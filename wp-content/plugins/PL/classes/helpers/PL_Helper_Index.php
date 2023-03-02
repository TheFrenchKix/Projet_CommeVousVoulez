<?php

class PL_Helper_Index{
    
    public function SexeToGender($sexe){

        if ($sexe == "H")
        {
            $civilite = "Mr.";
        }
        else if($sexe == "F")
        {
            $civilite = "Mme.";
        }

        return $civilite;

    }
}

?>