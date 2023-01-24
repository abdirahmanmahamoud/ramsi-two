<?php
function OutgoingSreg($db,$names,$qtys,$adminId){
    $successS = [];
    $errorS = [];
    $dataTwo = array();
    for($i = 0; $i < count($names); $i++){
        $queryT = "SELECT name,qty,price FROM `inventory` WHERE name = '$names[$i]' AND userId = '$adminId'";
        $coonT = $db->query($queryT);
        if($coonT){
            $row = $coonT->fetch_assoc();
            if($row == null){
                $errorS [] = array(
                    'type' => 'null',
                    'name' => $names[$i]
                );
            }else{
                if($row['qty'] >= $qtys[$i]){
                    $successS [] = array(
                        'name' => $names[$i],
                        'qty' => $qtys[$i],
                        'price' => $row['price']
                    );
                }else{
                    $errorS [] = array(
                        'type' => 'qty',
                        'name' => $names[$i],
                        'qty' => $qtys[$i],
                        'qtyAction' => $row['qty']
                    );
                }
            }
           
        }
    }
    if(count($successS) > 0 && count($errorS) == 0){
        $Product = kajar($db,$successS,$adminId);
        $dataTwo = array('code' => 321,'data' => $Product);
    }elseif(count($errorS) > 0){
        $dataTwo  = array('code' => 404, 'data' => $errorS);
    }
    return $dataTwo;
}
function kajar($db,$successS,$adminId){
    $dates = [];
    for($S = 0; $S < count($successS); $S++){
        $ProductName = $successS[$S]['name'];
        $queryT = "SELECT name,qty,price FROM `inventory` WHERE name = '$ProductName' AND userId = '$adminId'";
        $coonT = $db->query($queryT);
        if($coonT){
            $row = $coonT->fetch_assoc();
            $qtyProductS = $row['qty'] - $successS[$S]['qty'];
            $query = "UPDATE `inventory` SET `qty`='$qtyProductS' WHERE name = '$ProductName' AND userId = '$adminId'";
            $coon = $db->query($query);
            if($coon){
                $dates [] = array(
                    'name' => $successS[$S]['name'],
                    'qty' => $successS[$S]['qty'],
                    'price' => $successS[$S]['price']
                );
            }
    
        }
    }
    return $dates;
}
// update functions
function OutgoingUp($db,$names,$qtys,$id,$adminId){
    $successS = [];
    $errorS = [];
    $dataTwo = array();
    for($i = 0; $i < count($names); $i++){
        $queryS = "SELECT name,qty FROM `product` WHERE id = '$id[$i]' AND userId = '$adminId'";
        $coonS = $db->query($queryS);
        if($coonS){
            $rowS = $coonS->fetch_assoc();
            $nameFrom = $names[$i];
            if($rowS['name'] == $nameFrom){
                $queryT = "SELECT name,qty,price FROM `inventory` WHERE name = '$names[$i]'  AND userId = '$adminId'";
                $coonT = $db->query($queryT);
                if($coonT){
                    $row = $coonT->fetch_assoc();
                    $totalQty = $row['qty'] + $rowS['qty'];
                    if($totalQty >= $qtys[$i]){
                        $successS [] = array(
                            'name' => $names[$i],
                            'qty' => $qtys[$i],
                            'price' => $row['price'],
                            'id' => $id[$i],
                            'qtyTu' => array(
                                'type' => 'updateProduct',
                                'name' => $rowS['name'],
                                'qty' => $totalQty - $qtys[$i],
                            )
                        );
                    }else{
                        $errorS [] = array(
                            'name' => $names[$i],
                            'qty' => $qtys[$i],
                            'qtyAction' => $totalQty
                        );
                    }
                }
            }else{
                $queryT = "SELECT name,qty,price FROM `inventory` WHERE name = '$names[$i]'  AND userId = '$adminId'";
                $coonT = $db->query($queryT);
                if($coonT){
                    $row = $coonT->fetch_assoc();
                    if($row['qty'] >= $qtys[$i]){
                        $successS [] = array(
                            'name' => $names[$i],
                            'qty' => $qtys[$i],
                            'price' => $row['price'],
                            'id' => $id[$i],
                            'qtyTu' => array(
                                'type' => 'inProduct',
                                'name' => $rowS['name'],
                                'qty' => $rowS['qty'],
                            )
                        );
                    }else{
                        $errorS [] = array(
                            'name' => $names[$i],
                            'qty' => $qtys[$i],
                            'qtyAction' => $row['qty']
                        );
                    }
                }
            }
        }
      
    }
    if(count($successS) > 0 && count($errorS) == 0){
       $Product = proUpdate($db,$successS,$adminId);
        $dataTwo = array('code' => 321,'data' => $Product);
    }elseif(count($errorS) > 0){
        $dataTwo  = array('code' => 404, 'data' => $errorS);
    }
    return $dataTwo;
}
function proUpdate($db,$successS,$adminId){
    $dates = [];
    for($S = 0; $S < count($successS); $S++){
        $type = $successS[$S]['qtyTu']['type'];
        if($type == 'inProduct'){
            $name = $successS[$S]['qtyTu']['name'];
            $qty = $successS[$S]['qtyTu']['qty'];
            $queryS = "SELECT name,qty FROM `inventory` WHERE name = '$name'  AND userId = '$adminId'";
            $coonS = $db->query($queryS);
            if($coonS){
                $rowS = $coonS->fetch_assoc();
                $tQty = $rowS['qty'] + $qty;
                $query = "UPDATE `inventory` SET `qty`='$tQty' WHERE name = '$name'  AND userId = '$adminId'";
                $coon = $db->query($query);
                if($coon){
                    $ProductName = $successS[$S]['name'];
                    $queryTK = "SELECT name,qty,price FROM `inventory` WHERE name = '$ProductName'  AND userId = '$adminId'";
                    $coonTK = $db->query($queryTK);
                   if($coonTK){
                    $rowTK = $coonTK->fetch_assoc();
                    $ProductQty = $rowTK['qty'] - $successS[$S]['qty'];
                    $queryI = "UPDATE `inventory` SET `qty`='$ProductQty' WHERE name = '$ProductName'  AND userId = '$adminId'";
                    $coonI = $db->query($queryI);
                    if($coonI){
                        $dates [] = array(
                            'name' => $successS[$S]['name'],
                            'qty' => $successS[$S]['qty'],
                            'price' => $successS[$S]['price'],
                            'id' => $successS[$S]['id']
                        );
                    }
                   }
                }
            }
        }else{
            $qty = $successS[$S]['qtyTu']['qty'];
            $ProductName = $successS[$S]['name']; 
            $query = "UPDATE `inventory` SET `qty`='$qty' WHERE name = '$ProductName'  AND userId = '$adminId'";
            $coon = $db->query($query);
            if($coon){
                $dates [] = array(
                    'name' => $successS[$S]['name'],
                    'qty' => $successS[$S]['qty'],
                    'price' => $successS[$S]['price'],
                    'id' => $successS[$S]['id']
                );
            }

    }
}
   return $dates;
}

function OutgoingDele($db,$id){
    $successS = [];
    $errorS = [];
    $query = "SELECT * FROM `product` WHERE group_id = '$id'";
    $coon = $db->query($query);
    if($coon){
        while($row = $coon->fetch_assoc()){
            $ProductName = $row['name'];
            $queryS = "SELECT name,qty FROM `inventory` WHERE name = '$ProductName'";
            $coonS = $db->query($queryS);
            if($coonS){
                $rowS = $coonS->fetch_assoc();
                $ProductQtyUpdate = $rowS['qty'] + $row['qty'];
                $queryI = "UPDATE `inventory` SET `qty`='$ProductQtyUpdate' WHERE name = '$ProductName'";
                $coonI = $db->query($queryI);
                if($coonI){
                    $successS = [
                        'success' => 321
                    ];
                }else{
                    $errorS = [
                        'error' => 404
                    ];
                }
            }
        }
    }
    if(count($successS) > 0 && count($errorS) == 0){
        $ret = 321;
        return $ret;
    }elseif(count($errorS) > 0){
    }  
}
?>