
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMCouponsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_coupons", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('class_id')->nullable()->unsigned(); //クラスID
						$table->string('category_cd',2)->nullable(); //カテゴリーCD
						$table->string('name',30)->nullable(); //クーポン名
						$table->string('web_flg',1)->nullable(); //WEB予約可否
						$table->string('target_flg',1)->nullable(); //対象者
						$table->string('color_code',6)->nullable(); //予約色
						$table->date('start_date')->nullable(); //開始日
						$table->date('end_date')->nullable(); //終了日
						$table->integer('sort')->nullable(); //表示順
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("class_id")->references("id")->on("m_classes");



						// ----------------------------------------------------
						// -- SELECT [m_coupons]--
						// ----------------------------------------------------
						// $query = DB::table("m_coupons")
						// ->leftJoin("m_classes","m_classes.id", "=", "m_coupons.class_id")
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
                Schema::dropIfExists("m_coupons");
            }
        }
    