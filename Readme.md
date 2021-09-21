- [Doğrulama Hakkında](#doğrulama-hakkında)
- [Özellikleri](#özellikleri)
- [Gereklilikler](#gereklilikler)
- [Basit Kullanım](#basit-kullanım)
- [Kurallar](#kurallar)
- [Kurulum Ve Kural Tanımlama](#kurulum-ve-kural-tanımlama)
  - [Kurulum](#kurulum)
  - [Kural Tanımlama](#kural-tanımlama)
- [Parametre Gönderme](#parametre-gönderme)
# Doğrulama Hakkında
Bu doğrulama paketi, size kolay bir şekilde formları doğrulamanıza olanak sağlar. Basit mantık üzerinde işleyişi yatıyor. Kuralı tanımla, kuralı nesneye tanıt ve kuralı kullan şeklindedir.

`Illuminate\Validation` Laravel'den esinlenilmiştir. 

# Özellikleri
* Özel kurallar belirleme
* Özel hata mesajları belirleme
* Kullanım kolaylığı

# Gereklilikler
* composer 
* php >= 7.4.23
# Basit Kullanım
Paketi kurmadan önce basit kullanımına bakalım:
```php
$validation = new ahmetbarut\Validation\Validate();

$validation->setFields($_POST)->setRules(
    [
        "id" => ["required", "number"],
        "name" => ["string", "required"],
        "date" => ["date", "required"],
    ]
)->make();
```
`setFields` yöntemi, form alanlarını dizi şeklinde vermenizi sağlar.
`setRules` yöntemi, kurallardan geçecek olan alanları belirtmemizi sağlar.
`make` yöntemi, sıraya alınan işleri yürütür ve sonucu döndürür. Başarı durumunda `true`, başarısızlık durumunda ise hata mesajı döndürür.

# Kurallar
Kurallar, ilgili input alanlarının karşılaması gereken koşulları belirtmeyi sağlar. Yani basitçe ilgili input alanında sadece sayı ve 1-9 arasında değeri kabul ediyoruz normal durumda bunun için koşul yazıp, o şekilde doğrularız burda sorun yok ama birden fazla form alanı varsa ? Bu durumda sürekli kopyala/yapıştır yapmamız gerekebilir fakat burda kural yazınca ona bile gerek kalmıyor 1 defa yaz sürekli kullan ve karmaşayı da önlüyor.

# Kurulum Ve Kural Tanımlama
## Kurulum
Kurulum için `composer`'e ihtiyacımız var. [getcomposer.com](https://getcomposer.com/download) adresinden indirebilirsiniz.

```bash
    composer require ahmetbarut/validation
```
Eğer uygulamanızda Container(Kapsayıcı) kullanılıyorsa nesneyi kapsayıcı içinde oluşturmanız daha sağlıklı olur.

## Kural Tanımlama
Kural tanımlamak için öncelikle bu arayüzü `ahmetbarut\Validation\Validation\Rule` **implement** etmeniz gerekiyor. İlgili arayüzde 2 yöntemi ekletmek isteyecek. Bunlar: `check` ve `message`
`check` yönteminde, koşul yazmanızı sağlar ve duruma göre `bool` değer döndürmeniz gerekli.
`message` yönteminde eğer başarısızlık varsa ilgili mesaj geriye döndürülür.
Örenk Sınıf:
```php 
namespace ahmetbarut\Validation\Validation\Rules;

use ahmetbarut\Validation\Validation\Rule;

class Number implements Rule
{

    public function check(string $attr, string $value): bool
    {
        return is_numeric($value);
    }

    public function message(): string
    {
        return "Sayısal olmalıdır!";
    }
}
```
Bu sınıfı nesneye tanıtmak için nesneyi ilk oluşturduğumuzda verebiliriz. Bu arada nesneyi isteklerin ilk geldiği veya isteklerin geçtiği yerde oluşturmanız gerekli sonraki durumlarda böyle bir zorunluluk yok. Yani şöyle, eğer kural tanımlanacaksa belirttiğim şekilde olması gerekli. Sonraki durumda kuralların tutulduğu değişken `static` olduğu için nesneyi bir sonraki sefer ürettiğinizde yok olmaz önceki değerleri taşır.

Kural tanımlamanın 1 kuralı vardır. 
Dizi şeklinde verilmesi gerekir. Örn ["kural_adi" => Kural::class] kurala verilmek istenen isim ve sınıfın alan adı yani `namespace`.
Kuralı tanımlayalım :
```php
use ahmetbarut\Validation\Validate;
use ahmetbarut\Validation\Validation\Rule;

require_once "./vendor/autoload.php";

class Number implements Rule
{

    public function check(string $attr, string $value): bool
    {
        return is_numeric($value);
    }

    public function message(): string
    {
        return "Sayısal olmalıdır!";
    }
}

$validation = new ahmetbarut\Validation\Validate(["numara" => \Number::class]);

$validation->setFields($_POST)->setRules(
    [
        "id" => ["required", "numara"],
        "name" => ["string", "required"],
        "date" => ["date", "required"],
    ]
)->make();
```
Verilen form alanlarını nesne üzerinden almak istiyorsanız
```php
$validation = new ahmetbarut\Validation\Validate(["numara" => \Number::class]);

$validation->setFields($_POST)->setRules(
    [
        "id" => ["required", "numara"],
        "name" => ["string", "required"],
        "date" => ["date", "required"],
    ]
)->make();

$validation->getAllFields();
```

# Parametre Gönderme
Kurala parametre atanabiliyor. Ama öncesinde ilgili kuralın `__construct` yöntemi tanımlı olmalı. Onun dışında herhangi bir eklemeye ihtiyaç duymuyor.
```php
$validation = new ahmetbarut\Validation\Validate();

$validation->setFields($_POST)->setRules(
    [
        "id" => ["required",  new Max(50)],
        "name" => ["string", "required"],
        "date" => ["date", "required"],
    ]
)->make();

$validation->getAllFields();
```