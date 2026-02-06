<?php
/**
 * Скрипт для отображения всех таблиц БД с описанием их назначения
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$pdo = DB::connection()->getPdo();

// Описания таблиц из DBML-схемы
$tableDescriptions = [
    // Пользователи и роли
    'users' => 'Базовая таблица пользователей Laravel. Хранит email, пароль, email_verified_at',
    'user_roles' => 'Роли пользователей: customer (покупатель), seller (продавец мастер-классов через магазин), author (автор мастер-классов напрямую), admin (администратор), support (служба поддержки)',
    'user_user_role' => 'Связь пользователей с ролями (many-to-many). Один пользователь может быть одновременно покупателем и продавцом',
    'sessions' => 'Сессии пользователей Laravel',
    'password_reset_tokens' => 'Токены для сброса пароля Laravel',
    
    // Магазины и авторы
    'shops' => 'Магазины продавцов. Один пользователь может иметь несколько магазинов для разных тематик (например, "Вышивка крестиком" и "Вязание")',
    'authors' => 'Профили авторов мастер-классов. Продают напрямую без магазина. Могут иметь несколько адресов и налоговую информацию',
    'author_addresses' => 'Адреса авторов: юридический (для договоров), фактический (для корреспонденции), почтовый',
    'author_tax_info' => 'Налоговая информация авторов: taxpayer_type (self_employed - самозанятый, IP - ИП, legal_entity - юр.лицо), ИНН, дата регистрации НПД',
    'customers' => 'Профили покупателей с программой лояльности (bronze/silver/gold/platinum), статистикой покупок и настройками уведомлений',
    
    // Категории
    'categories' => 'Иерархические категории товаров. Каждая категория может иметь множественных родителей через category_relations',
    'category_relations' => 'Связь категорий many-to-many для поддержки множественных родителей. Например, "Вышивка лентами" может быть в категориях "Вышивка" и "Работа с лентами"',
    'attributes' => 'Атрибуты для товаров: Материалы, Сложность, Длительность и т.д. Привязываются к категориям',
    'attribute_options' => 'Значения атрибутов: для Сложности это {Начинающий, Средний, Продвинутый}',
    'category_attribute' => 'Привязка атрибутов к категориям. is_required=true для обязательных атрибутов. Дочерние категории наследуют атрибуты родителей',
    
    // Товары
    'products' => 'Мастер-классы и цифровые товары. Поддерживает shop_id (магазин) или author_id (автор напрямую). Денормализация: current_price, rating, views_count для быстрого доступа',
    'product_categories' => 'Связь товаров с категориями (many-to-many). Один товар может быть в нескольких категориях',
    'product_prices' => 'История цен товаров с temporal validity (valid_from/valid_to). Поддерживает скидки и акции на определенный период',
    'product_images' => 'Изображения товаров. is_main=true для главного фото',
    'product_files' => 'Цифровые файлы товара (видео, PDF и т.д.). is_preview=true для бесплатных превью (например, первый урок)',
    'product_attribute_values' => 'Значения атрибутов для товаров (EAV паттерн). value_text для текста, value_int для чисел, option_id для справочников',
    
    // Корзина и избранное
    'carts' => 'Корзины покупателей. user_id nullable для гостевых корзин (по session_id)',
    'cart_items' => 'Позиции в корзине. price_at_add фиксирует цену на момент добавления',
    'wishlists' => 'Списки желаемого покупателей',
    
    // Заказы
    'orders' => 'Заказы покупателей. order_number уникален. Статусы через order_status_id и payment_status_id',
    'order_items' => 'Позиции заказа со снимком данных на момент покупки: product_title, price. commission_rate и commission_amount фиксируются для точного расчета выплат',
    'order_item_access' => 'Контроль доступа к цифровым файлам после покупки. download_token для безопасного скачивания, max_downloads для ограничения. Требует подтверждения автора для некоторых товаров',
    'order_statuses' => 'Статусы заказов: pending (ожидает), processing (обрабатывается), completed (выполнен), canceled (отменен), refunded (возвращен)',
    'payment_statuses' => 'Статусы оплаты: pending, paid, failed, refunded, partially_refunded',
    
    // Платежи
    'payments' => 'История всех платежных транзакций. Хранит попытки оплаты, gateway_response (полный JSON от платежной системы), возвраты',
    'refunds' => 'Возвраты средств. Поддерживает частичные возвраты (по order_item_id) и полные. seller_balance_adjusted=true когда деньги списаны с баланса продавца',
    
    // Выплаты продавцам
    'seller_balances' => 'Баланс продавца. available_balance (доступно для вывода), pending_balance (в холде hold_days дней после заказа)',
    'seller_payouts' => 'Запросы на выплату продавцам. Статусы: pending, processing, completed, failed, rejected. payout_method: bank_card, bank_account, yoomoney, qiwi',
    'npd_receipts' => 'Чеки самозанятых по 422-ФЗ. ОБЯЗАТЕЛЬНЫ для всех выплат самозанятым. Формируются через API ФНС "Мой налог". Связь с payout_id или order_id',
    
    // Отзывы и социальное
    'reviews' => 'Полиморфные отзывы: на товары (Product), магазины (Shop), авторов (Author) через reviewable_type/reviewable_id. is_verified_purchase=true для подтвержденных покупок',
    'follows' => 'Полиморфные подписки: на авторов или магазины через followable_type/followable_id. Для уведомлений о новых товарах',
    'reports' => 'Полиморфные жалобы на любые сущности: товары, отзывы, комментарии через reportable_type/reportable_id. reason: spam, inappropriate, copyright и т.д.',
    'activity_logs' => 'Аудит действий пользователей. action: auth.login, product.view, order.create и т.д. (dot-notation). ip_address для безопасности',
    'notifications' => 'Полиморфные уведомления через notifiable_type/notifiable_id. channels: database, email, push. is_read для статуса прочтения',
    'notification_settings' => 'Настройки уведомлений по типам и каналам: email_enabled, push_enabled, database_enabled для каждого типа уведомлений',
    
    // Купоны
    'coupons' => 'Промокоды. discount_type: percentage (процент) или fixed (фиксированная сумма). max_uses для ограничения использований. Поддержка одноразовых кодов',
    'coupon_usage' => 'История использования промокодов. discount_amount фиксируется на момент применения',
    'coupon_categories' => 'Привязка купонов к категориям (ограничение применения)',
    'coupon_products' => 'Привязка купонов к товарам (ограничение применения)',
    
    // Блог
    'blog_posts' => 'Посты блога авторов. status: draft, published, scheduled. Авторы пишут статьи для привлечения аудитории. SEO-оптимизированы',
    'blog_categories' => 'Категории блога: Мастер-классы, Новости, Лайфхаки, Истории успеха',
    'blog_post_categories' => 'Связь постов с категориями (many-to-many)',
    'tags' => 'Теги для постов блога. usage_count автоинкрементится',
    'blog_post_tag' => 'Связь постов с тегами (many-to-many)',
    'blog_comments' => 'Комментарии к постам. parent_id для вложенных ответов. status: pending (модерация), approved, rejected',
    
    // Рассылки
    'newsletters' => 'Email-рассылки для покупателей. status: draft, scheduled, sending, sent, canceled. Статистика: opened_count, clicked_count',
    'newsletter_segments' => 'Сегменты аудитории. conditions: JSON с фильтрами {"loyalty_level": "gold", "total_spent": {">": 10000}}',
    'newsletter_sends' => 'История отправки каждому пользователю. Отслеживание: sent_at, opened_at, clicked_at, bounced_at',
    
    // Поддержка
    'tickets' => 'Тикеты службы поддержки. category: payment, delivery, refund, technical, other. priority: low, medium, high, critical. assigned_to - сотрудник поддержки',
    'ticket_messages' => 'Сообщения в тикетах. is_staff_reply=true для ответов поддержки. is_internal_note=true для внутренних заметок (не видны клиенту)',
    
    // Чаты
    'conversations' => 'Чаты покупатель-продавец. order_id ОБЯЗАТЕЛЕН - чат доступен только после покупки. unread_count для обеих сторон',
    'messages' => 'Сообщения в чатах. attachments: JSON массив файлов. read_at для статуса прочтения',
    
    // Подписки для магазинов
    'subscription_plans' => 'Тарифные планы для магазинов. max_products - лимит товаров, commission_rate - % комиссии маркетплейса, features: JSON доп. возможностей',
    'shop_subscriptions' => 'Активные подписки магазинов. billing_cycle: monthly/yearly. auto_renew для автопродления',
    
    // Служебные Laravel
    'migrations' => 'История выполненных миграций Laravel',
    'cache' => 'Кэш приложения Laravel',
    'cache_locks' => 'Блокировки для кэша Laravel',
    'jobs' => 'Очередь фоновых задач Laravel',
    'job_batches' => 'Пакеты задач Laravel',
    'failed_jobs' => 'Неудавшиеся фоновые задачи Laravel',
];

// Категории таблиц
$categories = [
    'Пользователи и роли' => ['users', 'user_roles', 'user_user_role', 'sessions', 'password_reset_tokens'],
    'Магазины и авторы' => ['shops', 'authors', 'author_addresses', 'author_tax_info', 'customers'],
    'Категории и атрибуты' => ['categories', 'category_relations', 'attributes', 'attribute_options', 'category_attribute'],
    'Товары' => ['products', 'product_categories', 'product_prices', 'product_images', 'product_files', 'product_attribute_values'],
    'Корзина и покупки' => ['carts', 'cart_items', 'wishlists'],
    'Заказы и оплата' => ['orders', 'order_items', 'order_item_access', 'order_statuses', 'payment_statuses', 'payments', 'refunds'],
    'Выплаты продавцам' => ['seller_balances', 'seller_payouts', 'npd_receipts'],
    'Отзывы и социальное' => ['reviews', 'follows', 'reports', 'activity_logs'],
    'Уведомления' => ['notifications', 'notification_settings'],
    'Купоны' => ['coupons', 'coupon_usage', 'coupon_categories', 'coupon_products'],
    'Блог' => ['blog_posts', 'blog_categories', 'blog_post_categories', 'tags', 'blog_post_tag', 'blog_comments'],
    'Рассылки' => ['newsletters', 'newsletter_segments', 'newsletter_sends'],
    'Поддержка' => ['tickets', 'ticket_messages'],
    'Чаты' => ['conversations', 'messages'],
    'Подписки магазинов' => ['subscription_plans', 'shop_subscriptions'],
    'Служебные Laravel' => ['migrations', 'cache', 'cache_locks', 'jobs', 'job_batches', 'failed_jobs'],
];

// Получаем список таблиц из БД
$stmt = $pdo->query("SHOW TABLES");
$actualTables = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo "═══════════════════════════════════════════════════════════════════════════\n";
echo "  ОПИСАНИЕ ТАБЛИЦ БАЗЫ ДАННЫХ MPLACE\n";
echo "═══════════════════════════════════════════════════════════════════════════\n\n";

foreach ($categories as $categoryName => $tables) {
    echo "┌─────────────────────────────────────────────────────────────────────────┐\n";
    echo "│ 📁 " . str_pad($categoryName, 70) . "│\n";
    echo "└─────────────────────────────────────────────────────────────────────────┘\n\n";
    
    foreach ($tables as $table) {
        $exists = in_array($table, $actualTables);
        $status = $exists ? '✅' : '❌';
        
        // Получаем размер таблицы если существует
        $size = '';
        if ($exists) {
            $sizeStmt = $pdo->query("
                SELECT 
                    ROUND((DATA_LENGTH + INDEX_LENGTH) / 1024, 2) as size_kb
                FROM information_schema.TABLES 
                WHERE TABLE_SCHEMA = DATABASE()
                AND TABLE_NAME = '$table'
            ");
            $sizeData = $sizeStmt->fetch(PDO::FETCH_ASSOC);
            $size = ' (' . $sizeData['size_kb'] . ' KB)';
        }
        
        $description = $tableDescriptions[$table] ?? 'Описание отсутствует';
        
        echo "$status $table$size\n";
        echo "   " . wordwrap($description, 73, "\n   ") . "\n\n";
    }
}

// Итоговая статистика
$totalExpected = array_sum(array_map('count', $categories));
$totalActual = count($actualTables);
$totalMatched = count(array_intersect(array_merge(...array_values($categories)), $actualTables));

echo "═══════════════════════════════════════════════════════════════════════════\n";
echo "  СТАТИСТИКА\n";
echo "═══════════════════════════════════════════════════════════════════════════\n\n";
echo "Таблиц описано:        $totalExpected\n";
echo "Таблиц в БД:           $totalActual\n";
echo "Совпадений:            $totalMatched\n";
echo "Полнота реализации:    " . round(($totalMatched / $totalExpected) * 100, 1) . "%\n\n";
