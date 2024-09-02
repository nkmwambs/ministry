<h2>Make a Payments</h2>

<table>
    <thead>
        <tr>
            <th>Transaction ID</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($payments as $payment): ?>
            <tr>
                <td><?php echo $payment['transaction_id']; ?></td>
                <td><?php echo $payment['amount']; ?></td>
                <td><?php echo $payment['status']; ?></td>
                <td><?php echo $payment['payment_date']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Make a Payment</h2>

<form action="<?php echo site_url('payments/make_payment'); ?>" method="post">
    <label for="amount">Amount:</label>
    <input type="text" name="amount" required>
    <button type="submit">Pay Now</button>
</form>
