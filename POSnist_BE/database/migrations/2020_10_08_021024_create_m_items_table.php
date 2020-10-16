
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMItemsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_items", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('class_id')->nullable()->unsigned(); //分類ID
						$table->string('category_cd',2)->nullable(); //カテゴリーCD
						$table->string('name',30)->nullable(); //商品名
						$table->bigInteger('used_date')->nullable(); //使用推定日数
						$table->bigInteger('price')->nullable(); //価格
						$table->bigInteger('tax_id')->nullable()->unsigned(); //税ID
						$table->integer('sort')->nullable(); //表示順
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("class_id")->references("id")->on("m_classes");
						//$table->foreign("tax_id")->references("id")->on("m_taxes");



						// ----------------------------------------------------
						// -- SELECT [m_items]--
						// ----------------------------------------------------
						// $query = DB::table("m_items")
						// ->leftJoin("m_classes","m_classes.id", "=", "m_items.class_id")
						// ->leftJoin("m_taxes","m_taxes.id", "=", "m_items.tax_id")
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
                Schema::dropIfExists("m_items");
            }
        }
    