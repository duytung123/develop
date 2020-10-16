
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMShopsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_shops", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('company_id')->nullable()->unsigned(); //会社ID
						$table->string('name',30)->nullable(); //店舗名
						$table->string('postal_cd',10)->nullable(); //郵便番号
						$table->string('prefecture',10)->nullable(); //都道府県
						$table->string('city',50)->nullable(); //市町村
						$table->string('area',50)->nullable(); //町域
						$table->string('address',50)->nullable(); //番地
						$table->string('tel',12)->nullable(); //電話番号
						$table->string('email',255)->nullable(); //E-mail
						$table->string('opening_time',10)->nullable(); //営業時間（From）
						$table->string('closing_time',10)->nullable(); //営業時間（to）
						$table->string('time_break',10)->nullable(); //予約表時間区切り
						$table->string('facility',10)->nullable(); //施術台・機材使用設定
						$table->string('language',3)->nullable(); //言語設定
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("company_id")->references("id")->on("m_companies");



						// ----------------------------------------------------
						// -- SELECT [m_shops]--
						// ----------------------------------------------------
						// $query = DB::table("m_shops")
						// ->leftJoin("m_companies","m_companies.id", "=", "m_shops.company_id")
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
                Schema::dropIfExists("m_shops");
            }
        }
    