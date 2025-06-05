<?php
date_default_timezone_set('UTC');

// Base URL pointing to the admin directory
$base_url = "http://localhost/shoe-store/admin/";

// Admin credentials for authentication
$admin_username = "bhupendra@gmail.com";
$admin_password = "Bhupendr@123";

// Cookie file to store session
$cookie_file = "cookie.txt";

function log_result($id, $op, $status, $message) {
    $log = "$id | $op | $status | $message | " . date("Y-m-d H:i:s") . "\n";
    file_put_contents("admin_test_log.txt", $log, FILE_APPEND);
    echo $log;
}

function send_post($url, $data) {
    global $cookie_file;
    $opts = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\nCookie: " . file_get_contents($cookie_file),
            'method'  => 'POST',
            'content' => http_build_query($data),
        ]
    ];
    $ctx = stream_context_create($opts);
    return file_get_contents($url, false, $ctx);
}

function send_get($url) {
    global $cookie_file;
    $opts = [
        'http' => [
            'header' => "Cookie: " . file_get_contents($cookie_file),
            'method' => 'GET',
        ]
    ];
    $ctx = stream_context_create($opts);
    return file_get_contents($url, false, $ctx);
}

function login() {
    global $base_url, $admin_username, $admin_password, $cookie_file;
    $data = [
        'email' => $admin_username,
        'password' => $admin_password
    ];
    $opts = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ]
    ];
    $ctx = stream_context_create($opts);
    $res = file_get_contents($base_url . "login_process.php", false, $ctx);

    // Extract session cookie
    preg_match('/Set-Cookie: (.*?);/', implode("\n", $http_response_header), $matches);
    if (!empty($matches[1])) {
        file_put_contents($cookie_file, $matches[1]);
        return true;
    }
    return false;
}

// 🔹 Manage Products
function test_add_product() {
    global $base_url;
    $data = [
        'ProductName' => 'New Shoe',
        'Description' => 'Comfortable running shoe',
        'Price'       => 59.99,
        'Size'        => 10,
        'Stock'       => 50,
        'CategoryID'  => 1,
        'ImagePath'   => 'img/new_shoe.jpg'
    ];
    $res = send_post($base_url . "add_product.php", $data);
    if (strpos($res, 'success') !== false) {
        log_result('TC001', 'Add Product', 'PASS', 'Product added');
    } else {
        log_result('TC001', 'Add Product', 'FAIL', $res);
    }
}

function test_edit_product() {
    global $base_url;
    $data = [
        'ProductID'   => 12,
        'ProductName' => 'Updated Shoe',
        'Description' => 'Updated description',
        'Price'       => 49.99,
        'Size'        => 9,
        'Stock'       => 40,
        'CategoryID'  => 1,
        'ImagePath'   => 'img/updated_shoe.jpg'
    ];
    $res = send_post($base_url . "edit_product.php", $data);
    if (strpos($res, 'success') !== false) {
        log_result('TC002', 'Edit Product', 'PASS', 'Product updated');
    } else {
        log_result('TC002', 'Edit Product', 'FAIL', $res);
    }
}

function test_delete_product() {
    global $base_url;
    $data = ['ProductID' => 12];
    $res = send_post($base_url . "delete_product.php", $data);
    if (strpos($res, 'success') !== false) {
        log_result('TC003', 'Delete Product', 'PASS', 'Product deleted');
    } else {
        log_result('TC003', 'Delete Product', 'FAIL', $res);
    }
}

function test_list_products() {
    global $base_url;
    $res = send_get($base_url . "list_products.php");
    if (strpos($res, 'New Shoe') !== false) {
        log_result('TC004', 'List Products', 'PASS', 'Products listed');
    } else {
        log_result('TC004', 'List Products', 'FAIL', $res);
    }
}

function test_validate_product_input() {
    global $base_url;
    $data = [
        'ProductName' => '',
        'Description' => 'Invalid product',
        'Price'       => -10,
        'Size'        => -1,
        'Stock'       => -5,
        'CategoryID'  => 1,
        'ImagePath'   => 'img/invalid.jpg'
    ];
    $res = send_post($base_url . "add_product.php", $data);
    if (strpos($res, 'error') !== false || strpos($res, 'required') !== false) {
        log_result('TC005', 'Validate Product Input', 'PASS', 'Validation works');
    } else {
        log_result('TC005', 'Validate Product Input', 'FAIL', $res);
    }
}

// 🔹 Manage Categories
function test_add_category() {
    global $base_url;
    $data = ['CategoryName' => 'Sports Shoes'];
    $res = send_post($base_url . "add_category.php", $data);
    if (strpos($res, 'success') !== false) {
        log_result('TC006', 'Add Category', 'PASS', 'Category added');
    } else {
        log_result('TC006', 'Add Category', 'FAIL', $res);
    }
}

function test_edit_category() {
    global $base_url;
    $data = [
        'CategoryID'   => 5,
        'CategoryName' => 'Running Shoes'
    ];
    $res = send_post($base_url . "edit_category.php", $data);
    if (strpos($res, 'success') !== false) {
        log_result('TC007', 'Edit Category', 'PASS', 'Category updated');
    } else {
        log_result('TC007', 'Edit Category', 'FAIL', $res);
    }
}

function test_delete_category() {
    global $base_url;
    $data = ['CategoryID' => 5];
    $res = send_post($base_url . "delete_category.php", $data);
    if (strpos($res, 'success') !== false) {
        log_result('TC008', 'Delete Category', 'PASS', 'Category deleted');
    } else {
        log_result('TC008', 'Delete Category', 'FAIL', $res);
    }
}

function test_list_categories() {
    global $base_url;
    $res = send_get($base_url . "list_categories.php");
    if (strpos($res, 'Sports Shoes') !== false) {
        log_result('TC009', 'List Categories', 'PASS', 'Categories listed');
    } else {
        log_result('TC009', 'List Categories', 'FAIL', $res);
    }
}

function test_validate_category_input() {
    global $base_url;
    $data = ['CategoryName' => ''];
    $res = send_post($base_url . "add_category.php", $data);
    if (strpos($res, 'error') !== false || strpos($res, 'required') !== false) {
        log_result('TC010', 'Validate Category Input', 'PASS', 'Validation works');
    } else {
        log_result('TC010', 'Validate Category Input', 'FAIL', $res);
    }
}

// 🔹 Manage Orders
function test_edit_order() {
    global $base_url;
    $data = [
        'OrderID' => 15,
        'Status'  => 'Shipped'
    ];
    $res = send_post($base_url . "edit_order.php", $data);
    if (strpos($res, 'success') !== false) {
        log_result('TC011', 'Edit Order', 'PASS', 'Order updated');
    } else {
        log_result('TC011', 'Edit Order', 'FAIL', $res);
    }
}

function test_delete_order() {
    global $base_url;
    $data = ['OrderID' => 15];
    $res = send_post($base_url . "delete_order.php", $data);
    if (strpos($res, 'success') !== false) {
        log_result('TC012', 'Delete Order', 'PASS', 'Order deleted');
    } else {
        log_result('TC012', 'Delete Order', 'FAIL', $res);
    }
}

function test_export_orders() {
    global $base_url;
    $res = send_get($base_url . "export_orders.php");
    if (strpos($res, 'CSV') !== false) {
        log_result('TC013', 'Export Orders', 'PASS', 'Orders exported');
    } else {
        log_result('TC013', 'Export Orders', 'FAIL', $res);
    }
}

// 🔹 Manage Users
function test_edit_user() {
    global $base_url;
    $data = [
        'UserID'   => 8,
        'FullName' => 'John Doe'
    ];
    $res = send_post($base_url . "edit_user.php", $data);
    if (strpos($res, 'success') !== false) {
        log_result('TC014', 'Edit User', 'PASS', 'User updated');
    } else {
        log_result('TC014', 'Edit User', 'FAIL', $res);
    }
}

function test_reset_password() {
    global $base_url;
    $data = [
        'UserID'       => 8,
        'NewPassword'  => 'Valid123!'
    ];
    $res = send_post($base_url . "reset_password.php", $data);
    if (strpos($res, 'success') !== false) {
        log_result('TC015', 'Reset Password', 'PASS', 'Password reset');
    } else {
        log_result('TC015', 'Reset Password', 'FAIL', $res);
    }
}

function test_delete_user() {
    global $base_url;
    $data = ['UserID' => 8];
    $res = send_post($base_url . "delete_user.php", $data);
    if (strpos($res, 'success') !== false) {
        log_result('TC016', 'Delete User', 'PASS', 'User deleted');
    } else {
        log_result('TC016', 'Delete User', 'FAIL', $res);
    }
}

// 🔹 Admin Logs
function test_view_logs() {
    global $base_url;
    $res = send_get($base_url . "view_logs.php");
    if (strpos($res, 'Admin Actions') !== false) {
        log_result('TC017', 'View Logs', 'PASS', 'Logs viewed');
    } else {
        log_result('TC017', 'View Logs', 'FAIL', $res);
    }
}

function test_search_logs() {
    global $base_url;
    $res = send_get($base_url . "logs.php?action=Deleted Product");
    if (strpos($res, 'Deleted Product') !== false) {
        log_result('TC018', 'Search Logs', 'PASS', 'Logs searched');
    } else {
        log_result('TC018', 'Search Logs', 'FAIL', $res);
    }
}

// 🔄 Run All Tests
if (login()) {
    test_add_product();
    test_edit_product();
    test_delete_product();
    test_list_products();
    test_validate_product_input();

    test_add_category();
    test_edit_category();
    test_delete_category();
    test_list_categories();
    test_validate_category_input();

    test_edit_order();
    test_delete_order();
    test_export_orders();

    test_edit_user();
    test_reset_password();
    test_delete_user();

    test_view_logs();
    test_search_logs();
} else {
    echo "Login failed. Please check your credentials.";
}
?>