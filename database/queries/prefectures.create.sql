create table `prefectures`
(
    `prefecture_code` smallint unsigned not null primary key comment '都道府県コード',
    `name` varchar(4) not null comment '名前',
    `order` varchar(10) not null comment '並べ替えキー'
)
comment='都道府県'
