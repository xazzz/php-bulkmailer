<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
print_r ($_POST);
print_r ($_GET);


if (isset ($_POST['selects'])) {
    $guids = isset($_POST['selects']);
}

foreach ($guids as $guid) {
    $guid = trim ($guid);
    
    
}
?>
