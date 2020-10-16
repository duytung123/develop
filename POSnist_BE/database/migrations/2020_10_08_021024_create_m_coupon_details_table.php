
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMCouponDetailsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_coupon_details", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('coupon_id')->nullable()->unsigned(); //クーポンID
						$table->string('category_cd',2)->nullable(); //カテゴリーCD
						$table->bigInteger('menu_id')->nullable(); //該当のID
						$table->bigInteger('discount')->nullable(); //割引額
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("coupon_id")->references("id")->on("m_coupons");



						// ----------------------------------------------------
						// -- SELECT [m_coupon_details]--
						// ----------------------------------------------------
						// $query = DB::table("m_coupon_details")
						// ->leftJoin("m_coupons","m_coupons.id", "=", "m_coupon_details.coupon_id")
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
                Schema::dropIfExists("m_coupon_details");
            }
        }
    