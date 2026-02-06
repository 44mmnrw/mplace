<?php
/**
 * Скрипт добавления комментариев к таблицам для отображения в phpMyAdmin
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$pdo = DB::connection()->getPdo();

// Комментарии для таблиц из DBML-схемы
$tableComments = [
    'users' => 'Базовая таблица пользователей Laravel',
    'user_roles' => 'Роли: customer, seller, author, admin, support',
    'user_user_role' => 'Связь пользователей с ролями (many-to-many)',
    'sessions' => 'Сессии пользователей Laravel',
    'password_reset_tokens' => 'Токены для сброса пароля',
    'shops' => 'Магазины продавцов. Один пользователь может иметь несколько магазинов',
    'authors' => 'Профили авторов мастер-классов. Продают напрямую без магазина',
    'author_addresses' => 'Адреса авторов: юридический, фактический, почтовый',
    'author_tax_info' => 'Налоговая информация: taxpayer_type, ИНН, НПД',
    'customers' => 'Профили покупателей с программой лояльности (bronze/silver/gold/platinum)',
    'categories' => 'Иерархические категории товаров. Поддержка множественных родителей',
    'category_relations' => 'Связь категорий many-to-many для множественных родителей',
    'attributes' => 'Атрибуты товаров: Материалы, Сложность, Длительность',
    'attribute_options' => 'Значения атрибутов: {Начинающий, Средний, Продвинутый}',
    'category_attribute' => 'Привязка атрибутов к категориям. Наследование от родителей',
    'products' => 'Мастер-классы и цифровые товары. shop_id или author_id',
    'product_categories' => 'Связь товаров с категориями (many-to-many)',
    'product_prices' => 'История цен с temporal validity (valid_from/valid_to)',
    'product_images' => 'Изображения товаров. is_main=true для главного фото',
    'product_files' => 'Цифровые файлы. is_preview=true для бесплатных превью',
    'product_attribute_values' => 'Значения атрибутов товаров (EAV паттерн)',
    'carts' => 'Корзины покупателей. user_id nullable для гостей',
    'cart_items' => 'Позиции в корзине. price_at_add фиксирует цену',
    'wishlists' => 'Списки желаемого покупателей',
    'orders' => 'Заказы. order_number уникален. Статусы через FK',
    'order_items' => 'Позиции заказа. Снимок данных + commission_rate на момент покупки',
    'order_item_access' => 'Доступ к файлам после покупки. download_token, max_downloads',
    'order_statuses' => 'Статусы: pending, processing, completed, canceled, refunded',
    'payment_statuses' => 'Статусы: pending, paid, failed, refunded, partially_refunded',
    'payments' => 'История платежей. gateway_response полный JSON от платежки',
    'refunds' => 'Возвраты. Частичные (по order_item_id) и полные',
    'seller_balances' => 'Баланс продавца. available_balance + pending_balance (hold_days)',
    'seller_payouts' => 'Выплаты продавцам. Статусы: pending, processing, completed, failed',
    'npd_receipts' => 'Чеки самозанятых 422-ФЗ. API ФНС "Мой налог". ОБЯЗАТЕЛЬНЫ',
    'reviews' => 'Полиморфные отзывы: Product, Shop, Author. is_verified_purchase',
    'follows' => 'Полиморфные подписки на авторов/магазины',
    'reports' => 'Полиморфные жалобы. reason: spam, inappropriate, copyright',
    'activity_logs' => 'Аудит действий. action: auth.login, product.view (dot-notation)',
    'notifications' => 'Полиморфные уведомления. channels: database, email, push',
    'notification_settings' => 'Настройки уведомлений по типам и каналам',
    'coupons' => 'Промокоды. discount_type: percentage или fixed. max_uses',
    'coupon_usage' => 'История использования промокодов',
    'coupon_categories' => 'Привязка купонов к категориям',
    'coupon_products' => 'Привязка купонов к товарам',
    'blog_posts' => 'Посты блога авторов. status: draft, published, scheduled',
    'blog_categories' => 'Категории блога: Мастер-классы, Новости, Лайфхаки',
    'blog_post_categories' => 'Связь постов с категориями (many-to-many)',
    'tags' => 'Теги для постов блога. usage_count автоинкремент',
    'blog_post_tag' => 'Связь постов с тегами (many-to-many)',
    'blog_comments' => 'Комментарии к постам. parent_id для вложенности. Модерация',
    'newsletters' => 'Email-рассылки. Статистика: opened_count, clicked_count',
    'newsletter_segments' => 'Сегменты аудитории. conditions: JSON фильтры',
    'newsletter_sends' => 'История отправки каждому пользователю. Отслеживание opens/clicks',
    'tickets' => 'Тикеты поддержки. category, priority, assigned_to',
    'ticket_messages' => 'Сообщения в тикетах. is_staff_reply, is_internal_note',
    'conversations' => 'Чаты покупатель-продавец. order_id обязателен!',
    'messages' => 'Сообщения в чатах. attachments: JSON, read_at',
    'subscription_plans' => 'Тарифы для магазинов. max_products, commission_rate, features: JSON',
    'shop_subscriptions' => 'Подписки магазинов. billing_cycle: monthly/yearly, auto_renew',
    'migrations' => 'История выполненных миграций Laravel',
    'cache' => 'Кэш приложения Laravel',
    'cache_locks' => 'Блокировки для кэша Laravel',
    'jobs' => 'Очередь фоновых задач Laravel',
    'job_batches' => 'Пакеты задач Laravel',
    'failed_jobs' => 'Неудавшиеся фоновые задачи Laravel',
];

echo "═══════════════════════════════════════════════════════════════\n";
echo "  ДОБАВЛЕНИЕ КОММЕНТАРИЕВ К ТАБЛИЦАМ ДЛЯ PHPMYADMIN\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

$successCount = 0;
$errorCount = 0;

foreach ($tableComments as $table => $comment) {
    try {
        // Экранируем комментарий
        $escapedComment = str_replace("'", "''", $comment);
        
        // Добавляем комментарий к таблице
        $sql = "ALTER TABLE `$table` COMMENT = '$escapedComment'";
        $pdo->exec($sql);
        
        echo "✅ $table\n";
        $successCount++;
    } catch (Exception $e) {
        echo "❌ $table: " . $e->getMessage() . "\n";
        $errorCount++;
    }
}

echo "\n═══════════════════════════════════════════════════════════════\n";
echo "  ИТОГИ\n";
echo "═══════════════════════════════════════════════════════════════\n\n";
echo "Успешно обработано: $successCount таблиц\n";
echo "Ошибок: $errorCount\n\n";

if ($successCount > 0) {
    echo "🎉 Комментарии добавлены! Теперь откройте phpMyAdmin:\n";
    echo "   http://localhost/phpmyadmin\n";
    echo "   Выберите БД 'mplace' - комментарии видны в списке таблиц\n\n";
}
