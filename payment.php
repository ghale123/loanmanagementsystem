<?php
include ("connection.php");

if (isset($_POST['payment'])) {
    $user_id = $_POST['user_id'];
    $loan_id = $_POST['loan_id'];
    $date = date("Y/M/d l", strtotime($_POST['payment_date']));
    $amount = $_POST['amount'];


    $payment_query = "INSERT INTO payment(user_id, loan_id, amount, date) VALUES('$user_id', '$loan_id', '$amount', '$date')";
    $payment_data = mysqli_query($conn, $payment_query);
    if ($payment_data) {
        echo "<script>alert('successfully payed')</script>";
    } else {
        echo "failed" . mysqli_error($conn);
    }
}
?>