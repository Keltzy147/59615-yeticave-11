INSERT INTO categories SET NAME = '����� � ����', link = 'boards';
INSERT INTO categories SET name = '���������', link = 'attachment';
INSERT INTO categories SET name = '�������', link = 'boots';
INSERT INTO categories SET name = '������', link = 'clothing';
INSERT INTO categories SET name = '�����������', link = 'tools';
INSERT INTO categories SET name = '������', link = 'other';

INSERT INTO users SET email = 'john@gmail.ru', NAME = '����', PASSWORD = '1111', contacts = '���������';
INSERT INTO users SET email = 'alex@mail.ru', NAME = '���������', PASSWORD = '1111', contacts = '���������';


INSERT INTO lots SET user_id = 1,
                     category_id = 1,
                     winner_id = 0,
                     name = '2014 Rossignol District Snowboard',
                     description = '�������� ������',
                     img = 'img/lot-1.jpg',
                     first_price = 10999,
                     expiry_date = '2019-11-07',
                     step = 1000;

INSERT INTO lots SET user_id = 1,
                     category_id = 1,
                     winner_id = 0,
                     name = 'DC Ply Mens 2016/2017 Snowboard',
                     description = '�������� ������',
                     img = 'img/lot-2.jpg',
                     first_price = 159999,
                     expiry_date = '2019-11-07',
                     step = 10000;

INSERT INTO lots SET user_id = 2,
                     category_id = 2,
                     winner_id = 0,
                     name = '��������� Union Contact Pro 2015 ���� ������ L/XL',
                     description = '�������� ������',
                     img = 'img/lot-3.jpg',
                     first_price = 8000,
                     expiry_date = '2019-11-07',
                     step = 500;

INSERT INTO lots SET user_id = 2,
                     category_id = 3,
                     winner_id = 0,
                     name = '������� ��� ��������� DC Mutiny Charocal',
                     description = '�������� ������',
                     img = 'img/lot-4.jpg',
                     first_price = 10999,
                     expiry_date = '2019-11-07',
                     step = 500;

INSERT INTO lots SET user_id = 1,
                     category_id = 4,
                     winner_id = 0,
                     name = '������ ��� ��������� DC Mutiny Charocal',
                     description = '�������� ������',
                     img = 'img/lot-5.jpg',
                     first_price = 7500,
                     expiry_date = '2019-11-07',
                     step = 500;

INSERT INTO lots SET user_id = 1,
                     category_id = 6,
                     winner_id = 0,
                     name = '����� Oakley Canopy',
                     description = '�������� ������',
                     img = 'img/lot-6.jpg',
                     first_price = 5400,
                     expiry_date = '2019-11-07',
                     step = 500;

INSERT INTO bets SET user_id = 1, lot_id = 1, price = 11999;
INSERT INTO bets SET user_id = 3, lot_id = 1, price = 12999;