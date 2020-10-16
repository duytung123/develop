
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateTFreeAnswersTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("t_free_answers", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('customer_id')->nullable()->unsigned(); //顧客ID
						$table->bigInteger('question_id')->nullable(); //質問ID
						$table->json('answer')->nullable(); //回答
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("customer_id")->references("id")->on("m_customers");
						//$table->foreign("question_id")->references("id")->on("t_free_questions");



						// ----------------------------------------------------
						// -- SELECT [t_free_answers]--
						// ----------------------------------------------------
						// $query = DB::table("t_free_answers")
						// ->leftJoin("m_customers","m_customers.id", "=", "t_free_answers.customer_id")
						// ->leftJoin("t_free_questions","t_free_questions.id", "=", "t_free_answers.question_id")
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
                Schema::dropIfExists("t_free_answers");
            }
        }
    