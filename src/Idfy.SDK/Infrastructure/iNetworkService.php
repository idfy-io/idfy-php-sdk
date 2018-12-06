<?php
declare(strict_types=1);

interface iNetworkService
{
	public function PostFormData($resource, $formData) : string;
}
