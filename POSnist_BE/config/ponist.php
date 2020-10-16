<?php
return [

  'status' => [
    'OK' =>'200',
    'BAD_REQUEST' => '400',
    'NO-CONTENT' => '204'
  ],
  'header' =>[
    'CONTENT_APPLICATION' => 'application/json'
  ],
  'notification' =>[
    'CODEINT' =>'40006',
    'MESSAGE40001'=>'不正なリクエスト', //CREATE
    'FIELD_ID' => 'id',
    'FIELD_NAME'=> 'name',
    'CODE40001' =>'40001',
    'CODE40006' =>'40006',
    'MESSAGE40006' => '有効な値でない',//GETID
    'MESSAGE50102' => '同時更新エラー',//UPDATED_AT
    'FIELD50102' => 'updated_at',
    'CODE50102' => '50102',
  ],
  'baseurl' => 'http://192.168.0.32:8000/',
  'categorycd' => [
         'TECH' => '01',
         'COURSE' => '02',
         'PRODUCT' => '03',
    ],
    'thumbnail' =>[
      'hight' => 100,
      'width' => 150,
    ],

];
