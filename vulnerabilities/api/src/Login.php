<?php

namespace Src;

use OpenApi\Attributes as OAT;

class Login
{
	private const ACCESS_TOKEN_LIFE = 180;
	private const REFRESH_TOKEN_LIFE = 240;

	private static function secret($name) {
		$value = getenv($name);
		if ($value === false || $value === '') {
			throw new \RuntimeException("$name is not configured");
		}
		return $value;
	}

	private static function access_token_secret() {
		return self::secret('ACCESS_TOKEN_SECRET');
	}

	private static function refresh_token_secret() {
		return self::secret('REFRESH_TOKEN_SECRET');
	}
	
	public static function create_token() {
		$now = time();
		$tokenObj = new Token();
		$token = json_encode (array (
			"access_token" => $tokenObj->create_token(self::access_token_secret(), $now + self::ACCESS_TOKEN_LIFE),
			"refresh_token" => $tokenObj->create_token(self::refresh_token_secret(), $now + self::REFRESH_TOKEN_LIFE),
			"token_type" => "bearer",
			"expires_in" => self::ACCESS_TOKEN_LIFE)
		);
		return $token;
	}

	public static function check_access_token($token) {
		$tokenObj = new Token();
		$decrypted = $tokenObj->decrypt_token ($token);

		if ($decrypted === false) {
			return false;
		}
		if (hash_equals(self::access_token_secret(), (string) ($decrypted['secret'] ?? '')) && $decrypted['expires'] > time()) {
			return true;
		}
		return false;
	}

	public static function check_refresh_token($token) {
		$tokenObj = new Token();
		$decrypted = $tokenObj->decrypt_token ($token);

		if ($decrypted === false) {
			return false;
		}
		if (hash_equals(self::refresh_token_secret(), (string) ($decrypted['secret'] ?? '')) && $decrypted['expires'] > time()) {
			return true;
		}
		return false;
	}
}
