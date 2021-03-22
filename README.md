## Image annotation tool

This is a simple prototype of an annotation web tool for medical images.

#### Basic functionality

The tool allows to navigate a set of images, mark regions of interest, stored them in the database (roi column) and displayed them back if needed.

#### Requirements

1) For the website to work you need a mysql database with the following structure:

* Table: **annotatedimages**
  Columns:
  * **image** : image name - type: char(50)
  *  **roi** : string with the position of the marks [[x1,y1],[x2,y2],...,] - type: pixelesvarchar(100)
  *  **checked** : indicates if the image was checked already or not - type: bool
  *  **idx** : automatic index - type: int(50) not null auto_increment primary key
  *  **time** : meant to store the last modification date but it is NOT implemented in the code - type: timestamp 

The database should be loaded with the names of the images available in the ./images folder.

Example of the initial state of the database:

| idx  | image           | roi  | checked | time |
| ---- | --------------- | ---- | ------- | ---- |
| 1    | 122788_L_CC.png | ""   | 0       | 0    |
| 2    | 145972_L_CC.png | ""   | 0       | 0    |
| 3    | 160074_L_CC.png | ""   | 0       | 0    |
| 4    | 184381_L_CC.png | ""   | 0       | 0    |

2) config.php file in the root directory containing the information of the database (this is not the safest way of doing it because the password is stored as a string, but it is good enough for a prototype).

Example:

```php
<?php
// config.php
$config = array(
	"dbname" => "image_database",
	"dbuser" => "username",
	"dbpass" => "password",
);

?>
```

