# Aplikacion Web PHP me OOP dhe MVC

Ky projekt është një aplikacion web i zhvilluar në PHP duke përdorur konceptet e Programimit të Orientuar në Objekte (OOP) dhe arkitekturën Model-View-Controller (MVC). Aplikacioni është ndërtuar për të funksionuar në mjedisin lokal përmes XAMPP.

## Funksionalitetet Kryesore

### Faqet Publike

* Faqja kryesore me përmbajtje dinamike
* Seksioni “Rreth Nesh”
* Lista e produkteve me detaje dhe shkarkim PDF
* Seksioni i lajmeve me artikuj dhe imazhe
* Forma e kontaktit për dërgimin e mesazheve

### Paneli i Administrimit

* Dashboard me statistika
* Menaxhimi i produkteve
* Menaxhimi i lajmeve
* Menaxhimi i faqeve dinamike
* Menaxhimi i mesazheve të kontaktit

### Karakteristikat Teknike

* Strukturë OOP
* Arkitekturë MVC
* Lidhje me databazë përmes PDO
* Hashing i fjalëkalimeve me BCrypt
* Menaxhim i sesioneve dhe autentifikimit
* Ngarkim i sigurt i skedarëve
* Dizajn responsive
* Menaxhim i gabimeve me try-catch

---

# Struktura e Projektit

```plaintext id="h6ref6"
AgjensiLajmesh/
├── config/
├── controllers/
├── models/
├── views/
├── public/
├── sql/
├── index.php
└── README.md
```

### Folderët Kryesorë

* **config/** – Konfigurimi i databazës
* **controllers/** – Logjika e aplikacionit
* **models/** – Komunikimi me databazën
* **views/** – Ndërfaqja vizuale
* **public/** – CSS, JavaScript dhe uploads
* **sql/** – Struktura e databazës

---

# Instalimi dhe Konfigurimi

## Kërkesat

* XAMPP
* PHP 7.4+
* MySQL/MariaDB
* Web browser

## Hapat e Instalimit

1. Vendosja e projektit në `htdocs`
2. Nisja e Apache dhe MySQL në XAMPP
3. Importimi i databazës përmes phpMyAdmin
4. Hapja e aplikacionit në:

   ```plaintext
   http://localhost/AgjensiLajmesh/
   ```

## Qasja në Panelin Admin

```plaintext id="jbg3jm"
Email: admin@example.com
Password: admin123
```

---

# Konfigurimi i Databazës

Në file-in `config/Database.php` përcaktohen parametrat e lidhjes:

```php id="z5fxfd"
private $host = 'localhost';
private $db_name = 'website_db';
private $username = 'root';
private $password = '';
```

---

# Funksionimi i Aplikacionit

## Faqja Kryesore

Shfaq lajmet më të fundit dhe produktet kryesore.

## Produktet

* Lista e produkteve
* Detajet individuale
* Shkarkimi i PDF-ve

## Lajmet

* Artikuj me imazh dhe përmbajtje të plotë

## Kontaktet

* Dërgimi i mesazheve përmes formës së kontaktit

---

# Databaza

Aplikacioni përdor tabelat:

* `users`
* `products`
* `news`
* `contacts`
* `pages`

### Shembuj të të dhënave:

* përdoruesit
* produktet
* lajmet
* mesazhet e kontaktit
* faqet dinamike

---

# Siguria në Aplikacion

Janë implementuar:

* Hashing i fjalëkalimeve
* Parandalimi i SQL Injection me PDO Prepared Statements
* Mbrojtje nga XSS
* Autentifikim me sesione
* Kontroll i roleve të përdoruesve
* Validim i upload-eve

---

# Përfundim

Ky projekt demonstron përdorimin praktik të PHP OOP dhe MVC për ndërtimin e një aplikacioni web të organizuar, të sigurt dhe të lehtë për mirëmbajtje. Struktura e ndarë në modele, pamje dhe kontrollues ndihmon në organizimin më të mirë të kodit dhe në zhvillimin e funksionaliteteve të reja në mënyrë efikase.
