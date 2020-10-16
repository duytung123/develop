
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMEquipmentsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_equipments", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->string('name',255)->nullable(); //設備名
						$table->bigInteger('shop_id')->nullable()->unsigned(); //店舗ID
						$table->string('equpment_cd',3)->nullable(); //設備コード
						$table->integer('amount')->nullable(); //数量
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("shop_id")->references("id")->on("m_shops");



						// ----------------------------------------------------
						// -- SELECT [m_equipments]--
						// ----------------------------------------------------
						// $query = DB::table("m_equipments")
						// ->leftJoin("m_shops","m_shops.id", "=", "m_equipments.shop_id")
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
                Schema::dropIfExists("m_equipments");
            }
        }
    