<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Month;
use App\Models\Member;
use App\Models\Notice;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Adjustment;
use App\Models\MemberMonth;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $floor = ['Ground Floor','1st Floor','2nd Floor'];
        $status = ['pending','active','inactive','deleted','banned','restricted'];
        $rent = [800,850,900,950,1000];
        $amount = [500,1000,1500,2000];

        User::create([
            'name'      => 'Md. Maksuduzzaman Maun',
            'email'     => 'heemaun@gmail.com',
            'phone'     => '01751430596',
            'status'    => 'active',
            'password'  => Hash::make('11111111'),
        ]);

        User::create([
            'name'      => 'Guest',
            'email'     => 'guest@gmail.com',
            'phone'     => '11111111111',
            'status'    => 'active',
            'password'  => Hash::make('guest123'),
        ]);

        for($x=0;$x<5;$x++){
            User::create([
                'name'      => $faker->name(),
                'email'     => $faker->email(),
                'phone'     => $faker->e164PhoneNumber(),
                'status'    => $faker->randomElement(['pending','active','deleted','banned','restricted']),
                'password'  => Hash::make('11111111'),
            ]);
        }

        for($x=2023;$x<2024;$x++){
            for($y=1;$y<=12;$y++){
                Month::create([
                    'user_id'       => rand(1,count(User::all())),
                    'name'          => date('Y-m',strtotime($x.'-'.$y)),
                    'status'        => 'active',
                ]);
            }
        }

        for($x=0;$x<50;$x++){
            $member = Member::create([
                'user_id'           => rand(1,count(User::all())),
                'name'              => $faker->name(),
                'phone'             => $faker->e164PhoneNumber(),
                'email'             => $faker->email(),
                'image'             => '',
                'initial_balance'   => rand(0,1000),
                'current_balance'   => rand(0,1000),
                'joining_date'      => $faker->date(),
                'floor'             => $floor[rand(0,2)],
                'status'            => 'active',
            ]);

            if(strcmp($member->status,'deleted')==0){
                $member->leaving_date = $faker->date();
                $member->save();
            }
        }

        foreach(Month::where('status','active')->get() as $month){
            foreach(Member::where('status','active')->get() as $member){
                MemberMonth::create([
                    'user_id'           => rand(1,count(User::all())),
                    'member_id'         => $member->id,
                    'month_id'          => $month->id,
                    'due'               => rand(500,1000),
                    'rent_this_month'   => $rent[rand(0,4)],
                ]);
            }
        }

        for($x=0;$x<600;$x++){
            Payment::create([
                'user_id'           => rand(1,count(User::all())),
                'member_month_id'   => rand(1,count(MemberMonth::all())),
                'amount'            => $amount[rand(0,3)],
                'note'              => $faker->text(),
                'status'            => $faker->randomElement(['pending','active','inactive','deleted']),
                'created_at'        => $faker->dateTime(),
            ]);
        }

        for($x=0;$x<500;$x++){
            Adjustment::create([
                'user_id'           => rand(1,count(User::all())),
                'member_month_id'   => rand(1,count(MemberMonth::all())),
                'type'              => $faker->randomElement(['fine','adjustment']),
                'amount'            => $amount[rand(0,3)],
                'note'              => $faker->text(),
                'status'            => $faker->randomElement(['pending','active','inactive','deleted']),
                'created_at'        => $faker->dateTime(),
            ]);
        }

        for($x=0;$x<5;$x++){
            Notice::create([
                'user_id'   => rand(1,count(User::all())),
                'heading'   => $faker->text(),
                'body'      => $faker->paragraph(),
                'status'    => $faker->randomElement(['pending','active','inactive','deleted']),
            ]);
        }

        Setting::create([
            'key'       => 'Ground Floor Rent',
            'value'     => 850,
            'user_id'   => 1
        ]);

        Setting::create([
            'key'       => '1st Floor Rent',
            'value'     => 900,
            'user_id'   => 1
        ]);

        Setting::create([
            'key'       => '2nd Floor Rent',
            'value'     => 900,
            'user_id'   => 1
        ]);
    }
}
