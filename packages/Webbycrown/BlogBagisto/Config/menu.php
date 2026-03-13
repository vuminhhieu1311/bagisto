<?php

return [

    /**
     * Blog.
     */
    [
        'key' => 'blog',
        'name' => 'Blog',
        'route' => 'admin.blog.index',
        'sort' => 3,
        // 'icon' => 'icon-blog',
        'icon' => 'icon-attribute',
    ],
    [
        'key'        => 'blog.blogs',
        'name'       => 'Bài viết',
        'route'      => 'admin.blog.index',
        'sort'       => 1,
        'icon'       => '',
    ],
    [
        'key'        => 'blog.category',
        'name'       => 'Danh mục',
        'route'      => 'admin.blog.category.index',
        'sort'       => 2,
        'icon'       => '',
    ],
    [
        'key'        => 'blog.tag',
        'name'       => 'Thẻ',
        'route'      => 'admin.blog.tag.index',
        'sort'       => 3,
        'icon'       => '',
    ],
    [
        'key'        => 'blog.comment',
        'name'       => 'Bình luận',
        'route'      => 'admin.blog.comment.index',
        'sort'       => 4,
        'icon'       => '',
    ],
    [
        'key'        => 'blog.setting',
        'name'       => 'Cài đặt',
        'route'      => 'admin.blog.setting.index',
        'sort'       => 5,
        'icon'       => '',
    ],
    [
        'key'        => 'blog.import_export',
        'name'       => 'Nhập/Xuất',
        'route'      => 'admin.blog.import.export',
        'sort'       => 6,
        'icon'       => '',
    ],

];
