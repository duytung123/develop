
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMShopMailsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_shop_mails", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('shop_id')->nullable()->unsigned(); //店舗ID
						$table->string('mail_type',1)->nullable(); //メール区分
						$table->text('subject')->nullable(); //件名
						$table->text('body')->nullable(); //本文
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("shop_id")->references("id")->on("m_shops");



						// ----------------------------------------------------
						// -- SELECT [m_shop_mails]--
						// ----------------------------------------------------
						// $query = DB::table("m_shop_mails")
						// ->leftJoin("m_shops","m_shops.id", "=", "m_shop_mails.shop_id")
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
                Schema::dropIfExists("m_shop_mails");
            }
        }
    