<?php

namespace App\Service;

use App\Interface\LoremInterface;

class Lorem implements LoremInterface
{
    private $loremipsum = "dolor sit amet, consectetur adipiscing elit. Maecenas ut suscipit ante. Nam mollis nibh at leo iaculis consectetur. Pellentesque ut ullamcorper felis. Aenean placerat, ligula quis dictum consectetur, velit orci interdum magna, nec vestibulum urna purus sit amet lorem. Integer nulla ligula, pharetra sit amet quam eget, tempus suscipit lorem.";

    public function CreateLorem(){
        $newText = 'Lorem ipsum ';
        $tablorem = explode(' ', $this->loremipsum);
        $nbword = rand(3, 15);
        for($i=0; $i<$nbword; $i++){
            $keyOfWord = rand(1, count($tablorem)-1);
            $newText.= $tablorem[$keyOfWord].' ';
            if($i===($nbword-1)){
                $newText.='.';
            }
        }
        return $newText;
    }
}