<script>
document.addEventListener("DOMContentLoaded", function () {

    function updateInvoiceTotals() {
        let subtotal = 0;
        let totalTax = 0;

        document.querySelectorAll('#product_table tbody tr').forEach(row => {
            const qty = parseFloat(row.querySelector('.qty')?.value) || 0;
            const price = parseFloat(row.querySelector('.price')?.value) || 0;
            const taxPercent = parseFloat(row.querySelector('.tax')?.value) || 0;

            const productTotal = qty * price;
            const taxAmount = (productTotal * taxPercent) / 100;

            subtotal += productTotal;
            totalTax += taxAmount;
        });

        const grandTotal = subtotal + totalTax;

        const subtotalInput = document.getElementById('subtotal');
        const taxTotalInput = document.getElementById('tax_total');
        const grandTotalInput = document.getElementById('grand_total');

        if (subtotalInput) subtotalInput.value = subtotal.toFixed(2);
        if (taxTotalInput) taxTotalInput.value = totalTax.toFixed(2);
        if (grandTotalInput) grandTotalInput.value = grandTotal.toFixed(2);
    }

    function calculateRowTotal(row) {
        const qty = parseFloat(row.querySelector('.qty')?.value) || 0;
        const price = parseFloat(row.querySelector('.price')?.value) || 0;
        const taxPercent = parseFloat(row.querySelector('.tax')?.value) || 0;
        const productTotal = qty * price;
        const taxAmount = (productTotal * taxPercent) / 100;
        row.querySelector('.total').value = (productTotal + taxAmount).toFixed(2);
        updateInvoiceTotals();
    }

    document.querySelectorAll('.qty, .price, .tax').forEach(el => {
        el.addEventListener('input', function () {
            calculateRowTotal(this.closest('tr'));
        });
    });

    document.getElementById('add_row')?.addEventListener('click', function () {
        const tableBody = document.querySelector('#product_table tbody');
        const newRow = tableBody.rows[0].cloneNode(true);

        newRow.querySelectorAll('input').forEach(input => input.value = '');
        tableBody.appendChild(newRow);

        newRow.querySelectorAll('.qty, .price, .tax').forEach(el => {
            el.addEventListener('input', function () {
                calculateRowTotal(this.closest('tr'));
            });
        });

        newRow.querySelector('.remove_row').addEventListener('click', function () {
            this.closest('tr').remove();
            updateInvoiceTotals();
        });
    });

    document.querySelectorAll('.remove_row').forEach(btn => {
        btn.addEventListener('click', function () {
            if (document.querySelectorAll('#product_table tbody tr').length > 1) {
                this.closest('tr').remove();
                updateInvoiceTotals();
            }
        });
    });

    // Initial calculation on page load (e.g., during edit)
    document.querySelectorAll('#product_table tbody tr').forEach(row => {
        calculateRowTotal(row);
    });
});
</script>
