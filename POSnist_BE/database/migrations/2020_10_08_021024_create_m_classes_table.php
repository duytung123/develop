
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMClassesTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_classes", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->string('name',255)->nullable(); //分類名
						$table->string('category_cd',3)->nullable(); //カテゴリID
						$table->bigInteger('shop_id')->nullable()->unsigned(); //店舗ID
						$table->bigInteger('sort')->nullable(); //表示順
						$table->timestamps();
						$table->softDeletes();
						//$table->foreign("shop_id")->references("id")->on("m_shops");



						// ----------------------------------------------------
						// -- SELECT [m_classes]--
						// ----------------------------------------------------
						// $query = DB::table("m_classes")
						// ->leftJoin("m_shops","m_shops.id", "=", "m_classes.shop_id")
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
                Schema::dropIfExists("m_classes");
            }
        }
    