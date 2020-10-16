
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMCompaniesTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_companies", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->string('name',30)->nullable(); //会社名
						$table->string('postal_cd',10)->nullable(); //郵便番号
						$table->string('prefecture',10)->nullable(); //都道府県
						$table->string('city',50)->nullable(); //市町村
						$table->string('area',50)->nullable(); //町域
						$table->string('address',50)->nullable(); //番地
						$table->string('accounting',2)->nullable(); //会計処理設定
						$table->timestamp('cutoff_date')->nullable(); //締め日
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付



						// ----------------------------------------------------
						// -- SELECT [m_companies]--
						// ----------------------------------------------------
						// $query = DB::table("m_companies")
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
                Schema::dropIfExists("m_companies");
            }
        }
    