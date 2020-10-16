
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateTSaleDetailsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("t_sale_details", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('sale_id')->nullable()->unsigned(); //売上ID
						$table->string('category_cd',2)->nullable(); //カテゴリーCD
						$table->bigInteger('menu_id')->nullable(); //メニューID
						$table->bigInteger('money')->nullable(); //支払金額
						$table->bigInteger('tax_id')->nullable()->unsigned(); //税
						$table->bigInteger('discont_id')->nullable(); //割値引き
						$table->bigInteger('discount')->nullable(); //割値引き額
						$table->integer('amount')->nullable(); //個数
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("sale_id")->references("id")->on("t_sales");



						// ----------------------------------------------------
						// -- SELECT [t_sale_details]--
						// ----------------------------------------------------
						// $query = DB::table("t_sale_details")
						// ->leftJoin("t_sales","t_sales.id", "=", "t_sale_details.sale_id")
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
                Schema::dropIfExists("t_sale_details");
            }
        }
    