<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode Scanner</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .card {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1px;
        }

        .card input {
            background-color: #d0eaff;
            border: 1px solid #007bff;
            border-radius: 4px;
            padding: 10px;
            margin: 2px;
            text-align: center;
            color: #007bff;
            flex: 1;
        }

        .card input.quantity {
            background-color: #b3d7ff;
        }

        .remove-button {
            background-color: #ff4d4d;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 11px;
            cursor: pointer;
            margin-left: 10px;
        }

        .remove-button:hover {
            background-color: #e60000;
        }

        #submitButton {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 20px;
            font-size: 16px;
        }

        #submitButton:hover {
            background-color: #0056b3;
        }
        
        .remove-button {
            background-color: #ff4d4d;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 11px;
            cursor: pointer;
            margin-left: 10px;
        }

        .remove-button:hover {
            background-color: #e60000;
        }

        #submitButton, #resetButton {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 20px;
            font-size: 16px;
            margin-right: 10px;
        }

        #submitButton:hover, #resetButton:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <h1>Barcode Scanner</h1>
    <form id="updInventory" method="post">
        <div id="itemCardContainer" class="card-container"></div>
        <button type="submit" id="submitButton">Submit</button>
        <button type="button" id="resetButton">Reset</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let barcode = '';

        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                if (barcode.length > 0) {
                    fetchItemData(barcode);
                    barcode = ''; // Clear the barcode after processing
                }
            } else {
                barcode += e.key; // Concatenate the key press to the barcode string
            }
        });

        function fetchItemData(barcode) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_item.php?item_code=' + encodeURIComponent(barcode), true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const item = JSON.parse(xhr.responseText);
                    if (item) {
                        addItemToCard(item);
                        saveItemsToLocalStorage();
                    }
                }
            };
            xhr.send();
        }

        function addItemToCard(item) {
            let existingCard = document.getElementById('item-' + item.item_code);
            if (existingCard) {
                let quantityField = existingCard.querySelector('.quantity');
                let currentQuantity = parseInt(quantityField.value) || 0;
                quantityField.value = currentQuantity + 1;
            } else {
                let card = document.createElement('div');
                card.className = 'card';
                card.id = 'item-' + item.item_code;
                card.innerHTML = `
                    <input type="text" name="pr_id[]" value="${item.pr_id}" placeholder="ID" readonly>
                    <input type="text" name="item_code[]" value="${item.item_code}" placeholder="Item Code" readonly>
                    <input type="text" name="sell_price[]" value="${item.sell_price}" placeholder="Selling Price" readonly>
                    <input type="text" name="quantity[]" class="quantity" value="1" placeholder="Quantity" readonly>
                    <input type="text" name="expiration_date[]" value="${item.expiration_date}" placeholder="Expiration Date" readonly>
                    <button class="remove-button" onclick="removeItem('${item.item_code}')">Remove</button>
                `;
                document.getElementById('itemCardContainer').appendChild(card);
            }
        }

        function removeItem(itemCode) {
            let card = document.getElementById('item-' + itemCode);
            if (card) {
                card.remove();
                saveItemsToLocalStorage();
            }
        }

        function saveItemsToLocalStorage() {
            const cards = document.querySelectorAll('.card');
            const items = Array.from(cards).map(card => {
                const inputs = card.querySelectorAll('input');
                return {
                    pr_id: inputs[0].value,
                    item_code: inputs[1].value,
                    sell_price: inputs[2].value,
                    quantity: inputs[3].value,
                    expiration_date: inputs[4].value
                };
            });
            localStorage.setItem('items', JSON.stringify(items));
        }

        function loadItemsFromLocalStorage() {
            const items = JSON.parse(localStorage.getItem('items')) || [];
            items.forEach(item => addItemToCard(item));
        }

        // Load items from local storage on page load
        loadItemsFromLocalStorage();

        $(document).ready(function() {
            $(document).on('submit', '#updInventory', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                Swal.fire({
                    title: 'Do you want to Update Product?',
                    showCancelButton: true,
                    confirmButtonText: 'Update',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "add_inventory.php",
                            data: formData,
                            success: function(response) {
                                var res = JSON.parse(response);
                                if (res.status == 400) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Something Went Wrong.',
                                        text: res.msg,
                                        timer: 3000
                                    });
                                } else if (res.status == 200) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'SUCCESS',
                                        text: res.msg,
                                        timer: 2000
                                    }).then(function() {
                                        // Remove all cards after successful submission
                                        document.getElementById('itemCardContainer').innerHTML = '';
                                        localStorage.removeItem('items');
                                    });
                                }
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info').then(function() {
                            location.reload();
                        });
                    }
                });
            });

            $('#resetButton').click(function() {
                Swal.fire({
                    title: 'Are you sure you want to reset?',
                    showCancelButton: true,
                    confirmButtonText: 'Reset',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Remove all cards and clear local storage
                        document.getElementById('itemCardContainer').innerHTML = '';
                        localStorage.removeItem('items');
                    }
                });
            });
        });
    </script>
</body>

</html>