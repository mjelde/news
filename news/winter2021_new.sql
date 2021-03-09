-- winter2021_news.sql

SET foreign_key_checks = 0; -- turn off constraints temporarily

DROP TABLE if EXISTS winter2021_feeds;
DROP TABLE if EXISTS winter2021_feed_categories;

CREATE TABLE winter2021_feeds(
FeedID INT UNSIGNED NOT NULL AUTO_INCREMENT,
FeedName VARCHAR(255) DEFAULT '',
Description TEXT DEFAULT '',
DateAdded DATETIME,
LastUpdated TIMESTAMP DEFAULT 0 ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (FeedID)
)

CREATE TABLE winter2021_feed_categories(
FeedCategoryID INT UNSIGNED NOT NULL AUTO_INCREMENT,
CategoryName VARCHAR(255) DEFAULT '',
Category_Description TEXT DEFAULT '',
DateAdded DATETIME,
LastUpdated TIMESTAMP DEFAULT 0 ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (FeedCategoryID)
)

INSERT INTO winter2021_feeds VALUES (NULL,1,'Test Feed 1','Feed Name 1',NOW(),NOW());
INSERT INTO winter2021_feed_categories VALUES (NULL,1,'','Test Category 1',NOW(),NOW());

SET foreign_key_checks = 1; -- turn foreign key check back on