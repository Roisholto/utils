<?php
namespace Roi\Utils\Validation ;

trait ValidatePhone {

public static function validatePhone($phone, $localization=null , array $accept=[0,1,2,9,7])
	{
  // $accept imply the type of phone number that is accceptable

	$return = false;
	$phoneNumberUtil = \libphonenumber\PhoneNumberUtil::getInstance();

	$phone =trim($phone) ;
	if ($phone != '')
		{
		try
			{
			// see	https://github.com/giggsey/libphonenumber-for-php/blob/master/docs/PhoneNumberUtil.md
			// should localization be null, then $phone is expected to be in international format
			$phoneNumberObject = $phoneNumberUtil->parse($phone, $localization);

			if($phoneNumberUtil->isValidNumber($phoneNumberObject))
				{
				if(
					(count($accept) and in_array($phoneNumberUtil->getNumberType($phoneNumberObject), $accept))
						or
						!count($accept)
						)
					$return =[
						'localization'=>$phoneNumberUtil->getRegionCodeForNumber($phoneNumberObject),
						'number'=>$phoneNumberUtil->format($phoneNumberObject , \libphonenumber\PhoneNumberFormat::E164)
					];
				}
			}
		catch(\libphonenumber\NumberParseException $e)
			{
			$e ;
			}
		}
	return $return ;
	}

// could as well just default self::validate_phone to ($phone,'NG', [0,1,2,9,7])
public static function validatePhoneNG($phone)
	{
	return static::validatePhone($phone,'NG',[0,1,2,9,7]) ;
	}

}
?>
