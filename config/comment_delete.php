<?php
include '../database/connection.php';

if (isset($_GET['res'])) {
    $res = $_GET['res'];
    $split_res = explode('/', $res);

    if (count($split_res) === 3) {
        $sql = "
            DELETE FROM reviews WHERE review_id = :review_id AND restaurant_id = :res_id
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":review_id", $split_res[0]);
        $stmt->bindParam(":res_id", $split_res[1]);

        if ($stmt->execute()) {
            echo "
                <script>
                    window.location.href='../public/restaurant?item={$split_res[2]}';
                </script>
            ";
        }
    } else {
        // Handle the error (e.g., log it or show an error message)
        echo "
            <script>
                alert('Invalid request format. Please try again.');
                window.location.href='../public/';
            </script>
        ";
    }
}