
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateTContractsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("t_contracts", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('customer_id')->nullable()->unsigned(); //顧客ID
						$table->bigInteger('course_id')->nullable(); //コースID
						$table->date('limit_date')->nullable(); //期限日
						$table->integer('count')->nullable(); //コース回数
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("customer_id")->references("id")->on("m_customers");



						// ----------------------------------------------------
						// -- SELECT [t_contracts]--
						// ----------------------------------------------------
						// $query = DB::table("t_contracts")
						// ->leftJoin("m_customers","m_customers.id", "=", "t_contracts.customer_id")
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
                Schema::dropIfExists("t_contracts");
            }
        }
    