<?php

namespace App\Helpers;

class PhoneNumberHelper
{
	/**
	 * @param $number
	 * @return bool|mixed|string
	 */
	public static function getNumber( $number )
	{
		$numbersOnly = preg_replace('/[^0-9]/', '', $number);

		$phoneNumber = self::getPhoneNumber( $numbersOnly );

		return $phoneNumber;
	}

	/**
	 * @param $number
	 * @return bool|null|string
	 */
	public static function getExtension( $number )
	{
		$numbersOnly = preg_replace('/[^0-9]/', '', $number);

		$count = strlen($numbersOnly);

		$extension = null;

		if ( $count  > 10 )
		{
			$extension = substr($numbersOnly, 10, $count - 10);
		}

		return $extension;
	}

	/**
	 * @param $numbersOnly
	 * @return bool|mixed|string
	 */
	private static function getPhoneNumber( $numbersOnly )
	{
		$phoneNumber = substr($numbersOnly, 0, 10);
		$phoneNumber = substr_replace($phoneNumber, '-', 3, 0);
		$phoneNumber = substr_replace($phoneNumber, '-', 7, 0);

		return $phoneNumber;
	}
}