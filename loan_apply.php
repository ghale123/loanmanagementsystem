<?php
include ("connection.php");

if (isset($_POST['apply'])) {
    $user_id = $_POST['user_id'];
    $amount = $_POST['amount'];
    $loan_plan = $_POST['loan_plan'];
    $loan_type = $_POST['loan_type'];

    $loan_query = "INSERT INTO loan(user_id, loan_amount, loan_plan, loan_type) VALUES(
        '$user_id', '$amount', '$loan_plan', '$loan_type')";
    $loan_data = mysqli_query($conn, $loan_query);
    if ($loan_data) {
        echo "<script>alert('Successfully Applied')</script>";
    } else {
        echo "failed to apply" . mysqli_error($conn);
    }
}
?>