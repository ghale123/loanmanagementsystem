<?php
include ("connection.php");
require ("loan_apply.php");
require ("payment.php");
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM user WHERE user_id='$user_id'";
    $data = mysqli_query($conn, $query);
    if (mysqli_num_rows($data) == 1) {
        $user_data = mysqli_fetch_assoc($data);
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
    <link rel="stylesheet" href="css/users.css" />
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
                    <p>My Loans</p>
                </div>
                <a href="#">
                    <div class="menu" id="newloan" onclick="newLoan()">
                        <i class="fa-solid fa-landmark"></i>
                        <p>New Loan</p>
                    </div>
                </a>

                <a href="#">
                    <div class="menu" id="payment" onclick="paymentShow()">
                        <i class="fa-solid fa-cash-register"></i>
                        <p>Payment</p>
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
                        <?php echo substr($user_data['user_name'], 0, 1); ?>
                    </div>
                    <p><?php echo $user_data['user_name'] ?></p>
                </div>
            </div>

            <!-- MY loan -->
            <div class="myloan hide">
                <h2>Loan Deatails</h2>
                <div class="details">
                    <table>
                        <thead>
                            <th>Loan Id</th>
                            <th>Loan Amount</th>
                            <th>Loan Type</th>
                            <th>Loan Plan</th>
                            <th>Remaining Due</th>
                            <th>Loan Status</th>
                        </thead>
                        <tbody>
                            <?php
                            include ("connection.php");
                            error_reporting(E_ALL);
                            $myloan = "SELECT l.loan_id, l.loan_type, l.loan_plan, l.loan_amount,l.status, p.amount 
                            FROM user AS u
                            INNER JOIN payment AS p ON u.user_id = p.user_id 
                            INNER JOIN loan AS l ON p.loan_id = l.loan_id
                           where u.user_id='$user_id' ";
                            $data = mysqli_query($conn, $myloan);
                            if (mysqli_num_rows($data) > 0) {
                                while ($row_loan = mysqli_fetch_assoc($data)) {
                                    // echo $row_loan['loan_id'];
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="loan_data"><?php echo $row_loan['loan_id'] ?></div>
                                        </td>
                                        <td>
                                            <div class="loan_data"><?php echo $row_loan['loan_amount'] ?></div>
                                        </td>
                                        <td>
                                            <div class="loan_data"><?php echo $row_loan['loan_type'] ?></div>
                                        </td>
                                        <td>
                                            <div class="loan_data"><?php echo $row_loan['loan_plan'] ?></div>
                                        </td>
                                        <td>
                                            <div class="loan_data"><?php echo $row_loan['loan_amount'] - $row_loan['amount'] ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="loan_data"><?php echo $row_loan['status'] ?></div>
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

            <!--New loan-->
            <div class="loan_container hide">
                <h2>Loan Application Form</h2>
                <div class="loan_search">
                    <form action="" method="post">
                        <input type="number" name="id" placeholder="enter your " required>
                        <button type="submit" name="search_loan">search</button>
                    </form>
                </div>
                <div class="loan_form">
                    <form action="" method="post">
                        <?php
                        if (isset($_POST['search_loan'])) {
                            $id = $_POST['id'];
                            //echo $id;
                            $search_query = "SELECT * FROM user WHERE user_id='$id'";
                            $search_data = mysqli_query($conn, $search_query);
                            if (mysqli_num_rows($search_data) == 1) {
                                $row_search = mysqli_fetch_assoc($search_data);
                                //echo $row_search['user_name'];
                                ?>
                                <div class="fields">
                                    <div class="input_field">
                                        <input type="text" value="<?php echo $row_search['user_name'] ?>"
                                            placeholder="enter your name">
                                    </div>
                                    <div class="input_field">
                                        <input type="text" value="<?php echo $row_search['email'] ?>"
                                            placeholder="enter your name">
                                    </div>
                                    <div class="input_field">
                                        <input type="text" value="<?php echo $row_search['gender'] ?>"
                                            placeholder="enter your name">
                                    </div>
                                    <div class="input_field">
                                        <input type="text" value="<?php echo $row_search['profession'] ?>"
                                            placeholder="enter your name">
                                    </div>
                                    <div class="input_field">
                                        <input type="text" value="<?php echo $row_search['pan_no'] ?>"
                                            placeholder="enter your name">
                                    </div>
                                    <div class="input_field">
                                        <input type="text" value="<?php echo $row_search['address'] ?>"
                                            placeholder="enter your name">
                                    </div>
                                    <div class="input_field">
                                        <div>
                                            <label>Amount:</label>
                                        </div>
                                        <input type="text" name="amount" placeholder="enter your loan amount">
                                    </div>
                                    <div class="input_field">
                                        <select name="loan_plan">
                                            <option selected disabled>select your loan plan</option>
                                            <option>36-Months 8% Interest 3% penalty</option>
                                            <option>24-Months 7% Interest 2% penalty</option>
                                            <option>12-Months 6% Interest 2% penalty</option>
                                            <option>6-Months 5% Interest 1% penalty</option>
                                        </select>

                                    </div>
                                    <div class="input_field">
                                        <select name="loan_type">
                                            <option selected disabled>select your loan type</option>
                                            <option>Business Loan</option>
                                            <option>Education Loan</option>
                                            <option>Small Business Loan</option>
                                            <option>Personal Loan</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="user_id" value="<?php echo $row_search['user_id'] ?>">
                                </div>
                                <div class="apply_btn">
                                    <button type="submit" name="apply">Apply</button>
                                </div>
                                <?php
                            } else {
                                echo "<script>alert('User Id not Found')</script>";
                            }
                        }
                        ?>

                    </form>
                </div>
            </div>

            <!-- payment -->
            <div class="payment_container hide">

                <h2>Loan Payment</h2>
                <div class="loan_search">
                    <form action="" method="post">
                        <input type="text" name="loan_id" placeholder="enter your loan id" required>
                        <button type="submit" name="loan_search" style="margin-left:10px;">Search</button>
                    </form>
                </div>
                <div class="payment_form">
                    <form action="" method="post">
                        <?php
                        if (isset($_POST['loan_search'])) {
                            $loan_id = $_POST['loan_id'];

                            $select = "SELECT * FROM loan WHERE loan_id='$loan_id' AND status='approved'";
                            $select_data = mysqli_query($conn, $select);
                            if (mysqli_num_rows($select_data) == 1) {
                                $result_loan = mysqli_fetch_assoc($select_data);

                                ?>
                                <div class="fields">
                                    <div class="input_field">
                                        <label>Loan Type:</label>:</label>
                                        <input type="text" value="<?php echo $result_loan['loan_type'] ?>" readonly>
                                    </div>
                                    <div class="input_field">
                                        <label>Loan Plan:</label>:</label>
                                        <input type="text" value="<?php echo $result_loan['loan_plan'] ?>" readonly>
                                    </div>
                                    <div class="input_field">
                                        <label>Loan Amount:</label>:</label>
                                        <input type="text" value="<?php echo $result_loan['loan_amount'] ?>" readonly>
                                    </div>
                                    <div class="input_field">
                                        <label>Date:</label>:</label>
                                        <input type="date" id="datepicker" name="payment_date" readonly>
                                    </div>
                                    <div class="input_field">
                                        <label>Payment Amount:</label>
                                        <input type="number" name="amount" placeholder="Enter amount you want to pay" required>
                                    </div>
                                    <div class="payment_btn">
                                        <button type="submit" name="payment">Payment</button>
                                    </div>
                                    <input type="hidden" name="loan_id" value="<?php echo $result_loan['loan_id'] ?>">
                                    <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>

        // current date
        document.addEventListener('DOMContentLoaded', function () {
            var today = new Date().toISOString().slice(0, 10);

            document.getElementById('datepicker').value = today;
        });

        function loanDetails() {
            document.querySelector('#myloan').classList.add("active");
            document.querySelector('#newloan').classList.remove("active");
            document.querySelector('#payment').classList.remove("active");
            document.querySelector('#dashboard').classList.remove("active");
            document.querySelector('.myloan').classList.remove("hide");
            document.querySelector('.loan_container').classList.add("hide");
            document.querySelector('.payment_container').classList.add("hide");

        }
        function newLoan() {
            document.querySelector('#myloan').classList.remove("active");
            document.querySelector('#dashboard').classList.remove("active");
            document.querySelector('#payment').classList.remove("active");
            document.querySelector('#newloan').classList.add("active");
            document.querySelector('.myloan').classList.add("hide");
            document.querySelector('.loan_container').classList.remove("hide");
            document.querySelector('.payment_container').classList.add("hide");

        }
        function dashboardShow() {
            document.querySelector('#dashboard').classList.add("active");
            document.querySelector('#myloan').classList.remove("active");
            document.querySelector('#payment').classList.remove("active");
            document.querySelector('#newloan').classList.remove("active");
            document.querySelector('.myloan').classList.add("hide");
            document.querySelector('.loan_container').classList.add("hide");
            document.querySelector('.payment_container').classList.add("hide");

        }
        function paymentShow() {
            document.querySelector('#dashboard').classList.remove("active");
            document.querySelector('#myloan').classList.remove("active");
            document.querySelector('#payment').classList.add("active");
            document.querySelector('#newloan').classList.remove("active");
            document.querySelector('.myloan').classList.add("hide");
            document.querySelector('.loan_container').classList.add("hide");
            document.querySelector('.payment_container').classList.remove("hide");
        }
    </script>
</body>

</html>

<?php
$select = "select * form loan";
$dat = mysqli_query($conn, $select);
$total = mysqli_num_rows($data);
if($total>0){
    $row=mysqli_fetch_assoc($data);
    echo $row['loan_id'];
}
?>