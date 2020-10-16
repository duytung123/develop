
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMReservReceptsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_reserv_recepts", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('shop_id')->nullable()->unsigned(); //店舗ID
						$table->string('reserv_interval',1)->nullable(); //予約間隔
						$table->string('recept_rest',1)->nullable(); //受付制限
						$table->integer('recept_amount')->nullable(); //受付可能数
						$table->string('cancel_setting_flg',1)->nullable(); //キャンセル設定
						$table->string('cancel_limit',2)->nullable(); //キャンセル期限
						$table->integer('future_reserv_num')->nullable(); //未来予約数
						$table->string('cancel_wait_flg',1)->nullable(); //キャンセル待ち
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("shop_id")->references("id")->on("m_shops");



						// ----------------------------------------------------
						// -- SELECT [m_reserv_recepts]--
						// ----------------------------------------------------
						// $query = DB::table("m_reserv_recepts")
						// ->leftJoin("m_shops","m_shops.id", "=", "m_reserv_recepts.shop_id")
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
                Schema::dropIfExists("m_reserv_recepts");
            }
        }
    