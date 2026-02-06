<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MasterclassController extends Controller
{
    /**
     * Display the masterclass detail page.
     */
    public function show($id)
    {
        // TODO: Получить данные мастер-класса из базы данных
        // $masterclass = Masterclass::findOrFail($id);
        
        // Временные данные для демонстрации
        $masterclass = [
            'id' => $id,
            'title' => 'Уютные домашние носки спицами: пошаговый мастер-класс',
            'subtitle' => 'Свяжите теплые носки для всей семьи с подробной инструкцией',
            'price' => 400,
            'old_price' => 550,
            'discount' => 27,
            'format' => 'Видео-курс + PDF-инструкция',
            'rating' => 4.9,
            'reviews_count' => 146,
            'images' => [
                'https://placehold.co/800x600/5b95bd/white?text=Носки+1',
                'https://placehold.co/800x600/5b95bd/white?text=Носки+2',
                'https://placehold.co/800x600/5b95bd/white?text=Носки+3',
                'https://placehold.co/800x600/5b95bd/white?text=Носки+4',
                'https://placehold.co/800x600/5b95bd/white?text=Носки+5',
            ],
            'author' => [
                'name' => 'Мария Иванова',
                'avatar' => 'https://placehold.co/56x56/5b95bd/white?text=МИ',
                'badges' => ['Топ-мастер', '5.0'],
                'rating' => 5.0,
                'reviews_count' => 146,
            ],
            'category' => 'Вязание',
            'level' => 'Начинающий',
            'description' => [
                'intro' => 'Научитесь вязать уютные домашние носки спицами с нашим подробным мастер-классом! Этот курс идеально подойдет для начинающих вязальщиц.',
                'what_you_learn' => [
                    'Основные техники вязания носков',
                    'Расчет петель для любого размера',
                    'Вязание пятки усиленной пяткой',
                    'Красивое закрытие мыска',
                    'Советы по выбору пряжи',
                ],
                'result' => 'В результате вы получите теплые, красивые носки ручной работы и навык, который пригодится на всю жизнь!',
            ],
            'materials' => [
                'Пряжа полушерстяная (50г - 200м) - 2 мотка',
                'Спицы носочные №3 - 5 штук',
                'Маркеры для петель',
                'Игла для сшивания',
                'Ножницы',
            ],
            'reviews' => [
                [
                    'author' => 'Елена К.',
                    'avatar' => 'https://placehold.co/48x48/5b95bd/white?text=ЕК',
                    'rating' => 5,
                    'date' => '2 дня назад',
                    'text' => 'Отличный мастер-класс! Все понятно объяснено, даже для новичка. Связала первые носки за выходные.',
                ],
                [
                    'author' => 'Анна М.',
                    'avatar' => 'https://placehold.co/48x48/5b95bd/white?text=АМ',
                    'rating' => 5,
                    'date' => '5 дней назад',
                    'text' => 'Мария замечательный педагог! Теперь вяжу носки всей семье. Спасибо за такой подробный курс.',
                ],
                [
                    'author' => 'Ольга В.',
                    'avatar' => 'https://placehold.co/48x48/5b95bd/white?text=ОВ',
                    'rating' => 4,
                    'date' => 'неделю назад',
                    'text' => 'Хороший мастер-класс, но хотелось бы больше примеров с разными узорами.',
                ],
            ],
            'author_classes' => [
                [
                    'id' => 2,
                    'title' => 'Вязаные варежки с узором',
                    'price' => 350,
                    'image' => 'https://placehold.co/200x150/5b95bd/white?text=Варежки',
                ],
                [
                    'id' => 3,
                    'title' => 'Шапка с косами',
                    'price' => 450,
                    'image' => 'https://placehold.co/200x150/5b95bd/white?text=Шапка',
                ],
                [
                    'id' => 4,
                    'title' => 'Теплый снуд спицами',
                    'price' => 280,
                    'image' => 'https://placehold.co/200x150/5b95bd/white?text=Снуд',
                ],
                [
                    'id' => 5,
                    'title' => 'Детские пинетки',
                    'price' => 250,
                    'image' => 'https://placehold.co/200x150/5b95bd/white?text=Пинетки',
                ],
            ],
            'similar_classes' => [
                [
                    'id' => 6,
                    'title' => 'Вязание тапочек следков',
                    'price' => 380,
                    'image' => 'https://placehold.co/200x180/5b95bd/white?text=Тапочки',
                    'author' => 'Ирина С.',
                    'author_avatar' => 'https://placehold.co/24x24/5b95bd/white?text=ИС',
                    'rating' => 4.8,
                ],
                [
                    'id' => 7,
                    'title' => 'Ажурные носки спицами',
                    'price' => 420,
                    'image' => 'https://placehold.co/200x180/5b95bd/white?text=Ажур',
                    'author' => 'Татьяна П.',
                    'author_avatar' => 'https://placehold.co/24x24/5b95bd/white?text=ТП',
                    'rating' => 4.9,
                ],
                [
                    'id' => 8,
                    'title' => 'Носки с жаккардовым узором',
                    'price' => 500,
                    'image' => 'https://placehold.co/200x180/5b95bd/white?text=Жаккард',
                    'author' => 'Екатерина Л.',
                    'author_avatar' => 'https://placehold.co/24x24/5b95bd/white?text=ЕЛ',
                    'rating' => 5.0,
                ],
                [
                    'id' => 9,
                    'title' => 'Вязание носков на двух спицах',
                    'price' => 350,
                    'image' => 'https://placehold.co/200x180/5b95bd/white?text=2+спицы',
                    'author' => 'Ольга К.',
                    'author_avatar' => 'https://placehold.co/24x24/5b95bd/white?text=ОК',
                    'rating' => 4.7,
                ],
            ],
        ];
        
        return view('front.masterclass-detail', compact('masterclass'));
    }
}
