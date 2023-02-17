# text_to_barcode
Generate your code128 from text
## Installation
Install the package via composer: `composer require klipeld/text_to_barcode`
## Compatibility

 Name       | Min version
:-------------|:----------
 php        | 7.4
 
## How to use - Simple example

`
echo"
<style>
@font-face {
  font-family: myFirstFont;
  src: url(code128.ttf);
}
</style>
<div style='color: black; font-family: myFirstFont;font-size: 70px'>".Code128ToBarcode::codeIt("Hello world :)")."</div>";
`

## Which characters can be encoded in the barcode CODE-128?

Up to 70 characters can be encoded into the barcode CODE-128:
- large Latin letters (from A to Z);
- digits (from 0 to 9);
- some special characters (!"#$%^&*()-=|\/:;,'."~+-_*{}[]:).

The character set allows you to put on the card not only a barcode with a number, for example 00001, but also cards with an identifier designation containing a letter prefix (for example, AC0001) or fully alphabetic values.

## Demo-version of app based on this package:

https://php-developer-polska.pl/en/barcode/code128