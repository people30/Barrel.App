create table `links`
(
    `id` int unsigned not null primary key auto_increment comment 'ID',
    `brewer_id` int unsigned not null comment '酒蔵 ID',
    `service` enum('website','twitter','facebook','instagram') not null comment 'サービス名',
    `url` varchar(200) not null comment 'URL',
    `created_at` datetime not null default current_timestamp,
    `updated_at` datetime not null default current_timestamp,
    `deleted_at` datetime default null,
    foreign key (`brewer_id`)
        references `brewers` (`id`)
        on update cascade
        on delete cascade
)
comment='酒蔵の関連リンク'
