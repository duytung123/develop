
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMShopsPaymentsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_shops_payments", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('shop_id')->nullable()->unsigned(); //店舗ID
						$table->string('name',30)->nullable(); //支払方法名称
						$table->bigInteger('sort')->nullable(); //表示順
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("shop_id")->references("id")->on("m_shops");



						// ----------------------------------------------------
						// -- SELECT [m_shops_payments]--
						// ----------------------------------------------------
						// $query = DB::table("m_shops_payments")
						// ->leftJoin("m_shops","m_shops.id", "=", "m_shops_payments.shop_id")
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
                Schema::dropIfExists("m_shops_payments");
            }
        }
    