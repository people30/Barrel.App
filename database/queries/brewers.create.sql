create table `brewers`
(
    `id` int unsigned not null primary key auto_increment comment 'ID',
    `slug` varchar(120) not null unique comment 'スラグ',
    `name` varchar(120) not null comment '名前',
    `order` varchar(120) not null comment '並べ替えキー',
    `phone_number` varchar(10) default null comment '代表電話番号',
    `fax_number` varchar(10) default null comment '代表 FAX 番号',
    `email` varchar(100) default null comment 'メール アドレス',
    `city_code` smallint unsigned not null comment '市区町村',
    `town` varchar(80) default null comment '街区・番地等',
    `lat` double not null comment '緯度',
    `lan` double not null comment '経度',
    `owner` varchar(20) default null comment '代表者',
    `toji` varchar(20) default null comment '杜氏',
    `buisiness_day` varchar(80) not null comment '営業日',
    `opening_time` time not null comment '開店時刻',
    `closing_time` time not null comment '閉店時刻',
    `can_visit_backstage` boolean not null comment '酒蔵の見学可か',
    `key_visual_filepath` varchar(200) default null comment 'キー ビジュアルのファイルパス',
    `text` text default null comment '説明',
    `created_at` datetime not null default current_timestamp,
    `updated_at` datetime not null default current_timestamp,
    `deleted_at` datetime default null,
    foreign key (`city_code`)
        references `cities` (`city_code`)
        on update cascade
        on delete cascade
)
comment='酒蔵'
