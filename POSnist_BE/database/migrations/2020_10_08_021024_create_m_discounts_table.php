
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMDiscountsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_discounts", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('shop_id')->nullable()->unsigned(); //店舗ID
						$table->string('name',30)->nullable(); //割引名称
						$table->string('discount_cd',2)->nullable(); //割値引コード
						$table->string('discount_type',1)->nullable(); //割値引区分
						$table->bigInteger('discount')->nullable(); //割値引値
						$table->integer('sort')->nullable(); //表示順
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("shop_id")->references("id")->on("m_shops");



						// ----------------------------------------------------
						// -- SELECT [m_discounts]--
						// ----------------------------------------------------
						// $query = DB::table("m_discounts")
						// ->leftJoin("m_shops","m_shops.id", "=", "m_discounts.shop_id")
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
                Schema::dropIfExists("m_discounts");
            }
        }
    