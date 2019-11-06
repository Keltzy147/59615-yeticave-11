INSERT INTO categories SET NAME = 'Доски и лыжи', link = 'boards';
INSERT INTO categories SET name = 'Крепления', link = 'attachment';
INSERT INTO categories SET name = 'Ботинки', link = 'boots';
INSERT INTO categories SET name = 'Одежда', link = 'clothing';
INSERT INTO categories SET name = 'Инструменты', link = 'tools';
INSERT INTO categories SET name = 'Разное', link = 'other';

INSERT INTO users SET email = 'john@gmail.ru', NAME = 'Джон', PASSWORD = '1111', contacts = 'Волгоград';
INSERT INTO users SET email = 'alex@mail.ru', NAME = 'Александр', PASSWORD = '1111', contacts = 'Краснодар';


INSERT INTO lots SET user_id = 1,
                     category_id = 1,
                     winner_id = 0,
                     name = '2014 Rossignol District Snowboard',
                     description = 'Описание товара',
                     img = 'img/lot-1.jpg',
                     first_price = 10999,
                     expiry_date = '2019-11-07',
                     step = 1000;

INSERT INTO lots SET user_id = 1,
                     category_id = 1,
                     winner_id = 0,
                     name = 'DC Ply Mens 2016/2017 Snowboard',
                     description = 'Описание товара',
                     img = 'img/lot-2.jpg',
                     first_price = 159999,
                     expiry_date = '2019-11-07',
                     step = 10000;

INSERT INTO lots SET user_id = 2,
                     category_id = 2,
                     winner_id = 0,
                     name = 'Крепления Union Contact Pro 2015 года размер L/XL',
                     description = 'Описание товара',
                     img = 'img/lot-3.jpg',
                     first_price = 8000,
                     expiry_date = '2019-11-07',
                     step = 500;

INSERT INTO lots SET user_id = 2,
                     category_id = 3,
                     winner_id = 0,
                     name = 'Ботинки для сноуборда DC Mutiny Charocal',
                     description = 'Описание товара',
                     img = 'img/lot-4.jpg',
                     first_price = 10999,
                     expiry_date = '2019-11-07',
                     step = 500;

INSERT INTO lots SET user_id = 1,
                     category_id = 4,
                     winner_id = 0,
                     name = 'Куртка для сноуборда DC Mutiny Charocal',
                     description = 'Описание товара',
                     img = 'img/lot-5.jpg',
                     first_price = 7500,
                     expiry_date = '2019-11-07',
                     step = 500;

INSERT INTO lots SET user_id = 1,
                     category_id = 6,
                     winner_id = 0,
                     name = 'Маска Oakley Canopy',
                     description = 'Описание товара',
                     img = 'img/lot-6.jpg',
                     first_price = 5400,
                     expiry_date = '2019-11-07',
                     step = 500;

INSERT INTO bets SET user_id = 1, lot_id = 1, price = 11999;
INSERT INTO bets SET user_id = 3, lot_id = 1, price = 12999;