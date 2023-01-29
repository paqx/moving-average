<?php

namespace Paquix\Ma;

interface RequestInterface
{
	public function getMethod(): string;
	public function getUri(): string;
	public function getUriParam(string $uriParam): ?string;
}