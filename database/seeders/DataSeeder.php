<?php

namespace Database\Seeders;

use App\Models\Adjustment;
use App\Models\Member;
use App\Models\MemberMonth;
use App\Models\Month;
use App\Models\Notice;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

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
        for($x=0;$x<5;$x++){
            User::create([
                'name'      => $faker->name(),
                'email'     => $faker->email(),
                'phone'     => $faker->phoneNumber(),
                'status'    => $faker->randomElement(['pending','active','deleted','banned','restricted']),
                'password'  => Hash::make('11111111'),
            ]);
        }


        for($x=0;$x<50;$x++){
            $member = Member::create([
                'user_id'           => rand(1,6),
                'name'              => $faker->name(),
                'phone'             => $faker->phoneNumber(),
                'email'             => $faker->email(),
                'image'             => $faker->email(),
                'initial_balance'   => rand(0,1000),
                'current_balance'   => rand(0,1000),
                'joining_date'      => $faker->date(),
                'floor'             => $floor[rand(0,2)],
                'status'            => $status[rand(0,5)],
            ]);

            if(strcmp($member->status,'deleted')==0){
                $member->leaving_date = $faker->date();
                $member->save();
            }
        }

        for($x=0;$x<10;$x++){
            Month::create([
                'user_id'       => rand(1,6),
                'name'          => date('Y-m',strtotime(rand(2015,date('Y')).'-'.rand(1,12))),
                'status'        => 'active',
            ]);
        }

        foreach(Month::where('status','active')->get() as $month){
            foreach(Member::where('status','active')->get() as $member){
                MemberMonth::create([
                    'user_id'         => 1,
                    'member_id'         => $member->id,
                    'month_id'          => $month->id,
                    'due'               => rand(500,1000),
                    'rent_this_month'   => $rent[rand(0,4)],
                ]);
            }
        }

        for($x=0;$x<500;$x++){
            Payment::create([
                'user_id'           => rand(1,6),
                'member_month_id'   => rand(1,count(MemberMonth::all())),
                'amount'            => $amount[rand(0,3)],
                'note'              => $faker->text(),
                'status'            => $faker->randomElement(['pending','active','inactive','deleted']),
            ]);
        }

        for($x=0;$x<25;$x++){
            Adjustment::create([
                'user_id'           => rand(1,6),
                'member_month_id'   => rand(1,count(MemberMonth::all())),
                'type'              => $faker->randomElement(['fine','adjustment']),
                'amount'            => $amount[rand(0,3)],
                'status'            => $faker->randomElement(['pending','active','inactive','deleted']),
            ]);
        }

        for($x=0;$x<5;$x++){
            Notice::create([
                'user_id'   => rand(1,6),
                'heading'   => $faker->text(),
                'body'      => $faker->paragraph(),
                'status'    => $faker->randomElement(['pending','active','inactive','deleted']),
            ]);
        }
    }
}
