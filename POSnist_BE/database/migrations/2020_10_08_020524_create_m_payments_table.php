
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMPaymentsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_payments", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->string('payment',30)->nullable(); //支払方法
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付



						// ----------------------------------------------------
						// -- SELECT [m_payments]--
						// ----------------------------------------------------
						// $query = DB::table("m_payments")
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
                Schema::dropIfExists("m_payments");
            }
        }
    