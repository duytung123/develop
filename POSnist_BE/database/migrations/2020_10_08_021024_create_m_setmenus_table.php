
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMSetmenusTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_setmenus", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('class_id')->nullable()->unsigned(); //分類ID
						$table->string('category_cd',2)->nullable(); //カテゴリーCD
						$table->string('name',30)->nullable(); //名称
						$table->string('web_flg',1)->nullable(); //WEB予約
						$table->string('color_code',6)->nullable(); //予約色
						$table->integer('sort')->nullable(); //表示順
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("class_id")->references("id")->on("m_classes");



						// ----------------------------------------------------
						// -- SELECT [m_setmenus]--
						// ----------------------------------------------------
						// $query = DB::table("m_setmenus")
						// ->leftJoin("m_classes","m_classes.id", "=", "m_setmenus.class_id")
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
                Schema::dropIfExists("m_setmenus");
            }
        }
    