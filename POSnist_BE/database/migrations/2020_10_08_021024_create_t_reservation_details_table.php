
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateTReservationDetailsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("t_reservation_details", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('reservation_id')->nullable()->unsigned(); //予約ID
						$table->bigInteger('treatment_time')->nullable(); //施術時間
						$table->string('category_cd',2)->nullable(); //カテゴリーCD
						$table->bigInteger('menu_id')->nullable(); //メニューID
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("reservation_id")->references("id")->on("t_reservations");



						// ----------------------------------------------------
						// -- SELECT [t_reservation_details]--
						// ----------------------------------------------------
						// $query = DB::table("t_reservation_details")
						// ->leftJoin("t_reservations","t_reservations.id", "=", "t_reservation_details.reservation_id")
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
                Schema::dropIfExists("t_reservation_details");
            }
        }
    