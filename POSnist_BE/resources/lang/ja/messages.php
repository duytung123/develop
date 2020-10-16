<?php

return [

    //Account Validator
    'emailRequired' =>'Eメール入力してください',
    'shop_idRequired' =>'名称を入力してください。',
    'company_idRequired' => '会社 コードを入力してください。',
    'login_idRequired' =>'ログインID 入力してください。',
    //Companies Validator
    'nameRequired' => '会社名を入力してください。',
    'nameMax' => '最大30文字。',
    'postal_cdRequired' => '郵便番号は数字～桁で入力してください。',
    'postal_cdMax' => '最大10文字。',
    'prefectureRequired' => '都道府県選択を選択してください。',
    'prefectureMax' => '最大10文字。',
    'cityRequired' => '市町村選択を選択してください。',
    'cityMax' => '最大50文字。',
    'areaRequired' => '町域を入力してください',
    'areaMax' => '最大50文字。',
    'addressRequired' => 'ビル名を入力してください。',
    'addressMax' => '最大10文字',
    'accountingRequired' => '会社名を入力してください。',
    'accountingMax' => '最大10文字',
    'cutoff_dateRequired' => '締め日は数字で入力してください。',

    //Classes Validator
    'nameClassesRequired' => '商品名を入力してください。',

    //Items Validator--
    'class_idRequired' => 'を入力してください商品分類選択',
    'category_cdRequied' => 'を入力してください商品分類選択',
    'nameItemsRequired' => '商品名称を入力してください。',
    'nameItemsMax' => '最大30文字。',
    'used_dateRequired' => '仕様推定日数は数字で入力してください。',
    'priceRequired' => '価格は数字で入力してください。',
    'tax_idRequired' => '税率は数字で入力してください。',

    //Discount Validator--
    'shop_idRequired' => '名称を入力してください。',
    'nameRequired' => '名称を入力してください。',
    'discount_cdRequired' => '割引率を入力してください。',
    'discount_typeRequired' => '割引率を入力してください。',
    'discountRequired' => '  対象を選択してください。',
    'sortRequired' =>'ソートは数字で入力してください。',

    //m_shop Validator
    'NameShopRequired' =>'店舗名を入力してください。',
    'NameShopMax' =>'最大30文字。',
    'Company_idShopRequired'=>'会社 コードを入力してください。',
    'Postal_cdShopRequired'=>'郵便 コードを入力してください。',
    'Postal_cdShopMax'=>'最大10文字。',
    'PrefectureShopRequired'=>'都道府県を入力してください。',
    'PrefectureShopMax'=>'最大10文字。',
    'CityShopRequired'=>'市区町村を入力してください。',
    'CityShopMax'=>'最大50文字。',
    'AreaShopRequired'=>'範囲 入力してください。',
    'AreaShopMax'=>'最大50文字。',
    'AddressShopRequired'=>'ビル名を入力してください',
    'AddressShopMax'=>'最大50文字。',
    'TelShopRequired'=>'電話番号を入力してください。',
    'TelShopMax'=>'最大12文字。',
    'EmailShopRequired'=>'メールアドレスを入力してください。',
    'EmailShopMax'=>'最大255文字。',
    'Opening_timeShopRequired'=>'開店を入力してください。',
    'Opening_timeShopMax'=>'最大10文字。',
    'Closing_timeShopRequired'=> '閉店を入力してください。',
    'Closing_timeShopMax'=>'最大10文字。',
    'Time_breakShopRequired'=>'予約表時間区切りを入力してください。',
    'Time_breakShopMax'=>'最大10文字。',
    'FacilityShopRequired'=>'施術台、機材使用設定を入力してください。',
    'FacilityShopMax'=>'最大10文字。',

    //Skill Validator
    'class_idRequired' =>'技術分類選択を選択してください。',
    'name_skillRequired' => '名称を入力してください。',
    'treatment_timeRequired' => '施術時間を選択してください。',
    'buffer_timeRequired' =>'バッファ時間を選択してください。',
    'priceRequired'=> '価格は数字で入力してください。',
    'web_flgRequired' =>'WEB数字で入力してください。',
    'tax_idRequired' =>'税率を選択してください。',
    'sortRequired' => 'ソートは数字で入力してください。',
    'color_code' =>'予約色約を選択してください。',

    //payment Validator
    'PaymentRequired'=>'支払い してください。',
    'PaymentMax' => '最大30文字。',

     // MShopPayment Validator
     'shop_idRequired' => '所属店舗を選択してください。',
     'shop_idInteger' => '整数型を入力してください。',                        
     'nameShopPaymentRequired' => 'ネームショップの支払いを入力してください。',
     'nameShopPaymentMax' => '最大30文字。',
     'sortRequired' => 'ソートは数字で入力してください。',
     'sortInteger' => '整数型を入力してください。',
 

     // Customers Validator
     'shop_idRequired'=>'名称を入力してください。',
     'customer_noRequired'=>'customer_no入力してください。',
     'firstnameRequired'=>'ファーストネーム 入力してください。',
     'lastnameRequired'=>'苗字入力してください。',
     'firstname_kanaRequired'=>'firstname入力してください。',
     'lastname_kanaRequired'=>'lastname入力してください。',
     'sexRequired'=>'セックス入力してください。',
     'emailRequired'=>'Eメール入力してください',
     'telRequired'=>'電話 入力してください ',
     'login_idRequired'=>'ログインID 入力してください。',
     'passwordRequired'=>'パスワード 入力してください。',
     'staff_idRequired'=>'スタッフ ID入力してください。',
     'member_flgRequired'=>'member_flg入力してください。',
     'customer_imgRequired'=>'顧客の写真 入力してください。',
     'postal_cdRequired'=>'郵便 コードを入力してください。',
     'cityRequired'=>'市入力してください',
     'areaRequired'=>'範死入力してください',
     'addressRequired'=>'住所入力しますください',
     'languageRequired'=>'力入してください',
     'visit_cntRequired'=>'visit_cnt入力してください。',
     'first_visitRequired'=>'最初の訪問 入力してください。',
     'last_visitRequired'=>'最後の訪問入力してください。',

    //Courses Validator
    'class_idRequired' => 'を入力してください商品分類選択',
    'class_idInteger' => '整数型を入力してください',
    'nameCourseRequired' => 'コース名を入力してください',
    'nameCourseMax' => '最大30文字。',
    'treatment_timeRequired' => '治療時間を入力してください',
    'treatment_timeInteger' => '整数型を入力してください',
    'buffer_timeRequired' => 'バッファ時間を入力してください',
    'buffer_timeInteger' => '整数型を入力してください',
    'countRequired' => 'カウントを入力してください',
    'countInteger' => '整数型を入力してください',
    'priceRequired' => '価格を入力してください',
    'priceInteger' => '整数型を入力してください',
    'tax_idRequired' => '納税者番号を入力してください',
    'tax_idInteger' => '整数型を入力してください',
    'limit_dateRequired' => '制限日を入力してください',
    'month_menu_flgRequired' => '月メニューを入力してください',
    'month_menu_flgMax' => '最大1文字。',

    //Taxes Validator
    'nameTaxesRequired' => 'nameを入力してください。',
    'nameMax' => '最大3文字。',
    'taxTaxesRequired' => 'taxを入力してください。',
    'taxTaxesMax' => '最大3文字。',
    'reduced_flgTaxesRequired' => 'reducedを入力してください。',
    'reduced_flgTaxesNumeric' => 'reducedは数字で入力してください。',
    'reduced_flgTaxesMax' => '最大11文字。',
    'start_dateTaxesRequired' => 'start dateを入力してください。',
    'end_dateTaxesRequired' => 'end dateを入力してください。',

    //Staffs
    'staff_img' =>'ファイルを選択を選択してください。',
    'nameRequired' => 'スタッフ名を入力してください。',
    'name_kanaRequired' => 'フリガナを入力してください。',
    'sexRequired' => '性別を選択してください。',
    'shop_idRequired' => '所属店舗を選択してください。',
    'month_menu_flgRequired' => '月メニューを入力してください',
    'month_menu_flgMax' => '最大1文字。',


    //Staff_Recepts Validator
    'staff_idRequired' => 'スタッフIDを入力してください。',
    'staff_idInteger' => '整数型を入力してください。',
    'recept_amountRequired' => '金額レセプタクルを入力してください。',
    'recept_amountInteger' => '整数型を入力してください。',
    'web_flgRequired' => 'ウェブを入力してください。',
    'web_flgMax' => '最大1文字。',
    'nominationRequired' => '推薦を入力してください。',
    'nominationInteger' => '整数型を入力してください。',


    //ShopMailDestinations
    'nameShopMailDestinationsRequired' => '名前を入力してください。',
    'emailShopMailDestinationsRequired' => 'メールアドレスを入力してください。',
    'emailShopMailDestinationsEmail' => 'メールアドレスの形式が正しくないか、 システムで扱うことができないメールアドレスです',

    //ReservReceptTime
    "recept_type" =>'共通設定・個別設定を入力してください。',
    "recept_start" =>'受付開始時間を選択してください。',
    "recept_end" =>'受付終了時間を選択してください。',
    "recept_start_mo" =>'受付開始時間を選択してください。',
    "recept_end_mo" =>'受付終了時間を選択してください。',
    "recept_start_tu" =>'受付開始時間を選択してください。',
    "recept_end_tu" =>'受付終了時間を選択してください。',
    "recept_start_we" =>'受付開始時間を選択してください。',
    "recept_end_we" =>'	受付終了時間を選択してください。',
    "recept_start_th" =>'受付開始時間を選択してください。',
    "recept_end_th" =>'受付終了時間を選択してください。',
    "recept_start_fr" =>'受付開始時間を選択してください。',
    "recept_end_fr" =>'受付終了時間を選択してください。',
    "recept_start_sa" =>'受付開始時間を選択してください。',
    "recept_end_sa" =>'受付終了時間を選択してください。',
    "recept_start_su" =>'受付開始時間を選択してください。',
    "recept_end_su" =>'受付終了時間を選択してください。',
    "recept_start_ho" =>'受付開始時間を選択してください。',
    "recept_end_ho" =>'受付終了時間を選択してください。',

    //ShopView
    'shop_idRequired'=>'所属店舗を選択してください。',
    'nameRequired' =>'店舗名 を入力してください。',
    'log_imgRequired'=>'ファイルを選択を選択してください。',
    'postal_cdRequired'=>'郵便番号は数字～桁で入力してください。',
    'prefectureRequired'=>'都道府県を入力してください。',
    'cityRequired' =>'市町村を入力してください。',
    'areaRequired' =>'町域を入力してください。',
    'addressRequired' =>'ビル名を入力してください。',
    'telRequired'=>'電話番号電話番号は数字～桁で入力してください。',
    'accessRequired' =>'アクセスを入力してください。',

    //ShopMails
    'subjectShopMailsRequired' => '件名を入力してください。',
    'bodyShopMailsRequired' => '本文を入力してください。',
    //reserv_recepts
    'reserv_intervalRequied' => '予約間隔を入力してください。',
    'reserv_intervalMax' =>'最大1文字。',
    'recept_restRequired' => '休息をた受け入らないくて入力してください。',
    'recept_restMax' => '最大1文字。',
    'recept_amountRequired' => '整数型を入力してください',
    'cancel_setting_flgRequired' => '価格は数字で入力してください。',
    'cancel_setting_flgMax' =>'最大1文字。',
    'cancel_limitRequired' => '制限をキャンセル字で入力してください。',
    'cancel_limitMax' =>'最大2文字。',
    'future_reserv_num' => '整数型を入力してください',
    'cancel_wait_flgRequired' => 'キはいんセル待ちを入力してください',
    'cancel_wait_flgMax' =>'最大1文字。',

    ////reserv_recepts
   'reserv_intervalRequied' => '予約間隔を入力してください。',
    'reserv_intervalMax' =>'最大1文字。',
    'recept_restRequired' => '受付制限を選択してください。',
    'recept_restMax' => '最大1文字。',
    'recept_amountRequired' => '未来予約数を選択してください。',
    'cancel_setting_flgRequired' => 'キャンセル設定を選択してください。',
    'cancel_setting_flgMax' =>'最大1文字。',
    'cancel_limitRequired' => 'キャンセル期限を選択してください。',
    'cancel_limitMax' =>'最大2文字。',
    'future_reserv_num' => '整数型を入力してください',
    'cancel_wait_flgRequired' => 'キはいんセル待ちを入力してください',
    'cancel_wait_flgMax' =>'最大1文字。',
    // Shopterms
    'termsRequied' => '規約を入力してください。',
    'privacy_policyRequired' => 'プライバシーポリシーを入力してください。',

    // ShopPublicHolidaies  validator 
    'dateShopPublicHolidaiesRequired'=> '日付入力してくださ',

];


