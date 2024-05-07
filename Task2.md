
Задача №2.

Имеется 3 таблицы: info, data, link, есть запрос для получения данных:

select * from data.link,info where link.info_id = info.id and link.data_id = data.id


предложить варианты оптимизации:
·	таблиц
·	запроса.
Запросы для создания таблиц:

CREATE TABLE `info` (
        `id` int(11) NOT NULL auto_increment,
       `name` varchar(255) default NULL,
        `desc` text default NULL,
        PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

CREATE TABLE `data` (
        `id` int(11) NOT NULL auto_increment,
        `date` date default NULL,
        `value` INT(11) default NULL,
        PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

CREATE TABLE `link` (
        `data_id` int(11) NOT NULL,
        `info_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

Ответы:
1. В самом запросе лучше не использовать *,  а перечислить конкретные поля выборки
2. Создать индексы. Например изменить таблицу link

ALTER TABLE link ADD INDEX data_id_index (data_id); 
ALTER TABLE link ADD INDEX info_id_index (info_id);

3. Использовать JOIN. Например


SELECT info.name, info.desc, data.date, data.value
FROM data
JOIN link ON link.data_id = data.id
JOIN info ON link.info_id = info.id;
