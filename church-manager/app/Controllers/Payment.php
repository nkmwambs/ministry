<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Payment extends BaseController
{

    public function __construct() {
        parent::__construct();
        $this->load->library('PaymentLibrary');
        $this->load->model('PaymentModel'); // If you have a model for handling payment data
    }

    public function initiate_payment() {

        // Assuming you get amount and phone number from a form submission
        $amount = $this->input->post('amount');
        $phoneNumber = $this->input->post('phone'); 

        // Call the Mpesa library's stkPush method
        $response = $this->PaymentLibrary->stkPush($amount, $phoneNumber);


        // Handle the response
        if ($response) {
            // Process the response, log it, update the database, etc.
            // Redirect or load a view for success
            $this->session->set_flashdata('success', 'Payment initiated successfully.');
            redirect('payments/success');
        } else {
            // Handle the error case
            $this->session->set_flashdata('error', 'Payment failed. Please try again.');
            redirect('payments/failure');
        }
    }

    public function success() {
        $this->load->view('payment_success');
    }

    public function failure() {
        $this->load->view('payment_failure');
    }
}
?>