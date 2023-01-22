<?php
 $successS  = array(
    [
        'name' => 'abdiraxman',
        'phone' => '12345679',
        'city' => 'garowe'
    ],
    [
        'name' => 'jamal',
        'phone' => '313456789',
        'city' => 'garowe'
    ],
    [
        'name' => 'axmed',
        'phone' => '123456',
        'city' => 'garowe'
    ],
);
// print_r($successS[2]['name']);
for($S = 0; $S < count($successS); $S++){
    // echo $S;
    echo $successS[$S]['name'].'<br/>';
}
?>