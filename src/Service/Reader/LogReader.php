<?php
declare(strict_types=1);

namespace App\Service\Reader;

class LogReader implements Reader
{
    private const int DEFAULT_BUFFER_SIZE = 1024 * 1024; // 1MB
    /**
     * @var resource|false $file
     */
    private $file;
    private int $seek;

    // Suffix holds the first row of each chunk and is appended to the next chuck. This way don't yield partial rows
    private string $suffix = '';

    /**
     * @inheritDoc
     * @throws \RuntimeException
     */
    public function iterator(): \Generator
    {
        $bufferSize = self::DEFAULT_BUFFER_SIZE;
        while ($this->seek > 0){
            $this->seek -= $bufferSize;
            if($this->seek < 0){
                $bufferSize = self::DEFAULT_BUFFER_SIZE + $this->seek;
                $this->seek = 0;
            }

            fseek($this->file, $this->seek);
            yield from $this->splitIntoLines(fread($this->file, $bufferSize));

        }
    }

    public function load(string $path): void
    {
        $this->file = fopen($path, 'rb');
        if(!$this->file){
            throw new \RuntimeException("Unable to open file {$path}");
        }
        fseek($this->file, 0, SEEK_END);
        $this->seek = \ftell($this->file);
    }

    /**
     * @param string $chunk
     * @return \Generator<string>
     *
     * @throws \RuntimeException
     */
    private function splitIntoLines(string $chunk): \Generator
    {
        $lines = \explode("\n", $chunk . $this->suffix);
        if(empty($lines)){
            throw new \RuntimeException('Line is longer than the buffer');
        }
        if($this->seek > 0){
            $this->suffix = \array_shift($lines);
        }

        $length = \count($lines);
        for($index = $length - 1; $index >= 0; $index--){
            // This will trim byte-order mark (BOM) as well
            yield \trim($lines[$index], "\u{FEFF} \n\r\t\v\0");
        }
    }
}
