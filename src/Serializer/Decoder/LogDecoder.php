<?php
declare(strict_types=1);

namespace App\Serializer\Decoder;

use Symfony\Component\Serializer\Encoder\DecoderInterface;

class LogDecoder implements DecoderInterface
{

    /**
     * @inheritDoc
     * @return array{
     *     0:string,
     *     1:string,
     *     2:array{0:string,1:string,2:string},
     *     3:string
     * }
     */
    public function decode(string $data, string $format, array $context = []): mixed
    {
        $data = str_replace([' - - [', '] "', '" '], '|', $data);
        $logEntryArray = explode('|', $data);
        $logEntryArray[2] = explode(' ', $logEntryArray[2]);

        return $logEntryArray;
    }

    /**
     * @inheritDoc
     */
    public function supportsDecoding(string $format): bool
    {
        return $format === 'log';
    }
}
