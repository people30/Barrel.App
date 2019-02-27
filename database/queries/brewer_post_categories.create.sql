create table `brewer_post_categories`
(
    `brewer_id` int unsigned not null,
    `post_category_id` int unsigned not null,
    primary key (`brewer_id`, `post_category_id`),
    foreign key (`brewer_id`)
        references `brewers` (`id`)
        on update cascade
        on delete cascade
)
comment='酒蔵の投稿のカテゴリ'
