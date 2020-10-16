
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMCustomersTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_customers", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('shop_id')->nullable()->unsigned(); //店舗ID
						$table->string('customer_no',15)->nullable(); //顧客No
						$table->string('firstname',10)->nullable(); //姓
						$table->string('lastname',10)->nullable(); //名
						$table->string('firstname_kana',20)->nullable(); //姓（ふりがな）
						$table->string('lastname_kana',20)->nullable(); //名（ふりがな）
						$table->string('sex',1)->nullable(); //性別
						$table->string('email',255)->nullable(); //E-mail
						$table->string('tel',12)->nullable(); //電話番号
						$table->string('login_id',255)->nullable(); //ログインID
						$table->string('password',255)->nullable(); //パスワード
						$table->bigInteger('staff_id')->nullable()->unsigned(); //担当ID
						$table->string('member_flg',1)->nullable(); //会員区分
						$table->string('customer_img',255)->nullable(); //顧客画像
						$table->string('postal_cd',10)->nullable(); //郵便番号
						$table->string('prefecture',10)->nullable(); //都道府県
						$table->string('city',50)->nullable(); //市区町村
						$table->string('area',50)->nullable(); //町域
						$table->string('address',50)->nullable(); //番地
						$table->string('language',3)->nullable(); //表示言語
						$table->bigInteger('visit_cnt')->nullable(); //来店回数
						$table->timestamp('first_visit')->nullable(); //初回来店日
						$table->timestamp('last_visit')->nullable(); //前回来店日
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("shop_id")->references("id")->on("m_shops");
						//$table->foreign("shop_id")->references("id")->on("m_shops");
						//$table->foreign("shop_id")->references("id")->on("m_shops");
						//$table->foreign("staff_id")->references("id")->on("m_staffs");



						// ----------------------------------------------------
						// -- SELECT [m_customers]--
						// ----------------------------------------------------
						// $query = DB::table("m_customers")
						// ->leftJoin("m_shops","m_shops.id", "=", "m_customers.shop_id")
						// ->leftJoin("m_shops","m_shops.id", "=", "m_customers.shop_id")
						// ->leftJoin("m_shops","m_shops.id", "=", "m_customers.shop_id")
						// ->leftJoin("m_staffs","m_staffs.id", "=", "m_customers.staff_id")
						// ->get();
						// dd($query); //For checking



                });
            }

            /**
             * Reverse the migrations.
             *
             * @return void
             */
            public function down()
            {
                Schema::dropIfExists("m_customers");
            }
        }
    