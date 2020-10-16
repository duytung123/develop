
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMTaxesTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_taxes", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->string('name',30)->nullable(); //税率名
						$table->integer('tax')->nullable(); //税率
						$table->integer('reduced_flg')->nullable(); //低減税率フラグ
						$table->date('start_date')->nullable(); //開始日
						$table->date('end_date')->nullable(); //終了日
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付



						// ----------------------------------------------------
						// -- SELECT [m_taxes]--
						// ----------------------------------------------------
						// $query = DB::table("m_taxes")
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
                Schema::dropIfExists("m_taxes");
            }
        }
    