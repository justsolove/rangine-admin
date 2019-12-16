<?php

namespace W7\App\Exception;

use Psr\Http\Message\ResponseInterface;
use W7\Core\Exception\ResponseExceptionAbstract;

class HttpException extends ResponseExceptionAbstract {
	public function render(): ResponseInterface {
//        return $this->response->json([
//            'message' => $this->getMessage()
//        ]);
		 return $this->response->withStatus($this->getCode())->withData(['message' => $this->getMessage()]);
	}
}