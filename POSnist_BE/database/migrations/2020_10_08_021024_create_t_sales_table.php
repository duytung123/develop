
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateTSalesTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("t_sales", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('customer_id')->nullable()->unsigned(); //顧客ID
						$table->bigInteger('shop_id')->nullable()->unsigned(); //店舗ID
						$table->bigInteger('reservation_id')->nullable()->unsigned(); //予約ID
						$table->bigInteger('payment_id')->nullable()->unsigned(); //支払方法ID
						$table->bigInteger('money')->nullable(); //支払合計
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("customer_id")->references("id")->on("m_customers");
						//$table->foreign("shop_id")->references("id")->on("m_shops");
						//$table->foreign("payment_id")->references("id")->on("m_shops_payments");



						// ----------------------------------------------------
						// -- SELECT [t_sales]--
						// ----------------------------------------------------
						// $query = DB::table("t_sales")
						// ->leftJoin("m_customers","m_customers.id", "=", "t_sales.customer_id")
						// ->leftJoin("m_shops","m_shops.id", "=", "t_sales.shop_id")
						// ->leftJoin("m_shops_payments","m_shops_payments.id", "=", "t_sales.payment_id")
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
                Schema::dropIfExists("t_sales");
            }
        }
    