
<?php
//apps/frontend/lib/myValidatorPhone.class.php
/**
 * myValidatorPhone validates a phone number.
 *
 * @author Jason Swett (http://jasonswett.net/how-to-validate-and-sanitize-a-phone-number-in-symfony/)
 */
class myValidatorPhone extends sfValidatorBase
{
  protected function doClean($value)
  {
    $clean = (string) $value;

    $phone_number_pattern = '/^(\((\d{3})\)|(\d{3}))\s*[-\.]?\s*(\d{3})\s*[-\.]?\s*(\d{4})$/';

    if (!$clean && $this->options['required'])
    {
      throw new sfValidatorError($this, 'required');
    }

    // If the value isn't a phone number, throw an error.
    if (!preg_match($phone_number_pattern, $clean))
    {
      throw new sfValidatorError($this, 'invalid', array('value' => $value));
    }

    // Take out anything that's not a number.
    $clean = preg_replace('/[^0-9]/', '', $clean);

    // Split the phone number into its three parts.
    $first_part = substr($clean, 0, 3);
    $second_part = substr($clean, 3, 3);
    $third_part = substr($clean, 6, 4);

    // Format the phone number.
    $clean = '('.$first_part.') '.$second_part.'-'.$third_part;

    return $clean;
  }
}
