<?php



// Получение списка продуктов
function getProducts()
{
    // Здесь можно реализовать логику получения списка продуктов из базы данных или внешнего источника данных
    // Возвращаем пример для наглядности
    $products = [
        ['id' => 1, 'name' => 'Сметана'],
        ['id' => 2, 'name' => 'Малина'],
        ['id' => 3, 'name' => 'Кукуруза'],
        // Другие продукты...
    ];

    return $products;
}

// Создание подписки на доставку
function createSubscription($data)
{
    // Здесь можно реализовать логику сохранения подписки в базе данных
    // $data содержит информацию о выбранных продуктах, адресе доставки и т.д.
    // Возвращаем созданную подписку или идентификатор подписки для дальнейшего использования
    $subscriptionId = 12345;

    return $subscriptionId;
}

// Получение информации о подписке
function getSubscription($subscriptionId)
{
    // Здесь можно реализовать логику получения информации о подписке из базы данных
    // Возвращаем пример для наглядности
    $subscription = [
        'id' => $subscriptionId,
        'products' => [
            ['id' => 1, 'name' => 'Сметана'],
            ['id' => 2, 'name' => 'Малина'],
            ['id' => 3, 'name' => 'Кукуруза'],
            // Другие продукты...
        ],
        'delivery_address' => 'ул. Пушкина, 10',
        // Другая информация о подписке...
    ];

    return $subscription;
}

// Главный код API

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'];

// Разбираем путь
$segments = explode('/', $path);
$resource = $segments[1];
$id = isset($segments[2]) ? $segments[2] : null;

// Обрабатываем запрос
header('Content-Type: application/json');

switch ($method) {
    case 'GET':
        if ($resource === 'products') {
            $products = getProducts();
            echo json_encode($products);
        } elseif ($resource === 'subscriptions' && $id !== null) {
            $subscription = getSubscription($id);
            echo json_encode($subscription);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Not Found']);
        }
        break;

    case 'POST':
        if ($resource === 'subscriptions') {
            $data = json_decode(file_get_contents('php://input'), true);
            $subscriptionId = createSubscription($data);
            echo json_encode(['subscription_id' => $subscriptionId]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Not Found']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
        break;
}

?>
