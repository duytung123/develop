
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMUsersTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_users", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('company_id')->nullable()->unsigned(); //会社ID
						$table->bigInteger('shop_id')->nullable()->unsigned(); //店舗ID
						$table->string('name',30)->nullable(); //名前
						$table->string('email',255)->nullable(); //E-mail
						$table->string('login_id',30)->nullable(); //ログインID
						$table->string('password',255)->nullable(); //パスワード
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						

                    //*********************************
                    // Foreign KEY [ Uncomment if you want to use!! ]
                    //*********************************
                        //$table->foreign("company_id")->references("id")->on("m_companies");
						//$table->foreign("shop_id")->references("id")->on("m_shops");



						// ----------------------------------------------------
						// -- SELECT [m_users]--
						// ----------------------------------------------------
						// $query = DB::table("m_users")
						// ->leftJoin("m_companies","m_companies.id", "=", "m_users.company_id")
						// ->leftJoin("m_shops","m_shops.id", "=", "m_users.shop_id")
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
                Schema::dropIfExists("m_users");
            }
        }
    