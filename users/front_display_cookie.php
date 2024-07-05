<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Canteen Management System | Front Display</title>

    <!-- loader-->
    <link href="../assets/css/pace.min.css" rel="stylesheet"/>
    <script src="../assets/js/pace.min.js"></script>

    <!--favicon-->
    <link rel="icon" href="../assets/images/favicon.ico" type="image/x-icon">

    <!-- Vector CSS -->
    <link href="../assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>

    <!-- simplebar CSS-->
    <link href="../assets/plugins/simplebar/css/simplebar.css" rel="stylesheet"/>

    <!-- Bootstrap core CSS-->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet"/>

    <!-- animate CSS-->
    <link href="../assets/css/animate.css" rel="stylesheet" type="text/css"/>

    <!-- Icons CSS-->
    <link href="../assets/icons/fontawesome-free-6.0.0-web/css/all.css" rel="stylesheet" type="text/css"/>

    <!-- Sidebar CSS-->
    <link href="../assets/css/sidebar-menu.css" rel="stylesheet"/>

    <link href="../assets/css/dataTables.bootstrap4.css" rel="stylesheet"/>
    <link href="../assets/css/responsive.dataTables.min.css" rel="stylesheet"/>
    <link href="../assets/css/toastr.min.css" rel="stylesheet"/>

    <!-- Custom Style-->
    <link href="../assets/css/app-style.css" rel="stylesheet"/>
</head>

<body class="bg-theme bg-theme6"><br><br>

<div class="row">

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4>Order List</h4>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="bg-light text-uppercase">
                        <tr>
                            <td><b>No.</b></td>
                            <td><b>Item Name</b></td>
                            <td><b>Price</b></td>
                            <td><b>Quantity</b></td>
                            <td><b>Total</b></td>
                        </tr>
                    </thead>
                    <tbody class="table-bordered" id="orders_tbl"></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg">
        <div class="card">
            <div class="card-header">
                <h5>Receipt</h5>
                <input type="hidden" name="trans_id" id="trans_id">
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">
                        <h5><b id="emp_name">---</b></h5>
                        <input type="hidden" name="emp_id" id="emp_id">
                    </div>
                    <div class="col-lg d-flex align-items-center justify-between">
                        <h5 class="mr-3"><b>Credit</b></h5>
                        <span class="fa fa-check p-2" id="credit_stat"></span>
                    </div>
                </div>

                <br><br>

                <table class="table">
                    <thead class="bg-light">
                        <tr>
                            <th>Discount</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody class="table-bordered" id="disc_tbl"></tbody>
                </table>

                <br><br>

                <div class="row">
                    <div class="col-lg-6">
                        <h3><b>Grand Total</b></h3>
                    </div>
                    <div class="col-lg-6">
                        <h1><b class="text-info" id="grand_total">0.00</b></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/popper.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<!-- simplebar js -->
<script src="../assets/plugins/simplebar/js/simplebar.js"></script>
<script src="../assets/js/datatables.min.js"></script>
<script src="../assets/js/dataTables.bootstrap4.js"></script>
<script src="../assets/js/toastr.min.js"></script>
<!-- sidebar-menu js -->
<script src="../assets/js/sidebar-menu.js"></script>
<!-- loader scripts -->
<script src="../assets/js/jquery.loading-indicator.js"></script>
<!-- Custom scripts -->
<script src="../assets/js/app-script.js"></script>
<script src="../assets/js/functions.js"></script>

<script>
    $(document).ready(function() {
        setInterval(function() {
            Get_Grand_Total();
            Get_CUST_NAME();
            ITEMS_TABLE();
            DISCOUNTS_TABLE();
        }, 1000);
    });

    

    function getCookie(cookieName) {
        var name = cookieName + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var cookieArray = decodedCookie.split(';');
        for (var i = 0; i < cookieArray.length; i++) {
            var cookie = cookieArray[i].trim();
            if (cookie.indexOf(name) === 0) {
                return cookie.substring(name.length, cookie.length);
            }
        }
        return "";
    }

    function Get_Grand_Total() {
        var grandTotal = getCookie('Grand_Total');
        if (grandTotal !== null) {
            document.getElementById('grand_total').innerText = grandTotal;
        }
    }

    function Get_CUST_NAME() {
        var custName = getCookie('CUST_NAME');
        if (custName !== null) {
            document.getElementById('emp_name').innerText = custName;
        }
    }

    function ITEMS_TABLE() {
        var itemName = getCookie('ITEM_NAME');
        var itemPrice = getCookie('ITEM_PRICE');
        var itemQty = getCookie('ITEM_QTY');

        // Consolidate the cookie data into an object
        var cookieData = {
            ITEM_NAME: itemName,
            ITEM_PRICE: itemPrice,
            ITEM_QTY: itemQty
        };

        // Function to parse cookie data
        function parseCookieData(cookieData) {
            const itemNames = cookieData.ITEM_NAME.split(',');
            const itemPrices = cookieData.ITEM_PRICE.split(',');
            const itemQtys = cookieData.ITEM_QTY.split(',');

            const resultArray = [];

            for (let i = 0; i < itemNames.length; i++) {
                const itemArray = [
                    `no.${i + 1}`,
                    itemNames[i],
                    itemPrices[i],
                    itemQtys[i],
                    (itemPrices[i] * itemQtys[i]).toFixed(2)  // Calculate total for each item
                ];
                resultArray.push(itemArray);
            }

            return resultArray;
        }

        // Process the cookie data
        const resultArray = parseCookieData(cookieData);

        // Output the result
        console.log(resultArray);

        // Insert rows into the orders table
        insertRowsIntoTable(resultArray, 'orders_tbl');
    }

    function DISCOUNTS_TABLE() {
        var discounts = getCookie('DISCOUNTS');

        // Assuming the discounts are stored in a comma-separated format
        var discountArray = discounts.split(',');

        // Process the discounts data into a 2D array
        const resultArray = discountArray.map(discount => [discount, '<h5>1</h5>']);

        // Output the result
        console.log(resultArray);

        // Insert rows into the discounts table
        insertRowsIntoTable(resultArray, 'disc_tbl');
    }

    function insertRowsIntoTable(dataArray, tableId) {
        const tableBody = document.getElementById(tableId);
        tableBody.innerHTML = '';  // Clear existing rows
        dataArray.forEach(rowData => {
            const row = document.createElement('tr');
            rowData.forEach(cellData => {
                const cell = document.createElement('td');
                if (cellData === '<h5>1</h5>') {
                    cell.innerHTML = cellData;
                } else if (cellData === '---') {
                    cell.innerHTML = '<b>---</b>';
                } else if (!isNaN(cellData)) {
                    cell.innerHTML = `<b>${cellData}</b>`;
                } else {
                    cell.textContent = cellData;
                }
                row.appendChild(cell);
            });
            tableBody.appendChild(row);
        });
    }
</script>

</body>
</html>
