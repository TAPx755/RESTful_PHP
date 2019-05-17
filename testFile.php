<?php
require "models/ActivityPackage.php";

$ap = new ActivityPackage(2, "hallo", "hallo", "hallo", 25, "2019-03-03", "00:00", 2, 0, "arzl");

$ap->save();




