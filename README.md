# SiteIndexer

A simple script to scrape basic content from a list of webpages and export it as JSON.
Used in combination with a lightweight search framework, basic static searching can be achieved.

### Getting Started
- Clone this repo
- run `composer install` for dependencies
- run `php leadIndexer.php` to index all public pages at https://indeed.com/lead
- results will be saved in a json file within the "dist" folder.