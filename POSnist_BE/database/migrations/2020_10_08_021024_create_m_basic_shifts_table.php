
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMBasicShiftsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_basic_shifts", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('shop_id')->nullable()->unsigned(); //店舗ID
						$table->string('name',30)->nullable(); //シフト名
						$table->time('start_time')->nullable(); //開始時間
						$table->time('end_time')->nullable(); //終了時間
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("shop_id")->references("id")->on("m_shops");



						// ----------------------------------------------------
						// -- SELECT [m_basic_shifts]--
						// ----------------------------------------------------
						// $query = DB::table("m_basic_shifts")
						// ->leftJoin("m_shops","m_shops.id", "=", "m_basic_shifts.shop_id")
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
                Schema::dropIfExists("m_basic_shifts");
            }
        }
    