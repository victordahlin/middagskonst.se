<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        User::create([
            'name' => 'Victor',
            'email' => 'victordahlin@gmail.com',
            'password' => Hash::make('test1'),
            'city' => 'Stockholm',
            'street'  => 'Grindtorpsvägen 41',
            'doorCode'  => '',
            'postalCode'  => '',
            'telephoneNumber'  => '0706170379',
            'additionalInfo'  => '',
            'telephoneNumberDriver'  => '0706170379',
            'interval'  => 'eachWeek',
            'startDate'  => '2015-04-16',
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
            'active'  => '1',
            'role'  => 'User']);
    }
}
