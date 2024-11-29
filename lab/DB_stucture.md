# General
DB name : `klienci`
sort method : `utf8mb4_general_c`


# Tables
## klienci
```
CREATE TABLE IF NOT EXISTS `klienci` (
 `Id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
 `Nazwisko` varchar(40) NOT NULL ,
 `Wiek` tinyint(3) UNSIGNED NOT NULL,
 `Panstwo` enum('Polska','Niemcy','Wielka Brytania','Czechy') NOT NULL
DEFAULT 'Polska',
 `Email` varchar(50) NOT NULL,
 `Zamowienie` set('Java','PHP','CPP') NOT NULL DEFAULT 'PHP',
 `Platnosc` enum('Visa','Master Card','Przelew') NOT NULL DEFAULT
'Visa',
 PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```
### example use
```
INSERT INTO `klienci`(`Nazwisko`,`Wiek`,`Panstwo`,`Email`,`Zamowienie`,`Platnosc`) VALUES ('',...)
```

## users
```
CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`userName` varchar(100) NOT NULL,
`fullName` varchar(255) NOT NULL,
`email` varchar(100) NOT NULL,
`passwd` varchar(255) NOT NULL,
`status` int(1) NOT NULL,
`date` datetime NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `userName`
(`userName`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
AUTO_INCREMENT=1 ;
```
