$(document).ready(function () 
{
    function calculateTotal()
    {
        let qty = parseInt($(this).closest('tr').find('.qty').val());
        let price = parseFloat($(this).closest('tr').find('.price').val());
        let subTotal = price * qty;

        if (isNaN(subTotal)) {
            subTotal = 0;
        } else {
            $(this).closest('tr').find('.sub-total').val(subTotal);
        }
        
        let total = 0;

        $("#productTable tbody tr").each(function () {
            let value = parseFloat($(this).closest('tr').find('.sub-total').val());

            if (!isNaN(value)) {
                total += value;
            }
        });

        $("#total").val(total);
    }

    function deleteProduct(id)
    {
        if (id != undefined) {
            $.ajax({
                type: "DELETE",
                url: "/products/" + id,
                dataType: "JSON",
                success: function (response) {
                    if (response.success) {
                        alert("Product successfully deleted");
                    }
                }
            });
        }
    }

    $("#productTable tbody").on("keyup change", '[data-action="calculateTotal"]', calculateTotal);

    $(".addField").click(function() {
        var rowHTML = `
            <tr class="text-center">
                <td>
                    <input type="text" class="form-control" name="product_names[]" required>
                </td>
                <td>
                    <input type="number" class="form-control qty" name="product_quantities[]" data-action="calculateTotal" required>
                </td>
                <td>
                    <input type="number" class="form-control price" name="product_prices[]" data-action="calculateTotal" required>
                </td>
                <td>
                    <input type="text" class="form-control sub-total" name="sub_totals[]" readonly>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger deleteField">-</button>
                </td>
            </tr>`;

        $("#productTable tbody").append(rowHTML);
    });

    $("#productTable").on('click','.deleteField',function(){
        $(this).parent().parent().remove();
        calculateTotal();
        deleteProduct($(this).attr("data-id"));
    });
});