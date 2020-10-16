
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateTFreeQuestionsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("t_free_questions", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('company_id')->nullable()->unsigned(); //会社ID
						$table->string('html_type',1)->nullable(); //HTMLタイプ
						$table->string('multiple_flg',1)->nullable(); //複数選択フラグ
						$table->string('question',30)->nullable(); //質問内容
						$table->json('answer')->nullable(); //回答選択肢
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("company_id")->references("id")->on("m_companies");



						// ----------------------------------------------------
						// -- SELECT [t_free_questions]--
						// ----------------------------------------------------
						// $query = DB::table("t_free_questions")
						// ->leftJoin("m_companies","m_companies.id", "=", "t_free_questions.company_id")
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
                Schema::dropIfExists("t_free_questions");
            }
        }
    