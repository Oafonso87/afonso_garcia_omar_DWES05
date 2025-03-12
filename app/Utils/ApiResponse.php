<?php
namespace App\Utils;

class ApiResponse {

    private array $response = [
        'status' => '',
        'code' => '',
        'message' => '',
        'data' => ''
    ];

    public function __construct(string $status = '', int $code = 0, string $message = '', $data = [] ) {
        $this->response['status'] = $status;
        $this->response['code'] = $code;
        $this->response['message'] = $message;
        $this->response['data'] = $data;
        
    }

    public function setStatus(string $status): void {
        $this->response['status'] = $status;
    }

    public function setCode(int $code): void {
        $this->response['code'] = $code;
    }

    public function setMessage(string $message): void {
        $this->response['message'] = $message;
    }

    public function setData($data): void {
        $this->response['data'] = $data;
    }

    public function getStatus(): string {
        return $this->response['status'];
    }

    public function getCode(): int {
        return $this->response['code'];
    }

    public function getMessage(): string {
        return $this->response['message'];
    }

    public function getData(): mixed {
        return $this->response['data'];
    }

    public function getResponse(): array {
        return $this->response;
    }

    public function toJSON(): string {
        return json_encode(value: $this->response);
    }
}
?>