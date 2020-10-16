
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMStaffShiftsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_staff_shifts", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('staff_id')->nullable()->unsigned(); //スタッフID
						$table->bigInteger('basicshift_id')->nullable(); //基本シフトID
						$table->date('day')->nullable(); //日付
						$table->time('start_time')->nullable(); //開始時間
						$table->time('end_time')->nullable(); //終了時間
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("id")->references("id")->on("m_staffs");
						//$table->foreign("basicshift_id")->references("id")->on("m_basic_shifts");



						// ----------------------------------------------------
						// -- SELECT [m_staff_shifts]--
						// ----------------------------------------------------
						// $query = DB::table("m_staff_shifts")
						// ->leftJoin("m_staffs","m_staffs.id", "=", "m_staff_shifts.id")
						// ->leftJoin("m_basic_shifts","m_basic_shifts.id", "=", "m_staff_shifts.basicshift_id")
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
                Schema::dropIfExists("m_staff_shifts");
            }
        }
    