<div id="recent_orders_container">
    <a class="mobile" href="index.php"><img src="./img/icons/return_arrow_left.svg" alt=""> Home</a>
    <h1>Recent Orders</h1>
</div>

<div id="recent_orders">
    <?php
    function generate_order($order_date, $order_item, $order_price){
        echo '    <div class="order">';
        echo '        <img src="./img/menu/thumbnail/' . $icon_link . '" alt="">';
        echo '        <div><p class="item_name">' . $order_item . '</p>';
        echo '        <p>' . $order_price . '</p>';
        echo '        <p>' . $order_date . '</p>';
        echo '        <button class="btn">Order again</button></div>';
        echo '    </div>';
    }

    if(isset($_COOKIE["name"]) && isset($_COOKIE["phone_number"]) && userExists($conn, $_COOKIE["name"], $_COOKIE["phone_number"])){
        $userID = getUserID($conn, $_COOKIE["name"], $_COOKIE["phone_number"]);
        $sql = "SELECT * FROM orders WHERE o_u_id = '". $userID . "'";
        $result = mysqli_query($conn,$sql);
    
        if ($result && !($result->num_rows == 0)) {
            $resultCheck = mysqli_num_rows($result);
            if($resultCheck>=1){
                while ($row = mysqli_fetch_assoc($result)) {
                    $orders = unserialize($row["o_order_detail"]);
                    $items = "";
                    foreach($orders as $theOrder){
                        $items .= $theOrder->getName();
                        if($theOrder != end($orders)){
                            $items .= ", ";
                        }
                    }
                    
                    $img = reset($orders)->getImg();
                    generate_order($row["o_ts"], $img, $items, $row["o_price"]);
                }
            }
        }
    
    ?>
</div>