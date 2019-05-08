<?php

$filter = '2023-06-17,0293-02-02';

echo preg_match_all('^([0-9]{4}-[0-9]{1,2}-[0-9]{1,2})^', $filter);