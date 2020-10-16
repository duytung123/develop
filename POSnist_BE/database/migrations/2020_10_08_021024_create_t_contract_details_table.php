
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateTContractDetailsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("t_contract_details", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('contract_id')->nullable()->unsigned(); //契約ID
						$table->bigInteger('sales_id')->nullable()->unsigned(); //売上ID
						$table->integer('number_count')->nullable(); //現在回数
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("contract_id")->references("id")->on("t_contracts");
						//$table->foreign("sales_id")->references("id")->on("t_sales");



						// ----------------------------------------------------
						// -- SELECT [t_contract_details]--
						// ----------------------------------------------------
						// $query = DB::table("t_contract_details")
						// ->leftJoin("t_contracts","t_contracts.id", "=", "t_contract_details.contract_id")
						// ->leftJoin("t_sales","t_sales.id", "=", "t_contract_details.sales_id")
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
                Schema::dropIfExists("t_contract_details");
            }
        }
    