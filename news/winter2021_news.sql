-- winter2021_news.sql

SET
    foreign_key_checks = 0; -- turn off constraints temporarily
    
DROP TABLE IF EXISTS
    winter2021_feeds;
    
DROP TABLE IF EXISTS
    winter2021_feed_categories;
    
CREATE TABLE winter2021_feeds(
    FeedID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    FeedName VARCHAR(255) DEFAULT '',
    FeedDescription TEXT DEFAULT '',
    PRIMARY KEY(FeedID)
);

CREATE TABLE winter2021_feed_categories(
    FeedCategoryID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    FeedID INT DEFAULT 0,
    CategoryName VARCHAR(255) DEFAULT '',
    CategoryURL TEXT DEFAULT '',
    PRIMARY KEY(FeedCategoryID)
);

INSERT INTO winter2021_feeds
VALUES(
    NULL,
    'Test Feed 1', 
    'Feed Name 1'
);


INSERT INTO winter2021_feed_categories
VALUES(
    NULL,
    1,
    'Test Category1',
    'www.test-category.com'
);

SET
    foreign_key_checks = 1; -- turn foreign key check back on