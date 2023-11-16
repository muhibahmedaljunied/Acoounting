<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

       
        DB::table('roles')->insert([
            'id'       => 1,
            'name'   => "Admin",
            'status'   => 1,
        ]);

        DB::table('roles')->insert([
            'id'       => 3,
            'name'   => "Customer",
            'status'   => 1,
        ]);

        DB::table('users')->insert([
            'id'        => 1,
            'role_id'    => 1,
            'name'    => "مهيب الجنيد",
            'phone'  => "776165784",
            'email'     => 'muhib@gmail.com',
            'email_verified_at' => now(),
            'address'    => "taiz",
            'password'  => bcrypt('12345678'),
            'status'    => 1,
            'remember_token' => '13131313',

        ]);

        DB::table('users')->insert([
            'id'        => 2,
            'role_id'    => 1,
            'name'    => "محمد عامر",
            'phone'  => "738017689",
            'email'     => 'muhamed@gmail.com',
            'email_verified_at' => now(),
            'address'    => "sana'a",
            'password'  => bcrypt('12345678'),
            'status'    => 1,
            'remember_token' => '12313131313',

        ]);
     
        // -----------------------------------------------------------------------------------------

        // DB::table('banks')->insert([
        //     'id'        => 1,
        //     'name'    => 'بنك التضامن',

        // ]);

        // DB::table('banks')->insert([
        //     'id'        => 2,
        //     'name'    => 'بنك الانشاء والتعمير',

        // ]);

        // DB::table('banks')->insert([
        //     'id'        => 3,
        //     'name'    => 'بنك سباء',

        // ]);
        // // ------------------------------------------------------
        // DB::table('treasuries')->insert([
        //     'id'        => 1,
        //     'name'    => 'الصندوق الريسي',

        // ]);

        // DB::table('treasuries')->insert([
        //     'id'        => 2,
        //     'name'    => 'صندوق حده',

        // ]);

        // DB::table('treasuries')->insert([
        //     'id'        => 1,
        //     'name'    => 'تالف',

        // ]);

        // --------------------------------------------------
        DB::table('currencies')->insert([
            'id'        => 1,
            'name'    => 'ريال يمني',
            'symbole' => 'YER',
            'rate' => '1',

        ]);
        DB::table('currencies')->insert([
            'id'        => 2,
            'name'    => 'دولار امريكي',
            'symbole' => 'USD',
            'rate' => '600',

        ]);
        DB::table('currencies')->insert([
            'id'        => 3,
            'name'    => 'ريال سعودي',
            'symbole' => 'SAR',
            'rate' => '150',

        ]);
        // ----------------------------------------------------------------------------------------------------------
        DB::table('statuses')->insert([
            'id'        => 1,
            'name'    => 'تالف',

        ]);


        DB::table('statuses')->insert([
            'id'        => 2,
            'name'    => 'جديد',

        ]);

        DB::table('statuses')->insert([
            'id'        => 3,
            'name'    => 'مستخدم',

        ]);

        DB::table('statuses')->insert([
            'id'        => 4,
            'name'    => 'سليم',

        ]);

        DB::table('statuses')->insert([
            'id'        => 5,
            'name'    => 'عطلان',

        ]);

        // -------------------------------------Staff---------------------------------------------------------

        DB::table('branches')->insert([
            'id'        => 1,
            'name'    => 'تعز',

        ]);
        DB::table('branches')->insert([
            'id'        => 2,
            'name'    => 'صنعاء',

        ]);
        DB::table('branches')->insert([
            'id'        => 3,
            'name'    => 'اب',

        ]);
        DB::table('branches')->insert([
            'id'        => 4,
            'name'    => 'عدن',

        ]);
        //     // -----------------------------departments---------------------------
        // DB::table('departments')->insert([
        //     'id'        => 1,
        //     'name'    => 'حاسوب',

        // ]);
        // DB::table('departments')->insert([
        //     'id'        => 2,
        //     'name'    => 'هندسه',

        // ]);
        //   -----------------------job----------------------------------

        // DB::table('jobs')->insert([
        //     'id'        => 1,
        //     'name'    => 'IT',

        // ]);
        // DB::table('jobs')->insert([
        //     'id'        => 2,
        //     'name'    => 'computer',

        // ]);
        //   -----------------------stafftype----------------------------------

        DB::table('staff_types')->insert([
            'id'        => 1,
            'name'    => 'رسمي',

        ]);
        DB::table('staff_types')->insert([
            'id'        => 2,
            'name'    => 'متعاقد',

        ]);
        //   -----------------------qualification----------------------------------

        DB::table('qualifications')->insert([
            'id'        => 1,
            'name'    => 'بكلوريوس',

        ]);
        DB::table('qualifications')->insert([
            'id'        => 2,
            'name'    => 'ماجستر',

        ]);
        //   -----------------------absence_type----------------------------------

        DB::table('absence_types')->insert([
            'id'        => 1,
            'name'    => 'يوم السبت',

        ]);
        DB::table('absence_types')->insert([
            'id'        => 2,
            'name'    => 'يوم الخميس',

        ]);

        DB::table('absence_types')->insert([
            'id'        => 3,
            'name'    => 'بعد عطله اسبوعيه',

        ]);

        DB::table('absence_types')->insert([
            'id'        => 4,
            'name'    => 'بعد اجازه رسميه',

        ]);


        //   -----------------------allowance----------------------------------

        DB::table('allowance_types')->insert([
            'id'        => 1,
            'name'    => 'بدل مواصلات',

        ]);
        DB::table('allowance_types')->insert([
            'id'        => 2,
            'name'    => 'بدل سكن',

        ]);
        DB::table('allowance_types')->insert([
            'id'        => 3,
            'name'    => 'تغذيه',

        ]);



        //   -----------------------allowance----------------------------------

        //  DB::table('allowances')->insert([
        //     'id'        => 1,
        //     'staff_id'    => 1,
        //     'name'    => 'بدل سكن',
        //     'allowance_type_id'=>1

        // ]);
        // DB::table('allowances')->insert([
        //     'id'        => 2,
        //     'staff_id'    => 1,
        //     'name'    => 'بدل مواصلات',
        //     'allowance_type_id'=>1

        // ]);

        //   -----------------------delay_types----------------------------------
        DB::table('delay_types')->insert([
            'id'        => 1,
            'name'    => 'يوم السبت',

        ]);
        DB::table('delay_types')->insert([
            'id'        => 2,
            'name'    => 'يوم الخميس',

        ]);

        //   -----------------------parts----------------------------------
        DB::table('parts')->insert([
            'id'        => 1,
            'name'    => ' ربع ساعه',
            'duration' =>  15


        ]);
        DB::table('parts')->insert([
            'id'        => 2,
            'name'    => 'نص ساعه',
            'duration'=>30

        ]);
        //   -----------------------extra_types----------------------------------

        DB::table('extra_types')->insert([
            'id'        => 1,
            'name'    => 'قبل الدوام',

        ]);
        DB::table('extra_types')->insert([
            'id'        => 2,
            'name'    => 'بعد الدوام',

        ]);

        DB::table('extra_types')->insert([
            'id'        => 3,
            'name'    => 'يوم عطله رسميه',

        ]);

        DB::table('extra_types')->insert([
            'id'        => 4,
            'name'    => 'يوم عطله اسبوعيه',

        ]);


      
        //   -----------------------leave_types----------------------------------

        DB::table('leave_types')->insert([
            'id'        => 1,
            'name'    => 'يوم السبت',


        ]);
        DB::table('leave_types')->insert([
            'id'        => 2,
            'name'    => 'يوم الخميس',


        ]);



        //   -----------------------discount_types----------------------------------

        DB::table('discount_types')->insert([
            'id'        => 1,
            'name'    => 'سداد سلفه',

        ]);
        DB::table('discount_types')->insert([
            'id'        => 2,
            'name'    => 'مخالفه قوانين',

        ]);

        DB::table('discount_types')->insert([
            'id'        => 3,
            'name'    => 'جزاء',

        ]);
        //   -----------------------units----------------------------------

        DB::table('units')->insert([
            'id'        => 1,
            'name'    => 'كرتون',

        ]);
        DB::table('units')->insert([
            'id'        => 2,
            'name'    => 'قطعه',

        ]);

        DB::table('units')->insert([
            'id'        => 3,
            'name'    => 'حبه',

        ]);
        DB::table('units')->insert([
            'id'        => 4,
            'name'    => 'كيلو',

        ]);
        DB::table('units')->insert([
            'id'        => 5,
            'name'    => 'جرام',

        ]);
        DB::table('units')->insert([
            'id'        => 6,
            'name'    => 'متر',

        ]);

        //   -----------------------official_holidays----------------------------------
        // DB::table('official_holidays')->insert([
        //     'id'        => 1,
        //     'name'    => 'عيد الفطر',
        //     'from_date'      =>'',
        //     'into_date'      =>''


        // ]);
        // DB::table('official_holidays')->insert([
        //     'id'        => 2,
        //     'name'    => 'عيد الاضحي',
        //     'from_date'      =>'',
        //     'into_date'      =>''

        // ]);
        // DB::table('official_holidays')->insert([
        //     'id'        => 3,
        //     'name'    => 'عطله اسبوعيه',
        //     'from_date'      =>'',
        //     'into_date'      =>''

        // ]);
        // DB::table('official_holidays')->insert([
        //     'id'        => 4,
        //     'name'    => 'عيد 22 مايو',
        //     'from_date'      =>'',
        //     'into_date'      =>''

        // ]);
        // DB::table('official_holidays')->insert([
        //     'id'        => 5,
        //     'name'    => 'عيد 14 اكتوبر',
        //     'from_date'      =>'',
        //     'into_date'      =>''

        // ]);

        // DB::table('official_holidays')->insert([
        //     'id'        => 6,
        //     'name'    => 'عيد 30 نوفمبر',
        //     'from_date'      =>'',
        //     'into_date'      =>''

        // ]);
        // DB::table('official_holidays')->insert([
        //     'id'        => 7,
        //     'name'    => 'عيد 26 سبتمبر',
        //     'from_date'      =>'',
        //     'into_date'      =>''

        // ]);
        //   -----------------------extra_types----------------------------------

        DB::table('vacation_types')->insert([
            'id'        => 1,
            'name'    => 'مرضيه',
            'duration' => 30,


        ]);
        DB::table('vacation_types')->insert([
            'id'        => 2,
            'name'    => 'زواج',
            'duration' => 14,

        ]);
        DB::table('vacation_types')->insert([
            'id'        => 3,
            'name'    => 'ولاد',
            'duration' => 7,

        ]);
        DB::table('vacation_types')->insert([
            'id'        => 4,
            'name'    => 'وفاه',
            'duration' => 5,

        ]);
        
        // ---------------------------------------
        //   -----------------------personality----------------------------------

        DB::table('nationalities')->insert([
            'id'        => 1,
            'name'    => 'اليمن',

        ]);
        DB::table('nationalities')->insert([
            'id'        => 2,
            'name'    => 'السعوديه',

        ]);
        //   -----------------------relgion----------------------------------

        DB::table('staff_religions')->insert([
            'id'        => 1,
            'name'    => 'مسلم',

        ]);
        DB::table('staff_religions')->insert([
            'id'        => 2,
            'name'    => 'مسيحي',

        ]);



        // --------------------------------------------------------------------
        DB::table('expence_types')->insert([
            'id'        => 1,
            'name'    => 'كهرباء',

        ]);

        DB::table('expence_types')->insert([
            'id'        => 2,
            'name'    => 'ايجار',

        ]);
        // ---------------------------------------------------------------------------
        DB::table('expences')->insert([
            'id'        => 1,
            'expence_type_id'    => '1',
            'quantity'    => '200000',


        ]);

        DB::table('expences')->insert([
            'id'        => 2,
            'expence_type_id'    => '2',
            'quantity'    => '200000',

        ]);

        // ----------------------------------------------------------------------------------

        DB::table('sanction_discounts')->insert([
            'id'        => 1,
            'name'    => 'من الراتب',


        ]);

        DB::table('sanction_discounts')->insert([
            'id'        => 2,
            'name'    => 'من الاضافي',


        ]);



        DB::table('sanction_discounts')->insert([
            'id'        => 3,
            'name'    => 'من الاجازه المرضيه',


        ]);



        DB::table('sanction_discounts')->insert([
            'id'        => 4,
            'name'    => 'من البدلات',


        ]);


        // --------------------------------WorkSyatem-------------------------------------------

        DB::table('work_types')->insert([
            'id'        => 1,
            'name'    => 'فتره',


        ]);


        DB::table('work_types')->insert([
            'id'        => 2,
            'name'    => 'فترتين',


        ]);

       
// -----------------------------------
        // DB::table('work_systems')->insert([
        //     'id'        => 1,
        //     'name'    => ' حراس امن',


        // ]);

        // DB::table('work_systems')->insert([
        //     'id'        => 2,
        //     'name'    => 'دوام  مدراء',


        // ]);

        // DB::table('work_systems')->insert([
        //     'id'        => 3,
        //     'name'    => 'فتره',


        // ]);



        // DB::table('work_systems')->insert([
        //     'id'        => 4,
        //     'name'    => 'فترتين',


        // ]);


      
        // --------------------------------periods-------------------------------------------
          DB::table('periods')->insert([
            'id'        => 1,
            'name'    => 'فتره صباحيه',
        



        ]);

        DB::table('periods')->insert([
            'id'        => 2,
            'name'    => 'فتره مسائيه',
           


        ]);


        DB::table('periods')->insert([
            'id'        => 3,
            'name'    => 'فتره ليليه',
           


        ]);

        // --------------------------------------------products--------------------------------------------------
        // DB::table('products')->insert([
        //     'id'        => 1,
        //     'parent_id'    => '',
        //     'text'=>'عصاير',
        //     'rank'=>''

        // ]);

        // DB::table('products')->insert([
        //     'id'        => 11,
        //     'parent_id'    => 1,
        //     'text'=>'يمني',
        //     'rank'=>1

        // ]);

        // DB::table('products')->insert([
        //     'id'        => 111,
        //     'parent_id'    => 11,
        //     'text'=>'هايل سعيد',
        //     'rank'=>2

        // ]);


        // DB::table('products')->insert([
        //     'id'        => 1111,
        //     'parent_id'    => 111,
        //     'text'=>'الهناء',
        //     'rank'=>3

        // ]);
        // -----------------------------------stores-----------------------------------------------------


        // DB::table('products')->insert([
        //     'id'        => 1,
        //     'parent_id'    => '',
        //     'text'=>'جدر',
        //     'rank'=>''

        // ]);

        // DB::table('products')->insert([
        //     'id'        => 11,
        //     'parent_id'    => 1,
        //     'text'=>'المخزن1',
        //     'rank'=>1

        // ]);

        // DB::table('products')->insert([
        //     'id'        => 12,
        //     'parent_id'    => 1,
        //     'text'=>'المخزن2',
        //     'rank'=>1

        // ]);
    }
}
