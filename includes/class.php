<?php

class Dog {

    var $eyeColor;
    var $nose;
    var $furColor;

    function showAll(){
       echo "Eye Color: " . $this->eyeColor. "<br>";
       echo "Nose: " . $this->nose. "<br>";
       echo "Fur Color: " . $this->furColor . "<br>";

    }

}

$doggy = new Dog;
$doggy->eyeColor = "Blue";
$doggy->nose = 1;
$doggy->furColor = "Black" . "<br>";

$doggy->showAll();

$pitBull = new Dog;
$pitBull->eyeColor = "Brown";
$pitBull->nose = 1;
$pitBull->furColor = "Grey";

$pitBull->showAll();