<?php

class Script
{
    /**
     * @var string $path путь к директории
     */
    protected string $path;
    /**
     * @var string $end_of_file расширение файла
     */
    protected string $end_of_file;

    /**
     * @param string $path это путь к директории поиска
     * @param string $end_of_file это расширение файла, например bros
     */
    public function __construct(string $path, string $end_of_file)
    {
        $this->path = $path;
        $this->end_of_file = $end_of_file;
    }

    /**
     * @return string это итоговая выборка
     */
    public function __toString(): string
    {
        $files = $this->scanDirectory($this->path);
        $namesFile = $this->getNamesFile($files, $this->end_of_file);
        $result = '';
        foreach ($namesFile as $item){
            $result .= $item . PHP_EOL;
        }
        return $result;
    }

    /**
     * @param string $path это путь к директории поиска
     * @return array
     */
    protected function scanDirectory(string $path): array
    {
        $files = [];
        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        foreach ($rii as $file)
            if (!$file->isDir())
                $files[] = basename($file);
        return $files;
    }

    /**
     * @param array $files массив со всеми файлами в директории
     * @param string $end_of_file расширение файло который ищем
     * @return array
     */
    protected function getNamesFile(array $files, string $end_of_file): array
    {
        $pattern = '/([0-9a-zA-Z]+)\.' . $end_of_file . '/';
        $foundFiles = [];
        foreach ($files as $file){
            if (preg_match($pattern, $file, $matches)) {
                $foundFiles[] = $matches[1];
            }
        }
        sort($foundFiles);
        return $foundFiles;
    }
}

// пример использования
$result = new Script('/hawking ', 'bros');
echo $result;