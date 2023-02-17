<?php

namespace KlipeLD\TextToBarcode;

class Code128ToBarcode
{
    private static function testNumeric(array $text, int $i, int $mini) : int
    {
        $mini--;
        if ($i + $mini < count($text))
        {
            for (; $mini >= 0; $mini--)
            {
                if ((mb_ord($text[$i + $mini],'UTF-8') < 48) || (mb_ord($text[$i + $mini],'UTF-8') > 57))
                {
                    break;
                }
            }   
        } 
        return $mini;
    }

    public static function codeIt(String $textToCode) : string
    {
        $text = str_split($textToCode);
        $checksum = 0; 
        $tableB = true; 

        $code128 = "";

        foreach ($text as $c)
        {
            if (((mb_ord($c,'UTF-8') < 32) || (mb_ord($c,'UTF-8') > 126 && mb_ord($c,'UTF-8') != 203)))
            {
                return null;
            }
        }

        for ($i = 0; $i < count($text);)
        {
            if ($tableB)
            {
                $mini = (($i == 0) || ($i + 3 == count($text) - 1) ? 4 : 6);
                $mini = self::testNumeric($text, $i, $mini);
                if ($mini < 0)
                {
                    if ($i == 0)
                    {
                        $code128 = mb_chr(210,'UTF-8');
                    }
                    else
                    {
                        $code128 .= mb_chr(204,'UTF-8');
                    }
                    $tableB = false;
                }
                else if ($i == 0)
                {
                    $code128 = mb_chr(209, 'UTF-8');
                }
            }


            if (!$tableB)
            {
                $mini = self::testNumeric($text, $i, 2);

                if ($mini < 0)
                {
                    $char2 = intval($text[$i] . $text[$i + 1]);
                    $char2 += ($char2 < 95 ? 32 : 105);
                    $code128 .= mb_chr($char2, 'UTF-8');
                    $i += 2;
                }
                else
                {
                    $code128 .= mb_chr(205,'UTF-8');
                    $tableB = true;
                }
            }

            if ($tableB)
                $code128 .= $text[$i++];
        }
        $code128_temp = mb_str_split($code128,1,'UTF-8');
        for ($i = 0; $i < count($code128_temp); $i++)
        {
            $char2 = mb_ord($code128_temp[$i],'UTF-8');
            $char2 -= ($char2 < 127 ? 32 : 105);
            if ($i == 0)
            {

                $checksum = $char2;
            }
            $checksum = ($checksum + $i * $char2) % 103;

        }
        $checksum += ($checksum < 95 ? 32 : 105);
        $code128 .= mb_chr($checksum,'UTF-8') . mb_chr(211, 'UTF-8');

        return $code128;
    }

}