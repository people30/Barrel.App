create table `cities`
(
    `prefecture_code` smallint unsigned not null comment '都道府県コード',
    `city_code` smallint unsigned not null unique comment '市区町村コード',
    `area_id` int unsigned not null comment '地域',
    `name` varchar(20) not null comment '名前',
    `order` varchar(40) not null comment '並べ替えキー',
    primary key (`prefecture_code`, `city_code`),
    foreign key (`prefecture_code`)
        references `prefectures` (`code`)
        on update cascade
        on delete cascade,
    foreign key (`area_id`)
        references `areas` (`id`)
        on update cascade
        on delete cascade
)
comment='市区町村'
