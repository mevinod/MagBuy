<?php
//Include Error Handler
require_once '../../../utility/error_handler_dir_back.php';

//Include Admin/Mod check
require_once '../../../utility/admin_session.php';

//Autoload to require needed model files
function __autoload($className)
{
    $className = '..\\..\\..\\' . $className;
    require_once str_replace("\\", "/", $className) . '.php';
}

if (isset($_GET['scid'])) {
    //Try to accomplish connection with the database
    try {
        $subcatId = $_GET['scid'];
        $subcatDao = \model\database\SubCategoriesDao::getInstance();
        $subcatDao->deleteSubCategory($subcatId);

        header("Location: ../../../view/admin/subcategories/subcategories_view.php");
        die();

    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
        error_log($message, 3, '../../../errors.log');
        header("Location: ../../../view/error/error_500.php");
        die();
    }
} else {
    header("Location: ../../../view/error/error_400.php");
    die();
}