<?php
include ("connection.php");

session_start();
if (isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];
    $query = "SELECT * FROM admin WHERE admin_id='$admin_id'";
    $data = mysqli_query($conn, $query);
    if (mysqli_num_rows($data) == 1) {
        $admin_data = mysqli_fetch_assoc($data);
        //echo $user_data['user_name'];
    } else {
        header("loction: login.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin dashboard</title>
    <link rel="stylesheet" href="css/admin1.css" />
    <!-- Link to Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <!-- Import Google font - Poppins  -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

</head>

<body>

    <div class="body_container">

        <div class="sidebar">
            <div class="logo_img">
                Loan Management System
                <!-- <img src="image/logo.png"> -->
            </div>

            <div class="menu_container">
                <div class="menu active" id="dashboard" onclick="dashboardShow()">
                    <i class="fa-solid fa-house"></i>
                    <p>Dashboard</p>
                </div>
                <div class="menu" id="myloan" onclick="loanDetails()">
                    <i class="fa-solid fa-money-check"></i>
                    <p>Loan Requests</p>
                </div>
                <a href="#">
                    <div class="menu" id="newloan" onclick="newLoan()">
                        <i class="fa-solid fa-landmark"></i>
                        <p>Users</p>
                    </div>
                </a>

                <a href="#">
                    <div class="menu" id="payment" onclick="paymentShow()">
                        <i class="fa-solid fa-cash-register"></i>
                        <p>Loans</p>
                    </div>
                </a>
                <a href="#">
                    <div class="menu" id="payment" onclick="paymentShow()">
                        <i class="fa-solid fa-cash-register"></i>
                        <p>Payment Details</p>
                    </div>
                </a>
            </div>
            <div class="line"></div>

            <div class="logout_btn">
                <a href="logout.php">
                    <div class="menu">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <p>Logout</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- main section -->
        <div class="main_section">

            <div class="header">
                <div class="search_btn">
                    <input type="text" placeholder="Search here">
                    <button>search</button>
                </div>
                <div class="profile_btn">
                    <div class="letter">
                        <?php echo substr($admin_data['admin_name'], 0, 1); ?>
                    </div>
                    <p><?php echo $admin_data['admin_name'] ?></p>
                </div>
            </div>

            <!--LOan request section-->
            <div class="loan_request hide">
                <h2>Loan Requests</h2>
                <div class="table_wrapper">
                    <table>
                        <thead>
                            <th>Loan Id</th>
                            <th>Loan Amount</th>
                            <th>Loan Plan</th>
                            <th>Loan Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php
                            include ('connection.php');
                            $request_query = "SELECT `loan_id`, `user_id`, `loan_amount`, `loan_plan`, `loan_type`, `status` FROM `loan` WHERE status='pending';";
                            $request_data = mysqli_query($conn, $request_query);

                            if (mysqli_num_rows($request_data) > 0) {
                                while ($result = mysqli_fetch_assoc($request_data)) {
                                    // echo $result['loan_id'];
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="data">
                                                <?php echo $result['loan_id'] ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="data">
                                                <?php echo $result['loan_amount'] ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="data">
                                                <?php echo $result['loan_plan'] ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="data">
                                                <?php echo $result['loan_type'] ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="data">
                                                <?php echo $result['status'] ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="action_data">

                                                <a href="approve.php?id=<?php echo $result['loan_id'] ?>"><button
                                                        style="background-color:rgb(89, 183, 110);">Approve</button></a>

                                                <a href="delete_request.php?id=<?php echo $result['loan_id'] ?>"><button
                                                        onclick="return confirmDelete()">Reject</button></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php

                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- user section -->
            <div class="user_container hide">
                <h2>User Details</h2>
                <div class="table_wrapper">
                    <table>
                        <thead>
                            <th>user Id</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th>Pan No.</th>
                            <th>Profession</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php
                            $user_query = "SELECT * FROM user";
                            $user_data = mysqli_query($conn, $user_query);

                            if ($user_data) { // Check if query execution was successful
                                if (mysqli_num_rows($user_data) > 0) {
                                    while ($result_user = mysqli_fetch_assoc($user_data)) {
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="data">
                                                    <?php echo $result_user['user_id'] ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="data">
                                                    <?php echo $result_user['user_name'] ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="data">
                                                    <?php echo $result_user['address'] ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="data">
                                                    <?php echo $result_user['gender'] ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="data">
                                                    <?php echo $result_user['email'] ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="data">
                                                    <?php echo $result_user['pan_no'] ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="data">
                                                    <?php echo $result_user['profession'] ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="action_data">
                                                    <a href="user_delete.php?id=<?php echo $result_user['user_id'] ?>"><button
                                                            onclick="return confirmDeleteUser()">Delete</button></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            } else {
                                echo "Error executing the query: " . mysqli_error($conn); // Output error message
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>

            <!-- loan section -->
            <div class="user_container ">
                <h2>Loan Details</h2>
                <div class="table_wrapper">
                    <table>
                        <thead>
                            <th>User Name</th>
                            <th>User Pan No.</th>
                            <th>User Id</th>
                            <th>Loan Id</th>
                            <th>Loan Plan</th>
                            <th>Loan Type</th>
                            <th>Loan Amount</th>
                            <th>Remaining Due</th>
                        </thead>
                        <tbody>
                            <?php
                            $user_query = "SELECT u.user_name,u.user_id, u.pan_no, l.loan_id, l.loan_type, l.loan_plan, l.loan_amount, p.amount
                            FROM user AS u
                            INNER JOIN payment AS p ON u.user_id = p.user_id 
                            INNER JOIN loan AS l ON p.loan_id = l.loan_id";
                            $user_data = mysqli_query($conn, $user_query);

                            if ($user_data) { // Check if query execution was successful
                                if (mysqli_num_rows($user_data) > 0) {
                                    while ($result_user = mysqli_fetch_assoc($user_data)) {
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="data">
                                                    <?php echo $result_user['user_name'] ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="data">
                                                    <?php echo $result_user['pan_no'] ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="data">
                                                    <?php echo $result_user['user_id'] ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="data">
                                                    <?php echo $result_user['loan_id'] ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="data">
                                                    <?php echo $result_user['loan_plan'] ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="data">
                                                    <?php echo $result_user['loan_type'] ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="data">
                                                    <?php echo $result_user['loan_amount'] ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="data">
                                                    <?php echo $result_user['loan_amount'] - $result_user['amount'] ?>
                                                </div>
                                            </td>

                                        </tr>
                                        <?php
                                    }
                                }
                            } else {
                                echo "Error executing the query: " . mysqli_error($conn); // Output error message
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>


            <!-- payment details -->
            <div class="payment_container hide">
                <div class="user_container ">
                    <h2>Payment Details</h2>
                    <div class="table_wrapper">
                        <?php
                        // Assuming you have already established a database connection
                        
                        // Execute the SQL query
                        $user_query = "SELECT u.user_name, u.profession, u.pan_no, l.loan_id, l.loan_type, p.amount, p.date
                    FROM user AS u
                    INNER JOIN payment AS p ON u.user_id = p.user_id 
                    INNER JOIN loan AS l ON p.loan_id = l.loan_id";

                        $user_data = mysqli_query($conn, $user_query);

                        // Check if query execution was successful
                        if ($user_data) {
                            ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th>User Name</th>
                                        <th>Profession</th>
                                        <th>Pan No.</th>
                                        <th>Loan ID</th>
                                        <th>Loan Type</th>
                                        <th>Payed Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($user_data) > 0) {
                                        while ($result_user = mysqli_fetch_assoc($user_data)) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <div class="data"><?php echo $result_user['user_name']; ?></div>
                                                </td>
                                                <td>
                                                    <div class="data"><?php echo $result_user['profession']; ?></div>
                                                </td>
                                                <td>
                                                    <div class="data"><?php echo $result_user['pan_no']; ?></div>
                                                </td>
                                                <td>
                                                    <div class="data"><?php echo $result_user['loan_id']; ?></div>
                                                </td>
                                                <td>
                                                    <div class="data"><?php echo $result_user['loan_type']; ?></div>
                                                </td>
                                                <td>
                                                    <div class="data"><?php echo $result_user['amount']; ?></div>
                                                </td>
                                                <td>
                                                    <div class="data"><?php echo $result_user['date']; ?></div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='7'>No data found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                        } else {
                            echo "Error executing the query: " . mysqli_error($conn);
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function confirmDelete() {
            return confirm('Are you sure. you want to reject the request.');
        }
        function confirmDeleteUser() {
            return confirm('Are you sure. you want to delete the user.');
        }
    </script>
</body>

</html>