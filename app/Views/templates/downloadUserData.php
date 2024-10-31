<div class="container">
    <h2>Download User Data</h2>
    <p>Click the button below to download the user data.</p>
    
    <form action="<?= site_url('users/downloadUserDataPdf/' . $user['id']) ?>" method="post">
        <button type="submit" class="btn btn-success">
            <i class="fa fa-download"></i> Download as PDF
        </button>
    </form>

    <form action="<?= site_url('users/downloadUserDataExcel/' . $user['id']) ?>" method="post" style="margin-top: 10px;">
        <button type="submit" class="btn btn-success">
            <i class="fa fa-download"></i> Download as Excel
        </button>
    </form>
</div>
