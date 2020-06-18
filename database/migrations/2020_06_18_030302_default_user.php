<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DefaultUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $user = new App\User();
        $user->password = Hash::make('123456');
        $user->email = 'test@test.com';
        $user->name = 'Giant Monkey Robot';
        $user->api_token = 'yQNEKsH0b0x1qllkk1W7czq6hKE62jdTckqj7GgU5IMYtElu4JTpuwl6ZHYj';
        $user->email_verified_at = time();
        $user->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
