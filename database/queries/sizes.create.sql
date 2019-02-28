create table `sizes`
(
    `id` int unsigned not null primary key auto_increment comment 'ID',
    `sake_id` int unsigned not null comment '日本酒 ID',
    `content` int unsigned not null comment '内容量',
    `price_before_tax` int unsigned not null comment '税抜き価格',
    `created_at` datetime not null default current_timestamp,
    `updated_at` datetime not null default current_timestamp,
    `deleted_at` datetime default null,
    foreign key (`sake_id`)
        references `sakes` (`id`)
        on update cascade
        on delete cascade
)
comment='日本酒のサイズと価格'
