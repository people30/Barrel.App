create table `sakes`
(
    `id` int unsigned not null primary key auto_increment comment 'ID',
    `slug` varchar(120) not null unique comment 'スラグ',
    `name` varchar(120) not null comment '銘柄',
    `order` varchar(120) not null comment '並べ替えキー',
    `bottle_filepath` varchar(200) default null comment 'ラベルまたは商品外観写真のファイルパス',
    `brewer_id` int unsigned not null comment '酒蔵 ID',
    `designation_id` int unsigned not null comment '特定名称',
    `taste_id` int unsigned not null comment '味の表現',
    `alcoholicity` double not null comment 'アルコール度 (>= 0, <= 1)',
    `raw_rice` varchar(40) not null comment '主原料米の品種',
    `rice_polishing_ratio` double not null comment '精米歩合 (>= 0, <= 1)',
    `text` text default null comment '説明',
    `created_at` datetime not null default current_timestamp,
    `updated_at` datetime not null default current_timestamp,
    `deleted_at` datetime default null,
    foreign key (`brewer_id`)
        references `brewers` (`id`)
        on update cascade
        on delete cascade,
    foreign key (`designation_id`)
        references `designations` (`id`)
        on update cascade
        on delete cascade,
    foreign key (`taste_id`)
        references `tastes` (`id`)
        on update cascade
        on delete cascade
)
comment='日本酒の銘柄'
