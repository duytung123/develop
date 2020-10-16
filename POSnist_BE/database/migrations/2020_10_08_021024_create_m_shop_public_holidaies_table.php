
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMShopPublicHolidaiesTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_shop_public_holidaies", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('shop_id')->nullable()->unsigned(); //店舗ID
						$table->date('date')->nullable(); //祝日
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("shop_id")->references("id")->on("m_shops");



						// ----------------------------------------------------
						// -- SELECT [m_shop_public_holidaies]--
						// ----------------------------------------------------
						// $query = DB::table("m_shop_public_holidaies")
						// ->leftJoin("m_shops","m_shops.id", "=", "m_shop_public_holidaies.shop_id")
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
                Schema::dropIfExists("m_shop_public_holidaies");
            }
        }
    