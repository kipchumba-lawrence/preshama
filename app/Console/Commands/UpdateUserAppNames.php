<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserApp;
use App\Models\Customer;

class UpdateUserAppNames extends Command
{
    protected $signature = 'app:update-names';
    protected $description = 'Update user_app first_name with customer_name';

    public function handle()
    {
        // Get all UserApp records
        $users = UserApp::where('user_type', 'USER')->get();
        // Loop through each user and update the first_name field
        foreach ($users as $user) {

            // Retrieve the related customer record and update the first_name field in the UserApp table
            // $customer = Customer::find($user->customer_id);

            $customer = Customer::where('customer_id', $user->customer_id)->first();

            if ($customer) {
                // Assuming $user is the UserApp instance and $customer is the related Customer instance
                if ($customer) {
                    $nameParts = explode(' ', $customer->customer_name, 2); // Split customer_name into an array of parts (first word and the rest)

                    $user->first_name = $nameParts[0]; // Set first_name to the first word
                    $user->surname = isset($nameParts[1]) ? $nameParts[1] : null; // Set surname to the rest (if available)

                    $emailName = preg_replace("/[^a-zA-Z0-9]/", "", strtolower($customer->customer_name)); // Remove non-alphanumeric characters and convert to lowercase
                    $user->email = $emailName . "@preshama.com"; // Set the email

                    $user->save(); // Save the changes to the database
                }

                $user->save(); // Save the changes to the UserApp table
            }
        }

        $this->info('UserApp records updated successfully!');
    }
}
