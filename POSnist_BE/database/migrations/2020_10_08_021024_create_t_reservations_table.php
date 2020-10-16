
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateTReservationsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("t_reservations", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('customer_id')->nullable()->unsigned(); //顧客ID
						$table->bigInteger('shop_id')->nullable()->unsigned(); //店舗ID
						$table->datetime('reservation_time')->nullable(); //予約時間
						$table->bigInteger('treatment_id')->nullable()->unsigned(); //施術台ID
						$table->bigInteger('equipment_id')->nullable()->unsigned(); //機材ID
						$table->bigInteger('staff_id')->nullable()->unsigned(); //担当者ID
						$table->bigInteger('treatments_time')->nullable(); //全施術時間
						$table->string('web_reservation_flg',1)->nullable(); //web予約フラグ
						$table->string('prepaid_flg',1)->nullable(); //事前決済フラグ
						$table->string('visit_flg',1)->nullable(); //来店フラグ
						$table->string('payment_flg',1)->nullable(); //支払フラグ
						$table->string('cancel_flg',1)->nullable(); //キャンセルフラグ
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("customer_id")->references("id")->on("m_customers");
						//$table->foreign("shop_id")->references("id")->on("m_shops");
						//$table->foreign("treatment_id")->references("id")->on("m_equipments");
						//$table->foreign("equipment_id")->references("id")->on("m_equipments");
						//$table->foreign("staff_id")->references("id")->on("m_staffs");



						// ----------------------------------------------------
						// -- SELECT [t_reservations]--
						// ----------------------------------------------------
						// $query = DB::table("t_reservations")
						// ->leftJoin("m_customers","m_customers.id", "=", "t_reservations.customer_id")
						// ->leftJoin("m_shops","m_shops.id", "=", "t_reservations.shop_id")
						// ->leftJoin("m_equipments","m_equipments.id", "=", "t_reservations.treatment_id")
						// ->leftJoin("m_equipments","m_equipments.id", "=", "t_reservations.equipment_id")
						// ->leftJoin("m_staffs","m_staffs.id", "=", "t_reservations.staff_id")
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
                Schema::dropIfExists("t_reservations");
            }
        }
    