<?php

if (!function_exists('generateOTP')) {
    function generateOTP($len)
    {
        $result = '';
        for ($i = 0; $i < $len; $i++) {
            $result .= mt_rand(0, 9);
        }
        return $result;
    }
}

if (!function_exists('customUnique')) {
	function customUnique()
	{
		$lenght = 10;
		// uniqid gives 13 chars, but you could adjust it to your needs.
		if (function_exists("random_bytes")) {
			$bytes = random_bytes(ceil($lenght / 2));
		} elseif (function_exists("openssl_random_pseudo_bytes")) {
			$bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
		}

		return substr(bin2hex($bytes), 0, $lenght);
	}
}

if (!function_exists('productUploads')) {
	function productUploads()
	{
		return 'uploads/';
	}

}
if (!function_exists('studentUploads')) {
	function studentUploads()
	{
		return 'uploads/students/';
	}

}

if (!function_exists('bannerResized')) {
	function bannerResized()
	{
		return 'uploads/banner/';
	}

}

if (!function_exists('deleteFile')) {
	function deleteFile($path)
	{
		if (file_exists($path)) {
			\Illuminate\Support\Facades\File::delete($path);
		}
	}

}