<?php

use DiDom\Document;

defined('LIBXML_HTML_NODEFDTD') || define ('LIBXML_HTML_NODEFDTD', 4);

class ChirpSeo_Parser
{

  protected $url;
  protected $dom;

  function __construct($url = "")
  {
    $this->url = $url;
    $this->errorMessage = false;
    $this->dom = false;

    try {
      $this->dom = new Document($url, true);
    } catch (Exception $e) {
      $this->errorMessage = $e->getMessage();
    }
  }

  function get_all_contents() {
    if (!$this->dom) {
      return false;
    }
  
    try {
      $all = $this->dom->find('p');
      return $all;
    } catch (Exception $e) {
      return false;
    }
  }

  function get_title_contents() {
    if (!$this->dom) {
      return false;
    }
  
    try {
      $titles = $this->dom->find('h1, h2, h3, h4, h5');
      return $titles;
    } catch (Exception $e) {
      return false;
    }
  }

  function get_paragraph_contents() {
    if (!$this->dom) {
      return false;
    }

    try {
      $paragraphs = $this->dom->find('p, ul');
      return $paragraphs;
    } catch (Exception $e) {
      return false;
    }
  }

  function get_image_tags() {
    if (!$this->dom) {
      return false;
    }

    try {
      $imgs = $this->dom->find('img');
      return $imgs;
    } catch (Exception $e) {
      return false;
    }
  }

  function get_meta_description() {
    if (!$this->dom) {
      return false;
    }

    try {
      $meta = $this->dom->find('meta[name="description"]');

      if (!empty($meta)) {
        $text = $meta[0]->getAttribute("content");
        return $text;
      }
    } catch (Exception $e) {
      return false;
    }
  }

  function get_og_url() {
    if (!$this->dom) {
      return false;
    }

    try {
      $meta = $this->dom->find('meta[property="og:url"]');

      if (!empty($meta)) {
        $text = $meta[0]->getAttribute("content");
        return $text;
      }
    } catch (Exception $e) {
      return false;
    }
  }

  function get_og_title() {
    if (!$this->dom) {
      return false;
    }

    try {
      $meta = $this->dom->find('meta[property="og:title"]');

      if (!empty($meta)) {
        $text = $meta[0]->getAttribute("content");
        return $text;
      }
    } catch (Exception $e) {
      return false;
    }
  }

  function get_og_description() {
    if (!$this->dom) {
      return false;
    }

    try {
      $meta = $this->dom->find('meta[property="og:description"]');

      if (!empty($meta)) {
        $text = $meta[0]->getAttribute("content");
        return $text;
      }
    } catch (Exception $e) {
      return false;
    }
  }

  function get_og_image() {
    if (!$this->dom) {
      return false;
    }

    try {
      $meta = $this->dom->find('meta[property="og:image"]');

      if (!empty($meta)) {
        $text = $meta[0]->getAttribute("content");
        return $text;
      }
    } catch (Exception $e) {
      return false;
    }
  }

  function get_canonical() {
    if (!$this->dom) {
      return false;
    }

    try {
      $meta = $this->dom->find('link[rel="canonical"]');

      if (!empty($meta)) {
        $text = $meta[0]->getAttribute("href");
        return $text;
      }
    } catch (Exception $e) {
      return false;
    }
  }

  function get_meta_description_snippet() {
    $snippet_meta_description = $this->get_meta_description();

    if (strlen($snippet_meta_description)> 160) {
      $snippet_meta_description = substr($snippet_meta_description, 0, 160).'...';
    }

    return $snippet_meta_description;
  }

  function get_page_title() {
    if (!$this->dom) {
      return false;
    }
  
    try {
      $meta = $this->dom->find('head title');

      if (!empty($meta)) {
        $text = $meta[0]->text();
        return $text;
      }
    } catch (Exception $e) {
      return false;
    }
  }

  function get_title_snippet() {
    $snippet_title = $this->get_page_title();

    if (strlen($snippet_title) > 55) {
      $snippet_title = substr($snippet_title, 0, 55).'...';
    }

    return $snippet_title;
  }

}
