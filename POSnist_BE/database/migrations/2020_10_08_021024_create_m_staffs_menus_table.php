
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMStaffsMenusTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_staffs_menus", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('staff_id')->nullable()->unsigned(); //スタッフID
						$table->string('category_cd',3)->nullable(); //カテゴリCD
						$table->bigInteger('menu_id')->nullable(); //メニューID
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("staff_id")->references("id")->on("m_staffs");



						// ----------------------------------------------------
						// -- SELECT [m_staffs_menus]--
						// ----------------------------------------------------
						// $query = DB::table("m_staffs_menus")
						// ->leftJoin("m_staffs","m_staffs.id", "=", "m_staffs_menus.staff_id")
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
                Schema::dropIfExists("m_staffs_menus");
            }
        }
    