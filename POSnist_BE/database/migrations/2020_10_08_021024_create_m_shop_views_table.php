
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMShopViewsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_shop_views", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('shop_id')->nullable()->unsigned(); //店舗ID
						$table->string('name',30)->nullable(); //店舗名
						$table->string('log_img',30)->nullable(); //店舗ロゴ
						$table->string('postal_cd',10)->nullable(); //郵便番号
						$table->string('prefecture',10)->nullable(); //都道府県
						$table->string('city',50)->nullable(); //市区町村
						$table->string('area',50)->nullable(); //町域
						$table->string('address',50)->nullable(); //番地等
						$table->string('tel',12)->nullable(); //電話番号
						$table->timestamps(); //登録日付
						$table->timestamp('update_at')->nullable(); //更新日付
						$table->softDeletes(); //削除日付
						//$table->foreign("shop_id")->references("id")->on("m_shops");



						// ----------------------------------------------------
						// -- SELECT [m_shop_views]--
						// ----------------------------------------------------
						// $query = DB::table("m_shop_views")
						// ->leftJoin("m_shops","m_shops.id", "=", "m_shop_views.shop_id")
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
                Schema::dropIfExists("m_shop_views");
            }
        }
    