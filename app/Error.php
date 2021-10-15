<?php

namespace App;


use JsonSerializable;

class Error implements JsonSerializable
{
    /**
     * @var integer
     */
    protected $code;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $localizedMessage;

    /**
     * Error constructor.
     * @param int $code
     * @param string $message
     * @param string $localizedMessage
     */
    public function __construct(int $code, string $message, string $localizedMessage)
    {
        $this->code = $code;
        $this->message = $message;
        $this->localizedMessage = $localizedMessage;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }


    //Codes//
    public const PRODUCT_NOT_FOUND = 404;

    /**
     * @param $errorCode int
     * @return Error
     */
    public static function getByCode(int $errorCode): Error
    {
        return new Error($errorCode,
            self::getMessage($errorCode)[0],
            self::getMessage($errorCode)[1]);
    }

    /**
     * @param int $errorCode
     * @return array
     */
    private static function getMessage(int $errorCode): array
    {
        switch ($errorCode) {
            case self::PRODUCT_NOT_FOUND:
                return ["Product not found", "Товар не найден"];
            default:
                return ["Unknown", "Произошла неизвестная ошибка"];
        }
    }

    public function jsonSerialize(): array
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'localizedMessage' => $this->localizedMessage,
        ];
    }
}
