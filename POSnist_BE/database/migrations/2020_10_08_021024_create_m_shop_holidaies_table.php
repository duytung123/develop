
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMShopHolidaiesTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_shop_holidaies", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('shop_id')->nullable()->unsigned(); //店舗ID
						$table->string('holiday_type',1)->nullable(); //休日区分
						$table->date('day')->nullable(); //日付
						$table->string('monday',1)->nullable(); //月曜日
						$table->string('tuesday',1)->nullable(); //火曜日
						$table->string('wednesday',1)->nullable(); //水曜日
						$table->string('thursday',1)->nullable(); //木曜日
						$table->string('friday',1)->nullable(); //金曜日
						$table->string('saturday',1)->nullable(); //土曜日
						$table->string('sunday',1)->nullable(); //日曜日
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("shop_id")->references("id")->on("m_shops");



						// ----------------------------------------------------
						// -- SELECT [m_shop_holidaies]--
						// ----------------------------------------------------
						// $query = DB::table("m_shop_holidaies")
						// ->leftJoin("m_shops","m_shops.id", "=", "m_shop_holidaies.shop_id")
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
                Schema::dropIfExists("m_shop_holidaies");
            }
        }
    