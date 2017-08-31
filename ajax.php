<?php

$owner_id = $_REQUEST['owner_id']; //id организации

switch ($_REQUEST['action']) {
case 'edit':
	//todo: часть 1. загрузка меню
	$columns = [
		'title' => [
			'title' => 'Услуга',
			'placeholder' => 'Услуга',
			'description' => 'Введите название услуги',
		],
		'cost' => [
			'title' => 'Цена, руб',
			'placeholder' => 'Цена, руб',
			'description' => 'Введите одно число',
		],
		'photo' => [
			'title' => 'Фото',
			'placeholder' => 'Фото',
			'description' => 'Вставьте ссылку на фото или загрузите с компьютера. Можно загрузить только одно фото.',
		],
	];

    //Предположим что у нас  есть ORM какой-то абстрактный
    $data = MenuItem::where('owner_id', (int)$_REQUEST['owner_id'])
                ->orderBy('name')
                    ->get();
//	$data = [];
//	$data[] = [
//		'id' => '1',
//		'title' => 'Гороховый суп',
//		'cost' => '120',
//		'photo' => 'http://zoon.ru/images/header/zoon_logo.png',
//	];
//	$data[] = [
//		'id' => '2',
//		'title' => 'Борщ',
//		'cost' => '140',
//		'photo' => 'http://zoon.ru/images/header/zoon_logo.png',
//	];
//	$data[] = [
//		'id' => '3',
//		'title' => 'Котлета',
//		'cost' => '130',
//		'photo' => 'http://zoon.ru/images/header/zoon_logo.png',
//	];
//	$data[] = [
//		'id' => '4',
//		'title' => 'Компот',
//		'cost' => '30',
//		'photo' => 'http://zoon.ru/images/header/zoon_logo.png',
//	];


	$res = [
		'success' => true,
		'data' => $data,
		'columns' => $columns,
	];
	break;

case 'save':
	//todo: часть 1. сохранение меню
	$res = ['success' => false];
	$owner_id = (int)$_REQUEST['owner_id'];
	$data = $_REQUEST['data'] ?? null;
	$errors = [];
	if (!$data) {
	    $res['error'] = 'Данных нет';
    } else {
	    $data = json_decode($data, true);
	    foreach ($data as $row) {
            //Предположим что у нас  есть ORM какой-то абстрактный
            $menuItem = MenuItem::where('id', (int)$row['id'])
                                ->firstOrCreate();
            $menuItem->owner_id = $owner_id;
            $menuItem->fill($row);
            if (!$menuItem->save()) {
                //Если вдруг не прошла валидация, добавим к списку ошибок, но откатывать другие н ебудем ибо глупо
                $errors[] = ['name' => $row->name, 'errors' => $menuItem->getErrors()];
            }
        }
        if ($errors) {
	        $res['error'] = 'Некоторые пункты меню не были сохранены';
        } else {
	        $res['success'] = true;
        }
    }


	break;

case 'uploadPhoto':
	//todo: часть 2. аплоадим файл, возвращаем ссылку на него
	$res = ['success' => true, 'photo' => 'https://www.google.ru/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png'];
	break;
default:
	$res = ['success' => false];
}


$res = json_encode($res);
header('Content-Length: '.strlen($res));
header('Content-Type: text/x-json; charset=utf-8');
echo $res;
