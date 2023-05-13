<?php

    include_once "../../backend/core.php";

    if (!isset($_SESSION['id'])) {
        header('Location: ' . $CONFIGURATION['site_url'] . 'login');
        exit;
    }

    if(isset($_GET['id']) && isset($_GET['a'])){
        
        $action = $_GET['a'];

        if($action == 'edit'){
            $customer_id = $_GET['id'];

            $sql = "SELECT * FROM $tabela_clientes WHERE `id` = $customer_id";
            $query = $mysqli->query($sql);
            if($query){
                $customer_infos = $query->fetch_assoc();
            } else { return; }
        }
    }    

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <?php include "../templates/includes/head.php"; ?>    

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include "../templates/includes/sidebar.php"; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include "../templates/includes/topbar.php"; ?>
                <!-- End of Topbar -->

                <!-- Body -->
                <?php include "../templates/customers/customer/body.php"; ?>
                <!-- Body -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include "../templates/includes/footer.php"; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Modals -->
    <?php include "../templates/includes/modals.php"; ?>
    <!-- Modals -->

    <!-- Scripts Section -->
    <?php include "../templates/includes/scripts.php"; ?>
    <!-- Scripts Section -->

</body>

</html>