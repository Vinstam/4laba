<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Доска объявлений</title>
</head>
<body>

<form action="4.2.php" method="POST">
    <label for="email">Email</label>
    <input type="email" name="email">
    <br>
    <label for="category">Категории</label>
    <select name="category" required>
        <?php
        require __DIR__ . '/vendor/autoload.php';
        $guzzleClient = new \GuzzleHttp\Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ), ));
        $client = new Google_Client();
        $client->setHttpClient($guzzleClient);
        $client->setApplicationName('Google Sheets with PHP');
        $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        $client->setAuthConfig(__DIR__ . '/credentials.json');
        $service = new Google_Service_Sheets($client);
        $range_cat = 'E2:E4';
        $spreadsheetID = '1o5yjC_VMUFFtmVhCw097_thPSfG4bAtiC8z64j0lTFM';
        $categories = $service -> spreadsheets_values -> get($spreadsheetID, $range_cat);
        foreach ($categories as $category) {
            if ($category != "." && $category != "..") {
                echo "<option value=\"$category[0]\">$category[0]</option>";
            }
        }
        ?>
    </select>
    <br>
    <label for="title">Заголовок объявления</label>
    <input type="text" name="title" required>
    <br>
    <label for="description">Текст объявления</label>
    <textarea name="description" id="" cols="30" rows="5" required></textarea><br>
    <input type="submit" value="Сохранить">
</form>

<table>
    <thead>
    <th>Категория</th>
    <th>Заголовок</th>
    <th>Описание</th>
    <th>E-mail</th>
    </thead>
    <?php
    $range_get = 'A2:D10';
    $results = $service -> spreadsheets_values -> get($spreadsheetID, $range_get);
    foreach ($results as $result) {
        if(!empty($result))
        {
            echo "<tr><td>$result[0]</td><td>$result[1]</td><td>$result[2]</td><td>$result[3]</td></tr>";
        }
        else
        {
            break;
        }
    }
    ?>
</table>
</body>
</html>