<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Table</title>
</head>
<body>
    <table id="orders_tbl" border="1">
        <thead>
            <tr>
                <th>No.</th>
                <th>Item Name</th>
                <th>Item Price</th>
                <th>Item Quantity</th>
                <th>---</th>
            </tr>
        </thead>
        <tbody>
            <!-- Rows will be inserted here -->
        </tbody>
    </table>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Function to get a cookie by name
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

            // Retrieve and display the cookie values
            var custName = getCookie('CUST_NAME');
            console.log("CUST_NAME : " + custName);

            var transID = getCookie('TRANS_ID');
            console.log("TRANS ID : " + transID);

            var grandTotal = getCookie('Grand_Total');
            console.log("Grand_Total : " + grandTotal);

            var discounts = getCookie('DISCOUNTS');
            console.log("DISCOUNTS : " + discounts);

            var itemName = getCookie('ITEM_NAME');
            console.log("ITEM_NAME : " + itemName);

            var itemID = getCookie('ITEM_ID');
            console.log("ITEM_ID : " + itemID);

            var itemQty = getCookie('ITEM_QTY');
            console.log("ITEM_QTY : " + itemQty);

            var itemPrice = getCookie('ITEM_PRICE');
            console.log("ITEM_PRICE : " + itemPrice);

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
                        '---'
                    ];
                    resultArray.push(itemArray);
                }

                return resultArray;
            }

            // Process the cookie data
            const resultArray = parseCookieData(cookieData);

            // Output the result
            console.log(resultArray);

            // Function to insert rows into the table
            function insertRowsIntoTable(dataArray) {
                const tableBody = document.getElementById('orders_tbl').getElementsByTagName('tbody')[0];
                dataArray.forEach(rowData => {
                    const row = document.createElement('tr');
                    rowData.forEach(cellData => {
                        const cell = document.createElement('td');
                        if (cellData === '---') {
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

            // Insert rows into the table
            insertRowsIntoTable(resultArray);
        });
    </script>
</body>
</html>
