CREATE DATABASE Fanfiction;
USE Fanfiction;

CREATE TABLE FanficData (
    FanficID int NOT NULL AUTO_INCREMENT,
    Title varchar(255) NOT NULL,
    Author varchar(255) NOT NULL,
    PubDate varchar(10) NOT NULL,
    WordCount int NOT NULL,
    Summary varchar(1023) NOT NULL,
    Keywords varchar(1023) NOT NULL,
    Link varchar(1023) NOT NULL,
    UNIQUE(Title,Author),
    CHECK(WordCount>=0),
    PRIMARY KEY(FanficID)
);

INSERT INTO FanficData VALUES
(NULL, "ExTitle1", "ExAuthor1", "01/01/2001", 1000, "ExSummary", "Key1, Key2, Key3", "https://archiveofourown.org/"),
(NULL, "ExTitle2", "ExAuthor1", "02/02/2002", 2000, "ExSummary", "Key2, Key3, Key4", "https://archiveofourown.org/"),
(NULL, "ExTitle3", "ExAuthor1", "03/03/2003", 3000, "ExSummary", "Key3, Key4, Key5", "https://archiveofourown.org/"),
(NULL, "ExTitle4", "ExAuthor2", "04/04/2004", 4000, "ExSummary", "Key4, Key5, Key6", "https://archiveofourown.org/"),
(NULL, "ExTitle5", "ExAuthor2", "05/05/2005", 5000, "ExSummary", "Key5, Key6, Key7", "https://archiveofourown.org/"),
(NULL, "ExTitle6", "ExAuthor2", "06/06/2006", 6000, "ExSummary", "Key6, Key7, Key8", "https://archiveofourown.org/"),
(NULL, "ExTitle7", "ExAuthor3", "07/07/2007", 7000, "ExSummary", "Key7, Key8, Key9", "https://archiveofourown.org/"),
(NULL, "ExTitle8", "ExAuthor3", "08/08/2008", 8000, "ExSummary", "Key8, Key9, Key10", "https://archiveofourown.org/"),
(NULL, "ExTitle9", "ExAuthor3", "09/09/2009", 9000, "ExSummary", "Key9, Key10, Key11", "https://archiveofourown.org/"),
(NULL, "ExTitle10", "ExAuthor4", "10/10/2010", 10000, "ExSummary", "Key10, Key11, Key12", "https://archiveofourown.org/"),
(NULL, "ExTitle11", "ExAuthor4", "11/11/2011", 11000, "ExSummary", "Key11, Key12, Key13", "https://archiveofourown.org/"),
(NULL, "ExTitle12", "ExAuthor4", "12/12/2012", 12000, "ExSummary", "Key12, Key13, Key14", "https://archiveofourown.org/");

CREATE TABLE PopSearches (
    SearchTerm varchar(255) NOT NULL,
    NumSearches int NOT NULL DEFAULT 0,
    PRIMARY KEY(SearchTerm)
);

INSERT INTO PopSearches VALUES
("Key3", 7),
("Key5", 6),
("Key7", 5);

CREATE TABLE Users (
    UserID int NOT NULL AUTO_INCREMENT,
    Username varchar(31) UNIQUE NOT NULL,
    Password varchar(31) NOT NULL,
    Admin boolean DEFAULT 0 NOT NULL,
    PRIMARY KEY(UserID)
);

INSERT INTO Users VALUES
(NULL, "Administrator", "12345", 1);
