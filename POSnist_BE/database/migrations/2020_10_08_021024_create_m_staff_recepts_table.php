
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMStaffReceptsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_staff_recepts", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('staff_id')->nullable()->unsigned(); //スタッフID
						$table->integer('recept_amount')->nullable(); //受付数
						$table->string('web_flg',1)->nullable(); //予約可否
						$table->integer('nomination')->nullable(); //指名料
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("staff_id")->references("id")->on("m_staffs");



						// ----------------------------------------------------
						// -- SELECT [m_staff_recepts]--
						// ----------------------------------------------------
						// $query = DB::table("m_staff_recepts")
						// ->leftJoin("m_staffs","m_staffs.id", "=", "m_staff_recepts.staff_id")
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
                Schema::dropIfExists("m_staff_recepts");
            }
        }
    