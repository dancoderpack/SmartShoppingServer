# Умный выбор
## Сервер для мобильного приложения
[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://travis-ci.org/joemccann/dillinger)
[![N|Solid](https://www.beloe.taxi/images/Google.png)](https://play.google.com/store/apps/details?id=com.conlage.smartshopping)
Мобильное приложение, предназначенное для умных покупок. 
Составляйте список покупок, сравнивайте товары, выбирайте лучшие по цене и качеству.
Доступно для скачивания в Google Play.
### Основное
- Язык: php 8.4
- Framework: Laravel
- Developer: Harenkov Daniil

[Ссылка на репозиторий Android приложения](https://github.com/KirillZaZa/SmartShopping/blob/master/README.md?plain=1)

# API

## Получение товара по штрихкоду

Данный метод возвращает данные о товаре по его штрихкоду
```sh
 products/barcode/{barcode}
```

## Получение товара по ключевому слову

Поиск
```sh
 products/search/{keyword}
```

## Получение товара по ID

(Если он известен)
```sh
 products/id/{id}
```

Разработка клиентской части велась **Захарчёнком Кириллом**.
Ссылка на github: [KirillZaZa](https://github.com/KirillZaZa)
Разработка серверной части велась **Даниилом Харенковым**.
Ссылка на github: [dancoderpack](https://github.com/dancoderpack)
## License
MIT
