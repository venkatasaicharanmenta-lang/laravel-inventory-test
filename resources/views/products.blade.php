<!DOCTYPE html>
<html>
<head>
    <title>Product Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">

<h2>Product Form</h2>

<form id="productForm">

    @csrf

    <label>Product Name:</label>
    <input type="text" name="product_name"><br><br>

    <label>Quantity in Stock:</label>
    <input type="number" name="quantity"><br><br>

    <label>Price per Item:</label>
    <input type="number" step="0.01" name="price"><br><br>

    <button type="submit">Submit</button>
</form>
<h2>Product List</h2>

<table class="table table-bordered"
 cellpadding="10">
    <tr>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Date Time</th>
        <th>Total Value</th>
    </tr>

    @php $grandTotal = 0; @endphp

    @foreach($products as $product)
        @php
            $total = $product['quantity'] * $product['price'];
            $grandTotal += $total;
        @endphp

        <tr>
            <td>{{ $product['product_name'] }}</td>
            <td>{{ $product['quantity'] }}</td>
            <td>{{ $product['price'] }}</td>
            <td>{{ $product['datetime'] }}</td>
            <td>{{ $total }}</td>
        </tr>
    @endforeach

    <tr>
        <td colspan="4"><strong>Grand Total</strong></td>
        <td><strong>{{ $grandTotal }}</strong></td>
    </tr>
</table>
</div>
<script>
document.getElementById("productForm").addEventListener("submit", function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch("/store", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        location.reload();
    });
});
</script>

</body>
</html>
