# WordPress
UPDATE wp_posts SET guid = replace(guid, 'www.perthdentalcentre.com.au','banksiagrovedental.local');

UPDATE wp_posts SET post_content = replace(post_content, 'www.perthdentalcentre.com.au', 'banksiagrovedental.local');

UPDATE wp_postmeta SET meta_value = replace(meta_value,'www.perthdentalcentre.com.au','banksiagrovedental.local');
