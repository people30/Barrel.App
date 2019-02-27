create table `areas`
(
    `id` int unsigned not null primary key auto_increment comment 'ID',
    `prefecture_code` smallint unsigned not null comment '都道府県コード',
    `name` varchar(20) not null comment '名前',
    `order` varchar(40) not null comment '並べ替えキー',
    foreign key (`prefecture_code`)
        references `prefectures` (`prefecture_code`)
        on update cascade
        on delete cascade
)
comment='地域'
