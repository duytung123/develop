
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMReservReceptTimesTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_reserv_recept_times", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('shop_id')->nullable()->unsigned(); //店舗ID
						$table->string('recept_type',1)->nullable(); //受付タイプ
						$table->time('recept_start')->nullable(); //受付開始時間
						$table->time('recept_end')->nullable(); //受付終了時間
						$table->time('recept_start_mo')->nullable(); //受付開始時間（月）
						$table->time('recept_end_mo')->nullable(); //受付終了時間（月）
						$table->time('recept_start_tu')->nullable(); //受付開始時間（火）
						$table->time('recept_end_tu')->nullable(); //受付終了時間（火）
						$table->time('recept_start_we')->nullable(); //受付開始時間（水）
						$table->time('recept_end_we')->nullable(); //受付終了時間（水）
						$table->time('recept_start_th')->nullable(); //受付開始時間（木）
						$table->time('recept_end_th')->nullable(); //受付終了時間（木）
						$table->time('recept_start_fr')->nullable(); //受付開始時間（金）
						$table->time('recept_end_fr')->nullable(); //受付終了時間（金）
						$table->time('recept_start_sa')->nullable(); //受付開始時間（土）
						$table->time('recept_end_sa')->nullable(); //受付終了時間（土）
						$table->time('recept_start_su')->nullable(); //受付開始時間（日）
						$table->time('recept_end_su')->nullable(); //受付終了時間（日）
						$table->time('recept_start_ho')->nullable(); //受付開始時間（祝）
						$table->time('recept_end_ho')->nullable(); //受付終了時間（祝）
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("shop_id")->references("id")->on("m_shops");



						// ----------------------------------------------------
						// -- SELECT [m_reserv_recept_times]--
						// ----------------------------------------------------
						// $query = DB::table("m_reserv_recept_times")
						// ->leftJoin("m_shops","m_shops.id", "=", "m_reserv_recept_times.shop_id")
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
                Schema::dropIfExists("m_reserv_recept_times");
            }
        }
    