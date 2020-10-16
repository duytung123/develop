
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMStaffsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_staffs", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('shop_id')->nullable()->unsigned(); //店舗ID
						$table->string('name',20)->nullable(); //氏名
						$table->string('name_kana',40)->nullable(); //氏名（フリガナ）
						$table->string('staff_img',255)->nullable(); //画像名
						$table->string('sex',1)->nullable(); //性別
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("shop_id")->references("id")->on("m_shops");



						// ----------------------------------------------------
						// -- SELECT [m_staffs]--
						// ----------------------------------------------------
						// $query = DB::table("m_staffs")
						// ->leftJoin("m_shops","m_shops.id", "=", "m_staffs.shop_id")
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
                Schema::dropIfExists("m_staffs");
            }
        }
    