<?php

/**
 * Class Hawking
 * Класс, от которого нельзя сделать наследника.
 */
final class Hawking
{
    /**
     * @var PDO $pdo
     */
    private PDO $pdo;

    /**
     * Constructor.
     * Выполняет методы bros() и brothers().
     */
    public function __construct()
    {
        $this->bros();
        $this->brothers();
    }


    /**
     * Создает таблицу test через PDO.
     * Для использования нужно подставить данные подключения к БД
     * @access private
     * @return void
     */
    private function bros(): void
    {
        // Подключение к базе данных
        $this->pdo = new PDO('mysql:host=localhost;dbname=your_database', 'root', 'root');

        // Создание таблицы test
        $sql = "CREATE TABLE IF NOT EXISTS test (
            id INT AUTO_INCREMENT PRIMARY KEY,
            script_name VARCHAR(25),
            start_time INT,
            end_time INT,
            result ENUM('normal', 'illegal', 'failed', 'success')
        )";
        try {
            $this->pdo->exec($sql);
        }catch (Exception $exception){
            echo $exception->getMessage();
        }

    }

    /**
     * Заполняет таблицу случайными данными.
     * @access private
     * @return void
     */
    private function brothers(): void
    {
        $results = ['normal', 'illegal', 'failed', 'success'];

        // Генерация случайных данных и добавление их в таблицу
        for ($i = 0; $i < 10; $i++) {
            $scriptName = 'scriptName ' . rand(1, 100);
            $startTime = mt_rand(1, 1000);
            $endTime = mt_rand(1001, 2000);
            $result = $results[array_rand($results)];

            $stmt = $this->pdo->prepare("INSERT INTO test (script_name, start_time, end_time, result) VALUES (?, ?, ?, ?)");
            try{
                $stmt->execute([$scriptName, $startTime, $endTime, $result]);
            }catch (Exception $exception){
                echo $exception->getMessage();
            }

        }
    }

    /**
     * Выбирает из таблицы test данные по критерию result.
     * @param array $criteria Критерий выборки ['normal', 'success']
     * @return array Результат выборки
     */
    public function production(array $criteria): array
    {
        // Выборка данных по критерию
        $stmt = $this->pdo->prepare("SELECT * FROM test WHERE result IN (? , ?)");
        try{
            $stmt->execute($criteria);
        }catch (Exception $exception){
            echo $exception->getMessage();
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Пример использования
$hawking = new Hawking();
$data = $hawking->production(['normal', 'success']);

print_r($data);