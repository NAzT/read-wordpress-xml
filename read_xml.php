<?php

#$a = simplexml_load_file("/Users/nat/Downloads/thainetizennetwork.wordpress.2014-02-26-5--904k.xml");
#$xml = simplexml_load_string(file_get_contents("/Users/nat/Downloads/thainetizennetwork.wordpress.2014-02-26-2--7mb.xml"));
$xml = simplexml_load_file("/Users/nat/Downloads/thainetizennetwork.wordpress.2014-02-26-2--7mb copy.xml");
$namespaces = $xml->getNameSpaces(true);
$namespaces = $xml->getNameSpaces(TRUE);
// $docs_id = explode(" ", "136 137 138 139 140 141 142 143 144 145 421 483 485 486 487 488 489 493 494 495 496 497 541 554 581 598 599 600 601 602 603 620 626 627 628 629 630 631 632 633 634 635 638 639 640 642 643 644 649 650 651 662 677 678 680 704 733 734 2378 2386 2422 2423 2443 2541 2549 2562 2569 2585 2592 2593 2609 2627 2628 2630 2631 2632 2637 2638 2639 2640 2642 2658 2660 5486 5794 6111 6531 6561 6586 6694");
$rows = array();

$private_posts_ids = array();

$item = $xml->channel->item;
foreach ($xml->channel->item as $item) {
  $currentRow = new stdClass;
  // Pull non-namespaced items
  foreach ($item as $name => $value) {
    // Special-case tags and categories, where we want to pull the
    // nicename attribute
    if ($name == 'category') {
      $attributes = $value->attributes();
      $domain = $attributes['domain'];
      $nicename = $attributes['nicename'];
      // Capture the nicename attribute and the value
      if ($domain == 'category') {
        $currentRow->category[] = (string)$nicename;
        $currentRow->category_value[] = (string)$value;
      }
      // 'tag' for WXR 1.0, 'post_tag' for WXR 1.1
      else if ($domain == 'tag' || $domain == 'post_tag') {
        $currentRow->tag[] = (string)$nicename;
        $currentRow->tag_value[] = (string)$value;
      }
    }
    else {
      $currentRow->$name = (string)$value;
    }
  }

  // list all namespaces
  $namespaces = $item->getNameSpaces(TRUE);

  //filter only wp namespace

  $wp_post = $item->children($namespaces['wp']);
  if ($wp_post->status == 'private') {
    $private_posts_ids[] = (int)$wp_post->post_id;
    //echo $item->asXML(); echo "\n\n";
  }
 }

 print_r($private_posts_ids);

?>
