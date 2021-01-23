<?php

  $nav = [];
  
  $nav[] = [
    'page' => [
        'chirp_seo',
        'chirp_seo/content/view'
    ],
    'label' => 'Pages'
  ];

  if (PERCH_RUNWAY) {
    $nav[] = [
      'page' => [
          'chirp_seo/collections',
          'chirp_seo/collections/collection',
          'chirp_seo/collections/collection/view'
      ],
      'label' => 'Collections'
		];
  }

  if (class_exists('PerchBlog_Blogs')) {
    $nav[] = [
			'page' => [
					'chirp_seo/blog',
					'chirp_seo/blog/view'
			],
			'label' => 'Blog'
		];
  }

  if (class_exists('PerchShop_Products')) {
    $nav[] = [
			'page' => [
					'chirp_seo/shop',
					'chirp_seo/shop/view'
			],
			'label' => 'Shop'
		];
  }

  $nav[] = [
    'page' => [
        'chirp_seo/sitemap',
    ],
    'label' => 'Sitemap'
  ];

	PerchUI::set_subnav($nav, $CurrentUser);
