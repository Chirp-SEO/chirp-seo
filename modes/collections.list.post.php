<?php

    echo $HTML->title_panel([
      'heading' => $Lang->get('Summary'),
    ], $CurrentUser);

    if ($error) echo $error; 
    if ($message) echo $message;

    if (PerchUtil::count($collections)) {

        $Listing = new PerchAdminListing($CurrentUser, $HTML, $Lang, $Paging);

        $Listing->add_col([
            'title'     => 'Title',
            'value'     => 'collectionKey',
            'sort'      => 'collectionKey',
            'edit_link' => 'collection',
        ]);
        
        $Listing->add_col([
            'title'     => 'Items',
            'value'     => 'get_item_count'
        ]);
            
        echo $Listing->render($collections);

      }
      ?>
