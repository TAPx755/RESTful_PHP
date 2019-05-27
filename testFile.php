<?php
require "models/ActivityPackage.php";
require "models/User.php";

$ap = new ActivityPackage(2, "", "DDD$", "hallo", 25, "2019-03-03", "00$:00", 2, 0, "arzl");

$ap->save();

$us = new User(2,"Oktay", "asdasd1234D", "AJAJAJAJ", "hih@gmail.com", 1,1);

//$us->save();




