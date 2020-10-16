
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMSkillsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_skills", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('class_id')->nullable()->unsigned(); //分類ID
						$table->string('category_cd',2)->nullable(); //カテゴリーCD
						$table->string('name',30)->nullable(); //技術名称
						$table->bigInteger('treatment_time')->nullable(); //施術時間
						$table->bigInteger('buffer_time')->nullable(); //バッファ時間
						$table->bigInteger('price')->nullable(); //価格
						$table->bigInteger('tax_id')->nullable()->unsigned(); //税率ID
						$table->integer('sort')->nullable(); //表示順
						$table->string('web_flg',1)->nullable();
						$table->string('color_code',6)->nullable(); //カラーコード
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("class_id")->references("id")->on("m_classes");
						//$table->foreign("tax_id")->references("id")->on("m_taxes");



						// ----------------------------------------------------
						// -- SELECT [m_skills]--
						// ----------------------------------------------------
						// $query = DB::table("m_skills")
						// ->leftJoin("m_classes","m_classes.id", "=", "m_skills.class_id")
						// ->leftJoin("m_taxes","m_taxes.id", "=", "m_skills.tax_id")
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
                Schema::dropIfExists("m_skills");
            }
        }
    