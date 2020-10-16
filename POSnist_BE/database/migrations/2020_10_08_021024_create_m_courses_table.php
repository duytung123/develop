
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMCoursesTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_courses", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('class_id')->nullable()->unsigned(); //分類ID
						$table->string('category_cd',2)->nullable(); //カテゴリーCD
						$table->string('name',30)->nullable(); //コース情報
						$table->bigInteger('treatment_time')->nullable(); //施術時間
						$table->bigInteger('buffer_time')->nullable(); //バッファ時間
						$table->integer('count')->nullable(); //回数
						$table->bigInteger('price')->nullable(); //価格
						$table->bigInteger('tax_id')->nullable()->unsigned(); //税ID
						$table->date('limit_date')->nullable(); //有効期限
						$table->integer('sort')->nullable(); //表示順
						$table->string('month_menu_flg',1)->nullable(); //月額制メニューフラグ
						$table->string('color_code',6)->nullable(); //予約色
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("class_id")->references("id")->on("m_classes");
						//$table->foreign("tax_id")->references("id")->on("m_taxes");



						// ----------------------------------------------------
						// -- SELECT [m_courses]--
						// ----------------------------------------------------
						// $query = DB::table("m_courses")
						// ->leftJoin("m_classes","m_classes.id", "=", "m_courses.class_id")
						// ->leftJoin("m_taxes","m_taxes.id", "=", "m_courses.tax_id")
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
                Schema::dropIfExists("m_courses");
            }
        }
    