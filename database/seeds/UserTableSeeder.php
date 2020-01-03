<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $today = new DateTime();
        

        DB::table('users')->insert([
            'name' => 'Test',
            'email' => 'test@test.com',
            'password' => bcrypt('test12345'),
            'city' => 'Test',
            'street'  => 'Test 1',
            'doorCode'  => '123456',
            'postalCode'  => '123456',
            'telephoneNumber'  => '07012345678',
            'telephoneNumberDriver'  => '07012345678',
            'additionalInfo'  => 'Test',            
            'interval'  => 'eachWeek',
            'startDate'  => $today->format('Y-m-d'),
            'skipDate'  => '',
            'extraProductCurrent'  => '0, 0, 0',
            'extraProductNext'  => '0, 0, 0',
            'extraProductPrice'  => '0',
            'dinnerProduct'  => '1',
            'dinnerProductAlternative'  => '',
            'dinnerProductAlternativePrice'  => '0',
            'dinnerProductAmount'  => '1',
            'dinnerProductPrice'  => '720',
            'payexID'  => '',
            'payed' => false,
            'active'  => '1',
            'role'  => 'User']);
    }
}
