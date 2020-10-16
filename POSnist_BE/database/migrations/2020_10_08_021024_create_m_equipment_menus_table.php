
    <?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;
        
        class CreateMEquipmentMenusTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("m_equipment_menus", function (Blueprint $table) {

						$table->bigIncrements('id');
						$table->bigInteger('equipment_id')->nullable()->unsigned(); //設備ID
						$table->string('category_cd',2)->nullable(); //カテゴリーCD
						$table->bigInteger('menu_id')->nullable(); //メニューID
						$table->timestamps(); //登録日付
						$table->softDeletes(); //削除日付
						//$table->foreign("equipment_id")->references("id")->on("m_equipments");



						// ----------------------------------------------------
						// -- SELECT [m_equipment_menus]--
						// ----------------------------------------------------
						// $query = DB::table("m_equipment_menus")
						// ->leftJoin("m_equipments","m_equipments.id", "=", "m_equipment_menus.equipment_id")
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
                Schema::dropIfExists("m_equipment_menus");
            }
        }
    