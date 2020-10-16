
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMSetmenuDetailsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_setmenu_details", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('setmenu_id')->nullable()->unsigned(); //セットメニューID
						$table->string('category_cd',2)->nullable(); //カテゴリーCD
						$table->string('menu_id')->nullable(); //該当のID
						$table->bigInteger('discount')->nullable(); //割引額
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("setmenu_id")->references("id")->on("m_setmenus");



						// ----------------------------------------------------
						// -- SELECT [m_setmenu_details]--
						// ----------------------------------------------------
						// $query = DB::table("m_setmenu_details")
						// ->leftJoin("m_setmenus","m_setmenus.id", "=", "m_setmenu_details.setmenu_id")
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
                Schema::dropIfExists("m_setmenu_details");
            }
        }
    